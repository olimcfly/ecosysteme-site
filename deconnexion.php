<?php
declare(strict_types=1);

$root = dirname(__FILE__);
$crm  = require $root . '/includes/mini_crm_config.php';
$sn   = (string) ($crm['session_name'] ?? 'mini_crm_sid');
if (session_status() === PHP_SESSION_NONE) {
    session_name($sn);
    session_start();
}
require_once $root . '/includes/saas_auth_service.php';

if (function_exists('saas_auth_logout')) {
    saas_auth_logout();
}
header('Location: /connexion.php', true, 302);
exit;
