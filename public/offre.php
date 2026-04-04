<?php

declare(strict_types=1);

require_once __DIR__ . '/tracking.php';

if (($_GET['src'] ?? '') === 'video_cta') {
    track_event('video_to_offer_click', ['from' => 'video.php']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Offre ECOSYSTEMEIMMO à 997€ pour les conseillers immobiliers : visibilité locale, contacts vendeurs et exclusivité par zone.">
  <title>ECOSYSTEMEIMMO | Offre de lancement 997€</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
<main>
  <section class="container">
    <article class="card">
      <p class="badge">Étape 3 — Offre</p>
      <h1>Un système local pour capter des vendeurs, sans dépendre des plateformes</h1>

      <h2>Le problème</h2>
      <p>Vous êtes compétent, mais invisible quand un propriétaire cherche un conseiller dans votre ville.</p>

      <h2>La solution ECOSYSTEMEIMMO</h2>
      <p>Nous installons un système marketing immobilier local pensé pour générer des opportunités vendeurs qualifiées.</p>

      <h2>Ce que contient l’offre</h2>
      <ul class="list">
        <li>Positionnement local clair sur votre zone géographique.</li>
        <li>Structure de pages pour transformer la visibilité en demandes de rendez-vous.</li>
        <li>Méthode d’acquisition orientée vendeurs et suivi des contacts.</li>
        <li>Process simple pour gagner du temps et garder la maîtrise de vos données.</li>
      </ul>

      <h2>Pourquoi c’est différent</h2>
      <p>Vous ne louez pas un outil : vous construisez votre propre système, adapté à votre secteur.</p>

      <p class="price">Offre de lancement : 997€</p>
      <p class="urgent">1 conseiller par zone. Dès qu’une zone est validée, elle devient indisponible.</p>

      <p class="center" style="margin-top: 1.4rem;">
        <a class="btn btn-primary" href="/formulaire.php?src=offre_cta">Voir si ma zone est disponible</a>
      </p>
    </article>
  </section>
</main>
</body>
</html>
