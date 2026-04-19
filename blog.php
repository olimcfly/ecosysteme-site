<?php
$page_title = 'Ressources & Conseils — Blog Immobilier Écosystème Immo';
$meta_description = 'Stratégies, conseils et astuces pour les conseillers immobiliers indépendants. Prospection, visibilité locale, réseaux sociaux, mandats exclusifs — toutes nos ressources gratuites.';

$articles = [
    [
        'id' => 1,
        'titre' => '7 erreurs qui font fuir les vendeurs avant même le premier rendez-vous',
        'extrait' => 'Votre première impression se forme souvent avant que vous ayez ouvert la bouche. Découvrez les erreurs qui sabotent vos chances dès le départ et comment les corriger facilement.',
        'tag' => 'Prospection',
        'emoji' => '🚫',
        'bg' => '#1A3C6E',
        'date' => '12 mars 2025',
        'lecture' => '6 min',
        'slug' => '7-erreurs-vendeurs'
    ],
    [
        'id' => 2,
        'titre' => 'Comment optimiser sa fiche Google My Business en 1 heure chrono',
        'extrait' => 'Google My Business est votre vitrine locale la plus importante. Ce guide pas-à-pas vous montre comment la configurer correctement et la mettre à jour régulièrement sans y passer des heures.',
        'tag' => 'Visibilité locale',
        'emoji' => '🔍',
        'bg' => '#0E7490',
        'date' => '5 mars 2025',
        'lecture' => '8 min',
        'slug' => 'optimiser-google-my-business'
    ],
    [
        'id' => 3,
        'titre' => 'Le script exact pour répondre à l\'objection "votre commission est trop élevée"',
        'extrait' => 'C\'est l\'objection la plus fréquente. Et pourtant, beaucoup de conseillers la subissent sans y répondre efficacement. Voici la méthode qui retourne la situation en votre faveur.',
        'tag' => 'Scripts & Mandats',
        'emoji' => '💬',
        'bg' => '#065F46',
        'date' => '28 février 2025',
        'lecture' => '7 min',
        'slug' => 'repondre-objection-commission'
    ],
    [
        'id' => 4,
        'titre' => 'Les 5 types de posts qui fonctionnent le mieux sur Facebook pour l\'immobilier',
        'extrait' => 'Tous les posts ne se valent pas. Après avoir analysé des centaines de publications immobilières, voici ceux qui génèrent le plus d\'engagement et de contacts entrants.',
        'tag' => 'Réseaux sociaux',
        'emoji' => '📱',
        'bg' => '#1A3C6E',
        'date' => '20 février 2025',
        'lecture' => '5 min',
        'slug' => '5-types-posts-facebook-immo'
    ],
    [
        'id' => 5,
        'titre' => 'Comment demander un avis Google à un client sans paraître intrusif',
        'extrait' => 'La plupart des clients satisfaits ne pensent pas à laisser un avis. Voici comment leur demander naturellement, au bon moment, avec les bons mots — et obtenir un taux de réponse de 70%+.',
        'tag' => 'Réputation',
        'emoji' => '⭐',
        'bg' => '#B45309',
        'date' => '14 février 2025',
        'lecture' => '4 min',
        'slug' => 'demander-avis-google'
    ],
    [
        'id' => 6,
        'titre' => 'Créer sa première séquence email en immobilier : le guide complet',
        'extrait' => 'L\'email marketing reste l\'outil de conversion le plus puissant pour un conseiller immobilier. Voici comment créer votre première séquence de bienvenue et commencer à convertir vos prospects.',
        'tag' => 'Email Marketing',
        'emoji' => '📧',
        'bg' => '#0369A1',
        'date' => '7 février 2025',
        'lecture' => '10 min',
        'slug' => 'premiere-sequence-email-immo'
    ],
    [
        'id' => 7,
        'titre' => 'Pourquoi votre site immobilier ne génère aucun contact (et comment y remédier)',
        'extrait' => 'Avoir un site web ne suffit plus. Pour qu\'il devienne une source de contacts, il faut respecter certaines règles de base que beaucoup de conseillers ignorent encore.',
        'tag' => 'SEO & Digital',
        'emoji' => '🌐',
        'bg' => '#065F46',
        'date' => '31 janvier 2025',
        'lecture' => '9 min',
        'slug' => 'site-immo-sans-contacts'
    ],
    [
        'id' => 8,
        'titre' => 'La communication parfaite avec vos vendeurs : les étapes clés de la transaction',
        'extrait' => 'Un vendeur qui ne se plaint pas de manquer d\'informations est un vendeur qui ne part pas. Voici le rythme et les messages qui fidélisent pendant toute la durée du mandat.',
        'tag' => 'Relation client',
        'emoji' => '🤝',
        'bg' => '#4C1D95',
        'date' => '24 janvier 2025',
        'lecture' => '6 min',
        'slug' => 'communication-vendeurs-transaction'
    ],
    [
        'id' => 9,
        'titre' => 'LinkedIn pour l\'immobilier : par où commencer si vous débutez',
        'extrait' => 'Vous avez un profil LinkedIn mais ne savez pas quoi en faire ? Ce guide vous donne les 5 premières actions à effectuer pour transformer votre profil en outil de prospection passive.',
        'tag' => 'LinkedIn',
        'emoji' => '💼',
        'bg' => '#0369A1',
        'date' => '17 janvier 2025',
        'lecture' => '7 min',
        'slug' => 'linkedin-immo-debutant'
    ],
];

include 'includes/header.php';
?>

<!-- PAGE HEADER -->
<section class="page-header">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="breadcrumb-sep">›</span>
      <span>Ressources</span>
    </div>
    <h1 class="page-header-title">Ressources & Conseils<br><span style="color: var(--accent-400);">pour les conseillers immobiliers</span></h1>
    <p class="page-header-subtitle">Stratégies concrètes, astuces terrain et méthodes pour développer votre activité. Tout est gratuit, tout est applicable.</p>
  </div>
</section>

<!-- FEATURED ARTICLE -->
<section class="section">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center; background: var(--primary-50); border: 1px solid var(--primary-200); border-radius: var(--radius-xl); padding: 48px; margin-bottom: 64px;">
      <div>
        <span style="display: inline-block; padding: 5px 14px; background: var(--primary-800); color: white; border-radius: 100px; font-size: .75rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; margin-bottom: 16px;">Article à la une</span>
        <h2 style="font-family: var(--font-display); font-size: 1.75rem; font-weight: 700; color: var(--neutral-900); line-height: 1.25; margin-bottom: 16px;">
          7 erreurs qui font fuir les vendeurs avant même le premier rendez-vous
        </h2>
        <p style="font-size: 1.0625rem; color: var(--neutral-600); line-height: 1.7; margin-bottom: 28px;">
          Votre première impression se forme souvent avant que vous ayez ouvert la bouche. Découvrez les erreurs qui sabotent vos chances dès le départ et comment les corriger facilement.
        </p>
        <div style="display: flex; align-items: center; gap: 16px; font-size: .875rem; color: var(--neutral-500); margin-bottom: 24px;">
          <span>📅 12 mars 2025</span>
          <span>⏱ 6 min de lecture</span>
          <span class="badge badge-primary">Prospection</span>
        </div>
        <a href="contact.php" class="btn btn-primary">Lire l'article →</a>
      </div>
      <div style="background: linear-gradient(135deg, #1A3C6E, #2C5F9E); border-radius: var(--radius-lg); height: 260px; display: flex; align-items: center; justify-content: center; font-size: 5rem;">🚫</div>
    </div>

    <!-- ARTICLES GRID -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 32px;">
      <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--neutral-900);">Tous les articles</h2>
      <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <?php
        $all_tags = array_unique(array_column($articles, 'tag'));
        ?>
        <button class="filter-btn active" data-tag="all">Tous</button>
        <?php foreach ($all_tags as $tag): ?>
        <button class="filter-btn" data-tag="<?= htmlspecialchars($tag) ?>"><?= htmlspecialchars($tag) ?></button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="blog-grid" id="blog-grid">
      <?php foreach (array_slice($articles, 1) as $article): ?>
      <div class="blog-card guide-card-wrapper" data-tag="<?= htmlspecialchars($article['tag']) ?>">
        <div class="blog-card-image" style="background: linear-gradient(135deg, <?= $article['bg'] ?>, <?= $article['bg'] ?>99);">
          <?= $article['emoji'] ?>
        </div>
        <div class="blog-card-body">
          <span class="blog-tag"><?= htmlspecialchars($article['tag']) ?></span>
          <h3 class="blog-card-title"><?= htmlspecialchars($article['titre']) ?></h3>
          <p class="blog-card-excerpt"><?= htmlspecialchars($article['extrait']) ?></p>
          <div class="blog-card-meta">
            <span>📅 <?= $article['date'] ?> · ⏱ <?= $article['lecture'] ?></span>
            <a href="contact.php" class="blog-card-read-more">Lire →</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- NEWSLETTER CAPTURE -->
<section class="section capture-section">
  <div class="container">
    <div class="capture-inner">
      <span class="section-tag">Ne rien manquer</span>
      <h2 class="section-title" style="margin-top: 12px;">Recevez nos nouveaux articles en avant-première</h2>
      <p style="font-size: 1.0625rem; color: var(--neutral-600); line-height: 1.7; margin-top: 16px;">
        Chaque semaine, un article pratique directement dans votre boîte mail. Stratégies terrain, outils, scripts — tout ce qui fait la différence au quotidien.
      </p>
      <form class="capture-form" id="capture-form">
        <input type="email" placeholder="Votre adresse email" required>
        <button type="submit" class="btn btn-primary">Je m'abonne</button>
      </form>
      <p class="capture-note">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        Pas de spam. Désinscription en un clic.
      </p>
    </div>
  </div>
</section>

<!-- CTA GUIDES -->
<section class="section">
  <div class="container">
    <div style="background: linear-gradient(135deg, var(--primary-900), var(--primary-800)); border-radius: var(--radius-xl); padding: 56px 48px; display: grid; grid-template-columns: 1fr auto; gap: 40px; align-items: center;">
      <div>
        <h2 style="font-family: var(--font-display); font-size: 1.75rem; font-weight: 700; color: white; margin-bottom: 16px;">Vous voulez aller plus loin ?</h2>
        <p style="font-size: 1.0625rem; color: rgba(255,255,255,.75); line-height: 1.7;">
          Nos articles vous donnent des bases solides. Nos guides pratiques vous donnent la méthode complète, les templates et les outils pour agir immédiatement.
        </p>
      </div>
      <div style="flex-shrink: 0;">
        <a href="guides.php" class="btn btn-primary btn-lg">Découvrir les 12 guides →</a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
