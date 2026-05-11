<?php
$page_title = 'Vérifier la disponibilité de votre ville ou secteur';
$meta_description = 'Exclusivité territoriale : un seul conseiller par ville ou secteur prioritaire. Villes déjà réservées : Bordeaux, Nantes, Nandy, Aix-en-Provence, Lannion. Vérifiez votre zone.';
$body_class = 'page-verifier-ville';

$villes_fermees = ['Bordeaux', 'Nantes', 'Nandy', 'Aix-en-Provence', 'Lannion'];

/* Formulaire : même logique que /rdv (mail) */
$sent   = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $honeypot = trim((string) ($_POST['website'] ?? ''));
    if ($honeypot !== '') {
        $sent  = true;
        $email = trim((string) ($_POST['email'] ?? ''));
        if ($email === '') {
            $email = 'l’adresse indiquée dans le formulaire';
        }
    } else {
    $prenom    = trim($_POST['prenom'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $ville     = trim($_POST['ville_souhaitee'] ?? '');
    $reseau    = trim($_POST['reseau'] ?? '');
    $message   = trim($_POST['message'] ?? '');
    $rgpd      = isset($_POST['rgpd']);

    if (strlen($prenom) < 2) {
        $errors[] = 'Prénom trop court.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email invalide.';
    }
    if (strlen($telephone) < 10) {
        $errors[] = 'Téléphone invalide (10 caractères minimum).';
    }
    if (strlen($ville) < 2) {
        $errors[] = 'Indiquez la ville ou le secteur concerné.';
    }
    if (!$rgpd) {
        $errors[] = 'Vous devez accepter la politique de confidentialité.';
    }

    if (empty($errors)) {
        $to      = 'oliver@ecosystemeimmo.fr';
        $subject = "Vérification disponibilité territoire — {$prenom}";
        $body    = "Demande de vérification (pas de réservation avant validation humaine).\n\n"
            . "Prénom : {$prenom}\n"
            . "Email : {$email}\n"
            . "Téléphone : {$telephone}\n"
            . "Ville / secteur souhaité : {$ville}\n"
            . "Réseau : {$reseau}\n"
            . "Message : {$message}\n";
        $headers = "From: contact@ecosystemeimmo.fr\r\nReply-To: {$email}\r\nContent-Type: text/plain; charset=UTF-8";

        @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);
        require_once __DIR__ . '/includes/nocodb.php';
        nocodb_sync('ville', [
            'prenom'    => $prenom,
            'email'     => $email,
            'telephone' => $telephone,
            'ville'     => $ville,
            'reseau'    => $reseau,
            'message'   => $message,
        ], "Vérif. ville — {$prenom}");
        require_once __DIR__ . '/includes/leads_api_client.php';
        ecosystemeimmo_send_lead_to_api([
            'type_demande' => 'prospect',
            'prenom'       => $prenom,
            'nom'          => '',
            'email'        => $email,
            'telephone'    => $telephone,
            'ville'        => $ville,
            'source'       => 'verifier-ma-ville',
            'message'      => trim(($reseau !== '' ? "Réseau : {$reseau}\n\n" : '') . $message),
            'website'      => '',
        ]);
        $sent = true;
    }
    }
}

include 'includes/nav.php';
?>

<main class="main-verifier-ville" id="contenu-principal">

  <section class="page-header page-header--verif-ville">
    <div class="container">
      <div class="breadcrumb">
        <a href="/">Accueil</a>
        <span class="breadcrumb-sep">›</span>
        <span>Vérifier ma ville</span>
      </div>
      <h1 class="page-header-title">Votre ville est-elle encore disponible ?</h1>
      <p class="page-header-subtitle page-header-subtitle--wide">Écosystème Immo fonctionne avec une <strong>exclusivité territoriale</strong> : <strong>un seul conseiller</strong> par <strong>ville</strong> ou <strong>secteur prioritaire</strong> (selon le cadrage).</p>
    </div>
  </section>

  <div class="verif-kpi-bar" aria-label="Principes">
    <div class="container">
      <ul class="verif-kpi-bar__list">
        <li class="verif-kpi-bar__item">Validation humaine — pas d’engagement par formulaire seul</li>
        <li class="verif-kpi-bar__item">Découpage possible (quartier, périphérie)</li>
        <li class="verif-kpi-bar__item">Offres : <a href="/offres">détail</a> &amp; <a href="/etudes-cas">études de cas</a></li>
      </ul>
    </div>
  </div>

  <section class="section verif-lede">
    <div class="container container-md">
      <div class="content-block verif-lede__block">
        <p class="verif-lede__text">
          Une <strong>ville</strong> ou une <strong>zone</strong> ne peut être active pour le <strong class="verif-lede__em">même dispositif</strong> qu’<strong>un seul</strong> conseiller à la fois — afin d’éviter la course aux mêmes mots-clés et la même offre, sur le <strong>même</strong> territoire.
        </p>
      </div>
    </div>
  </section>

  <section class="section bg-light verif-why" id="pourquoi">
    <div class="container">
      <div class="section-header center verif-why__header">
        <span class="section-tag">Exclusivité</span>
        <h2 class="section-title">Pourquoi l'exclusivité</h2>
        <div class="section-title-accent" aria-hidden="true"></div>
      </div>
      <div class="grid grid-2 verif-why__grid">
        <div class="content-block verif-why__col">
          <ul class="verif-why__ul">
            <li>éviter que deux conseillers portent <strong>le même système</strong> sur <strong>la même zone cible</strong> ;</li>
            <li>renforcer le <strong>SEO local</strong> (un positionnement, une voix) ;</li>
          </ul>
        </div>
        <div class="content-block verif-why__col">
          <ul class="verif-why__ul">
            <li>protéger l'<strong>investissement</strong> (temps, budget, contenus) de chacun ;</li>
            <li>tracer un <strong>vrai territoire digital</strong> — pas une carte à joueurs illimités.</li>
          </ul>
        </div>
      </div>
      <p class="verif-why__foot">
        Les <strong>grandes agglomérations</strong> peuvent être <strong>découpées en secteurs</strong> ou <strong>quartiers</strong> : la zone exacte se valide <strong>au cas par cas</strong>, humain, selon le marché.
      </p>
    </div>
  </section>

  <section class="section" id="villes-fermees">
    <div class="container">
      <div class="section-header center verif-cities__header">
        <span class="section-tag">Bêta &amp; lancements</span>
        <h2 class="section-title">Territoires déjà réservés (à date)</h2>
        <p class="section-subtitle">Ces billets sont <strong>fermés</strong> sur la liste publique. La matrice complète côté équipe peut évoluer — la réponse à votre demande reste <strong>personnalisée</strong>.</p>
      </div>
      <div class="verif-cities__chips">
        <?php foreach ($villes_fermees as $v): ?>
          <span class="badge verif-city-badge">🔒 <?= htmlspecialchars($v) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section bg-light verif-form-section" id="formulaire">
    <div class="container">
      <div class="contact-layout verif-form-layout">

        <div class="verif-form-intro">
          <span class="section-tag">Sans engagement</span>
          <h2 class="section-title verif-form-intro__title">Demander une vérification</h2>
          <p class="verif-form-intro__lede">
            Indiquez la <strong>ville</strong> ou le <strong>secteur</strong> visé : nous le croisons avec les territoires déjà engagés. <strong>Aucune réservation n’est confirmée</strong> par le seul envoi du formulaire — la faisabilité est validée <strong>par l’équipe</strong>, au cas par cas.
          </p>
          <div class="content-block verif-form-intro__note">
            <p class="verif-form-intro__note-p">
              <strong>Important :</strong> le territoire exact (ville, périphérie, arrondissement, quartier) se précise en échange — la carte n’est jamais « bloquée » par un seul critère automatisé.
            </p>
          </div>
        </div>

        <div class="contact-form-wrapper verif-form-wrapper">
          <?php if ($sent): ?>
            <div class="content-block verif-success">
              <div class="verif-success__ico" aria-hidden="true">✅</div>
              <h3 class="heading-md verif-success__title">Demande bien envoyée</h3>
              <p class="verif-success__text">
                Nous revenons vers vous sur la disponibilité de votre <strong>secteur</strong>, en général sous <strong>24–48h</strong> ouvrées, sur <strong><?= htmlspecialchars($email) ?></strong>.
              </p>
              <a href="/" class="btn btn-secondary verif-success__btn">Retour à l'accueil</a>
            </div>
          <?php else: ?>
            <h3 class="heading-md verif-form-block-title">Vérifier ma ville</h3>
            <?php if (!empty($errors)): ?>
              <div class="verif-errors" role="alert">
                <?php foreach ($errors as $err): ?>
                  <div><?= htmlspecialchars($err) ?></div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <form method="post" action="/verifier-ma-ville#formulaire" novalidate>
              <div class="form-honeypot-verif" style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
                <label for="website_verif">Ne pas remplir</label>
                <input type="text" id="website_verif" name="website" tabindex="-1" autocomplete="off" value="">
              </div>
              <div class="form-group">
                <label class="form-label" for="prenom_ville">Prénom *</label>
                <input class="form-input" type="text" id="prenom_ville" name="prenom" required
                       value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
                       placeholder="Votre prénom" autocomplete="given-name">
              </div>
              <div class="form-group">
                <label class="form-label" for="email_ville">Email *</label>
                <input class="form-input" type="email" id="email_ville" name="email" required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="vous@exemple.fr" autocomplete="email">
              </div>
              <div class="form-group">
                <label class="form-label" for="telephone_ville">Téléphone *</label>
                <input class="form-input" type="tel" id="telephone_ville" name="telephone" required
                       value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>"
                       placeholder="06 00 00 00 00" autocomplete="tel">
              </div>
              <div class="form-group">
                <label class="form-label" for="ville_souhaitee">Ville ou secteur souhaité *</label>
                <input class="form-input" type="text" id="ville_souhaitee" name="ville_souhaitee" required
                       value="<?= htmlspecialchars($_POST['ville_souhaitee'] ?? '') ?>"
                       placeholder="Ex. quartier, commune, périphérie…">
                <p class="verif-field-hint">Précisez au possible : c’est ce périmètre que nous croisons avec les réservations en cours.</p>
              </div>
              <div class="form-group">
                <label class="form-label" for="reseau_ville">Réseau immobilier</label>
                <select class="form-select" id="reseau_ville" name="reseau">
                  <option value="">— Indiquez si besoin —</option>
                  <option <?= ($_POST['reseau'] ?? '') === 'IAD' ? 'selected' : '' ?>>IAD</option>
                  <option <?= ($_POST['reseau'] ?? '') === 'Optimhome' ? 'selected' : '' ?>>Optimhome</option>
                  <option <?= ($_POST['reseau'] ?? '') === 'Safti' ? 'selected' : '' ?>>Safti</option>
                  <option <?= ($_POST['reseau'] ?? '') === 'eXp' ? 'selected' : '' ?>>eXp</option>
                  <option <?= ($_POST['reseau'] ?? '') === 'Autre réseau' ? 'selected' : '' ?>>Autre réseau</option>
                  <option <?= ($_POST['reseau'] ?? '') === 'Indépendant' ? 'selected' : '' ?>>Indépendant</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label" for="message_ville">Message (optionnel)</label>
                <textarea class="form-textarea" id="message_ville" name="message" rows="3"
                  placeholder="Précision sur votre cible géographique, délai, offre en tête…"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
              </div>
              <div class="form-group verif-rgpd">
                <input type="checkbox" id="rgpd_ville" name="rgpd" required class="verif-rgpd__input"
                       <?= isset($_POST['rgpd']) ? 'checked' : '' ?>>
                <label for="rgpd_ville" class="verif-rgpd__label">
                  J'accepte d'être recontacté·e pour cette vérification.
                  <a href="/protection-des-donnees" class="verif-rgpd__link">Confidentialité →</a>
                </label>
              </div>
              <button type="submit" class="btn btn-primary verif-submit">
                Vérifier ma ville
              </button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="section verif-reassurance" id="reassurance" aria-label="Informations rassurantes">
    <div class="container verif-reassurance__inner">
      <div class="grid grid-2 verif-reassurance__grid">
        <div class="content-block verif-reassurance__card">
          <p class="verif-reassurance__p">
            Cette vérification est <strong>gratuite</strong> et <strong>sans engagement</strong>.
          </p>
        </div>
        <div class="content-block verif-reassurance__card">
          <p class="verif-reassurance__p">
            Vous recevez une <strong>réponse claire</strong> sur la disponibilité de votre <strong>ville ou secteur</strong> (selon le cadrage possible).
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="section verif-offres-rappel" id="rappel-offres">
    <div class="container">
      <div class="section-header center verif-offres-rappel__header">
        <span class="section-tag">Offres</span>
        <h2 class="section-title">Quand le territoire est libre, que choisir ?</h2>
        <p class="section-subtitle">Trois niveaux, une même logique de système — conditions et accompagnement détaillés sur la page <a href="/offres" class="verif-inline-link">Offres</a> (sur demande).</p>
      </div>
      <div class="grid grid-3 verif-offres-rappel__grid">
        <div class="content-block verif-offre-card">
          <span class="badge badge-primary verif-offre-card__badge">Essentiel</span>
          <p class="verif-offre-card__text">Socle digital structuré — bon pour lancer proprement.</p>
        </div>
        <div class="content-block verif-offre-card verif-offre-card--featured">
          <div class="verif-offre-card__ribbon">Recommandé</div>
          <p class="verif-offre-card__badge-wrap"><span class="badge badge-accent">Pro</span></p>
          <p class="verif-offre-card__text">Écosystème dédié — l’option la plus demandée quand l’immo est votre cœur de métier.</p>
        </div>
        <div class="content-block verif-offre-card">
          <span class="badge badge-primary verif-offre-card__badge">Expert</span>
          <p class="verif-offre-card__text">Stratégie, contenus, pub et pilotage serré — quand vous voulez aller plus vite.</p>
        </div>
      </div>
      <div class="verif-offres-rappel__cta">
        <a href="/offres" class="btn btn-dark">Découvrir les offres</a>
      </div>
    </div>
  </section>

  <section class="section cta-section verif-cta-final">
    <div class="container container-md">
      <div class="section-header center verif-cta-final__header">
        <h2 class="section-title verif-cta-final__title">Préférez voir le système en direct ?</h2>
        <p class="section-subtitle verif-cta-final__sub">Même règle : échange concret, pas de promesse en l’air.</p>
        <div class="cta-buttons">
          <a href="/rdv" class="btn btn-primary btn-lg">Réserver mon diagnostic</a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include 'includes/footer.php'; ?>
