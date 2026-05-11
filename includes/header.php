<?php
$current_page = basename($_SERVER['PHP_SELF']);
$use_signup_minimal_header = !empty($signup_page_minimal_nav);
$minimal_nav_tagline = isset($minimal_nav_tagline) && (string) $minimal_nav_tagline !== ''
    ? (string) $minimal_nav_tagline
    : ($use_signup_minimal_header ? 'Essai & inscription' : 'Guides pour l\'immobilier');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' — Écosystème Immo' : 'Écosystème Immo — Guides pratiques pour conseillers immobiliers' ?></title>
  <meta name="description" content="<?= isset($meta_description) ? htmlspecialchars($meta_description) : 'Écosystème Immo : 12 guides pratiques pour aider les conseillers immobiliers indépendants à développer leur visibilité, leurs contacts et leur chiffre d\'affaires.' ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="<?= isset($canonical_url) && is_string($canonical_url) && $canonical_url !== '' ? htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8') : 'https://ecosystemeimmo.fr/' . htmlspecialchars($current_page, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:title" content="<?= isset($page_title) ? htmlspecialchars($page_title) : 'Écosystème Immo' ?>">
  <meta property="og:description" content="<?= isset($meta_description) ? htmlspecialchars($meta_description) : 'Guides pratiques pour conseillers immobiliers indépendants.' ?>">
  <meta property="og:type" content="website">
  <link rel="stylesheet" href="/assets/css/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
<?php
require_once __DIR__ . '/front_admin_toolbar.php';
front_admin_toolbar_render();
?>

<header class="site-header<?= $use_signup_minimal_header ? ' site-header--signup-logo-only' : '' ?>" id="site-header">
  <div class="container">
    <div class="header-inner">

      <!-- LOGO -->
      <a href="/" class="logo">
        <div class="logo-icon">ÉI</div>
        <div class="logo-text">
          <span class="logo-name">Écosystème Immo</span>
          <span class="logo-tagline"><?= htmlspecialchars($minimal_nav_tagline, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      </a>

      <!-- NAV DESKTOP -->
      <?php if (!$use_signup_minimal_header): ?>
      <nav class="nav-main">
        <a href="/"
           class="nav-link <?= $current_page === 'index.php' ? 'active' : '' ?>">
          Accueil
        </a>
        <a href="/pourquoi.php"
           class="nav-link <?= $current_page === 'pourquoi.php' ? 'active' : '' ?>">
          Pourquoi
        </a>
        <a href="/methode.php"
           class="nav-link <?= $current_page === 'methode.php' ? 'active' : '' ?>">
          La méthode
        </a>
        <a href="/demonstration.php"
           class="nav-link <?= $current_page === 'demonstration.php' ? 'active' : '' ?>">
          Démonstration
        </a>
        <a href="https://guides.ecosystemeimmo.fr"
           class="nav-link"
           target="_blank"
           rel="noopener noreferrer">
          Ressources ↗
        </a>
        <a href="/a-propos.php"
           class="nav-link <?= $current_page === 'a-propos.php' ? 'active' : '' ?>">
          À propos
        </a>
        <a href="/contact.php"
           class="nav-link <?= $current_page === 'contact.php' ? 'active' : '' ?>">
          Contact
        </a>
        <a href="/inscription.php"
           class="nav-link <?= $current_page === 'inscription.php' ? 'active' : '' ?>">
          Essai 30 j.
        </a>
        <a href="/connexion.php"
           class="nav-link <?= $current_page === 'connexion.php' ? 'active' : '' ?>">
          Mon espace
        </a>
      </nav>

      <!-- CTA DESKTOP -->
      <div class="header-cta">
        <a href="https://guides.ecosystemeimmo.fr"
           class="btn btn-primary btn-sm"
           target="_blank"
           rel="noopener noreferrer">
          Découvrir les guides ↗
        </a>
      </div>

      <!-- BURGER MOBILE -->
      <button class="mobile-menu-btn" aria-label="Ouvrir le menu">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <?php endif; ?>

    </div>
  </div>
</header>

<!-- MENU MOBILE -->
<?php if (!$use_signup_minimal_header): ?>
<div class="mobile-menu" id="mobile-menu">
  <div class="mobile-menu-header">
    <a href="/" class="logo">
      <div class="logo-icon">ÉI</div>
      <div class="logo-text">
        <span class="logo-name">Écosystème Immo</span>
      </div>
    </a>
    <button class="mobile-menu-close" aria-label="Fermer le menu">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <nav>
    <a href="index.php"
       class="mobile-nav-link <?= $current_page === 'index.php' ? 'active' : '' ?>">
      🏠 Accueil
    </a>
    <a href="pourquoi.php"
       class="mobile-nav-link <?= $current_page === 'pourquoi.php' ? 'active' : '' ?>">
      🤔 Pourquoi
    </a>
    <a href="methode.php"
       class="mobile-nav-link <?= $current_page === 'methode.php' ? 'active' : '' ?>">
      🔍 La méthode
    </a>
    <a href="demonstration.php"
       class="mobile-nav-link <?= $current_page === 'demonstration.php' ? 'active' : '' ?>">
      🎯 Démonstration
    </a>
    <a href="https://guides.ecosystemeimmo.fr"
       class="mobile-nav-link"
       target="_blank"
       rel="noopener noreferrer">
      📚 Ressources ↗
    </a>
    <a href="a-propos.php"
       class="mobile-nav-link <?= $current_page === 'a-propos.php' ? 'active' : '' ?>">
      👤 À propos
    </a>
    <a href="contact.php"
       class="mobile-nav-link <?= $current_page === 'contact.php' ? 'active' : '' ?>">
      💬 Contact
    </a>
    <a href="inscription.php"
       class="mobile-nav-link <?= $current_page === 'inscription.php' ? 'active' : '' ?>">
      ✨ Essai 30 j.
    </a>
    <a href="connexion.php"
       class="mobile-nav-link <?= $current_page === 'connexion.php' ? 'active' : '' ?>">
      🔑 Mon espace
    </a>
  </nav>

  <div class="mobile-menu-footer">
    <a href="https://guides.ecosystemeimmo.fr"
       class="btn btn-primary"
       target="_blank"
       rel="noopener noreferrer">
      Voir les 12 guides (conditions sur le site ressource) ↗
    </a>
    <a href="contact.php" class="btn btn-secondary">
      Demander un audit gratuit
    </a>
  </div>
</div>
<?php endif; ?>
