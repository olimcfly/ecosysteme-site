<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Database Configuration
 * Ce fichier délègue à config/database.php (fichier consolidé)
 */
require_once __DIR__ . '/includes/helpers.php';

// ============================================
// CONFIGURATION BASE DE DONNÉES
// ============================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'tasq5564_ecosystemeimmolocal');  
define('DB_USER', 'tasq5564_occolas14');
define('DB_PASS', 'xxdFJXyAeCc6');
define('DB_CHARSET', 'utf8mb4');

// ============================================
// CONFIGURATION EMAIL SMTP
// ============================================

define('SMTP_HOST', 'ecosystemeimmo.fr');
define('SMTP_PORT', 465);
define('SMTP_USER', 'admin@ecosystemeimmo.fr');
define('SMTP_PASS', '0785611700Fd!');
define('SMTP_FROM_EMAIL', 'admin@ecosystemeimmo.fr');
define('SMTP_FROM_NAME', 'ÉCOSYSTÈME IMMO LOCAL+');
define('NOTIFICATION_EMAIL', 'admin@ecosystemeimmo.fr');

// ============================================
// CONFIGURATION SITE
// ============================================

define('SITE_URL', 'https://ecosystemeimmo.fr');
define('SITE_NAME', 'ÉCOSYSTÈME IMMO LOCAL+');
define('CRM_URL', SITE_URL . '/admin-crm.php');

// ============================================
// CONNEXION PDO
// ============================================

function getDB() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Erreur de connexion à la base de données");
        }
    }
    
    return $pdo;
}

// ============================================
// HELPER FUNCTIONS
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
        'data' => $data
    ]);
    exit;
}

function formatDate($datetime) {
    return date('d/m/Y H:i', strtotime($datetime));
}

?>
