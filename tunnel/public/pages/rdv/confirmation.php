<?php
$pageTitle = "Confirmation de rendez-vous";
require_once '../../config/config.php';
require_once '../../config/functions.php';
require_once '../../includes/header.php';

// Récupération des paramètres
$leadId = isset($_GET['lead_id']) ? (int)$_GET['lead_id'] : 0;
$offre = isset($_GET['offre']) ? sanitizeInput($_GET['offre']) : 'standard';

// Récupération des infos du lead
if ($leadId > 0) {
    $stmt = $pdo->prepare("SELECT nom, email, ville FROM leads WHERE id = ?");
    $stmt->execute([$leadId]);
    $lead = $stmt->fetch();
} else {
    $lead = ['nom' => '', 'email' => '', 'ville' => ''];
}

// Mise à jour du statut du lead
if ($leadId > 0) {
    $stmt = $pdo->prepare("UPDATE leads SET statut = 'rdv_pris' WHERE id = ?");
    $stmt->execute([$leadId]);
}
?>

<section class="confirmation-section">
    <div class="container">
        <div class="confirmation-card">
            <i class="fas fa-check-circle"></i>
            <h1>Rendez-vous confirmé !</h1>
            <p>Merci <?= htmlspecialchars($lead['nom'] ?? 'cher partenaire') ?>. Votre rendez-vous a bien été enregistré.</p>

            <div class="confirmation-details">
                <h2>Détails</h2>
                <p><strong>Ville :</strong> <?= htmlspecialchars($lead['ville'] ?? 'Non spécifiée') ?></p>
                <p><strong>Offre :</strong> <?= ucfirst($offre) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($lead['email'] ?? '') ?></p>
                <p>Un email de confirmation vous a été envoyé avec les détails du rendez-vous.</p>
            </div>

            <div class="confirmation-actions">
                <a href="<?= BASE_URL ?>pages/ressources/ressources.php?lead_id=<?= $leadId ?>" class="btn-primary">
                    Accéder à vos ressources exclusives
                </a>
                <a href="<?= BASE_URL ?>" class="btn-secondary">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</section>

<?php require_once '../../includes/footer.php'; ?>
