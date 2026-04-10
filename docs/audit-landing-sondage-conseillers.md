# Audit technique — Intégration d'une landing « Sondage stratégique »

_Date : 2026-04-10_

## 1) Architecture globale observée

## 1.1 Organisation du code
Le projet est **MVC-like**, mais majoritairement **procédural** :

- **Entrées HTTP / pages** : `public/pages/**` (chaque page est un script PHP autonome).
- **API** : `public/api/**` (endpoints JSON / tracking / CRM).
- **Composants de layout** : `public/includes/header.php`, `public/includes/footer.php`, `public/includes/tracking.php`.
- **Assets front** : `public/assets/css/style.css`, `public/assets/js/main.js`.
- **Logique métier CRM** : `lib/crm.php` (service principal, stockage JSON `storage/`).

👉 Il n'existe pas de couche « contrôleurs/models » au sens framework (Laravel/Symfony), mais une séparation par responsabilité de fichiers.

## 1.2 Flux tunnel actuel (résumé)

- Home redirige vers `/pages/capture/`.
- Capture -> formulaire (EPÉE) -> vidéo -> offre -> RDV -> ressources.
- Les leads sont captés via `/api/contact.php` et enrichis / scorés dans `lib/crm.php`.

Ce tunnel est déjà orienté conversion et qualification progressive.

---

## 2) Routing actuel et implications

## 2.1 Routage serveur
Le routing principal repose sur Apache (`.htaccess`) :

- `/` redirigé vers `/pages/capture/`.
- Réécriture des URLs sans extension vers `*.php`.
- Fallback 404 côté `.htaccess` racine vers `/pages/erreurs/404.php` (incohérent avec `public/pages/404.php`).
- `public/pages/.htaccess` redirige les URL invalides vers `/pages/404.php`.

⚠️ Incohérence à anticiper : selon le niveau Apache déclenché, la 404 peut pointer sur un chemin absent (`/pages/erreurs/404.php`).

## 2.2 Route idéale pour la landing sondage
Je recommande une URL lisible, stable SEO et explicite segment cible :

- **Route publique proposée** : `/pages/sondage-conseillers/` (URL canonique),
- avec alias marketing optionnel (plus tard) : `/sondage-conseillers-immobilier`.

Pourquoi ce choix :
- cohérent avec l'organisation actuelle (`/pages/<slug>/index.php`),
- faible risque de régression,
- aucune dépendance à un routeur applicatif central.

---

## 3) Layout / header / footer / UI existants

## 3.1 Layout partagé
Pour une intégration propre et homogène :

- inclure `public/config/config.php` puis `public/includes/header.php` en haut,
- inclure `public/includes/footer.php` en bas,
- définir `$pageTitle` avant le header.

Cela garantit : style global, nav, scripts communs, tracking GTM/GA et messages flash.

## 3.2 Conventions CSS/UI
Conventions déjà en place à respecter :

- Variables design system dans `:root` (`--primary-color`, `--secondary-color`, etc.).
- Utilitaires réutilisables : `.container`, `.section`, `.section-title`, `.btn`, `.btn-primary`, `.btn-secondary`, `.alert`.
- Pattern hero/cartes déjà présent (`.hero`, `.offre-card`, etc.).

👉 Recommandation : **ne pas créer un nouveau CSS global massif**. Préférer une section dédiée, ex. `.survey-landing`, et composants préfixés (`.survey-*`) pour éviter les collisions.

---

## 4) Où et comment intégrer la nouvelle landing (sans casser l'existant)

## 4.1 Arborescence cible recommandée

```text
public/
  pages/
    sondage-conseillers/
      index.php               # landing + intro sondage
      traitement-sondage.php  # (phase 2) traitement POST server-side
  api/
    sondage-strategique.php   # (phase 2) endpoint JSON si soumission AJAX
  assets/
    css/
      style.css               # ajouter un bloc scoped .survey-landing
    js/
      main.js                 # OU fichier dédié si logique importante
```

## 4.2 Stratégie d'intégration propre

### Option A (recommandée pour ce projet)
- **Page PHP dédiée** `public/pages/sondage-conseillers/index.php`.
- Réutiliser header/footer existants.
- Soumission vers endpoint dédié (`/api/sondage-strategique.php`) avec structure compatible CRM.

Avantages :
- respecte les conventions existantes,
- évite de toucher le tunnel principal capture/offre,
- rollback simple (supprimer dossier page + endpoint).

### Option B
- Ajouter le sondage à la page capture existante.

Inconvénients :
- fort risque de cannibalisation du tunnel actuel,
- mélange de deux intentions (vente vs étude stratégique),
- maintenance plus complexe.

---

## 5) Fichiers à créer / modifier (proposition concrète)

## 5.1 À créer (phase implémentation)
1. `public/pages/sondage-conseillers/index.php`
2. `public/api/sondage-strategique.php` (si mode AJAX)
3. (optionnel) `public/pages/sondage-conseillers/merci.php`

## 5.2 À modifier
1. `public/assets/css/style.css`
   - ajouter styles scoped `.survey-landing`, `.survey-step`, `.survey-progress`.
2. `public/assets/js/main.js` **ou** nouveau `public/assets/js/survey.js`
   - logique UX (étapes, validation douce, progression, tracking events).
3. `public/includes/header.php` (optionnel)
   - uniquement si besoin d'ajouter un lien de navigation vers la nouvelle page.
4. `lib/crm.php` (optionnel mais recommandé)
   - ajouter un helper de création lead/source dédiée `source = sondage_conseillers_2026` et stockage des réponses structurées en `meta`.

## 5.3 Composants réutilisables identifiés
- Layout global : `header.php` / `footer.php`.
- Boutons et containers : `.btn*`, `.container`, `.section`.
- Mécaniques tracking (visitor_id + events) déjà présentes dans `main.js` et `api/track.php`.
- Capture lead existante via `/api/contact.php` (réutilisable si le sondage se limite à nom/email/tel/ville).

---

## 6) Conventions à respecter

1. **Sécurité entrée/sortie**
   - `filter_input`, sanitation, validation email stricte.
   - échappement `htmlspecialchars` en sortie.
2. **Cohérence include**
   - `require_once '../../config/config.php';`
   - `require_once '../../includes/header.php';`
3. **Nommage**
   - slug URL en kebab-case,
   - classes CSS préfixées pour éviter effets de bord.
4. **Tracking/CRM**
   - tracer au minimum : vue landing, démarrage sondage, abandon étape, soumission complète.
   - envoyer `source` explicite pour segmentation CRM.

---

## 7) Risques avant implémentation

1. **Incohérence routing erreurs** (`/pages/erreurs/*` vs `/pages/404.php`) pouvant perturber debug et QA.
2. **API CRM ouvertes CORS `*`** : à surveiller si on ajoute un endpoint public de sondage.
3. **Risque de collision CSS** si styles non scopés (le `style.css` est global et volumineux).
4. **Risque business** : si CTA sondage placé au mauvais endroit, baisse du taux de conversion du tunnel principal.
5. **Donnée non structurée** : sans schéma clair des réponses (JSON), difficulté d'exploitation CRM/BI ensuite.

---

## 8) Plan d'implémentation recommandé (sans casser l'existant)

## Phase 0 — Préparation (rapide)
- Valider les champs exacts du sondage (business + CRM).
- Définir le mapping CRM (`source`, tags, score, priorité commerciale).

## Phase 1 — Landing seule (safe)
- Créer `/pages/sondage-conseillers/index.php` avec header/footer existants.
- Ajouter UI multi-étapes légère, mobile-first, sans toucher au tunnel capture.

## Phase 2 — Capture & qualification
- Créer endpoint dédié (`/api/sondage-strategique.php`) ou adapter `/api/contact.php` avec `source` dédiée + `meta`.
- Enregistrer les réponses structurées (JSON) pour exploitation future.

## Phase 3 — Tracking & pilotage
- Événements : `survey_view`, `survey_start`, `survey_step_completed`, `survey_submit`.
- Dashboard admin : filtre par source `sondage_conseillers_2026`.

## Phase 4 — Optimisation conversion
- Ajouter page de remerciement + next step (lead magnet / prise de RDV soft).
- A/B tests sur titre, longueur du sondage, ordre des questions.

---

## 9) Décision technique recommandée

✅ **Créer une page autonome** `public/pages/sondage-conseillers/index.php` + endpoint dédié, en réutilisant layout/components existants et en isolant le style via préfixe `.survey-*`.

C'est l'approche la plus propre, la moins risquée et la plus compatible avec l'architecture actuelle du projet.
