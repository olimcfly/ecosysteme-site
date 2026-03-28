<?php
/**
 * SEO Meta Tags - Balises meta dynamiques pour le référencement
 *
 * Variables acceptées (à définir avant l'inclusion) :
 *   $seoTitle       — Titre de la page (défaut : $pageTitle)
 *   $seoDescription — Description de la page (défaut : $pageDescription)
 *   $seoImage       — URL de l'image OG/Twitter (défaut : image par défaut)
 *   $seoUrl         — URL canonique (défaut : URL courante)
 *   $seoType        — Type Open Graph (défaut : website)
 */

$siteUrl   = 'https://ecosystemeimmo.fr';
$siteName  = 'ÉCOSYSTÈME IMMO LOCAL+';
$defaultOgImage = $siteUrl . '/assets/img/og-default.png';

// Résoudre les valeurs
$_seoTitle       = isset($seoTitle) ? $seoTitle : (isset($pageTitle) ? $pageTitle : $siteName);
$_seoDescription = isset($seoDescription) ? $seoDescription : (isset($pageDescription) ? $pageDescription : 'La plateforme SaaS complète pour les agents immobiliers indépendants.');
$_seoImage       = isset($seoImage) ? $seoImage : $defaultOgImage;
$_seoType        = isset($seoType) ? $seoType : 'website';

// URL canonique : utiliser $seoUrl si défini, sinon construire depuis REQUEST_URI
if (isset($seoUrl)) {
    $_seoCanonical = $seoUrl;
} else {
    $requestPath = strtok($_SERVER['REQUEST_URI'], '?');
    $_seoCanonical = $siteUrl . rtrim($requestPath, '/');
    // Page d'accueil : juste le domaine
    if ($requestPath === '/' || $requestPath === '/index.php') {
        $_seoCanonical = $siteUrl;
    }
}

// Échapper pour HTML
$_t = htmlspecialchars($_seoTitle, ENT_QUOTES, 'UTF-8');
$_d = htmlspecialchars($_seoDescription, ENT_QUOTES, 'UTF-8');
$_i = htmlspecialchars($_seoImage, ENT_QUOTES, 'UTF-8');
$_c = htmlspecialchars($_seoCanonical, ENT_QUOTES, 'UTF-8');
?>

<!-- Canonical -->
<link rel="canonical" href="<?php echo $_c; ?>">

<!-- Open Graph -->
<meta property="og:type" content="<?php echo htmlspecialchars($_seoType, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:title" content="<?php echo $_t; ?>">
<meta property="og:description" content="<?php echo $_d; ?>">
<meta property="og:image" content="<?php echo $_i; ?>">
<meta property="og:url" content="<?php echo $_c; ?>">
<meta property="og:site_name" content="<?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:locale" content="fr_FR">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $_t; ?>">
<meta name="twitter:description" content="<?php echo $_d; ?>">
<meta name="twitter:image" content="<?php echo $_i; ?>">
