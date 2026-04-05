<?php
$pageTitle = "Vos ressources exclusives";
require_once '../../config/config.php';
require_once '../../includes/header.php';

// Vérification de l'authentification (optionnel)
if (!isset($_SESSION['conseiller_id']) && !isset($_GET['lead_id'])) {
    redirectWithError(BASE_URL . 'pages/capture/', "Accès non autorisé.");
}

// Récupération des infos du lead ou du conseiller
$leadId = isset($_GET['lead_id']) ? (int)$_GET['lead_id'] : 0;
$conseillerId = $_SESSION['conseiller_id'] ?? 0;

if ($leadId > 0) {
    $stmt = $pdo->prepare("SELECT nom, ville FROM leads WHERE id = ?");
    $stmt->execute([$leadId]);
    $user = $stmt->fetch();
} elseif ($conseillerId > 0) {
    $stmt = $pdo->prepare("SELECT nom, ville FROM conseillers WHERE id = ?");
    $stmt->execute([$conseillerId]);
    $user = $stmt->fetch();
} else {
    $user = ['nom' => 'Partenaire', 'ville' => 'votre ville'];
}
?>

<section class="ressources-section">
    <div class="container">
        <h1>Vos ressources exclusives, <?= htmlspecialchars($user['nom']) ?></h1>
        <p class="subtitle">Découvrez comment attirer plus de vendeurs à <?= htmlspecialchars($user['ville']) ?>.</p>

        <div class="ressources-grid">
            <!-- Exercice Mots-Clés -->
            <div class="ressource-card">
                <div class="ressource-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h2>Exercice : Vos mots-clés immobiliers</h2>
                <p>Découvrez quels mots-clés génèrent des leads dans votre ville et comment vous positionner.</p>
                <a href="exercice-mots-cles.php?ville=<?= urlencode($user['ville']) ?>&lead_id=<?= $leadId ?>"
                   class="btn-primary">Faire l'exercice</a>
            </div>

            <!-- Guide PDF -->
            <div class="ressource-card">
                <div class="ressource-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <h2>Guide : 10 mots-clés qui convertissent</h2>
                <p>Téléchargez notre guide PDF avec les mots-clés les plus efficaces pour votre ville.</p>
                <a href="<?= ASSETS_URL ?>guides/guide-mots-cles.pdf" class="btn-secondary" download>
                    Télécharger le guide
                </a>
            </div>

            <!-- Vidéo de Formation -->
            <div class="ressource-card">
                <div class="ressource-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
                <h2>Formation : Optimiser vos annonces</h2>
                <p>Apprenez à optimiser vos annonces pour attirer plus de vendeurs.</p>
                <a href="#" class="btn-secondary">Voir la formation</a>
            </div>
        </div>
    </div>
</section>

<?php require_once '../../includes/footer.php'; ?>
