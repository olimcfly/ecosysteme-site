<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecosystème Immobilier - <?= $pageTitle ?? 'Accueil' ?></title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a href="<?= BASE_URL ?>" class="logo">
                <img src="<?= ASSETS_URL ?>images/logo.png" alt="Logo Ecosystème Immobilier">
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="<?= BASE_URL ?>pages/capture/">Accueil</a></li>
                    <?php if (isset($_SESSION['conseiller_id'])): ?>
                        <li><a href="<?= BASE_URL ?>pages/ressources/">Mes Ressources</a></li>
                        <li><a href="<?= BASE_URL ?>logout.php">Déconnexion</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <?php
        // Affichage des messages d'erreur/succès
        if (isset($_SESSION['error'])) {
            echo '<div class="alert error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="alert success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>
