# Plan CRO opérationnel — ecosystemeimmo.fr (28/03/2026)

## 1) Audit conversion (priorisé business)

### Critique
1. **Incohérence prix vs réalité commerciale**
   - La page tarifs affirme « pas de grille tarifaire » alors que l’offre réelle comporte des plans précis (27€, 47€, 97€, 897€, 900€ option exclusivité). 
   - Effet business : perte de confiance immédiate, baisse de qualification des leads.

2. **Message produit trop “outil” sur pages clés**
   - Le wording alterne entre plateforme/modules/SaaS, sans cadrer systématiquement « système d’acquisition local ».
   - Effet business : les indépendants immobiliers perçoivent une complexité technique plutôt qu’un résultat business (mandats vendeurs).

3. **Parcours principal dispersé (CTA concurrentiels)**
   - Sur l’accueil et tarifs, plusieurs CTA de même niveau (démo/contact/coaching/fondateur), ce qui dilue le CTA business principal : **vérifier la ville**.
   - Effet business : baisse du taux de passage vers l’étape d’intention forte (vérification territoriale).

4. **Bloc mobile potentiellement cassant sur la page de conversion**
   - La section formulaire de `verifier-ma-ville.php` est en grille 2 colonnes fixe (`1fr 1fr`) sans fallback explicite inline au breakpoint.
   - Effet business : friction sur mobile (segment majoritaire), donc chute des demandes qualifiées.

### Fort
1. **Sur-usage d’émojis sur pages business**
   - L’interface utilise beaucoup de pictos/émojis sur accueil, tarifs, footer, ce qui nuit à la perception premium B2B.

2. **Preuves insuffisamment “chiffrées” au-dessus de la ligne de flottaison**
   - Peu de preuves structurées (cas, KPI, délais, process onboarding) au moment du choix.

3. **Positionnement “fondateur” ambigu**
   - Le positionnement reste parfois flou au lieu d’un “Programme Fondateurs” cadré et crédible.

4. **Navigation très riche vs intention simple**
   - Beaucoup d’entrées de menu et pages annexes avant la conversion principale.

### Moyen
1. **Liens internes hétérogènes (chemins absolus et `/front/pages/...`)**
   - Peut créer une perception de manque de finition + fragilité tracking.

2. **Promesse “exclusivité” pas suffisamment contractualisée dans le copy**
   - Besoin d’un wording explicite : zone verrouillée, non revendable, modalités claires.

3. **FAQ tarifaire obsolète temporellement**
   - Mention “probablement fin 2026” déjà fragile en mars 2026.

### Faible
1. **Micro-copy formulaire perfectible**
   - “réponse sous 24h” utile mais sans précision process (appel, email, créneau).

2. **Hiérarchie visuelle longue pages**
   - Certaines sections répétitives allongent le scroll sans renforcer la décision.

---

## 2) Plan d’exécution en 3 phases

## Phase 1 — Conversion immédiate (J+1 à J+5)
Objectif : augmenter immédiatement les demandes qualifiées.

1. **Repositionner la proposition de valeur sur les pages d’entrée**
   - Remplacer le framing “plateforme/outil” par “système d’acquisition local vendeurs”.
   - Formule cible : *“Nous vous installons un système local qui transforme Google + contenu + estimateur + relances en rendez-vous vendeurs.”*

2. **Aligner la page tarifs sur le pricing réel (sans ambiguïté)**
   - Intégrer clairement :
     - Programme Fondateurs : **47€/mois à vie** (fermé / requalification)
     - Estimateur seul : **27€/mois + 197€ setup**
     - Standard mensuel : **97€/mois + 497€ setup + 3 mois prépayés**
     - Annuel : **897€/an**, setup offert, exclusivité incluse
     - Option exclusivité verrouillée : **900€ one-shot**

3. **Monocanal CTA primaire**
   - CTA principal partout : **“Vérifier si ma ville est disponible”**.
   - CTA secondaires en style ghost uniquement (Démo, Contact).

4. **Corriger la page “Vérifier ma ville” mobile-first**
   - Basculer la zone formulaire + étapes en une seule colonne < 992px.
   - Réduire hauteur visuelle hero + rapprocher formulaire du top.
   - Ajouter micro-réassurance sous bouton : délai + mode de réponse + aucune obligation.

5. **Mettre à jour les villes fermées partout**
   - Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion (cohérence multi-pages).

## Phase 2 — Confiance / preuve (Semaine 2)
Objectif : augmenter taux de passage check-ville → échange commercial.

1. **Bloc preuve “résultats terrain”**
   - 2 à 3 mini études de cas orientées vendeurs (avant/après, délai, type de ville).

2. **Clarifier le mécanisme d’exclusivité**
   - Ajouter encart “Comment l’exclusivité est garantie” (règle, validation, verrouillage).

3. **Renforcer la page méthode avec éléments concrets**
   - Timeline onboarding 30 jours.
   - Livrables précis (site local, estimateur, séquences CRM, contenu SEO).

4. **FAQ décisionnelle compacte**
   - Réponses sur engagement, setup, délai de mise en ligne, ville déjà réservée, migration.

## Phase 3 — Finition UX / SEO (Semaine 3)
Objectif : consolider performance et cohérence premium.

1. **Réduction des émojis et harmonisation visuelle premium**
   - Garder pictos sobres, supprimer les accents “grand public”.

2. **Normaliser les URLs internes et templates CTA**
   - Unifier les chemins et les labels CTA pour analytics propre.

3. **SEO local orienté intention vendeur**
   - Ajuster H1/H2 + méta pages stratégiques autour “mandat vendeur local / estimation [ville]”.

4. **Instrumentation funnel**
   - Events : clic CTA principal, scroll 50%, submit check-ville, source page.

---

## 3) Liste exacte des fichiers à modifier

### Priorité Phase 1
1. `front/pages/tarifs.php`
2. `index.php`
3. `front/pages/verifier-ma-ville.php`
4. `includes/header.php`
5. `assets/css/style.css`
6. `assets/css/verifier-zone.css`
7. `front/pages/methode.php`
8. `front/pages/plateforme.php`

### Priorité Phase 2
9. `front/pages/temoignages.php`
10. `front/pages/pourquoi.php`
11. `front/pages/demo.php`
12. `includes/footer.php`

### Priorité Phase 3
13. `includes/seo-head.php`
14. `assets/js/main.js`
15. `api/track-click.php`
16. `sitemap.xml`

---

## 4) Ordre précis des modifications (séquence exécutable)

1. **`front/pages/tarifs.php`** — réécriture offre/prix réelle + CTA principal check-ville.
2. **`index.php`** — héro + sections clés orientées “système d’acquisition local”.
3. **`front/pages/verifier-ma-ville.php`** — optimisation mobile + simplification formulaire/réassurance.
4. **`includes/header.php`** — simplifier navigation et hiérarchiser CTA principal unique.
5. **`assets/css/verifier-zone.css` + `assets/css/style.css`** — breakpoints mobile premium, densité visuelle, hiérarchie CTA.
6. **`front/pages/methode.php` + `front/pages/plateforme.php`** — preuve/process/livrables business.
7. **`front/pages/temoignages.php` + `front/pages/pourquoi.php`** — ajout preuves quantitatives et objection handling.
8. **`includes/footer.php`** — liens orientés conversion (ville, preuves, tarifs, appel).
9. **`includes/seo-head.php` + `sitemap.xml`** — cohérence SEO des pages prioritaires.
10. **`assets/js/main.js` + `api/track-click.php`** — tracking funnel CTA principal.

---

## 5) Garde-fous d’exécution
- **Ne pas refondre l’architecture** : conserver les pages existantes et améliorer copy/ordre/UX.
- **Mobile-first strict** : valider chaque section en 390px avant desktop.
- **Design premium sobre** : moins d’émojis, plus de preuve, plus de clarté.
- **Un message unique** : “système d’acquisition local vendeurs + exclusivité territoriale”.
