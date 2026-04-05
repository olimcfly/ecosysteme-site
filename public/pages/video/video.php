<?php
$pageTitle = "Les 7 erreurs qui tuent vos ventes immobilières";
require_once '../../config/config.php';
require_once '../../includes/header.php';

// Récupération de l'ID du lead
$leadId = isset($_GET['lead_id']) ? (int)$_GET['lead_id'] : 0;
if ($leadId <= 0) {
    redirectWithError(BASE_URL . 'pages/capture/', "ID de lead invalide.");
}

// Récupération des infos du lead
$stmt = $pdo->prepare("SELECT ville, email FROM leads WHERE id = ?");
$stmt->execute([$leadId]);
$lead = $stmt->fetch();

if (!$lead) {
    redirectWithError(BASE_URL . 'pages/capture/', "Lead introuvable.");
}
?>

<section class="video-section">
    <div class="container">
        <h1>Les 7 erreurs qui tuent vos ventes immobilières à <?= htmlspecialchars($lead['ville']) ?></h1>
        <p class="subtitle">Découvrez comment les corriger et vendre plus, plus vite, et plus cher.</p>

        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                    title="Les 7 erreurs immobilières" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
        </div>

        <div class="cta-video">
            <h2>Prêt à transformer vos ventes ?</h2>
            <p>Découvrez comment notre solution peut vous aider à attirer plus de vendeurs à <?= htmlspecialchars($lead['ville']) ?>.</p>
            <a href="<?= BASE_URL ?>pages/offre/offre.php?lead_id=<?= $leadId ?>" class="btn-primary btn-large">Découvrir l'offre</a>
        </div>
    </div>
</section>

<script>
// Tracking de la vidéo (ex: si la vidéo est regardée à 50%)
document.addEventListener('DOMContentLoaded', function() {
    const iframe = document.querySelector('iframe');
    iframe.addEventListener('load', function() {
        // Envoi d'une requête AJAX pour tracker la vue de la vidéo
        fetch('traitement-video.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'lead_id=<?= $leadId ?>&action=video_view'
        });
    });
});
</script>

<?php require_once '../../includes/footer.php'; ?>
