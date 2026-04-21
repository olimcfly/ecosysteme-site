<?php
$page_title = 'Paiement confirmé — Écosystème Immo';
$meta_description = 'Votre paiement a été confirmé. Votre guide est en téléchargement.';

include 'includes/header.php';

$session_id = isset($_GET['session']) ? htmlspecialchars($_GET['session']) : null;
?>

<main>

<section class="page-header">
  <div class="container">
    <h1 class="page-header-title">
      ✓ Paiement confirmé !
    </h1>
    <p class="page-header-subtitle">
      Votre guide est en cours de téléchargement. Vérifiez votre email si rien n'apparaît.
    </p>
  </div>
</section>

<section class="section">
  <div class="container container-md">

    <div style="background: var(--green-50); border: 1px solid var(--green-200); border-radius: var(--radius-lg); padding: 40px; text-align: center; margin-bottom: 40px;">
      <div style="font-size: 3rem; margin-bottom: 16px;">✓</div>
      <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--green-900); margin-bottom: 12px;">
        Merci pour votre achat !
      </h2>
      <p style="color: var(--green-800); line-height: 1.7;">
        Vous avez accès à votre guide. Un email de confirmation avec le lien de téléchargement vient d'être envoyé à votre adresse email.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 48px;">

      <div style="background: var(--white); border: 1px solid var(--neutral-200); border-radius: var(--radius-lg); padding: 28px;">
        <div style="font-size: 1.5rem; margin-bottom: 12px;">📥</div>
        <h3 style="font-weight: 700; color: var(--neutral-900); margin-bottom: 8px;">Email de confirmation</h3>
        <p style="font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.6;">
          Vérifiez votre boîte mail (y compris les spams). Vous y trouverez le lien de téléchargement de votre guide au format PDF.
        </p>
      </div>

      <div style="background: var(--white); border: 1px solid var(--neutral-200); border-radius: var(--radius-lg); padding: 28px;">
        <div style="font-size: 1.5rem; margin-bottom: 12px;">🎓</div>
        <h3 style="font-weight: 700; color: var(--neutral-900); margin-bottom: 8px;">Commencez à lire</h3>
        <p style="font-size: 0.9375rem; color: var(--neutral-600); line-height: 1.6;">
          Le guide est prêt à être utilisé. Vous pouvez l'imprimer ou le lire directement. Il contient des modèles, des checklist et des actions concrètes.
        </p>
      </div>

    </div>

    <!-- CTA -->
    <div style="text-align: center;">
      <p style="color: var(--neutral-600); margin-bottom: 24px;">
        Explorez les autres guides ou retournez à l'accueil.
      </p>
      <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <a href="guides.php" class="btn btn-primary">Voir les autres guides</a>
        <a href="index.php" class="btn btn-outline">Retour à l'accueil</a>
      </div>
    </div>

  </div>
</section>

</main>

<?php include 'includes/footer.php'; ?>
