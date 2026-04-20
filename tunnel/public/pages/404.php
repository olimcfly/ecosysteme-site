<?php include_once __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <div class="error-page">
        <div class="error-content">
            <h1>404 - Page Introuvable</h1>
            <p>Désolé, la page que vous recherchez n'existe pas ou a été déplacée.</p>
            <a href="<?= BASE_URL ?>pages/capture/" class="btn btn-primary">Retour à l'accueil</a>
        </div>
        <div class="error-image">
            <img src="<?= ASSETS_URL ?>images/404.png" alt="Erreur 404">
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
