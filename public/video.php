<?php

declare(strict_types=1);

require_once __DIR__ . '/tracking.php';

if (($_GET['src'] ?? '') === 'capture_cta') {
    track_event('capture_to_video_click', ['from' => 'capture.php']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Regardez la démonstration ECOSYSTEMEIMMO et découvrez comment capter des vendeurs dans votre zone locale.">
  <title>ECOSYSTEMEIMMO | Vidéo de démonstration</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
<main>
  <section class="container">
    <div class="card center">
      <span class="badge">Étape 2 — Démonstration</span>
      <h1>Comment un conseiller devient la référence locale sur sa zone</h1>
      <div class="video-shell" aria-label="Vidéo de présentation ECOSYSTEMEIMMO">
        <div class="placeholder">Insérez ici votre vidéo (YouTube, Vimeo ou lecteur interne)</div>
      </div>
      <p>Vous découvrez un système simple pour générer des contacts vendeurs, gagner du temps et rester propriétaire de vos données.</p>
      <p><strong>Rappel :</strong> un seul conseiller est sélectionné par zone géographique.</p>
      <a class="btn btn-primary" href="/offre.php?src=video_cta">Voir l’offre</a>
    </div>
  </section>
</main>
</body>
</html>
