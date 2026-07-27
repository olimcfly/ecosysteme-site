<?php
require_once __DIR__ . '/security-headers.php';
require_once __DIR__ . '/csrf.php';
require_once __DIR__ . '/helpers.php';
if (!isset($pageTitle)) $pageTitle = 'ÉCOSYSTÈME IMMO LOCAL+';
if (!isset($pageDescription)) $pageDescription = 'La plateforme SaaS complète pour les agents immobiliers indépendants.';
if (!isset($currentPage)) $currentPage = 'accueil';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo h($pageDescription); ?>">
<title><?php echo h($pageTitle); ?> | ÉCOSYSTÈME IMMO LOCAL+</title>

<?php include __DIR__ . '/seo-head.php'; ?>
<?php include __DIR__ . '/schema.php'; ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="/assets/css/merci-download.css">

<?php if (isset($additionalCSS)): ?>
<link rel="stylesheet" href="/assets/css/<?php echo h($additionalCSS); ?>">
<?php endif; ?>

<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='54'>EI</text></svg>">

<style>
@keyframes navpulse {
 0%,100% { opacity: 1; transform: scale(1); }
 50% { opacity: 0.5; transform: scale(0.7); }
}

.sb-desktop { display: inline; }
@media (max-width: 640px) { .sb-desktop { display: none; } }

.navbar {
 position: fixed;
 top: 33px;
 left: 0;
 right: 0;
 z-index: 1000;
 background: rgba(255, 255, 255, 0.97);
 backdrop-filter: blur(12px);
 border-bottom: 1px solid rgba(102, 126, 234, 0.15);
 transition: box-shadow 0.3s;
}

.navbar.scrolled {
 box-shadow: 0 2px 20px rgba(102, 126, 234, 0.15);
}

.nav-container {
 max-width: 1200px;
 margin: 0 auto;
 height: 60px;
 display: flex;
 align-items: center;
 justify-content: space-between;
 padding: 0 2rem;
}

.nav-logo {
 font-family: 'Poppins', sans-serif;
 font-size: 14px;
 font-weight: 800;
 letter-spacing: 0.03em;
 color: #667eea;
 text-decoration: none;
 text-transform: uppercase;
 flex-shrink: 0;
}

.nav-menu {
 display: flex;
 align-items: center;
 list-style: none;
 margin: 0;
 padding: 0;
 gap: 0;
}

.nav-link {
 display: flex;
 align-items: center;
 gap: 5px;
 padding: 7px 12px;
 font-size: 13px;
 font-weight: 500;
 color: #4a5568;
 text-decoration: none;
 border-radius: 6px;
 transition: color 0.2s, background 0.2s;
 white-space: nowrap;
}

.nav-link:hover {
 color: #667eea;
 background: rgba(102, 126, 234, 0.07);
}

.nav-link.active {
 color: #667eea;
 font-weight: 600;
}

.nav-actions {
 display: flex;
 align-items: center;
 gap: 8px;
 flex-shrink: 0;
}

.nav-cta {
 display: inline-flex;
 align-items: center;
 gap: 6px;
 background: linear-gradient(135deg, #667eea, #764ba2);
 color: white;
 font-size: 12px;
 font-weight: 600;
 padding: 8px 16px;
 border-radius: 8px;
 text-decoration: none;
 white-space: nowrap;
 transition: opacity 0.2s, transform 0.2s;
 box-shadow: 0 3px 12px rgba(102, 126, 234, 0.3);
}

.nav-cta:hover {
 opacity: 0.92;
 transform: translateY(-1px);
 color: white;
 text-decoration: none;
}

.nav-pulse {
 width: 6px;
 height: 6px;
 background: #FDCB6E;
 border-radius: 50%;
 flex-shrink: 0;
 animation: navpulse 2s infinite;
}

.nav-toggle {
 display: none;
 flex-direction: column;
 gap: 4px;
 cursor: pointer;
 padding: 5px;
 background: none;
 border: none;
}

.nav-toggle span {
 display: block;
 width: 20px;
 height: 2px;
 background: #4a5568;
 border-radius: 2px;
 transition: 0.3s;
}

.nav-toggle.open span:nth-child(1) {
 transform: rotate(45deg) translate(8px, 8px);
}

.nav-toggle.open span:nth-child(2) {
 opacity: 0;
}

.nav-toggle.open span:nth-child(3) {
 transform: rotate(-45deg) translate(7px, -7px);
}

.nav-mobile {
 display: none;
 background: white;
 border-top: 1px solid #f0f0f0;
 padding: 1rem 1.5rem 1.5rem;
 max-height: calc(100vh - 93px);
 overflow-y: auto;
}

.nav-mobile.open {
 display: block;
}

.nav-mobile a {
 display: flex;
 align-items: center;
 justify-content: space-between;
 padding: 10px 0;
 font-size: 14px;
 font-weight: 500;
 color: #4a5568;
 text-decoration: none;
 border-bottom: 1px solid #f7fafc;
}

.nav-mobile a:hover {
 color: #667eea;
}

.nav-mobile a:last-child {
 border-bottom: none;
}

.nav-mobile-cta {
 display: flex;
 align-items: center;
 justify-content: center;
 gap: 7px;
 margin-top: 1rem;
 background: linear-gradient(135deg, #667eea, #764ba2);
 color: white;
 font-weight: 600;
 font-size: 13px;
 padding: 11px 18px;
 border-radius: 8px;
 text-decoration: none;
}

@media (max-width: 960px) {
 .nav-menu {
 display: none;
 }
 .nav-toggle {
 display: flex;
 }
}

@media (max-width: 480px) {
 .nav-container {
 padding: 0 1rem;
 height: 56px;
 }
 .nav-logo {
 font-size: 12px;
 }
}

body {
 padding-top: 93px;
}
</style>

</head>

<body>

<div id="scarcity-bar" style="background:#0f172a;color:#f8fafc;text-align:center;padding:8px 16px;font-size:12px;letter-spacing:0.01em;position:fixed;top:0;left:0;right:0;z-index:1001;line-height:1.4;">
 <span class="sb-desktop">Territoires complets&nbsp;: Bordeaux &middot; Nantes &middot; Nandy &middot; Aix-en-Provence &middot; Lannion &nbsp;&mdash;&nbsp;</span>
 <a href="/verifier-ma-ville" style="color:#e2e8f0;text-decoration:underline;font-weight:600;">V&eacute;rifier votre ville &rarr;</a>
</div>

<nav class="navbar" id="mainNav">
 <div class="nav-container">
 <a href="/" class="nav-logo">ÉCOSYSTÈME IMMO</a>

 <ul class="nav-menu" id="mainMenu">
 <li>
 <a href="/" class="nav-link <?php echo ($currentPage ?? '') === 'accueil' ? 'active' : ''; ?>">
 Accueil
 </a>
 </li>
 <li>
 <a href="/#methode" class="nav-link">
 Comment &ccedil;a marche
 </a>
 </li>
 <li>
 <a href="/tarifs" class="nav-link <?php echo ($currentPage ?? '') === 'tarifs' ? 'active' : ''; ?>">
 Tarifs
 </a>
 </li>
 <li>
 <a href="/villes-pilotes" class="nav-link <?php echo ($currentPage ?? '') === 'villes' ? 'active' : ''; ?>">
 R&eacute;alisations
 </a>
 </li>
 <li>
 <a href="/blog" class="nav-link <?php echo ($currentPage ?? '') === 'blog' ? 'active' : ''; ?>">
 Blog
 </a>
 </li>
 </ul>

 <div class="nav-actions">
 <a href="/verifier-ma-ville" class="nav-cta">
 <span class="nav-pulse"></span>
 V&eacute;rifier ma ville
 </a>
 </div>

 <button class="nav-toggle" id="navToggle" aria-label="Menu">
 <span></span>
 <span></span>
 <span></span>
 </button>
 </div>

 <div class="nav-mobile" id="navMobile">
 <a href="/">Accueil</a>
 <a href="/#methode">Comment &ccedil;a marche</a>
 <a href="/tarifs">Tarifs</a>
 <a href="/villes-pilotes">R&eacute;alisations</a>
 <a href="/blog">Blog</a>

 <a href="/verifier-ma-ville" class="nav-mobile-cta">
 <span class="nav-pulse"></span>
 V&eacute;rifier ma ville
 </a>
 </div>
</nav>

<script>
(function() {
 const nav = document.getElementById('mainNav');
 window.addEventListener('scroll', function() {
 nav.classList.toggle('scrolled', window.scrollY > 20);
 });

 const toggle = document.getElementById('navToggle');
 const mobile = document.getElementById('navMobile');
 
 toggle.addEventListener('click', function() {
 toggle.classList.toggle('open');
 mobile.classList.toggle('open');
 });

 mobile.querySelectorAll('a').forEach(link => {
 link.addEventListener('click', function() {
 toggle.classList.remove('open');
 mobile.classList.remove('open');
 });
 });
})();
</script>

<main>
