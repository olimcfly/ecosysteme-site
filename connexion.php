<?php
declare(strict_types=1);

/**
 * Connexion par e-mail (lien magique) — ne révèle pas si l’adresse est inconnue.
 */
$root = dirname(__FILE__);
$crm  = require $root . '/includes/mini_crm_config.php';
$sn   = (string) ($crm['session_name'] ?? 'mini_crm_sid');
if (session_status() === PHP_SESSION_NONE) {
    session_name($sn);
    session_start();
}
require_once $root . '/includes/saas_auth_service.php';
require_once $root . '/includes/security_rate_limit.php';

if (function_exists('saas_auth_is_session_valid') && saas_auth_is_session_valid()) {
    header('Location: /mini-crm/compte.php', true, 302);
    exit;
}

$posted = false;
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $posted = true;
    if (security_honeypot_is_filled()) {
        security_log_event('honeypot', ['scope' => 'connexion']);
        header('Location: /connexion.php?envoye=1', true, 303);
        exit;
    }
    $ip = security_client_ip();
    if (!security_rate_limit_check('connexion_ip', $ip, 10, 3600)) {
        security_log_event('rate_limit', ['scope' => 'connexion_ip']);
        header('Location: /connexion.php?envoye=1', true, 303);
        exit;
    }
    $em = (string) ($_POST['email'] ?? '');
    $norm = saas_auth_normalize_email($em);
    if (filter_var($norm, FILTER_VALIDATE_EMAIL)) {
        if (!security_rate_limit_check('connexion_email', $norm, 5, 3600)) {
            security_log_event('rate_limit', ['scope' => 'connexion_email']);
            header('Location: /connexion.php?envoye=1', true, 303);
            exit;
        }
    }
    security_rate_limit_hit('connexion_ip', $ip);
    if (filter_var($norm, FILTER_VALIDATE_EMAIL)) {
        security_rate_limit_hit('connexion_email', $norm);
        $hit = saas_auth_find_tenant_by_email($em);
        if ($hit !== null) {
            $slug = (string) $hit['tenant_slug'];
            $m    = saas_auth_create_magic_link($slug, $em, 'login');
            if ($m['ok'] ?? false && isset($m['token'])) {
                $host = (string) ($_SERVER['HTTP_HOST'] ?? 'ecosystemeimmo.fr');
                $isHt = !empty($_SERVER['HTTPS']) && (string) $_SERVER['HTTPS'] !== 'off';
                $link = ($isHt ? 'https' : 'http') . '://' . $host . '/auth/magic.php?token=' . rawurlencode((string) $m['token']);
                $urow = isset($hit['user']) && is_array($hit['user']) ? $hit['user'] : null;
                $ctx  = saas_auth_magic_link_email_context($slug, $urow);
                saas_auth_send_magic_link_email(saas_auth_normalize_email($em), $link, $ctx);
            }
        }
    }
    header('Location: /connexion.php?envoye=1', true, 303);
    exit;
}

$showMessage = isset($_GET['envoye']) && (string) $_GET['envoye'] === '1';
$page_title = 'Connexion — Écosystème Immo';
$meta_description = 'Accédez à votre espace par lien sécurisé envoyé par e-mail.';
include $root . '/includes/header.php';
?>
<main>
<section class="page-header">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="breadcrumb-sep">›</span>
      <span>Connexion</span>
    </div>
    <h1 class="page-header-title" style="max-width: 40rem">Accéder à mon espace</h1>
    <p class="page-header-subtitle" style="max-width: 40rem">Nous vous envoyons un <strong>lien de connexion</strong> (sans mot de passe). Aucun prélèvement sur cette page.</p>
  </div>
</section>
<section class="section">
  <div class="container" style="max-width: 480px; margin: 0 auto">
    <?php if ($showMessage): ?>
      <p style="padding: 14px 16px; background: var(--primary-50, #f0f9ff); border-radius: 8px; border: 1px solid var(--neutral-200); margin-bottom: 1.5rem; line-height: 1.5">
        Si un compte existe avec cet e-mail, <strong>un lien vient d’être envoyé</strong> (vérifiez les courriers indésirables). Le message peut prendre une minute. Le lien expire au bout d’environ 24 h — vous pourrez redemander une connexion ici.
      </p>
    <?php endif; ?>
    <form method="post" action="connexion.php" class="card" style="padding: 24px; border: 1px solid var(--neutral-200); border-radius: 12px; background: #fff">
      <div style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden" aria-hidden="true">
        <label for="website_hp_c">Ne pas remplir</label>
        <input type="text" name="website" id="website_hp_c" value="" tabindex="-1" autocomplete="off" />
        <label for="company_url_hp_c">Ne pas remplir</label>
        <input type="text" name="company_url" id="company_url_hp_c" value="" tabindex="-1" autocomplete="off" />
      </div>
      <label for="em" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 6px">Adresse e-mail</label>
      <input type="email" name="email" id="em" required autocomplete="email" class="form-input" style="width: 100%; padding: 10px 12px; border: 1px solid var(--neutral-300); border-radius: 8px; box-sizing: border-box" value="<?= isset($_GET['e']) ? htmlspecialchars((string) $_GET['e'], ENT_QUOTES, 'UTF-8') : '' ?>" />
      <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 16px; padding: 12px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer">M’envoyer le lien de connexion</button>
    </form>
  </div>
</section>
</main>
<?php include $root . '/includes/footer.php'; ?>
