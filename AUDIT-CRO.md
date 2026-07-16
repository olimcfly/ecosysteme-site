# Audit CRO — Écosystème Immo
> Généré le 2026-07-16 | Site audité : ecosystemeimmo.fr

---

## RÉSUMÉ EXÉCUTIF

Le site est propre et lisible, mais il convertit mal sur 3 raisons fondamentales :

1. **Le pricing affiché (149€–399€) ne correspond pas au pricing réel** — écart critique de crédibilité
2. **L'exclusivité territoriale n'est pas le pilier central** — elle est mentionnée en note de bas de section
3. **Zéro preuve de résultats** — les réalisations montrent "bases mises en place", pas de leads, pas de mandats, pas de chiffres

Le site vend un outil. Il doit vendre un territoire.

---

## PROBLÈMES CLASSÉS PAR IMPACT

### CRITIQUE

| # | Problème | Impact | Localisation |
|---|----------|--------|-------------|
| C1 | Pricing affiché (149/249/399€) ≠ pricing réel (97/897€) | Visiteurs qualifiés perdus au moment de la décision | `/offre`, homepage section pricing |
| C2 | Exclusivité présentée comme détail, pas comme proposition centrale | Différenciateur clé invisible — le concurrent "classique" n'a pas cet angle | Hero, pricing, titre principal |
| C3 | Villes fermées (Bordeaux, Nantes, Nandy, Aix, Lannion) affichées sans badge "COMPLET" | Scarcité non activée — aucune urgence créée | Section réalisations |
| C4 | L'IA et les automatisations ne figurent pas sur le site | L'offre réelle > l'offre perçue. Valeur cachée. | Features section, pricing |

### FORT

| # | Problème | Impact |
|---|----------|--------|
| F1 | Hero H1 faible ("Construisez votre visibilité locale...") — passif, générique | Accroche < 3s ratée sur mobile |
| F2 | Aucun chiffre dans les preuves sociales ("base mise en place" ≠ résultat) | La preuve sociale est une image, pas une preuve |
| F3 | 3 CTAs concurrents sans hiérarchie claire | Friction décisionnelle = abandon |
| F4 | Pas de barre de scarcité en haut de page | L'urgence n'est jamais déclenchée |
| F5 | Le texte hero mentionne "149€/mois" dans le CTA secondaire (prix incohérent) | Contradiction visible dès la homepage |
| F6 | Programme fondateur (beta 47€/mois) non positionné ni clarifié | Segment le plus chaud ignoré |
| F7 | Pas de section "Comment ça marche" claire en 3 étapes | Le chemin d'achat est flou |

### MOYEN

| # | Problème | Impact |
|---|----------|--------|
| M1 | 6 emojis dans la section features | Ton gadget, pas premium |
| M2 | Title de la page pricing ("moins cher qu'un abonnement SeLoger") positionne l'offre comme low cost | Positionnement contradictoire avec la promesse premium |
| M3 | FAQ enterrée sur la page /offre — pas sur la homepage | Objections non traitées sur la landing principale |
| M4 | Footer surchargé (11 liens découvrir + action) | Dispersion vs. focus |
| M5 | La notion de "système d'acquisition" n'est pas nommée explicitement | Le vocabulaire ne différencie pas assez |
| M6 | La navigation propose "Site Estimateur ville" et "Phenix" sans contexte | Liens orphelins qui créent de la confusion |

### FAIBLE

| # | Problème | Impact |
|---|----------|--------|
| Fa1 | Meta descriptions non vérifiables (pas d'accès aux sources) | SEO limité |
| Fa2 | Pas de schema markup LocalBusiness visible | Rich snippets manquants |

---

## PLAN D'EXÉCUTION EN 3 PHASES

---

## PHASE 1 — Conversion immédiate (Semaine 1, ~2h de dev)

### 1.1 — Corriger le pricing (C1) `CRITIQUE`

**Fichier probable :** `src/pages/offre.astro` ou `src/components/Pricing.astro`

**Pricing à afficher :**

```
ESTIMATEUR SEUL
27€/mois + 197€ setup unique
→ Idéal pour démarrer sans engagement fort

MENSUEL (STANDARD)
97€/mois + 497€ setup
Engagement 3 mois prépayés
→ Visibilité locale complète, sans blocage annuel

ANNUEL (MEILLEUR RAPPORT)
897€/an — setup offert — exclusivité incluse
≈ 74€/mois — économisez 267€ vs mensuel
→ Pour sécuriser son territoire durablement

EXCLUSIVITÉ VERROUILLÉE
900€ paiement unique
→ Verrou territorial à vie sur votre ville
```

**Supprimer :** les 3 tiers actuels (Essentiel 149€ / Visibilité 249€ / Territoire 399€)

**Note :** Le programme Fondateur (47€/mois à vie) est fermé. Le mentionner comme "Places épuisées — programme fermé" ajoute de la preuve sociale et de la scarcité.

---

### 1.2 — Ajouter une barre de scarcité en haut de page (C3, F4) `CRITIQUE`

**Fichier probable :** `src/layouts/Layout.astro` ou `src/components/Header.astro`

**Contenu exact à ajouter** (barre fixe top, fond sombre, texte blanc) :

```html
<div class="scarcity-bar">
  Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion — Territoire complet.
  <a href="#verifier">Vérifiez votre ville →</a>
</div>
```

**Style :** fond `#1a1a2e` (bleu-nuit), texte `#ffffff`, taille 13px, padding 10px, sticky top.

---

### 1.3 — Réécrire le H1 Hero (F1) `FORT`

**Fichier probable :** `src/components/Hero.astro` ou `src/pages/index.astro`

**Avant :**
> "Construisez votre visibilité locale avant que votre concurrent le fasse."

**Après :**
> "Votre ville a une seule place disponible."

**Sous-titre avant :**
> "Écosystème Immo installe votre base digitale locale : site professionnel, SEO, Google Business Profile, pages quartiers et suivi prospects. Un système complet pour devenir visible dans votre ville."

**Sous-titre après :**
> "Écosystème Immo installe votre système d'acquisition local — site, SEO, Google Business, pages quartiers, CRM et automatisations IA — sur un territoire exclusif. Un seul conseiller par ville."

**CTA principal :** "Vérifier si ma ville est disponible" (inchangé, bon)

**Supprimer le CTA secondaire :** "Voir les offres à partir de 149 €/mois" → remplacer par : "Voir comment ça marche" (ancre vers section process)

---

### 1.4 — Badges "COMPLET" sur les réalisations (C3) `CRITIQUE`

**Fichier probable :** `src/components/Realisations.astro` ou `src/pages/realisations.astro`

Sur chaque carte des villes fermées, ajouter un badge rouge :

```html
<!-- Badge à ajouter sur Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion -->
<span class="badge-complet">Territoire complet</span>
```

**Style :** fond `#dc2626`, texte blanc, `border-radius: 4px`, position absolute top-right de la carte.

Ces villes **ne doivent plus avoir de CTA** "Vérifier ma ville". À la place : texte gris "Ce territoire est fermé."

---

### 1.5 — Simplifier la hiérarchie des CTAs (F3) `FORT`

**Règle :** 1 CTA primaire par section. Le CTA primaire est toujours "Vérifier si ma ville est disponible".

**Homepage :**
- Hero : CTA primaire = "Vérifier si ma ville est disponible" / CTA secondaire = "Comment ça marche" (ancre)
- Section features : pas de CTA (section informationnelle)
- Section pricing : CTA unique par formule → "Choisir cette formule — [nom]"
- Section réalisations : CTA = "Vérifier ma ville"
- Section finale : CTA primaire = "Vérifier si ma ville est disponible"

**Supprimer "Diagnostic gratuit" comme CTA concurrent** → le déplacer uniquement dans la nav et dans la section finale comme option secondaire.

---

### 1.6 — Ajouter IA + Automatisations dans les features (C4) `CRITIQUE`

**Fichier probable :** `src/components/Features.astro`

**Après "Relances email", ajouter :**

```
Automatisations et IA
Rappels automatiques, relances intelligentes et scoring des prospects.
Le système travaille quand vous prospectez.
```

**Modifier l'intro de la section :**

**Avant :** "Pas un outil de plus. Un système connecté : visibilité, contenus, prospects et relances dans une base simple et exploitable."

**Après :** "Pas un outil de plus. Un système d'acquisition local : visibilité locale, contenus SEO, capture vendeurs, suivi CRM et automatisations IA — activé sur votre territoire."

---

## PHASE 2 — Confiance et preuve (Semaine 2–3, ~4h de dev + contenu)

### 2.1 — Réécrire les case studies avec résultats (F2)

**Avant :** "Site local, pages secteurs, estimateur, blog SEO et capture de leads vendeurs."

**Après (exemple) :**

```
Eduardo De Sul — Bordeaux Métropole
Territoire : complet (fermé)

Livré en 18 jours : site local brandé, 6 pages secteurs,
estimateur intégré, 3 articles SEO, séquence email vendeurs.
Présence propriétaire sur Bordeaux — Eduardo n'est plus dépendant
de son réseau pour sa visibilité locale.
```

**Note :** Si des chiffres réels existent (x contacts/mois, x estimations/mois), les intégrer impérativement.

---

### 2.2 — Ajouter une section "Comment ça marche" (F7)

**Après la section Hero, avant les features**, insérer une section 3 étapes :

```
Comment ça marche

1. Vous vérifiez votre ville (2 min)
   Vous renseignez votre commune. Si elle est disponible, vous recevez
   une confirmation sous 24h.

2. On installe votre système (sous 21 jours)
   Site, SEO local, Google Business, pages secteurs, CRM et automatisations.
   Vous validez, on livre.

3. Votre territoire travaille pour vous
   Les vendeurs de votre ville vous trouvent sur Google.
   Vous recevez les demandes directement dans votre CRM.
```

---

### 2.3 — Ajouter la garantie de propriété en évidence (F2)

**Dans la section pricing, ajouter une ligne de réassurance :**

```
Vos données, votre domaine, votre site.
Si vous partez, vous repartez avec tout.
```

---

### 2.4 — Repositionner le Programme Fondateur (F6)

**Ajouter une section ou une mention :**

```
Programme Fondateur — Places épuisées

Les 5 premiers conseillers ont rejoint le programme à 47€/mois à vie.
Ces places sont fermées. L'offre actuelle démarre à 97€/mois.

[Voir les villes disponibles →]
```

Cela crée de la preuve sociale (5 fondateurs) et justifie le prix actuel.

---

### 2.5 — Ajouter 3 objections en FAQ sur la homepage

**Objections critiques à traiter directement sur la homepage :**

```
Q : Est-ce que je dois gérer le site moi-même ?
R : Non. On gère tout — maintenance, contenu SEO, Google Business.
    Vous n'avez qu'à recevoir les demandes.

Q : En combien de temps je vois des résultats ?
R : Les premiers contacts vendeurs arrivent en moyenne sous 60 à 90 jours.
    Le SEO se renforce sur 3 à 6 mois.

Q : Et si je change de réseau ou de ville ?
R : Le domaine, le site et les données vous appartiennent.
    Vous pouvez migrer ou garder le système indépendamment de votre réseau.
```

---

## PHASE 3 — Finition UX / SEO (Semaine 3–4, ~3h)

### 3.1 — Retirer les emojis de la section features

**Fichier probable :** `src/components/Features.astro`

Supprimer : 🌐 📍 ⭐ 📝 📋 ✉️

Les remplacer par des **icônes SVG simples** (style outline, 24px, couleur primaire du site) ou des **numéros** (01, 02, 03...) comme dans la section "Ce qui est installé" en homepage.

---

### 3.2 — Modifier le titre de la page /offre

**Avant :** "Votre base digitale locale, moins cher qu'un abonnement SeLoger"

**Après :** "Un seul territoire. Un seul conseiller. Un système qui travaille pour vous."

---

### 3.3 — Nettoyer la navigation

**Supprimer de la nav principale :**
- "Phenix" (non contextualisé)
- "Site Estimateur ville" (proposer en offre dédiée, pas en nav principale)
- "Solution financement" (si non lié à l'offre principale)

**Nav simplifiée :**
```
Accueil | Comment ça marche | Offres | Réalisations | Blog | [Vérifier ma ville]
```

---

### 3.4 — Simplifier le footer

**Footer actuel :** 11+ liens dans 2 colonnes désorganisées

**Footer simplifié :**

```
Écosystème Immo
Système d'acquisition local pour conseillers immobiliers indépendants.

[Offres]   [Réalisations]   [Blog]   [Contact]

Olivier Colas — contact@ecosystemeimmo.fr — 07 85 61 17 00
Mentions légales | CGU | Confidentialité
© 2026 Écosystème Immo — OCDM Agency
```

---

### 3.5 — Titre H2 section pricing

**Avant :** "Choisissez votre niveau de visibilité"

**Après :** "Sécurisez votre territoire"

---

## ORDRE D'EXÉCUTION EXACT

```
Priorité 1 — Impact immédiat, moins de 30 min chacun :
  [1] Corriger le pricing (C1)
  [2] Barre de scarcité villes fermées (C3 + F4)
  [3] Badges "Territoire complet" sur réalisations (C3)

Priorité 2 — Impact fort, 1h–2h chacun :
  [4] Réécrire H1 + sous-titre hero (F1)
  [5] Supprimer CTA "149€/mois" du hero (F5)
  [6] Ajouter IA/automatisations dans features (C4)
  [7] Simplifier CTAs par section (F3)

Priorité 3 — Preuve et confiance, 2h–4h au total :
  [8] Réécrire les 5 case studies avec résultats réels (F2)
  [9] Ajouter section "Comment ça marche" (F7)
  [10] Ajouter 3 FAQ sur la homepage (M3)
  [11] Ajouter bloc Programme Fondateur fermé (F6)

Priorité 4 — Finition UX, 1h–2h au total :
  [12] Retirer emojis features → icônes SVG (M1)
  [13] Modifier titre page /offre (M2)
  [14] Nettoyer navigation (M6)
  [15] Simplifier footer (M4)
```

---

## LISTE DES FICHIERS À MODIFIER

> Structure supposée pour un site Astro/Next.js. À adapter à votre stack.

| Fichier probable | Modifications |
|-----------------|---------------|
| `src/layouts/Layout.astro` | Barre scarcité (header global) |
| `src/components/Header.astro` | Simplification navigation |
| `src/pages/index.astro` | Coordonner toutes les sections homepage |
| `src/components/Hero.astro` | H1, sous-titre, CTA secondaire |
| `src/components/Features.astro` | Supprimer emojis, ajouter IA |
| `src/components/Pricing.astro` | Tout le pricing (C1 = priorité absolue) |
| `src/components/Realisations.astro` | Badges complet, réécriture case studies |
| `src/components/HowItWorks.astro` | Créer si inexistant, section 3 étapes |
| `src/components/FAQ.astro` | Ajouter 3 FAQ homepage |
| `src/pages/offre.astro` | Pricing, titre page |
| `src/pages/realisations.astro` | Badges complet, résultats |
| `src/components/Footer.astro` | Simplification footer |

---

## COPY — BANQUE DE TEXTES PRÊTS À UTILISER

### Hero principal (version finale)

```
H1 : Votre ville a une seule place disponible.

Sous-titre : Écosystème Immo installe votre système d'acquisition local —
site professionnel, SEO, Google Business, pages quartiers, CRM et automatisations IA.
Exclusif à votre territoire. Un seul conseiller par ville.

CTA primaire : Vérifier si ma ville est disponible
CTA secondaire : Comment ça marche
```

### Section pricing — accroche

```
H2 : Sécurisez votre territoire

Sous-titre : Un système. Un territoire. Un conseiller.
Chaque formule inclut l'exclusivité sur votre secteur.
```

### Barre scarcité

```
Territoires complets : Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion
Vérifiez votre ville →
```

### CTA footer de section réalisations

```
Ces territoires sont fermés.
Le vôtre est peut-être encore disponible.
[Vérifier ma ville]
```

### Intro section features (version finale)

```
Un système d'acquisition local, pas un outil de plus.

Visibilité locale, contenus SEO, capture vendeurs, suivi CRM
et automatisations IA — activé sur votre territoire exclusif.
```

---

## MÉTRIQUES À SUIVRE (POST-DÉPLOIEMENT)

- Taux de clic sur "Vérifier si ma ville est disponible" (événement GA4)
- Nombre de formulaires de vérification soumis / semaine
- Temps passé sur la page /offre avant conversion
- Scroll depth sur la homepage (section pricing atteinte ?)
- Taux de rebond mobile vs desktop

---

*Audit réalisé sur la base du site en production ecosystemeimmo.fr — 2026-07-16*
