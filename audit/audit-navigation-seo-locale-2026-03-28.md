# Audit stratégique — Navigation SEO locale (immobilier)

Date : 28 mars 2026
Périmètre audité : navigation globale (`header`, `footer`, routes publiques, blog, sitemap)

## 1) Diagnostic de la navigation SEO locale actuelle

## Ce qui fonctionne
- Le site met fortement en avant le levier local via le CTA « Vérifier ma ville » (header + mobile + footer).
- Le menu inclut « Villes », cohérent avec la promesse d’exclusivité territoriale.
- Le blog contient des sujets SEO local et estimation (ex. `seo-local`, `estimer-biens`).

## Points bloquants SEO local
1. **Menu principal orienté “produit SaaS” et non “intentions locales vendeurs”.**
   - Les entrées hautes sont : Accueil, Plateforme, Méthode, Modules, IA, Ressources, Villes.
   - Pour un objectif de domination locale, les ancres clés « Estimation », « Vendre [Ville] », « Quartiers », « Prix m² [Ville] » ne sont pas en navigation primaire.

2. **Absence de hubs locaux structurants dans la navigation.**
   - Pas de rubrique “Secteurs / Quartiers” dans le menu.
   - Pas de rubrique “Estimation immobilière” dédiée dans le menu.
   - Pas de séparation claire entre “blog expertise” et “blog local transactionnel”.

3. **Le “Blog” est peu exploité comme cluster local.**
   - Le blog agrège des sujets généraux (CRM, automation, ads, email), utiles business mais peu transactionnels localement.
   - Faible visibilité de parcours internes explicites : Article local → Estimation → RDV vendeur.

4. **Risque de dilution du PageRank interne vers des pages non prioritaires localement.**
   - Menu principal accorde un poids élevé à des pages de présentation SaaS (Plateforme, Méthode, Modules, IA).
   - Les pages à forte valeur “capture vendeur local” ne bénéficient pas d’un niveau de prominence équivalent.

5. **Logique locale incomplète entre navigation, routage et sitemap.**
   - Le sitemap expose surtout pages corporate + blog, sans taxonomie explicite “ville > quartier > estimation”.
   - Le routage ne montre pas de modèle de pages “secteur/quartier” ou “estimation ville” indexables à grande échelle.

## 2) Évaluation par critère demandé

### a) Logique locale du menu
- **Note actuelle : 5/10.**
- Le message local est présent (villes/exclusivité), mais la structure de liens n’épouse pas encore les requêtes immobilières locales à fort volume/intention.

### b) Hiérarchisation des liens
- **Note actuelle : 4/10.**
- Les liens “produit” dominent la barre principale ; les liens transactionnels locaux sont secondaires ou absents.

### c) Présence des pages à forte valeur SEO
- **Note actuelle : 3/10.**
- Manquent en navigation principale :
  - hub estimation,
  - hubs secteurs/quartiers,
  - hubs contenu local par ville,
  - pages vendeur locales (ex. “Vendre à [Ville]”).

### d) Cohérence objectifs vendeurs / estimation / visibilité locale
- **Note actuelle : 4/10.**
- L’intention “devenir référent local” est bien exprimée, mais le maillage/menu n’organisent pas encore un tunnel SEO local clair et répétable.

### e) Opportunités de sous-menus / liens contextuels
- **Potentiel : 9/10.**
- Le site peut rapidement gagner en performance locale avec 3 hubs (Estimation, Secteurs, Blog local) + sous-navigation contextuelle.

## 3) Pages à mettre dans le menu principal (priorité SEO locale)

## Doivent figurer dans le menu principal (desktop)
1. **Estimation** (hub prioritaire)
   - URL cible : `/estimation-immobiliere` (ou `/estimation`)
   - Rôle : page mère de conversion + distribution vers pages estimation par ville.

2. **Villes / Secteurs** (hub local)
   - URL cible : `/villes` puis sous-arborescence `/ville/{slug}`.
   - Rôle : capter requêtes géolocalisées et distribuer vers quartiers.

3. **Quartiers** (ou sous-menu de Villes)
   - URL cible : `/ville/{slug}/quartiers`.
   - Rôle : capter longue traîne locale très qualifiée.

4. **Vendre** (hub transaction vendeur)
   - URL cible : `/vendre` puis `/vendre-{ville}`.
   - Rôle : faire correspondre intention vendeur + ville + preuve locale.

5. **Blog local** (pas “Blog” générique)
   - URL cible : `/blog-local`.
   - Rôle : cluster informationnel local connecté aux pages estimation/secteurs.

6. **CTA permanent : Estimer mon bien / Vérifier ma ville**
   - CTA sticky en header : conversion directe.

## Peuvent sortir du menu principal (aller en secondaire/footer)
- Plateforme
- Méthode
- Modules
- Assistant IA
- Ressources (guides evergreen)

> Ces pages restent importantes pour la vente de l’offre, mais elles ne doivent pas capter la majorité du jus de liens de niveau 1 si l’objectif prioritaire est la domination SEO locale transactionnelle.

## 4) Structure de menu recommandée (plus efficace SEO locale)

### Proposition cible (niveau 1)
- **Estimation**
- **Vendre**
- **Villes & Quartiers**
- **Blog local**
- **Preuves locales** (avis, études de cas, positions Google)
- **[CTA] Estimer mon bien**

### Sous-menus recommandés

#### Estimation
- Estimation en ligne
- Estimation appartement
- Estimation maison
- Estimation par ville (top villes)
- Comment fonctionne l’estimation

#### Villes & Quartiers
- Villes couvertes
- Pages ville (A → Z)
- Quartiers populaires (top liens internes)
- Prix m² par quartier
- Délais de vente locaux

#### Blog local
- Prix immobilier local
- Vendre dans [Ville]
- Quartiers à surveiller
- Actualités urbanisme/locales
- Guides vendeur local

## 5) Renforcement des pages “Estimation”

1. Créer un **hub estimation unique** (niveau 1) avec liens vers :
   - estimation par type de bien,
   - estimation par ville,
   - estimation par quartier,
   - preuve méthodologique + FAQ locale.

2. Mettre en place des **ancres internes normalisées** depuis le menu et le contenu :
   - “Estimation immobilière [Ville]”
   - “Estimer mon appartement à [Ville]”
   - “Avis de valeur [Quartier]”.

3. Ajouter des **blocs de maillage systématiques** sur chaque page estimation :
   - “Quartiers proches”
   - “Prix m² autour de vous”
   - “Vendre à [Ville] : étapes”.

4. Faire de la page estimation le **nœud central de conversion** :
   - menu + footer + liens contextuels blog + CTA intermédiaires.

## 6) Renforcement des pages “Secteurs / Quartiers”

1. Architecture conseillée :
   - `/ville/{slug}` (hub ville)
   - `/ville/{slug}/quartier/{slug}` (pages profondes)

2. Chaque page quartier doit linker vers :
   - estimation quartier,
   - estimation ville,
   - page vendre ville,
   - articles blog local liés.

3. Créer des **modules de navigation locale** visibles :
   - fil d’Ariane,
   - “Quartiers voisins”,
   - “Autres villes proches”,
   - “Derniers articles sur [Ville]”.

4. Prioriser les pages quartier dans le menu via sous-menu dynamique “Top quartiers” selon la ville focus.

## 7) Renforcement des pages blog locales

1. Séparer “blog local transactionnel” du blog marketing général.
2. Sur chaque article local, imposer 3 liens minimum :
   - vers estimation ville,
   - vers page quartier liée,
   - vers page vendre locale.
3. Ajouter en fin d’article un bloc “Continuer votre projet dans [Ville]”.
4. Catégoriser le blog par intention :
   - Vendre,
   - Estimer,
   - Quartier,
   - Prix m²,
   - Marché local.

## 8) Recommandation de maillage interne local (modèle opérationnel)

## Modèle “hub & spokes” recommandé
- **Hub 1 : Estimation** → spokes = pages estimation ville/quartier/type bien.
- **Hub 2 : Villes** → spokes = pages ville + pages quartier.
- **Hub 3 : Blog local** → spokes = articles locaux par intention.

## Règles de maillage
- Toute page quartier doit pointer vers **1 estimation + 1 vendre + 1 article local**.
- Tout article local doit pointer vers **1 page ville + 1 page estimation + 1 page quartier**.
- Toute page ville doit remonter vers **hub villes + hub estimation + hub blog local**.
- Footer : liens locaux prioritaires (top villes, top quartiers, estimation).

## 9) Hiérarchie de pages optimale (SEO local immobilier)

Niveau 1 (menu) :
- Estimation
- Vendre
- Villes & Quartiers
- Blog local
- Preuves locales

Niveau 2 :
- Estimation par ville / type de bien
- Pages ville (transactionnelles)
- Catégories blog locales

Niveau 3 :
- Pages quartier
- Articles longue traîne locale
- Pages “prix m² micro-zone”

Niveau 4 (contextuel, non menu) :
- FAQ hyperlocales
- Pages guides ciblées (écoles, transports, copro, fiscalité locale)

## 10) Priorités d’implémentation (90 jours)

### Sprint 1 (S1-S3)
- Refonte menu principal selon structure cible.
- Création hub Estimation + hub Villes & Quartiers + hub Blog local.
- Repositionnement des pages SaaS en navigation secondaire.

### Sprint 2 (S4-S7)
- Déploiement pages villes prioritaires + top quartiers.
- Gabarits de blocs de maillage contextuel (article ↔ estimation ↔ quartier).
- Harmonisation ancres internes et CTA “Estimer mon bien”.

### Sprint 3 (S8-S12)
- Enrichissement cluster blog local transactionnel.
- Optimisation des liens footer locaux.
- Pilotage via KPIs : impressions locales, clics SEO locaux, conversion estimation→RDV.

---

## Conclusion stratégique
La navigation actuelle soutient bien le discours de marque, mais **ne maximise pas encore la domination SEO locale transactionnelle**. Le gain principal viendra d’un menu recentré sur les intentions “Estimation / Vendre / Ville / Quartier / Blog local”, avec un maillage interne systémique orienté conversion vendeur.
