# ecosysteme-site

Landing page + tunnel de vente ECOSYSTEMEIMMO avec capture de leads, CRM admin et séquence email automatisée.

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

Chaque lead reçoit automatiquement une séquence de 4 emails (J0, J1, J3, J5), générée à la capture.

Pour déclencher les envois :

1. Soit depuis l'admin (`Envoyer emails dus`).
2. Soit via cron en appelant l'API:

```bash
curl -X POST "https://votre-domaine.fr/api/crm.php?action=send-sequence"
```

Exemple cron (toutes les 30 min) :

```bash
*/30 * * * * curl -s -X POST "https://votre-domaine.fr/api/crm.php?action=send-sequence" >/dev/null 2>&1
```

## Notes

Le projet utilise `mail()` PHP pour l'envoi. En production, remplacez par un SMTP transactionnel (Brevo, Mailgun, Sendgrid).
