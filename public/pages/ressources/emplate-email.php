<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .button { background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <p>Bonjour <?= htmlspecialchars($nom_conseiller) ?>,</p>

    <p>Merci pour notre échange aujourd’hui ! Comme promis, voici vos <strong>ressources exclusives</strong> pour attirer plus de vendeurs à <?= htmlspecialchars($ville) ?> :</p>

    <h3>🔍 Exercice Pratique : Vos Mots-Clés Immobiliers</h3>
    <p>Découvrez en 5 minutes <strong>ce que vos concurrents voient... et pas vous</strong> :</p>
    <p><a href="<?= BASE_URL ?>pages/ressources/exercice-mots-cles.php?ville=<?= urlencode($ville) ?>" class="button">Faire l'exercice maintenant</a></p>

    <h3>📚 Autres Ressources :</h3>
    <ul>
        <li><a href="<?= BASE_URL ?>pages/ressources/ressources.php">Accéder à toutes vos ressources</a></li>
        <li><a href="<?= ASSETS_URL ?>guides/guide-mots-cles.pdf">Télécharger le guide PDF "10 Mots-Clés qui Convertissent"</a></li>
    </ul>

    <p>Notre plateforme peut vous aider à :</p>
    <ul>
        <li>Cibler automatiquement les mots-clés qui génèrent des leads à <?= htmlspecialchars($ville) ?>.</li>
        <li>Dépasser vos concurrents sur Google en 30 jours.</li>
        <li>Recevoir des leads qualifiés directement dans votre CRM.</li>
    </ul>

    <p>À très vite,<br>
    [Votre Prénom]<br>
    [Votre Poste]<br>
    [Votre Téléphone]</p>
</body>
</html>
