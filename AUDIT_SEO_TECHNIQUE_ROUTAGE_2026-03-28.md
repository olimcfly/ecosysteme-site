# Audit SEO technique (routage & navigation)

Date : 2026-03-28  
Périmètre : structure crawlable Google, routage, navigation et cohérence d’URL.

## 1) Constat global

Le site a une base saine sur les URL “propres” principales :
- `sitemap.xml` listant les pages clés,
- `robots.txt` autorisant le front,
- routeur central avec fallback 404.

Mais plusieurs signaux techniques peuvent créer de la confusion pour Google :
- coexistence d’URLs “propres” et d’URLs legacy (`.php`, `/front/pages/...`),
- canonical auto-référente sur ces variantes au lieu d’une canonical unique,
- nombreux liens internes qui poussent les versions non canoniques.

## 2) Résultats par point audité

### A. `sitemap.xml`

✅ Le sitemap pointe vers les routes SEO attendues (`/plateforme`, `/methode`, `/modules`, etc.).

⚠️ Limites observées :
- toutes les dates `lastmod` sont fixes au `2026-03-24` (valeur statique),
- le sitemap n’empêche pas l’exploration des variantes d’URL présentes dans le maillage.

### B. `robots.txt`

✅ Correct sur l’intention : crawl du front autorisé, dossiers sensibles bloqués (`/admin`, `/api`, etc.).

⚠️ Point de vigilance :
- `Allow: /front/` et `Allow: /blog/` ne posent pas de problème direct, mais le vrai enjeu reste la canonicalisation des URLs internes non propres.

### C. Canonical

❌ Problème critique : canonical calculée à partir de l’URL demandée (`REQUEST_URI`).

Conséquences :
- `/plateforme.php` canonise vers `/plateforme.php`,
- `/front/pages/demo.php` canonise vers `/front/pages/demo.php`,
- `/verifier-ma-ville.php` canonise vers `/verifier-ma-ville.php`.

Donc Google reçoit plusieurs versions “valides” d’un même contenu au lieu d’un seul canonique unique.

### D. Liens internes réels (menu + contenus)

✅ Menu header/footer principalement propre (liens vers routes courtes).

❌ Problème critique dans les contenus : beaucoup de liens internes pointent vers :
- `/front/pages/...`,
- `*.php` (`/ressources.php`, `/verifier-zone.php`, etc.).

Ces liens injectent dans le crawl des routes que vous ne voulez probablement pas indexer.

### E. Pages indexables / non indexables

⚠️ La majorité des pages front est indexable par défaut (pas de `noindex`).

❌ Risques :
- pages de remerciement (`merci-*`) accessibles/crawlables,
- pages utilitaires pouvant être indexées sans valeur SEO,
- certaines pages legacy/non stratégiques sans règle d’exclusion.

Note : `front/pages/demo-video.php` est bien en `noindex, nofollow`.

### F. Statut HTTP

✅ Les URLs du sitemap renvoient 200 en local.

⚠️ Mais la stratégie HTTP de canonicalisation n’est pas appliquée de façon systématique :
- des alias existent (`*.php`) sans redirection 301 généralisée vers la version propre,
- quelques redirections legacy sont gérées (`verifier-zone.php`, `verification-zone.php`), mais le coverage est incomplet.

### G. Cohérence des URLs

❌ Incohérence élevée entre :
- routes “marketing SEO” (`/demo`, `/verifier-ma-ville`),
- routes techniques historiques (`/front/pages/demo.php`, `/front/pages/verifier-ma-ville.php`, `/ressources.php`).

### H. Homepage fallback

✅ Fallback homepage présent (`/` route home, lien retour sur 404).

⚠️ `index.php` est accessible en direct (même contenu), ce qui nécessite une normalisation stricte par redirection ou canonical systématique contrôlée.

### I. Gestion des erreurs 404

✅ Routeur renvoie un `http_response_code(404)` + page 404 dédiée.

⚠️ Mais si un fichier physique existe sous un chemin non souhaité (`/front/pages/...`), il peut être servi directement selon la conf serveur, contournant la logique de routeur.

### J. Pages accessibles seulement par certaines routes

❌ Plusieurs pages sont accessibles via routes multiples :
- route propre,
- alias `.php`,
- chemin physique `/front/pages/...`.

Cela multiplie les points d’entrée crawlables pour un même contenu.

### K. Duplication potentielle de contenu

❌ Risque élevé de duplication (ou quasi-duplication) via :
- `/page` vs `/page.php`,
- `/page` vs `/front/pages/page.php`,
- variantes avec/without slash.

Canonical actuelle n’élimine pas ce risque puisqu’elle suit l’URL demandée.

## 3) Problèmes critiques (priorité P0)

1. Canonical non normalisée (auto-référente sur les mauvaises variantes).  
2. Maillage interne contenant massivement des URLs non canoniques (`/front/pages/...`, `*.php`).  
3. Absence de 301 globale de normalisation vers les routes propres.

## 4) Risques SEO

- Dilution de signaux (popularité et pertinence réparties entre plusieurs URLs).
- Crawl budget gaspillé sur des versions techniques/legacy.
- Mauvaise version potentiellement choisie par Google dans l’index.
- Baisse de stabilité des performances SEO (positions fluctuantes).

## 5) Recommandations prioritaires

### R1 — Canonical stricte par route métier

Ne pas construire la canonical à partir de `REQUEST_URI` brute pour les pages routées.

Mettre une table de normalisation :
- `/plateforme.php` -> canonical `/plateforme`
- `/front/pages/plateforme.php` -> canonical `/plateforme`
- idem pour toutes les pages clés.

### R2 — Redirections 301 systématiques

Dans la couche serveur (Apache/Nginx) :
- rediriger `/*.php` publics vers route propre,
- rediriger `/front/pages/*.php` publics vers route propre,
- conserver uniquement quelques exceptions techniques si nécessaire.

### R3 — Assainir le maillage interne

Remplacer tous les liens internes vers :
- `/front/pages/...` par route propre,
- `/ressources.php` par `/ressources`,
- `/verifier-zone.php` par `/verifier-ma-ville`.

### R4 — Politique d’indexation

Ajouter `noindex, follow` sur :
- pages de remerciement,
- pages transactionnelles sans valeur SEO (selon stratégie),
- toute URL legacy qui ne doit plus ranker.

### R5 — Gouvernance sitemap

- garder uniquement les URLs canoniques,
- automatiser `lastmod` réel par page.

## 6) Correctifs techniques à prévoir (backlog)

- [ ] Créer une fonction de canonicalisation centrale (`normalizeCanonicalPath`).
- [ ] Ajouter une map de redirection 301 complète pour aliases `.php` et `/front/pages/*`.
- [ ] Passer un script de lint des liens internes (détection `href` non conformes).
- [ ] Ajouter tests automatiques HTTP (200/301/404 + canonical attendue).
- [ ] Appliquer `meta robots noindex` sur templates “merci-*”.

## 7) Tests manuels à exécuter (checklist)

1. `curl -I https://ecosystemeimmo.fr/plateforme.php` doit renvoyer `301 -> /plateforme`.  
2. `curl -I https://ecosystemeimmo.fr/front/pages/plateforme.php` doit renvoyer `301 -> /plateforme`.  
3. `curl -s https://ecosystemeimmo.fr/plateforme | grep canonical` doit pointer vers `/plateforme` uniquement.  
4. Vérifier que toutes les URLs du menu principal apparaissent dans le sitemap canonique.  
5. Vérifier qu’aucun lien interne en production ne contient `/front/pages/` ou `.php` (hors cas explicitement voulus).  
6. Ouvrir 20 pages clés + 20 pages blog : canonical unique, statut 200, pas de mixed routing.  
7. Tester 10 URLs invalides : statut 404 + template 404 + aucun soft-404.

## 8) Réponse directe à vos questions

- **Le sitemap pointe-t-il vers les bonnes URLs ?** Oui, globalement oui pour les pages business principales.
- **Certaines URLs du menu sont-elles incohérentes avec le sitemap ?** Le menu principal est cohérent, mais les contenus profonds poussent d’autres routes non canoniques.
- **Certaines pages clés manquent-elles de soutien via maillage ?** Oui, surtout `rdv`, `tarifs`, `contact` sont peu maillées comparativement à `ressources`/`demo`.
- **Google risque-t-il d’explorer de mauvaises versions ?** Oui, risque élevé actuellement.
- **Le site peut-il être perçu comme confus techniquement ?** Oui, tant que les variantes URL restent accessibles + maillées + canonisées sur elles-mêmes.
