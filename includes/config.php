<?php
/**
 * config.php
 * Constantes de configuration — aucun code exécutable ici
 * Connexion PDO : utiliser ce fichier dans les modules via new PDO(...)
 */

// Charger les variables d'environnement
require_once dirname(__DIR__) . '/config/env-loader.php';

// ── Base de données ────────────────────────────────────────────
if (!defined('DB_HOST'))    define('DB_HOST',    getenv('DB_HOST')    ?: 'localhost');
if (!defined('DB_NAME'))    define('DB_NAME',    getenv('DB_NAME')    ?: '');
if (!defined('DB_USER'))    define('DB_USER',    getenv('DB_USER')    ?: '');
if (!defined('DB_PASS'))    define('DB_PASS',    getenv('DB_PASS')    ?: '');
if (!defined('DB_CHARSET')) define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

// ── Application ───────────────────────────────────────────────
define('APP_NAME',    'ÉCOSYSTÈME IMMO LOCAL');
define('APP_URL',     getenv('SITE_URL') ?: 'https://ecosystemeimmo.fr');
define('APP_VERSION', '1.0.0');

// ── Emails ────────────────────────────────────────────────────
if (!defined('ADMIN_EMAIL'))   define('ADMIN_EMAIL',   getenv('ADMIN_EMAIL')   ?: 'contact@ecosystemeimmo.fr');
if (!defined('NOREPLY_EMAIL')) define('NOREPLY_EMAIL',  getenv('NOREPLY_EMAIL') ?: 'noreply@ecosystemeimmo.fr');
if (!defined('SMTP_HOST'))     define('SMTP_HOST',      getenv('SMTP_HOST')     ?: '');
if (!defined('SMTP_PORT'))     define('SMTP_PORT',      getenv('SMTP_PORT')     ?: 465);
if (!defined('SMTP_USER'))     define('SMTP_USER',      getenv('SMTP_USER')     ?: '');
if (!defined('SMTP_PASS'))     define('SMTP_PASS',      getenv('SMTP_PASS')     ?: '');

// ── Sécurité ──────────────────────────────────────────────────
define('SECRET_KEY', getenv('SECRET_KEY') ?: 'CHANGEZ_CETTE_CLE_ALEATOIRE_32CHARS');

// ── Environnement ─────────────────────────────────────────────
define('APP_ENV',   getenv('APP_ENV')   ?: 'production');
define('APP_DEBUG', getenv('APP_DEBUG') === 'true');

// ── Chemins absolus ───────────────────────────────────────────
define('ROOT_PATH',     $_SERVER['DOCUMENT_ROOT']);
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('UPLOADS_PATH',  ROOT_PATH . '/uploads');
define('LOGS_PATH',     ROOT_PATH . '/logs');

// ── Zones réservées (utilisé dans villes-pilotes.php) ────────
define('VILLES_RESERVEES', serialize([
    'Bordeaux', 'Nantes', 'Nandy', 'Lannion'
]));
define('VILLES_DISCUSSION', serialize([
    'Aix-en-Provence'
]));
