# ecosysteme-site

CRM simple ECOSYSTEMEIMMO en PHP + MySQL pour capturer et piloter les leads.

## Structure

- `public/index.php` : page de vente (copywriting + CTA).
- `public/api/contact.php` : capture des leads depuis le formulaire.
- `public/api/crm.php` : API CRM (liste, mise à jour, envoi des emails dus, tracking open/click).
- `public/admin/index.php` : interface admin CRM (séquences + stats).
- `lib/crm.php` : logique métier CRM (stockage JSON, file d'attente, scoring, automatisation).
- `storage/` : persistance locale des leads, queue et logs email.

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

Déclencheur: formulaire rempli (`/api/contact.php`).

Séquence (J0/J1/J3/J5):
1. Email 1 : accès vidéo
2. Email 2 : rappel vidéo (si vidéo non vue)
3. Email 3 : offre
4. Email 4 : urgence/rareté (si offre vue sans RDV)

Conditions:
- Si vidéo non vue → email de relance conservé.
- Si offre vue mais pas RDV → relance urgence.
- Si RDV pris → arrêt automatique de la séquence.

Technique:
- Cron job sur `/api/crm.php?action=send-sequence`
- File d'attente locale (`storage/email_queue.json`)
- Suivi ouverture/clic via pixel + liens trackés (`track-open`, `track-click`)

Exemple cron (toutes les 30 min):

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
