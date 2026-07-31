# Audit CRO — Écosystème Immo
> Mis à jour le 2026-07-31 | Audit initial : 2026-07-16 | Site : ecosystemeimmo.fr

---

## SITUATION AU 2026-07-31

Troisième audit live. Le site a changé depuis le 25 juillet — dans une **direction opposée au brief**.
0/15 actions exécutées. Nouveau H1, nouveau pricing, nouveau funnel — toujours dans le mauvais sens.

### Pricing en production au 31/07 (3ème version en 3 semaines)

| | Brief (16/07) | Live 25/07 | Live 31/07 |
|---|---|---|---|
| Entrée | 27€/mois + 197€ setup | 0€ (essai 30j) | 0€ (essai 7j) |
| Standard | 97€/mois + 497€ setup | 49€/mois | **197€/mois + 997€ setup** |
| Supérieur | 897€/an setup offert | 149€/mois exclusivité | **397€/mois + 1 497€ setup** |
| Exclusivité | 900€ paiement unique | Incluse | Incluse dans 397€ |

Le prix a été **multiplié par 2 à 4** par rapport au brief. Si c'est intentionnel (montée en gamme),
l'ensemble du positionnement, du ciblage et de la page offre doit être repensé en conséquence.
Si c'est une erreur, corriger immédiatement — ces prix tuent la conversion sur un marché B2B immobilier
où les conseillers indépendants ont des revenus variables.

### H1 au 31/07

> "Écosystème Immo n'est pas un simple logiciel. C'est votre système métier immobilier, clé en main."

Problèmes :
- Commence par le nom de marque → centré sur le produit, pas sur le client
- "n'est pas un simple logiciel" = defense posture, pas une promesse
- "clé en main" = vague, utilisé par tout le secteur

H1 cible (toujours valide) : "Votre ville a une seule place disponible."

### Programme Fondateur — contradiction majeure

Brief : "Beta fondateur fermé — 47€/mois à vie, places épuisées"
Live 31/07 : "Devenir partenaire fondateur — 197€/mois + 997€ setup, limité à 10 conseillers"

C'est l'inverse. Soit le programme est fermé (le brief), soit il est ouvert à 197€/mois (le live).
Ces deux réalités ne peuvent pas coexister. Décision requise.

### Nouvelle découverte : disclaimer de non-résultat sur /offre `CRITIQUE`

Sur la page /offre, en production : **"nous ne promettons ni délai ni volume de mandats"**

Cette phrase doit disparaître. En B2B SaaS, un disclaimer de non-résultat sur la page de vente
élimine la confiance que tout le reste du site cherche à construire. Remplacer par des résultats
observés avec délai de réalisme : "Premiers contacts sous 60 à 90 jours selon votre marché."

### Navigation au 31/07 — toujours ingérable

15+ liens visibles : Accueil · Offre · Avantages · Blog · Partenaires · Financement ·
Guides gratuits · Programme Fondateurs · Autres métiers · Vérifier votre zone · Pourquoi ·
Ventes immobilières · À propos · Actualités · Contact

Cible : 5 liens max + 1 CTA bouton.

### CTAs concurrents toujours actifs

- "Tester gratuitement pendant 7 jours"
- "Mon territoire est-il encore libre ?"
- "Devenir partenaire fondateur"
- "Vérifier la disponibilité de mon territoire"
- "Vérifier si ma zone est disponible"

5 CTAs actifs. L'essai gratuit 7 jours dilue l'urgence territoriale.

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

## ÉTAT D'IMPLÉMENTATION — SUIVI CUMULÉ

| # | Action | Statut au 31/07 | Notes |
|---|--------|-----------------|-------|
| 1 | Corriger le pricing | Non fait | 3ème version de prix, toujours incohérente avec le brief |
| 2 | Barre scarcité villes fermées | Non fait | Aucun élément de scarcité territoriale visible |
| 3 | Badges "Territoire complet" réalisations | Non fait | /realisations : 6 clients sans badge ni statut |
| 4 | Réécrire H1 | Non fait | Nouveau H1 pire que le précédent — centré marque, pas client |
| 5 | Unifier CTA principal | Non fait | 5 CTAs actifs, dont 3 directions contradictoires |
| 6 | Ajouter IA/automatisations features | Non fait | Section features : emojis toujours présents |
| 7 | Simplifier CTAs | Non fait | Empiré (essai 7j + 4 autres CTAs) |
| 8 | Case studies avec résultats | Non fait | Nom + ville + "Voir le site →" uniquement |
| 9 | Section "Comment ça marche" | Non fait | Absente |
| 10 | FAQ homepage | Non fait | Absente |
| 11 | Programme Fondateur — statut cohérent | Non fait | Brief : fermé. Live : ouvert à 197€. Contradiction. |
| 12 | Retirer emojis | Non fait | 📉 🔗 🚫 🌐 📝 📍 ⭐ 📋 🎁 🔓 🔒 🚀 toujours présents |
| 13 | Modifier titre page /offre | Non fait | H1 identique à la homepage |
| 14 | Nettoyer navigation | Non fait | 15 liens en nav (était partiellement fait au 25/07, empiré au 31/07) |
| 15 | Simplifier footer | Non fait | Non audité au 31/07 |
| 16 | *(nouveau)* Retirer disclaimer non-résultat /offre | Non fait | "nous ne promettons ni délai ni volume" = tueur de conversion |
| 17 | *(nouveau)* Ajouter Angers dans la scarcity bar | Non fait | Eric Verneau affiché sur /realisations, non listé dans les villes fermées |

---

## DÉCISIONS REQUISES AVANT IMPLÉMENTATION (ordre de priorité)

Ces décisions doivent être tranchées par Olivier Colas. Sans elles, aucun développeur ne peut
implémenter correctement.

**Décision 1 — PRICING (bloquant tout le reste)**
- Brief : 97€/mois + 497€ setup / 897€/an
- Live actuel : 197€/mois + 997€ setup / 397€/mois + 1 497€ setup
- Question : La montée en gamme est-elle intentionnelle ? Si oui, l'ensemble du positionnement change.

**Décision 2 — PROGRAMME FONDATEUR**
- Brief : fermé, 47€/mois à vie, places épuisées
- Live actuel : ouvert, 197€/mois, 10 places max
- Question : Quel est le statut réel ?

**Décision 3 — TRIAL GRATUIT**
- Un essai gratuit et une exclusivité territoriale sont des messages contradictoires.
- Choisir : SaaS avec trial, ou système d'acquisition premium sans trial.

**Décision 4 — "VILLE" ou "ZONE"**
- "1 ville = 1 conseiller" : précis, scarcité immédiate, vérifiable
- "Zone 50 km" / "territoire" flou : géographique vague, urgence faible
- Recommandation : "1 ville = 1 conseiller"

---

*Audit mis à jour le 2026-07-31*
*0/15 actions de l'audit initial exécutées après 15 jours. 2 nouveaux problèmes détectés. 17 actions totales en attente.*
