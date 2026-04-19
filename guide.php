<?php
require_once 'data/guides.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$guide = getGuideBySlug($slug);

if (!$guide) {
    header('Location: guides.php');
    exit;
}

$guide_icons = ['🏠', '🔍', '🎯', '💬', '🎨', '💼', '📧', '⭐', '✍️', '📱', '🤝', '⚡'];
$guide_colors = [
  '#1A3C6E','#0E7490','#1A3C6E','#065F46',
  '#4C1D95','#0369A1','#92400E','#065F46',
  '#0E7490','#831843','#065F46','#1A3C6E'
];

$icon = $guide_icons[$guide['id'] - 1];
$color = $guide_colors[$guide['id'] - 1];
$guides_lies = getGuidesLies($guide['guides_lies']);

$page_title = $guide['titre'];
$meta_description = $guide['promesse_courte'] . ' — Guide pratique Écosystème Immo à ' . $guide['prix'] . '€. ' . $guide['description'];

include 'includes/header.php';
?>

<!-- PAGE HEADER -->
<section class="page-header">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="breadcrumb-sep">›</span>
      <a href="guides.php">Les 12 guides</a>
      <span class="breadcrumb-sep">›</span>
      <span><?= htmlspecialchars($guide['titre']) ?></span>
    </div>
    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(245,158,11,.15); border: 1px solid rgba(245,158,11,.3); color: var(--accent-400); padding: 6px 14px; border-radius: 100px; font-size: .8125rem; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; margin-bottom: 16px;">
      <?= htmlspecialchars($guide['tag']) ?> · Guide #<?= $guide['id'] ?>
    </div>
    <h1 class="page-header-title"><?= htmlspecialchars($guide['titre']) ?></h1>
    <p class="page-header-subtitle"><?= htmlspecialchars($guide['sous_titre']) ?></p>
  </div>
</section>

<!-- MAIN CONTENT -->
<section class="section">
  <div class="container">
    <div class="guide-detail-layout">

      <!-- LEFT: Content -->
      <div>

        <!-- Description -->
        <div class="content-block">
          <p style="font-size: 1.125rem; color: var(--neutral-700); line-height: 1.8; font-style: italic; border-left: 4px solid <?= $color ?>; padding-left: 20px;">
            <?= htmlspecialchars($guide['description']) ?>
          </p>
        </div>

        <!-- Pour qui -->
        <div class="content-block">
          <h3>
            <span class="block-icon" style="background: #FEF3C7; color: #92400E;">🎯</span>
            Ce guide est fait pour vous si…
          </h3>
          <div class="check-list">
            <?php foreach ($guide['pour_qui'] as $item): ?>
            <div class="check-item">
              <div class="check-icon">✓</div>
              <span><?= htmlspecialchars($item) ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Ce que vous allez apprendre -->
        <div class="content-block">
          <h3>
            <span class="block-icon" style="background: #D1FAE5; color: #065F46;">📖</span>
            Ce que vous allez apprendre
          </h3>
          <div class="check-list">
            <?php foreach ($guide['apprentissages'] as $item): ?>
            <div class="check-item">
              <div class="check-icon" style="background: var(--primary-100); color: var(--primary-700);">→</div>
              <span><?= htmlspecialchars($item) ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Ce qu'il contient -->
        <div class="content-block">
          <h3>
            <span class="block-icon" style="background: var(--primary-100); color: var(--primary-700);">📦</span>
            Ce que contient ce guide
          </h3>
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
            <?php foreach ($guide['contenu'] as $item): ?>
            <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: var(--neutral-50); border-radius: var(--radius); border: 1px solid var(--neutral-200);">
              <span style="font-size: 1.25rem;">📄</span>
              <span style="font-size: .9375rem; font-weight: 500; color: var(--neutral-800);"><?= htmlspecialchars($item) ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Bénéfices concrets -->
        <div class="content-block" style="background: linear-gradient(135deg, var(--primary-50), var(--white)); border-color: var(--primary-200);">
          <h3>
            <span class="block-icon" style="background: var(--primary-100); color: var(--primary-800);">🚀</span>
            Les bénéfices concrets pour vous
          </h3>
          <div class="check-list">
            <?php foreach ($guide['benefices'] as $item): ?>
            <div class="check-item">
              <div class="check-icon" style="background: <?= $color ?>22; color: <?= $color ?>; border-radius: 50%;">★</div>
              <span style="font-weight: 500; color: var(--neutral-800);"><?= htmlspecialchars($item) ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- FAQ -->
        <div class="content-block">
          <h3>
            <span class="block-icon" style="background: #E0E7FF; color: #3730A3;">❓</span>
            Questions fréquentes sur ce guide
          </h3>
          <div class="faq-list">
            <?php foreach ($guide['faq'] as $faq): ?>
            <div class="faq-item">
              <button class="faq-question">
                <?= htmlspecialchars($faq['q']) ?>
                <span class="faq-chevron">▼</span>
              </button>
              <div class="faq-answer">
                <p><?= htmlspecialchars($faq['r']) ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

      </div>

      <!-- RIGHT: Sticky sidebar -->
      <div class="guide-sticky-sidebar">
        <div class="guide-buy-card">
          <!-- Cover -->
          <div class="guide-cover-big" style="background: linear-gradient(135deg, <?= $color ?>, <?= $color ?>bb);">
            <div class="guide-cover-big-inner">
              <div style="font-family: var(--font-display); font-size: 4rem; font-weight: 800; color: rgba(255,255,255,.15); line-height: 1;"><?= sprintf('%02d', $guide['id']) ?></div>
              <div style="font-size: 2.5rem; margin: 8px 0;"><?= $icon ?></div>
              <div style="font-size: .9375rem; font-weight: 600; color: rgba(255,255,255,.9); text-align: center; line-height: 1.3;"><?= htmlspecialchars($guide['titre']) ?></div>
              <div style="margin-top: 8px; padding: 4px 12px; background: rgba(255,255,255,.15); border-radius: 100px; font-size: .75rem; color: rgba(255,255,255,.8); font-weight: 600;"><?= htmlspecialchars($guide['tag']) ?></div>
            </div>
          </div>

          <!-- Price -->
          <div style="margin-bottom: 4px;">
            <div class="guide-price-display">
              <span class="guide-price-currency">€</span>
              <span class="guide-price-big"><?= $guide['prix'] ?></span>
            </div>
            <p class="guide-price-note">Accès immédiat · Téléchargement PDF</p>
          </div>

          <!-- CTA -->
          <a href="contact.php?guide=<?= urlencode($guide['titre']) ?>" class="btn btn-primary" style="width: 100%; margin-top: 20px; justify-content: center; font-size: 1.0625rem; padding: 16px;">
            Obtenir ce guide
          </a>

          <!-- What's included -->
          <div class="guide-format-list">
            <?php foreach ($guide['contenu'] as $item): ?>
            <div class="guide-format-item">
              <span class="guide-format-icon">✓</span>
              <span><?= htmlspecialchars($item) ?></span>
            </div>
            <?php endforeach; ?>
          </div>

          <!-- Guarantee -->
          <div class="guide-guarantee">
            <span>🔒</span>
            <span>Paiement 100% sécurisé — Accès garanti immédiatement</span>
          </div>

          <!-- Trust -->
          <div style="margin-top: 20px; text-align: center;">
            <div style="display: flex; justify-content: center; gap: 4px; color: var(--accent-500); font-size: .875rem; margin-bottom: 6px;">★★★★★</div>
            <p style="font-size: .8125rem; color: var(--neutral-500);">+500 conseillers immobiliers font confiance à Écosystème Immo</p>
          </div>
        </div>

        <!-- Share or more info -->
        <div style="background: var(--neutral-50); border: 1px solid var(--neutral-200); border-radius: var(--radius-lg); padding: 20px; margin-top: 16px; text-align: center;">
          <p style="font-size: .9375rem; color: var(--neutral-600); margin-bottom: 12px;">Des questions sur ce guide ?</p>
          <a href="contact.php" class="btn btn-secondary btn-sm" style="width: 100%; justify-content: center;">Nous contacter</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- GUIDES COMPLÉMENTAIRES -->
<?php if (!empty($guides_lies)): ?>
<section class="section bg-light" style="border-top: 1px solid var(--neutral-200);">
  <div class="container">
    <div class="section-header center" style="margin-bottom: 40px;">
      <h2 class="section-title">Guides complémentaires</h2>
      <p class="section-subtitle">Ces guides s'associent parfaitement avec celui-ci pour amplifier vos résultats.</p>
    </div>
    <div class="related-guides">
      <?php
      $related_icons = $guide_icons;
      $related_colors = $guide_colors;
      foreach ($guides_lies as $related):
        $ri = $related['id'] - 1;
      ?>
      <div class="guide-card">
        <div class="guide-card-cover" style="background: linear-gradient(135deg, <?= $related_colors[$ri] ?>, <?= $related_colors[$ri] ?>bb); height: 160px;">
          <div class="guide-card-cover-inner">
            <div style="font-size: 1.875rem; margin-bottom: 4px;"><?= $related_icons[$ri] ?></div>
            <div class="guide-card-cover-title" style="font-size: .8125rem;"><?= htmlspecialchars($related['titre']) ?></div>
          </div>
          <span class="guide-card-tag"><?= htmlspecialchars($related['tag']) ?></span>
        </div>
        <div class="guide-card-body">
          <h3 class="guide-card-title" style="font-size: 1rem;"><?= htmlspecialchars($related['titre']) ?></h3>
          <p class="guide-card-desc" style="font-size: .875rem;"><?= htmlspecialchars($related['promesse_courte']) ?></p>
          <div class="guide-card-footer">
            <div class="guide-card-price"><?= $related['prix'] ?>€</div>
            <a href="guide.php?slug=<?= $related['slug'] ?>" class="btn btn-dark btn-sm">Voir →</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align: center; margin-top: 40px;">
      <a href="guides.php" class="btn btn-secondary">Voir tous les guides →</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- CTA FINAL -->
<section class="section cta-section">
  <div class="container container-md">
    <div class="section-header center" style="margin-bottom: 0;">
      <h2 class="section-title" style="color: var(--white);">Prêt à transformer votre activité ?</h2>
      <p class="section-subtitle" style="color: rgba(255,255,255,.75); margin-top: 16px;">
        Téléchargez le guide "<?= htmlspecialchars($guide['titre']) ?>" pour seulement <?= $guide['prix'] ?>€ et commencez à appliquer dès aujourd'hui.
      </p>
      <div class="cta-buttons">
        <a href="contact.php?guide=<?= urlencode($guide['titre']) ?>" class="btn btn-primary btn-lg">Obtenir ce guide — <?= $guide['prix'] ?>€</a>
        <a href="guides.php" class="btn btn-outline-white">Voir tous les guides</a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
