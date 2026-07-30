# Plan d'exécution CRO — Écosystème Immo
> Créé le 2026-07-30 | Basé sur l'audit du 2026-07-25 | 0/15 actions exécutées

---

## DÉCISIONS STRATÉGIQUES (tranchées — ne pas revenir dessus)

| Question | Décision |
|----------|---------|
| Quel pricing ? | Brief : 27€ / 97€ / 897€ / 900€ — retirer le 0€ trial et le 49€/149€ |
| Essai gratuit ? | Non — supprimé. Affaiblit la scarcité et le positionnement premium |
| Exclusivité par ville ou zone ? | **1 ville = 1 conseiller** — pas "zone 50 km" |
| CTA principal ? | **"Vérifier si ma ville est disponible"** — un seul funnel |
| Angers fermé ? | Oui — ajouter Eric Verneau à la scarcity bar et /realisations |

---

## PROBLÈMES CLASSÉS PAR IMPACT BUSINESS

### CRITIQUE — Bloque la conversion aujourd'hui

| Ref | Problème | Fichier concerné |
|-----|----------|-----------------|
| EC1 | Pricing incohérent (0€ / 49€ / 149€ ≠ brief) | Pricing.astro, offre.astro |
| EC2 | "Zone 50 km" au lieu de "1 ville = 1 conseiller" | Hero.astro, offre.astro, Layout.astro |
| EC3 | Deux funnels contradictoires (trial gratuit + vérification ville) | Hero.astro, Header.astro |
| C2 | Exclusivité présentée comme détail, pas comme pilier central | Hero.astro, offre.astro |

### FORT — Réduit la confiance et le désir

| Ref | Problème | Fichier concerné |
|-----|----------|-----------------|
| F1 | H1 trop long, passif — ne crée pas l'urgence | Hero.astro |
| F3 | CTAs sans hiérarchie (3+ CTA différents sur la homepage) | Hero.astro, Header.astro |
| F4 | Pas de barre de scarcité des villes fermées | Layout.astro |
| C3 | Pas de badges "Territoire complet" sur les réalisations | Realisations.astro |
| F2 | Case studies sans résultats concrets (délais, livrables) | Realisations.astro |
| C4 | IA et automatisations absentes du site | Features.astro |
| F6 | Programme Fondateur non valorisé / not explained | Pricing.astro |
| F7 | Pas de section "Comment ça marche" | Nouveau : HowItWorks.astro |

### MOYEN — Dégrade l'image premium

| Ref | Problème | Fichier concerné |
|-----|----------|-----------------|
| M1 | Emojis partout (📉 🔗 🚫 🌐 📝 📍 ⭐ 📋 🎁 🔓 🔒) | Features.astro, offre.astro |
| M3 | FAQ absente de la homepage | Nouveau : FAQ.astro |
| M5 | "Système d'acquisition" jamais utilisé dans les textes | Hero.astro, Features.astro |
| Nav | Navigation surchargée (Phenix, Estimateur ville, Financement) | Header.astro |
| Footer | Footer non simplifié | Footer.astro |
| Titre | Page /offre : titre de positionnement faible | offre.astro |

---

## PHASE 1 — CONVERSION IMMÉDIATE (à faire en priorité absolue)

Objectif : éliminer tout ce qui bloque le clic et crée de la confusion.
Durée estimée : 2 à 3 heures de développement.

### 1.1 — src/layouts/Layout.astro
**Ajouter la barre de scarcité sticky en top du layout (avant le Header)**

```html
<div id="scarcity-bar" style="
  background: #0f172a;
  color: #f8fafc;
  text-align: center;
  padding: 10px 20px;
  font-size: 13px;
  letter-spacing: 0.01em;
  position: sticky;
  top: 0;
  z-index: 100;
">
  Territoires complets : Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion · Angers
  &nbsp;—&nbsp;
  <a href="#verifier" style="color: #e2e8f0; text-decoration: underline; font-weight: 500;">
    Vérifiez votre ville →
  </a>
</div>
```

---

### 1.2 — src/components/Header.astro
**Navigation simplifiée — retirer tous les liens parasites**

Navigation après :
```
Accueil | Comment ça marche | Offres | Réalisations | Blog
CTA nav : [Vérifier ma ville]
```

Supprimer : Phenix, Site Estimateur ville, Solution financement, Diagnostic gratuit,
Avantages (si présent en nav principale)

---

### 1.3 — src/components/Hero.astro
**Réécrire entièrement le bloc hero**

```
H1 :
Votre ville a une seule place disponible.

Sous-titre :
Écosystème Immo installe votre système d'acquisition local — site professionnel,
SEO, Google Business, pages quartiers, CRM et automatisations IA.
Exclusif à votre territoire. Un seul conseiller par ville.

CTA principal : Vérifier si ma ville est disponible
CTA secondaire : Comment ça marche  [ancre #process]

SUPPRIMER : "Démarrer mes 30 jours gratuits"
SUPPRIMER : "Voir les offres à partir de 149 €/mois"
SUPPRIMER : tout texte mentionnant "zone de 50 km"
```

---

### 1.4 — src/components/Pricing.astro
**Remplacer entièrement le pricing**

Retirer : 0€ (essai 30j) / 49€/mois / 149€/mois

Mettre :

```
FORMULE ESTIMATEUR
27 €/mois + 197 € setup unique
— Estimateur immobilier intégré
— Formulaire de capture vendeurs
— Hébergement et maintenance
CTA : Choisir cette formule

---

FORMULE MENSUELLE   [RECOMMANDÉE]
97 €/mois + 497 € setup
3 mois prépayés à l'activation
— Site immobilier local à votre nom
— Pages secteurs et quartiers
— Google Business Profile
— Estimateur et formulaire vendeur
— CRM et suivi prospects
— Automatisations et relances IA
— Contenu SEO mensuel
— Exclusivité territoriale
CTA : Vérifier si ma ville est disponible

---

FORMULE ANNUELLE   [MEILLEURE VALEUR]
897 €/an — setup offert
≈ 74 €/mois · Économisez 267 € vs mensuel
+ Exclusivité territoriale renforcée
+ Priorité sur les villes à forte demande
CTA : Sécuriser mon territoire

---

EXCLUSIVITÉ VERROUILLÉE
900 € — paiement unique
Verrou territorial à vie. Sans abonnement. Sans renouvellement.
CTA : Me renseigner sur cette option

---

Note de réassurance :
Vos données, votre domaine, votre site — vous repartez avec tout si vous partez.
Un seul conseiller par territoire.

---

Programme Fondateur — Places épuisées
Les 5 premiers conseillers ont rejoint le programme à 47 €/mois à vie.
Ces places sont fermées. Ce sont eux qui apparaissent dans les réalisations.
```

---

### 1.5 — src/pages/offre.astro
**Changer le titre de la page et corriger le pricing**

```
AVANT : "Votre base digitale locale, moins cher qu'un abonnement SeLoger"
APRÈS : "Un seul territoire. Un seul conseiller. Un système qui travaille pour vous."
```

+ Remplacer le même pricing que ci-dessus (1.4)
+ Remplacer toutes les mentions "zone 50 km" par "votre ville"
+ Supprimer tout lien vers l'essai gratuit

---

## PHASE 2 — CONFIANCE ET PREUVE (à faire dans les 48h suivantes)

Objectif : lever les objections, montrer la preuve sociale, expliquer le fonctionnement.

### 2.1 — src/components/HowItWorks.astro (CRÉER)
Section à insérer entre Hero et Features, avec ancre `id="process"`.

```
H2 : Comment ça marche

Étape 01 — Vous vérifiez votre ville
Renseignez votre commune. Si elle est disponible, vous recevez
une confirmation et un brief personnalisé sous 24h.

Étape 02 — On installe votre système en 21 jours
Site, SEO local, Google Business, pages secteurs, CRM et automatisations.
Vous validez chaque étape. On livre clé en main.

Étape 03 — Votre territoire travaille pour vous
Les vendeurs de votre ville vous trouvent sur Google.
Les demandes arrivent directement dans votre CRM.

CTA : Vérifier si ma ville est disponible
```

Design : 3 blocs numérotés (01 / 02 / 03), fond neutre, pas de card.
Mobile : stack vertical. Desktop : 3 colonnes.

---

### 2.2 — src/components/Features.astro
**Supprimer tous les emojis — ajouter IA/automatisations**

```
H2 : Un système d'acquisition local, pas un outil de plus.

Intro :
Visibilité locale, contenus SEO, capture vendeurs, suivi CRM et automatisations IA
— activé sur votre territoire exclusif.

01 — Site immobilier local
Professionnel, mobile-first, brandé à votre nom. Pensé pour capter
les propriétaires vendeurs de votre secteur.

02 — Pages secteurs et quartiers
Des pages dédiées à vos communes et zones d'influence, optimisées
pour apparaître sur Google quand un vendeur cherche dans votre ville.

03 — Google Business Profile
Une fiche locale cohérente avec votre site. Indispensable pour
apparaître sur Google Maps et dans les résultats locaux.

04 — Formulaire vendeur
Un point d'entrée clair pour capter les demandes d'estimation
et les contacts vendeurs directement depuis votre site.

05 — CRM et suivi prospects
Suivi centralisé de vos contacts, statuts et prochaines actions.
Tout au même endroit, sans outils dispersés.

06 — Automatisations et IA
Rappels automatiques, relances intelligentes, scoring prospects.
Le système travaille quand vous prospectez.
```

Supprimer tous les emojis (🌐 📍 ⭐ 📝 📋 ✉️ et tous les autres).
Remplacer par numéros 01-06 en police mono ou petits SVG outline neutres.

---

### 2.3 — src/components/Realisations.astro
**Ajouter les badges "TERRITOIRE COMPLET" + détails livraison + Eric Verneau (Angers)**

Chaque carte doit avoir :
- Badge rouge "TERRITOIRE COMPLET" (position absolute top-right ou top-left)
- Délai de livraison mentionné si connu
- 2-3 livrables concrets listés

```
Bordeaux Métropole — Eduardo De Sul   [TERRITOIRE COMPLET]
Livré en 18 jours : site local, 6 pages secteurs, estimateur, 3 articles SEO, séquence email.

Aix-en-Provence — Pascal Hamm   [TERRITOIRE COMPLET]
Site brandé, pages services, estimateur, structure SEO locale.

Nandy / Sénart — Fatima Rabia   [TERRITOIRE COMPLET]
Site local, formulaire vendeur, pages secteurs.

Lannion / Trégor — Stéphanie Hulen   [TERRITOIRE COMPLET]
Site local, pages géographiques, contenus, formulaires.

Nantes — Brice Chupin   [TERRITOIRE COMPLET]
Positionnement coach immobilier visible localement.

Angers — Eric Verneau   [TERRITOIRE COMPLET]
[Détails à compléter]
```

CTA section :
```
Ces territoires sont fermés. Le vôtre est peut-être encore disponible.
[Vérifier ma ville]
```

---

### 2.4 — src/pages/realisations.astro
Mêmes badges "TERRITOIRE COMPLET" que 2.3, cohérence sur la page dédiée.

---

## PHASE 3 — FINITION, UX ET SEO

Objectif : polish, suppression des frictions restantes, SEO technique.

### 3.1 — src/components/FAQ.astro (CRÉER)
Section à insérer avant le CTA final.

```
H2 : Questions fréquentes

Q : Est-ce que je dois gérer le site moi-même ?
R : Non. On gère tout — maintenance, mises à jour, contenus SEO,
    Google Business Profile. Vous recevez les demandes, on gère le système.

Q : En combien de temps je vois des résultats ?
R : Les premiers contacts vendeurs arrivent généralement sous 60 à 90 jours.
    Le référencement local se renforce sur 3 à 6 mois.
    Le système travaille en continu, pas ponctuellement.

Q : Et si je change de réseau ou de secteur ?
R : Le domaine, le site et toutes vos données vous appartiennent.
    Vous pouvez continuer à utiliser le système
    indépendamment de votre réseau.
```

Design : accordéon sobre (sans animation gadget), fond blanc/gris très léger.

---

### 3.2 — Section finale CTA (dans la homepage)
```
H2 : Votre territoire est encore disponible ?

Sous-titre :
La vérification est gratuite et sans engagement.
Si votre ville est libre, vous recevez une confirmation sous 24h.

CTA principal : Vérifier si ma ville est disponible

Note sous le CTA :
Sans engagement · Réponse sous 24h · Un seul conseiller par ville
```

---

### 3.3 — src/components/Footer.astro
**Simplifier — retirer les liens parasites**

```
Écosystème Immo
Système d'acquisition local pour conseillers immobiliers indépendants.

Liens : Offres · Réalisations · Blog · Contact

Olivier Colas — 07 85 61 17 00 — contact@ecosystemeimmo.fr

Mentions légales | CGU | Confidentialité
© 2026 Écosystème Immo — OCDM Agency
```

Supprimer : liens Phenix, Solution financement, Site Estimateur, Avantages.

---

## ORDRE D'EXÉCUTION PRÉCIS

```
Étape 01 → src/components/Pricing.astro     (pricing complet — décision la plus urgente)
Étape 02 → src/pages/offre.astro            (titre + même pricing)
Étape 03 → src/components/Hero.astro        (H1 + CTA unique + supprimer trial)
Étape 04 → src/layouts/Layout.astro         (barre scarcité sticky)
Étape 05 → src/components/Header.astro      (navigation simplifiée)
Étape 06 → src/components/Realisations.astro (badges TERRITOIRE COMPLET + Angers)
Étape 07 → src/pages/realisations.astro     (même badges)
Étape 08 → src/components/HowItWorks.astro  (CRÉER — 3 étapes)
Étape 09 → src/components/Features.astro    (supprimer emojis, ajouter IA/automatisations)
Étape 10 → src/components/FAQ.astro         (CRÉER — 3 objections)
Étape 11 → Section CTA finale homepage      (dans la page principale)
Étape 12 → src/components/Footer.astro      (simplifier)
```

---

## RÉCAPITULATIF FICHIERS À MODIFIER

| Fichier | Phase | Action |
|---------|-------|--------|
| `src/layouts/Layout.astro` | 1 | Ajouter barre scarcité sticky |
| `src/components/Header.astro` | 1 | Navigation simplifiée, CTA unique |
| `src/components/Hero.astro` | 1 | H1 + sous-titre + CTA unifié, supprimer trial |
| `src/components/Pricing.astro` | 1 | Pricing complet à corriger (4 formules) |
| `src/pages/offre.astro` | 1 | Titre page + même pricing |
| `src/components/HowItWorks.astro` | 2 | CRÉER — section 3 étapes |
| `src/components/Features.astro` | 2 | Emojis → numéros, ajouter IA/automatisations |
| `src/components/Realisations.astro` | 2 | Badges "Territoire complet" + Angers |
| `src/pages/realisations.astro` | 2 | Badges + cohérence |
| `src/components/FAQ.astro` | 3 | CRÉER — 3 objections |
| Section CTA finale | 3 | Copy finale de conversion |
| `src/components/Footer.astro` | 3 | Simplifier |

**Total : 10 fichiers à modifier, 2 fichiers à créer.**

---

## RÈGLES DESIGN À RESPECTER

- **Mobile-first absolu** : tester chaque modification sur 375px avant desktop
- **Zéro emoji** dans le contenu final
- **Hiérarchie CTA stricte** : un seul CTA principal par section ("Vérifier si ma ville est disponible")
- **Palette sobre** : pas de dégradés criards, pas d'effets gadgets, tons neutres
- **Typographie** : taille H1 ≥ 36px mobile, espacement généreux
- **Scarcity bar** : toujours visible, fond sombre, texte clair — position sticky z-index élevé

---

*Plan créé le 2026-07-30 — à exécuter dans le projet source Astro*
*Référence copy complète → COPY-CHANGES.md*
*Référence audit → AUDIT-CRO.md*
