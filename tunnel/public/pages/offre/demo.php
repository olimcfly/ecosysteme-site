<?php
$pageTitle = "Démonstration de la plateforme";
require_once '../../config/config.php';
require_once '../../includes/header.php';
?>

<section class="demo-section">
    <div class="container">
        <h1>Démonstration de notre plateforme</h1>
        <p class="subtitle">Découvrez comment notre solution fonctionne en pratique.</p>

        <div class="demo-video">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/another_video_id"
                    title="Démonstration plateforme" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
        </div>

        <div class="demo-features">
            <h2>Fonctionnalités clés</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-search"></i>
                    <h3>Recherche de mots-clés</h3>
                    <p>Trouvez les mots-clés qui génèrent des leads dans votre ville.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-chart-line"></i>
                    <h3>Analyse concurrentielle</h3>
                    <p>Comparez votre visibilité avec celle de vos concurrents.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-envelope"></i>
                    <h3>Automatisation des emails</h3>
                    <p>Envoyez des emails personnalisés à vos leads automatiquement.</p>
                </div>
            </div>
        </div>

        <div class="cta-demo">
            <a href="<?= BASE_URL ?>pages/rdv/rdv.php" class="btn-primary btn-large">Prendre rendez-vous</a>
        </div>
    </div>
</section>

<?php require_once '../../includes/footer.php'; ?>
