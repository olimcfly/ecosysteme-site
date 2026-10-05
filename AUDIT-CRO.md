# Audit CRO — Écosystème Immo
> Mis à jour le 2026-10-05 | Audit initial : 2026-07-16 | Site : ecosystemeimmo.fr

---

## SITUATION AU 2026-10-05 (12ème session)

**DÉCISION STRATÉGIQUE CONFIRMÉE : retour au modèle SaaS. Brief de pricing réintégré.**

Deux jours après la 11ème session, le brief de pricing est reconfirmé :
le modèle cible reste le SaaS mensuel avec exclusivité territoriale — pas le one-shot.
La 12ème session acte ce choix et produit le plan d'exécution opérationnel à partir de zéro.

> **Note repo** : le dépôt git ne contient plus les fichiers source Astro (`src/`).
> Le site tourne sur Astro — les chemins de fichiers ci-dessous sont les cibles à reconstituer.
> Toute la copy est dans `COPY-CHANGES.md`, prête à intégrer.

---

### Brief de pricing réel (source Olivier Colas — confirmé 2026-10-05)

| Formule | Prix | Détail |
|---------|------|--------|
| Beta fondateur | 47 €/mois à vie | **Fermé** — à afficher comme "Places épuisées" |
| Estimateur seul | 27 €/mois | + 197 € setup unique |
| Mensuel standard | 97 €/mois | + 497 € setup + 3 mois prépayés **[RECOMMANDÉE]** |
| Annuel | 897 €/an | Setup offert · ≈ 74 €/mois **[MEILLEURE VALEUR]** |
| Exclusivité verrouillée | 900 € | Paiement unique · verrou territorial à vie |

**Villes fermées** : Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion

---

### Diagnostic au 05/10 — Score : ~3/17 (inchangé vs 03/10)

Le site est en décalage total avec le brief. Blocages critiques actifs :

**CRITIQUE — bloquent la conversion aujourd'hui**

| Ref | Problème | État |
|-----|----------|------|
| CR1 | **Pricing SaaS absent** | Le site affiche 1 790 €/3 990 € HT (one-shot). Les formules 27/97/897 € sont introuvables. |
| CR2 | **CTA sans urgence territoriale** | "Analyser mon acquisition" ≠ "Vérifier si ma ville est disponible". Aucun mécanisme de qualification ni d'urgence. |
| CR3 | **Exclusivité territoriale absente** | Le différenciateur #1 ("1 ville = 1 conseiller") a disparu de toutes les pages. |
| CR4 | **Barre de scarcité absente** | Semaine 12 consécutive. Bordeaux · Nantes · Nandy · Aix · Lannion : aucun signal de fermeture visible. |
| CR5 | **3 disclaimers de non-résultat** | "/tarifs : 3 × 'Aucun résultat garanti'". Annihile la confiance avant l'achat. |
| CR6 | **Programme Fondateur introuvable** | Ni "ouvert", ni "épuisé". La preuve sociale des 5 fondateurs est perdue. |

**FORT — affaiblissent la persuasion**

| Ref | Problème |
|-----|----------|
| FO1 | FAQ disparue de /tarifs (présente au 12/08 — régression) |
| FO2 | Badges "Territoire complet" absents sur /réalisations |
| FO3 | Système "Déployé/Activé/Validé" sans badge rouge — crée zéro urgence |
| FO4 | Section "Comment ça marche" non vérifiable (lien nav présent, contenu inconnu) |
| FO5 | Case studies sans résultats chiffrés |

---

### Plan d'exécution — 3 phases opérationnelles

#### PHASE 1 — Conversion immédiate (Jour 1-2)

**Priorité absolue** : remettre le pricing brief, l'exclusivité et la scarcité.

**Action 1 — Réécrire le H1 + sous-titre hero**
```
H1 : Votre ville a une seule place disponible.

Sous-titre :
Écosystème Immo installe votre système d'acquisition local — site professionnel,
SEO, Google Business, pages quartiers, CRM et automatisations IA.
Exclusif à votre territoire. Un seul conseiller par ville.
```
Fichier : `src/components/Hero.astro`

**Action 2 — Unifier le CTA principal**
```
Supprimer : "Analyser mon acquisition" comme CTA primaire
CTA unique : "Vérifier si ma ville est disponible" → ancre #verifier
CTA secondaire : "Comment ça marche" → ancre #process
```
Fichiers : `src/components/Hero.astro`, `src/components/Header.astro`

**Action 3 — Barre de scarcité sticky (header global)**
```html
<div id="scarcity-bar" style="
  background:#0f172a; color:#f8fafc; text-align:center;
  padding:10px 20px; font-size:13px; letter-spacing:0.01em;
  position:sticky; top:0; z-index:100;
">
  Territoires complets : Bordeaux · Nantes · Nandy · Aix-en-Provence · Lannion
  &nbsp;—&nbsp;
  <a href="#verifier" style="color:#e2e8f0; text-decoration:underline; font-weight:500;">
    Vérifiez votre ville →
  </a>
</div>
```
Fichier : `src/layouts/Layout.astro`

**Action 4 — Pricing SaaS complet**
```
Formule Estimateur      : 27 €/mois + 197 € setup
Formule Mensuelle       : 97 €/mois + 497 € setup (3 mois prépayés) [RECOMMANDÉE]
Formule Annuelle        : 897 €/an — setup offert ≈ 74 €/mois      [MEILLEURE VALEUR]
Exclusivité verrouillée : 900 € paiement unique
Programme Fondateur     : Places épuisées — 5 conseillers à 47 €/mois à vie
```
Fichiers : `src/components/Pricing.astro`, `src/pages/tarifs.astro` (ou `/offre.astro`)

**Action 5 — Supprimer les disclaimers de non-résultat**
```
Supprimer les 3 occurrences : "Aucun résultat n'est garanti" / "Aucun nombre de
prospects/RDV/mandats n'est garanti" / "Budget pub non inclus" (en note, pas en disclaimer)

Remplacer par :
"Premiers contacts vendeurs observés sous 60 à 90 jours selon le territoire."
```
Fichier : `src/pages/tarifs.astro`

**Action 6 — Afficher le Programme Fondateur épuisé**
```
"Programme Fondateur — Places épuisées.
 Les 5 premiers conseillers ont rejoint à 47 €/mois à vie.
 Ces places sont définitivement fermées."
```
Fichier : `src/components/Pricing.astro`

---

#### PHASE 2 — Confiance et preuve sociale (Jour 3-5)

**Action 7 — Badges "Territoire complet" sur /réalisations**
```
Chaque carte client : badge rouge "TERRITOIRE COMPLET"

Bordeaux Métropole — Eduardo De Sul — Territoire complet
Aix-en-Provence — Pascal Hamm — Territoire complet
Nandy / Sénart — Fatima Rabia — Territoire complet
Lannion / Trégor — Stéphanie Hulen — Territoire complet
Nantes — Brice Chupin — Territoire complet

CTA section : "Ces territoires sont fermés. Le vôtre est peut-être encore disponible.
               [Vérifier ma ville]"
```
Fichiers : `src/components/Realisations.astro`, `src/pages/realisations.astro`

**Action 8 — Section "Comment ça marche" (3 étapes)**
```
H2 : Comment ça marche

Étape 01 — Vous vérifiez votre ville
Renseignez votre commune. Si elle est disponible, vous recevez une
confirmation et un brief personnalisé sous 24h.

Étape 02 — On installe votre système (en 21 jours)
Site, SEO local, Google Business, pages secteurs, CRM et automatisations.
Vous validez chaque étape. On livre clé en main.

Étape 03 — Votre territoire travaille pour vous
Les vendeurs de votre ville vous trouvent sur Google.
Les demandes arrivent directement dans votre CRM.

CTA : Vérifier si ma ville est disponible
```
Fichier à créer : `src/components/HowItWorks.astro`
Intégrer dans : `src/pages/index.astro` — après le Hero, avant Features

**Action 9 — FAQ sur la homepage (3 objections critiques)**
```
Q : Est-ce que je dois gérer le site moi-même ?
R : Non. On gère tout — maintenance, mises à jour, contenus SEO, Google Business.
    Vous recevez les demandes, on gère le système.

Q : En combien de temps je vois des résultats ?
R : Les premiers contacts vendeurs arrivent généralement sous 60 à 90 jours.
    Le référencement local se renforce sur 3 à 6 mois.

Q : Et si je change de réseau ou de secteur ?
R : Le domaine, le site et vos données vous appartiennent. Vous pouvez continuer
    indépendamment de votre réseau.
```
Fichier à créer : `src/components/FAQ.astro`
Intégrer dans : `src/pages/index.astro` — avant le CTA final

**Action 10 — Case studies avec livrables concrets**
```
Pour chaque territoire affiché : nommer ce qui a été livré (voir COPY-CHANGES.md)
Ex. Bordeaux : "Livré en 18 jours : site local, 6 pages secteurs, estimateur,
 3 articles SEO, séquence email vendeurs."
```
Fichiers : `src/components/Realisations.astro`

---

#### PHASE 3 — Finition UX, navigation, SEO (Jour 5-7)

**Action 11 — Supprimer les emojis restants**
```
Features : remplacer 🌐 📍 ⭐ 📝 📋 ✉️ par numéros 01-06 ou icônes SVG outline
```
Fichier : `src/components/Features.astro`

**Action 12 — Navigation : 5 liens + 1 CTA**
```
APRÈS : Accueil | Comment ça marche | Offres | Réalisations | Blog
CTA nav : [Vérifier ma ville]

Supprimer : Academy, "Comment ça marche" (si doublon), "Analyser mon acquisition",
            "À propos", "Ressources/Blog" → fusionner en "Blog"
```
Fichier : `src/components/Header.astro`

**Action 13 — Titre page /tarifs**
```
H1 : Un seul territoire. Un seul conseiller. Un système qui travaille pour vous.
```
Fichier : `src/pages/tarifs.astro`

**Action 14 — Simplifier le footer**
```
Écosystème Immo — Système d'acquisition local pour conseillers immobiliers indépendants.
Liens : Offres · Réalisations · Blog · Contact
Olivier Colas — 07 85 61 17 00 — contact@ecosystemeimmo.fr
Mentions légales | CGU | Confidentialité
© 2026 Écosystème Immo — OCDM Agency
```
Fichier : `src/components/Footer.astro`

---

### Ordre exact d'exécution

```
Jour 1
  1. src/layouts/Layout.astro          → Barre de scarcité sticky
  2. src/components/Hero.astro         → H1 + sous-titre + CTA unifié
  3. src/components/Header.astro       → CTA "Vérifier ma ville", retirer "Analyser"
  4. src/components/Pricing.astro      → Pricing SaaS complet + Fondateur épuisé
  5. src/pages/tarifs.astro            → Pricing + supprimer 3 disclaimers + H1

Jour 2
  6. src/pages/realisations.astro      → Badges "Territoire complet"
  7. src/components/Realisations.astro → Descriptions livrées + CTA section

Jour 3–4
  8. src/components/HowItWorks.astro   → Créer (3 étapes)
  9. src/pages/index.astro             → Intégrer HowItWorks après Hero
 10. src/components/FAQ.astro          → Créer (3 questions)
 11. src/pages/index.astro             → Intégrer FAQ avant CTA finale

Jour 5–7
 12. src/components/Features.astro     → Supprimer emojis → numéros 01-06
 13. src/components/Header.astro       → Navigation 5 liens + CTA (finaliser)
 14. src/pages/tarifs.astro            → Titre H1 différencié
 15. src/layouts/Layout.astro          → Vérifier Angers dans scarcity bar
 16. src/components/Footer.astro       → Simplifier
```

---

### Liste des fichiers à modifier

| Fichier | Actions | Phase |
|---------|---------|-------|
| `src/layouts/Layout.astro` | Barre scarcité sticky | P1 |
| `src/components/Hero.astro` | H1, sous-titre, CTA | P1 |
| `src/components/Header.astro` | CTA nav + nav simplifiée | P1 + P3 |
| `src/components/Pricing.astro` | Pricing SaaS + Fondateur épuisé | P1 |
| `src/pages/tarifs.astro` | Pricing + 3 disclaimers supprimés + H1 | P1 + P3 |
| `src/pages/realisations.astro` | Badges territoire complet | P2 |
| `src/components/Realisations.astro` | Descriptions livrées + CTA section | P2 |
| `src/components/HowItWorks.astro` | Créer — 3 étapes | P2 |
| `src/components/FAQ.astro` | Créer — 3 objections | P2 |
| `src/pages/index.astro` | Intégrer HowItWorks + FAQ | P2 |
| `src/components/Features.astro` | Emojis → numéros 01-06 | P3 |
| `src/components/Footer.astro` | Simplifier | P3 |

> Copy complète dans `COPY-CHANGES.md`. Aucune refonte d'architecture nécessaire.
> Toutes les modifications sont des substitutions de texte + ajout de 2 composants.
> Mobile-first : vérifier que scarcity bar, H1 et CTA hero sont visibles sans scroll sur 375px.

---

### Tableau de suivi — état au 05/10

| # | Action | Statut | Notes |
|---|--------|--------|-------|
| 1 | Pricing SaaS (27/97/897€) | **NON FAIT** | Site affiche 1790/3990€ one-shot |
| 2 | Barre scarcité villes fermées | **NON FAIT** | Semaine 12 consécutive |
| 3 | Badges "Territoire complet" réalisations | **NON FAIT** | Statut "Déployé" sans badge rouge |
| 4 | H1 "Votre ville a une seule place disponible" | **NON FAIT** | H1 actuel orienté douleur mais pas exclusivité |
| 5 | CTA "Vérifier si ma ville est disponible" | **NON FAIT** | CTA actuel "Analyser mon acquisition" |
| 6 | Exclusivité territoriale dans hero | **NON FAIT** | Absente du site |
| 7 | Programme Fondateur épuisé affiché | **NON FAIT** | Introuvable sur le site |
| 8 | Supprimer 3 disclaimers non-résultat | **NON FAIT** | 3 occurrences sur /tarifs |
| 9 | Section "Comment ça marche" | **PARTIEL** | Lien nav présent — contenu non confirmé |
| 10 | FAQ homepage | **NON FAIT** | Absente homepage ET /tarifs |
| 11 | Case studies avec livrables | **NON FAIT** | Tous en "Déployé" uniquement |
| 12 | Supprimer emojis | **FAIT** | Maintenu depuis 12/08 |
| 13 | Navigation simplifiée | **PARTIEL** | 9 liens (mieux que 18), cible : 5 + CTA |
| 14 | Titre H1 /tarifs différencié | **PARTIEL** | Titre présent, modèle incompatible |
| 15 | Footer simplifié | **NON VÉRIFIÉ** | — |
| 16 | Angers dans scarcity bar | **NON FAIT** | Scarcity bar absente |

**Score au 05/10 : ~3/17. Décision stratégique : retour au modèle SaaS confirmé.**

---

*Audit 12ème session — 2026-10-05*
*Décision actée : modèle SaaS mensuel (27/97/897€) + exclusivité territoriale = brief final.*
*Le modèle one-shot (1790/3990€ HT) est abandonné. Plan d'exécution Phase 1 à démarrer immédiatement.*
*Prochaine vérification : 7 à 10 jours après démarrage Phase 1.*

---

## SITUATION AU 2026-10-03 (11ème audit)

**ALERTE : DEUXIÈME PIVOT MAJEUR — Modèle économique changé. Score ~3/17. 4 nouvelles régressions.**

Entre le 12/08 et le 03/10 (7 semaines), le site a subi un pivot complet du modèle économique.
Le passage d'un SaaS par abonnement mensuel (27-97-897€/mois) vers une offre projet one-shot
(1 790€ - 3 990€ HT) est un changement de nature — plus un ajustement de copy.
**Ce pivot invalide l'intégralité du brief de pricing fourni.**

### Observations au 03/10

**Homepage — NOUVEAU POSITIONNEMENT (3e architecture en 11 semaines)**
- H1 : "Arrêtez de courir après votre prochaine opportunité vendeur."
- Sous-titre : "ÉcosystèmeImmo construit autour de votre activité un système d'acquisition immobilier capable d'attirer, suivre et faire mûrir vos prospects vendeurs"
- CTAs : "Analyser mon acquisition" · "Découvrir ÉcosystèmeImmo" · "Accéder gratuitement à l'Academy" · "Voir une démonstration" — 4 CTAs (amélioration vs 10+ au 12/08)
- Navigation : Accueil · Essentiel · Complet · Academy · Comment ça marche · Tarifs · À propos · Ressources/Blog · Analyser mon acquisition — 9 liens (simplification réelle)
- **Aucune mention de l'exclusivité territoriale** ("1 ville = 1 conseiller" a disparu)
- **Pas de barre de scarcité** (inchangé — semaine 11 consécutive)
- **Disclaimer toujours présent** : "Aucun nombre de prospects, de rendez-vous ou de mandats n'est garanti."
- Aucun emoji visible (maintenu)

Analyse : le H1 est orienté douleur ("Arrêtez de courir...") — meilleur angle client que le H1 précédent. Mais le concept d'exclusivité territoriale, principal différenciateur du brief, a entièrement disparu du site. Le CTA principal "Analyser mon acquisition" est plus froid que "Vérifier si ma ville est disponible" — il n'active aucune urgence.

**Page /tarifs — PRICING ENTIÈREMENT REFONDU (modèle incompatible avec le brief)**
- H1 : "Des prix clairs. Vous choisissez jusqu'où vous voulez déléguer."
- **Nouveau modèle prix (one-shot / projet) :**
  - Academy : 0 € (accès gratuit)
  - Essentiel : 1 790 € HT (ou 3 × 600 € HT)
  - Complet : 3 990 € HT (ou 3 × 1 350 € HT)
  - Maintenance : 197 € HT/mois (optionnel)
  - Gestion pub : 590 € HT setup + 490 € HT/mois (optionnel)
- **INCOMPATIBLE avec le brief** : le brief décrit 27€/97€/897€/mois — ces tarifs ont disparu
- Le modèle n'est plus SaaS par abonnement — c'est une prestation de service one-shot
- **3 disclaimers** : "Aucun résultat n'est garanti" · "Budget pub non inclus" · "Aucun nombre de prospects/RDV/mandats n'est garanti"
- **Aucune FAQ** sur cette page (régression — FAQ présente au 12/08)

**Page /realisations — RÉGRESSION**
- H1 : "Des systèmes d'acquisition déjà déployés dans plusieurs villes." (inchangé)
- **5 clients affichés** (Eric Verneau / Angers toujours absent — disparu depuis le 12/08)
- Nouveau système de statut : Déployé / Activé / Validé
- **Tous les clients en statut "Déployé" uniquement** — aucun "Activé", aucun "Validé"
- "Votre ville · À auditer" en dernière carte
- **Aucun badge "Territoire complet"** (inchangé)
- Aucune mention des territoires fermés (Bordeaux · Nantes · Nandy · Aix · Lannion)
- CTAs dirigent vers "/audit" (cohérent avec le pivot "analyser mon acquisition")

### Score au 03/10 : ~3/17 (en baisse vs 4/17 au 12/08)

Blocages critiques persistants :
1. **CR6 — Barre de scarcité absente** (semaine 11 consécutive — jamais implémentée)
2. **CR5 — Disclaimer non-résultat** : 3 occurrences sur /tarifs
3. **CR7 (NOUVEAU) — Pivot modèle économique** : tarifs incompatibles avec le brief
4. **CR8 (NOUVEAU) — Exclusivité territoriale absente** : le différenciateur #1 a disparu du site

---

## SITUATION AU 2026-08-12 (10ème audit)

**~4/17 actions. PIVOT STRATÉGIQUE MAJEUR. 3 nouvelles régressions critiques.**

Le site a subi une refonte complète de positionnement entre le 11/08 et le 12/08.
L'angle "exclusivité territoriale / 1 ville = 1 conseiller" a été abandonné au profit
d'une nouvelle architecture "méthode PACTE". C'est le changement le plus significatif
depuis l'ouverture de cet audit.

### Observations au 12/08

**Homepage — PIVOT COMPLET**
- H1 : "Transformez votre visibilité locale en rendez-vous avec des propriétaires vendeurs"
- Sous-titre : "De la visibilité au mandat, un seul système d'acquisition locale."
- **CTA principal : "Recevoir l'audit de mon secteur"** (abandon du CTA "Vérifier si ma ville est disponible")
- CTA secondaire : "Voir le système en démonstration"
- Navigation : Accueil · La méthode · Tarifs · Audit de secteur · Contact · Demander mon audit
- **Aucun prix visible sur la homepage** (inchangé)
- **Pas de barre de scarcité** (inchangé — semaine 8)
- Aucun emoji visible (maintenu)
- Nouvelle architecture en sections : "méthode PACTE" (P·A·C·T·E) + 9 étapes "parcours" + 5 sections de démonstration
- **10+ CTAs** : "Voir l'étape P →" · "Voir l'étape A →" · "Voir l'étape C →" · "Voir l'étape T →" · "Voir l'étape E →" · "Découvrir la méthode PACTE" · "Voir la démonstration complète" · "Découvrir la plateforme" · "Voir les déploiements et résultats" · "Comparer les formules"

Analyse du pivot : le site bascule d'un pitch B2B scarcité/exclusivité vers un pitch "méthodologie d'expert". La méthode PACTE (Propriétaires · Acquisition · Capture · Traitement · Évaluation) ajoute de la complexité là où le brief demandait de la clarté. Le CTA "audit de secteur" remplace la vérification de ville disponible — l'urgence territoriale est évaporée.

**Page /tarifs (ex-/offre) — PRIX ENFIN VISIBLES, MAIS PROBLÈMES MAJEURS**
- H1 : "Une plateforme complète. Un tarif adapté à votre activité."
- **Pricing enfin visible** (1ère fois en 8 semaines) :
  - Offre Fondateur : 47 €/mois (pour les 50 premiers) — **TOUJOURS OUVERTE** (brief : fermée à 5)
  - Solo : 97 €/mois
  - Pro : 197 €/mois
  - Agence : 997 €/mois + 1 997 € setup
  - Secteur supplémentaire : 49 €/mois
  - Done With You : 400 €/mois + 490 € setup
  - Done For You : 1 400 €/mois + 990 € setup
- **NOUVEAU DISCLAIMER CRITIQUE** : "Le secteur ne constitue pas automatiquement une exclusivité commerciale" — tue le principal différenciateur du brief
- Disclaimers persistants : "Aucun nombre de leads, rendez-vous ou mandats garanti" · "Aucune position Google ni délai de résultat ne sont garantis."
- FAQ présente : 6 questions (progrès)
- CTAs : "Demander mon audit de secteur" (×2) + "Demander votre audit"

**Page /realisations — inchangée**
- H1 : "Des systèmes d'acquisition déjà déployés dans plusieurs villes."
- 5 clients affichés : Brice Chupin (Nantes), Fatima Rabia (Nandy), Stéphanie Hulen (Lannion), Pascal Hamm (Aix-en-Provence), Eduardo De Sul (ville non précisée)
- Eric Verneau (Angers) disparu de la page (régression)
- **Aucun badge "Territoire complet"** (inchangé)
- CTAs : "Voir ce qu'il faut construire sur mon secteur →" · "Faire mesurer mon secteur"
- Dernière carte : "Votre ville · À auditer" — cohérent avec le nouveau pivot, incohérent avec le brief

### Score au 12/08 : ~4/17 (en baisse vs 5/17 au 11/08)

Progrès :
- Prix enfin visibles sur /tarifs (CR1 partiellement résolu — mais structure différente du brief)
- FAQ présente sur /tarifs (FO7 partiellement résolu — absente de la homepage)
- Aucun emoji (maintenu)

Régressions majeures :
- **RÉGRESSION STRATÉGIQUE** : abandon de l'exclusivité territoriale comme argument principal
- **RÉGRESSION CR5** : nouveau disclaimer "Le secteur ne constitue pas automatiquement une exclusivité commerciale" — contradictoire avec le positionnement
- **RÉGRESSION CR3** : 10+ CTAs sur la homepage (record absolu)
- **RÉGRESSION FO3** : Offre Fondateur ouverte pour 50 conseillers (brief : fermée à 5 fondateurs)
- **RÉGRESSION** : Eric Verneau (Angers) disparu de /realisations
- **RÉGRESSION H1** : nouveau H1 plus générique que le précédent ("Les vendeurs de votre ville cherchent sur Google...")

Blocages critiques persistants :
1. **CR6 — Barre de scarcité absente** (semaine 8 consécutive)
2. **CR5 — Disclaimers renforcés** : 3 avertissements dont un qui contredit l'exclusivité
3. **FO3 — Fondateur incohérent** : brief dit 5 fondateurs fermés, live dit 50 premiers ouverts
4. **CR3 — Dilution CTA** : 10+ CTAs sans hiérarchie claire

### Alerte stratégique

Le pivot vers "méthode PACTE" est un changement d'architecture de persuasion complet.
L'hypothèse testée : vendre une expertise méthodologique plutôt qu'une exclusivité territoriale.
Risques identifiés :
- La méthode PACTE crée de la complexité cognitive là où le brief voulait de la clarté radicale
- L'abandon du CTA "Vérifier si ma ville est disponible" supprime le principal mécanisme de qualification et d'urgence
- "Audit de secteur" comme CTA principal déplace l'entrée entonnoir vers une étape plus froide
- Le disclaimer "Le secteur ne constitue pas automatiquement une exclusivité commerciale" contredit directement la valeur fondamentale vendue
- 7 formules de pricing vs 4 dans le brief — risque de paralysie du choix

---

## SITUATION AU 2026-08-11 (9ème audit)

**~5/17 actions (inchangé). 1 nouveauté. Blocages critiques semaine 7.**

Des modifications mineures ont eu lieu entre le 10/08 et le 11/08.

### Observations au 11/08

**Homepage — 1 NOUVEAU CTA vidéo**
- H1 : "Les vendeurs de votre ville cherchent sur Google. Aujourd'hui, ils trouvent quelqu'un d'autre." (inchangé)
- Sous-titre : "Notre métier : faire que ce soit vous qu'ils trouvent." (inchangé)
- CTA dominant : "Vérifier si ma ville est encore libre →" (inchangé)
- **NOUVEAU CTA** : "Voir la vidéo (9 minutes)" — ajouté entre le CTA principal et "Voir la méthode en détail →"
- Navigation : 5 liens — Accueil · La méthode · Villes disponibles · Blog · Vérifier ma ville (inchangé)
- Aucun emoji visible (inchangé)
- **Pas de prix · Pas de barre de scarcité** (inchangés — semaine 7 consécutive)

Analyse du CTA vidéo : une vidéo de 9 minutes comme CTA secondaire peut qualifier les prospects mais risque de diluer le flux vers le CTA principal. À surveiller : est-ce un levier de confiance ou une fuite d'attention avant conversion ?

**Page /offre — inchangée (régression double disclaimer confirmée)**
- H1 : "Ce que nous installons, dans l'ordre où ça produit des résultats." (inchangé)
- **Aucun prix affiché** (inchangé — blocage critique semaine 7)
- **Double disclaimer toujours présent** : (1) "nous ne promettons ni délai ni volume de mandats" + (2) "Aucun volume de contacts n'est promis : il dépend du secteur, du budget et du marché." — régression confirmée semaine 2 consécutive
- Aucune FAQ

**Page /realisations — inchangée**
- H1 : "Des conseillers indépendants, déjà accompagnés"
- 6 clients : Eduardo De Sul (Bordeaux), Pascal Hamm (Aix), Stéphanie Hulen (Lannion), Brice Chupin (Nantes), Fatima Rabia (Nandy), Eric Verneau (Angers)
- **Aucun badge "Territoire complet"** (inchangé)
- CTAs nav secondaires encore visibles : "Diagnostic gratuit", "Simulation de financement", "Voir la démo" — pollution de navigation persistante

### Score au 11/08 : ~5/17 (inchangé)

1 nouveauté :
- CTA "Voir la vidéo (9 minutes)" ajouté sur la homepage

Les 3 blocages critiques persistent depuis 7 semaines :
1. **CR1 — Pricing absent** : aucun prix sur homepage ni /offre (semaine 7)
2. **CR6 — Scarcité bar absente** : Bordeaux · Nantes · Nandy · Aix · Lannion · Angers non signalés (semaine 7)
3. **CR5 — Double disclaimer** : toujours présent sur /offre (2e semaine consécutive de régression)

---

## SITUATION AU 2026-08-10 (8ème audit)

**~5/17 actions (inchangé en nombre). 1 changement positif. 1 régression critique.**

Des modifications ont eu lieu entre le 09/08 et le 10/08.

### Observations au 10/08

**Homepage — H1 CHANGÉ**
- H1 précédent (09/08) : "Un seul conseiller par bassin de vie"
- H1 actuel (10/08) : "Les vendeurs de votre ville cherchent sur Google. Aujourd'hui, ils trouvent quelqu'un d'autre."
- Sous-titre nouveau : "Notre métier : faire que ce soit vous qu'ils trouvent."
- Progrès réel : le H1 est désormais centré sur la douleur client (vendeurs qui trouvent quelqu'un d'autre), pas sur la marque. Différent du brief ("Votre ville a une seule place disponible.") mais orienté résultat.
- CTA dominant : "Vérifier si ma ville est encore libre →" (inchangé)
- Navigation : 5 liens — Accueil · La méthode · Villes disponibles · Blog · Vérifier ma ville (inchangé)
- Aucun emoji visible (inchangé)
- **Pas de prix · Pas de barre de scarcité** (inchangés — semaine 6 consécutive)

**Page /offre — RÉGRESSION**
- H1 : "Ce que nous installons, dans l'ordre où ça produit des résultats." (inchangé)
- **Aucun prix affiché** (inchangé — blocage critique semaine 6)
- **Double disclaimer désormais présent** : (1) "nous ne promettons ni délai ni volume de mandats" + (2) "Aucun volume de contacts n'est promis : il dépend du secteur, du budget et du marché." — RÉGRESSION par rapport au 09/08 (un seul disclaimer). Le message de non-résultat est maintenant répété deux fois.
- Aucune FAQ

**Page /realisations — inchangée**
- H1 : "Des conseillers indépendants, déjà accompagnés"
- 6 clients : Eduardo De Sul (Bordeaux), Pascal Hamm (Aix), Stéphanie Hulen (Lannion), Brice Chupin (Nantes), Fatima Rabia (Nandy), Eric Verneau (Angers)
- **Aucun badge "Territoire complet"** (inchangé)

### Score au 10/08 : ~5/17 (inchangé en nombre, régression qualitative)

Changement positif :
- H1 homepage plus client-centré (douleur vendeurs)

Régression :
- Double disclaimer sur /offre (CR5 aggravé)

Les 3 blocages critiques persistent depuis 6 semaines :
1. **CR1 — Pricing absent** : aucun prix sur homepage ni /offre (semaine 6)
2. **CR6 — Scarcité bar absente** : Bordeaux · Nantes · Nandy · Aix · Lannion · Angers non signalés (semaine 6)
3. **CR5 — Disclaimer non-résultat** : désormais doublé sur /offre (RÉGRESSION)

---

## SITUATION AU 2026-08-09 (7ème audit)

**5/17 actions exécutées (partiellement). Aucun changement depuis le 06/08.**

Aucune modification détectée entre le 06/08 et le 09/08.

### Observations au 09/08

**Homepage — inchangée**
- H1 : "Un seul conseiller par bassin de vie" (inchangé depuis 06/08)
- CTA dominant : "Vérifier si ma ville est encore libre →" (inchangé)
- Navigation : 5 liens — Accueil · La méthode · Villes disponibles · Blog · Vérifier ma ville (inchangé)
- Aucun emoji visible (inchangé)
- **Pas de prix · Pas de barre de scarcité** (inchangés — semaine 5 consécutive)

**Page /offre — inchangée**
- H1 : "Ce que nous installons, dans l'ordre où ça produit des résultats." (inchangé)
- **Aucun prix affiché** (inchangé — blocage critique semaine 5)
- **Disclaimer présent** : "nous ne promettons ni délai ni volume de mandats" (inchangé — semaine 5)
- Aucune FAQ

**Page /realisations — inchangée**
- 6 clients affichés : Eduardo De Sul (Bordeaux), Pascal Hamm (Aix), Stéphanie Hulen (Lannion), Brice Chupin (Nantes), Fatima Rabia (Nandy), Eric Verneau (Angers)
- **Aucun badge "Territoire complet"** (inchangé)
- CTA par client : "Voir le site →"
- CTA section : "Vérifier si ma ville est encore libre"

### Score au 09/08 : 5/17 (identique au 06/08)

Les 3 blocages critiques persistent depuis 5 semaines :
1. **CR1 — Pricing absent** : aucun prix sur homepage ni /offre
2. **CR6 — Scarcité bar absente** : Bordeaux · Nantes · Nandy · Aix · Lannion · Angers non signalés
3. **CR5 — Disclaimer non-résultat** : "nous ne promettons ni délai ni volume de mandats" toujours présent

---

## SITUATION AU 2026-08-06 (6ème audit)

**5/17 actions exécutées (partiellement). Premiers progrès réels depuis 4 semaines.**

Des changements significatifs ont eu lieu entre le 02/08 et le 06/08.

### Observations au 06/08

**Navigation — RÉSOLUE**
Navigation réduite à 5 liens : Accueil · La méthode · Villes disponibles · Blog · Vérifier ma ville.
Plus de "Diagnostic", "Méthode FOTO", "Financement", "Guides gratuits", etc. visibles en nav principale.
(Ils restent dans le footer — à simplifier en phase 3.)

**H1 — AMÉLIORÉ (partiel)**
Texte live : "Un seul conseiller par bassin de vie"
Sous-titre : "Les vendeurs de votre ville cherchent sur Google. Aujourd'hui, ils trouvent quelqu'un d'autre."
Progrès réel vs l'ancien H1 centré sur la marque. Pas exactement le brief mais client-centré et axé exclusivité.

**CTA principal — AMÉLIORÉ (partiel)**
CTA dominant désormais : "Vérifier si ma ville est encore libre →"
Cohérent sur toute la homepage. L'essai gratuit 7 jours a disparu.
CTA secondaire : "Voir la méthode en détail →" — acceptable.

**Section "Comment ça marche" — PRÉSENTE (partielle)**
Section visible : "Comment ça marche — Trois leviers, trois vitesses, une seule chaîne."
Contenu : 3 vitesses (3-6 mois articles / quelques semaines GBP / immédiat annonces).
Différent du brief (3 étapes process) mais la section existe.

**Emojis — RÉSOLUS**
Aucun emoji visible sur la homepage. Action 11 complète.

**Exclusivité dans le hero — PRÉSENTE**
"Un seul conseiller par secteur" et "Un seul conseiller par bassin de vie" visibles dans le hero.
FO1 (exclusivité en bas de page) partiellement résolu.

**Pricing — TOUJOURS ABSENT (CRITIQUE)**
Aucun prix visible sur la homepage ni sur /offre.
La page /offre affiche H1 : "Ce que nous installons, dans l'ordre où ça produit des résultats."
Aucune formule, aucun montant en euros. Blocage total de conversion — 3e semaine consécutive.

**Disclaimer non-résultat — TOUJOURS PRÉSENT (CRITIQUE)**
/offre : "nous ne promettons ni délai ni volume de mandats" — inchangé.

**Barre de scarcité — TOUJOURS ABSENTE (CRITIQUE)**
Aucune indication des villes fermées. Levier de conversion #1 toujours absent.

**Badges "Territoire complet" — TOUJOURS ABSENTS**
/realisations : 6 territoires listés dont Angers (Eric Verneau), mais aucun badge rouge.
Progression : Angers désormais listé (résout partiellement l'action 14/17).

**Programme Fondateur — STATUT AMBIGU**
Redirige vers un sous-domaine externe : fondateurs.ecosystemeimmo.fr
Pas de prix affiché ni de statut "places épuisées" sur le site principal.

**FAQ homepage — TOUJOURS ABSENTE**
Pas de FAQ visible sur la homepage.

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

| # | Action | Statut au 12/08 | Statut au 11/08 | Notes |
|---|--------|-----------------|-----------------|-------|
| 1 | Corriger le pricing | **PARTIEL** | Non fait | Pricing visible sur /tarifs — 7 formules (vs 4 dans le brief), absent de la homepage |
| 2 | Barre scarcité villes fermées | **NON FAIT** | Non fait | Toujours absente — semaine 8 |
| 3 | Badges "Territoire complet" réalisations | **NON FAIT** | Non fait | 5 clients affichés (Angers disparu), 0 badge |
| 4 | Réécrire H1 | **RÉGRESSION** | Amélioré | Nouveau H1 générique "Transformez votre visibilité..." — moins percutant qu'au 11/08 |
| 5 | Unifier CTA principal | **RÉGRESSION** | Partiel | 10+ CTAs homepage — record absolu depuis l'ouverture de l'audit |
| 6 | Ajouter IA/automatisations features | **NON CONFIRMÉ** | Non fait | Non confirmé visible |
| 7 | Simplifier CTAs | **RÉGRESSION** | Partiel | 10+ CTAs homepage — pire état |
| 8 | Case studies avec résultats | **NON FAIT** | Non fait | Pas de métriques, pas de livrables |
| 9 | Section "Comment ça marche" | **RÉGRESSION** | Partiel | Remplacée par méthode PACTE (5 étapes + 9 sous-étapes) — complexité accrue |
| 10 | FAQ homepage | **NON FAIT** | Non fait | FAQ sur /tarifs uniquement — absente de la homepage |
| 11 | Programme Fondateur — statut cohérent | **RÉGRESSION** | Incertain | Ouvert pour "50 premiers conseillers" à 47€ — brief : fermé à 5 fondateurs |
| 12 | Retirer emojis | **FAIT** | Fait | Aucun emoji visible (maintenu) |
| 13 | Modifier titre page /offre | **FAIT** | Partiel | Page renommée /tarifs avec nouveau H1 différencié |
| 14 | Nettoyer navigation | **PARTIEL** | Fait | Nav simplifiée mais différente du brief — "Tarifs" / "Audit de secteur" |
| 15 | Simplifier footer | **NON VÉRIFIÉ** | Non vérifié | Non vérifié |
| 16 | Retirer disclaimer non-résultat | **RÉGRESSION** | Régression | 3 disclaimers dont nouveau : "Le secteur ne constitue pas automatiquement une exclusivité commerciale" — CRITIQUE |
| 17 | Ajouter Angers dans scarcity bar | **NON FAIT** | Non fait | Scarcity bar absente + Angers retiré de /realisations |

**Score au 12/08 : ~4/17 (en baisse). Pivot stratégique majeur. 6 régressions.**
Actions complètes : emojis retirés (12), titre /tarifs différencié (13).
Actions partielles : pricing sur /tarifs (1), navigation (14).
Régressions : H1 (4), CTAs (5/7/9), Fondateur ouvert (11), disclaimer exclusivité (16).
Blocages critiques semaine 8 : barre scarcité (2), disclaimer anti-exclusivité (16), Fondateur incohérent (11), 10+ CTAs (5).

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

*Audit mis à jour le 2026-08-12*
*10ème session. ~4/17 actions (en baisse). Pivot stratégique majeur vers "méthode PACTE".*
*Progrès : pricing enfin visible sur /tarifs, FAQ présente sur /tarifs, aucun emoji maintenu.*
*Régressions majeures : H1 plus générique, 10+ CTAs, abandon de l'exclusivité territoriale, nouveau disclaimer anti-exclusivité, Fondateur ouvert pour 50 conseillers, Angers retiré des réalisations.*
*Alerte stratégique : le positionnement "1 ville = 1 conseiller" est en train d'être abandonné. Décision à trancher : confirmer le pivot PACTE ou revenir au brief d'exclusivité territoriale.*
*Priorité absolue : (1) supprimer le disclaimer "Le secteur ne constitue pas automatiquement une exclusivité commerciale" — il contre-argue la valeur principale. (2) trancher le positionnement PACTE vs exclusivité. (3) réduire à 1 CTA principal. (4) barre de scarcité si retour au brief.*
