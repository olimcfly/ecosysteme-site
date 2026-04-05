<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

if (Auth::check()) {
    header('Location: /admin/');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string) ($_POST['password'] ?? '');
    if (Auth::attempt($password)) {
        header('Location: /admin/');
        exit;
    }

    $error = 'Mot de passe incorrect.';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Ecosystème Immo</title>
    <link href="/admin/css/style.css" rel="stylesheet">
</head>
<body class="admin-login-body">
    <main class="login-card">
        <h1>Connexion admin</h1>
        <p class="hint">Utilisez la variable d'environnement <code>CRM_ADMIN_PASSWORD</code> pour sécuriser l'accès.</p>
        <?php if ($error !== ''): ?>
            <p class="alert alert-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form method="post" class="login-form">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </main>
</body>
</html>
