# Audit CRO — Écosystème Immo
> Mis à jour le 2026-07-25 | Audit initial : 2026-07-16 | Site : ecosystemeimmo.fr

---

## SITUATION AU 2026-07-25

L'audit du 16 juillet listait 15 changements à apporter en 3 phases.
**Aucun n'a été implémenté.**

Pire : le site a évolué dans une direction qui crée de **nouveaux problèmes critiques** — notamment une rupture complète entre le brief business et ce qui est en production.

---

## ÉCARTS CRITIQUES DÉTECTÉS (nouveaux, vs audit initial)

### EC1 — Pricing en production ≠ pricing du brief `BLOQUANT`

| | Brief fourni | Site en production (25/07) |
|---|---|---|
| Entrée | 27€/mois + 197€ setup | 0€/mois (essai 30j) |
| Standard | 97€/mois + 497€ setup | 49€/mois (engagement 12 mois) |
| Annuel | 897€/an, setup offert | 149€/mois exclusivité (12 mois) |
| Exclusivité | 900€ paiement unique | Incluse dans 149€/mois |
| Setup | 497€ (mensuel) | Non mentionné |

Ce n'est pas un problème de copy. C'est une incohérence de modèle économique.
Avant d'implémenter quoi que ce soit, décider : quel pricing est le bon ?

---

### EC2 — "Zone 50 km" vs "1 ville = 1 conseiller" `CRITIQUE`

Le site en production parle de "zone de 50 km". Le brief parle de "1 ville = 1 seul conseiller".
- "Zone 50 km" = géographiquement flou, difficile à vendre, urgence faible
- "1 ville = 1 conseiller" = précis, exclusivité visible, scarcité immédiate

Le différenciateur central n'est pas activé dans la version actuelle.

---

### EC3 — Deux funnels de conversion en compétition `CRITIQUE`

Le site propose simultanément :
- CTA A : "Démarrer mes 30 jours gratuits" → funnel d'essai gratuit
- CTA B : "Ma zone est-elle encore libre ?" / "Vérifier ma zone" → funnel de qualification

Ces deux approches sont contradictoires. L'essai gratuit dilue l'urgence territoriale.
Question à trancher : produit SaaS avec trial, ou système d'acquisition avec exclusivité ?

---

### EC4 — 6ème client non documenté dans le brief `MOYEN`

La page /realisations affiche Eric Verneau (Angers) — absent de la liste des villes fermées
(Bordeaux, Nantes, Nandy, Aix, Lannion). Angers doit apparaître dans la scarcity bar
si le territoire est fermé.

---

## CE QUI N'A PAS CHANGÉ (15 problèmes de l'audit initial toujours présents)

| Ref | Problème | Priorité |
|-----|----------|----------|
| C2 | Exclusivité présentée comme détail, pas comme pilier | CRITIQUE |
| C3 | Pas de badges "Territoire complet" sur les réalisations | CRITIQUE |
| C4 | IA et automatisations absentes du site | FORT |
| F1 | H1 faible et trop long | FORT |
| F2 | Case studies sans chiffres de résultats | FORT |
| F3 | CTAs concurrents sans hiérarchie claire | FORT |
| F4 | Pas de barre de scarcité territoriale | FORT |
| F6 | Programme Fondateur non valorisé | FORT |
| F7 | Pas de section "Comment ça marche" | FORT |
| M1 | Emojis partout : 📉 🔗 🚫 🌐 📝 📍 ⭐ 📋 🎁 🔓 🔒 | MOYEN |
| M3 | FAQ absente de la homepage | MOYEN |
| M5 | "Système d'acquisition" jamais nommé | MOYEN |

---

## DÉCISIONS À PRENDRE EN PRIORITÉ (avant toute implémentation)

1. Quel est le pricing définitif ?
   Brief : 97€/mois + setup. Live : 49€/mois sans setup. Ces deux modèles
   ont des implications complètement différentes sur la page d'offre et la crédibilité.

2. L'essai gratuit 30j est-il maintenu ?
   Si oui : repenser le funnel autour du trial (onboarding, email, qualification).
   Si non : retirer immédiatement — il affaiblit la scarcité et le positionnement premium.

3. Exclusivité par ville ou par zone de 50 km ?
   "1 ville = 1 conseiller" est laser et différenciant.
   "Zone 50 km" est flou et difficile à vendre.

---

## PLAN D'ACTION (si retour au brief : pricing 97€/897€, exclusivité par ville)

Ordre d'exécution :
1. Corriger le pricing sur toutes les pages (homepage, /offre, /realisations, /avantages)
2. Retirer "Démarrer gratuitement" — remplacer par "Vérifier si ma ville est disponible"
3. Ajouter la barre de scarcité (Bordeaux, Nantes, Nandy, Aix, Lannion, Angers)
4. Réécrire le H1 : "Votre ville a une seule place disponible."
5. Ajouter badges "Territoire complet" sur /realisations
6. Ajouter section "Comment ça marche" (3 étapes)
7. Ajouter FAQ homepage (3 objections)
8. Supprimer emojis — numéros ou icônes SVG outline
9. Simplifier navigation : ajouter Réalisations, retirer /avantages en lien nav

Voir COPY-CHANGES.md pour tous les textes prêts à intégrer.

---

## LISTE DES FICHIERS À MODIFIER

| Fichier | Modifications requises |
|---------|----------------------|
| `src/layouts/Layout.astro` | Barre de scarcité (sticky top) |
| `src/components/Header.astro` | Navigation simplifiée, CTA unique |
| `src/components/Hero.astro` | H1, sous-titre, CTA unifié |
| `src/components/Features.astro` | Emojis → numéros, ajouter IA/automatisations |
| `src/components/Pricing.astro` | Pricing complet à corriger |
| `src/components/Realisations.astro` | Badges "Territoire complet", résultats |
| `src/components/HowItWorks.astro` | Créer — section 3 étapes |
| `src/components/FAQ.astro` | Créer — 3 objections |
| `src/pages/offre.astro` | Pricing + titre page |
| `src/pages/realisations.astro` | Badges + case studies |
| `src/components/Footer.astro` | Simplifier |

Note : le code source n'est pas dans ce dépôt. Ces fichiers sont à modifier dans le projet source.

---

## ÉTAT D'IMPLÉMENTATION DE L'AUDIT INITIAL (16/07)

| # | Action | Statut |
|---|--------|--------|
| 1 | Corriger le pricing | Non fait (prix différents du brief ET différents de l'audit) |
| 2 | Barre scarcité villes fermées | Non fait |
| 3 | Badges "Territoire complet" réalisations | Non fait |
| 4 | Réécrire H1 | Non fait (nouveau H1 mais toujours trop long et passif) |
| 5 | Supprimer CTA prix incohérent | Non fait (nouveau prix, nouvelle incohérence) |
| 6 | Ajouter IA/automatisations features | Non fait |
| 7 | Simplifier CTAs | Non fait (2 funnels contradictoires désormais) |
| 8 | Case studies avec résultats | Non fait |
| 9 | Section "Comment ça marche" | Non fait |
| 10 | FAQ homepage | Non fait |
| 11 | Programme Fondateur fermé | Non fait |
| 12 | Retirer emojis | Non fait (davantage d'emojis qu'avant) |
| 13 | Modifier titre page /offre | Non fait |
| 14 | Nettoyer navigation | Partiellement (Réalisations n'apparaît plus dans la nav principale) |
| 15 | Simplifier footer | Non fait |

---

*Audit mis à jour le 2026-07-25*
*0/15 actions de l'audit initial exécutées. 4 nouveaux problèmes critiques détectés.*
