<?php
$pageTitle = "Exercice : Mots-Clés Immobiliers";
require_once '../../config/config.php';
require_once '../../includes/header.php';

// Récupération des paramètres
$ville = isset($_GET['ville']) ? sanitizeInput($_GET['ville']) : '';
$leadId = isset($_GET['lead_id']) ? (int)$_GET['lead_id'] : 0;

if (empty($ville)) {
    redirectWithError(BASE_URL . 'pages/ressources/', "Ville non spécifiée.");
}

// Récupération des mots-clés pour cette ville (exemple)
$stmt = $pdo->prepare("SELECT * FROM mots_cles WHERE ville = ?");
$stmt->execute([$ville]);
$motsCles = $stmt->fetchAll();

// Génération du token CSRF
$csrfToken = generateCsrfToken();
?>

<section class="exercice-section">
    <div class="container">
        <h1>Exercice : Vos mots-clés immobiliers à <?= htmlspecialchars($ville) ?></h1>
        <p class="subtitle">Découvrez si vous apparaissez sur les requêtes qui génèrent des leads.</p>

        <form action="traitement-exercice.php" method="post" class="exercice-form">
            <input type="hidden" name="ville" value="<?= htmlspecialchars($ville) ?>">
            <input type="hidden" name="lead_id" value="<?= $leadId ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

            <div class="exercice-intro">
                <p>Pour chaque mot-clé ci-dessous, vérifiez si vous apparaissez dans les <strong>3 premiers résultats</strong> de Google.</p>
                <p>Si ce n'est pas le cas, cochez les concurrents qui apparaissent à votre place.</p>
            </div>

            <?php foreach ($motsCles as $motCle): ?>
                <div class="mot-cle-group">
                    <h3><?= htmlspecialchars($motCle['mot_cle']) ?> <span class="volume">(<?= $motCle['volume_recherche'] ?> recherches/mois)</span></h3>

                    <div class="radio-group">
                        <label>
                            <input type="radio" name="apparait[<?= $motCle['id'] ?>]" value="oui" required>
                            Oui, j'apparais dans les 3 premiers résultats
                        </label>
                        <label>
                            <input type="radio" name="apparait[<?= $motCle['id'] ?>]" value="non">
                            Non, je n'apparais pas
                        </label>
                        <label>
                            <input type="radio" name="apparait[<?= $motCle['id'] ?>]" value="parfois">
                            Parfois, selon les jours
                        </label>
                    </div>

                    <?php if ($motCle['position_concurrent_1'] || $motCle['position_concurrent_2'] || $motCle['position_concurrent_3']): ?>
                        <div class="concurrents-group">
                            <p>Si vous n'apparaissez pas, qui apparaît à votre place ? (Cochez tous ceux qui s'appliquent)</p>
                            <div class="checkbox-group">
                                <?php if ($motCle['position_concurrent_1']): ?>
                                    <label>
                                        <input type="checkbox" name="concurrents[<?= $motCle['id'] ?>][]" value="<?= htmlspecialchars($motCle['position_concurrent_1']) ?>">
                                        <?= htmlspecialchars($motCle['position_concurrent_1']) ?>
                                    </label>
                                <?php endif; ?>
                                <?php if ($motCle['position_concurrent_2']): ?>
                                    <label>
                                        <input type="checkbox" name="concurrents[<?= $motCle['id'] ?>][]" value="<?= htmlspecialchars($motCle['position_concurrent_2']) ?>">
                                        <?= htmlspecialchars($motCle['position_concurrent_2']) ?>
                                    </label>
                                <?php endif; ?>
                                <?php if ($motCle['position_concurrent_3']): ?>
                                    <label>
                                        <input type="checkbox" name="concurrents[<?= $motCle['id'] ?>][]" value="<?= htmlspecialchars($motCle['position_concurrent_3']) ?>">
                                        <?= htmlspecialchars($motCle['position_concurrent_3']) ?>
                                    </label>
                                <?php endif; ?>
                                <label>
                                    <input type="checkbox" name="concurrents[<?= $motCle['id'] ?>][]" value="autres">
                                    Autres (précisez) :
                                    <input type="text" name="concurrents_autres[<?= $motCle['id'] ?>]">
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <div class="estimation-group">
                <h3>Estimation des leads perdus</h3>
                <p>Selon vous, combien de leads estimez-vous perdre chaque mois à cause de ces mots-clés non optimisés ?</p>
                <select name="leads_perdus" required>
                    <option value="">-- Sélectionnez une estimation --</option>
                    <option value="1-5">1 à 5 leads/mois</option>
                    <option value="5-10">5 à 10 leads/mois</option>
                    <option value="10-20">10 à 20 leads/mois</option>
                    <option value="20+">Plus de 20 leads/mois</option>
                </select>
            </div>

            <button type="submit" class="btn-primary btn-large">Valider mon exercice</button>
        </form>
    </div>
</section>

<?php require_once '../../includes/footer.php'; ?>
