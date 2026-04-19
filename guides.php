<?php
require_once 'data/guides.php';

$page_title = 'Les 12 guides pratiques — Attirer des vendeurs localement';
$meta_description = 'Découvrez la collection des 12 guides Écosystème Immo pour attirer des vendeurs, développer votre visibilité locale et structurer votre acquisition sans perdre de temps.';

include 'includes/header.php';

$guide_icons = ['🏠', '🔍', '🎯', '💬', '🎨', '💼', '📧', '⭐', '✍️', '📱', '🤝', '⚡'];
$guide_colors = [
  '#1A3C6E','#0E7490','#1A3C6E','#065F46',
  '#4C1D95','#0369A1','#92400E','#065F46',
  '#0E7490','#831843','#065F46','#1A3C6E'
];

$tags = array_unique(array_column($guides, 'tag'));
?>

<!-- PAGE HEADER -->
<section class="page-header">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="breadcrumb-sep">›</span>
      <span>Les 12 guides</span>
    </div>
    <h1 class="page-header-title">Les 12 guides essentiels<br><span style="color: var(--accent-400);">pour attirer plus de vendeurs</span></h1>
    <p class="page-header-subtitle">Chaque guide vous donne une méthode claire, concrète et directement applicable pour développer votre visibilité locale et générer des mandats sans dépendre du hasard.</p>
    <div style="display: flex; align-items: center; gap: 24px; margin-top: 32px; flex-wrap: wrap;">
      <div style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,.75); font-size: .9375rem;">
        <span>📚</span> 12 guides spécialisés
      </div>
      <div style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,.75); font-size: .9375rem;">
        <span>💰</span> 47€ par guide
      </div>
      <div style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,.75); font-size: .9375rem;">
        <span>⚡</span> Accès immédiat
      </div>
    </div>
  </div>
</section>

<!-- FILTERS -->
<section class="section-sm bg-light" style="border-bottom: 1px solid var(--neutral-200);">
  <div class="container">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
      <div class="catalog-filters">
        <button class="filter-btn active" data-tag="all">Tous les guides (12)</button>
        <?php foreach ($tags as $tag): ?>
        <button class="filter-btn" data-tag="<?= htmlspecialchars($tag) ?>"><?= htmlspecialchars($tag) ?></button>
        <?php endforeach; ?>
      </div>
      <div style="font-size: .9375rem; color: var(--neutral-500);">
        <strong style="color: var(--neutral-900);">12 guides</strong> pour développer votre activité
      </div>
    </div>
  </div>
</section>

<!-- GUIDES GRID -->
<section class="section">
  <div class="container">
    <div class="guides-grid" id="guides-grid">
      <?php foreach ($guides as $index => $guide): ?>
      <div class="guide-card-wrapper" data-tag="<?= htmlspecialchars($guide['tag']) ?>">
        <div class="guide-card">
          <div class="guide-card-cover" style="background: linear-gradient(135deg, <?= $guide_colors[$index] ?>, <?= $guide_colors[$index] ?>bb);">
            <div class="guide-card-cover-inner">
              <div class="guide-card-number"><?= sprintf('%02d', $guide['id']) ?></div>
              <div class="guide-card-icon"><?= $guide_icons[$index] ?></div>
              <div class="guide-card-cover-title"><?= htmlspecialchars($guide['titre']) ?></div>
            </div>
            <span class="guide-card-tag"><?= htmlspecialchars($guide['tag']) ?></span>
          </div>
          <div class="guide-card-body">
            <h2 class="guide-card-title"><?= htmlspecialchars($guide['titre']) ?></h2>
            <p class="guide-card-desc"><?= htmlspecialchars($guide['promesse_courte']) ?></p>
            <div class="guide-card-footer">
              <div class="guide-card-price"><?= $guide['prix'] ?>€ <span>HT</span></div>
              <a href="guide.php?slug=<?= $guide['slug'] ?>" class="btn btn-dark btn-sm">Voir le guide →</a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PACK SUGGESTION -->
<section class="section bg-light" style="border-top: 1px solid var(--neutral-200);">
  <div class="container container-md">
    <div style="background: linear-gradient(135deg, var(--primary-900), var(--primary-800)); border-radius: var(--radius-xl); padding: 56px 48px; text-align: center;">
      <span class="section-tag" style="background: rgba(245,158,11,.15); color: var(--accent-400);">Accès complet</span>
      <h2 style="font-family: var(--font-display); font-size: 2rem; font-weight: 700; color: var(--white); margin-top: 16px; margin-bottom: 16px;">Vous voulez structurer tout votre système ?</h2>
      <p style="font-size: 1.0625rem; color: rgba(255,255,255,.75); line-height: 1.7; max-width: 520px; margin: 0 auto 32px;">
        Accédez à l’ensemble des guides et mettez en place une stratégie complète pour attirer des vendeurs, gagner en visibilité et sécuriser vos mandats.
      </p>
      <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <a href="contact.php" class="btn btn-primary btn-lg">Accéder à l’offre complète</a>
        <a href="methode.php" class="btn btn-outline-white">Comprendre la méthode</a>
      </div>
    </div>
  </div>
</section>

<!-- FAQ RAPIDE -->
<section class="section">
  <div class="container container-md">
    <div class="section-header center">
      <h2 class="section-title">Questions fréquentes</h2>
    </div>
    <div class="faq-list">
      <div class="faq-item">
        <button class="faq-question">
          Comment vais-je recevoir mon guide après l'achat ?
          <span class="faq-chevron">▼</span>
        </button>
        <div class="faq-answer">
          <p>Après votre paiement, vous recevez immédiatement un lien de téléchargement. Le guide est accessible sur ordinateur, tablette et mobile.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Est-ce adapté si je débute en marketing digital ?
          <span class="faq-chevron">▼</span>
        </button>
        <div class="faq-answer">
          <p>Oui. Les guides sont conçus pour être simples, concrets et directement applicables, même sans expérience technique.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Puis-je acheter plusieurs guides ?
          <span class="faq-chevron">▼</span>
        </button>
        <div class="faq-answer">
          <p>Oui, vous pouvez avancer à votre rythme. Une offre globale est également disponible pour structurer votre système complet.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Est-ce que ça fonctionne dans toutes les villes ?
          <span class="faq-chevron">▼</span>
        </button>
        <div class="faq-answer">
          <p>Oui. Les méthodes sont pensées pour s’adapter à votre marché local, quelle que soit votre zone.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question">
          Ai-je besoin d’outils spécifiques ?
          <span class="faq-chevron">▼</span>
        </button>
        <div class="faq-answer">
          <p>Non. Vous pouvez commencer avec des outils simples. Les guides vous expliquent tout pas à pas.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>