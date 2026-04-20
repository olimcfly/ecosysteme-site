# Audit global du dépôt `ecosysteme-site`

_Date de l'audit : 2026-04-05_

## 1) Structure

### ✅ Points cohérents
- L'organisation MVC-like est globalement présente côté `public/` :
  - pages dans `public/pages/`
  - composants partagés dans `public/includes/`
  - endpoints API séparés dans `public/api/`.
- Les pages métiers utilisent majoritairement `require_once` pour charger la config et les includes critiques.

### ⚠️ Écarts / incohérences
- Le routeur `.htaccess` pointe vers des pages d'erreur dans `/pages/erreurs/...`, mais le dépôt versionne surtout `/public/pages/403.php` et `/public/pages/404.php` (sans sous-dossier `erreurs`).
- Plusieurs scripts référencent des fichiers de configuration non versionnés (`../../config/config.php`, `../config/database.php`). C'est normal pour des secrets, mais il manque un `config.example.php` ou une documentation de bootstrap solide.

### Fichiers sensibles / redondants observés
- `.gitignore` ignore déjà des fichiers sensibles attendus : `.env`, `/storage/`, `/public/config/config.php`.
- **Fichier sensible versionné** : `public/sql/schemadb.sql` contient des données de production (emails, historique RDV) et un mot de passe admin en clair (`'652100'`).
- **Fichiers de logs versionnés** : `public/logs/error_log` et `public/pages/error_log` exposent des chemins systèmes, messages d'erreurs PHP, et des indices de configuration.

## 2) Sécurité

### Vulnérabilités potentielles

#### A. AuthZ/AuthN insuffisante sur certaines APIs
- `public/api/rdv.php` :
  - connexion DB en dur dans le fichier
  - endpoints GET (types/slots/appointments) exploitables avec `user_id` sans contrôle d'accès robuste
  - absence de `session_start()` alors que `$_SESSION` est utilisé.
- `public/api/crm.php` :
  - l'action `list` retourne leads/stats/queue sans authentification explicite.

#### B. CSRF
- Protection CSRF correctement implémentée sur certains formulaires (`epee`, `ressources`).
- Mais pas de protection CSRF explicite sur d'autres mutations (ex: `public/pages/offre/traitement-offre.php`, endpoints API JSON ouverts avec CORS `*`).

#### C. XSS
- Dans `public/includes/header.php`, les messages `$_SESSION['error']` / `$_SESSION['success']` sont affichés directement sans échappement HTML.

#### D. Fuite d'informations
- Les logs versionnés exposent stack traces, chemins absolus et infos de connexion ratée DB.
- Le dump SQL versionné expose des données personnelles et une valeur de mot de passe en clair.

#### E. Uploads de fichiers
- Aucun endpoint d'upload de fichier via `$_FILES` / `move_uploaded_file()` n'a été identifié dans les fichiers audités (risque faible sur ce point actuellement).

### Vérification `.htaccess`
- Le `.htaccess` racine bloque les extensions sensibles (dont `.sql`, `.log`, `.env`, `config.php`) et désactive l'indexation.
- `public/config/.htaccess` bloque bien tout accès (`Deny from all`) + désactive l'exécution PHP.
- Limite : les règles reposent sur Apache et peuvent être inopérantes selon l'hébergement (Nginx/LiteSpeed mal configuré).

### Secrets en dur
- Mot de passe DB placeholder en dur dans `public/api/rdv.php`.
- Mot de passe admin **en clair** dans `public/sql/schemadb.sql` (jeu de données inséré).
- La partie admin principale lit bien `ADMIN_EMAIL` et `ADMIN_PASSWORD` depuis l'environnement (bon point), avec `password_verify`.

## 3) Bonnes pratiques

### `require_once` vs `include`
- Bon usage de `require_once` sur les fichiers critiques (config, auth, librairies CRM).
- `include`/`include_once` est utilisé sur des fragments de vue (404/403, partials admin) : acceptable pour du templating, à condition de ne pas y mettre de logique critique.

### Variables globales / entrées utilisateur
- Bonnes pratiques observées : usage fréquent de `filter_input`, casts explicites, `PDO::prepare`.
- Points à renforcer :
  - accès direct `$_POST['password']` dans `public/admin/auth.php` (faible risque mais uniformiser via `filter_input` + validation stricte est préférable)
  - `$_SESSION` non échappé à l'affichage (`header.php`), donc surface XSS stockée/réfléchie via flash messages.

### Logging des erreurs (`error_log`)

#### Constat
- Le projet appelle `error_log()` à plusieurs endroits (bon réflexe), mais des logs applicatifs se retrouvent versionnés dans Git.

#### Recommandations concrètes
1. Exclure durablement les logs du dépôt (`public/logs/error_log`, `public/pages/error_log`) et ne garder qu'un `.gitkeep`.
2. Mettre en place un logger central (Monolog) avec :
   - niveau (`info`, `warning`, `error`)
   - format JSON
   - rotation des fichiers.
3. Activer un `APP_ENV` (`dev|prod`) :
   - `dev` : traces détaillées
   - `prod` : messages neutres côté client + détails uniquement en logs serveur.
4. Ajouter un identifiant de corrélation (`request_id`) par requête pour faciliter le debug transversal API/front.
5. Ne jamais logger de secrets (passwords, tokens, payloads bruts sensibles).

## Priorités recommandées (ordre d'impact)
1. **Retirer immédiatement les données sensibles versionnées** (`schemadb.sql`, logs).  
2. **Protéger l'accès aux APIs CRM/RDV** (auth obligatoire + contrôle d'autorisation).  
3. **Corriger les sorties non échappées dans le header** (XSS).  
4. **Harmoniser CSRF + CORS** selon contexte (navigateur vs webhooks serveur).  
5. **Créer un bootstrap de config documenté** (`config.example.php` / `.env.example`) pour éviter les inclusions cassées.
