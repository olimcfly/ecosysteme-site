<?php
declare(strict_types=1);

$page_title = 'Diagnostic gratuit de visibilité locale pour conseiller immobilier';
$meta_description = 'Recevez un mini diagnostic gratuit de votre visibilité locale : site, Google, SEO, contenus, CRM et relances. Spécial conseillers immobiliers indépendants.';
$body_class = 'page-rdv page-diagnostic-visibilite';

$errors = [];

function diagnostic_visibilite_sanitize(string $value): string
{
    $value = trim($value);
    $value = preg_replace('/\s+/', ' ', $value) ?? $value;

    return trim(strip_tags($value));
}

function diagnostic_visibilite_build_notes(array $data): string
{
    $lines = [
        'Source: ' . ($data['source'] ?? ''),
        'Campaign: ' . ($data['campaign'] ?? ''),
        'Offer: ' . ($data['offer'] ?? ''),
        'Landing page: ' . ($data['landing_page'] ?? ''),
        'UTM source: ' . ($data['utm_source'] ?? ''),
        'UTM medium: ' . ($data['utm_medium'] ?? ''),
        'UTM campaign: ' . ($data['utm_campaign'] ?? ''),
        'UTM content: ' . ($data['utm_content'] ?? ''),
    ];

    if (!empty($data['message'])) {
        $lines[] = 'Message: ' . $data['message'];
    }

    return implode("\n", array_filter($lines, static fn($line) => trim((string) $line) !== ''));
}

function diagnostic_visibilite_split_location(string $value): array
{
    $value = diagnostic_visibilite_sanitize($value);
    $city = $value;
    $department = '';

    if ($value !== '' && str_contains($value, '/')) {
        [$left, $right] = array_map('trim', explode('/', $value, 2));
        $city = $left;
        $department = $right;
    } elseif (preg_match('/\b([0-9]{2,3}[A-Z]?)\b/u', $value, $matches)) {
        $department = $matches[1];
    }

    return [$city, $department];
}

function diagnostic_visibilite_send_to_admin_crm(array $payload): array
{
    $ch = curl_init('https://admin.ecosystemeimmo.fr/api/public/lead-capture.php');
    if ($ch === false) {
        return ['ok' => false, 'error' => 'Connexion CRM indisponible.'];
    }

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($payload),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_TIMEOUT => 12,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'Accept: application/json',
        ],
    ]);

    $raw = curl_exec($ch);
    $error = curl_error($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    if ($raw === false || $error !== '') {
        return ['ok' => false, 'error' => 'Connexion CRM indisponible.'];
    }

    $data = json_decode((string) $raw, true);
    if (!is_array($data) || empty($data['success']) || $code < 200 || $code >= 300) {
        return ['ok' => false, 'error' => 'CRM indisponible pour le moment.'];
    }

    return ['ok' => true, 'id' => $data['id'] ?? null];
}

    $form = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone' => '',
        'network' => 'ImmoForfait',
        'city_or_department' => '',
        'message' => '',
        'form_ts' => (string) time(),
    ];

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (trim((string) ($_POST['website'] ?? '')) !== '') {
        $errors[] = 'Soumission non autorisée.';
    }

    $form['first_name'] = diagnostic_visibilite_sanitize((string) ($_POST['first_name'] ?? ''));
    $form['last_name'] = diagnostic_visibilite_sanitize((string) ($_POST['last_name'] ?? ''));
    $form['email'] = diagnostic_visibilite_sanitize((string) ($_POST['email'] ?? ''));
    $form['phone'] = diagnostic_visibilite_sanitize((string) ($_POST['phone'] ?? ''));
    $form['network'] = diagnostic_visibilite_sanitize((string) ($_POST['network'] ?? 'ImmoForfait')) ?: 'ImmoForfait';
    $form['city_or_department'] = diagnostic_visibilite_sanitize((string) ($_POST['city_or_department'] ?? ''));
    $form['message'] = diagnostic_visibilite_sanitize((string) ($_POST['message'] ?? ''));
    $form['form_ts'] = diagnostic_visibilite_sanitize((string) ($_POST['form_ts'] ?? ''));

    $consent = isset($_POST['consent']);

    if ($form['first_name'] === '') {
        $errors[] = 'Le prénom est obligatoire.';
    }
    if ($form['last_name'] === '') {
        $errors[] = 'Le nom est obligatoire.';
    }
    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'L’adresse email est invalide.';
    }
    $phoneDigits = preg_replace('/\D+/', '', $form['phone']) ?? '';
    if (strlen($phoneDigits) < 10) {
        $errors[] = 'Le téléphone est invalide.';
    }
    if ($form['city_or_department'] === '') {
        $errors[] = 'La ville ou le département est obligatoire.';
    }
    if (!$consent) {
        $errors[] = 'Le consentement est obligatoire.';
    }

    if ($errors === []) {
        [$city, $department] = diagnostic_visibilite_split_location($form['city_or_department']);

        $payload = [
            'first_name' => $form['first_name'],
            'last_name' => $form['last_name'],
            'email' => $form['email'],
            'phone' => $form['phone'],
            'network' => $form['network'],
            'city' => $city,
            'department' => $department,
            'status' => 'new',
            'source' => 'diagnostic-visibilite-locale',
            'source_url' => 'https://ecosystemeimmo.fr/diagnostic-visibilite-locale',
            'notes' => diagnostic_visibilite_build_notes([
                'source' => 'diagnostic-visibilite-locale',
                'campaign' => 'ImmoForfait – Audit visibilité locale 10 min',
                'offer' => 'Diagnostic gratuit visibilité locale',
                'landing_page' => 'diagnostic-visibilite-locale',
                'utm_source' => (string) ($_POST['utm_source'] ?? ''),
                'utm_medium' => (string) ($_POST['utm_medium'] ?? ''),
                'utm_campaign' => (string) ($_POST['utm_campaign'] ?? ''),
                'utm_content' => (string) ($_POST['utm_content'] ?? ''),
                'message' => $form['message'],
            ]),
            'message' => $form['message'],
            'consent_rgpd' => 1,
            'score' => 50,
        ];

        $result = diagnostic_visibilite_send_to_admin_crm($payload);
        if ($result['ok']) {
            $thankYouUrl = '/diagnostic-visibilite-locale/merci';
            if (!empty($result['id'])) {
                $thankYouUrl .= '?lead_id=' . rawurlencode((string) $result['id']);
            }
            header('Location: ' . $thankYouUrl, true, 302);
            exit;
        } else {
            $errors[] = 'Votre demande ne peut pas être envoyée pour le moment. Réessayez dans quelques minutes.';
        }
    }
}

include 'includes/nav.php';
?>

<main class="page-diagnostic">
  <section class="page-header page-header--rdv page-header--diagnostic">
    <div class="container">
      <div class="breadcrumb">
        <a href="/">Accueil</a>
        <span class="breadcrumb-sep">›</span>
        <span>Diagnostic visibilité locale</span>
      </div>
      <h1 class="page-header-title">Votre visibilité locale travaille-t-elle vraiment pour vous ?</h1>
      <p class="page-header-subtitle page-header-subtitle--wide">Recevez un mini diagnostic gratuit pour comprendre si votre présence en ligne vous aide réellement à attirer des vendeurs qualifiés sur votre secteur.</p>
      <div class="rdv-hero-actions">
        <a href="#formulaire" class="btn btn-primary btn-lg">Demander mon diagnostic gratuit</a>
        <a href="/rdv" class="btn btn-secondary btn-lg">Prendre rendez-vous</a>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="diagnostic-hero-copy content-block">
        <p class="text-lg"><strong>Vous êtes conseiller immobilier indépendant</strong> et vous avez déjà une présence en ligne : fiche réseau, annonces, parfois une fiche Google, parfois un site.</p>
        <p class="text-lg">Mais une question reste essentielle : <strong>quand un propriétaire cherche un conseiller sur votre secteur, tombe-t-il facilement sur vous ?</strong></p>
      </div>
    </div>
  </section>

  <section class="section bg-light">
    <div class="container">
      <div class="section-header center">
        <span class="section-tag">Ce que le diagnostic analyse</span>
        <h2 class="section-title">Un regard simple, concret et priorisé</h2>
      </div>
      <div class="grid grid-2 diagnostic-grid">
        <article class="content-block diagnostic-card"><h3>1. Votre visibilité Google</h3><p>Analyse de votre présence lorsqu’un propriétaire cherche un conseiller sur votre ville ou département.</p></article>
        <article class="content-block diagnostic-card"><h3>2. Votre positionnement local</h3><p>Vérification de votre message, de votre différenciation et de votre clarté.</p></article>
        <article class="content-block diagnostic-card"><h3>3. Vos points de contact</h3><p>Site, fiche, formulaire, téléphone, email, prise de rendez-vous.</p></article>
        <article class="content-block diagnostic-card"><h3>4. Vos contenus locaux</h3><p>Articles, pages secteur, publications, cohérence avec votre zone.</p></article>
        <article class="content-block diagnostic-card diagnostic-card--wide"><h3>5. Vos relances prospects</h3><p>CRM, emails, suivi, automatisations simples.</p></article>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="grid grid-2 diagnostic-split">
        <article class="content-block">
          <span class="section-tag">Ce que ce n’est pas</span>
          <p>Ce diagnostic n’est pas une promesse miracle.</p>
          <p>Ce n’est pas une proposition pour changer de réseau.</p>
          <p>Ce n’est pas un audit technique compliqué.</p>
          <p>C’est un regard simple et concret sur votre visibilité locale actuelle, avec 2 ou 3 pistes d’amélioration prioritaires.</p>
        </article>
        <article class="content-block">
          <span class="section-tag">Pour qui</span>
          <ul class="check-list">
            <li class="check-item"><span class="check-icon">✓</span><span>Conseillers immobiliers indépendants</span></li>
            <li class="check-item"><span class="check-icon">✓</span><span>Mandataires</span></li>
            <li class="check-item"><span class="check-icon">✓</span><span>Agents commerciaux</span></li>
            <li class="check-item"><span class="check-icon">✓</span><span>Professionnels qui veulent mieux capter les vendeurs locaux</span></li>
            <li class="check-item"><span class="check-icon">✓</span><span>Conseillers qui veulent moins dépendre des portails et du hasard</span></li>
          </ul>
        </article>
      </div>
    </div>
  </section>

  <section class="section bg-light" id="formulaire">
    <div class="container">
      <div class="contact-layout rdv-form-layout">
        <div class="rdv-form-intro-col">
          <span class="section-tag">Demande gratuite</span>
          <h2 class="section-title rdv-form-intro-title">Demander mon diagnostic gratuit</h2>
          <p class="rdv-form-intro-text">Votre demande est traitée par Olivier Colas / Écosystème Immo dans le cadre du diagnostic gratuit.</p>
          <p class="rdv-form-intro-note">Vos informations ne sont pas revendues. Vous pouvez demander leur suppression à tout moment.</p>
        </div>

        <div class="contact-form-wrapper rdv-form-panel">
          <h3 class="heading-md rdv-form-h3">Formulaire de diagnostic</h3>
          <p class="rdv-form-hint">Les champs marqués comme obligatoires doivent être renseignés.</p>

          <?php if (!empty($errors)): ?>
            <div class="rdv-error-alert" role="alert">
              <?php foreach ($errors as $error): ?>
                <div class="rdv-error-line">⚠ <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form method="post" action="/diagnostic-visibilite-locale" class="form-stack diagnostic-form">
            <div style="display:none;">
              <label>Company website check <input type="text" name="company_website_check" tabindex="-1" autocomplete="off"></label>
            </div>

            <div class="grid grid-2 diagnostic-form-grid">
              <label class="diagnostic-field">
                <span>Prénom <span class="diagnostic-required" aria-hidden="true">*</span></span>
                <input type="text" name="first_name" value="<?= htmlspecialchars($form['first_name'], ENT_QUOTES, 'UTF-8') ?>" required>
              </label>
              <label class="diagnostic-field">
                <span>Nom <span class="diagnostic-required" aria-hidden="true">*</span></span>
                <input type="text" name="last_name" value="<?= htmlspecialchars($form['last_name'], ENT_QUOTES, 'UTF-8') ?>" required>
              </label>
            </div>

            <div class="grid grid-2 diagnostic-form-grid">
              <label class="diagnostic-field">
                <span>Email <span class="diagnostic-required" aria-hidden="true">*</span></span>
                <input type="email" name="email" value="<?= htmlspecialchars($form['email'], ENT_QUOTES, 'UTF-8') ?>" required>
              </label>
              <label class="diagnostic-field">
                <span>Téléphone <span class="diagnostic-required" aria-hidden="true">*</span></span>
                <input type="tel" name="phone" value="<?= htmlspecialchars($form['phone'], ENT_QUOTES, 'UTF-8') ?>" required>
              </label>
            </div>

            <div class="grid grid-2 diagnostic-form-grid">
              <label class="diagnostic-field">
                <span>Réseau <span class="diagnostic-required" aria-hidden="true">*</span></span>
                <select name="network" required>
                  <option value="ImmoForfait"<?= $form['network'] === 'ImmoForfait' ? ' selected' : '' ?>>ImmoForfait</option>
                  <option value="Autre"<?= $form['network'] === 'Autre' ? ' selected' : '' ?>>Autre</option>
                </select>
              </label>
              <label class="diagnostic-field">
                <span>Ville ou département <span class="diagnostic-required" aria-hidden="true">*</span></span>
                <input type="text" name="city_or_department" value="<?= htmlspecialchars($form['city_or_department'], ENT_QUOTES, 'UTF-8') ?>" placeholder="Bordeaux / 33" required>
              </label>
            </div>

            <label class="diagnostic-field diagnostic-field--full">
              <span>Message <span class="diagnostic-optional">(optionnel)</span></span>
              <textarea name="message" rows="5" placeholder="Décrivez votre secteur ou votre besoin"><?= htmlspecialchars($form['message'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </label>

            <input type="hidden" name="source" value="diagnostic-visibilite-locale">
            <input type="hidden" name="campaign" value="Diagnostic visibilité locale">
            <input type="hidden" name="offer" value="Diagnostic gratuit visibilité locale">
            <input type="hidden" name="landing_page" value="diagnostic-visibilite-locale">
            <input type="hidden" name="form_ts" value="<?= htmlspecialchars($form['form_ts'], ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="utm_source" value="<?= htmlspecialchars((string) ($_GET['utm_source'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="utm_medium" value="<?= htmlspecialchars((string) ($_GET['utm_medium'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="utm_campaign" value="<?= htmlspecialchars((string) ($_GET['utm_campaign'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="utm_content" value="<?= htmlspecialchars((string) ($_GET['utm_content'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">

            <label class="diagnostic-consent">
              <input type="checkbox" name="consent" value="1" required>
              <span>J’accepte d’être recontacté par Olivier Colas / Écosystème Immo dans le cadre de ma demande de diagnostic gratuit.</span>
            </label>

            <p class="text-sm text-muted">Vos informations ne sont pas revendues. Vous pouvez demander leur suppression à tout moment.</p>

            <button type="submit" class="btn btn-primary btn-lg diagnostic-submit">Demander mon diagnostic gratuit</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="content-block">
        <h2 class="section-title" style="margin-bottom: 12px;">Ce que vous recevez</h2>
        <p>Un premier regard simple sur votre présence locale, avec 2 ou 3 axes prioritaires pour la suite.</p>
      </div>
    </div>
  </section>
</main>

<style>
.page-diagnostic .page-header--diagnostic {
  background: linear-gradient(135deg, rgba(13,34,64,.98), rgba(30,77,140,.92));
}
.page-diagnostic .diagnostic-hero-copy,
.page-diagnostic .diagnostic-card,
.page-diagnostic .diagnostic-split .content-block {
  height: 100%;
}
.page-diagnostic .diagnostic-grid {
  align-items: stretch;
}
.page-diagnostic .diagnostic-card--wide {
  grid-column: 1 / -1;
}
.page-diagnostic .rdv-form-panel {
  border-radius: 24px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
  overflow: hidden;
  position: relative;
}
.page-diagnostic .rdv-form-panel::before {
  content: '';
  position: absolute;
  inset: 0 0 auto 0;
  height: 5px;
  background: linear-gradient(90deg, #f59e0b, #fb923c, #f97316);
}
.page-diagnostic .rdv-form-panel > * {
  position: relative;
  z-index: 1;
}
.page-diagnostic .diagnostic-form {
  margin-top: 12px;
  display: grid;
  gap: 18px;
}
.page-diagnostic .diagnostic-form-grid {
  gap: 18px;
}
.page-diagnostic .diagnostic-field {
  display: flex;
  flex-direction: column;
  gap: 6px;
  font-weight: 600;
  color: #0f172a;
}
.page-diagnostic .diagnostic-field > span {
  font-size: 14px;
  line-height: 1.35;
}
.page-diagnostic .diagnostic-required {
  color: #ef4444;
}
.page-diagnostic .diagnostic-optional {
  color: #64748b;
  font-weight: 500;
  font-size: 13px;
}
.page-diagnostic .diagnostic-field input,
.page-diagnostic .diagnostic-field select,
.page-diagnostic .diagnostic-field textarea {
  width: 100%;
  min-height: 48px;
  padding: 12px 14px;
  border: 1px solid #d1d5db;
  border-radius: 12px;
  background: #fff;
  font-size: 16px;
  color: #0f172a;
  transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease, background-color .2s ease;
  box-sizing: border-box;
}
.page-diagnostic .diagnostic-field textarea {
  min-height: 130px;
  resize: vertical;
  line-height: 1.6;
}
.page-diagnostic .diagnostic-field input::placeholder,
.page-diagnostic .diagnostic-field textarea::placeholder {
  color: #94a3b8;
}
.page-diagnostic .diagnostic-field input:focus,
.page-diagnostic .diagnostic-field select:focus,
.page-diagnostic .diagnostic-field textarea:focus {
  outline: none;
  border-color: #1d4ed8;
  box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.12);
}
.page-diagnostic .diagnostic-field--full {
  gap: 8px;
}
.page-diagnostic .diagnostic-consent {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 14px 16px;
  border-radius: 12px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  color: #0f172a;
  font-weight: 600;
  line-height: 1.5;
}
.page-diagnostic .diagnostic-consent input {
  width: 18px;
  height: 18px;
  margin-top: 2px;
  flex: 0 0 auto;
  accent-color: #1d4ed8;
}
.page-diagnostic .diagnostic-submit {
  width: 100%;
  min-height: 54px;
  border-radius: 16px;
  font-size: 16px;
  font-weight: 700;
  box-shadow: 0 12px 24px rgba(249, 115, 22, 0.2);
  transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
}
.page-diagnostic .diagnostic-submit:hover {
  transform: translateY(-1px);
  box-shadow: 0 16px 30px rgba(249, 115, 22, 0.26);
}
.page-diagnostic .diagnostic-submit:active {
  transform: translateY(0);
}
.page-diagnostic .rdv-error-alert,
.page-diagnostic .rdv-success {
  border-radius: 12px;
  padding: 14px 16px;
}
.page-diagnostic .rdv-error-alert {
  background: #fef2f2;
  border: 1px solid #fecaca;
  color: #991b1b;
}
.page-diagnostic .rdv-error-line + .rdv-error-line {
  margin-top: 8px;
}
.page-diagnostic .rdv-success {
  background: #f0fdf4;
  border: 1px solid #bbf7d0;
}
@media (max-width: 900px) {
  .page-diagnostic .diagnostic-card--wide {
    grid-column: auto;
  }
}
@media (max-width: 720px) {
  .page-diagnostic .rdv-hero-actions {
    display: grid;
    gap: 12px;
  }
  .page-diagnostic .rdv-hero-actions .btn {
    width: 100%;
  }
  .page-diagnostic .rdv-form-panel {
    border-radius: 20px;
  }
  .page-diagnostic .contact-form-wrapper {
    padding: 0;
  }
  .page-diagnostic .diagnostic-form {
    gap: 16px;
  }
  .page-diagnostic .diagnostic-form-grid {
    grid-template-columns: 1fr;
  }
  .page-diagnostic .diagnostic-field input,
  .page-diagnostic .diagnostic-field select,
  .page-diagnostic .diagnostic-field textarea {
    font-size: 16px;
  }
  .page-diagnostic .diagnostic-consent {
    padding: 12px 14px;
  }
  .page-diagnostic .diagnostic-submit {
    min-height: 52px;
  }
  .page-diagnostic .grid.grid-2 {
    grid-template-columns: 1fr;
  }
}
</style>
