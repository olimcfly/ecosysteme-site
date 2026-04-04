# ecosysteme-site

Landing page + tunnel de vente ECOSYSTEMEIMMO avec capture de leads, CRM admin et séquence email automatisée (queue + tracking + conditions).

## Structure

- `public/index.php` : page de vente (copywriting + CTA).
- `public/api/contact.php` : capture des leads depuis le formulaire.
- `public/api/crm.php` : API CRM (liste, mise à jour, envoi des emails dus).
- `public/admin/index.php` : interface admin CRM.
- `lib/crm.php` : logique métier CRM (stockage JSON, scoring, séquences email).
- `storage/` : persistance locale des leads et logs email.

## Accès admin

- URL : `/admin/`
- Mot de passe par défaut : `ecosystemeimmo2026`
- À personnaliser dans `public/admin/index.php`.

## Automatisation email

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

Pour déclencher les envois :

1. Soit depuis l'admin (`Envoyer emails dus`).
2. Soit via cron API :

```bash
curl -X POST "https://votre-domaine.fr/api/crm.php?action=send-sequence"
```

3. Soit via cron CLI :

```bash
php scripts/email_cron.php
```

Exemple cron (toutes les 15 min) :

```bash
*/15 * * * * php /chemin/vers/ecosysteme-site/scripts/email_cron.php >/dev/null 2>&1
```

## Notes

Le projet utilise `mail()` PHP pour l'envoi. En production, remplacez par un SMTP transactionnel (Brevo, Mailgun, Sendgrid).
