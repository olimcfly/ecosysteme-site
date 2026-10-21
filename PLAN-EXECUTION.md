# Plan d'exécution CRO — Écosystème Immo
> Généré le 2026-10-21 | Basé sur 18 sessions d'audit | Score actuel : 2/17

---

## Diagnostic synthétique

**Situation :** Le site convertit en mode agence conseil ("Sur devis") alors que le brief est SaaS B2B.
Un visiteur arrive, ne voit aucun prix, aucune rareté, aucune exclusivité — il repart.
La copy est prête dans COPY-CHANGES.md depuis juillet. Elle n'a jamais été intégrée.

**Problème racine :** 5 décisions sont bloquées depuis 14 jours. Ce ne sont pas des problèmes techniques. Ce sont des décisions de copy et de structure à exécuter en 2-4h chacune.

---

## Classement des blocages par impact business

### CRITIQUE — Bloquent la conversion autonome

| # | Blocage | Impact | Présent depuis |
|---|---------|--------|----------------|
| CR1 | **Aucun prix visible** — "Sur devis" partout | Visiteur ne peut pas décider seul | 06/10 (régression) |
| CR6 | **Barre de scarcité absente** | 0 urgence, 0 FOMO | Lancement (18 semaines) |
| CR8 | **Exclusivité territoriale absente** | Différenciateur #1 non communiqué | Semaine 6 |
| CR9 | **Navigation 39 destinations** | Dilution totale de l'attention | 16/10 (aggravation) |
| BUG | **Prompt injection DOM visible** | Crédibilité + SEO dégradés | 15/10 (non corrigé) |

### FORT — Bloquent la confiance post-hero

| # | Blocage | Impact |
|---|---------|--------|
| CR5 | 4 disclaimers sur /tarifs (migration, résultats, pub) | Signal de méfiance avant décision |
| CR2 | H1 générique sans urgence ni exclusivité | Différenciation nulle, taux de rebond élevé |
| CR3 | 8 CTAs sans hiérarchie en homepage | Paralysie du choix |
| CR4 | Page /réalisations sans badge "Territoire complet" | Preuve sociale amputée |
| CR10 | Footer 25 destinations (dont doublon Actif Vendeur) | Sortie de funnel en bas de page |

### MOYEN — Freinent la conversion long terme

| # | Blocage |
|---|---------|
| M1 | Sous-titre homepage trop long, orienté fonctionnalités |
| M2 | Section "Comment ça marche" présente mais mauvaises étapes (ne mentionne pas "Vérifier votre ville") |
| M3 | Page /tarifs H1 vague, sans prix ni exclusivité |
| M4 | Eduardo De Sul sans ville — preuve sociale incomplète |
| M5 | Section Academy en homepage — distraction conversion principale |

### FAIBLE — Finition UX/SEO

| # | Blocage |
|---|---------|
| F1 | Programme "Fondateur 47€" non repositionné comme fermé |
| F2 | Aucune FAQ sur /tarifs |
| F3 | Section "Objections fréquentes" positionnée trop tard (section 9 sur 13) |
| F4 | Lien "Voir son site" (×5 pilotes) sortent du funnel |

---

## Plan d'exécution en 3 phases

---

### PHASE 1 — Conversion immédiate
> Durée estimée : 3-4h | Gain attendu : déblocage de la conversion autonome

**Ces 5 modifications remontent le score de 2/17 à ~9/17.**

---

#### P1.1 — Barre de scarcité (header global)
**Fichier :** `src/layouts/Layout.astro` (ou composant header principal)
**Position :** Première ligne de `<body>`, au-dessus du `<header>`
**Temps :** 20 min

```html
<!-- Coller AVANT le <header> dans le layout principal -->
<div
  id="scarcity-bar"
  style="background:#0f172a;color:#f8fafc;text-align:center;padding:10px 20px;font-size:13px;letter-spacing:0.01em;position:sticky;top:0;z-index:200;"
>
  Territoires complets&nbsp;: Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion
  &nbsp;—&nbsp;
  <a href="#verifier" style="color:#e2e8f0;text-decoration:underline;font-weight:500;">
    Vérifiez votre ville →
  </a>
</div>
```

**Note :** Le z-index doit être supérieur à celui du header si ce dernier est sticky.

---

#### P1.2 — Hero : H1 + CTA unique
**Fichier :** `src/components/Hero.astro` (ou section hero homepage)
**Temps :** 30 min

Remplacer l'intégralité du bloc hero par :

```
H1 :
Votre ville a une seule place disponible.

Sous-titre (1 ligne) :
Système d'acquisition local — site, SEO, CRM, automatisations IA.
Exclusif à votre territoire. Un seul conseiller par ville.

CTA PRINCIPAL (bouton plein, couleur accent) :
"Vérifier si ma ville est disponible"

CTA SECONDAIRE (lien texte sous le principal) :
"Comment ça marche ↓"
```

**Supprimer :** tous les autres CTAs du hero (Découvrir ÉcosystèmeImmo, Voir une démonstration, etc.)

---

#### P1.3 — Navigation : réduction à 5 liens
**Fichier :** `src/components/Header.astro` (ou composant nav)
**Temps :** 45 min

```
AVANT (14 liens header) :
Accueil · Offres (sous-menu) · Comment ça marche · À propos · Ressources (sous-menu) · Audit (sous-menu) · Analyser mon acquisition

APRÈS (5 liens) :
Comment ça marche | Offres | Réalisations | Blog | [Vérifier ma ville →]

"Vérifier ma ville →" = bouton CTA en header, pas un lien
```

Tout ce qui est supprimé de la nav doit aller en footer uniquement (pas de sous-menus).

**Footer après simplification :**
```
Colonne 1 — Navigation : Offres · Réalisations · Blog · Contact
Colonne 2 — Démarrer : Vérifier ma ville · Démonstration · Audit SEO · Devenir Ambassadeur
Colonne 3 — Légal : Mentions légales · CGV · Confidentialité · Gestion cookies
```

**Supprimer du footer :** doublon "Actif Vendeur", Comparatifs logiciels, Hébergement Hostinger, Formations, Guides, Devenir conseiller (si doublon avec Devenir Ambassadeur), Espace client (si pas utilisé par les prospects).

---

#### P1.4 — Pricing réel sur /tarifs
**Fichier :** `src/pages/tarifs.astro` (ou `src/pages/tarifs/index.astro`)
**Temps :** 60-90 min

Remplacer tous les "Sur devis" par les prix réels ci-dessous.

**H1 :** `Sécurisez votre territoire`
**Sous-titre :** `Un système. Un territoire. Un conseiller. Chaque formule inclut l'exclusivité sur votre secteur.`

**Structure des 3 cartes (mobile : stack vertical, desktop : 3 colonnes) :**

```
┌─────────────────────────────────────────────────────────────┐
│  ESTIMATEUR           MENSUEL [RECOMMANDÉ]   ANNUEL [VALEUR]│
│  27 €/mois            97 €/mois              897 €/an       │
│  + 197 € setup        + 497 € setup          setup offert   │
│                       3 mois prépayés        ≈ 74 €/mois    │
│                                              -267 € vs mens.│
├─────────────────────────────────────────────────────────────┤
│  — Estimateur         — Site local           Tout Mensuel + │
│  — Formulaire         — Pages secteurs       — Setup offert │
│  — Hébergement        — Google Business      — Exclusivité  │
│                       — Estimateur           renforcée      │
│                       — CRM                  — Priorité     │
│                       — Automatisations IA   villes fortes  │
│                       — SEO mensuel          │
│                       — Exclusivité          │
├─────────────────────────────────────────────────────────────┤
│  [Choisir]            [Vérifier ma ville]   [Sécuriser mon │
│                                              territoire]    │
└─────────────────────────────────────────────────────────────┘
```

**Sous le tableau — bloc exclusivité verrouillée :**
```
Exclusivité verrouillée — 900 € paiement unique
Verrou territorial à vie. Sans abonnement. Sans renouvellement.
[Me renseigner]
```

**Note de réassurance (sous tout le pricing) :**
```
Vos données, votre domaine, votre site — vous repartez avec tout si vous partez.
Un seul conseiller par territoire. La disponibilité dépend de votre ville.
```

**Programme Fondateur (bloc grisé, mention basse) :**
```
Programme Fondateur — Places épuisées
Les 5 premiers conseillers ont rejoint le programme à 47 €/mois à vie.
Ces places sont fermées. Ce sont eux qui apparaissent dans les réalisations.
```

**Supprimer :** les 4 disclaimers actuels. Les remplacer par la note de réassurance ci-dessus.

---

#### P1.5 — Correction prompt injection DOM
**Fichier :** composant de bannière cookies / consentement sur `/realisations`
**Temps :** 15 min

Le texte "Extrais :" (ou "Extrais verbatim :") est rendu visible dans le DOM de `/realisations`.
Ce texte est probablement dans un composant de consentement RGPD ou dans un script dynamique.

**Action :** Rechercher dans le code source le texte "Extrais" ou "verbatim" et le supprimer.

```bash
grep -r "Extrais" src/
grep -r "verbatim" src/
grep -r "verbatim" public/
```

Si le texte vient d'un composant tiers (Cookiebot, Axeptio, etc.), vérifier la configuration
et retirer toute injection de texte dans le DOM visible.

---

### PHASE 2 — Confiance et preuve sociale
> Durée estimée : 2-3h | Prérequis : Phase 1 terminée

**Ces modifications remontent le score de ~9/17 à ~14/17.**

---

#### P2.1 — Page /réalisations : badges "Territoire complet"
**Fichier :** `src/pages/realisations.astro`

**H2 :** `Les territoires déjà installés`
**Intro :** `Cinq bases locales construites pour des conseillers indépendants. Ces territoires sont désormais fermés.`

**Sur chaque carte client, ajouter :**
```html
<!-- Badge rouge au-dessus du nom de la ville -->
<span style="
  display:inline-block;
  background:#dc2626;
  color:#fff;
  font-size:11px;
  font-weight:700;
  letter-spacing:0.06em;
  padding:3px 8px;
  text-transform:uppercase;
  margin-bottom:8px;
">TERRITOIRE COMPLET</span>
```

**Corriger Eduardo De Sul** : ajouter "Bordeaux Métropole" comme ville.

**CTA section :**
```
Ces territoires sont fermés. Le vôtre est peut-être encore disponible.
[Vérifier ma ville]
```

---

#### P2.2 — Section "Comment ça marche" : corriger les 3 étapes
**Fichier :** `src/components/Process.astro` (ou section dédiée homepage)

Remplacer les étapes actuelles par :

```
Étape 01 — Vous vérifiez votre ville
Renseignez votre commune. Si elle est disponible, vous recevez
une confirmation et un brief personnalisé sous 24h.

Étape 02 — On installe votre système (21 jours)
Site, SEO local, Google Business, pages secteurs, CRM et automatisations.
Vous validez chaque étape. On livre clé en main.

Étape 03 — Votre territoire travaille pour vous
Les vendeurs de votre ville vous trouvent sur Google.
Les demandes arrivent directement dans votre CRM.

CTA : Vérifier si ma ville est disponible
```

---

#### P2.3 — FAQ homepage : remonter et compléter
**Fichier :** section FAQ dans `src/pages/index.astro`

**Action :** Déplacer la FAQ de la section 9 vers la section 4-5 (après hero + process).
Remplacer les 4 questions actuelles par :

```
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

#### P2.4 — Exclusivité territoriale : mention sur chaque page clé
**Fichiers :** `src/pages/index.astro`, `src/pages/tarifs.astro`

Ajouter ce bloc textuel au-dessus du pricing et dans le hero :
```
Un seul conseiller par ville. L'exclusivité est incluse dans chaque formule.
```

Ou en variante pour le hero :
```
1 ville = 1 conseiller = 1 territoire sécurisé
```

---

### PHASE 3 — Finition UX / SEO
> Durée estimée : 2-3h | Prérequis : Phases 1 et 2 terminées

---

#### P3.1 — Suppression des CTAs parasites
**Fichier :** `src/pages/index.astro`

**Supprimer de la homepage :**
- "Voir son site" (×5 liens vers pilotes) — envoient les visiteurs hors du site avant conversion
- "Accéder gratuitement à l'Academy" — distraction majeure (section entière à déplacer en footer)
- "Découvrir ÉcosystèmeImmo" — doublon du hero
- "Analyser mon acquisition" (×2 occurrences en double) — garder une seule occurrence en CTA final

**CTA autorisés sur la homepage (3 maximum) :**
1. "Vérifier si ma ville est disponible" (hero + section pricing + CTA finale)
2. "Comment ça marche ↓" (sous le CTA principal en hero, lien ancre uniquement)
3. "Sécuriser mon territoire" (sur carte Annuel dans la section pricing)

---

#### P3.2 — CTA finale homepage
**Fichier :** dernière section de `src/pages/index.astro`

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

#### P3.3 — Meta titles et descriptions SEO
**Fichiers :** `src/pages/index.astro`, `src/pages/tarifs.astro`, `src/pages/realisations.astro`

```
Homepage :
<title>Écosystème Immo — Système d'acquisition local pour conseillers immobiliers</title>
<description>Site + SEO local + CRM + automatisations IA. Exclusif à votre territoire. Un seul conseiller par ville. Vérifiez si votre ville est disponible.</description>

/tarifs :
<title>Offres Écosystème Immo — 27 €/mois à 897 €/an | Exclusivité territoriale incluse</title>
<description>Estimateur 27€/mois, Mensuel 97€/mois, Annuel 897€/an. Setup clé en main. Exclusivité sur votre territoire. Un seul conseiller par ville.</description>

/réalisations :
<title>Territoires déployés — Écosystème Immo | Bordeaux, Nantes, Aix, Lannion, Nandy</title>
<description>5 systèmes d'acquisition locaux installés. Ces territoires sont complets. Vérifiez si votre ville est encore disponible.</description>
```

---

#### P3.4 — Mobile : vérifications spécifiques
Points à valider sur téléphone avant la mise en ligne :

1. Barre de scarcité : lisible sans scroll horizontal, texte entier visible
2. Hero H1 : `font-size` ≥ 28px, pas de coupure de mot gênante
3. Cards pricing : stack vertical, pas de débordement horizontal
4. CTA "Vérifier ma ville" : height ≥ 48px, largeur ≥ 80% de l'écran
5. Badge "TERRITOIRE COMPLET" : lisible sur les cards /réalisations
6. Navigation simplifiée : menu hamburger propre, 5 liens max

---

## Ordre d'exécution recommandé

```
JOUR 1 (3-4h) — Phase 1 complète :

  [1] P1.5 — Bug prompt injection (15 min) → risque immédiat, action gratuite
  [2] P1.1 — Barre de scarcité (20 min) → visible sur 100% des pages
  [3] P1.3 — Navigation 5 liens (45 min) → réduit la dispersion immédiatement
  [4] P1.2 — Hero H1 + CTA unique (30 min) → message principal recadré
  [5] P1.4 — Pricing réel sur /tarifs (90 min) → déblocage de la conversion

  → Test mobile après chaque modification

JOUR 2 (2-3h) — Phase 2 :

  [6] P2.1 — Badges "Territoire complet" sur /réalisations (30 min)
  [7] P2.4 — Mention exclusivité sur homepage + /tarifs (20 min)
  [8] P2.2 — Corriger les 3 étapes "Comment ça marche" (30 min)
  [9] P2.3 — FAQ repositionnée + mise à jour copy (45 min)

JOUR 3 (1-2h) — Phase 3 :

  [10] P3.1 — Suppression CTAs parasites (30 min)
  [11] P3.2 — CTA finale homepage (20 min)
  [12] P3.3 — Meta titles SEO (30 min)
  [13] P3.4 — Validation mobile complète (30 min)
```

---

## Score projeté après chaque phase

| Après | Score | Déblocage principal |
|-------|-------|---------------------|
| Maintenant | 2/17 | — |
| Phase 1 | ~9/17 | Pricing visible, scarcité, nav simplifiée, CTA unique |
| Phase 2 | ~13/17 | Confiance, preuves, exclusivité communiquée |
| Phase 3 | ~16/17 | UX propre, SEO aligné, mobile premium |

---

## Fichiers à modifier (liste complète)

```
src/layouts/Layout.astro          → P1.1 barre de scarcité
src/components/Header.astro       → P1.3 navigation (ou équivalent)
src/components/Hero.astro         → P1.2 H1 + CTA (ou section hero dans index.astro)
src/pages/tarifs.astro            → P1.4 pricing réel + P3.3 meta
src/pages/realisations.astro      → P2.1 badges + P3.3 meta
src/pages/index.astro             → P2.2 process + P2.3 FAQ + P2.4 exclusivité + P3.1 CTAs + P3.2 CTA finale + P3.3 meta
src/components/[cookies].astro    → P1.5 prompt injection (nom exact à confirmer avec grep)
```

Si le framework n'est pas Astro, adapter les extensions (.vue, .tsx, .html, etc.).
La structure logique reste la même.

---

## Ce qu'il ne faut PAS faire

- Ne pas refactoriser l'architecture des pages pour intégrer ces changes
- Ne pas créer de nouvelles pages (ces modifications s'intègrent dans l'existant)
- Ne pas ajouter d'animations, transitions ou effets gadgets
- Ne pas toucher au design de base — seules la copy, la hiérarchie et les composants existants changent
- Ne pas ajouter de nouveaux disclaimers (les supprimer, pas les remplacer par d'autres)
- Ne pas déplacer l'Academy — juste supprimer son CTA de la homepage

---

*Document généré automatiquement — 2026-10-21*
*Copy source : COPY-CHANGES.md (validée le 2026-07-16)*
