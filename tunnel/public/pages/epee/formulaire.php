<?php
$pageTitle = "Analyse des 7 erreurs - Étape 1/2";
require_once '../../config/config.php';
require_once '../../config/functions.php';
require_once '../../includes/header.php';

// Récupération de la ville depuis le formulaire précédent (POST prioritaire)
$ville = isset($_POST['ville']) ? sanitizeInput((string) $_POST['ville']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken((string) $_POST['csrf_token'])) {
        redirectWithError(BASE_URL . 'pages/capture/', "Token CSRF invalide !");
    }
}


if (empty($ville)) {
    redirectWithError(BASE_URL . 'pages/capture/', "Ville non spécifiée. Veuillez recommencer.");
}

// Régénération du token CSRF pour l'étape suivante
$csrfToken = generateCsrfToken();
?>

<section class="form-section">
    <div class="container">
        <div class="form-progress">
            <div class="progress-bar">
                <div class="progress" style="width: 14%;"></div>
            </div>
            <span>Étape 1/2 : Analyse des erreurs</span>
        </div>

        <form action="traitement.php" method="post" class="form-epee">
            <input type="hidden" name="ville" value="<?= htmlspecialchars($ville) ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

            <h2>Analyse des 7 erreurs à <?= htmlspecialchars($ville) ?></h2>
            <p>Répondez à ces 7 questions pour identifier les erreurs qui vous font perdre des ventes.</p>

            <!-- Question 1 -->
            <div class="form-group">
                <label>1. Utilisez-vous un système pour suivre les leads immobiliers (CRM) ?</label>
                <div class="radio-group">
                    <label><input type="radio" name="q1" value="oui" required> Oui</label>
                    <label><input type="radio" name="q1" value="non"> Non</label>
                </div>
            </div>

            <!-- Question 2 -->
            <div class="form-group">
                <label>2. Avez-vous une stratégie de contenu pour attirer des vendeurs ?</label>
                <div class="radio-group">
                    <label><input type="radio" name="q2" value="oui" required> Oui</label>
                    <label><input type="radio" name="q2" value="non"> Non</label>
                </div>
            </div>

            <!-- Questions 3 à 6 (similaires) -->
            <div class="form-group">
                <label>3. Vos annonces sont-elles optimisées pour le SEO ?</label>
                <div class="radio-group">
                    <label><input type="radio" name="q3" value="oui" required> Oui</label>
                    <label><input type="radio" name="q3" value="non"> Non</label>
                </div>
            </div>

            <div class="form-group">
                <label>4. Utilisez-vous des vidéos pour présenter les biens ?</label>
                <div class="radio-group">
                    <label><input type="radio" name="q4" value="oui" required> Oui</label>
                    <label><input type="radio" name="q4" value="non"> Non</label>
                </div>
            </div>

            <div class="form-group">
                <label>5. Avez-vous un processus de relance des leads inactifs ?</label>
                <div class="radio-group">
                    <label><input type="radio" name="q5" value="oui" required> Oui</label>
                    <label><input type="radio" name="q5" value="non"> Non</label>
                </div>
            </div>

            <div class="form-group">
                <label>6. Vos estimations sont-elles automatisées ?</label>
                <div class="radio-group">
                    <label><input type="radio" name="q6" value="oui" required> Oui</label>
                    <label><input type="radio" name="q6" value="non"> Non</label>
                </div>
            </div>

            <!-- Question 7 -->
            <div class="form-group">
                <label>7. Souhaitez-vous recevoir une analyse détaillée de vos erreurs ?</label>
                <div class="radio-group">
                    <label><input type="radio" name="q7" value="oui" required> Oui, envoyez-moi mon rapport</label>
                    <label><input type="radio" name="q7" value="non"> Non, je préfère continuer seul</label>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Votre email pour recevoir l'analyse :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <button type="submit" class="btn-primary btn-large">Recevoir mon analyse</button>
        </form>
    </div>
</section>

<?php require_once '../../includes/footer.php'; ?>
