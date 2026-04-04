<?php

declare(strict_types=1);

require_once __DIR__ . '/tracking.php';

if (($_GET['src'] ?? '') === 'offre_cta') {
    track_event('offer_to_form_click', ['from' => 'offre.php']);
}

$old = [
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'telephone' => '',
    'zone' => '',
    'experience' => '',
    'contacts_vendeurs' => '',
    'objectif' => '',
    'investissement' => '',
];

$errors = [];
if (isset($_GET['errors'])) {
    $decodedErrors = json_decode((string) $_GET['errors'], true);
    $decodedOld = json_decode((string) ($_GET['old'] ?? ''), true);

    if (is_array($decodedErrors)) {
        $errors = $decodedErrors;
    }
    if (is_array($decodedOld)) {
        $old = array_merge($old, $decodedOld);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Validez votre demande ECOSYSTEMEIMMO et vérifiez la disponibilité de votre zone immobilière.">
  <title>ECOSYSTEMEIMMO | Qualification & demande</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
<main>
  <section class="container">
    <div class="card">
      <p class="badge">Étape 4 — Qualification</p>
      <h1>Vérifions si votre zone est encore disponible</h1>
      <p>Complétez ce formulaire. Nous revenons vers vous avec une réponse claire et un créneau adapté.</p>

      <?php if ($errors !== []): ?>
        <div class="error" role="alert">
          <strong>Merci de corriger les points suivants :</strong>
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" action="/traitement-formulaire.php" novalidate>
        <div class="form-grid two-cols">
          <div>
            <label for="nom">Nom *</label>
            <input id="nom" name="nom" type="text" required value="<?php echo htmlspecialchars($old['nom'], ENT_QUOTES, 'UTF-8'); ?>">
          </div>
          <div>
            <label for="prenom">Prénom *</label>
            <input id="prenom" name="prenom" type="text" required value="<?php echo htmlspecialchars($old['prenom'], ENT_QUOTES, 'UTF-8'); ?>">
          </div>
          <div>
            <label for="email">Email *</label>
            <input id="email" name="email" type="email" required value="<?php echo htmlspecialchars($old['email'], ENT_QUOTES, 'UTF-8'); ?>">
          </div>
          <div>
            <label for="telephone">Téléphone *</label>
            <input id="telephone" name="telephone" type="tel" required value="<?php echo htmlspecialchars($old['telephone'], ENT_QUOTES, 'UTF-8'); ?>">
          </div>
        </div>

        <div class="form-grid" style="margin-top:1rem;">
          <div>
            <label for="zone">Zone géographique *</label>
            <input id="zone" name="zone" type="text" required value="<?php echo htmlspecialchars($old['zone'], ENT_QUOTES, 'UTF-8'); ?>">
          </div>
          <div>
            <label for="experience">Depuis combien de temps êtes-vous conseiller immobilier ? *</label>
            <input id="experience" name="experience" type="text" required value="<?php echo htmlspecialchars($old['experience'], ENT_QUOTES, 'UTF-8'); ?>">
          </div>
          <div>
            <label for="contacts_vendeurs">Recevez-vous actuellement des contacts vendeurs ? *</label>
            <select id="contacts_vendeurs" name="contacts_vendeurs" required>
              <option value="">Sélectionner...</option>
              <?php foreach (['oui régulièrement', 'parfois', 'jamais'] as $option): ?>
                <option value="<?php echo $option; ?>" <?php echo $old['contacts_vendeurs'] === $option ? 'selected' : ''; ?>><?php echo ucfirst($option); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label for="objectif">Quel est votre objectif principal ? *</label>
            <textarea id="objectif" name="objectif" required><?php echo htmlspecialchars($old['objectif'], ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div>
            <label for="investissement">Êtes-vous prêt à investir dans votre visibilité locale ? *</label>
            <select id="investissement" name="investissement" required>
              <option value="">Sélectionner...</option>
              <?php foreach (['oui', 'non', 'à discuter'] as $option): ?>
                <option value="<?php echo $option; ?>" <?php echo $old['investissement'] === $option ? 'selected' : ''; ?>><?php echo ucfirst($option); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <input type="hidden" name="tracking_event" value="form_submission">

        <p class="center" style="margin-top:1.3rem;">
          <button class="btn btn-primary" type="submit">Valider ma demande</button>
        </p>
      </form>
    </div>
  </section>
</main>
</body>
</html>
