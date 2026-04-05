# ecosysteme-site

Landing page + tunnel de vente ECOSYSTEMEIMMO avec capture de leads, CRM admin et séquence email automatisée (queue + tracking + conditions).

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

Le système envoie une séquence de 4 emails :

1. Email 1: accès vidéo
2. Email 2: rappel vidéo (uniquement si vidéo non vue)
3. Email 3: offre
4. Email 4: urgence/rareté (si offre vue mais sans RDV)

Condition d'arrêt: si le lead prend un RDV (`rdv_planifie`), la séquence est stoppée.

Technique incluse :
- Queue email persistée (`storage/email_queue.json`)
- Worker cron pour planifier + envoyer
- Tracking ouverture/clic via `/api/email-track.php`

Séquence (J0/J1/J3/J5):
1. Email 1 : accès vidéo
2. Email 2 : rappel vidéo (si vidéo non vue)
3. Email 3 : offre
4. Email 4 : urgence/rareté (si offre vue sans RDV)

1. Soit depuis l'admin (`Envoyer emails dus`).
2. Soit via cron API :

Technique:
- Cron job sur `/api/crm.php?action=send-sequence`
- File d'attente locale (`storage/email_queue.json`)
- Suivi ouverture/clic via pixel + liens trackés (`track-open`, `track-click`)

3. Soit via cron CLI :

```bash
php scripts/email_cron.php
```

Exemple cron (toutes les 15 min) :

```bash
*/15 * * * * php /chemin/vers/ecosysteme-site/scripts/email_cron.php >/dev/null 2>&1
```

## Accès admin

- URL : `/admin/`
- Mot de passe par défaut : `ecosystemeimmo2026`
- À personnaliser dans `public/admin/index.php`.

## Webhook Calendly

Un endpoint est disponible sur `POST /api/calendly.php` pour synchroniser les événements Calendly avec le statut des leads.

Configuration attendue côté Calendly :
- URL : `https://votre-domaine.com/api/calendly.php`
- Événements : `invitee.created`, `invitee.canceled`
- Header de signature : `Calendly-Webhook-Signature`

Variable d'environnement requise :
- `CALENDLY_WEBHOOK_SIGNING_KEY` (clé de signature du webhook Calendly)
