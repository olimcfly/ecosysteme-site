<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
$pageTitle = "Découvrez les 7 erreurs qui tuent vos ventes immobilières";
$pageTitle = "Découvrez les 7 erreurs qui tuent vos ventes immobilières";
require_once '../../config/config.php';
require_once '../../includes/header.php';
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Les 7 erreurs qui tuent vos ventes immobilières à <span id="ville-detectee">votre ville</span></h1>
            <p class="subtitle">Découvrez comment les éviter et vendre plus, plus vite, et plus cher.</p>
            <button id="btn-declencheur" class="btn-primary btn-large">Découvrir les 7 erreurs</button>
        </div>
        <div class="hero-image">
            <img src="<?= ASSETS_URL ?>images/agent-immobilier.jpg" alt="Agent immobilier">
        </div>
    </div>
</section>

<!-- Popup cachée par défaut -->
<div id="popup-capture" class="popup" style="display: none;">
    <div class="popup-content">
        <span class="close-popup">&times;</span>
        <h2>Découvrez les 7 erreurs qui vous font perdre des ventes</h2>
        <p>Répondez à 7 questions rapides pour recevoir votre analyse personnalisée.</p>
        <form action="<?= BASE_URL ?>pages/epee/formulaire.php" method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
            <input type="text" name="ville" id="ville-popup" placeholder="Votre ville" required>
            <button type="submit" class="btn-primary">Commencer l'analyse</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnDeclencheur = document.getElementById('btn-declencheur');
    const popup = document.getElementById('popup-capture');
    const closePopup = document.querySelector('.close-popup');

    // Détection de la ville (simplifiée - à remplacer par une API comme IPStack)
    function detecterVille() {
        // En production, utilisez une API comme https://ipstack.com/
        const villes = ["Paris", "Lyon", "Bordeaux", "Toulouse", "Nantes"];
        const villeAleatoire = villes[Math.floor(Math.random() * villes.length)];
        document.getElementById('ville-detectee').textContent = villeAleatoire;
        document.getElementById('ville-popup').value = villeAleatoire;
    }

    // Afficher la popup
    btnDeclencheur.addEventListener('click', function() {
        popup.style.display = 'block';
        detecterVille();
    });

    // Fermer la popup
    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    // Fermer la popup si clic en dehors
    window.addEventListener('click', function(event) {
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    });
});
</script>

<?php require_once '../../includes/footer.php'; ?>
