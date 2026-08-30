<?php
declare(strict_types=1);
$ville = htmlspecialchars($_GET['ville'] ?? 'votre ville', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex">
  <title>Demande reçue — Écosystème Immo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="confirm-page">
  <div class="confirm-card">
    <div class="confirm-icon">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
              d="M5 13l4 4L19 7"/>
      </svg>
    </div>
    <h1>Demande reçue</h1>
    <p>Nous avons bien reçu votre demande pour <strong><?php echo $ville; ?></strong>.</p>
    <p>Vous recevrez une réponse sous 24h pour confirmer la disponibilité de votre territoire.</p>
    <p style="margin-top:24px;">
      <a href="/" class="btn btn-primary">Retour à l'accueil</a>
    </p>
  </div>
</div>

</body>
</html>
