<?php
$page_title = 'Ressources pour conseillers immobiliers indépendants';
$meta_description = 'Guides et articles : pourquoi votre site ne convertit pas, SEO local, acquisition vendeurs, CRM, écosystème digital. Pour les conseillers indépendants.';

/* Articles (structure inchangée : même tableau, clé "categorie" pour le filtrage) */
$articles = [
  [
    'categorie' => 'seo-local',
    'titre'   => 'Articles immobiliers locaux : la nouvelle arme des conseillers',
    'extrait' => 'Pourquoi les contenus locaux, les posts Google Business Profile et une stratégie IA cohérente peuvent aider un conseiller immobilier à gagner en visibilité et en crédibilité.',
    'tag'     => 'SEO local & IA',
    'date'    => '1er mai 2026',
    'lecture' => '12 min',
    'icon'    => '📍',
    'bg'      => '#0369A1',
    'url'     => '/blog/articles-immobiliers-locaux-conseillers',
  ],
  [
    'categorie' => 'crm',
    'titre'   => 'HubSpot CRM ou Écosystème Immo : quel outil choisir pour votre activité locale ?',
    'extrait' => 'Comparatif : CRM généraliste international vs système métier immobilier — contacts, site, SEO local, avis de valeur, acquisition vendeurs et mandats.',
    'tag'     => 'CRM & outils',
    'date'    => '27 avril 2026',
    'lecture' => '12 min',
    'icon'    => '⚖️',
    'bg'      => '#B45309',
    'url'     => '/blog/hubspot-crm-ou-ecosysteme-immo',
  ],
  [
    'categorie' => 'ecosysteme',
    'titre'   => 'Systeme.io vs Écosystème Immo : quel outil choisir quand on est conseiller immobilier indépendant ?',
    'extrait' => 'Plateforme marketing généraliste ou système métier immobilier : comparatif sur les pages, séquences, CRM, SEO local et surtout le temps nécessaire avant d’être opérationnel.',
    'tag'     => 'Stack digital',
    'date'    => '28 avril 2026',
    'lecture' => '11 min',
    'icon'    => '🔀',
    'bg'      => '#0F766E',
    'url'     => '/blog/systeme-io-vs-ecosysteme-immo',
  ],
  [
    'categorie' => 'acquisition',
    'titre'   => 'Pourquoi le taux de commission ne suffit plus à réussir dans l’immobilier',
    'extrait' => '70 % ou 90 % sur zéro mandat ne change rien : la commission arrive en fin de parcours — le vrai levier, c’est le flux d’opportunités et un système d’acquisition durable.',
    'tag'     => 'Stratégie',
    'date'    => '29 avril 2026',
    'lecture' => '14 min',
    'icon'    => '💼',
    'bg'      => '#92400E',
    'url'     => '/blog/pourquoi-taux-commission-ne-suffit-plus',
  ],
  [
    'categorie' => 'acquisition',
    'titre'   => '80 % de commission sur zéro mandat, ça fait toujours zéro',
    'extrait' => 'Le taux de rétrocession arrive en fin de parcours : sans flux de mandats et sans visibilité locale, « garder plus » ne remplace pas l’acquisition — l’équation du revenu passe d’abord par les opportunités.',
    'tag'     => 'Rémunération',
    'date'    => '30 avril 2026',
    'lecture' => '12 min',
    'icon'    => '0️⃣',
    'bg'      => '#7C2D12',
    'url'     => '/blog/80-pourcent-commission-zero-mandat',
  ],
  [
    'categorie' => 'ecosysteme',
    'titre'   => 'Le vrai problème des conseillers immobiliers indépendants n’est pas le manque d’outils',
    'extrait' => 'CRM, pub, IA : empiler des logiciels sans parcours vendeur ne crée pas de mandats. Méthode, fondations et écosystème — quand les outils servent enfin la même stratégie.',
    'tag'     => 'Méthode',
    'date'    => '1er mai 2026',
    'lecture' => '13 min',
    'icon'    => '🧩',
    'bg'      => '#4338CA',
    'url'     => '/blog/vrai-probleme-conseillers-pas-outils',
  ],
  [
    'categorie' => 'acquisition',
    'titre'   => 'Comment générer vos premiers contacts vendeurs sans portail immobilier',
    'extrait' => 'Les portails vous coûtent cher et vous rendent dépendant. Voici comment construire votre propre flux de contacts vendeurs avec un site optimisé et une stratégie de contenu locale.',
    'tag'     => 'Acquisition',
    'date'    => '12 avril 2026',
    'lecture' => '6 min',
    'icon'    => '🏡',
    'bg'      => '#1A3C6E',
  ],
  [
    'categorie' => 'seo-local',
    'titre'   => 'Google Business Profile en immobilier : le guide complet 2026',
    'extrait' => 'Votre fiche GBP est souvent le premier contact avec un vendeur. Découvrez comment l\'optimiser pour apparaître en tête des recherches locales et déclencher des appels entrants.',
    'tag'     => 'SEO local',
    'date'    => '5 avril 2026',
    'lecture' => '8 min',
    'icon'    => '🗺️',
    'bg'      => '#0E7490',
  ],
  [
    'categorie' => 'crm',
    'titre'   => 'CRM immobilier : pourquoi vos mandats vous échappent sans suivi structuré',
    'extrait' => 'Un mandat non relancé à temps, c\'est un mandat perdu. Un bon CRM immobilier transforme votre suivi en système automatique — même quand vous êtes sur le terrain.',
    'tag'     => 'CRM',
    'date'    => '28 mars 2026',
    'lecture' => '5 min',
    'icon'    => '📋',
    'bg'      => '#065F46',
  ],
  [
    'categorie' => 'acquisition',
    'titre'   => 'Exclusivité géographique : pourquoi verrouiller votre zone dès maintenant',
    'extrait' => 'Dans votre secteur, un seul conseiller peut avoir l\'avantage de l\'exclusivité digitale. Une fois la zone prise, elle l\'est. Voici pourquoi agir avant la concurrence.',
    'tag'     => 'Stratégie',
    'date'    => '20 mars 2026',
    'lecture' => '4 min',
    'icon'    => '🔒',
    'bg'      => '#7C3AED',
  ],
  [
    'categorie' => 'acquisition',
    'titre'   => 'Contenu immobilier : 5 formats qui attirent vraiment les vendeurs',
    'extrait' => 'Tous les contenus ne se valent pas. Ces 5 formats ont prouvé leur efficacité pour attirer les propriétaires vendeurs et les inciter à vous contacter directement.',
    'tag'     => 'Contenu',
    'date'    => '14 mars 2026',
    'lecture' => '7 min',
    'icon'    => '✍️',
    'bg'      => '#0369A1',
  ],
  [
    'categorie' => 'ecosysteme',
    'titre'   => 'Écosystème digital immobilier : pourquoi les outils isolés ne fonctionnent pas',
    'extrait' => 'Site, CRM, contenu, trafic : quand ces éléments ne sont pas reliés, chacun travaille en silo. Un écosystème cohérent multiplie l\'efficacité de chaque action.',
    'tag'     => 'Écosystème',
    'date'    => '7 mars 2026',
    'lecture' => '6 min',
    'icon'    => '⚙️',
    'bg'      => '#1A3C6E',
  ],
];

$blog_chips = [
  ['id' => 'tous',      'type' => 'filter', 'label' => 'Tout'],
  ['id' => 'seo-local', 'type' => 'filter', 'label' => 'SEO local immobilier'],
  ['id' => 'acquisition', 'type' => 'filter', 'label' => 'Acquisition vendeurs'],
  ['id' => 'crm',       'type' => 'filter', 'label' => 'CRM & suivi prospects'],
  ['id' => 'ia',        'type' => 'filter', 'label' => 'IA pour conseillers immobiliers'],
  ['id' => 'etudes',    'type' => 'link',   'label' => 'Études de cas',     'href' => '/etudes-cas'],
  ['id' => 'methode',   'type' => 'link',   'label' => 'Méthode Écosystème Immo', 'href' => '/methode'],
];

include '../includes/nav.php';
?>

<main class="blog-resources-page">

  <section class="page-header">
    <div class="container">
      <div class="breadcrumb">
        <a href="/">Accueil</a>
        <span class="breadcrumb-sep">›</span>
        <span>Ressources</span>
      </div>
      <h1 class="page-header-title">Ressources pour conseillers immobiliers indépendants</h1>
    </div>
  </section>

  <section class="section" id="articles-guides" style="padding-top: 32px;">
    <div class="container blog-listing-cols">
      <div class="blog-listing-main">

        <p class="footer-col-title" style="color: var(--neutral-500); font-size: .75rem; margin-bottom: 10px;">Catégories</p>
        <div class="blog-categories" id="blog-categories" role="tablist" aria-label="Filtrer les ressources">
          <?php foreach ($blog_chips as $chip) :
            if ($chip['type'] === 'link') : ?>
            <a class="blog-cat-pill blog-cat-pill--link" href="<?= htmlspecialchars($chip['href'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($chip['label'], ENT_QUOTES, 'UTF-8') ?> →</a>
            <?php else : ?>
            <button type="button" class="blog-cat-pill<?= $chip['id'] === 'tous' ? ' is-active' : '' ?>" data-blog-filter="<?= htmlspecialchars($chip['id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($chip['label'], ENT_QUOTES, 'UTF-8') ?></button>
            <?php endif;
            endforeach; ?>
        </div>

        <div class="blog-grid-empty" id="blog-grid-empty" hidden>
          <p style="font-size: .9375rem; color: var(--neutral-600); line-height: 1.6; margin: 0 0 16px;">Aucun article dans cette thématique pour l’instant — le sujet <strong>IA</strong> s’enrichit progressivement. En attendant, un <strong>diagnostic</strong> permet de cadrer votre contexte (ville, outils, objectifs).</p>
          <a class="btn btn-primary" href="/rdv#reservation">Réserver un diagnostic</a>
        </div>

        <div class="blog-grid" id="blog-article-grid">
          <?php foreach ($articles as $article): ?>
          <article class="blog-card" data-categorie="<?= htmlspecialchars($article['categorie'], ENT_QUOTES, 'UTF-8') ?>">
            <div class="blog-card-image" style="background: linear-gradient(135deg, <?= $article['bg'] ?>, <?= $article['bg'] ?>cc);">
              <span style="font-size: 3rem;"><?= $article['icon'] ?></span>
            </div>
            <div class="blog-card-body">
              <span class="blog-tag"><?= htmlspecialchars($article['tag']) ?></span>
              <h2 class="blog-card-title"><?php if (!empty($article['url'])): ?><a href="<?= htmlspecialchars($article['url'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($article['titre']) ?></a><?php else: ?><?= htmlspecialchars($article['titre']) ?><?php endif; ?></h2>
              <p class="blog-card-excerpt"><?= htmlspecialchars($article['extrait']) ?></p>
              <div class="blog-card-meta">
                <span><?= $article['date'] ?> · <?= $article['lecture'] ?> de lecture</span>
                <?php if (!empty($article['url'])): ?>
                <a class="blog-card-read-more" href="<?= htmlspecialchars($article['url'], ENT_QUOTES, 'UTF-8') ?>">Lire l’article</a>
                <?php else: ?>
                <span class="blog-card-read-more" aria-hidden="true">Aperçu</span>
                <?php endif; ?>
              </div>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>

      <aside class="blog-listing-aside" aria-label="Aller plus loin">
        <div class="blog-aside-card content-block" style="margin: 0; border-color: var(--primary-200); background: var(--white); top: 88px; position: sticky;">
          <p style="font-size: .8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--primary-800); margin: 0 0 8px;">Votre territoire</p>
          <p style="font-size: 1rem; color: var(--neutral-800); line-height: 1.5; margin: 0 0 16px;">Vous voulez appliquer cela <strong>à votre ville</strong> ?</p>
          <a href="/rdv#reservation" class="btn btn-primary" style="width: 100%; justify-content: center; margin-bottom: 12px;">Réserver un diagnostic</a>
          <a href="/verifier-ma-ville" class="btn btn-secondary" style="width: 100%; justify-content: center; margin-bottom: 12px;">Vérifier ma ville</a>
          <a href="/offres" class="footer-link" style="display: block; text-align: center; font-size: .875rem;">Comparer les offres (Essentiel, Pro, Expert) →</a>
        </div>
      </aside>
    </div>
  </section>

  <section class="section capture-section" id="guide-newsletter">
    <div class="container">
      <div class="capture-inner">
        <span class="section-tag">Rester informé</span>
        <h2 class="section-title" style="margin-top: 12px;">Recevoir le guide (prochains contenus)</h2>
        <p style="font-size: 1.0625rem; color: var(--neutral-600); line-height: 1.7; margin-top: 16px;">
          Conseils terrain, idées de pages locales et rappels sur le <strong>parcours vendeur</strong> : laissez votre email, nous ne polluons pas.
        </p>
        <form class="capture-form" id="capture-form" novalidate>
          <input type="email" name="email" placeholder="Votre adresse email" required autocomplete="email" aria-label="Adresse email">
          <button type="submit" class="btn btn-primary">Recevoir le guide</button>
        </form>
        <p class="capture-note">Zéro spam. Désinscription en un clic.</p>
        <p style="font-size: .8125rem; color: var(--neutral-500); margin-top: 20px; line-height: 1.5;">Besoin d’une réponse sur <strong>votre</strong> situation plutôt que d’emails génériques ? <a href="/rdv" style="color: var(--primary-700); font-weight: 600;">Demander un diagnostic</a> · <a href="/verifier-ma-ville" style="color: var(--primary-700); font-weight: 600;">Vérifier ma ville</a></p>
      </div>
    </div>
  </section>

</main>

<?php include '../includes/footer.php'; ?>
