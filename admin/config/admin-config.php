<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Configuration Admin
 * Spécifique à l'espace administrateur
 *
 * Inclure après database.php
 */

require_once __DIR__ . '/../../includes/security-headers.php';
require_once __DIR__ . '/../../includes/csrf.php';

// ============================================
// 1. AUTHENTIFICATION & OTP
// ============================================
define('OTP_LENGTH', 6);              // Longueur du code OTP (6 chiffres)
define('OTP_EXPIRY', 600);            // Validité du code (10 minutes)
define('OTP_MAX_ATTEMPTS', 5);        // Max tentatives avant blocage
define('SESSION_DURATION', 86400);    // Durée session (24h)

// ============================================
// 2. EMAIL (configuration admin)
// ============================================
define('EMAIL_FROM', 'admin@ecosystemeimmo.fr');
define('EMAIL_FROM_NAME', 'ÉCOSYSTÈME IMMO LOCAL+');
define('EMAIL_REPLY_TO', 'admin@ecosystemeimmo.fr');


// ============================================
// 4. SCORING (points pour chaque action)
// ============================================
define('SCORE_DOWNLOAD_RESSOURCE', 10);
define('SCORE_DOWNLOAD_OUTIL', 20);
define('SCORE_DOWNLOAD_DIAGNOSTIC', 30);
define('SCORE_DEMO_REQUEST', 50);
define('SCORE_CALL_BOOKED', 100);

// ============================================
// 5. DEBUG MODE
// ============================================
define('DEBUG_MODE', false); // À passer à true seulement en développement

?>