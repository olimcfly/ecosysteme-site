<?php
session_start();
require_once __DIR__ . '/includes/offre_dedie_paliers.php';

$paliers = offre_dedie_paliers();

$palier_key = $_GET['palier'] ?? $_POST['palier'] ?? 'site-vitrine';
if (!isset($paliers[$palier_key])) {
    $palier_key = 'site-vitrine';
}
$palier_label = $paliers[$palier_key];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom        = trim($_POST['prenom'] ?? '');
    $nom           = trim($_POST['nom'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $telephone     = trim($_POST['telephone'] ?? '');
    $metier        = trim($_POST['metier'] ?? '');
    $ville         = trim($_POST['ville'] ?? '');
    $experience    = trim($_POST['experience'] ?? '');
    $objectif      = trim($_POST['objectif'] ?? '');
    $delais        = trim($_POST['delais'] ?? '');
    $palier_post   = trim($_POST['palier'] ?? '');
    $rgpd          = isset($_POST['rgpd']);
    $honeypot      = trim($_POST['website'] ?? '');

    if (strlen($honeypot) > 0) {
        http_response_code(400);
        exit;
    }
    if (!isset($paliers[$palier_post])) {
        $palier_post = 'site-vitrine';
    }
    $palier_key  = $palier_post;
    $palier_label = $paliers[$palier_key];

    if (strlen($prenom) < 2) {
        $errors[] = 'Prénom requis.';
    }
    if (strlen($nom) < 2) {
        $errors[] = 'Nom requis.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email invalide.';
    }
    if (strlen($telephone) < 10) {
        $errors[] = 'Téléphone requis (10 chiffres minimum).';
    }
    if (strlen($metier) < 2) {
        $errors[] = 'Veuillez préciser votre métier / statut.';
    }
    if (strlen($ville) < 2) {
        $errors[] = 'Ville requise.';
    }
    if ($experience === '') {
        $errors[] = 'Sélectionnez votre ancienneté.';
    }
    if (strlen($objectif) < 5) {
        $errors[] = 'Décrivez brièvement votre objectif (quelques mots).';
    }
    if ($delais === '') {
        $errors[] = 'Sélectionnez un horizon de délais.';
    }
    if (!$rgpd) {
        $errors[] = 'Vous devez accepter la politique de confidentialité.';
    }

    if (empty($errors)) {
        $host    = $_SERVER['HTTP_HOST'] ?? 'ecosystemeimmo.fr';
        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
        $base    = ($isHttps ? 'https' : 'http') . '://' . $host;
        $pdfUrl  = $base . '/assets/docs/offre-dediee-ecosysteme-immo.pdf';

        $payload = [
            'date'         => date('c'),
            'palier'       => $palier_key,
            'palier_label' => $palier_label,
            'prenom'       => $prenom,
            'nom'          => $nom,
            'email'        => $email,
            'telephone'    => $telephone,
            'metier'       => $metier,
            'ville'        => $ville,
            'experience'   => $experience,
            'objectif'     => $objectif,
            'delais'       => $delais,
        ];

        $dir = __DIR__ . '/data/qualification';
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
        }
        $file = $dir . '/' . date('Y-m-d_His') . '_' . preg_replace('/[^a-z0-9_\-@.]/i', '_', $email) . '.json';
        file_put_contents($file, json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n", LOCK_EX);

        $to = 'oliver@ecosystemeimmo.fr';
        $subject = "Qualification offre dédiée — {$palier_label} — {$prenom} {$nom}";
        $body    = "Palier : {$palier_label}\n\n"
            . "Prénom : {$prenom}\nNom : {$nom}\nEmail : {$email}\nTél : {$telephone}\n"
            . "Métier : {$metier}\nVille : {$ville}\nAncienneté : {$experience}\n"
            . "Délais : {$delais}\n\nObjectif :\n{$objectif}\n";
        $headers = "From: contact@ecosystemeimmo.fr\r\nReply-To: {$email}\r\nContent-Type: text/plain; charset=UTF-8";
        @mail($to, $subject, $body, $headers);

        require_once __DIR__ . '/includes/nocodb.php';
        nocodb_sync('offre_dedie', $payload, "Offre dédiée — {$palier_label} — {$prenom} {$nom}");

        require_once __DIR__ . '/includes/leads_api_client.php';
        ecosystemeimmo_send_lead_to_api([
            'type_demande' => 'offre',
            'prenom'       => $prenom,
            'nom'          => $nom,
            'email'        => $email,
            'telephone'    => $telephone,
            'ville'        => $ville,
            'source'       => 'offre-dedie-qualif',
            'offre'        => $palier_label,
            'besoin'       => $objectif,
            'message'      => "Métier : {$metier}\nAncienneté : {$experience}\nDélais : {$delais}",
            'website'      => '',
        ]);

        $userSubject = "Votre offre complète — Écosystème Immo (dédié immobilier)";
        $userBody    = "Bonjour {$prenom},\n\n"
            . "Merci d'avoir complété le formulaire de qualification pour : {$palier_label}.\n\n"
            . "Vous trouverez la présentation complète de l'offre dédiée au format PDF ici :\n{$pdfUrl}\n\n"
            . "Nous restons à votre disposition pour échanger sur la suite de votre projet.\n\n"
            . "L'équipe Écosystème Immo\n";
        @mail($email, $userSubject, $userBody, "From: contact@ecosystemeimmo.fr\r\nContent-Type: text/plain; charset=UTF-8");

        $_SESSION['merci_offre_dedie'] = true;
        header('Location: /merci-offre-dedie', true, 303);
        exit;
    }
}

$page_title       = 'Recevoir l\'offre dédiée — Qualification';
$meta_description = 'Quelques questions pour personnaliser votre parcours. Vous recevez ensuite la présentation complète de l\'offre dédiée (PDF) par email.';
include 'includes/nav.php';
?>

<main>
  <section class="page-header">
    <div class="container">
      <div class="breadcrumb">
        <a href="/">Accueil</a>
        <span class="breadcrumb-sep">›</span>
        <span>Offre dédiée</span>
      </div>
      <h1 class="page-header-title">Recevoir l'offre complète (PDF)</h1>
      <p class="page-header-subtitle">
        Le temps d'un échange structuré : qualification courte, sans engagement. Dès validation, vous recevez la présentation détaillée de l'offre
        <strong style="color: var(--primary-800);"><?= htmlspecialchars($palier_label) ?></strong>.
      </p>
    </div>
  </section>

  <section class="section">
    <div class="container" style="max-width: 640px;">

      <div class="content-block" style="margin-bottom: 0;">

        <?php if (!empty($errors)): ?>
          <div style="background: #FEF2F2; border: 1px solid #DC2626; border-radius: var(--radius); padding: 16px 20px; margin-bottom: 24px; color: #DC2626; font-size: .9375rem;">
            <?php foreach ($errors as $err): ?>
              <div>⚠ <?= htmlspecialchars($err) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form method="post" action="/offre-dedie-qualif" novalidate class="qualif-form-dedie">

          <!-- Honeypot anti-spam -->
          <div style="position: absolute; left: -5000px;" aria-hidden="true">
            <label for="website">Ne pas remplir</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
          </div>

          <div class="form-group">
            <label class="form-label" for="palier_aff">Palier visé *</label>
            <select class="form-select" id="palier_aff" name="palier">
              <?php foreach ($paliers as $k => $label): ?>
                <option value="<?= htmlspecialchars($k) ?>" <?= $palier_key === $k ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
              <?php endforeach; ?>
            </select>
            <p style="font-size: .8125rem; color: var(--neutral-500); margin-top: 6px;">Vous pouvez changer ici le palier qui vous intéresse.</p>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="prenom">Prénom *</label>
              <input class="form-input" type="text" id="prenom" name="prenom" required
                     value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" placeholder="Jean">
            </div>
            <div class="form-group">
              <label class="form-label" for="nom">Nom *</label>
              <input class="form-input" type="text" id="nom" name="nom" required
                     value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" placeholder="Dupont">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="email">Email *</label>
            <input class="form-input" type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="vous@exemple.com">
          </div>

          <div class="form-group">
            <label class="form-label" for="telephone">Téléphone *</label>
            <input class="form-input" type="tel" id="telephone" name="telephone" required
                   value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>" placeholder="06 00 00 00 00">
          </div>

          <div class="form-group">
            <label class="form-label" for="metier">Votre métier / statut *</label>
            <input class="form-input" type="text" id="metier" name="metier" required
                   value="<?= htmlspecialchars($_POST['metier'] ?? '') ?>"
                   placeholder="Ex. Conseiller immobilier, mandataire, agent indépendant…">
          </div>

          <div class="form-group">
            <label class="form-label" for="ville">Ville d'activité *</label>
            <input class="form-input" type="text" id="ville" name="ville" required
                   value="<?= htmlspecialchars($_POST['ville'] ?? '') ?>" placeholder="Ville principale d'exercice">
          </div>

          <div class="form-group">
            <label class="form-label" for="experience">Années d'expérience *</label>
            <select class="form-select" id="experience" name="experience" required>
              <option value="">— Choisissez —</option>
              <?php
              $optExp = [
                  "Moins d'1 an",
                  "1 à 3 ans",
                  "3 à 5 ans",
                  "5 à 10 ans",
                  "Plus de 10 ans",
              ];
              $postExp = $_POST['experience'] ?? '';
              foreach ($optExp as $o):
              ?>
                <option value="<?= htmlspecialchars($o) ?>" <?= $postExp === $o ? 'selected' : '' ?>><?= htmlspecialchars($o) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="objectif">Votre objectif *</label>
            <textarea class="form-textarea" id="objectif" name="objectif" rows="4" required
              placeholder="Ex. Lancer un site pro local, générer des mandats, structurer le suivi, préparer l'exclusivité géo…"><?= htmlspecialchars($_POST['objectif'] ?? '') ?></textarea>
          </div>

          <div class="form-group">
            <label class="form-label" for="delais">Délais souhaités *</label>
            <select class="form-select" id="delais" name="delais" required>
              <option value="">— Choisissez —</option>
              <?php
              $optDel = [
                  "Moins de 3 mois",
                  "3 à 6 mois",
                  "6 à 12 mois",
                  "Plus d'un an",
                  "Pas de date fixe (exploration)",
              ];
              $postDel = $_POST['delais'] ?? '';
              foreach ($optDel as $o):
              ?>
                <option value="<?= htmlspecialchars($o) ?>" <?= $postDel === $o ? 'selected' : '' ?>><?= htmlspecialchars($o) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group" style="display: flex; gap: 12px; align-items: flex-start;">
            <input type="checkbox" id="rgpd" name="rgpd" required
                   style="margin-top: 3px; flex-shrink: 0; width: 16px; height: 16px;"
                   <?= isset($_POST['rgpd']) ? 'checked' : '' ?>>
            <label for="rgpd" style="font-size: .875rem; color: var(--neutral-600); line-height: 1.5; cursor: pointer;">
              J'accepte d'être recontacté et que mes réponses soient traitées pour cette qualification.
              <a href="/protection-des-donnees" style="color: var(--primary-600);">Politique de confidentialité</a>
            </label>
          </div>

          <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 8px;">
            Valider et recevoir l'offre (PDF)
          </button>
        </form>
      </div>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
