# ecosysteme-site

Script prêt à l'emploi pour repartir de zéro avec une structure web moderne et GitHub comme source de vérité.

## Script principal

- `scripts/reinit_site.sh`

### Exemples

```bash
# Dry run local (commit sans push)
./scripts/reinit_site.sh

# Commit + push standard
./scripts/reinit_site.sh --push

# Réinitialisation complète avec force push (danger)
./scripts/reinit_site.sh --push --force-push
```
