# ecosysteme-site

Landing page + tunnel de vente ECOSYSTEMEIMMO avec capture de leads, CRM admin et séquence email automatisée.

## Structure

- `public/index.php` : page de vente (copywriting + CTA).
- `public/api/contact.php` : capture des leads depuis le formulaire.
- `public/api/crm.php` : API CRM (liste, mise à jour, envoi des emails dus, tracking open/click).
- `public/admin/index.php` : interface admin CRM (séquences + stats).
- `lib/crm.php` : logique métier CRM (stockage JSON, file d'attente, scoring, automatisation).
- `storage/` : persistance locale des leads, queue et logs email.

## Accès admin

- URL : `/admin/`
- Mot de passe par défaut : `ecosystemeimmo2026`
- À personnaliser dans `public/admin/index.php`.

## Automatisation email

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

```bash
*/30 * * * * curl -s -X POST "https://votre-domaine.fr/api/crm.php?action=send-sequence" >/dev/null 2>&1
```

## Notes

Le projet utilise `mail()` PHP pour l'envoi. En production, remplacez par un SMTP transactionnel (Brevo, Mailgun, Sendgrid).
