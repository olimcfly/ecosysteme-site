<?php
declare(strict_types=1);

$formule = htmlspecialchars($_GET['formule'] ?? '', ENT_QUOTES, 'UTF-8');

$old = [
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'telephone' => '',
    'ville' => '',
    'formule' => $formule,
    'experience' => '',
    'contacts_vendeurs' => '',
    'objectif' => '',
];

$errors = [];
if (!empty($_GET['errors'])) {
    $decodedErrors = json_decode((string) $_GET['errors'], true);
    if (is_array($decodedErrors)) {
        $errors = $decodedErrors;
    }
}
if (!empty($_GET['old'])) {
    $decodedOld = json_decode((string) $_GET['old'], true);
    if (is_array($decodedOld)) {
        $old = array_merge($old, array_map(
            fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'),
            $decodedOld
        ));
    }
}

$formule_labels = [
    'estimateur'  => 'Estimateur — 27 €/mois',
    'mensuelle'   => 'Mensuelle — 97 €/mois',
    'annuelle'    => 'Annuelle — 897 €/an',
    'exclusivite' => 'Exclusivité Verrouillée — 900 €',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Vérifiez si votre ville est encore disponible. Réponse sous 24h, sans engagement.">
  <title>Vérifier ma ville — Écosystème Immo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div id="scarcity-bar" role="note">
  Territoires complets&nbsp;: Bordeaux &middot; Nantes &middot; Nandy &middot; Aix-en-Provence &middot; Lannion
  &nbsp;&mdash;&nbsp;
  <a href="formulaire.php">Vérifiez votre ville &rarr;</a>
</div>

<nav class="nav" aria-label="Navigation principale">
  <div class="container nav__inner">
    <a href="/" class="nav__logo">Écosystème<span>Immo</span></a>
    <ul class="nav__links" role="list">
      <li><a href="/#process">Comment ça marche</a></li>
      <li><a href="offre.php">Offres</a></li>
      <li><a href="/#realisations">Réalisations</a></li>
      <li><a href="blog/">Blog</a></li>
    </ul>
    <a href="formulaire.php" class="btn btn-primary nav__cta">Vérifier ma ville</a>
    <button class="nav__hamburger" aria-label="Menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div class="form-page">
  <div class="form-card">
    <p class="form-card__eyebrow">Disponibilité territoriale</p>
    <h1>Vérifions si votre ville est encore disponible</h1>
    <p class="form-card__sub">
      Complétez ce formulaire. Nous revenons vers vous avec une réponse claire sous 24h.
      La vérification est gratuite et sans engagement.
    </p>

    <?php if (!empty($errors)): ?>
    <div class="form-error" role="alert">
      <p>Merci de corriger les points suivants :</p>
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?php echo htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <form method="post" action="traitement-formulaire.php" novalidate>
      <input type="hidden" name="formule" value="<?php echo $old['formule']; ?>">

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label" for="nom">Nom <span aria-hidden="true">*</span></label>
          <input class="form-input" type="text" id="nom" name="nom"
                 value="<?php echo $old['nom']; ?>" required autocomplete="family-name">
        </div>
        <div class="form-group">
          <label class="form-label" for="prenom">Prénom <span aria-hidden="true">*</span></label>
          <input class="form-input" type="text" id="prenom" name="prenom"
                 value="<?php echo $old['prenom']; ?>" required autocomplete="given-name">
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label" for="email">Email <span aria-hidden="true">*</span></label>
          <input class="form-input" type="email" id="email" name="email"
                 value="<?php echo $old['email']; ?>" required autocomplete="email">
        </div>
        <div class="form-group">
          <label class="form-label" for="telephone">Téléphone <span aria-hidden="true">*</span></label>
          <input class="form-input" type="tel" id="telephone" name="telephone"
                 value="<?php echo $old['telephone']; ?>" required autocomplete="tel">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="ville">Votre ville / commune <span aria-hidden="true">*</span></label>
        <input class="form-input" type="text" id="ville" name="ville"
               value="<?php echo $old['ville']; ?>" required
               placeholder="Ex : Lyon, Rennes, Brest...">
      </div>

      <div class="form-group">
        <label class="form-label" for="formule_select">Formule qui vous intéresse</label>
        <select class="form-select" id="formule_select" name="formule">
          <option value="">Je ne sais pas encore</option>
          <?php foreach ($formule_labels as $key => $label): ?>
            <option value="<?php echo $key; ?>"
              <?php echo ($old['formule'] === $key) ? 'selected' : ''; ?>>
              <?php echo $label; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label" for="experience">Depuis combien de temps êtes-vous conseiller immobilier ?</label>
        <input class="form-input" type="text" id="experience" name="experience"
               value="<?php echo $old['experience']; ?>"
               placeholder="Ex : 2 ans, 6 mois...">
      </div>

      <div class="form-group">
        <label class="form-label" for="contacts_vendeurs">Recevez-vous actuellement des contacts vendeurs ?</label>
        <select class="form-select" id="contacts_vendeurs" name="contacts_vendeurs">
          <option value="">Sélectionner...</option>
          <?php foreach (['Oui, régulièrement' => 'oui', 'Parfois' => 'parfois', 'Jamais' => 'jamais'] as $label => $val): ?>
            <option value="<?php echo $val; ?>"
              <?php echo ($old['contacts_vendeurs'] === $val) ? 'selected' : ''; ?>>
              <?php echo $label; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label" for="objectif">Votre objectif principal (optionnel)</label>
        <textarea class="form-textarea" id="objectif" name="objectif"
                  placeholder="Ex : générer des mandats vendeurs sans prospecter à froid"><?php echo $old['objectif']; ?></textarea>
      </div>

      <button class="btn btn-primary btn-xl btn-full" type="submit">
        Envoyer ma demande
      </button>

      <p style="font-size:12px;color:var(--slate-500);text-align:center;margin-top:12px;line-height:1.5;">
        Sans engagement &middot; Réponse sous 24h &middot; Données confidentielles
      </p>
    </form>
  </div>
</div>

<script src="/assets/js/main.js"></script>
</body>
</html>
