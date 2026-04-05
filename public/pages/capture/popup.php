<?php
require_once '../../config/config.php';
require_once '../../includes/header.php';
?>

<div class="popup-overlay">
    <div class="popup-content">
        <span class="close-popup">&times;</span>
        <h2>Découvrez les 7 erreurs qui vous font perdre des ventes</h2>
        <p>Répondez à 7 questions rapides pour recevoir votre analyse personnalisée.</p>
        <form action="<?= BASE_URL ?>pages/epee/formulaire.php" method="post">
            <input type="text" name="ville" placeholder="Votre ville" required
                   value="<?= isset($_GET['ville']) ? htmlspecialchars($_GET['ville']) : '' ?>">
            <button type="submit" class="btn-primary">Commencer l'analyse</button>
        </form>
    </div>
</div>

<script>
document.querySelector('.close-popup').addEventListener('click', function() {
    window.close(); // Ferme la popup si ouverte dans un nouvel onglet
    window.location.href = "<?= BASE_URL ?>pages/capture/"; // Redirige vers l'accueil
});
</script>

<?php require_once '../../includes/footer.php'; ?>
