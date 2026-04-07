<?php
$pageTitle = 'Prendre rendez-vous';
require_once '../../config/config.php';
require_once '../../config/functions.php';
require_once '../../includes/header.php';

$leadId = isset($_GET['lead_id']) ? (int) $_GET['lead_id'] : 0;
$offre = isset($_GET['offre']) ? sanitizeInput((string) $_GET['offre']) : 'standard';
$ville = isset($_GET['ville']) ? sanitizeInput((string) $_GET['ville']) : '';
?>

<section class="rdv-section">
    <div class="container">
        <h1>Finalisez votre accompagnement</h1>
        <p class="subtitle">Choisissez votre créneau en quelques secondes pour lancer votre tunnel local.</p>

        <div class="rdv-container">
            <div class="rdv-info">
                <h2>Votre réservation</h2>
                <p>
                    Offre sélectionnée : <strong><?= htmlspecialchars(ucfirst($offre), ENT_QUOTES, 'UTF-8') ?></strong>
                    <?= $ville !== '' ? '• Ville : <strong>' . htmlspecialchars($ville, ENT_QUOTES, 'UTF-8') . '</strong>' : '' ?>
                </p>
                <ul class="rdv-features">
                    <li><i class="fas fa-check-circle"></i> Audit rapide de votre positionnement local</li>
                    <li><i class="fas fa-check-circle"></i> Plan d'action concret sur 30 jours</li>
                    <li><i class="fas fa-check-circle"></i> Réponse à vos questions business</li>
                </ul>
                <p>Durée estimée : 30 minutes en visio.</p>
            </div>

            <div class="rdv-calendly">
                <iframe
                    src="https://calendly.com/ecosystemeimmo/rdv?hide_gdpr_banner=1"
                    title="Planification de rendez-vous"
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                ></iframe>
            </div>
        </div>

        <div style="margin-top: 24px; text-align: center;">
            <a
                href="<?= BASE_URL ?>pages/rdv/confirmation.php?lead_id=<?= $leadId ?>&offre=<?= urlencode($offre) ?>"
                class="btn-primary btn-large"
            >
                J'ai réservé mon créneau
            </a>
        </div>
    </div>
</section>

<?php require_once '../../includes/footer.php'; ?>
