<?php
require_once 'vendor/autoload.php';

$page_title = 'Paiement sécurisé — Écosystème Immo';
$meta_description = 'Complétez votre paiement pour accéder à votre guide immédiatement.';

include 'includes/header.php';

// Récupérer l'ID du guide depuis l'URL
$guide_id = isset($_GET['guide']) ? htmlspecialchars($_GET['guide']) : null;

// Base de données des guides
$guides = [
    'guide-1' => ['titre' => 'Positionner votre offre immobilière', 'prix' => 4700, 'description' => 'Clarifiez votre positionnement pour attirer les bons clients.'],
    'guide-2' => ['titre' => 'Générer vos premiers contacts', 'prix' => 4700, 'description' => 'Mettez en place votre système d\'acquisition locale.'],
    'guide-3' => ['titre' => 'Structurer votre présence digitale', 'prix' => 4700, 'description' => 'Site, email, réseaux : un vrai système cohérent.'],
    // ... ajoutez les autres guides
];

if (!$guide_id || !isset($guides[$guide_id])) {
    header('Location: guides.php');
    exit;
}

$guide = $guides[$guide_id];
$stripe_key = 'pk_live_VOTRE_CLE_PUBLIQUE'; // À remplacer

?>

<main>

<!-- PAGE HEADER -->
<section class="page-header">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="breadcrumb-sep">›</span>
      <a href="guides.php">Les guides</a>
      <span class="breadcrumb-sep">›</span>
      <span>Paiement</span>
    </div>
    <h1 class="page-header-title">Paiement sécurisé</h1>
    <p class="page-header-subtitle">Accédez à votre guide immédiatement après le paiement</p>
  </div>
</section>

<!-- CHECKOUT -->
<section class="section">
  <div class="container">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 48px; max-width: 1000px; margin: 0 auto;">

      <!-- FORMULAIRE DE PAIEMENT -->
      <div>
        <h2 style="font-size: 1.375rem; font-weight: 700; margin-bottom: 28px; color: var(--neutral-900);">
          Complétez votre paiement
        </h2>

        <form id="payment-form" style="display: flex; flex-direction: column; gap: 20px;">

          <!-- Infos client -->
          <div>
            <h3 style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase; color: var(--neutral-500); margin-bottom: 16px; letter-spacing: 0.5px;">Vos informations</h3>

            <div class="form-group">
              <label class="form-label" for="email">Email *</label>
              <input type="email" id="email" name="email" class="form-input" placeholder="vous@email.fr" required>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="prenom">Prénom *</label>
                <input type="text" id="prenom" name="prenom" class="form-input" placeholder="Jean" required>
              </div>
              <div class="form-group">
                <label class="form-label" for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" class="form-input" placeholder="Dupont" required>
              </div>
            </div>
          </div>

          <!-- Stripe Card Element -->
          <div>
            <h3 style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase; color: var(--neutral-500); margin-bottom: 16px; letter-spacing: 0.5px;">Moyen de paiement</h3>
            <div id="card-element" style="border: 1px solid var(--neutral-300); border-radius: var(--radius-md); padding: 12px; background: var(--white);"></div>
            <div id="card-errors" style="color: #fa755a; margin-top: 8px; font-size: 0.875rem;"></div>
          </div>

          <!-- RGPD -->
          <div style="display: flex; gap: 12px; align-items: flex-start;">
            <input type="checkbox" id="rgpd" name="rgpd" required style="width: 18px; height: 18px; margin-top: 2px; cursor: pointer;">
            <label for="rgpd" style="font-size: 0.875rem; color: var(--neutral-600); line-height: 1.5; cursor: pointer;">
              J'accepte les <a href="mentions-legales.php" style="color: var(--primary-500); text-decoration: underline;">conditions d'utilisation</a> et la <a href="mentions-legales.php#rgpd" style="color: var(--primary-500); text-decoration: underline;">politique de confidentialité</a>
            </label>
          </div>

          <!-- Bouton de paiement -->
          <button type="submit" id="submit-btn" class="btn btn-primary btn-lg" style="width: 100%; margin-top: 12px;">
            Payer 47€ et accéder au guide
          </button>

          <p style="font-size: 0.8125rem; color: var(--neutral-500); text-align: center;">
            Paiement 100% sécurisé via Stripe. Pas de frais supplémentaires.
          </p>

        </form>
      </div>

      <!-- RÉSUMÉ DE COMMANDE -->
      <div>
        <div style="background: var(--neutral-50); border: 1px solid var(--neutral-200); border-radius: var(--radius-lg); padding: 28px; position: sticky; top: 100px;">

          <h3 style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase; color: var(--neutral-500); margin-bottom: 20px; letter-spacing: 0.5px;">Résumé de commande</h3>

          <div style="margin-bottom: 24px;">
            <h4 style="font-weight: 700; font-size: 1rem; color: var(--neutral-900); margin-bottom: 6px;">
              <?= htmlspecialchars($guide['titre']) ?>
            </h4>
            <p style="font-size: 0.875rem; color: var(--neutral-600); line-height: 1.6;">
              <?= htmlspecialchars($guide['description']) ?>
            </p>
          </div>

          <div style="border-top: 1px solid var(--neutral-300); padding-top: 16px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
              <span style="color: var(--neutral-600);">Sous-total</span>
              <span style="font-weight: 600;">47€</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
              <span style="color: var(--neutral-600);">TVA (20%)</span>
              <span style="font-weight: 600;">9,40€</span>
            </div>
          </div>

          <div style="border-top: 1px solid var(--neutral-300); padding-top: 16px; display: flex; justify-content: space-between; align-items: baseline;">
            <span style="font-weight: 700; color: var(--neutral-900);">Total TTC</span>
            <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary-600);">56,40€</span>
          </div>

          <div style="background: var(--green-50); border: 1px solid var(--green-200); border-radius: var(--radius-md); padding: 16px; margin-top: 24px; text-align: center;">
            <p style="font-size: 0.875rem; color: var(--green-800);">
              <strong>✓ Accès immédiat</strong><br>
              Vous recevrez le lien de téléchargement par email dès le paiement confirmé.
            </p>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

</main>

<!-- Scripts Stripe -->
<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe('<?= $stripe_key ?>');
const elements = stripe.elements();
const cardElement = elements.create('card');
cardElement.mount('#card-element');

// Gestion des erreurs de carte
cardElement.addEventListener('change', function(event) {
  const displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Soumission du formulaire
document.getElementById('payment-form').addEventListener('submit', async function(e) {
  e.preventDefault();

  const submitBtn = document.getElementById('submit-btn');
  submitBtn.disabled = true;
  submitBtn.textContent = 'Traitement en cours...';

  // Créer le Payment Intent côté serveur
  const response = await fetch('api/create-payment-intent.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      guide_id: '<?= $guide_id ?>',
      email: document.getElementById('email').value,
      prenom: document.getElementById('prenom').value,
      nom: document.getElementById('nom').value,
      montant: <?= $guide['prix'] ?>
    })
  });

  const data = await response.json();

  if (!data.client_secret) {
    alert('Erreur : ' + data.error);
    submitBtn.disabled = false;
    submitBtn.textContent = 'Payer 47€ et accéder au guide';
    return;
  }

  // Confirmer le paiement
  const result = await stripe.confirmCardPayment(data.client_secret, {
    payment_method: {
      card: cardElement,
      billing_details: {
        email: document.getElementById('email').value,
        name: document.getElementById('prenom').value + ' ' + document.getElementById('nom').value
      }
    }
  });

  if (result.error) {
    alert('Erreur de paiement : ' + result.error.message);
    submitBtn.disabled = false;
    submitBtn.textContent = 'Payer 47€ et accéder au guide';
  } else if (result.paymentIntent.status === 'succeeded') {
    window.location.href = 'confirmation.php?session=' + result.paymentIntent.id;
  }
});
</script>

<?php include 'includes/footer.php'; ?>
