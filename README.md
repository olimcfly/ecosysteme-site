# ecosysteme-site

CRM simple ECOSYSTEMEIMMO en PHP + MySQL pour capturer et piloter les leads.

## Fonctionnalités

- Stockage des leads dans MySQL (`contacts`).
- Organisation/tri par ville.
- Filtre par statut du tunnel.
- Recherche multi-champs (nom, email, téléphone, ville, source).
- Dashboard rapide (total, aujourd'hui, convertis).
- Sidebar avec : Dashboard, Contacts, Pipeline, Emails, Automations.

## Structure

- `public/admin/index.php` : interface CRM mobile friendly.
- `public/api/contact.php` : création de leads.
- `public/api/crm.php` : liste + filtres + mise à jour du statut tunnel.
- `lib/crm.php` : accès MySQL + logique CRM.

## Configuration MySQL

Variables d'environnement supportées :

- `DB_HOST` (défaut: `127.0.0.1`)
- `DB_PORT` (défaut: `3306`)
- `DB_NAME` (défaut: `ecosystemeimmo`)
- `DB_USER` (défaut: `root`)
- `DB_PASS` (défaut: vide)

> La table `contacts` est créée automatiquement au premier accès API/CRM.

## Schéma table `contacts`

- `id`
- `nom`
- `email`
- `telephone`
- `ville`
- `source`
- `statut_tunnel`
- `date_creation`

## Accès admin

- URL : `/admin/`
- Mot de passe par défaut : `ecosystemeimmo2026`
- À personnaliser dans `public/admin/index.php`.
