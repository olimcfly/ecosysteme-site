<?php
$pageTitle = "Résultats de votre exercice";
require_once '../../config/config.php';
require_once '../../includes/header.php';

// Récupération des paramètres
$ville = isset($_GET['ville']) ? sanitizeInput($_GET['ville']) : '';
$leadId = isset($_GET['lead_id']) ? (int)$_GET['lead_id'] : 0;

if (empty($ville)) {
    redirectWithError(BASE_URL . 'pages/ressources/', "Ville non spécifiée.");
}

// Récupération des résultats de l'exercice
$stmt = $pdo->prepare("
    SELECT apparait_premiere_page, concurrents, leads_perdus_estimes
    FROM exercice_mots_cles
    WHERE ville = ? AND id_lead = ?
    ORDER BY date_completion DESC
    LIMIT 1
");
$stmt->execute([$ville, $leadId]);
$resultat = $stmt->fetch();

if (!$resultat) {
    redirectWithError(
        BASE_URL . 'pages/ressources/exercice-mots-cles.php?ville=' . urlencode($ville) . '&lead_id=' . $leadId,
        "Aucun résultat trouvé. Veuillez refaire l'exercice."
    );
}

// Décodage des concurrents
$concurrents = json_decode($resultat['concurrents'], true);
$leadsPerdus = [
    '1-5' => '1 à 5 leads par mois',
    '5-10' => '5 à 10 leads par mois',
    '10-20' => '10 à 20 leads par mois',
    '20+' => 'Plus de 20 leads par mois'
][$resultat['leads_perdus_estimes']] ?? 'Non spécifié';
?>

<section class="resultats-section">
    <div class="container">
        <div class="resultats-header">
            <i class="fas fa-chart-bar"></i>
            <h1>Résultats de votre exercice à <?= htmlspecialchars($ville) ?></h1>
            <p>Voici ce que nous avons découvert sur votre visibilité.</p>
        </div>

        <div class="resultats-grid">
            <!-- Résultats Généraux -->
            <div class="resultat-card">
                <h2>Votre visibilité sur Google</h2>
                <div class="resultat-visibilite">
                    <?php if ($resultat['apparait_premiere_page'] === 'oui'): ?>
                        <i class="fas fa-check-circle success"></i>
                        <p>Vous apparaissez <strong>souvent</strong> dans les premiers résultats pour les mots-clés testés.</p>
                    <?php elseif ($resultat['apparait_premiere_page'] === 'parfois'): ?>
                        <i class="fas fa-exclamation-triangle warning"></i>
                        <p>Vous apparaissez <strong>parfois</strong>, mais pas de manière constante.</p>
                    <?php else: ?>
                        <i class="fas fa-times-circle error"></i>
                        <p>Vous n'apparaissez <strong>pas</strong> dans les premiers résultats pour la plupart des mots-clés.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Leads Perdus -->
            <div class="resultat-card">
                <h2>Leads perdus estimés</h2>
                <div class="resultat-leads">
                    <i class="fas fa-users"></i>
                    <p>Selon votre estimation, vous perdez <strong><?= htmlspecialchars($leadsPerdus) ?></strong> à cause de ces mots-clés non optimisés.</p>
                </div>
            </div>

            <!-- Concurrents -->
            <div class="resultat-card">
                <h2>Vos principaux concurrents</h2>
                <div class="resultat-concurrents">
                    <?php if (!empty($concurrents)): ?>
                        <ul>
                            <?php
                            $concurrentsUniques = [];
                            foreach ($concurrents as $concurrentsList) {
                                foreach ($concurrentsList as $concurrent) {
                                    if (!in_array($concurrent, $concurrentsUniques) && $concurrent !== 'autres') {
                                        $concurrentsUniques[] = $concurrent;
                                    }
                                }
                            }
                            foreach ($concurrentsUniques as $concurrent): ?>
                                <li><?= htmlspecialchars($concurrent) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <p>Ces concurrents captent les leads que vous pourriez obtenir.</p>
                    <?php else: ?>
                        <p>Aucun concurrent identifié. Vous êtes peut-être le seul à ne pas apparaître !</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="resultats-actions">
            <h2>Que faire maintenant ?</h2>
            <div class="actions-grid">
                <div class="action-card">
                    <i class="fas fa-rocket"></i>
                    <h3>Optimisez vos mots-clés</h3>
                    <p>Utilisez notre outil pour cibler les mots-clés qui génèrent des leads à <?= htmlspecialchars($ville) ?>.</p>
                    <a href="<?= BASE_URL ?>pages/offre/offre.php?lead_id=<?= $leadId ?>" class="btn-primary">
                        Découvrir nos offres
                    </a>
                </div>
                <div class="action-card">
                    <i class="fas fa-chart-line"></i>
                    <h3>Analysez vos concurrents</h3>
                    <p>Comparez votre visibilité avec celle de vos concurrents et identifiez les opportunités.</p>
                    <a href="#" class="btn-secondary">Voir l'analyse concurrentielle</a>
                </div>
                <div class="action-card">
                    <i class="fas fa-envelope"></i>
                    <h3>Recevez des leads qualifiés</h3>
                    <p>Notre plateforme peut vous envoyer des leads directement dans votre CRM.</p>
                    <a href="<?= BASE_URL ?>pages/rdv/rdv.php?lead_id=<?= $leadId ?>" class="btn-secondary">
                        Prendre rendez-vous
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../../includes/footer.php'; ?>
