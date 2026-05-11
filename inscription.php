<?php
declare(strict_types=1);

/**
 * Inscription essai 30 j. — provisionnement `data/tenants/{slug}/`, pas de Stripe.
 * Désactivable sans retirer le code : ENABLE_SAAS_SIGNUP=true dans .env (voir docs).
 */
$root = __DIR__;
$envFile = $root . '/.env';
if (is_readable($envFile)) {
    require_once $root . '/includes/env_loader.php';
    ecosysteme_immo_load_env($envFile);
}

function saas_signup_is_enabled(): bool
{
    $v = getenv('ENABLE_SAAS_SIGNUP');

    return is_string($v) && strtolower(trim($v)) === 'true';
}

$crmCfg = require $root . '/includes/mini_crm_config.php';
$sn     = (string) ($crmCfg['session_name'] ?? 'mini_crm_sid');
if (session_status() === PHP_SESSION_NONE) {
    session_name($sn);
    session_start();
}

if (!saas_signup_is_enabled()) {
    $page_title       = 'Le SaaS arrive bientôt — Écosystème Immo';
    $meta_description = 'L’inscription en ligne ouvrira prochainement. Contactez-nous pour un diagnostic dédié.';
    $signup_page_minimal_nav = true;
    include $root . '/includes/header.php';
    ?>
<main>
<section class="page-header">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="breadcrumb-sep">›</span>
      <span>Inscription</span>
    </div>
    <h1 class="page-header-title" style="max-width: 40rem">Le SaaS arrive bientôt</h1>
    <p class="page-header-subtitle" style="max-width: 40rem; margin-top: 12px">
      L’inscription en ligne sur la plateforme mutualisée n’est pas encore ouverte. Le mode SaaS est en finalisation ; il proposera notamment <strong>30 jours gratuits</strong> et un <strong>tarif fondateur à 47&nbsp;€/mois</strong>.
    </p>
  </div>
</section>
<section class="section">
  <div class="container" style="max-width: 640px; margin: 0 auto">
    <div class="card" style="padding: 28px; border: 1px solid var(--neutral-200); border-radius: 12px; background: #fff">
      <p style="line-height: 1.65; color: var(--neutral-700); margin: 0 0 1rem">
        Pour être <strong>prévenu au lancement</strong> ou pour un <strong>accompagnement dédié</strong>, prenez rendez-vous.
      </p>
      <p style="margin: 0 0 1rem; display: flex; flex-wrap: wrap; gap: 10px">
        <a href="/rdv?sujet=lancement-saas" class="btn btn-primary" style="display: inline-block; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600">Être prévenu au lancement</a>
        <a href="/offres.php" class="btn btn-secondary" style="display: inline-block; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600">Voir les offres</a>
      </p>
      <p style="font-size: 0.875rem; color: var(--neutral-600); margin: 0">
        Déjà un compte ? <a href="connexion.php">Connexion</a>
      </p>
    </div>
  </div>
</section>
</main>
    <?php
    include $root . '/includes/footer.php';
    exit;
}

require_once $root . '/includes/saas_tenant_provisioning.php';
require_once $root . '/includes/saas_auth_service.php';
require_once $root . '/includes/security_rate_limit.php';

$inscription_allowed_plans = ['essential', 'pro', 'expert'];
$inscription_plan_query    = strtolower(trim((string) ($_GET['plan'] ?? '')));
$inscription_plan_default  = in_array($inscription_plan_query, $inscription_allowed_plans, true)
    ? $inscription_plan_query
    : 'pro';
$inscription_normalize_plan = static function (string $raw) use ($inscription_allowed_plans, $inscription_plan_default): string {
    $c = strtolower(trim($raw));
    return ($c !== '' && in_array($c, $inscription_allowed_plans, true)) ? $c : $inscription_plan_default;
};

$page_title = 'Inscription — essai 30 jours';
$meta_description = 'Créez votre espace Écosystème Immo : 30 jours gratuits, sans setup, un compte par conseiller.';
$signup_error  = null;
$merci        = isset($_GET['merci']) && (string) $_GET['merci'] === '1';
$prisEnCompte = isset($_GET['pris_en_compte']) && (string) $_GET['pris_en_compte'] === '1';
$devMagicLink = '';
if ($merci && isset($_SESSION['saas_inscription_dev_magic_url'])) {
    $devMagicLink = (string) $_SESSION['saas_inscription_dev_magic_url'];
    unset($_SESSION['saas_inscription_dev_magic_url']);
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (security_honeypot_is_filled()) {
        security_log_event('honeypot', ['scope' => 'inscription']);
        header('Location: /inscription.php?pris_en_compte=1', true, 303);
        exit;
    }
    $ip = security_client_ip();
    if (!security_rate_limit_check('inscription_ip', $ip, 5, 3600)) {
        security_log_event('rate_limit', ['scope' => 'inscription_ip']);
        header('Location: /inscription.php?pris_en_compte=1', true, 303);
        exit;
    }
    $emProbe = saas_auth_normalize_email((string) ($_POST['email'] ?? ''));
    if ($emProbe !== '' && filter_var($emProbe, FILTER_VALIDATE_EMAIL)) {
        if (!security_rate_limit_check('inscription_email', $emProbe, 3, 86400)) {
            security_log_event('rate_limit', ['scope' => 'inscription_email']);
            header('Location: /inscription.php?pris_en_compte=1', true, 303);
            exit;
        }
    }
    security_rate_limit_hit('inscription_ip', $ip);
    if ($emProbe !== '' && filter_var($emProbe, FILTER_VALIDATE_EMAIL)) {
        security_rate_limit_hit('inscription_email', $emProbe);
    }

    $payload = [
        'first_name'     => (string) ($_POST['first_name'] ?? ''),
        'last_name'      => (string) ($_POST['last_name'] ?? ''),
        'email'          => (string) ($_POST['email'] ?? ''),
        'phone'          => (string) ($_POST['phone'] ?? ''),
        'business_name'  => (string) ($_POST['business_name'] ?? ''),
        'city'           => (string) ($_POST['city'] ?? ''),
        'custom_domain'  => (string) ($_POST['custom_domain'] ?? ''),
        'plan_code'      => $inscription_normalize_plan((string) ($_POST['plan_code'] ?? '')),
        'cgu'            => !empty($_POST['cgu']),
    ];
    $r = saas_register_trial_tenant($payload);
    if ($r['ok'] ?? false) {
        $slug = (string) $r['tenant_slug'];
        $u    = saas_auth_create_user_for_tenant($slug, [
            'email'      => (string) $payload['email'],
            'first_name' => (string) $payload['first_name'],
            'last_name'  => (string) $payload['last_name'],
            'role'       => 'owner',
        ]);
        if (!($u['ok'] ?? false)) {
            $signup_error = (string) ($u['error'] ?? 'Compte utilisateur non créé.');
        } else {
            $m = saas_auth_create_magic_link($slug, (string) $payload['email'], 'signup');
            if ($m['ok'] ?? false && isset($m['token'])) {
                $host = (string) ($_SERVER['HTTP_HOST'] ?? 'ecosystemeimmo.fr');
                $isHt = !empty($_SERVER['HTTPS']) && (string) $_SERVER['HTTPS'] !== 'off';
                $url  = ($isHt ? 'https' : 'http') . '://' . $host . '/auth/magic.php?token=' . rawurlencode((string) $m['token']);
                $ctx  = saas_auth_magic_link_email_context($slug, isset($u['user']) && is_array($u['user']) ? $u['user'] : null);
                saas_auth_send_magic_link_email(saas_auth_normalize_email((string) $payload['email']), $url, $ctx);
                if (function_exists('saas_is_production_env') && !saas_is_production_env()) {
                    $_SESSION['saas_inscription_dev_magic_url'] = $url;
                }
            }
            header('Location: /inscription.php?merci=1', true, 303);
            exit;
        }
    } else {
        $signup_error = (string) ($r['error'] ?? 'Inscription impossible.');
    }
}

$sel_plan_form = $inscription_normalize_plan((string) ($_POST['plan_code'] ?? ''));

$signup_page_minimal_nav = true;
include 'includes/header.php';
?>

<main>
<section class="page-header">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="breadcrumb-sep">›</span>
      <span>Essai gratuit</span>
    </div>
    <h1 class="page-header-title" style="max-width: 40rem">
      Essayez <span style="color: var(--accent-400)">Écosystème Immo</span> gratuitement pendant 30 jours
    </h1>
    <p class="page-header-subtitle" style="max-width: 40rem; margin-top: 12px">
      Aucun setup. Vous choisissez ensuite votre abonnement. Un seul hébergement, un compte par conseiller.
    </p>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width: 640px; margin: 0 auto">
    <?php if ($prisEnCompte): ?>
      <div class="card" style="padding: 28px; border: 1px solid var(--neutral-200); border-radius: 12px; background: #fff; margin-bottom: 1.5rem">
        <p style="line-height: 1.6; color: var(--neutral-700); margin: 0">Merci, votre demande est bien prise en compte. Si tout est correct, vous recevrez un e-mail.</p>
        <p style="margin-top: 1rem"><a href="inscription.php">Faire une nouvelle demande</a></p>
      </div>
    <?php endif; ?>

    <?php if ($merci): ?>
      <div class="card" style="padding: 28px; border: 1px solid var(--neutral-200); border-radius: 12px; background: #fff; margin-bottom: 1.5rem">
        <h2 class="page-header-title" style="font-size: 1.35rem; margin-bottom: 12px">Vérifiez votre e-mail</h2>
        <p style="line-height: 1.6; color: var(--neutral-600)">Votre espace d’essai a été préparé. <strong>Cliquez sur le lien</strong> que nous venons d’envoyer (vérifiez les courriers indésirables) pour <strong>activer l’accès</strong> à votre compte. Le lien est valable environ 24 h et est à usage unique.</p>
        <p style="margin-top: 1rem"><a href="connexion.php" class="btn btn-primary" style="display: inline-block; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600">Page de connexion</a></p>
        <?php if ($devMagicLink !== '' && function_exists('saas_is_production_env') && !saas_is_production_env()): ?>
          <p style="margin-top: 1.25rem; font-size: 0.85rem; color: #92400e; background: #fffbeb; padding: 12px; border-radius: 8px; word-break: break-all"><strong>Mode développement :</strong> e-mail non branché. Lien (ne pas en production) :<br><a href="<?= htmlspecialchars($devMagicLink, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($devMagicLink, ENT_QUOTES, 'UTF-8') ?></a></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($signup_error): ?>
      <p class="crm-bad" style="margin: 0 0 1.25rem; padding: 12px 16px; background: #fef2f2; border-radius: 8px; color: #991b1b">
        <?= htmlspecialchars($signup_error, ENT_QUOTES, 'UTF-8') ?>
      </p>
    <?php endif; ?>

    <?php if (!$merci && !$prisEnCompte): ?>
    <form method="post" action="inscription.php" class="card" style="padding: 28px; border: 1px solid var(--neutral-200); border-radius: 12px; background: #fff">
      <p style="font-size: 0.9rem; color: var(--neutral-600); margin: 0 0 1.25rem">Les champs marqués * sont obligatoires.</p>

      <div style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden" aria-hidden="true">
        <label for="website_hp">Ne pas remplir ce champ</label>
        <input type="text" name="website" id="website_hp" value="" tabindex="-1" autocomplete="off" />
        <label for="company_url_hp">Ne pas remplir</label>
        <input type="text" name="company_url" id="company_url_hp" value="" tabindex="-1" autocomplete="off" />
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px">
        <div>
          <label for="first_name" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 4px">Prénom *</label>
          <input name="first_name" id="first_name" type="text" required autocomplete="given-name" class="form-input" style="width: 100%; padding: 10px 12px; border: 1px solid var(--neutral-300); border-radius: 8px" value="<?= isset($_POST['first_name']) ? htmlspecialchars((string) $_POST['first_name'], ENT_QUOTES, 'UTF-8') : '' ?>" />
        </div>
        <div>
          <label for="last_name" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 4px">Nom *</label>
          <input name="last_name" id="last_name" type="text" required autocomplete="family-name" class="form-input" style="width: 100%; padding: 10px 12px; border: 1px solid var(--neutral-300); border-radius: 8px" value="<?= isset($_POST['last_name']) ? htmlspecialchars((string) $_POST['last_name'], ENT_QUOTES, 'UTF-8') : '' ?>" />
        </div>
      </div>

      <div style="margin-bottom: 12px">
        <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 4px">E-mail *</label>
        <input name="email" id="email" type="email" required autocomplete="email" class="form-input" style="width: 100%; padding: 10px 12px; border: 1px solid var(--neutral-300); border-radius: 8px" value="<?= isset($_POST['email']) ? htmlspecialchars((string) $_POST['email'], ENT_QUOTES, 'UTF-8') : '' ?>" />
      </div>

      <div style="margin-bottom: 12px">
        <label for="phone" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 4px">Téléphone</label>
        <input name="phone" id="phone" type="text" inputmode="tel" autocomplete="tel" class="form-input" style="width: 100%; padding: 10px 12px; border: 1px solid var(--neutral-300); border-radius: 8px" value="<?= isset($_POST['phone']) ? htmlspecialchars((string) $_POST['phone'], ENT_QUOTES, 'UTF-8') : '' ?>" />
      </div>

      <div style="margin-bottom: 12px">
        <label for="business_name" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 4px">Nom commercial / activité *</label>
        <input name="business_name" id="business_name" type="text" required class="form-input" style="width: 100%; padding: 10px 12px; border: 1px solid var(--neutral-300); border-radius: 8px" value="<?= isset($_POST['business_name']) ? htmlspecialchars((string) $_POST['business_name'], ENT_QUOTES, 'UTF-8') : '' ?>" />
      </div>

      <div style="margin-bottom: 12px">
        <label for="city" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 4px">Ville principale *</label>
        <input name="city" id="city" type="text" required autocomplete="address-level2" class="form-input" style="width: 100%; padding: 10px 12px; border: 1px solid var(--neutral-300); border-radius: 8px" value="<?= isset($_POST['city']) ? htmlspecialchars((string) $_POST['city'], ENT_QUOTES, 'UTF-8') : '' ?>" />
      </div>

      <div style="margin-bottom: 12px">
        <label for="custom_domain" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 4px">Domaine actuel du site (optionnel)</label>
        <input name="custom_domain" id="custom_domain" type="text" class="form-input" style="width: 100%; padding: 10px 12px; border: 1px solid var(--neutral-300); border-radius: 8px" placeholder="exemple.fr" value="<?= isset($_POST['custom_domain']) ? htmlspecialchars((string) $_POST['custom_domain'], ENT_QUOTES, 'UTF-8') : '' ?>" />
      </div>

      <div style="margin-bottom: 12px">
        <label for="plan_code" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 4px">Formule (essai, puis abonnement)</label>
        <select name="plan_code" id="plan_code" class="form-input" style="width: 100%; padding: 10px 12px; border: 1px solid var(--neutral-300); border-radius: 8px">
          <?php
            $plOpts = [
                'essential' => 'Essentiel — 47 €/mois (indic.)',
                'pro'       => 'Pro — 97 €/mois (indic.)',
                'expert'    => 'Expert — 197 €/mois (indic.)',
            ];
            foreach ($plOpts as $k => $label) {
                $s = $sel_plan_form === $k ? ' selected' : '';
                echo '<option value="' . htmlspecialchars($k, ENT_QUOTES, 'UTF-8') . '"' . $s . '>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</option>\n";
            }
          ?>
        </select>
      </div>

      <label style="display: flex; gap: 10px; align-items: flex-start; margin: 1rem 0; font-size: 0.9rem; line-height: 1.4">
        <input type="checkbox" name="cgu" value="1" required style="margin-top: 3px" <?= !empty($_POST['cgu']) ? ' checked' : '' ?> />
        <span>J’accepte les <a href="cgv.php" target="_blank" rel="noopener">conditions générales</a> et l’<strong>essai gratuit de 30 jours</strong> (sans prélèvement à ce stade). *</span>
      </label>

      <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px; padding: 12px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer">
        Créer mon espace d’essai
      </button>
    </form>
    <?php endif; ?>
  </div>
</section>
</main>

<?php include 'includes/footer.php'; ?>
