<?php
$pageTitle = "Choisissez votre offre";
require_once '../../config/config.php';
require_once '../../config/functions.php';
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

// Vérification si la ville est réservée
$villeReservee = isVilleReserved($lead['ville']);
$csrfToken = generateCsrfToken();
?>

<section class="offre-section">
    <div class="container">
        <h1>Choisissez l'offre qui correspond à vos besoins</h1>
        <p class="subtitle">À <?= htmlspecialchars($lead['ville']) ?>, nous avons une solution pour vous.</p>

        <div class="offres-grid">
            <!-- Offre Standard (97€/mois) -->
            <div class="offre-card">
                <div class="offre-header">
                    <h2>Offre Standard</h2>
                    <div class="prix">97€<span>/mois</span></div>
                </div>
                <ul class="offre-features">
                    <li>Accès à la plateforme</li>
                    <li>Formation en ligne</li>
                    <li>Support par email</li>
                    <li>Outils de base</li>
                </ul>
                <form action="traitement-offre.php" method="post">
                    <input type="hidden" name="lead_id" value="<?= $leadId ?>">
                    <input type="hidden" name="offre" value="standard">
                    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                    <button type="submit" class="btn-secondary">Choisir cette offre</button>
                </form>
            </div>

            <!-- Offre Exclusive (997€ - Ville réservée) -->
            <div class="offre-card <?= $villeReservee ? 'disabled' : '' ?>">
                <div class="offre-header">
                    <h2>Offre Exclusive</h2>
                    <div class="prix">997€<span>unique</span></div>
                    <?php if ($villeReservee): ?>
                        <div class="badge-reserve">Ville réservée</div>
                    <?php endif; ?>
                </div>
                <ul class="offre-features">
                    <li>Exclusivité sur <?= htmlspecialchars($lead['ville']) ?></li>
                    <li>Accès à tous les outils premium</li>
                    <li>Formation personnalisée</li>
                    <li>Support prioritaire</li>
                    <li>Garantie "Leads ou Remboursé"</li>
                </ul>
                <?php if ($villeReservee): ?>
                    <button class="btn-disabled" disabled>Ville déjà réservée</button>
                <?php else: ?>
                    <form action="traitement-offre.php" method="post">
                        <input type="hidden" name="lead_id" value="<?= $leadId ?>">
                        <input type="hidden" name="offre" value="exclusive">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                        <button type="submit" class="btn-primary">Réserver <?= htmlspecialchars($lead['ville']) ?></button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="offre-note">
            <p><strong>Note :</strong> L'offre exclusive est limitée à une seule agence par ville. <?= htmlspecialchars($lead['ville']) ?> est actuellement <?= $villeReservee ? 'réservée' : 'disponible' ?>.</p>
        </div>
    </div>
</section>

<?php require_once '../../includes/footer.php'; ?>
