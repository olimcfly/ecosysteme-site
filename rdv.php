<?php
$page_title = 'Diagnostic 30 min — Quel écosystème pour votre situation ?';
$meta_description = 'Réservez 30 minutes : présence actuelle, ville, positionnement, Essentiel / Pro / Expert. Sans pression, sans engagement. Réponse rapide.';

$allowed_sujet_keys = [
  'essentiel'       => 'Essentiel',
  'pro'             => 'Pro',
  'expert'          => 'Expert',
  'diagnostic'      => 'Diagnostic (page Méthode)',
  'lancement-saas'  => 'Lancement de la plateforme SaaS',
];

$sent   = false;
$errors = [];
$sujet_field = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $honeypot = trim((string) ($_POST['website'] ?? ''));
  if ($honeypot !== '') {
    $sent  = true;
    $email = trim((string) ($_POST['email'] ?? ''));
    if ($email === '') {
      $email = 'l’adresse indiquée dans le formulaire';
    }
  } else {
  $prenom     = trim($_POST['prenom']     ?? '');
  $nom        = trim($_POST['nom']        ?? '');
  $email      = trim($_POST['email']      ?? '');
  $telephone  = trim($_POST['telephone']  ?? '');
  $ville      = trim($_POST['ville']      ?? '');
  $reseau     = trim($_POST['reseau']     ?? '');
  $anciennete = trim($_POST['anciennete'] ?? '');
  $situation  = trim($_POST['situation']  ?? '');
  $message    = trim($_POST['message']    ?? '');
  $rgpd       = isset($_POST['rgpd']);

  $sujet_in = $_POST['sujet'] ?? '';
  $sujet_ok = isset($allowed_sujet_keys[$sujet_in]) ? $sujet_in : '';

  if (strlen($prenom) < 2) {
    $errors[] = 'Prénom trop court.';
  }
  if (strlen($nom) < 2) {
    $errors[] = 'Nom trop court.';
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email invalide.';
  }
  if (strlen($telephone) < 10) {
    $errors[] = 'Téléphone invalide.';
  }
  if (strlen($ville) < 2) {
    $errors[] = 'Ville requise.';
  }
  if (!$rgpd) {
    $errors[] = 'Vous devez accepter la politique de confidentialité.';
  }

  if (empty($errors)) {
    $typeLabel = $sujet_ok ? $allowed_sujet_keys[$sujet_ok] : 'Diagnostic 30 min';

    require_once __DIR__ . '/includes/leads_api_client.php';
    ecosystemeimmo_send_lead_to_api([
        'type_demande' => 'rdv',
        'prenom'       => $prenom,
        'nom'          => $nom,
        'email'        => $email,
        'telephone'    => $telephone,
        'ville'        => $ville,
        'message'      => $message,
        'besoin'       => $situation,
        'source'       => 'rdv-site-public',
        'type_rdv'     => $typeLabel,
        'reseau'       => $reseau,
        'anciennete'   => $anciennete,
        'situation'    => $situation,
        'sujet_label'  => $sujet_ok ? $allowed_sujet_keys[$sujet_ok] : '',
        'website'      => '',
    ]);

    $to = 'oliver@ecosystemeimmo.fr';
    $subject = "Diagnostic 30 min — {$prenom} {$nom}";

    $extra = $sujet_ok ? "\nIntérêt (page) : " . $allowed_sujet_keys[$sujet_ok] . "\n" : "\n";
    $body  = "Demande de diagnostic 30 minutes (écosystème & situation).{$extra}\n"
      . "Prénom : {$prenom}\nNom : {$nom}\nEmail : {$email}\nTéléphone : {$telephone}\n"
      . "Ville : {$ville}\nRéseau : {$reseau}\nAncienneté : {$anciennete}\n"
      . "Situation : {$situation}\nMessage : {$message}";

    $headers = "From: contact@ecosystemeimmo.fr\r\nReply-To: {$email}\r\nContent-Type: text/plain; charset=UTF-8";

    @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);
    require_once __DIR__ . '/includes/nocodb.php';
    nocodb_sync('rdv', [
        'prenom'      => $prenom,
        'nom'         => $nom,
        'email'       => $email,
        'telephone'   => $telephone,
        'ville'       => $ville,
        'reseau'      => $reseau,
        'anciennete'  => $anciennete,
        'situation'   => $situation,
        'message'     => $message,
        'sujet'       => $sujet_ok,
        'sujet_label' => $sujet_ok ? $allowed_sujet_keys[$sujet_ok] : '',
    ], "RDV 30 min — {$prenom} {$nom}");
    $sent = true;
  } elseif (isset($_POST['sujet']) && isset($allowed_sujet_keys[$_POST['sujet']])) {
    $sujet_field = $_POST['sujet'];
  }
  }
} elseif (isset($_GET['sujet']) && isset($allowed_sujet_keys[$_GET['sujet']])) {
  $sujet_field = $_GET['sujet'];
}

if ($sujet_field === 'lancement-saas') {
  $page_title       = 'Être prévenu au lancement — SaaS Écosystème Immo';
  $meta_description = 'Indiquez vos coordonnées : nous vous recontactons pour le lancement (essai 30 jours, offre fondateur). Même formulaire sécurisé, réponse en général sous 24h ouvrées.';
}

$body_class = 'page-rdv' . ($sujet_field === 'lancement-saas' ? ' page-rdv--lancement-saas' : '');
include 'includes/nav.php';
?>

<main class="main-rdv">

  <section class="page-header page-header--rdv">
    <div class="container">
      <div class="breadcrumb">
        <a href="/">Accueil</a>
        <span class="breadcrumb-sep">›</span>
        <span>Diagnostic &amp; RDV</span>
      </div>
      <h1 class="page-header-title">Voyons quel écosystème peut réellement vous aider</h1>
      <p class="page-header-subtitle page-header-subtitle--wide">En 30 minutes, on regarde votre <strong>présence actuelle</strong>, votre <strong>ville</strong> ou <strong>secteur</strong>, votre <strong>positionnement</strong> et le <strong>niveau d’offre</strong> le plus adapté à votre <strong>cadre et votre budget</strong> — si ça a du sens.</p>
      <div class="rdv-hero-actions">
        <a href="#reservation" class="btn btn-primary btn-lg">Réserver mon diagnostic</a>
        <a href="/verifier-ma-ville" class="btn btn-secondary btn-lg">Vérifier ma ville avant l’appel</a>
      </div>
    </div>
  </section>

  <section class="section rdv-section-pendant">
    <div class="container container-md">
      <div class="section-header center rdv-head-pendant">
        <span class="section-tag">Pendant l’appel</span>
        <h2 class="section-title">Pendant l’appel, on regarde</h2>
        <p class="section-subtitle rdv-lede-pendant">Pas de slide linéaire : on part de <strong>votre</strong> terrain, pas d’un scénario vendeur toutes grilles confondues.</p>
      </div>
      <div class="rdv-info-grid rdv-pendant-grid">
        <div class="rdv-info-card">
          <span class="rdv-info-arrow" aria-hidden="true">→</span>
          <p>Votre <strong>ville</strong> ou <strong>secteur</strong> (et, si besoin, comment une grande agglomération peut se découper).</p>
        </div>
        <div class="rdv-info-card">
          <span class="rdv-info-arrow" aria-hidden="true">→</span>
          <p>Votre <strong>présence digitale</strong> actuelle — ce qui tourne, ce qui coince, ce qui manque.</p>
        </div>
        <div class="rdv-info-card">
          <span class="rdv-info-arrow" aria-hidden="true">→</span>
          <p>Votre <strong>site</strong> ou <strong>profil</strong> existant (même bancal : on tranche le signal du bruit).</p>
        </div>
        <div class="rdv-info-card">
          <span class="rdv-info-arrow" aria-hidden="true">→</span>
          <p>Vos <strong>sources de prospects</strong> : d’où viennent les contacts aujourd’hui, et où vous voulez en être dans 3 à 6 mois.</p>
        </div>
        <div class="rdv-info-card">
          <span class="rdv-info-arrow" aria-hidden="true">→</span>
          <p>Votre <strong>niveau de besoin</strong> côté offre : <strong>Essentiel</strong>, <strong>Pro</strong> ou <strong>Expert</strong> — ou autre enchaînement si c’est plus cohérent.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-light rdv-section-not">
    <div class="container container-md">
      <div class="section-header center rdv-head-not">
        <span class="section-tag section-tag--muted">Transparence</span>
        <h2 class="section-title">Ce n’est pas</h2>
      </div>
      <div class="rdv-not-block">
        <ul>
          <li><strong>Pas</strong> un appel de vente forcée : pas de compte à rebours, pas d’artifice.</li>
          <li><strong>Pas</strong> une formation théorique : on reste sur du concret, votre situation d’abord.</li>
          <li><strong>Pas</strong> une promesse magique : la visibilité locale se travaille — on dit ce qui tient, et ce qui ne tient pas.</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="section rdv-section-takeaway">
    <div class="container container-md">
      <div class="section-header center rdv-head-takeaway">
        <span class="section-tag">Après l’appel</span>
        <h2 class="section-title">Vous repartez avec</h2>
      </div>
      <div class="rdv-benefits-grid rdv-takeaway-grid">
        <div class="rdv-benefit-card">
          <span class="rdv-benefit-check" aria-hidden="true">✓</span>
          <p>Une <strong>lecture claire</strong> de votre situation (forces, angles morts, priorité 1).</p>
        </div>
        <div class="rdv-benefit-card">
          <span class="rdv-benefit-check" aria-hidden="true">✓</span>
          <p>Les <strong>3 priorités</strong> pour avancer côté <strong>visibilité locale</strong> — pas une liste de 20 cases.</p>
        </div>
        <div class="rdv-benefit-card">
          <span class="rdv-benefit-check" aria-hidden="true">✓</span>
          <p>L’<strong>offre</strong> qui colle le mieux <strong>ou</strong> l’honnêteté que ce n’est <strong>pas</strong> le bon moment / le bon fit — c’est valable aussi.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-light rdv-section-form" id="reservation">
    <div class="container">
      <div class="contact-layout rdv-form-layout">

        <div class="rdv-form-intro-col">
          <span class="section-tag">Prochaine étape</span>
          <h2 class="section-title rdv-form-intro-title">Formulaire, puis recontact pour caler les 30 minutes</h2>
          <p class="rdv-form-intro-text">
            Nous n’avons <strong>pas</strong> de prise de rendez-vous en direct sur le site pour l’instant : vous laissez vos coordonnées, on revient vers vous <strong>vite</strong> (souvent sous <strong>24h ouvrées</strong>) pour <strong>fixer le créneau</strong> qui vous arrange. C’est le même filet de sécurité qu’avant, avec un cadrage plus explicite.
          </p>
          <p class="rdv-form-intro-note">
            Vous hésitez sur le <strong>territoire</strong> ? Avant l’appel, vous pouvez demander une <strong>vérification de disponibilité</strong> (ville / secteur) — c’est <strong>gratuit</strong> et <strong>sans engagement</strong>.
          </p>
          <a href="/verifier-ma-ville" class="btn btn-secondary rdv-form-intro-cta">Vérifier ma ville avant l’appel</a>
        </div>

        <div class="contact-form-wrapper rdv-form-panel">

          <?php if ($sent): ?>
            <div class="rdv-success">
              <div class="rdv-success-icon" aria-hidden="true">✅</div>
              <h3 class="heading-md rdv-success-title">Demande bien reçue</h3>
              <p class="rdv-success-text">
                On vous recontacte pour <strong>planifier le diagnostic 30 min</strong>, en général sous <strong>24h ouvrées</strong>, sur <strong><?= htmlspecialchars($email) ?></strong>.
              </p>
              <a href="/" class="btn btn-secondary rdv-success-btn">Retour à l’accueil</a>
            </div>

          <?php else: ?>

            <h3 class="heading-md rdv-form-h3">Réserver mon diagnostic</h3>
            <p class="rdv-form-hint">Même champs qu’avant : ça alimente le même traitement côté serveur.</p>

            <?php if ($sujet_field && isset($allowed_sujet_keys[$sujet_field])): ?>
              <div class="content-block rdv-sujet-banner<?= $sujet_field === 'lancement-saas' ? ' rdv-sujet-banner--lancement' : '' ?>">
                <p class="rdv-sujet-banner-text">
                  <?php if ($sujet_field === 'lancement-saas'): ?>
                    Vous souhaitez être <strong>prévenu au lancement</strong> de la plateforme : nous en tiendrons compte dans notre recontact (priorité lancement / essai).
                  <?php else: ?>
                    Vous arrivez avec un intérêt pour <strong><?= htmlspecialchars($allowed_sujet_keys[$sujet_field]) ?></strong> : on le prendra en compte sur l’appel.
                  <?php endif; ?>
                </p>
              </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
              <div class="rdv-error-alert" role="alert">
                <?php foreach ($errors as $err): ?>
                  <div class="rdv-error-line">⚠ <?= htmlspecialchars($err) ?></div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <form method="post" action="/rdv#reservation" novalidate>
              <input type="hidden" name="type_demande" value="rdv">
              <input type="hidden" name="source" value="rdv-site-public">
              <?php if ($sujet_field && isset($allowed_sujet_keys[$sujet_field])): ?>
                <input type="hidden" name="sujet" value="<?= htmlspecialchars($sujet_field) ?>">
              <?php endif; ?>

              <div class="form-honeypot-rdv" style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
                <label for="website_rdv">Ne pas remplir</label>
                <input type="text" id="website_rdv" name="website" tabindex="-1" autocomplete="off" value="">
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="prenom">Prénom *</label>
                  <input class="form-input" type="text" id="prenom" name="prenom"
                         value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
                         placeholder="Jean" required autocomplete="given-name">
                </div>
                <div class="form-group">
                  <label class="form-label" for="nom">Nom *</label>
                  <input class="form-input" type="text" id="nom" name="nom"
                         value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                         placeholder="Dupont" required autocomplete="family-name">
                </div>
              </div>

              <div class="form-group">
                <label class="form-label" for="email">Email *</label>
                <input class="form-input" type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="jean.dupont@email.com" required autocomplete="email">
              </div>

              <div class="form-group">
                <label class="form-label" for="telephone">Téléphone *</label>
                <input class="form-input" type="tel" id="telephone" name="telephone"
                       value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>"
                       placeholder="06 12 34 56 78" required autocomplete="tel">
              </div>

              <div class="form-group">
                <label class="form-label" for="ville">Ville ou secteur d’activité *</label>
                <input class="form-input" type="text" id="ville" name="ville"
                       value="<?= htmlspecialchars($_POST['ville'] ?? '') ?>"
                       placeholder="Ex. commune, périphérie, arrondissement…" required>
              </div>

              <div class="form-group">
                <label class="form-label" for="reseau">Réseau ou indépendant</label>
                <select class="form-select" id="reseau" name="reseau">
                  <option value="">— Choisissez —</option>
                  <option value="IAD" <?= ($_POST['reseau'] ?? '') === 'IAD' ? 'selected' : '' ?>>IAD</option>
                  <option value="Optimhome" <?= ($_POST['reseau'] ?? '') === 'Optimhome' ? 'selected' : '' ?>>Optimhome</option>
                  <option value="Safti" <?= ($_POST['reseau'] ?? '') === 'Safti' ? 'selected' : '' ?>>Safti</option>
                  <option value="eXp" <?= ($_POST['reseau'] ?? '') === 'eXp' ? 'selected' : '' ?>>eXp</option>
                  <option value="Autre réseau" <?= ($_POST['reseau'] ?? '') === 'Autre réseau' ? 'selected' : '' ?>>Autre réseau</option>
                  <option value="Indépendant" <?= ($_POST['reseau'] ?? '') === 'Indépendant' ? 'selected' : '' ?>>Indépendant</option>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label" for="anciennete">Depuis combien de temps êtes-vous conseiller ?</label>
                <select class="form-select" id="anciennete" name="anciennete">
                  <option value="">— Choisissez —</option>
                  <option value="Moins d'1 an" <?= ($_POST['anciennete'] ?? '') === "Moins d'1 an" ? 'selected' : '' ?>>Moins d'1 an</option>
                  <option value="1 à 3 ans" <?= ($_POST['anciennete'] ?? '') === '1 à 3 ans' ? 'selected' : '' ?>>1 à 3 ans</option>
                  <option value="Plus de 3 ans" <?= ($_POST['anciennete'] ?? '') === 'Plus de 3 ans' ? 'selected' : '' ?>>Plus de 3 ans</option>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label" for="situation">Votre situation actuelle</label>
                <select class="form-select" id="situation" name="situation">
                  <option value="">— Choisissez —</option>
                  <option value="Je n'ai pas de site" <?= ($_POST['situation'] ?? '') === "Je n'ai pas de site" ? 'selected' : '' ?>>Je n'ai pas de site</option>
                  <option value="J'ai un site mais il ne génère pas de leads" <?= ($_POST['situation'] ?? '') === "J'ai un site mais il ne génère pas de leads" ? 'selected' : '' ?>>J'ai un site mais il ne génère pas de leads</option>
                  <option value="Je cherche à mieux structurer mon activité" <?= ($_POST['situation'] ?? '') === "Je cherche à mieux structurer mon activité" ? 'selected' : '' ?>>Je cherche à mieux structurer mon activité</option>
                  <option value="Autre" <?= ($_POST['situation'] ?? '') === 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label" for="message">Votre message (optionnel)</label>
                <textarea class="form-textarea" id="message" name="message" rows="3"
                  placeholder="Précisez votre situation, votre budget approximatif ou vos questions…"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
              </div>

              <div class="form-group form-group--rgpd rdv-rgpd">
                <input class="rdv-rgpd-input" type="checkbox" id="rgpd" name="rgpd" required
                       <?= isset($_POST['rgpd']) ? 'checked' : '' ?>>
                <label class="rdv-rgpd-label" for="rgpd">
                  J'accepte que mes données soient utilisées pour me recontacter.
                  <a href="/protection-des-donnees" class="rdv-rgpd-link">Politique de confidentialité →</a>
                </label>
              </div>

              <button type="submit" class="btn btn-primary rdv-submit">
                Réserver mon diagnostic
              </button>
            </form>

          <?php endif; ?>

        </div>
      </div>
    </div>
  </section>

  <div class="trust-bar rdv-trust-bar">
    <div class="container">
      <div class="trust-items">
        <div class="trust-item"><span class="trust-icon">✓</span> Réponse en général sous 24h ouvrées</div>
        <div class="trust-item"><span class="trust-icon">✓</span> Aucun engagement sur ce seul échange</div>
        <div class="trust-item"><span class="trust-icon">✓</span> Données traitées en interne, usage contact</div>
      </div>
    </div>
  </div>

</main>

<?php include 'includes/footer.php'; ?>
