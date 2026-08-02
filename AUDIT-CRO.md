# Audit CRO — Écosystème Immo
> Mis à jour le 2026-08-02 | Audit initial : 2026-07-16 | Site : ecosystemeimmo.fr

---

## SITUATION AU 2026-08-02 (5ème audit)

**0/17 actions exécutées. 3,5 semaines de dérive.**

Aucun changement depuis le 01/08. Nouvelle anomalie détectée sur le pricing.

### Nouvelles observations au 02/08

**Pricing — régression critique**
Le site ne montre plus aucun prix réel sur la homepage ni sur /offre.
L'offre affichée est désormais : "0 € pendant 7 jours, puis 1 € le 1er mois" — sans aucun tarif d'abonnement visible.
Les formules réelles (27€ / 97€ / 897€) sont absentes de toutes les pages accessibles.
C'est une régression par rapport à l'état du 01/08 où des prix (même incorrects) étaient au moins visibles.

**CTA principal — variante identique**
Texte live : "Tester 7 jours gratuits, puis 1 €" (légère variation de formulation, même problème)

**Angers confirmé sur /realisations**
Eric Verneau (Angers) est bien affiché sur la page réalisations.
Angers devra figurer dans la scarcity bar quand elle sera créée (action 14, déjà documentée).

Tout le reste : inchangé. Le site continue de diverger du brief fourni.

---

## PROBLÈMES CLASSÉS PAR IMPACT BUSINESS

### CRITIQUE — bloquent la conversion aujourd'hui

| Ref | Problème | Observation au 01/08 |
|-----|----------|----------------------|
| CR1 | **Pricing absent du site** | Live au 02/08 : "0€ / 7 jours puis 1€" uniquement. Aucun tarif réel visible. Brief : 27€/97€/897€. Le visiteur ne peut pas acheter sans voir de prix — blocage total de conversion. |
| CR2 | **Essai gratuit 7 jours en CTA principal** | "Tester gratuitement pendant 7 jours" = premier bouton visible. Annule l'exclusivité territoriale comme argument d'achat. Contradiction totale avec le positionnement premium. |
| CR3 | **5 CTAs sans hiérarchie** | "Tester gratuitement" · "Mon territoire est-il encore libre ?" · "Devenir partenaire fondateur" · "Vérifier la disponibilité" · "Vérifier si ma zone est disponible" → le visiteur ne sait pas quoi faire. |
| CR4 | **H1 centré sur la marque, pas le client** | "Écosystème Immo n'est pas un simple logiciel…" — commence par le nom de marque, posture défensive, aucune promesse client. |
| CR5 | **Disclaimer de non-résultat sur /offre** | "nous ne promettons ni délai ni volume de mandats" = annihile la confiance construite par le reste de la page. |
| CR6 | **Aucun élément de scarcité territoriale** | Pas de barre "Bordeaux · Nantes · Nandy · Aix · Lannion fermés". La scarcité est le principal levier de conversion — elle est absente. |

### FORT — affaiblissent la persuasion

| Ref | Problème | Observation au 01/08 |
|-----|----------|----------------------|
| FO1 | **Exclusivité présentée en bas de page** | "Une seule exclusivité par territoire" est un H2 en fin de page. C'est le différenciateur #1 — il doit être dans le H1. |
| FO2 | **Aucun badge "Territoire complet" sur /realisations** | 6 clients affichés sans statut de fermeture. Aucune urgence, aucune preuve sociale d'exclusivité. |
| FO3 | **Programme Fondateur — contradiction** | Brief : fermé, 47€/mois à vie. Live : ouvert, "OFFRE LIMITÉE 10 CONSEILLERS", 197€/mois + 997€ setup. Ces deux réalités sont incompatibles. |
| FO4 | **Section "Comment ça marche" absente** | Aucun visiteur ne comprend le process d'achat. 3 étapes claires manquantes entre le H1 et le pricing. |
| FO5 | **Case studies sans résultats** | 6 territoires affichés : "Site local, pages secteurs" — aucun chiffre, aucune métrique, aucun before/after. |
| FO6 | **IA et automatisations non mises en avant** | Mentionnées dans la liste de features mais pas présentées comme différenciateur fort. Or c'est une attente clé en 2026. |
| FO7 | **FAQ absente de la homepage** | Elle existe sur /offre depuis le 31/07 — elle doit être sur la homepage pour traiter les objections avant la page d'offre. |

### MOYEN — dégradent l'expérience et la crédibilité

| Ref | Problème | Observation au 01/08 |
|-----|----------|----------------------|
| MO1 | **Emojis partout** | 📉 🔗 🚫 🌐 📝 📍 ⭐ 📋 🎁 🚀 🔒 ✓ — ton "startup débutante", pas "système B2B premium" |
| MO2 | **Navigation surchargée** | Accueil · Offre · Avantages · Blog · Partenaires · Financement · Guides gratuits · Programme Fondateurs · Autres métiers · Vérifier votre zone · Offre et tarifs · Pourquoi · Méthode FOTO · À propos · Contact · Actualités · Diagnostic · Simulation financement = 18 destinations. Cible : 5 liens + 1 CTA. |
| MO3 | **Angers non listé dans les villes fermées** | Eric Verneau (Angers) affiché sur /realisations mais Angers absent de la scarcity bar et du brief. |
| MO4 | **Titre /offre identique à la homepage** | Même H1 sur les deux pages. La page offre doit avoir son propre titre orienté conversion. |
| MO5 | **"Système d'acquisition local" jamais nommé** | Le produit est décrit comme "logiciel" ou "plateforme" — jamais comme "système d'acquisition local". Pourtant c'est le positionnement du brief. |

### FAIBLE — à corriger en phase 3

| Ref | Problème |
|-----|----------|
| FA1 | Footer non audité — probablement trop chargé |
| FA2 | "Méthode FOTO" en nav — jargon interne, aucun sens pour un prospect |
| FA3 | "Autres métiers" en nav — hors scope, dilue le focus sur les conseillers indépendants |

---

## PLAN D'EXÉCUTION EN 3 PHASES

> Pricing de référence (brief fourni par Olivier Colas) :
> - Estimateur seul : 27€/mois + 197€ setup
> - Mensuel standard : 97€/mois + 497€ setup + 3 mois prépayés
> - Annuel : 897€/an, setup offert, exclusivité incluse
> - Exclusivité verrouillée : 900€ paiement unique
> - Programme Fondateur : 47€/mois à vie — **FERMÉ**, 5 places prises

---

### PHASE 1 — Conversion immédiate (1 à 2 jours)

Chaque action ci-dessous supprime un frein direct à la conversion.

**Action 1 — Réécrire le H1**
```
Avant : "Écosystème Immo n'est pas un simple logiciel. C'est votre système métier immobilier, clé en main."
Après : "Votre ville a une seule place disponible."
```
Fichier : `src/components/Hero.astro`

**Action 2 — Unifier le CTA principal**
```
Supprimer : "Tester gratuitement pendant 7 jours"
CTA unique : "Vérifier si ma ville est disponible" → ancre #verifier
```
Fichiers : `src/components/Hero.astro`, `src/components/Header.astro`

**Action 3 — Ajouter la barre de scarcité (sticky top)**
```html
<div id="scarcity-bar">
  Territoires complets : Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion
  — <a href="#verifier">Vérifiez votre ville →</a>
</div>
```
Style : fond #0f172a, texte #f8fafc, 13px, position sticky, z-index 100.
Fichier : `src/layouts/Layout.astro`

**Action 4 — Corriger le pricing**
```
Formule Estimateur      : 27€/mois + 197€ setup
Formule Mensuelle       : 97€/mois + 497€ setup (3 mois prépayés)  [RECOMMANDÉE]
Formule Annuelle        : 897€/an — setup offert ≈ 74€/mois        [MEILLEURE VALEUR]
Exclusivité verrouillée : 900€ paiement unique (verrou territorial à vie)
Programme Fondateur     : Places épuisées — 5 conseillers à 47€/mois à vie
```
Fichiers : `src/components/Pricing.astro`, `src/pages/offre.astro`

**Action 5 — Supprimer le disclaimer de non-résultat**
```
Supprimer : "nous ne promettons ni délai ni volume de mandats"
Remplacer par : "Premiers contacts vendeurs observés sous 60 à 90 jours selon le territoire."
```
Fichier : `src/pages/offre.astro`

**Action 6 — Clore le Programme Fondateur**
```
Avant : "OFFRE LIMITÉE — 10 PREMIERS CONSEILLERS" + 197€/mois
Après : "Programme Fondateur — Places épuisées.
         Les 5 premiers conseillers ont rejoint à 47€/mois à vie.
         Ces places sont fermées."
```
Fichier : `src/components/Pricing.astro`

---

### PHASE 2 — Confiance et preuve sociale (3 à 5 jours)

**Action 7 — Badges "Territoire complet" sur /realisations**
```
Chaque carte client → badge rouge "TERRITOIRE COMPLET"
Sous chaque nom : description de ce qui a été livré (voir COPY-CHANGES.md)
CTA section : "Ces territoires sont fermés. Le vôtre est peut-être encore disponible. [Vérifier ma ville]"
```
Fichiers : `src/components/Realisations.astro`, `src/pages/realisations.astro`

**Action 8 — Créer la section "Comment ça marche"**
```
Étape 01 : Vous vérifiez votre ville → confirmation + brief sous 24h
Étape 02 : On installe votre système (21 jours) → site, SEO, GBP, CRM, automatisations
Étape 03 : Votre territoire travaille pour vous → vendeurs sur Google → demandes dans CRM
CTA : "Vérifier si ma ville est disponible"
```
Fichier à créer : `src/components/HowItWorks.astro`
Intégrer dans : `src/pages/index.astro` (après le Hero, avant Features)

**Action 9 — Déplacer la FAQ sur la homepage**
```
3 questions (déjà rédigées dans COPY-CHANGES.md) :
Q : Est-ce que je dois gérer le site moi-même ?
Q : En combien de temps je vois des résultats ?
Q : Et si je change de réseau ou de secteur ?
```
Fichier à créer : `src/components/FAQ.astro`
Intégrer dans : `src/pages/index.astro` (avant la section CTA finale)

**Action 10 — Réécrire le sous-titre hero**
```
Écosystème Immo installe votre système d'acquisition local — site professionnel,
SEO, Google Business, pages quartiers, CRM et automatisations IA.
Exclusif à votre territoire. Un seul conseiller par ville.
```
Fichier : `src/components/Hero.astro`

---

### PHASE 3 — Finition, UX et SEO (1 semaine)

**Action 11 — Supprimer les emojis (features)**
```
Remplacer 📉 🔗 🚫 🌐 📝 📍 ⭐ 📋 🎁 🚀 🔒
Par : numéros 01–06 ou icônes SVG outline simples (stroke, pas fill)
```
Fichier : `src/components/Features.astro`

**Action 12 — Simplifier la navigation**
```
Avant : 18 liens
Après : Accueil | Comment ça marche | Offres | Réalisations | Blog + [Vérifier ma ville]
Supprimer : Avantages, Partenaires, Financement, Guides gratuits, Programme Fondateurs,
            Autres métiers, Vérifier votre zone (doublon), Offre et tarifs (doublon),
            Pourquoi, Méthode FOTO, Diagnostic, Simulation financement
```
Fichier : `src/components/Header.astro`

**Action 13 — Titre page /offre**
```
Avant : H1 identique à la homepage
Après : "Un seul territoire. Un seul conseiller. Un système qui travaille pour vous."
```
Fichier : `src/pages/offre.astro`

**Action 14 — Ajouter Angers dans la scarcity bar** (si territoire fermé)
```
"Territoires complets : Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion · Angers"
```
Fichier : `src/layouts/Layout.astro`

**Action 15 — Simplifier le footer**
```
Écosystème Immo — Système d'acquisition local pour conseillers immobiliers indépendants.
Liens : Offres · Réalisations · Blog · Contact
Olivier Colas — 07 85 61 17 00 — contact@ecosystemeimmo.fr
Mentions légales | CGU | Confidentialité
© 2026 Écosystème Immo — OCDM Agency
```
Fichier : `src/components/Footer.astro`

---

## ORDRE EXACT D'EXÉCUTION

```
Jour 1
  1. src/components/Hero.astro         → H1 + sous-titre + CTA unifié
  2. src/layouts/Layout.astro          → Barre de scarcité sticky
  3. src/components/Pricing.astro      → Pricing brief + clore Fondateur
  4. src/pages/offre.astro             → Pricing + supprimer disclaimer

Jour 2
  5. src/components/Header.astro       → Retirer "Tester gratuitement", CTA unique
  6. src/pages/realisations.astro      → Badges "Territoire complet"
  7. src/components/Realisations.astro → Descriptions livrées + CTA section

Jour 3–4
  8. src/components/HowItWorks.astro   → Créer (3 étapes)
  9. src/pages/index.astro             → Intégrer HowItWorks après Hero
 10. src/components/FAQ.astro          → Créer (3 questions)
 11. src/pages/index.astro             → Intégrer FAQ avant CTA finale

Jour 5–7
 12. src/components/Features.astro     → Supprimer emojis → numéros 01-06
 13. src/components/Header.astro       → Navigation 5 liens + CTA
 14. src/pages/offre.astro             → Titre H1 différencié
 15. src/layouts/Layout.astro          → Angers dans scarcity bar (si fermé)
 16. src/components/Footer.astro       → Simplifier
```

---

## LISTE COMPLÈTE DES FICHIERS À MODIFIER

| Fichier | Actions | Phase |
|---------|---------|-------|
| `src/layouts/Layout.astro` | Barre scarcité sticky | P1 |
| `src/components/Hero.astro` | H1, sous-titre, CTA | P1 |
| `src/components/Pricing.astro` | Pricing complet + Fondateur fermé | P1 |
| `src/pages/offre.astro` | Pricing + disclaimer + titre H1 | P1 + P3 |
| `src/components/Header.astro` | Retirer trial CTA + nav simplifiée | P1 + P3 |
| `src/components/Realisations.astro` | Badges + descriptions + CTA section | P2 |
| `src/pages/realisations.astro` | Badges + descriptions | P2 |
| `src/components/HowItWorks.astro` | Créer — 3 étapes | P2 |
| `src/components/FAQ.astro` | Créer — 3 objections | P2 |
| `src/pages/index.astro` | Intégrer HowItWorks + FAQ | P2 |
| `src/components/Features.astro` | Emojis → numéros, ajouter IA | P3 |
| `src/components/Footer.astro` | Simplifier | P3 |

Voir COPY-CHANGES.md pour tous les textes prêts à copier-coller.

---

## ÉTAT D'IMPLÉMENTATION — SUIVI CUMULÉ

| # | Action | Statut au 01/08 | Notes |
|---|--------|-----------------|-------|
| 1 | Corriger le pricing | Non fait | 5ème version : aucun prix réel visible. Régression vs 01/08. |
| 2 | Barre scarcité villes fermées | Non fait | Toujours absente |
| 3 | Badges "Territoire complet" réalisations | Non fait | 6 clients sans statut |
| 4 | Réécrire H1 | Non fait | Même H1 faible depuis le 31/07 |
| 5 | Unifier CTA principal | Non fait | 5 CTAs actifs, trial en premier |
| 6 | Ajouter IA/automatisations features | Non fait | Mentionné mais non mis en avant |
| 7 | Simplifier CTAs | Non fait | Empiré au fil des semaines |
| 8 | Case studies avec résultats | Non fait | Nom + ville uniquement |
| 9 | Section "Comment ça marche" | Non fait | Absente homepage |
| 10 | FAQ homepage | Non fait | Présente sur /offre uniquement (progression partielle) |
| 11 | Programme Fondateur — statut cohérent | Non fait | Brief : fermé 47€. Live : ouvert 197€. |
| 12 | Retirer emojis | Non fait | Toujours présents |
| 13 | Modifier titre page /offre | Non fait | H1 identique homepage |
| 14 | Nettoyer navigation | Non fait | 18 liens (empiré depuis juillet) |
| 15 | Simplifier footer | Non fait | Non audité |
| 16 | Retirer disclaimer non-résultat /offre | Non fait | Toujours en production |
| 17 | Ajouter Angers dans scarcity bar | Non fait | Eric Verneau affiché, Angers non listé |

**Score : 0/17 après 3,5 semaines.**
Régression sur CR1 : le pricing a disparu du site (ni correct ni incorrect — absent).
Une progression partielle sur la FAQ reste la seule évolution depuis le 16/07.

---

## NOTE ARCHITECTURALE

Le site est en **Astro**. L'architecture (Layout → pages → composants) est saine.
Aucune refonte de structure n'est nécessaire. Toutes les modifications ci-dessus
sont des substitutions de texte et ajouts de composants — elles peuvent être faites
indépendamment les unes des autres, dans l'ordre indiqué ci-dessus.

Mobile-first : vérifier que la barre de scarcité, le H1, et le CTA hero sont visibles
sans scroll sur un écran 375px (iPhone SE). C'est le premier point de vérification
après chaque action de Phase 1.

---

*Audit mis à jour le 2026-08-02*
*5ème session. 0/17 actions exécutées en 3,5 semaines. Régression sur CR1 (pricing disparu). Plan d'exécution en 15 étapes inchangé — toujours exécutable immédiatement.*
