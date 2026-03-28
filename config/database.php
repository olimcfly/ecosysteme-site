<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Configuration Base de Données (consolidée)
 * Fichier unique de configuration — charge les variables depuis .env
 *
 * Inclure ce fichier en premier dans tous les fichiers
 * qui ont besoin d'accéder à la base de données.
 */
require_once __DIR__ . '/../includes/helpers.php';

// Charger les variables d'environnement
require_once __DIR__ . '/env-loader.php';

// ============================================
// 1. CONSTANTES DE CONNEXION
// ============================================
if (!defined('DB_HOST'))    define('DB_HOST',    getenv('DB_HOST')    ?: 'localhost');
if (!defined('DB_NAME'))    define('DB_NAME',    getenv('DB_NAME')    ?: '');
if (!defined('DB_USER'))    define('DB_USER',    getenv('DB_USER')    ?: '');
if (!defined('DB_PASS'))    define('DB_PASS',    getenv('DB_PASS')    ?: '');
if (!defined('DB_CHARSET')) define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

// ============================================
// 2. CONSTANTES API
// ============================================
if (!defined('ANTHROPIC_API_KEY')) define('ANTHROPIC_API_KEY', getenv('ANTHROPIC_API_KEY') ?: '');
if (!defined('ANTHROPIC_MODEL'))   define('ANTHROPIC_MODEL',   getenv('ANTHROPIC_MODEL')   ?: 'claude-3-5-sonnet-20241022');

// ============================================
// 3. CONSTANTES EMAIL & SMTP
// ============================================
if (!defined('SMTP_HOST'))          define('SMTP_HOST',          getenv('SMTP_HOST')          ?: '');
if (!defined('SMTP_PORT'))          define('SMTP_PORT',          getenv('SMTP_PORT')          ?: 465);
if (!defined('SMTP_USER'))          define('SMTP_USER',          getenv('SMTP_USER')          ?: '');
if (!defined('SMTP_PASS'))          define('SMTP_PASS',          getenv('SMTP_PASS')          ?: '');
if (!defined('SMTP_FROM_EMAIL'))    define('SMTP_FROM_EMAIL',    getenv('SMTP_FROM_EMAIL')    ?: '');
if (!defined('SMTP_FROM_NAME'))     define('SMTP_FROM_NAME',     getenv('SMTP_FROM_NAME')     ?: '');
if (!defined('ADMIN_EMAIL'))        define('ADMIN_EMAIL',        getenv('ADMIN_EMAIL')        ?: '');
if (!defined('NOTIFICATION_EMAIL')) define('NOTIFICATION_EMAIL', getenv('NOTIFICATION_EMAIL') ?: '');

// ============================================
// 4. CONSTANTES SITE
// ============================================
if (!defined('SITE_URL'))  define('SITE_URL',  getenv('SITE_URL')  ?: 'https://localhost');
if (!defined('SITE_NAME')) define('SITE_NAME', getenv('SITE_NAME') ?: 'ÉCOSYSTÈME IMMO LOCAL+');
if (!defined('CRM_URL'))   define('CRM_URL',   SITE_URL . '/admin-crm.php');

// ============================================
// 5. CONNEXION PDO (singleton)
// ============================================
function getDB() {
    static $pdo = null;

    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Erreur de connexion à la base de données");
        }
    }

    return $pdo;
}

// Variable globale $pdo (pour compatibilité)
$pdo = getDB();

// ============================================
// 6. HELPER FUNCTIONS
// ============================================

function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return h(trim($input));
}

function jsonResponse($success, $data = [], $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'data'    => $data
    ]);
    exit;
}

function formatDate($datetime) {
    return date('d/m/Y H:i', strtotime($datetime));
}
?>
