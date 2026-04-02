#!/usr/bin/env bash
set -Eeuo pipefail

##############################################
# Reinitialise un projet web avec structure  #
# moderne, GitHub comme source de vérité,    #
# et préparation au déploiement serveur.     #
##############################################

# =========================
# Configuration par défaut
# =========================
SITE_DIR="${SITE_DIR:-$HOME/site}"
REPO_URL="${REPO_URL:-https://github.com/olimcfly/ecosysteme-site.git}"
BRANCH="${BRANCH:-main}"
BACKUP_ROOT="${BACKUP_ROOT:-$HOME}"
BACKUP_PREFIX="site_backup_$(date +%Y%m%d)"
BACKUP_DIR="${BACKUP_ROOT}/${BACKUP_PREFIX}"
BACKUP_ARCHIVE="${BACKUP_ROOT}/${BACKUP_PREFIX}.tar.gz"
APACHE_VHOST_PATH="${APACHE_VHOST_PATH:-/etc/apache2/sites-available/ecosysteme.conf}"
SERVER_NAME="${SERVER_NAME:-ton-domaine.fr}"

DO_PUSH=0
FORCE_PUSH=0
DO_SERVER_SETUP=0
DO_CHECKS=1

usage() {
  cat <<USAGE
Usage: $(basename "$0") [options]

Options:
  --site-dir PATH        Répertoire du projet (défaut: $HOME/site)
  --repo-url URL         URL GitHub du dépôt (défaut: $REPO_URL)
  --branch NAME          Branche Git (défaut: main)
  --push                 Exécute git push après commit
  --force-push           Ajoute --force au push (dangereux: écrase l'historique distant)
  --server-setup         Applique la config permissions + vhost Apache localement
  --skip-checks          Ignore les vérifications finales (tree/curl/log)
  -h, --help             Affiche cette aide

Exemples:
  $(basename "$0") --push
  $(basename "$0") --push --force-push --server-setup
  SITE_DIR=/var/www/site $(basename "$0") --push
USAGE
}

log() { printf '\n[%s] %s\n' "$(date '+%Y-%m-%d %H:%M:%S')" "$*"; }
warn() { printf '\n[WARN] %s\n' "$*" >&2; }
fail() { printf '\n[ERROR] %s\n' "$*" >&2; exit 1; }

require_cmd() {
  command -v "$1" >/dev/null 2>&1 || fail "Commande requise introuvable: $1"
}

on_error() {
  local line="$1"
  warn "Échec à la ligne ${line}. Vérifiez les logs ci-dessus."
}
trap 'on_error $LINENO' ERR

parse_args() {
  while [[ $# -gt 0 ]]; do
    case "$1" in
      --site-dir) SITE_DIR="$2"; shift 2 ;;
      --repo-url) REPO_URL="$2"; shift 2 ;;
      --branch) BRANCH="$2"; shift 2 ;;
      --push) DO_PUSH=1; shift ;;
      --force-push) FORCE_PUSH=1; shift ;;
      --server-setup) DO_SERVER_SETUP=1; shift ;;
      --skip-checks) DO_CHECKS=0; shift ;;
      -h|--help) usage; exit 0 ;;
      *) fail "Option inconnue: $1" ;;
    esac
  done

  if [[ "$FORCE_PUSH" -eq 1 && "$DO_PUSH" -ne 1 ]]; then
    fail "--force-push nécessite --push"
  fi
}

preflight() {
  log "Vérification des commandes nécessaires"
  require_cmd git
  require_cmd mkdir
  require_cmd cp
  require_cmd rm
  require_cmd tar
  require_cmd find
  require_cmd chmod

  [[ -d "$SITE_DIR" ]] || fail "Le dossier SITE_DIR n'existe pas: $SITE_DIR"
}

backup_site() {
  log "1/8 Sauvegarde d'urgence"
  mkdir -p "$BACKUP_DIR"

  if [[ -n "$(find "$SITE_DIR" -mindepth 1 -maxdepth 1 -print -quit)" ]]; then
    cp -a "$SITE_DIR"/. "$BACKUP_DIR"/
  else
    warn "Le dossier $SITE_DIR est déjà vide; sauvegarde de contenu ignorée."
  fi

  tar -czf "$BACKUP_ARCHIVE" -C "$BACKUP_ROOT" "$BACKUP_PREFIX"
  rm -rf "$BACKUP_DIR"
  log "Archive créée: $BACKUP_ARCHIVE"
}

clean_site() {
  log "2/8 Nettoyage total du dossier local"
  find "$SITE_DIR" -mindepth 1 -maxdepth 1 -exec rm -rf {} +
}

init_git() {
  log "3/8 Initialisation du dépôt Git"
  cd "$SITE_DIR"
  git init

  if git remote get-url origin >/dev/null 2>&1; then
    git remote set-url origin "$REPO_URL"
  else
    git remote add origin "$REPO_URL"
  fi

  log "4/8 Récupération de la branche principale (si elle existe)"
  if git fetch origin "$BRANCH"; then
    git checkout -B "$BRANCH" "origin/$BRANCH"
  else
    warn "Branche distante introuvable. Création locale: $BRANCH"
    git checkout -B "$BRANCH"
  fi
}

create_structure() {
  log "5/8 Création de la structure moderne"
  mkdir -p \
    "$SITE_DIR/public" \
    "$SITE_DIR/src/assets/css" \
    "$SITE_DIR/src/assets/js" \
    "$SITE_DIR/src/assets/images" \
    "$SITE_DIR/src/includes" \
    "$SITE_DIR/src/config" \
    "$SITE_DIR/logs" \
    "$SITE_DIR/storage/cache" \
    "$SITE_DIR/storage/sessions" \
    "$SITE_DIR/storage/uploads" \
    "$SITE_DIR/vendor"

  touch "$SITE_DIR/public/index.php" \
        "$SITE_DIR/public/.htaccess" \
        "$SITE_DIR/public/robots.txt" \
        "$SITE_DIR/src/config/database.php" \
        "$SITE_DIR/src/config/app.php" \
        "$SITE_DIR/.env" \
        "$SITE_DIR/.gitignore" \
        "$SITE_DIR/README.md"

  cat > "$SITE_DIR/public/index.php" <<'PHP'
<?php
require __DIR__ . '/../src/config/app.php';

echo 'Hello, Codex! Nouvelle structure opérationnelle.';
PHP

  cat > "$SITE_DIR/.gitignore" <<'GITIGNORE'
# Ignorer les fichiers sensibles
.env
/storage/
/logs/
/vendor/
.DS_Store
*.log
GITIGNORE

  cat > "$SITE_DIR/README.md" <<'README'
# Ecosystème Site

Nouvelle structure moderne pour le projet.

## Installation
1. Cloner le dépôt
2. Configurer `.env`
3. Lancer `composer install` (si PHP)
README
}

commit_and_push() {
  log "6/8 Commit Git"
  cd "$SITE_DIR"
  git add .

  if git diff --cached --quiet; then
    warn "Aucun changement à committer."
    return
  fi

  git commit -m "feat: Nouvelle structure moderne avec séparation public/src"

  if [[ "$DO_PUSH" -eq 1 ]]; then
    log "7/8 Push vers GitHub"

    local push_args=(-u origin "$BRANCH")
    if [[ "$FORCE_PUSH" -eq 1 ]]; then
      warn "Force push activé: l'historique distant sera écrasé."
      push_args+=(--force)
    fi

    git push "${push_args[@]}"
  else
    warn "Push non exécuté. Ajoutez --push pour publier sur GitHub."
  fi
}

server_setup() {
  [[ "$DO_SERVER_SETUP" -eq 1 ]] || return 0

  log "8/8 Configuration serveur locale (permissions + vhost Apache)"
  cd "$SITE_DIR"

  find . -type d -exec chmod 755 {} \;
  find . -type f -exec chmod 644 {} \;
  chmod -R 775 storage
  chmod 640 .env

  cat > /tmp/ecosysteme.conf <<EOF_APACHE
<VirtualHost *:80>
    ServerName ${SERVER_NAME}
    DocumentRoot ${SITE_DIR}/public
    <Directory ${SITE_DIR}/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF_APACHE

  if command -v sudo >/dev/null 2>&1; then
    sudo tee "$APACHE_VHOST_PATH" < /tmp/ecosysteme.conf >/dev/null
    sudo a2ensite "$(basename "$APACHE_VHOST_PATH")"
    sudo systemctl restart apache2
  else
    warn "sudo indisponible. Copiez manuellement /tmp/ecosysteme.conf vers $APACHE_VHOST_PATH"
  fi
}

final_checks() {
  [[ "$DO_CHECKS" -eq 1 ]] || { warn "Vérifications finales ignorées (--skip-checks)."; return 0; }

  log "Vérifications finales"
  if command -v tree >/dev/null 2>&1; then
    tree -L 3 "$SITE_DIR"
  else
    warn "Commande tree absente; aperçu via find."
    find "$SITE_DIR" -maxdepth 3 -print
  fi

  if command -v curl >/dev/null 2>&1; then
    curl -I http://localhost || warn "curl localhost en échec (service web peut être arrêté)."
  fi

  local errlog="$SITE_DIR/logs/error.log"
  if [[ -f "$errlog" ]]; then
    tail -n 50 "$errlog"
  else
    warn "Log absent: $errlog (créez-le si nécessaire)."
  fi
}

main() {
  parse_args "$@"
  preflight
  backup_site
  clean_site
  init_git
  create_structure
  commit_and_push
  server_setup
  final_checks

  log "Terminé."
  warn "Pensez à adapter les chemins (ex: /home/sc1tasq5564/) et le nom de domaine."
}

main "$@"
