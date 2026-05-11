<?php
declare(strict_types=1);

$page_title = 'Merci — Diagnostic de visibilité locale';
$meta_description = 'Votre demande de diagnostic de visibilité locale est bien reçue. Nous vous recontactons rapidement.';
$body_class = 'page-diagnostic page-diagnostic--merci';
$canonical_url = 'https://ecosystemeimmo.fr/diagnostic-visibilite-locale/merci/';

$leadId = trim((string) ($_GET['lead_id'] ?? ''));

require_once __DIR__ . '/../../includes/nav.php';
?>

<main class="page-diagnostic page-diagnostic--merci">
  <section class="page-header page-header--rdv page-header--diagnostic">
    <div class="container">
      <div class="breadcrumb">
        <a href="/">Accueil</a>
        <span class="breadcrumb-sep">›</span>
        <a href="/diagnostic-visibilite-locale">Diagnostic visibilité locale</a>
        <span class="breadcrumb-sep">›</span>
        <span>Merci</span>
      </div>
      <h1 class="page-header-title">Merci, votre demande est bien reçue.</h1>
      <p class="page-header-subtitle page-header-subtitle--wide">Nous allons analyser votre visibilité locale et revenir vers vous rapidement avec un premier retour concret.</p>
      <?php if ($leadId !== ''): ?>
        <p class="page-header-subtitle" style="margin-top: 12px; font-size: 0.95rem;">Référence de votre demande : <strong>#<?= htmlspecialchars($leadId, ENT_QUOTES, 'UTF-8') ?></strong></p>
      <?php endif; ?>
      <div class="rdv-hero-actions">
        <a href="/audit-fiche-google" class="btn btn-primary btn-lg">Faire un autre diagnostic</a>
        <a href="/" class="btn btn-secondary btn-lg">Retour à l’accueil</a>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="grid grid-2 diagnostic-split">
        <article class="content-block">
          <span class="section-tag">Ce qui se passe maintenant</span>
          <h2 class="section-title">Votre demande est enregistrée</h2>
          <p>Nous avons bien reçu vos informations. Si besoin, nous pouvons vous recontacter pour préciser votre secteur, votre réseau ou votre objectif commercial.</p>
        </article>
        <article class="content-block">
          <span class="section-tag">En attendant</span>
          <h2 class="section-title">Préparez votre prochain levier local</h2>
          <p>Vous pouvez déjà explorer l’audit Google Business Profile pour comparer votre visibilité locale et identifier les priorités les plus rapides.</p>
        </article>
      </div>
    </div>
  </section>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
