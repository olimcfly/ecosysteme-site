<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' — Écosystème Immo' : 'Écosystème Immo — Guides pratiques pour conseillers immobiliers' ?></title>
  <meta name="description" content="<?= isset($meta_description) ? htmlspecialchars($meta_description) : 'Écosystème Immo : 12 guides pratiques pour aider les conseillers immobiliers indépendants à développer leur visibilité, leurs contacts et leur chiffre d\'affaires.' ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://ecosysteme-immo.fr/<?= htmlspecialchars($current_page) ?>">
  <meta property="og:title" content="<?= isset($page_title) ? htmlspecialchars($page_title) : 'Écosystème Immo' ?>">
  <meta property="og:description" content="<?= isset($meta_description) ? htmlspecialchars($meta_description) : 'Guides pratiques pour conseillers immobiliers indépendants.' ?>">
  <meta property="og:type" content="website">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>

<header class="site-header" id="site-header">
  <div class="container">
    <div class="header-inner">
      <a href="index.php" class="logo">
        <div class="logo-icon">ÉI</div>
        <div class="logo-text">
          <span class="logo-name">Écosystème Immo</span>
          <span class="logo-tagline">Guides pour l'immobilier</span>
        </div>
      </a>

      <nav class="nav-main">
        <a href="index.php" class="nav-link <?= $current_page === 'index.php' ? 'active' : '' ?>">Accueil</a>
        <a href="guides.php" class="nav-link <?= $current_page === 'guides.php' ? 'active' : '' ?>">Les 12 guides</a>
        <a href="methode.php" class="nav-link <?= $current_page === 'methode.php' ? 'active' : '' ?>">La méthode</a>
        <a href="blog.php" class="nav-link <?= $current_page === 'blog.php' ? 'active' : '' ?>">Ressources</a>
        <a href="a-propos.php" class="nav-link <?= $current_page === 'a-propos.php' ? 'active' : '' ?>">À propos</a>
        <a href="contact.php" class="nav-link <?= $current_page === 'contact.php' ? 'active' : '' ?>">Contact</a>
      </nav>

      <div class="header-cta">
        <a href="guides.php" class="btn btn-primary btn-sm">Découvrir les guides</a>
      </div>

      <button class="mobile-menu-btn" aria-label="Ouvrir le menu">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>
</header>

<div class="mobile-menu" id="mobile-menu">
  <div class="mobile-menu-header">
    <a href="index.php" class="logo">
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
    <a href="index.php" class="mobile-nav-link">🏠 Accueil</a>
    <a href="guides.php" class="mobile-nav-link">📚 Les 12 guides</a>
    <a href="methode.php" class="mobile-nav-link">🔍 La méthode</a>
    <a href="blog.php" class="mobile-nav-link">✏️ Ressources</a>
    <a href="a-propos.php" class="mobile-nav-link">👤 À propos</a>
    <a href="contact.php" class="mobile-nav-link">💬 Contact</a>
  </nav>
  <div class="mobile-menu-footer">
    <a href="guides.php" class="btn btn-primary">Voir les 12 guides — 47€ l'unité</a>
    <a href="contact.php" class="btn btn-secondary">Demander un audit gratuit</a>
  </div>
</div>
