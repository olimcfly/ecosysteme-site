<?php
declare(strict_types=1);

$page_title = 'Merci — Audit Google Business Profile';
$meta_description = 'Votre demande d’audit Google Business Profile est bien reçue. Nous préparons l’analyse complète.';
$body_class = 'page-gmb-audit page-gmb-audit--merci';
$canonical_url = 'https://ecosystemeimmo.fr/audit-fiche-google/merci/';

$requestPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?: '';
if ($requestPath === '/audit-fiche-google.php') {
    header('Location: /audit-fiche-google/' . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : ''), true, 301);
    exit;
}
if ($requestPath === '/audit-fiche-google-merci.php') {
    header('Location: /audit-fiche-google/merci/' . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : ''), true, 301);
    exit;
}

require_once __DIR__ . '/includes/gmb_audit_helpers.php';

$audit = null;
$auditId = (int) ($_GET['audit_id'] ?? 0);
$token = trim((string) ($_GET['token'] ?? ''));
if ($auditId > 0 && $token !== '') {
    $view = gmb_audit_view_remote($auditId, $token);
    if (!empty($view['ok']) && is_array($view['data']['audit'] ?? null)) {
        $audit = $view['data']['audit'];
    }
}

?>
<?php
$signup_page_minimal_nav = true;
$minimal_nav_tagline = 'Audit gratuit Google Business Profile';
include __DIR__ . '/includes/header.php';
?>

<main class="page-gmb-audit page-gmb-audit--merci">
  <section class="gmb-audit-hero gmb-audit-hero--merci">
    <div class="container">
      <div class="gmb-audit-merci-card">
        <div class="gmb-audit-merci-icon" aria-hidden="true">✓</div>
        <h1>Votre demande d’audit est bien reçue.</h1>
        <p>Nous préparons votre analyse Google Business Profile. Vous restez bien sur le site public Écosystème Immo.</p>
        <a href="/audit-fiche-google" class="btn btn-primary btn-lg">Analyser une autre fiche</a>
      </div>
    </div>
  </section>

  <?php if ($audit !== null): ?>
  <section class="section">
    <div class="container">
      <div class="gmb-audit-results">
        <article class="content-block">
          <span class="section-tag">Aperçu reçu</span>
          <h2 class="section-title">Votre score et vos priorités</h2>
          <div class="gmb-audit-metrics gmb-audit-metrics--full">
            <article><span>Global</span><strong><?= e($audit['global_score'] ?? 0) ?>/100</strong></article>
            <article><span>Visibilité locale</span><strong><?= e($audit['visibility_score'] ?? 0) ?>/100</strong></article>
            <article><span>Confiance</span><strong><?= e($audit['trust_score'] ?? 0) ?>/100</strong></article>
          </div>
        </article>
        <article class="content-block gmb-audit-result-card">
          <span class="section-tag">Opportunité principale</span>
          <h2 class="section-title"><?= e($audit['main_opportunity'] ?? '') ?></h2>
          <p><?= e($audit['short_summary'] ?? '') ?></p>
          <p class="text-base"><strong>Points faibles :</strong> <?= e(implode(' · ', (array) ($audit['weaknesses'] ?? []))) ?></p>
        </article>
      </div>
    </div>
  </section>
  <?php endif; ?>
</main>

<footer class="gmb-audit-footer">
  <div class="container gmb-audit-footer__inner">
    <p><strong>Écosystème Immo</strong> · Audit gratuit Google Business Profile</p>
    <p>Acquisition locale · Séquences email · Suivi CRM · RGPD</p>
  </div>
</footer>

</body>
</html>
