<?php
session_start();
if (empty($_SESSION['merci_offre_dedie'])) {
    header('Location: /offre-dedie-qualif', true, 302);
    exit;
}
unset($_SESSION['merci_offre_dedie']);

$pdfPath = __DIR__ . '/assets/docs/offre-dediee-ecosysteme-immo.pdf';
$pdfOk   = is_file($pdfPath);

$page_title       = 'Merci — Votre offre (PDF)';
$meta_description = 'Téléchargez la présentation complète de l\'offre dédiée. Un email de confirmation vous a également été envoyé.';
include 'includes/nav.php';
?>

<main>
  <section class="page-header">
    <div class="container">
      <div class="breadcrumb">
        <a href="/">Accueil</a>
        <span class="breadcrumb-sep">›</span>
        <span>Confirmation</span>
      </div>
      <h1 class="page-header-title">Merci ! Votre qualification est enregistrée.</h1>
      <p class="page-header-subtitle">
        Vous avez reçu un email avec le lien direct vers le PDF. Vous pouvez aussi le télécharger ci-dessous.
      </p>
    </div>
  </section>

  <section class="section">
    <div class="container" style="max-width: 560px; text-align: center;">

      <?php if ($pdfOk): ?>
        <div class="content-block" style="margin-bottom: 24px;">
          <div style="font-size: 3rem; margin-bottom: 16px;">📄</div>
          <h2 class="heading-md" style="margin-bottom: 12px;">Téléchargez la présentation complète</h2>
          <p style="font-size: .9375rem; color: var(--neutral-600); line-height: 1.7; margin-bottom: 24px;">
            Le PDF détaille l'offre dédiée immobilier (paliers, accompagnement, prochaines étapes).
          </p>
          <a href="/assets/docs/offre-dediee-ecosysteme-immo.pdf" class="btn btn-primary btn-lg" download target="_blank" rel="noopener">
            Télécharger l'offre (PDF)
          </a>
        </div>
      <?php else: ?>
        <div class="content-block" style="margin-bottom: 24px;">
          <p style="color: var(--neutral-600);">Vous recevrez l'offre par email dès qu'elle sera disponible en pièce jointe. Merci de votre confiance.</p>
        </div>
      <?php endif; ?>

      <a href="/offres" class="btn btn-secondary">Retour aux offres</a>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
