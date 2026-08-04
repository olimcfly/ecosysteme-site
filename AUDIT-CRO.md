# Audit CRO — Écosystème Immo
> Mis à jour le 2026-08-04 | Audit initial : 2026-07-16 | Site : ecosystemeimmo.fr

---

## SITUATION AU 2026-08-04 (6ème audit)

**ALERTE DÉPLOIEMENT — Code CRO corrigé en branche GitHub, non déployé en production.**

Le blocage n'est plus de l'ordre du développement : les principales corrections existent dans la branche
`codex/audit-et-optimisation-du-site-pour-conversion`. Le site live tourne encore sur l'ancienne version.

### CORRECTION CRITIQUE — Le framework n'est pas Astro

**Le site est en PHP (pas Astro)**. Les fichiers sont :
- `index.php` — Homepage
- `front/pages/tarifs.php` — Page tarifs/fondateur
- `front/pages/verifier-ma-ville.php` — Page vérification ville
- `includes/header.php` — Navigation + meta
- `includes/footer.php` — Footer
- `assets/css/style.css` — Styles

Toutes les références à `src/components/*.astro` et `src/pages/*.astro` dans ce document
sont à lire comme les fichiers PHP correspondants ci-dessus.

---

### ÉTAT LIVE vs BRANCHE au 04/08/2026

| Élément | Site live (ecosystemeimmo.fr) | Branche codex/audit-et-optimisation |
|---------|-------------------------------|--------------------------------------|
| H1 | "Écosystème Immo n'est pas un simple logiciel..." | "Devenez le conseiller référent de votre ville..." |
| CTA principal | "Tester 7 jours gratuitement" | "Vérifier si ma ville est disponible" |
| Pricing homepage | Aucun prix réel visible | 27€ / 97€ / 897€ présents |
| FAQ homepage | Absente | 10 questions présentes |
| Section "système en action" | Absente | Présente (7 étapes) |
| Comparatif positionnement | Absent | Présent |
| Villes fermées | Non listées de façon visible | Box rouge présente |
| Scarcity bar sticky | Absente | Absente (non corrigée) |
| Programme Fondateur | "OFFRE LIMITÉE, 10 conseillers" | "4 places encore disponibles" (toujours ouvert) |
| Disclaimer non-résultat | Présent sur /offre | À vérifier |

**Conclusion : le développement a été fait. Le déploiement n'a pas eu lieu.**

### Nouveaux problèmes détectés dans la branche (non corrigés)

**PF1 — Programme Fondateur toujours ouvert dans la branche**
`front/pages/tarifs.php` affiche : "Rejoignez le Programme Fondateurs" + "4 places encore disponibles"
Brief : fermé, 5 conseillers à 47€/mois à vie. La page doit indiquer "Places épuisées".

**PF2 — H1 de la branche encore perfectible**
"Devenez le conseiller référent de votre ville..." est meilleur que l'original mais toujours orienté aspiration.
Recommandation conservée : "Votre ville a une seule place disponible."

**PF3 — Barre scarcité sticky absente de la branche**
La branche liste les villes dans un bloc rouge dans la section exclusivité, mais pas en sticky bar.
La barre de scarcité persistante (top: 0, z-index: 100) n'existe dans aucune version.

**PF4 — Navigation de la branche encore trop chargée**
Branche : Accueil | Plateforme | Méthode | Modules | IA | Ressources | Villes = 7 liens + 2 CTA
Cible : 5 liens max + 1 CTA "Vérifier ma ville"

**PF5 — Badges "TERRITOIRE COMPLET" absents**
La section "Conseillers déjà en place" montre un badge vert "Déployé" — pas de badge rouge
"TERRITOIRE COMPLET" qui crée l'urgence et la preuve d'exclusivité.

---

## PLAN D'ACTION IMMÉDIAT (ordre strict)

---

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

## ÉTAT D'IMPLÉMENTATION — SUIVI CUMULÉ (04/08/2026)

**LECTURE DU TABLEAU** : deux colonnes — état sur le site live, état dans la branche GitHub non déployée.

| # | Action | Live au 04/08 | Branche codex/audit-et-optimisation | Priorité |
|---|--------|---------------|--------------------------------------|----------|
| 1 | Corriger le pricing | ABSENT — aucun prix réel | FAIT — 27€/97€/897€ présents | P0 deploy |
| 2 | Barre scarcité villes fermées | Absente | Absente — block rouge statique seulement | À faire |
| 3 | Badges "Territoire complet" réalisations | Absents | "Déployé" vert — pas "TERRITOIRE COMPLET" rouge | À faire |
| 4 | Réécrire H1 | Inchangé ("logiciel") | Partiellement — "Devenez le conseiller référent" | Améliorer |
| 5 | Unifier CTA principal | "Tester gratuitement" | "Vérifier si ma ville est disponible" | P0 deploy |
| 6 | Section "Comment ça marche" | Absente | Présente (7 étapes "système en action") | P0 deploy |
| 7 | FAQ homepage | Absente | 10 questions présentes | P0 deploy |
| 8 | Programme Fondateur — statut cohérent | "Ouvert" (prix variable) | "4 places encore disponibles" — TOUJOURS OUVERT | CRITIQUE |
| 9 | Simplifier CTAs | 5 CTAs actifs | 2 CTAs clairs | P0 deploy |
| 10 | Retirer disclaimer non-résultat /offre | Présent | Non vérifié | À vérifier |
| 11 | Barre sticky scarcité | Absente | Absente | À faire |
| 12 | Retirer emojis sections | Présents partout | Partiellement retirés | À compléter |
| 13 | Navigation simplifiée | 18+ liens | 7 liens (Plateforme, Méthode, Modules, IA...) | Améliorer |
| 14 | Simplifier footer | Non audité | Non audité | À faire |
| 15 | H1 page /offre différencié | Identique homepage | Non vérifié | À vérifier |
| 16 | Angers dans scarcity bar | Absent | Absent | À faire |
| 17 | Comparatif positionnement | Absent | FAIT — tableau présent | P0 deploy |

**Score site live : 0/17**
**Score branche : ~7/17 implémentés, non déployés**

**Blocage numéro 1 : déploiement de la branche `codex/audit-et-optimisation-du-site-pour-conversion`.**
Avant de continuer à développer, déployer ce qui existe.

**Blocage numéro 2 après déploiement :**
- `front/pages/tarifs.php` — Programme Fondateur à fermer explicitement
- `includes/header.php` — Sticky scarcity bar à ajouter
- `index.php` — Badges "TERRITOIRE COMPLET" rouges dans la section preuves

---

## NOTE ARCHITECTURALE (CORRIGÉE AU 04/08/2026)

**Le site est en PHP, pas Astro.** Structure réelle :
```
index.php                          → Homepage
includes/header.php                → Navigation, meta, styles nav
includes/footer.php                → Footer
front/pages/tarifs.php             → Page tarifs / Programme Fondateur
front/pages/verifier-ma-ville.php  → Page vérification ville (CTA principal)
front/pages/temoignages.php        → Réalisations / témoignages
assets/css/style.css               → Styles globaux
```

Aucune refonte de structure n'est nécessaire. Les modifications sont des substitutions
de texte et ajouts de blocs HTML dans les fichiers PHP correspondants.

Mobile-first : vérifier que la barre de scarcité, le H1, et le CTA hero sont visibles
sans scroll sur un écran 375px (iPhone SE). C'est le premier point de vérification
après chaque action de Phase 1.

---

*Audit mis à jour le 2026-08-04*
*6ème session. Découverte clé : ~7/17 corrections existent dans la branche GitHub mais ne sont PAS déployées. Le site live tourne encore sur l'ancienne version. Priorité absolue : déploiement de la branche `codex/audit-et-optimisation-du-site-pour-conversion`, puis fermeture du Programme Fondateur et ajout de la sticky scarcity bar.*
