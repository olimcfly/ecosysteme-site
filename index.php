<?php
$routePath = isset($_GET['url']) ? trim((string) parse_url($_GET['url'], PHP_URL_PATH), '/') : '';

if ($routePath !== '') {
 $routeMap = [
 'plateforme' => 'front/pages/plateforme.php',
 'methode' => 'front/pages/methode.php',
 'modules' => 'front/pages/licence.php',
 'assistant' => 'front/pages/assistant.php',
 'ressources' => 'front/pages/ressources.php',
 'blog' => 'front/blog/blog.php',
 'temoignages' => 'front/pages/temoignages.php',
 'villes' => 'front/pages/verifier-ma-ville.php',
 'villes-pilotes' => 'front/pages/villes-pilotes.php',
 'demo' => 'front/pages/demo.php',
 'verifier-ma-ville' => 'front/pages/verifier-ma-ville.php',
 'rdv' => 'front/pages/rdv.php',
 'tarifs' => 'front/pages/tarifs.php',
 'contact' => 'front/pages/contact.php',
 'pourquoi' => 'front/pages/pourquoi.php',
 'avance' => 'front/pages/avance-concurrents.php',
 'mentions-legales' => 'front/pages/mentions-legales.php',
 'cgv' => 'front/pages/cgv.php',
 'confidentialite' => 'front/pages/politique-confidentialite.php',
 'merci-ville' => 'front/pages/merci-ville.php',
 'traitement-ville' => 'front/pages/traitement-ville.php',
 'traitement-rdv' => 'front/pages/rdv.php',
 ];

 $redirectMap = [
 'verifier-zone.php' => '/verifier-ma-ville',
 'verification-zone.php' => '/verifier-ma-ville',
 // Redirections legacy (.php) vers URLs propres pour éviter le contenu dupliqué
 'plateforme.php' => '/plateforme',
 'methode.php' => '/methode',
 'assistant.php' => '/assistant',
 'demo.php' => '/demo',
 'verifier-ma-ville.php' => '/verifier-ma-ville',
 'rdv.php' => '/rdv',
 'contact.php' => '/contact',
 'tarifs.php' => '/tarifs',
 'temoignages.php' => '/temoignages',
 'mentions-legales.php' => '/mentions-legales',
 'cgv.php' => '/cgv',
 'politique-confidentialite.php' => '/confidentialite',
 'ressources.php' => '/ressources',
 'traitement-rdv.php' => '/rdv',
 'index.php' => '/',
 ];

 if (isset($redirectMap[$routePath])) {
 header('Location: ' . $redirectMap[$routePath], true, 301);
 exit;
 }

 $renderRoute = static function (string $relativePath): bool {
 $absolutePath = __DIR__ . '/' . ltrim($relativePath, '/');
 if (!is_file($absolutePath)) {
 return false;
 }

 $originalCwd = getcwd();
 chdir(dirname($absolutePath));
 require basename($absolutePath);
 if ($originalCwd !== false) {
 chdir($originalCwd);
 }
 return true;
 };

 if (isset($routeMap[$routePath])) {
 if ($renderRoute($routeMap[$routePath])) {
 exit;
 }
 }

 if (strpos($routePath, 'blog/') === 0) {
 $slug = basename($routePath);
 if (preg_match('/^[a-z0-9-]+$/', $slug)) {
 $articlePath = 'front/blog/articles/' . $slug . '.php';
 if (is_file(__DIR__ . '/' . $articlePath) && $renderRoute($articlePath)) {
 exit;
 }
 }
 }

 http_response_code(404);
 $pageTitle = 'Page introuvable';
 $pageDescription = 'Cette page n’existe pas ou a été déplacée.';
 $currentPage = '';
 include __DIR__ . '/includes/header.php';
 ?>
 <section style="padding:120px 0 90px; text-align:center;">
 <div class="container" style="max-width:760px;">
 <h1 style="font-size:2rem; margin-bottom:12px; color:#1a202c;">Page introuvable (404)</h1>
 <p style="color:#64748b; line-height:1.7; margin-bottom:24px;">
 La page demandée est introuvable. Utilisez le menu pour continuer votre navigation.
 </p>
 <a href="/" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; text-decoration:none; padding:12px 22px; border-radius:10px; font-weight:600;">
 Retour à l’accueil
 </a>
 </div>
 </section>
 <?php
 include __DIR__ . '/includes/footer.php';
 exit;
}

$pageTitle = "L'&eacute;cosyst&egrave;me digital que vos concurrents ne pourront jamais avoir";
$pageDescription = '&Eacute;COSYST&Egrave;ME IMMO LOCAL+ : la plateforme tout-en-un pour les pros immobiliers avec exclusivit&eacute; territoriale garantie. Site, SEO, CRM, IA et m&eacute;thode guid&eacute;e.';
$currentPage = 'accueil';

include 'includes/header.php';
?>

<style>
@keyframes pdot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

.pi-badge {
 display: inline-flex; align-items: center; gap: 8px;
 border-radius: 30px; padding: 6px 18px;
 font-size: 0.84rem; font-weight: 600; letter-spacing: 0.02em;
 margin-bottom: 22px;
}
.pi-pulse { width:7px;height:7px;border-radius:50%;display:inline-block;animation:pdot 2s infinite; }

.pi-section-badge {
 display: inline-block; padding: 6px 16px;
 border-radius: 20px; font-size: 0.85rem; font-weight: 600;
 margin-bottom: 14px;
}

.pi-card {
 background: white; border-radius: 14px;
 box-shadow: 0 2px 12px rgba(0,0,0,0.07);
 transition: transform 0.2s, box-shadow 0.2s;
}
.pi-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.13); }

.pi-flow-step {
 display: flex; align-items: center; gap: 0;
 justify-content: center; flex-wrap: wrap; gap: 0;
}
.pi-flow-box {
 background: white; border-radius: 10px;
 border: 1px solid #e9ecf5;
 padding: 14px 22px; text-align: center;
 font-size: 0.9rem; font-weight: 600; color: #2d3748;
 white-space: nowrap;
}
.pi-flow-arrow {
 font-size: 1.4rem; color: #667eea; padding: 0 8px; flex-shrink: 0;
}

.hero-premium {
 padding: 92px 0 78px;
 text-align: center;
 background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hero-premium-wrap {
 color: white;
 max-width: 860px;
 margin: 0 auto;
 animation: fadeUp 0.7s ease both;
}

.hero-proof-row {
 display: grid;
 grid-template-columns: repeat(3, minmax(0, 1fr));
 gap: 10px;
 margin: 0 auto 24px;
 max-width: 760px;
}

.hero-proof-item {
 background: rgba(255,255,255,0.14);
 border: 1px solid rgba(255,255,255,0.25);
 border-radius: 10px;
 padding: 10px 12px;
 font-size: 0.84rem;
 font-weight: 600;
}

.hero-funnel {
 margin: 0 auto 26px;
 max-width: 880px;
 background: rgba(255,255,255,0.12);
 border: 1px solid rgba(255,255,255,0.26);
 border-radius: 12px;
 padding: 12px;
}

.hero-funnel-steps {
 display: flex;
 align-items: center;
 justify-content: center;
 flex-wrap: wrap;
 gap: 6px;
}

.hero-funnel-step {
 background: rgba(255,255,255,0.95);
 color: #374151;
 border-radius: 8px;
 padding: 8px 12px;
 font-size: 0.8rem;
 font-weight: 600;
 white-space: nowrap;
}

.hero-funnel-arrow {
 color: rgba(255,255,255,0.85);
 font-size: 1rem;
 font-weight: 700;
}

.pricing-grid {
 display: grid;
 grid-template-columns: repeat(3, minmax(0, 1fr));
 gap: 18px;
 max-width: 1020px;
 margin: 0 auto 22px;
}

.pricing-card {
 background: #ffffff;
 border: 1px solid #e2e8f0;
 border-radius: 16px;
 padding: 24px;
 box-shadow: 0 4px 16px rgba(0,0,0,0.05);
 text-align: left;
 position: relative;
}

.pricing-card.is-featured {
 border: 2px solid #667eea;
 box-shadow: 0 12px 30px rgba(102,126,234,0.16);
 transform: translateY(-3px);
}

.pricing-badge {
 display: inline-block;
 background: #eef2ff;
 color: #3730a3;
 font-size: 0.77rem;
 font-weight: 700;
 letter-spacing: 0.03em;
 border-radius: 999px;
 padding: 6px 10px;
 margin-bottom: 14px;
 text-transform: uppercase;
}

.pricing-title {
 font-size: 1.15rem;
 color: #111827;
 font-weight: 700;
 margin-bottom: 8px;
}

.pricing-price {
 color: #111827;
 font-size: 2rem;
 font-weight: 800;
 margin-bottom: 2px;
 line-height: 1.2;
}

.pricing-price-sub {
 font-size: 0.9rem;
 color: #64748b;
 margin-bottom: 14px;
}

.pricing-features {
 list-style: none;
 margin: 0 0 18px;
 padding: 0;
 display: grid;
 gap: 8px;
}

.pricing-features li {
 display: flex;
 align-items: flex-start;
 gap: 8px;
 color: #334155;
 font-size: 0.9rem;
 line-height: 1.45;
}

.pricing-features li::before {
 content: "";
 color: #4f46e5;
 font-weight: 700;
 flex-shrink: 0;
}

.pricing-actions {
 display: flex;
 flex-direction: column;
 gap: 8px;
}

.pricing-note {
 max-width: 900px;
 margin: 0 auto;
 background: #eef2ff;
 border: 1px solid #c7d2fe;
 border-radius: 12px;
 padding: 12px 14px;
 font-size: 0.9rem;
 color: #3730a3;
 text-align: center;
}

.pricing-faq {
 max-width: 900px;
 margin: 26px auto 0;
 display: grid;
 grid-template-columns: repeat(2, minmax(0, 1fr));
 gap: 14px;
}

.pricing-faq-item {
 background: #ffffff;
 border: 1px solid #e2e8f0;
 border-radius: 12px;
 padding: 16px;
}

.pricing-faq-item strong {
 display: block;
 color: #111827;
 font-size: 0.94rem;
 margin-bottom: 6px;
}

.pricing-faq-item p {
 margin: 0;
 color: #64748b;
 font-size: 0.88rem;
 line-height: 1.5;
}

.proof-grid {
 display: grid;
 grid-template-columns: repeat(3, minmax(0, 1fr));
 gap: 16px;
 max-width: 980px;
 margin: 0 auto;
}

.proof-card {
 background: #ffffff;
 border: 1px solid #e2e8f0;
 border-radius: 14px;
 padding: 18px;
 box-shadow: 0 3px 14px rgba(15,23,42,0.05);
}

.proof-head {
 display: flex;
 align-items: center;
 gap: 10px;
 margin-bottom: 10px;
}

.proof-avatar {
 width: 40px;
 height: 40px;
 border-radius: 50%;
 background: linear-gradient(135deg, #667eea, #764ba2);
 color: #fff;
 display: flex;
 align-items: center;
 justify-content: center;
 font-size: 0.86rem;
 font-weight: 700;
 flex-shrink: 0;
}

.proof-name {
 color: #0f172a;
 font-size: 0.95rem;
 font-weight: 700;
}

.proof-zone {
 color: #475569;
 font-size: 0.86rem;
 line-height: 1.45;
 margin-bottom: 8px;
}

.proof-status {
 display: inline-block;
 background: #ecfeff;
 color: #0f766e;
 border: 1px solid #99f6e4;
 border-radius: 999px;
 font-size: 0.74rem;
 font-weight: 700;
 letter-spacing: 0.03em;
 text-transform: uppercase;
 padding: 4px 9px;
}

.proof-note {
 max-width: 980px;
 margin: 18px auto 0;
 padding: 12px 14px;
 border-radius: 12px;
 border: 1px solid #cbd5e1;
 background: #f8fafc;
 color: #475569;
 font-size: 0.88rem;
 text-align: center;
}

.founder-wrap {
 max-width: 980px;
 margin: 0 auto;
 display: grid;
 grid-template-columns: 260px 1fr;
 gap: 26px;
 align-items: center;
}

.founder-photo {
 width: 100%;
 max-width: 260px;
 aspect-ratio: 1 / 1;
 border-radius: 18px;
 border: 1.5px dashed #cbd5e1;
 background: #f8fafc;
 color: #64748b;
 display: flex;
 align-items: center;
 justify-content: center;
 text-align: center;
 font-size: 0.9rem;
 font-weight: 600;
 padding: 16px;
}

.founder-card {
 background: #ffffff;
 border: 1px solid #e2e8f0;
 border-radius: 16px;
 padding: 26px;
 box-shadow: 0 4px 20px rgba(15,23,42,0.06);
}

.founder-meta {
 display: inline-block;
 font-size: 0.76rem;
 font-weight: 700;
 letter-spacing: 0.04em;
 text-transform: uppercase;
 color: #4338ca;
 background: #eef2ff;
 border-radius: 999px;
 padding: 5px 11px;
 margin-bottom: 11px;
}

.founder-title {
 font-size: 1.65rem;
 color: #0f172a;
 line-height: 1.25;
 margin-bottom: 10px;
}

.founder-text {
 color: #475569;
 font-size: 0.96rem;
 line-height: 1.7;
 margin-bottom: 15px;
}

.founder-beliefs {
 display: grid;
 grid-template-columns: repeat(2, minmax(0, 1fr));
 gap: 12px;
 margin-top: 8px;
}

.founder-belief {
 border-radius: 12px;
 padding: 13px;
 font-size: 0.86rem;
 line-height: 1.5;
}

.founder-belief.ok {
 border: 1px solid #bfdbfe;
 background: #eff6ff;
 color: #1e3a8a;
}

.founder-belief.no {
 border: 1px solid #fecaca;
 background: #fef2f2;
 color: #991b1b;
}

.faq-wrap {
 max-width: 920px;
 margin: 0 auto;
}

.faq-list {
 display: grid;
 gap: 12px;
}

.faq-item {
 background: #ffffff;
 border: 1px solid #e2e8f0;
 border-radius: 12px;
 overflow: hidden;
}

.faq-question {
 width: 100%;
 text-align: left;
 border: none;
 background: #ffffff;
 padding: 16px 18px;
 display: flex;
 align-items: center;
 justify-content: space-between;
 gap: 12px;
 font-size: 0.97rem;
 font-weight: 700;
 color: #0f172a;
 cursor: pointer;
 font-family: inherit;
}

.faq-question:hover {
 background: #f8fafc;
}

.faq-chevron {
 font-size: 1rem;
 color: #64748b;
 transition: transform 0.2s ease;
 flex-shrink: 0;
}

.faq-question[aria-expanded="true"] .faq-chevron {
 transform: rotate(180deg);
}

.faq-answer {
 max-height: 0;
 overflow: hidden;
 transition: max-height 0.25s ease;
}

.faq-answer-inner {
 padding: 0 18px 16px;
 color: #475569;
 font-size: 0.93rem;
 line-height: 1.62;
}

.faq-micro {
 margin-top: 14px;
 text-align: center;
 color: #64748b;
 font-size: 0.86rem;
}

.system-action-wrap {
 max-width: 1060px;
 margin: 0 auto;
}

.system-action-grid {
 display: grid;
 grid-template-columns: repeat(7, minmax(0, 1fr));
 gap: 10px;
 margin-top: 28px;
}

.system-step {
 background: #ffffff;
 border: 1px solid #e2e8f0;
 border-radius: 12px;
 padding: 14px 12px;
 text-align: left;
 box-shadow: 0 3px 14px rgba(15,23,42,0.05);
 min-height: 138px;
}

.system-step-index {
 display: inline-flex;
 align-items: center;
 justify-content: center;
 width: 24px;
 height: 24px;
 border-radius: 999px;
 background: #eef2ff;
 color: #4338ca;
 font-size: 0.75rem;
 font-weight: 700;
 margin-bottom: 8px;
}

.system-step-title {
 color: #0f172a;
 font-size: 0.9rem;
 font-weight: 700;
 margin-bottom: 5px;
 line-height: 1.35;
}

.system-step-copy {
 color: #64748b;
 font-size: 0.82rem;
 line-height: 1.45;
 margin: 0;
}

.system-action-cta {
 margin-top: 24px;
 text-align: center;
}

.comparatif-wrap {
 max-width: 1120px;
 margin: 0 auto;
}

.comparatif-grid {
 margin-top: 30px;
 border: 1px solid #e2e8f0;
 border-radius: 16px;
 background: #ffffff;
 overflow: hidden;
 box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
}

.comparatif-head,
.comparatif-row {
 display: grid;
 grid-template-columns: minmax(220px, 1.3fr) repeat(3, minmax(0, 1fr));
}

.comparatif-head {
 background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
}

.comparatif-head > div {
 padding: 16px 14px;
 border-bottom: 1px solid #e2e8f0;
 font-size: 0.86rem;
 font-weight: 700;
 color: #0f172a;
}

.comparatif-head .is-ecosysteme {
 color: #4338ca;
}

.comparatif-row > div {
 padding: 14px;
 border-bottom: 1px solid #edf2f7;
 border-right: 1px solid #edf2f7;
 font-size: 0.88rem;
 color: #334155;
}

.comparatif-row:last-child > div {
 border-bottom: 0;
}

.comparatif-row > div:last-child,
.comparatif-head > div:last-child {
 border-right: 0;
}

.comparatif-critere {
 font-weight: 700;
 color: #0f172a;
}

.comparatif-ok {
 color: #14532d;
 font-weight: 600;
}

.comparatif-mid {
 color: #1e3a8a;
 font-weight: 600;
}

.comparatif-no {
 color: #7c2d12;
 font-weight: 600;
}

.comparatif-note {
 margin-top: 18px;
 color: #64748b;
 font-size: 0.9rem;
 text-align: center;
}

@media (max-width: 1200px) {
 .system-action-grid {
 grid-template-columns: repeat(4, minmax(0, 1fr));
 }
}

@media (max-width: 992px) {
 .hero-premium { padding: 84px 0 64px; }
 .hero-proof-row { grid-template-columns: 1fr; max-width: 460px; }
 .pricing-grid { grid-template-columns: 1fr; max-width: 560px; }
 .pricing-card.is-featured { transform: none; }
 .pricing-faq { grid-template-columns: 1fr; max-width: 560px; }
 .proof-grid { grid-template-columns: 1fr; max-width: 560px; }
 .founder-wrap { grid-template-columns: 1fr; max-width: 560px; }
 .founder-photo { max-width: 220px; margin: 0 auto; }
 .founder-beliefs { grid-template-columns: 1fr; }
 .system-action-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
 .comparatif-head,
 .comparatif-row { grid-template-columns: minmax(160px, 1fr) repeat(3, minmax(130px, 1fr)); }
}

@media (max-width: 640px) {
 .hero-premium h1 {
 font-size: 2rem !important;
 line-height: 1.25 !important;
 }
 .hero-premium p {
 font-size: 1rem !important;
 line-height: 1.6 !important;
 }
 .hero-funnel-step { font-size: 0.76rem; padding: 7px 10px; }
 .pricing-card { padding: 20px; }
 .pricing-price { font-size: 1.75rem; }
 .faq-question { font-size: 0.93rem; }
 .system-action-grid { grid-template-columns: 1fr; }
 .system-step { min-height: auto; }
 .comparatif-grid {
 border: 0;
 background: transparent;
 box-shadow: none;
 }
 .comparatif-head {
 display: none;
 }
 .comparatif-row {
 display: block;
 margin-bottom: 12px;
 border: 1px solid #e2e8f0;
 border-radius: 12px;
 background: #fff;
 box-shadow: 0 4px 14px rgba(15,23,42,0.06);
 }
 .comparatif-row > div {
 border-right: 0;
 border-bottom: 1px dashed #e2e8f0;
 padding: 10px 12px;
 display: flex;
 justify-content: space-between;
 gap: 12px;
 font-size: 0.84rem;
 }
 .comparatif-row > div::before {
 content: attr(data-label);
 color: #64748b;
 font-weight: 600;
 min-width: 110px;
 }
 .comparatif-row > div:last-child {
 border-bottom: 0;
 }
 .comparatif-critere {
 background: #f8fafc;
 border-radius: 12px 12px 0 0;
 }
}
</style>

<!-- ═══════════ HERO ═══════════ -->
<section class="hero-premium">
 <div class="container">
 <div class="hero-premium-wrap">

 <div class="pi-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white;">
 <span class="pi-pulse" style="background:#FDCB6E;"></span>
 Exclusivit&eacute; territoriale &mdash; 1 conseiller par zone
 </div>

 <h1 style="font-size:2.75rem; font-weight:800; line-height:1.18; margin-bottom:18px; color:white;">
 Devenez le conseiller r&eacute;f&eacute;rent de votre ville<br>et attirez des vendeurs qualifi&eacute;s en continu
 </h1>

 <p style="font-size:1.1rem; opacity:0.96; line-height:1.7; margin-bottom:22px; max-width:760px; margin-left:auto; margin-right:auto;">
 Un syst&egrave;me d'acquisition local pens&eacute; pour les conseillers ind&eacute;pendants :
 <strong>plus de vendeurs entrants</strong>, sans d&eacute;pendre des portails et sans prospection &agrave; froid.
 </p>

 <div class="hero-proof-row">
 <div class="hero-proof-item">5 villes d&eacute;j&agrave; verrouill&eacute;es</div>
 <div class="hero-proof-item">Premiers r&eacute;sultats en moins de 90 jours</div>
 <div class="hero-proof-item">1 seul conseiller par zone</div>
 </div>

 <div class="hero-funnel">
 <div class="hero-funnel-steps">
 <span class="hero-funnel-step">Recherche Google</span>
 <span class="hero-funnel-arrow">&rarr;</span>
 <span class="hero-funnel-step">Article local</span>
 <span class="hero-funnel-arrow">&rarr;</span>
 <span class="hero-funnel-step">Estimation</span>
 <span class="hero-funnel-arrow">&rarr;</span>
 <span class="hero-funnel-step">Lead CRM</span>
 <span class="hero-funnel-arrow">&rarr;</span>
 <span class="hero-funnel-step">RDV vendeur</span>
 <span class="hero-funnel-arrow">&rarr;</span>
 <span class="hero-funnel-step">Mandat sign&eacute;</span>
 </div>
 </div>

 <div style="display:flex; gap:15px; justify-content:center; flex-wrap:wrap; margin-bottom:28px;">
 <a href="/front/pages/verifier-ma-ville.php" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:15px 32px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.18); transition:transform 0.2s;">
 V&eacute;rifier si ma ville est disponible
 </a>
 <a href="/front/pages/demo.php" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:13px 30px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:background 0.2s;">
 Voir la d&eacute;mo
 </a>
 </div>

 <p style="font-size:0.86rem; opacity:0.78; margin:0;">
 V&eacute;rification gratuite de votre ville &bull; r&eacute;ponse sous 24h &bull; aucune obligation d'engagement
 </p>
 </div>
 </div>
</section>

<!-- ═══════════ SYSTÈME EN ACTION ═══════════ -->
<section style="padding:88px 0; background:#f8fafc;">
 <div class="container">
 <div class="system-action-wrap">
 <div style="text-align:center;">
 <span class="pi-section-badge" style="background:#dbeafe; color:#1e40af;">Le système en action</span>
 <h2 style="font-size:2.05rem; color:#1a202c; margin-bottom:12px;">Comment un vendeur devient un mandat, étape par étape</h2>
 <p style="font-size:1rem; color:#64748b; margin:0; max-width:760px; margin-left:auto; margin-right:auto;">
 Vous n'avez rien à deviner : le parcours est clair, concret et orienté résultat business.
 </p>
 </div>

 <?php
 $systemSteps = [
 ['titre' => 'Recherche Google', 'copy' => 'Le vendeur cherche une réponse locale dans votre secteur.'],
 ['titre' => 'Contenu local', 'copy' => 'Il trouve votre contenu utile, adapté à sa ville.'],
 ['titre' => 'Avis de valeur', 'copy' => 'Il demande une estimation de son bien en ligne.'],
 ['titre' => 'Lead qualifié', 'copy' => 'La demande arrive avec les infos utiles pour agir vite.'],
 ['titre' => 'Relance CRM', 'copy' => 'Le suivi part automatiquement pour éviter les leads perdus.'],
 ['titre' => 'Rendez-vous', 'copy' => 'Vous échangez avec un vendeur déjà engagé dans sa démarche.'],
 ['titre' => 'Mandat', 'copy' => 'Vous transformez une demande locale en opportunité concrète.'],
 ];
 ?>

 <div class="system-action-grid">
 <?php foreach ($systemSteps as $i => $step): ?>
 <article class="system-step">
 <span class="system-step-index"><?= $i + 1 ?></span>
 <div class="system-step-title"><?= $step['titre'] ?></div>
 <p class="system-step-copy"><?= $step['copy'] ?></p>
 </article>
 <?php endforeach; ?>
 </div>

 <div class="system-action-cta">
 <a href="/front/pages/verifier-ma-ville.php" style="background:#667eea; color:white; font-weight:700; font-size:1rem; padding:14px 30px; border-radius:11px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 22px rgba(102,126,234,0.28);">
 Vérifier si ma ville est disponible
 </a>
 </div>
 </div>
 </div>
</section>

<!-- ═══════════ COMPARATIF POSITIONNEMENT ═══════════ -->
<section style="padding:90px 0; background:#ffffff;">
 <div class="container">
 <div class="comparatif-wrap">
 <div style="text-align:center;">
 <span class="pi-section-badge" style="background:#ede9fe; color:#5b21b6;">Positionnement</span>
 <h2 style="font-size:2.05rem; color:#1a202c; margin-bottom:12px;">Empiler des outils ou piloter un vrai système&nbsp;?</h2>
 <p style="font-size:1rem; color:#64748b; margin:0; max-width:790px; margin-left:auto; margin-right:auto;">
 Chaque approche a sa logique. Le but ici est de vous montrer, de façon concrète et honnête, ce qui change sur le terrain quand on vise des mandats vendeurs réguliers.
 </p>
 </div>

 <div class="comparatif-grid">
 <div class="comparatif-head">
 <div>Critères clés</div>
 <div>Outils classiques</div>
 <div>SaaS générique</div>
 <div class="is-ecosysteme">Écosystème Immo</div>
 </div>

 <?php
 $comparatifRows = [
 ['critere' => 'Méthode', 'outils' => 'Actions dispersées', 'saas' => 'Cadre global standard', 'ecosysteme' => 'Méthode locale structurée'],
 ['critere' => 'SEO local', 'outils' => 'Souvent absent', 'saas' => 'Fonction partielle', 'ecosysteme' => 'Plan éditorial orienté ville'],
 ['critere' => 'Exclusivité territoriale', 'outils' => 'Non prévue', 'saas' => 'Rare', 'ecosysteme' => '1 conseiller par zone'],
 ['critere' => 'CRM connecté', 'outils' => 'Connexions manuelles', 'saas' => 'Connecteurs limités', 'ecosysteme' => 'Suivi lead et relance intégrés'],
 ['critere' => 'Accompagnement', 'outils' => 'Support ponctuel', 'saas' => 'Support produit', 'ecosysteme' => 'Accompagnement orienté résultats'],
 ['critere' => 'IA contextuelle', 'outils' => 'Utilisation isolée', 'saas' => 'IA généraliste', 'ecosysteme' => 'IA nourrie par votre contexte local'],
 ['critere' => 'Tunnel orienté vendeur', 'outils' => 'À construire seul', 'saas' => 'Base non spécialisée', 'ecosysteme' => 'Tunnel pensé pour capter du vendeur'],
 ];
 ?>

 <?php foreach ($comparatifRows as $row): ?>
 <div class="comparatif-row">
 <div class="comparatif-critere" data-label="Critère"><?= $row['critere'] ?></div>
 <div class="comparatif-no" data-label="Outils"><?= $row['outils'] ?></div>
 <div class="comparatif-mid" data-label="SaaS"><?= $row['saas'] ?></div>
 <div class="comparatif-ok" data-label="Écosystème"><?= $row['ecosysteme'] ?></div>
 </div>
 <?php endforeach; ?>
 </div>

 <p class="comparatif-note">
 Notre promesse n'est pas d'opposer des outils, mais d'orchestrer un système complet qui fait gagner du temps et sécurise la conquête locale.
 </p>
 </div>
 </div>
</section>

<!-- ═══════════ PROBLÈME ═══════════ -->
<section style="padding:90px 0; background:#f7fafc;">
 <div class="container">
 <div style="text-align:center; margin-bottom:55px;">
 <span class="pi-section-badge" style="background:#fee2e2; color:#991b1b;"> Le Probl&egrave;me</span>
 <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:0;">Si vous &ecirc;tes agent ou mandataire,<br>vous vivez probablement &ccedil;a</h2>
 </div>

 <div style="max-width:760px; margin:0 auto; display:grid; gap:14px;">

 <?php
 $problems = [
 ['', 'Trop d\'outils, pas de syst&egrave;me',
 'Un CRM, un site, des emails, des r&eacute;seaux sociaux&hellip; Mais rien n\'est r&eacute;ellement connect&eacute;. R&eacute;sultat&nbsp;: vous passez votre temps &agrave; copier-coller entre les outils.'],
 ['', 'Invisible sur Google',
 'Votre site existe. Mais quand un vendeur tape &laquo;&nbsp;Estimer maison + votre ville&nbsp;&raquo;, vous n\'apparaissez pas.'],
 ['', 'D&eacute;pendance aux portails et &agrave; la pub',
 'SeLoger. LeBonCoin. Facebook Ads. Vous payez pour exister. Coupez la pub et les leads disparaissent.'],
 ['', 'Pas le temps de faire du marketing',
 'Entre les visites, les estimations, les relances et les compromis&nbsp;: le marketing digital devient impossible &agrave; g&eacute;rer seul.'],
 ];
 foreach ($problems as $p):
 ?>
 <div class="pi-card" style="display:flex; align-items:flex-start; gap:16px; padding:22px; border-left:4px solid #667eea;">
 <span style="font-size:1.7rem; flex-shrink:0;"><?= $p[0] ?></span>
 <div>
 <strong style="color:#1a202c; display:block; margin-bottom:5px;"><?= $p[1] ?></strong>
 <p style="color:#718096; margin:0; font-size:0.94rem; line-height:1.6;"><?= $p[2] ?></p>
 </div>
 </div>
 <?php endforeach; ?>

 </div>

 <div style="text-align:center; margin-top:44px; padding:28px 36px; background:white; border-radius:14px; box-shadow:0 2px 14px rgba(102,126,234,0.1); max-width:620px; margin-left:auto; margin-right:auto;">
 <p style="font-size:1.1rem; color:#1a202c; margin:0; line-height:1.85;">
 Le probl&egrave;me n'est pas votre <strong>motivation</strong>.<br>
 C'est l'absence d'un <strong>syst&egrave;me qui travaille pour vous</strong>.
 </p>
 </div>
 </div>
</section>

<!-- ═══════════ DÉCLIC ═══════════ -->
<section style="padding:90px 0;">
 <div class="container">
 <div style="text-align:center; margin-bottom:50px;">
 <span class="pi-section-badge" style="background:#fef3c7; color:#92400e;"> Le D&eacute;clic</span>
 <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:0;">Les outils sans m&eacute;thode ne servent &agrave; rien</h2>
 </div>

 <div style="max-width:680px; margin:0 auto; text-align:center; margin-bottom:44px;">
 <p style="font-size:1.15rem; color:#4a5568; line-height:1.85; margin-bottom:20px;">
 Vous pouvez avoir&nbsp;: le meilleur CRM, un beau site, des campagnes publicitaires.<br>
 Mais si vous ne savez pas <strong>&agrave; qui parler</strong>, <strong>quoi dire</strong> et <strong>o&ugrave; le diffuser</strong>&hellip;
 </p>
 <p style="font-size:1.25rem; color:#1a202c; font-weight:700; margin:0;">
 &hellip;vous avez simplement un outil de plus qui prend la poussi&egrave;re.
 </p>
 </div>

 <div style="padding:28px 32px; background:#f7fafc; border-left:4px solid #667eea; border-radius:0 12px 12px 0; max-width:640px; margin:0 auto;">
 <p style="color:#2d3748; margin:0; font-style:italic; font-size:1.05rem; line-height:1.7;">
 &laquo;&nbsp;La diff&eacute;rence entre un ind&eacute;pendant qui gal&egrave;re et un ind&eacute;pendant qui cartonne&nbsp;? Ce n'est pas le talent. C'est le syst&egrave;me.&nbsp;&raquo;
 </p>
 </div>
 </div>
</section>

<!-- ═══════════ MÉTHODE ═══════════ -->
<section style="padding:90px 0; background:#f7fafc;" id="methode">
 <div class="container">
 <div style="text-align:center; margin-bottom:60px;">
 <span class="pi-section-badge" style="background:#dbeafe; color:#1e40af;"> La M&eacute;thode</span>
 <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:12px;">3 leviers pour attirer vos vendeurs</h2>
 <p style="font-size:1.05rem; color:#718096; margin:0;">Sans pub, sans portails, sans d&eacute;pendance</p>
 </div>

 <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(270px,1fr)); gap:24px; max-width:920px; margin:0 auto 50px;">
 <?php
 $steps = [
 ['', '1 &mdash; PERSONA', 'Comprendre vos vendeurs',
 'Qui sont-ils&nbsp;? vendeurs seniors, familles qui d&eacute;m&eacute;nagent, investisseurs&hellip; L\'assistant IA identifie leurs motivations, leurs blocages et leurs objections.'],
 ['', '2 &mdash; CONTENU', 'Savoir quoi leur dire',
 'L\'IA g&eacute;n&egrave;re automatiquement&nbsp;: articles SEO, posts r&eacute;seaux, emails, guides vendeurs. Chaque contenu correspond &agrave; une &eacute;tape du parcours vendeur.'],
 ['', '3 &mdash; TRAFIC', 'Les atteindre au bon endroit',
 'Vos contenus sont diffus&eacute;s sur Google, votre blog, votre fiche Google, vos r&eacute;seaux. Objectif&nbsp;: attirer des vendeurs avant m&ecirc;me qu\'ils contactent un agent.'],
 ];
 foreach ($steps as $s):
 ?>
 <div class="pi-card" style="padding:32px; text-align:center;">
 <div style="font-size:2.4rem; margin-bottom:14px;"><?= $s[0] ?></div>
 <h3 style="color:#1a202c; margin-bottom:8px; font-size:1.1rem; letter-spacing:0.04em;"><?= $s[1] ?></h3>
 <p style="color:#667eea; font-weight:600; margin-bottom:12px; font-size:0.95rem;"><?= $s[2] ?></p>
 <p style="color:#718096; margin:0; font-size:0.91rem; line-height:1.6;"><?= $s[3] ?></p>
 </div>
 <?php endforeach; ?>
 </div>

 <!-- Flux mandat -->
 <div style="background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.07); max-width:860px; margin:0 auto; padding:36px; text-align:center;">
 <p style="font-size:0.88rem; font-weight:600; color:#718096; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:22px;"> Comment le syst&egrave;me g&eacute;n&egrave;re des mandats</p>
 <div style="display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:0;">
 <?php
 $flow = ['Recherche Google','Article local','Estimation','Lead CRM','RDV vendeur','Mandat sign&eacute;'];
 foreach ($flow as $i => $f):
 ?>
 <div class="pi-flow-box"><?= $f ?></div>
 <?php if ($i < count($flow)-1): ?>
 <span class="pi-flow-arrow">&#8594;</span>
 <?php endif; endforeach; ?>
 </div>
 <p style="margin-top:18px; font-size:0.88rem; color:#718096; margin-bottom:0;">Le syst&egrave;me travaille 24h/24, m&ecirc;me quand vous &ecirc;tes en visite.</p>
 </div>

 <!-- SaaS vs Écosystème -->
 <div style="padding:28px; background:white; border-radius:14px; box-shadow:0 4px 18px rgba(0,0,0,0.07); max-width:620px; margin:30px auto 0; text-align:center;">
 <p style="font-size:0.9rem; font-weight:700; color:#1a202c; margin-bottom:18px; text-transform:uppercase; letter-spacing:0.05em;">La vraie diff&eacute;rence</p>
 <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
 <div style="padding:18px; background:#fee2e2; border-radius:10px;">
 <strong style="color:#991b1b; display:block; margin-bottom:6px;"> SaaS classiques</strong>
 <p style="color:#b91c1c; margin:0; font-size:0.87rem;">&laquo;&nbsp;Voici les outils, d&eacute;brouille-toi&nbsp;&raquo;</p>
 </div>
 <div style="padding:18px; background:#d1fae5; border-radius:10px;">
 <strong style="color:#065f46; display:block; margin-bottom:6px;"> &Eacute;COSYST&Egrave;ME IMMO</strong>
 <p style="color:#047857; margin:0; font-size:0.87rem;">&laquo;&nbsp;Voici la m&eacute;thode + les outils&nbsp;&raquo;</p>
 </div>
 </div>
 </div>
 </div>
</section>

<!-- ═══════════ MODULES ═══════════ -->
<section style="padding:90px 0;">
 <div class="container">
 <div style="text-align:center; margin-bottom:60px;">
 <span class="pi-section-badge" style="background:#e9d5ff; color:#6b21a8;"> La Plateforme</span>
 <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:12px;">Une plateforme compl&egrave;te &mdash; tout est int&eacute;gr&eacute;</h2>
 <p style="font-size:1.05rem; color:#718096; margin:0;">Pas besoin d'empiler les outils. Tout est connect&eacute;.</p>
 </div>

 <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(255px,1fr)); gap:18px; max-width:1040px; margin:0 auto;">
 <?php
 $modules = [
 ['', 'Site immobilier professionnel', 'Pages g&eacute;olocalis&eacute;es optimis&eacute;es pour Google.'],
 ['', 'Blog SEO local', 'Articles con&ccedil;us pour attirer les vendeurs de votre secteur.'],
 ['', 'Pages de capture', 'Landing pages illimit&eacute;es, templates optimis&eacute;s, suivi conversions.'],
 ['', 'CRM immobilier', 'Suivi des contacts, leads, mandats. Pipeline complet.'],
 ['', 'Automatisations', 'Emails, SMS et relances automatiques. Le syst&egrave;me tourne 24/7.'],
 ['', 'Assistant IA', 'G&eacute;n&eacute;ration instantan&eacute;e de contenus, emails, posts, descriptions.'],
 ['', 'Dashboard temps r&eacute;el', 'Leads, RDV, mandats, commissions en un coup d\'&#339;il.'],
 ['', 'Estimateur en ligne', 'Un outil qui capture des vendeurs 24h/24 sur votre site.'],
 ['', 'GMB int&eacute;gr&eacute;', 'Fiche Google optimis&eacute;e, avis, publications pilot&eacute;es depuis la plateforme.'],
 ];
 foreach ($modules as $m):
 ?>
 <div class="pi-card" style="padding:22px; border-left:4px solid #667eea;">
 <div style="font-size:1.7rem; margin-bottom:9px;"><?= $m[0] ?></div>
 <strong style="color:#1a202c; font-size:0.97rem;"><?= $m[1] ?></strong>
 <p style="color:#718096; margin:7px 0 0; font-size:0.88rem; line-height:1.5;"><?= $m[2] ?></p>
 </div>
 <?php endforeach; ?>
 </div>
 </div>
</section>

<!-- ═══════════ EXCLUSIVITÉ ═══════════ -->
<section style="padding:90px 0; background:#f7fafc;">
 <div class="container">
 <div style="text-align:center; margin-bottom:55px;">
 <span class="pi-section-badge" style="background:#fce7f3; color:#be123c;"> L'Exclusivit&eacute;</span>
 <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:0;">L'avantage que personne ne peut copier</h2>
 </div>

 <div style="max-width:760px; margin:0 auto;">

 <div style="text-align:center; margin-bottom:36px; padding:30px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:16px;">
 <p style="font-size:1.45rem; color:white; font-weight:700; margin:0; line-height:1.4;">
 1 ville = 1 seul partenaire &Eacute;COSYST&Egrave;ME IMMO
 </p>
 </div>

 <div style="display:grid; gap:16px; margin-bottom:36px;">
 <?php
 $excl = [
 ['', 'Aucune concurrence interne',
 'Votre concurrent local ne peut pas utiliser le m&ecirc;me syst&egrave;me que vous.'],
 ['', 'SEO local prot&eacute;g&eacute;',
 'Votre r&eacute;f&eacute;rencement ne sera jamais dilu&eacute; par d\'autres utilisateurs dans votre zone.'],
 ['', 'Investissement s&eacute;curis&eacute;',
 'La position digitale que vous construisez vous appartient. Personne ne peut la dupliquer.'],
 ];
 foreach ($excl as $e):
 ?>
 <div class="pi-card" style="display:flex; align-items:flex-start; gap:16px; padding:22px; border-left:4px solid #667eea;">
 <span style="font-size:1.6rem; flex-shrink:0;"><?= $e[0] ?></span>
 <div>
 <strong style="color:#1a202c; display:block; margin-bottom:5px;"><?= $e[1] ?></strong>
 <p style="color:#718096; margin:0; font-size:0.93rem; line-height:1.6;"><?= $e[2] ?></p>
 </div>
 </div>
 <?php endforeach; ?>
 </div>

 <div style="padding:24px 28px; background:white; border-left:4px solid #667eea; border-radius:0 12px 12px 0; margin-bottom:24px;">
 <p style="color:#2d3748; margin:0; font-style:italic; font-size:1.0rem; line-height:1.7;">
 &laquo;&nbsp;Les SaaS classiques veulent 10 000 clients. Nous sommes limit&eacute;s &agrave; ~500 zones. C'est ce qui garantit que le syst&egrave;me fonctionne <strong>pour vous</strong>.&nbsp;&raquo;
 </p>
 </div>

 <div style="text-align:center; padding:18px 24px; background:#fee2e2; border-radius:12px; border:1px solid #fecaca;">
 <p style="color:#991b1b; margin:0; font-weight:600; font-size:0.94rem;">
 Villes d&eacute;j&agrave; r&eacute;serv&eacute;es&nbsp;: Bordeaux &mdash; Nantes &mdash; Nandy &mdash; Aix-en-Provence &mdash; Lannion<br>
 <span style="font-weight:400; font-size:0.88rem;">Une fois r&eacute;serv&eacute;e, une ville est d&eacute;finitivement verrouill&eacute;e.</span>
 </p>
 </div>
 </div>
 </div>
</section>

<!-- ═══════════ RÉSULTATS ═══════════ -->
<section style="padding:90px 0;">
 <div class="container">
 <div style="text-align:center; margin-bottom:55px;">
 <span class="pi-section-badge" style="background:#c7d2fe; color:#3730a3;"> Ce que &ccedil;a change</span>
 <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:0;">Ce que &ccedil;a change pour vous</h2>
 </div>

 <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(270px,1fr)); gap:18px; max-width:920px; margin:0 auto;">
 <?php
 $results = [
 ['', 'Attirer sans prospecter', 'Les vendeurs viennent &agrave; vous gr&acirc;ce &agrave; votre pr&eacute;sence digitale.'],
 ['', 'R&eacute;duire la d&eacute;pendance aux portails', 'Le SEO et le contenu travaillent en continu, sans budget pub.'],
 ['', 'Gagner du temps', 'Les automatisations et l\'IA g&egrave;rent le marketing r&eacute;p&eacute;titif.'],
 ['', 'Devenir la r&eacute;f&eacute;rence locale', 'Votre nom devient associ&eacute; &agrave; l\'immobilier dans votre secteur.'],
 ['', 'Prospects qualifi&eacute;s', 'Les tunnels filtrent&nbsp;: vous ne parlez qu\'aux pr&ecirc;ts &agrave; vendre.'],
 ['', 'Position prot&eacute;g&eacute;e', 'L\'exclusivit&eacute; garantit que vous restez seul sur votre zone.'],
 ];
 foreach ($results as $r):
 ?>
 <div class="pi-card" style="padding:26px; text-align:center;">
 <div style="font-size:1.8rem; margin-bottom:10px;"><?= $r[0] ?></div>
 <strong style="color:#1a202c; font-size:0.97rem;"><?= $r[1] ?></strong>
 <p style="color:#718096; margin:8px 0 0; font-size:0.88rem; line-height:1.55;"><?= $r[2] ?></p>
 </div>
 <?php endforeach; ?>
 </div>
 </div>
</section>

<!-- ═══════════ PREUVES RÉELLES ═══════════ -->
<section style="padding:90px 0; background:#ffffff;">
 <div class="container">
 <div style="text-align:center; margin-bottom:44px;">
 <span class="pi-section-badge" style="background:#ecfeff; color:#0f766e;">Conseillers d&eacute;j&agrave; en place</span>
 <h2 style="font-size:2.05rem; color:#1a202c; margin-bottom:12px;">Une base solide, ville par ville</h2>
 <p style="font-size:1.01rem; color:#64748b; margin:0; max-width:760px; margin-left:auto; margin-right:auto;">
 Nous publions uniquement des informations v&eacute;rifi&eacute;es&nbsp;: zones ferm&eacute;es, conseillers d&eacute;ploy&eacute;s et activations en cours.
 Pas de faux avis, pas de chiffres invent&eacute;s.
 </p>
 </div>

 <div class="proof-grid">
 <?php
 $proofAdvisors = [
 ['initiales' => 'ED', 'nom' => 'Eduardo De Sul', 'zone' => 'Bordeaux M&eacute;tropole', 'statut' => 'D&eacute;ploy&eacute;'],
 ['initiales' => 'SH', 'nom' => 'St&eacute;phanie Hulen', 'zone' => 'Lannion / Tr&eacute;gor', 'statut' => 'D&eacute;ploy&eacute;'],
 ['initiales' => 'PH', 'nom' => 'Pascal Hamm', 'zone' => 'Aix-en-Provence', 'statut' => 'D&eacute;ploy&eacute;'],
 ['initiales' => 'FR', 'nom' => 'Fatima Rabia', 'zone' => 'Nandy / S&eacute;nart', 'statut' => 'D&eacute;ploy&eacute;'],
 ['initiales' => 'BC', 'nom' => 'Brice Chupin', 'zone' => 'Nantes', 'statut' => 'D&eacute;ploy&eacute;'],
 ];
 foreach ($proofAdvisors as $advisor):
 ?>
 <article class="proof-card">
 <div class="proof-head">
 <div class="proof-avatar"><?= $advisor['initiales'] ?></div>
 <div>
 <div class="proof-name"><?= $advisor['nom'] ?></div>
 <div style="font-size:0.8rem; color:#94a3b8;">Partenaire fondateur</div>
 </div>
 </div>
 <p class="proof-zone"><?= $advisor['zone'] ?></p>
 <span class="proof-status"><?= $advisor['statut'] ?></span>
 </article>
 <?php endforeach; ?>
 </div>

 <p class="proof-note">
 Villes actuellement ferm&eacute;es&nbsp;: Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion.
 Cette section est volontairement factuelle et sera enrichie au fur et &agrave; mesure avec des retours clients document&eacute;s (photo, contexte, cas d'usage).
 </p>
 </div>
</section>

<!-- ═══════════ FONDATEUR ═══════════ -->
<section style="padding:90px 0; background:#f8fafc;">
 <div class="container">
 <div class="founder-wrap">
 <div class="founder-photo">
 Emplacement photo<br>Olivier Colas
 </div>

 <article class="founder-card">
 <span class="founder-meta">Fondateur</span>
 <h2 class="founder-title">Pourquoi Olivier Colas a cr&eacute;&eacute; &Eacute;COSYST&Egrave;ME IMMO LOCAL+</h2>
 <p class="founder-text">
 Apr&egrave;s des ann&eacute;es en marketing, acquisition et conception d'&eacute;cosyst&egrave;mes strat&eacute;giques, Olivier a fait le m&ecirc;me constat sur le terrain&nbsp;:
 trop d'outils empil&eacute;s, trop de d&eacute;pendance aux portails, et un marketing souvent flou.
 </p>
 <p class="founder-text" style="margin-bottom:0;">
 Sa mission est simple&nbsp;: aider les conseillers immobiliers ind&eacute;pendants &agrave; devenir la r&eacute;f&eacute;rence locale de leur secteur avec un syst&egrave;me clair,
 utile, concret et orient&eacute; r&eacute;sultats.
 </p>

 <div class="founder-beliefs">
 <div class="founder-belief ok">
 <strong>Ce que je crois</strong><br>
 Une strat&eacute;gie locale claire, bien ex&eacute;cut&eacute;e, vaut mieux qu'une collection d'outils.
 </div>
 <div class="founder-belief no">
 <strong>Ce que je refuse</strong><br>
 Vendre de la complexit&eacute; ou des promesses vagues qui n'aident pas &agrave; signer plus de mandats.
 </div>
 </div>
 </article>
 </div>
 </div>
</section>

<!-- ═══════════ PRICING ═══════════ -->
<section style="padding:90px 0; background:#f7fafc;">
 <div class="container">
 <div style="text-align:center; margin-bottom:44px;">
 <span class="pi-section-badge" style="background:#dbeafe; color:#1e40af;">Tarifs</span>
 <h2 style="font-size:2.1rem; color:#1a202c; margin-bottom:12px;">Choisissez votre rythme de d&eacute;ploiement local</h2>
 <p style="font-size:1.02rem; color:#64748b; margin:0; max-width:720px; margin-left:auto; margin-right:auto;">
 Des offres pens&eacute;es pour un objectif simple&nbsp;: g&eacute;n&eacute;rer des vendeurs qualifi&eacute;s dans votre zone et convertir en mandats.
 </p>
 </div>

 <div class="pricing-grid">
 <article class="pricing-card">
 <span class="pricing-badge">Entr&eacute;e rapide</span>
 <h3 class="pricing-title">Estimateur seul</h3>
 <p class="pricing-price">27&euro;/mois</p>
 <p class="pricing-price-sub">+ 197&euro; setup</p>
 <ul class="pricing-features">
 <li>Estimateur local install&eacute; sur votre site</li>
 <li>Capture des demandes vendeurs 24h/24</li>
 <li>Suivi des leads entrants</li>
 </ul>
 <div class="pricing-actions">
 <a href="/front/pages/verifier-ma-ville.php" style="background:#667eea; color:#fff; font-weight:600; padding:11px 14px; border-radius:9px; text-decoration:none; text-align:center;">V&eacute;rifier ma ville</a>
 <a href="/front/pages/rdv.php" style="background:#fff; color:#667eea; border:1px solid #c7d2fe; font-weight:600; padding:10px 14px; border-radius:9px; text-decoration:none; text-align:center;">R&eacute;server un appel d&eacute;couverte</a>
 </div>
 </article>

 <article class="pricing-card is-featured">
 <span class="pricing-badge" style="background:#ede9fe; color:#5b21b6;">Offre recommand&eacute;e</span>
 <h3 class="pricing-title">Standard mensuel</h3>
 <p class="pricing-price">97&euro;/mois</p>
 <p class="pricing-price-sub">+ 497&euro; setup &bull; 3 mois pr&eacute;pay&eacute;s</p>
 <ul class="pricing-features">
 <li>Syst&egrave;me d'acquisition local complet</li>
 <li>Tunnel vendeur : visibilit&eacute; &rarr; estimation &rarr; rendez-vous</li>
 <li>Pilotage centralis&eacute; des opportunit&eacute;s</li>
 </ul>
 <div class="pricing-actions">
 <a href="/front/pages/verifier-ma-ville.php" style="background:#667eea; color:#fff; font-weight:600; padding:11px 14px; border-radius:9px; text-decoration:none; text-align:center;">V&eacute;rifier ma ville</a>
 <a href="/front/pages/rdv.php" style="background:#fff; color:#667eea; border:1px solid #c7d2fe; font-weight:600; padding:10px 14px; border-radius:9px; text-decoration:none; text-align:center;">R&eacute;server un appel d&eacute;couverte</a>
 </div>
 </article>

 <article class="pricing-card">
 <span class="pricing-badge">Position dominante</span>
 <h3 class="pricing-title">Annuel</h3>
 <p class="pricing-price">897&euro;/an</p>
 <p class="pricing-price-sub">Setup offert &bull; exclusivit&eacute; incluse</p>
 <ul class="pricing-features">
 <li>D&eacute;ploiement prioritaire et continuit&eacute; annuelle</li>
 <li>Exclusivit&eacute; territoriale int&eacute;gr&eacute;e &agrave; l'offre</li>
 <li>Co&ucirc;t optimis&eacute; pour votre marge annuelle</li>
 </ul>
 <div class="pricing-actions">
 <a href="/front/pages/verifier-ma-ville.php" style="background:#667eea; color:#fff; font-weight:600; padding:11px 14px; border-radius:9px; text-decoration:none; text-align:center;">V&eacute;rifier ma ville</a>
 <a href="/front/pages/rdv.php" style="background:#fff; color:#667eea; border:1px solid #c7d2fe; font-weight:600; padding:10px 14px; border-radius:9px; text-decoration:none; text-align:center;">R&eacute;server un appel d&eacute;couverte</a>
 </div>
 </article>
 </div>

 <p class="pricing-note">
 Un seul mandat peut rentabiliser plusieurs mois d'abonnement. Option compl&eacute;mentaire&nbsp;: exclusivit&eacute; verrouill&eacute;e &agrave; 900&euro; (paiement unique) sur certaines offres.
 </p>
 <p style="text-align:center; margin-top:12px; font-size:0.87rem; color:#64748b;">
 Acc&egrave;s fondateur disponible selon les zones ouvertes, apr&egrave;s validation.
 </p>

 <div class="pricing-faq">
 <div class="pricing-faq-item">
 <strong>Pourquoi demander 3 mois pr&eacute;pay&eacute;s sur l'offre standard&nbsp;?</strong>
 <p>Pour laisser le temps au syst&egrave;me local de produire ses premiers r&eacute;sultats r&eacute;els et mesurer l'impact sur vos rendez-vous vendeurs.</p>
 </div>
 <div class="pricing-faq-item">
 <strong>L'exclusivit&eacute; &agrave; 900&euro; est-elle obligatoire&nbsp;?</strong>
 <p>Non. C'est une option selon votre zone et votre strat&eacute;gie. L'offre annuelle inclut d&eacute;j&agrave; l'exclusivit&eacute; territoriale.</p>
 </div>
 </div>
 </div>
</section>

<!-- ═══════════ FAQ CONVERSION ═══════════ -->
<section style="padding:90px 0; background:#ffffff;">
 <div class="container">
 <div class="faq-wrap">
 <div style="text-align:center; margin-bottom:34px;">
 <span class="pi-section-badge" style="background:#ede9fe; color:#5b21b6;">FAQ</span>
 <h2 style="font-size:2.05rem; color:#1a202c; margin-bottom:12px;">Questions fr&eacute;quentes avant de r&eacute;server votre ville</h2>
 <p style="font-size:1rem; color:#64748b; margin:0; max-width:740px; margin-left:auto; margin-right:auto;">
 Des r&eacute;ponses courtes et concr&egrave;tes pour vous aider &agrave; d&eacute;cider rapidement.
 </p>
 </div>

 <?php
 $faqItems = [
 ['q' => 'Combien &ccedil;a co&ucirc;te&nbsp;?', 'a' => 'Trois formats&nbsp;: Estimateur seul (27&euro;/mois + 197&euro; setup), Standard (97&euro;/mois + 497&euro; setup + 3 mois pr&eacute;pay&eacute;s), Annuel (897&euro;/an, setup offert, exclusivit&eacute; incluse).'],
 ['q' => 'En combien de temps puis-je &ecirc;tre en ligne&nbsp;?', 'a' => 'En g&eacute;n&eacute;ral, le d&eacute;ploiement d&eacute;marre sous quelques jours apr&egrave;s validation de votre zone et des &eacute;l&eacute;ments de base.'],
 ['q' => 'Est-ce que &ccedil;a fonctionne si ma ville est petite&nbsp;?', 'a' => 'Oui, tant qu\'il y a une demande locale. L\'approche est adapt&eacute;e &agrave; votre zone, pas copi&eacute;e-coll&eacute;e d\'une grande ville.'],
 ['q' => 'Est-ce que je peux arr&ecirc;ter&nbsp;?', 'a' => 'Oui. Les modalit&eacute;s sont clarifi&eacute;es avant validation. L\'objectif est un partenariat utile, pas un engagement subi.'],
 ['q' => 'Est-ce compatible avec mon r&eacute;seau ou mon site actuel&nbsp;?', 'a' => 'Oui. On adapte l\'int&eacute;gration &agrave; votre contexte actuel pour &eacute;viter de repartir de z&eacute;ro inutilement.'],
 ['q' => 'Dois-je &ecirc;tre &agrave; l\'aise avec la technique&nbsp;?', 'a' => 'Non. Vous &ecirc;tes accompagn&eacute; pas &agrave; pas. Le syst&egrave;me est pens&eacute; pour des conseillers terrain, pas pour des techniciens.'],
 ['q' => 'Que se passe-t-il si ma ville est d&eacute;j&agrave; r&eacute;serv&eacute;e&nbsp;?', 'a' => 'La zone reste ferm&eacute;e. Nous regardons avec vous les alternatives de secteur les plus pertinentes.'],
 ['q' => 'Quelle diff&eacute;rence avec un CRM classique ou un site WordPress&nbsp;?', 'a' => 'Un CRM ou un site seul ne suffit pas. Ici, vous avez un syst&egrave;me local complet orient&eacute; acquisition vendeurs + exclusivit&eacute; territoriale.'],
 ['q' => 'Que comprend l\'accompagnement&nbsp;?', 'a' => 'Configuration initiale, cadrage local, mise en route, et suivi pour que le syst&egrave;me soit r&eacute;ellement utilis&eacute; au quotidien.'],
 ['q' => 'Est-ce que mes donn&eacute;es m\'appartiennent&nbsp;?', 'a' => 'Oui. Vos donn&eacute;es, vos contenus et vos leads restent sous votre contr&ocirc;le.'],
 ];
 ?>

 <div class="faq-list" id="faqList">
 <?php foreach ($faqItems as $i => $item): ?>
 <article class="faq-item">
 <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-<?= $i ?>" id="faq-question-<?= $i ?>">
 <span><?= $item['q'] ?></span>
 <span class="faq-chevron"></span>
 </button>
 <div class="faq-answer" id="faq-answer-<?= $i ?>" role="region" aria-labelledby="faq-question-<?= $i ?>">
 <div class="faq-answer-inner"><?= $item['a'] ?></div>
 </div>
 </article>
 <?php endforeach; ?>
 </div>

 <p class="faq-micro">
 Une question plus sp&eacute;cifique sur votre zone ? V&eacute;rifiez la disponibilit&eacute; puis r&eacute;servez un appel.
 </p>
 </div>
 </div>
</section>

<script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "FAQPage",
 "mainEntity": [
<?php foreach ($faqItems as $i => $item): ?>
 {
 "@type": "Question",
 "name": <?= json_encode(html_entity_decode(strip_tags($item['q']), ENT_QUOTES, 'UTF-8'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
 "acceptedAnswer": {
 "@type": "Answer",
 "text": <?= json_encode(html_entity_decode(strip_tags($item['a']), ENT_QUOTES, 'UTF-8'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
 }
 }<?= $i < count($faqItems)-1 ? ',' : '' ?>
<?php endforeach; ?>
 ]
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
 const faqButtons = document.querySelectorAll('.faq-question');
 faqButtons.forEach(function (btn) {
 btn.addEventListener('click', function () {
 const expanded = btn.getAttribute('aria-expanded') === 'true';
 btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
 const answer = document.getElementById(btn.getAttribute('aria-controls'));
 if (!answer) return;
 answer.style.maxHeight = expanded ? '0px' : answer.scrollHeight + 'px';
 });
 });
});
</script>

<!-- ═══════════ CTA FINAL ═══════════ -->
<section style="padding:90px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; text-align:center;">
 <div class="container">
 <div style="max-width:640px; margin:0 auto;">
 <div class="pi-badge" style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; margin-bottom:24px;">
 <span class="pi-pulse" style="background:#FDCB6E;"></span>
 V&eacute;rifiez avant qu'un concurrent ne r&eacute;serve
 </div>
 <h2 style="font-size:2.2rem; color:white; margin-bottom:16px; font-weight:800;">
 Votre ville est-elle encore disponible&nbsp;?
 </h2>
 <p style="font-size:1.1rem; opacity:0.95; margin-bottom:36px; line-height:1.7;">
 Chaque ville ne peut &ecirc;tre attribu&eacute;e qu'&agrave; un seul professionnel.<br>
 Une fois r&eacute;serv&eacute;e, l'acc&egrave;s est d&eacute;finitivement ferm&eacute;.
 </p>
 <div style="display:flex; justify-content:center; gap:15px; flex-wrap:wrap;">
 <a href="/front/pages/verifier-ma-ville.php" style="background:white; color:#667eea; font-weight:700; font-size:1rem; padding:15px 34px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 25px rgba(0,0,0,0.2); transition:transform 0.2s;">
 V&eacute;rifier ma ville maintenant
 </a>
 <a href="/front/pages/demo.php" style="background:transparent; border:2px solid rgba(255,255,255,0.8); color:white; font-weight:600; font-size:1rem; padding:13px 30px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
 Voir la d&eacute;monstration
 </a>
 </div>
 </div>
 </div>
</section>

<?php include 'includes/footer.php'; ?>
