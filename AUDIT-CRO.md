# Audit CRO — Écosystème Immo
> Mis à jour le 2026-07-29 | Audit initial : 2026-07-16 | Site : ecosystemeimmo.fr

---

## ÉTAT GÉNÉRAL

**0/15 actions de l'audit initial exécutées (au 25/07).**
Trois décisions structurelles bloquantes ont été tranchées dans le brief du 29/07 — elles sont maintenant résolues. Le plan ci-dessous est directement exécutable.

---

## DÉCISIONS TRANCHÉES (29/07 — brief confirmé)

| Question | Réponse définitive |
|----------|-------------------|
| Quel pricing ? | 97€/mois + 497€ setup (mensuel) · 897€/an setup offert (annuel) · 27€/mois + 197€ (estimateur) · 900€ (exclusivité verrouillée) |
| L'essai 30j gratuit est-il maintenu ? | **NON** — à retirer immédiatement |
| Exclusivité par ville ou zone 50 km ? | **Par ville** — "1 ville = 1 seul conseiller" |
| Villes fermées ? | Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion (+ Angers — Eric Verneau, à confirmer dans la scarcity bar) |

---

## PROBLÈMES PAR IMPACT BUSINESS

### CRITIQUE — Bloquent la conversion maintenant

| Ref | Problème | Pourquoi c'est bloquant |
|-----|----------|------------------------|
| C1 | Pricing en production (49€/mois, 0€ essai) ≠ pricing du brief | Crédibilité détruite, positionnement premium impossible |
| C2 | "Démarrer mes 30 jours gratuits" en CTA principal | Contredit l'exclusivité, dilue l'urgence, mauvais signal client |
| C3 | "Zone 50 km" vs "1 ville = 1 conseiller" | Différenciateur central absent — scarcité inactivée |
| C4 | Deux funnels concurrents (essai gratuit + vérification ville) | Le visiteur ne sait pas quoi faire |
| C5 | Programme Fondateur non valorisé (47€/mois, places épuisées) | Preuve sociale et scarcité perdues |

### FORT — Freinent la confiance et la qualité du lead

| Ref | Problème | Pourquoi c'est important |
|-----|----------|--------------------------|
| F1 | H1 trop long, trop passif — échoue le test des 3s mobile | Accroche manquée avant tout le reste |
| F2 | Barre de scarcité absente | L'urgence territoriale n'est jamais visible |
| F3 | Badges "Territoire complet" absents sur /realisations | Les villes fermées ne créent pas de pression |
| F4 | IA et automatisations absentes des features | La promesse produit est incomplète |
| F5 | Case studies sans résultats ni délais de livraison | "Preuve" sans preuve — = témoignage vide |
| F6 | Section "Comment ça marche" absente | Le visiteur n'a pas de plan d'action clair |

### MOYEN — Dégradent la perception premium

| Ref | Problème |
|-----|----------|
| M1 | Emojis partout (📉 🔗 🚫 🌐 📝 📍 ⭐ 📋 🎁 🔓 🔒) — augmentation entre juillet 16 et 25 |
| M2 | Navigation surchargée (Phenix, Site Estimateur ville, Solution financement, Diagnostic gratuit) |
| M3 | FAQ absente de la homepage |
| M4 | Footer avec 11+ liens en 2 colonnes mal organisées |
| M5 | "Système d'acquisition" jamais nommé — le site vend un "outil" |
| M6 | Titre page /offre : "moins cher qu'un abonnement SeLoger" — positionnement low-cost |

### FAIBLE — Finitions UX

| Ref | Problème |
|-----|----------|
| F7 | Lien "Réalisations" absent de la nav principale |
| F8 | Pas de note de réassurance sous le formulaire CTA |

---

## PLAN D'EXÉCUTION EN 3 PHASES

### PHASE 1 — Conversion immédiate (à faire en premier, impacte chaque session)

Ces 5 changements débloquent la conversion sans refonte. À faire dans cet ordre strict.

**1. Retirer "Démarrer mes 30 jours gratuits"**
Fichier : `src/components/Hero.astro`
Remplacer par le CTA unique : "Vérifier si ma ville est disponible"
Supprimer toute mention d'essai gratuit sur l'ensemble du site.

**2. Corriger le pricing sur toutes les pages**
Fichiers : `src/components/Pricing.astro`, `src/pages/offre.astro`
Pricing à afficher : voir section COPY-CHANGES.md — formules Estimateur / Mensuel / Annuel / Exclusivité verrouillée.
Supprimer les lignes 0€ et 49€/mois.

**3. Remplacer "Zone 50 km" par "1 ville = 1 conseiller"**
Fichiers : tout fichier contenant "zone" ou "50 km" — chercher et remplacer sur tout le projet.
Cette phrase doit apparaître dans le hero sous-titre ET dans la section pricing.

**4. Ajouter la barre de scarcité (sticky top)**
Fichier : `src/layouts/Layout.astro`
Code HTML prêt dans COPY-CHANGES.md — section SCARCITY BAR.
Villes : Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion (ajouter Angers si territoire confirmé fermé).

**5. Réécrire le H1**
Fichier : `src/components/Hero.astro`
Nouveau H1 : "Votre ville a une seule place disponible."
Nouveau sous-titre : voir COPY-CHANGES.md — section HERO.

---

### PHASE 2 — Confiance et preuve (dans la semaine)

**6. Ajouter badges "Territoire complet" sur /realisations**
Fichier : `src/components/Realisations.astro`, `src/pages/realisations.astro`
Badge rouge "#TERRITOIRE COMPLET" sur chaque carte client.
Intro à changer : "Ces territoires sont désormais fermés."

**7. Ajouter la section "Comment ça marche" (3 étapes)**
Fichier à créer : `src/components/HowItWorks.astro`
Insérer après le Hero dans `src/pages/index.astro`
Copy prête dans COPY-CHANGES.md.

**8. Ajouter IA/Automatisations dans les features**
Fichier : `src/components/Features.astro`
Ajouter comme feature 06 : "Automatisations et IA — rappels automatiques, relances intelligentes, scoring prospects."
Changer l'intro : "Un système d'acquisition local, pas un outil de plus."

**9. Supprimer les emojis — numéros 01-06**
Fichier : `src/components/Features.astro`
Remplacer 🌐 📍 ⭐ 📝 📋 ✉️ par les numéros 01 à 06.
Chercher et supprimer tous les autres emojis sur le site.

**10. Valoriser le Programme Fondateur (fermé)**
Fichier : `src/components/Pricing.astro`
Ajouter sous les formules : "Programme Fondateur — Places épuisées. Les 5 premiers conseillers ont rejoint à 47€/mois à vie. Ces places sont fermées."

---

### PHASE 3 — Finition UX et SEO (dans le mois)

**11. Ajouter FAQ homepage (3 questions)**
Fichier à créer : `src/components/FAQ.astro`
Insérer avant le CTA final dans `src/pages/index.astro`
Copy prête dans COPY-CHANGES.md.

**12. Simplifier la navigation**
Fichier : `src/components/Header.astro`
AVANT : Accueil | L'offre | Avantages | Réalisations | Blog | Diagnostic gratuit | Solution financement | Site Estimateur ville
APRÈS : Accueil | Comment ça marche | Offres | Réalisations | Blog
CTA nav : [Vérifier ma ville]
Supprimer : Phenix, Site Estimateur ville, Solution financement, Diagnostic gratuit (garder en footer secondaire)

**13. Changer le titre page /offre**
Fichier : `src/pages/offre.astro`
AVANT : "Votre base digitale locale, moins cher qu'un abonnement SeLoger"
APRÈS : "Un seul territoire. Un seul conseiller. Un système qui travaille pour vous."

**14. Ajouter case studies enrichis sur /realisations**
Fichier : `src/pages/realisations.astro`
Ajouter pour chaque client : délai de livraison, description de ce qui a été installé.
Copy disponible dans COPY-CHANGES.md.

**15. Simplifier le footer**
Fichier : `src/components/Footer.astro`
APRÈS : Écosystème Immo | Liens : Offres · Réalisations · Blog · Contact | Coordonnées | Mentions légales | CGU | © 2026

---

## LISTE COMPLÈTE DES FICHIERS À MODIFIER

| Fichier | Phase | Modifications |
|---------|-------|---------------|
| `src/layouts/Layout.astro` | 1 | Scarcity bar sticky top |
| `src/components/Hero.astro` | 1 | H1, sous-titre, CTA unique, supprimer essai gratuit |
| `src/components/Pricing.astro` | 1 + 2 | Pricing complet, Programme Fondateur fermé |
| `src/pages/offre.astro` | 1 + 3 | Pricing + titre page |
| `src/components/Features.astro` | 2 | Emojis → 01-06, ajouter IA, changer intro |
| `src/components/Realisations.astro` | 2 | Badges "Territoire complet" |
| `src/pages/realisations.astro` | 2 + 3 | Badges + case studies enrichis |
| `src/components/HowItWorks.astro` | 2 | **Créer** — section 3 étapes |
| `src/components/FAQ.astro` | 3 | **Créer** — 3 objections |
| `src/components/Header.astro` | 3 | Navigation simplifiée |
| `src/pages/index.astro` | 2 + 3 | Insérer HowItWorks et FAQ |
| `src/components/Footer.astro` | 3 | Simplifier |

Chercher/remplacer sur tout le projet :
- "zone" + "50 km" → "votre ville" / "votre territoire"
- "essai gratuit" / "30 jours" → supprimer
- Tous les emojis unicode → supprimer

---

## ORDRE PRÉCIS D'EXÉCUTION

```
Semaine 1 — Conversion immédiate :
  1 → Retirer essai gratuit + unifier CTA (Hero.astro)
  2 → Corriger pricing (Pricing.astro + offre.astro)
  3 → Remplacer "zone 50 km" → "1 ville = 1 conseiller" (site entier)
  4 → Ajouter scarcity bar (Layout.astro)
  5 → Réécrire H1 + sous-titre (Hero.astro)

Semaine 2 — Confiance :
  6 → Badges "Territoire complet" (Realisations.astro)
  7 → Créer HowItWorks.astro + insérer dans index.astro
  8 → Ajouter IA/automatisations dans Features.astro
  9 → Supprimer tous les emojis (Features.astro + site entier)
  10 → Programme Fondateur fermé (Pricing.astro)

Semaine 3-4 — Finition :
  11 → Créer FAQ.astro + insérer dans index.astro
  12 → Simplifier navigation (Header.astro)
  13 → Changer titre /offre
  14 → Case studies enrichis (realisations.astro)
  15 → Simplifier footer (Footer.astro)
```

---

## RÈGLES DE DESIGN À RESPECTER

- **Mobile-first** : H1 ≤ 6 mots lisibles sur 375px. CTA full-width sur mobile.
- **Zéro emoji** : numéros (01-06) ou icônes SVG outline simples.
- **Premium sobre** : pas d'effets, pas d'animations gadget, palette sombre/contrasté.
- **Scarcité réelle** : noms de villes vrais, pas de compteurs artificiels.
- **Un seul CTA** : "Vérifier si ma ville est disponible" — partout, tout le temps.
- **Ne pas nommer un "outil"** : toujours "système d'acquisition local".

---

## ÉTAT D'IMPLÉMENTATION

| # | Action | Phase | Statut |
|---|--------|-------|--------|
| 1 | Retirer essai gratuit, unifier CTA | 1 | Non fait |
| 2 | Corriger pricing | 1 | Non fait |
| 3 | Remplacer zone 50km | 1 | Non fait |
| 4 | Scarcity bar | 1 | Non fait |
| 5 | Réécrire H1 | 1 | Non fait |
| 6 | Badges "Territoire complet" | 2 | Non fait |
| 7 | Section "Comment ça marche" | 2 | Non fait |
| 8 | Ajouter IA/automatisations | 2 | Non fait |
| 9 | Supprimer emojis | 2 | Non fait |
| 10 | Programme Fondateur (fermé) | 2 | Non fait |
| 11 | FAQ homepage | 3 | Non fait |
| 12 | Simplifier navigation | 3 | Partiel (Réalisations retiré de nav) |
| 13 | Titre page /offre | 3 | Non fait |
| 14 | Case studies enrichis | 3 | Non fait |
| 15 | Simplifier footer | 3 | Non fait |

---

*Mis à jour le 2026-07-29 — Décisions structurelles tranchées. Plan opérationnel prêt.*
*Le code source à modifier se trouve dans le projet Astro source (non inclus dans ce dépôt).*
