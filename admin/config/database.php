<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Configuration Base de Données
 * Partagé par l'ensemble du site (public + admin)
 *
 * Ce fichier doit être inclus en premier dans tous les fichiers
 * qui ont besoin d'accéder à la base de données.
 */
require_once __DIR__ . '/../../includes/helpers.php';

// ============================================
// 1. CONSTANTES DE CONNEXION
// ============================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'tasq5564_ecosystemeimmolocal');
define('DB_USER', 'tasq5564_occolas14');
define('DB_PASS', 'xxdFJXyAeCc6');
define('DB_CHARSET', 'utf8mb4');

// ============================================
// 2. CONSTANTES EMAIL & SMTP
// ============================================
define('SMTP_FROM_EMAIL', 'admin@ecosystemeimmo.fr');
define('ADMIN_EMAIL', 'admin@ecosystemeimmo.fr');
define('NOTIFICATION_EMAIL', 'admin@ecosystemeimmo.fr');
define('SITE_NAME', 'ÉCOSYSTÈME IMMO LOCAL+');
define('SITE_URL', 'https://ecosystemeimmo.fr');

// ============================================
// 3. CONSTANTES API
// ============================================
define('ANTHROPIC_API_KEY', 'sk-ant-api03-F-yRJL_2_...');
define('ANTHROPIC_MODEL', 'claude-3-5-sonnet-20241022');

// ============================================
// 2. FONCTION DE CONNEXION (singleton)
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
            die("Erreur de connexion à la base de données. Contactez l'administrateur.");
        }
    }
    
    return $pdo;
}

// ============================================
// 3. VARIABLE GLOBALE $pdo (pour compatibilité)
// ============================================
$pdo = getDB();

// ============================================
// 4. HELPER FUNCTIONS
// ============================================

/**
 * Nettoie et sécurise une entrée
 */
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return h(trim($input));
}

/**
 * Retourne une réponse JSON formatée
 */
function jsonResponse($success, $data = [], $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'data' => $data
    ]);
    exit;
}

/**
 * Formate une date pour l'affichage
 */
function formatDate($datetime) {
    return date('d/m/Y H:i', strtotime($datetime));
}
?>
