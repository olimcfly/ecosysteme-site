<?php
declare(strict_types=1);

$page_title = 'Audit gratuit Google Business Profile';
$meta_description = 'Recevez un audit gratuit de votre fiche Google Business Profile : score de visibilité locale, avis, catégories, photos, posts, NAP et plan d’action prioritaire.';
$body_class = 'page-gmb-audit';
$canonical_url = 'https://ecosystemeimmo.fr/audit-fiche-google/';

$requestPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?: '';
if ($requestPath === '/audit-fiche-google.php') {
    header('Location: /audit-fiche-google/' . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : ''), true, 301);
    exit;
}
if ($requestPath === '/audit-fiche-google-merci.php') {
    header('Location: /audit-fiche-google/merci/' . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : ''), true, 301);
    exit;
}

require_once __DIR__ . '/includes/gmb_audit_helpers.php';

$stage = trim((string) ($_POST['step'] ?? $_GET['step'] ?? ''));
$errors = [];
$preview = null;
$audit = null;
$analysisInput = [
    'google_business_url' => '',
    'city' => '',
    'network_name' => '',
];
$captureResult = null;

if (isset($_GET['audit_id'], $_GET['token']) && (int) $_GET['audit_id'] > 0 && trim((string) $_GET['token']) !== '') {
    $view = gmb_audit_view_remote((int) $_GET['audit_id'], trim((string) $_GET['token']));
    if (!empty($view['ok']) && is_array($view['data']['audit'] ?? null)) {
        $audit = $view['data']['audit'];
        $analysisInput = [
            'google_business_url' => (string) ($audit['google_business_url'] ?? ''),
            'city' => (string) ($audit['city'] ?? ''),
            'network_name' => (string) ($audit['network_name'] ?? ''),
        ];
    } else {
        $errors[] = 'Le rapport est temporairement indisponible. Vous pouvez lancer une nouvelle analyse.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $stage !== 'capture') {
    if (trim((string) ($_POST['website'] ?? '')) !== '') {
        $errors[] = 'Soumission rejetée.';
    } else {
        $analysisInput = [
            'google_business_url' => trim((string) ($_POST['google_business_url'] ?? '')),
            'city' => gmb_audit_clean((string) ($_POST['city'] ?? '')),
            'network_name' => gmb_audit_clean((string) ($_POST['network_name'] ?? '')),
        ];
        if (!filter_var($analysisInput['google_business_url'], FILTER_VALIDATE_URL)) {
            $errors[] = 'Le lien Google Business Profile est invalide.';
        }
        if ($analysisInput['city'] === '') {
            $errors[] = 'La ville est obligatoire.';
        }
        if ($errors === []) {
            $preview = gmb_audit_preview($analysisInput, gmb_audit_fetch_places($analysisInput));
        }
    }
} elseif ($audit !== null) {
    $preview = [
        'global_score' => (int) ($audit['global_score'] ?? 0),
        'findings' => array_slice(array_values(array_filter(array_map('trim', (array) ($audit['weaknesses'] ?? [])))), 0, 3),
        'main_opportunity' => (string) ($audit['main_opportunity'] ?? ''),
        'short_summary' => (string) ($audit['short_summary'] ?? ''),
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $stage === 'capture') {
    if (trim((string) ($_POST['website'] ?? '')) !== '') {
        $errors[] = 'Soumission rejetée.';
    } else {
        $payload = [
            'google_business_url' => trim((string) ($_POST['google_business_url'] ?? '')),
            'city' => gmb_audit_clean((string) ($_POST['city'] ?? '')),
            'network_name' => gmb_audit_clean((string) ($_POST['network_name'] ?? '')),
            'first_name' => gmb_audit_clean((string) ($_POST['first_name'] ?? '')),
            'email' => gmb_audit_clean((string) ($_POST['email'] ?? '')),
            'phone' => gmb_audit_clean((string) ($_POST['phone'] ?? '')),
            'consent_rgpd' => !empty($_POST['consent_rgpd']) || !empty($_POST['information_prospection']) ? '1' : '',
            'information_prospection' => !empty($_POST['information_prospection']) ? '1' : '',
            'utm_source' => trim((string) ($_POST['utm_source'] ?? ($_GET['utm_source'] ?? ''))),
            'utm_medium' => trim((string) ($_POST['utm_medium'] ?? ($_GET['utm_medium'] ?? ''))),
            'utm_campaign' => trim((string) ($_POST['utm_campaign'] ?? ($_GET['utm_campaign'] ?? ''))),
            'landing_page' => '/audit-fiche-google',
            'referrer' => trim((string) ($_POST['referrer'] ?? ($_SERVER['HTTP_REFERER'] ?? ''))),
            'form_ts' => trim((string) ($_POST['form_ts'] ?? '')),
            'session_token' => trim((string) ($_POST['session_token'] ?? '')),
            'website' => trim((string) ($_POST['website'] ?? '')),
        ];

        if (!filter_var($payload['google_business_url'], FILTER_VALIDATE_URL)) {
            $errors[] = 'Le lien Google Business Profile est invalide.';
        }
        if ($payload['city'] === '') {
            $errors[] = 'La ville est obligatoire.';
        }
        if ($payload['first_name'] === '') {
            $errors[] = 'Le prénom est obligatoire.';
        }
        if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'L’email professionnel est invalide.';
        }
        if ($payload['consent_rgpd'] === '') {
            $errors[] = 'Le consentement est requis.';
        }

        if ($errors === []) {
            $captureResult = gmb_audit_capture_remote($payload);
            if (!empty($captureResult['ok']) && !empty($captureResult['data']['thank_you_url'])) {
                header('Location: ' . $captureResult['data']['thank_you_url'], true, 302);
                exit;
            }
            $errors[] = 'Votre demande ne peut pas être envoyée pour le moment. Réessayez dans quelques minutes.';
        }
    }
}

?>
<?php
$signup_page_minimal_nav = true;
$minimal_nav_tagline = 'Audit gratuit Google Business Profile';
include __DIR__ . '/includes/header.php';
?>

<main class="page-gmb-audit">
  <section class="gmb-audit-hero">
    <div class="container">
      <div class="gmb-audit-hero__grid">
        <div class="gmb-audit-hero__copy">
          <span class="badge badge-accent gmb-audit-eyebrow">Audit gratuit Google Business Profile</span>
          <h1>Votre fiche Google attire-t-elle vraiment des vendeurs ?</h1>
          <p class="gmb-audit-lead">Collez le lien de votre fiche Google Business Profile et recevez un audit visibilité locale. Vous verrez d’abord un mini-score IA, puis nous préparons l’audit complet par email.</p>
          <ul class="gmb-audit-points">
            <li>Score de visibilité locale</li>
            <li>Analyse des avis, catégories, photos, posts et cohérence NAP</li>
            <li>Plan d’action prioritaire pour générer plus de mandats</li>
          </ul>
        </div>

        <div class="gmb-audit-card">
          <div class="gmb-audit-card__head">
            <p class="gmb-audit-card__eyebrow">Démarrer l’analyse</p>
            <h2>Analyser ma fiche Google gratuitement</h2>
          </div>

          <?php if (!empty($errors)): ?>
            <div class="gmb-audit-alert" role="alert">
              <?php foreach ($errors as $error): ?>
                <p><?= e($error) ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <?php if ($preview !== null && $audit === null): ?>
            <div class="gmb-audit-preview">
              <div class="gmb-audit-metrics">
                <article>
                  <span>Score estimé</span>
                  <strong><?= e($preview['global_score'] ?? 0) ?>/100</strong>
                </article>
                <article>
                  <span>Constats rapides</span>
                  <strong><?= e(count((array) ($preview['findings'] ?? []))) ?></strong>
                </article>
                <article>
                  <span>Opportunité</span>
                  <strong><?= e($preview['main_opportunity'] ?? '') ?></strong>
                </article>
              </div>
              <ul class="gmb-audit-list">
                <?php foreach ((array) ($preview['findings'] ?? []) as $finding): ?>
                  <li><?= e($finding) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <?php if ($preview === null && $audit === null): ?>
          <form method="POST" action="/audit-fiche-google/" class="gmb-audit-form">
            <input type="hidden" name="step" value="preview">
            <input type="text" name="website" class="gmb-audit-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
            <input type="hidden" name="utm_source" value="<?= e((string) ($_GET['utm_source'] ?? '')) ?>">
            <input type="hidden" name="utm_medium" value="<?= e((string) ($_GET['utm_medium'] ?? '')) ?>">
            <input type="hidden" name="utm_campaign" value="<?= e((string) ($_GET['utm_campaign'] ?? '')) ?>">
            <input type="hidden" name="referrer" value="<?= e((string) ($_SERVER['HTTP_REFERER'] ?? '')) ?>">
            <input type="hidden" name="session_token" value="<?= e((string) ($_GET['token'] ?? '')) ?>">
            <input type="hidden" name="audit_id" value="<?= e((string) ($_GET['audit_id'] ?? '')) ?>">
              <label>
                Lien Google Business Profile
                <input type="url" name="google_business_url" placeholder="https://www.google.com/maps/..." required value="<?= e($analysisInput['google_business_url'] ?? '') ?>">
              </label>
              <div class="gmb-audit-form__grid">
                <label>
                  Ville
                  <input type="text" name="city" placeholder="Ex. Bordeaux" required value="<?= e($analysisInput['city'] ?? '') ?>">
                </label>
                <label>
                  Réseau immobilier
                  <select name="network_name">
                    <option value="">Facultatif</option>
                    <?php foreach (gmb_audit_network_options() as $network): ?>
                      <option value="<?= e($network) ?>" <?= ($analysisInput['network_name'] ?? '') === $network ? 'selected' : '' ?>><?= e($network) ?></option>
                    <?php endforeach; ?>
                  </select>
                </label>
              </div>
              <button type="submit" class="btn btn-primary btn-lg gmb-audit-submit">Analyser ma fiche Google gratuitement</button>
          </form>
          <?php endif; ?>

          <p class="gmb-audit-legal">En soumettant ce formulaire, vous acceptez que votre demande soit traitée pour générer un audit et préparer un suivi commercial conforme au RGPD. Aucun scraping sauvage n’est utilisé.</p>
        </div>
      </div>
    </div>
  </section>

  <?php if ($preview !== null && $audit === null): ?>
  <section class="section">
    <div class="container">
      <div class="gmb-audit-results">
        <article class="content-block">
          <span class="section-tag">Mini-score IA</span>
          <h2 class="section-title" style="margin-bottom: 12px;">Voici votre premier aperçu</h2>
          <p class="text-lg"><strong>Score global estimé :</strong> <?= e($preview['global_score'] ?? 0) ?>/100</p>
          <p class="text-base"><strong>Opportunité principale :</strong> <?= e($preview['main_opportunity'] ?? '') ?></p>
          <p class="text-base"><strong>Résumé rapide :</strong> <?= e($preview['short_summary'] ?? '') ?></p>
        </article>

        <article class="content-block gmb-audit-result-card">
          <span class="section-tag">Recevoir l’audit complet par email</span>
          <h2 class="section-title" style="margin-bottom: 12px;">Laissez votre email professionnel</h2>
          <form method="POST" action="/audit-fiche-google/" class="gmb-audit-form gmb-audit-form--lead">
            <input type="hidden" name="step" value="capture">
            <input type="hidden" name="google_business_url" value="<?= e($analysisInput['google_business_url'] ?? '') ?>">
            <input type="hidden" name="city" value="<?= e($analysisInput['city'] ?? '') ?>">
            <input type="hidden" name="network_name" value="<?= e($analysisInput['network_name'] ?? '') ?>">
            <input type="hidden" name="utm_source" value="<?= e((string) ($_GET['utm_source'] ?? '')) ?>">
            <input type="hidden" name="utm_medium" value="<?= e((string) ($_GET['utm_medium'] ?? '')) ?>">
            <input type="hidden" name="utm_campaign" value="<?= e((string) ($_GET['utm_campaign'] ?? '')) ?>">
            <input type="hidden" name="referrer" value="<?= e((string) ($_SERVER['HTTP_REFERER'] ?? '')) ?>">
            <input type="hidden" name="form_ts" value="<?= e((string) time()) ?>">
            <input type="text" name="website" class="gmb-audit-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
            <div class="gmb-audit-form__grid">
              <label>
                Prénom
                <input type="text" name="first_name" required>
              </label>
              <label>
                Email professionnel
                <input type="email" name="email" required>
              </label>
            </div>
            <div class="gmb-audit-form__grid">
              <label>
                Téléphone
                <input type="tel" name="phone" placeholder="Facultatif">
              </label>
              <label>
                Réseau immobilier
                <input type="text" name="network_name" value="<?= e($analysisInput['network_name'] ?? '') ?>">
              </label>
            </div>
            <label class="gmb-audit-consent">
              <input type="checkbox" name="information_prospection" value="1" checked>
              <span>J’accepte d’être recontacté pour recevoir mon audit complet et les conseils associés.</span>
            </label>
            <button type="submit" class="btn btn-primary btn-lg gmb-audit-submit">Recevoir mon audit complet</button>
          </form>
        </article>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($audit !== null): ?>
  <section class="section">
    <div class="container">
      <div class="gmb-audit-results">
        <article class="content-block">
          <span class="section-tag">Audit complet</span>
          <h2 class="section-title">Votre rapport détaillé</h2>
          <div class="gmb-audit-metrics gmb-audit-metrics--full">
            <article><span>Global</span><strong><?= e($audit['global_score'] ?? 0) ?>/100</strong></article>
            <article><span>Visibilité locale</span><strong><?= e($audit['visibility_score'] ?? 0) ?>/100</strong></article>
            <article><span>Confiance</span><strong><?= e($audit['trust_score'] ?? 0) ?>/100</strong></article>
            <article><span>Avis</span><strong><?= e($audit['reviews_score'] ?? 0) ?>/100</strong></article>
            <article><span>Contenu</span><strong><?= e($audit['content_score'] ?? 0) ?>/100</strong></article>
            <article><span>Conversion</span><strong><?= e($audit['conversion_score'] ?? 0) ?>/100</strong></article>
          </div>
        </article>
        <article class="content-block gmb-audit-result-card">
          <span class="section-tag">Plan d’action</span>
          <h2 class="section-title">Ce qu’il faut faire en priorité</h2>
          <p class="text-base"><strong>Points forts :</strong> <?= e(implode(' · ', (array) ($audit['strengths'] ?? []))) ?></p>
          <p class="text-base"><strong>Points faibles :</strong> <?= e(implode(' · ', (array) ($audit['weaknesses'] ?? []))) ?></p>
          <p class="text-base"><strong>Opportunité principale :</strong> <?= e($audit['main_opportunity'] ?? '') ?></p>
          <p class="text-base"><strong>Résumé long :</strong><br><?= nl2br(e($audit['long_summary'] ?? '')) ?></p>
        </article>
      </div>
    </div>
  </section>
  <?php endif; ?>
</main>

<footer class="gmb-audit-footer">
  <div class="container gmb-audit-footer__inner">
    <p><strong>Écosystème Immo</strong> · Audit gratuit Google Business Profile</p>
    <p>Acquisition locale · Séquences email · Suivi CRM · RGPD</p>
  </div>
</footer>

</body>
</html>
