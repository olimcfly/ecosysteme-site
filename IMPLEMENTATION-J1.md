# Plan d'implémentation — Jour 1
> Basé sur l'audit CRO du 2026-07-16 · À exécuter dans cet ordre exact

---

## AVANT DE COMMENCER

- Ouvrir le projet dans votre éditeur
- Avoir le site en local ou une preview déployée
- Tester chaque modification sur mobile avant de déployer

**Stack supposée :** Astro.js  
**Temps total estimé :** 3h30 pour les 10 premiers points

---

## PRIORITÉ 1 — Modifications à impact immédiat (1h30)

### [1] Barre de scarcité — `src/layouts/Layout.astro`
*Impact : CRITIQUE — Urgence immédiate, scarcité activée*  
*Temps : 10 min*

Coller ce bloc **juste après l'ouverture de `<body>`**, avant tout autre élément :

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
  z-index: 200;
">
  Territoires complets&nbsp;: Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion
  &nbsp;—&nbsp;
  <a href="#verifier" style="
    color: #e2e8f0;
    text-decoration: underline;
    font-weight: 500;
    white-space: nowrap;
  ">Vérifiez votre ville →</a>
</div>
```

---

### [2] Hero — H1 et sous-titre — `src/components/Hero.astro`
*Impact : FORT — Accroche ratée = rebond immédiat sur mobile*  
*Temps : 15 min*

**Remplacer le H1 actuel par :**
```
Votre ville a une seule place disponible.
```

**Remplacer le sous-titre par :**
```
Écosystème Immo installe votre système d'acquisition local — site professionnel,
SEO, Google Business, pages quartiers, CRM et automatisations IA.
Exclusif à votre territoire. Un seul conseiller par ville.
```

**Supprimer** : le CTA secondaire "Voir les offres à partir de 149 €/mois"  
**Le remplacer par** : `<a href="#process">Comment ça marche</a>`

Le CTA principal "Vérifier si ma ville est disponible" reste intact.

---

### [3] Pricing — `src/components/Pricing.astro` ou `src/pages/offre.astro`
*Impact : CRITIQUE — Le pricing affiché (149/249/399€) ne correspond pas à la réalité*  
*Temps : 30 min*

**Supprimer entièrement** les 3 tiers actuels (Essentiel / Visibilité / Territoire).

**Remplacer par ces 4 formules :**

**Titre H2 :** `Sécurisez votre territoire`  
**Sous-titre :** `Un système. Un territoire. Un conseiller. Chaque formule inclut l'exclusivité sur votre secteur.`

---

**Formule 1 — ESTIMATEUR**
```
ESTIMATEUR
27 €/mois + 197 € setup unique

— Estimateur immobilier intégré
— Formulaire de capture vendeurs
— Hébergement et maintenance

Pour : Conseillers qui veulent démarrer par la capture d'estimations.

[CTA] Choisir cette formule
```

---

**Formule 2 — MENSUELLE** *(badge RECOMMANDÉ)*
```
MENSUELLE
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

Pour : Conseillers qui veulent un système complet sans engagement annuel.

[CTA] Vérifier si ma ville est disponible
```

---

**Formule 3 — ANNUELLE** *(badge MEILLEURE VALEUR)*
```
ANNUELLE
897 €/an — setup offert
≈ 74 €/mois · Économisez 267 € vs mensuel

Tout le Mensuel, plus :
— Setup offert (497 € économisés)
— Exclusivité territoriale renforcée
— Priorité sur les villes à forte demande

Pour : Conseillers qui veulent sécuriser leur territoire durablement.

[CTA] Sécuriser mon territoire
```

---

**Formule 4 — EXCLUSIVITÉ VERROUILLÉE**
```
EXCLUSIVITÉ VERROUILLÉE
900 € — paiement unique

Verrou territorial à vie sur votre ville.
Sans abonnement. Sans renouvellement.
Votre territoire reste bloqué pour les concurrents,
quelle que soit votre formule.

[CTA] Me renseigner sur cette option
```

---

**Note de réassurance sous le tableau :**
```
Vos données, votre domaine, votre site — vous repartez avec tout si vous partez.
Un seul conseiller par territoire. La disponibilité dépend de votre ville.
```

**Bloc Programme Fondateur (sous la réassurance) :**
```
Programme Fondateur — Places épuisées
Les 5 premiers conseillers ont rejoint le programme à 47 €/mois à vie.
Ces places sont fermées. C'est eux qui apparaissent dans les réalisations ci-dessous.
```

---

### [4] Badges "Territoire complet" — `src/components/Realisations.astro`
*Impact : CRITIQUE — Scarcité non activée sur les villes fermées*  
*Temps : 20 min*

Sur chaque carte des 5 villes (Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion) :

**Ajouter ce badge en position `absolute` top-right :**
```html
<span style="
  background: #dc2626;
  color: white;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  padding: 4px 10px;
  border-radius: 4px;
  position: absolute;
  top: 16px;
  right: 16px;
">Territoire complet</span>
```

**Supprimer** tout CTA "Vérifier ma ville" sur ces cartes.  
**Ajouter à la place :** `<span style="color: #9ca3af; font-size: 13px;">Ce territoire est fermé.</span>`

**CTA de fin de section :**
```
Ces territoires sont fermés.
Le vôtre est peut-être encore disponible.

[Vérifier ma ville]
```

---

### [5] Contenu IA manquant — `src/components/Features.astro`
*Impact : CRITIQUE — L'IA et automatisations ne figurent pas sur le site*  
*Temps : 15 min*

**Remplacer l'intro de section par :**
```
Un système d'acquisition local, pas un outil de plus.

Visibilité locale, contenus SEO, capture vendeurs, suivi CRM et automatisations IA
— activé sur votre territoire exclusif.
```

**Remplacer les features actuelles par ces 6 items numérotés :**
```
01 — Site immobilier local
Professionnel, mobile-first, brandé à votre nom. Pensé pour capter
les propriétaires vendeurs de votre secteur.

02 — Pages secteurs et quartiers
Pages dédiées à vos communes et zones d'influence, optimisées
pour apparaître sur Google quand un vendeur cherche dans votre ville.

03 — Google Business Profile
Fiche locale cohérente avec votre site. Indispensable pour
apparaître sur Google Maps et dans les résultats locaux.

04 — Formulaire vendeur
Point d'entrée clair pour capter les demandes d'estimation
et les contacts vendeurs directement depuis votre site.

05 — CRM et suivi prospects
Suivi centralisé de vos contacts, statuts et prochaines actions.
Tout au même endroit, sans outils dispersés.

06 — Automatisations et IA
Rappels automatiques, relances intelligentes, scoring prospects.
Le système travaille quand vous prospectez.
```

**Supprimer tous les emojis :** 🌐 📍 ⭐ 📝 📋 ✉️  
Remplacer par les numéros 01–06 (ou icônes SVG outline 24px couleur primaire).

---

## PRIORITÉ 2 — Confiance et preuve (1h30)

### [6] Section "Comment ça marche" — Nouveau composant
*Impact : FORT — Le chemin d'achat est flou*  
*Temps : 25 min*

Créer `src/components/HowItWorks.astro` (ou ajouter inline dans `index.astro`) **entre le Hero et les Features**, avec l'ancre `id="process"` :

```html
<section id="process">
  <h2>Comment ça marche</h2>

  <div class="step">
    <span class="step-number">01</span>
    <h3>Vous vérifiez votre ville</h3>
    <p>Renseignez votre commune. Si elle est disponible, vous recevez
    une confirmation et un brief personnalisé sous 24h.</p>
  </div>

  <div class="step">
    <span class="step-number">02</span>
    <h3>On installe votre système en 21 jours</h3>
    <p>Site, SEO local, Google Business, pages secteurs, CRM et automatisations.
    Vous validez chaque étape. On livre clé en main.</p>
  </div>

  <div class="step">
    <span class="step-number">03</span>
    <h3>Votre territoire travaille pour vous</h3>
    <p>Les vendeurs de votre ville vous trouvent sur Google.
    Les demandes arrivent directement dans votre CRM.</p>
  </div>

  <a href="#verifier">Vérifier si ma ville est disponible</a>
</section>
```

---

### [7] Réalisations — réécriture des descriptions — `src/components/Realisations.astro`
*Impact : FORT — "base mise en place" ≠ résultat*  
*Temps : 20 min*

**Remplacer le titre H2 par :** `Les territoires déjà installés`  
**Sous-titre :** `Cinq bases locales construites pour des conseillers indépendants. Ces territoires sont désormais fermés.`

**Descriptions par carte :**

Bordeaux Métropole — Eduardo De Sul :
```
Livré en 18 jours : site local, 6 pages secteurs, estimateur intégré,
3 articles SEO de démarrage, séquence email vendeurs.
Eduardo dispose d'une présence propriétaire sur Bordeaux — indépendante de son réseau.
```

Aix-en-Provence — Pascal Hamm :
```
Site brandé, pages services, estimateur, structure SEO locale.
Fondation digitale posée sur un marché à forte concurrence.
```

Nandy / Sénart — Fatima Rabia :
```
Site local humanisé, formulaire vendeur, pages secteurs.
Présence propriétaire sur son territoire d'origine.
```

Lannion / Trégor — Stéphanie Hulen :
```
Site local, pages géographiques, contenus et formulaires.
Présence digitale ancrée dans l'identité bretonne de son territoire.
```

Nantes — Brice Chupin :
```
Positionnement "coach immobilier" rendu visible localement.
Présence différenciante sur Nantes.
```

---

### [8] FAQ Homepage — `src/pages/index.astro` ou `src/components/FAQ.astro`
*Impact : MOYEN — Objections non traitées sur la landing principale*  
*Temps : 15 min*

Ajouter une section FAQ directement sur la homepage (pas seulement sur /offre) :

```
Questions fréquentes

Q : Est-ce que je dois gérer le site moi-même ?
R : Non. On gère tout — maintenance, mises à jour, contenus SEO,
    Google Business Profile. Vous recevez les demandes, on gère le système.

Q : En combien de temps je vois des résultats ?
R : Les premiers contacts vendeurs arrivent généralement sous 60 à 90 jours.
    Le référencement local se renforce sur 3 à 6 mois.
    Le système travaille en continu, pas ponctuellement.

Q : Et si je change de réseau ou de secteur ?
R : Le domaine, le site et toutes vos données vous appartiennent.
    Vous pouvez continuer à utiliser le système indépendamment de votre réseau.
```

---

### [9] Section finale CTA — `src/pages/index.astro`
*Temps : 10 min*

**Remplacer le CTA de bas de page par :**

```
Votre territoire est encore disponible ?

La vérification est gratuite et sans engagement.
Si votre ville est libre, vous recevez une confirmation sous 24h.

[Vérifier si ma ville est disponible]

Sans engagement · Réponse sous 24h · Un seul conseiller par ville
```

Ancre : `id="verifier"`

---

## PRIORITÉ 3 — Finition UX (30 min)

### [10] Titre page /offre — `src/pages/offre.astro`
*Temps : 5 min*

```
AVANT : "Votre base digitale locale, moins cher qu'un abonnement SeLoger"
APRÈS : "Un seul territoire. Un seul conseiller. Un système qui travaille pour vous."
```

---

### [11] Navigation — `src/components/Header.astro`
*Temps : 10 min*

```
AVANT : Accueil | L'offre | Avantages | Réalisations | Blog |
        Diagnostic gratuit | Solution financement | Site Estimateur ville

APRÈS : Accueil | Comment ça marche | Offres | Réalisations | Blog

CTA nav : [Vérifier ma ville]
```

**Supprimer :** Phenix, Site Estimateur ville, Solution financement, Diagnostic gratuit (garder en lien secondaire dans le footer uniquement).

---

### [12] Footer — `src/components/Footer.astro`
*Temps : 15 min*

```
Écosystème Immo
Système d'acquisition local pour conseillers immobiliers indépendants.

Offres · Réalisations · Blog · Contact

Olivier Colas
07 85 61 17 00
contact@ecosystemeimmo.fr

Mentions légales | CGU | Confidentialité
© 2026 Écosystème Immo — OCDM Agency
```

---

## RÉCAPITULATIF ORDRE D'EXÉCUTION

```
PHASE 1 — Impact immédiat (1h30)
  [1] Barre scarcité         → Layout.astro          10 min
  [2] Hero H1 + CTA          → Hero.astro            15 min
  [3] Pricing (4 formules)   → Pricing/offre.astro   30 min
  [4] Badges "complet"       → Realisations.astro    20 min
  [5] IA features            → Features.astro        15 min

PHASE 2 — Confiance (1h30)
  [6] "Comment ça marche"    → HowItWorks.astro      25 min
  [7] Réalisations copy      → Realisations.astro    20 min
  [8] FAQ homepage           → index / FAQ.astro     15 min
  [9] Section finale CTA     → index.astro           10 min

PHASE 3 — Finition (30 min)
  [10] Titre page /offre     → offre.astro           5 min
  [11] Navigation            → Header.astro          10 min
  [12] Footer                → Footer.astro          15 min
```

---

## FICHIERS À MODIFIER (liste définitive)

| Fichier | Modifications | Priorité |
|---------|---------------|----------|
| `src/layouts/Layout.astro` | Barre scarcité | CRITIQUE |
| `src/components/Hero.astro` | H1, sous-titre, CTA secondaire | CRITIQUE |
| `src/components/Pricing.astro` ou `src/pages/offre.astro` | 4 formules, suppression anciens tarifs | CRITIQUE |
| `src/components/Realisations.astro` | Badges complet, descriptions, CTA section | CRITIQUE |
| `src/components/Features.astro` | IA, suppression emojis, numéros 01-06 | CRITIQUE |
| `src/components/HowItWorks.astro` | Créer ce composant (3 étapes) | FORT |
| `src/components/FAQ.astro` ou `src/pages/index.astro` | 3 FAQ homepage | MOYEN |
| `src/pages/index.astro` | Section finale CTA, intégration HowItWorks | FORT |
| `src/pages/offre.astro` | Titre page | MOYEN |
| `src/components/Header.astro` | Navigation simplifiée | MOYEN |
| `src/components/Footer.astro` | Footer simplifié | MOYEN |

---

## MÉTRIQUES À ACTIVER POST-DÉPLOIEMENT (GA4)

- Clic sur "Vérifier si ma ville est disponible" → événement `cta_verify_city`
- Formulaire de vérification soumis → `form_verify_submit`
- Scroll depth homepage (pricing atteint ?) → `scroll_pricing_visible`
- Temps passé page /offre avant conversion → segment dédié

---

*Plan opérationnel généré le 2026-07-17 · Basé sur l'audit CRO du 2026-07-16*
