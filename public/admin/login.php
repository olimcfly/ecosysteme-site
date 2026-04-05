<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

if (Auth::check()) {
    header('Location: /admin/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion admin</title>
    <style>
      body{font-family:Inter,system-ui,-apple-system,sans-serif;background:#f3f5f9;margin:0}
      .card{max-width:430px;margin:10vh auto;background:#fff;border:1px solid #e6e9f0;border-radius:16px;padding:22px;box-shadow:0 8px 24px rgba(15,23,42,.06)}
      h1{margin:0 0 8px}
      p{color:#5b6474}
      label{display:block;font-weight:600;margin:10px 0 6px}
      input{width:100%;font:inherit;border-radius:10px;border:1px solid #cdd5e3;padding:10px;background:#fff;color:#0f172a}
      button{margin-top:14px;cursor:pointer;border:1px solid transparent;background:#2563eb;color:#fff;padding:10px 14px;border-radius:10px;font-weight:600}
      button:hover{background:#1d4ed8}
      .err{color:#ef4444;font-size:.95rem}
      code{background:#f1f5f9;padding:2px 6px;border-radius:6px}
    </style>
</head>
<body>
<div class="card">
    <h1>Connexion CRM</h1>
    <p>Connectez-vous avec l'email admin et le mot de passe définis dans <code>.env</code>.</p>

    <?php if (!empty($error)): ?>
        <p class="err"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form method="post" action="/admin/login.php">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" required autocomplete="username">

        <label for="password">Mot de passe</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">

        <button type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>
