<?php
/**
 * ============================================
 * DEBUG CONFIGURATION
 * ============================================
 */

// Afficher TOUS les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Custom error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo '<div style="background:#fee2e2; border:2px solid #dc2626; padding:15px; margin:15px; border-radius:8px; font-family:monospace; color:#991b1b;">';
    echo '<strong style="display:block; margin-bottom:10px;">⚠️ ERREUR PHP</strong>';
    echo "📁 Fichier: <strong>$errfile</strong><br>";
    echo "📍 Ligne: <strong>$errline</strong><br>";
    echo "📋 Type: <strong>" . errorTypeToString($errno) . "</strong><br>";
    echo "❌ Message: <strong>$errstr</strong>";
    echo '</div>';
    return true;
});

function errorTypeToString($type) {
    return match($type) {
        E_ERROR => 'E_ERROR',
        E_WARNING => 'E_WARNING',
        E_PARSE => 'E_PARSE',
        E_NOTICE => 'E_NOTICE',
        E_CORE_ERROR => 'E_CORE_ERROR',
        E_CORE_WARNING => 'E_CORE_WARNING',
        E_COMPILE_ERROR => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING => 'E_COMPILE_WARNING',
        E_USER_ERROR => 'E_USER_ERROR',
        E_USER_WARNING => 'E_USER_WARNING',
        E_USER_NOTICE => 'E_USER_NOTICE',
        E_STRICT => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED => 'E_DEPRECATED',
        E_USER_DEPRECATED => 'E_USER_DEPRECATED',
        default => "ERREUR #$type"
    };
}

// ============================================
// HELPER DEBUG
// ============================================
function debugLog($label, $data = null) {
    echo '<div style="background:#f0f9ff; border:2px solid #0ea5e9; padding:12px; margin:10px; border-radius:6px; font-family:monospace; font-size:12px;">';
    echo '<strong style="color:#0369a1;">🔍 ' . htmlspecialchars($label) . '</strong>';
    if ($data !== null) {
        echo '<pre style="margin:8px 0; background:#white; padding:8px; border-radius:4px; overflow-x:auto;">';
        echo htmlspecialchars(is_array($data) || is_object($data) ? json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $data);
        echo '</pre>';
    }
    echo '</div>';
}

function debugSession() {
    debugLog('SESSION', $_SESSION);
}

function debugGet() {
    debugLog('GET', $_GET ?: 'Vide');
}

function debugPost() {
    debugLog('POST', $_POST ?: 'Vide');
}

function debugServer() {
    debugLog('REQUEST_URI', $_SERVER['REQUEST_URI']);
    debugLog('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
    debugLog('REMOTE_ADDR', $_SERVER['REMOTE_ADDR']);
}

function debugDatabase($pdo) {
    if ($pdo) {
        debugLog('DATABASE', 'Connecte ✅');
    } else {
        echo '<div style="background:#fecaca; border:2px solid #ef4444; padding:12px; margin:10px; border-radius:6px;">';
        echo '<strong style="color:#991b1b;">❌ DATABASE NON CONNECTÉE</strong>';
        echo '</div>';
    }
}

// ============================================
// DEBUG RAPIDE
// ============================================
// Charger les variables d'environnement si pas déjà fait
require_once __DIR__ . '/../../config/env-loader.php';

$DEBUG = getenv('DEBUG') === 'true'; // Contrôlé par la variable ENV DEBUG

if ($DEBUG) {
    echo '<div style="position:fixed; top:10px; right:10px; background:#1f2937; color:#fff; padding:10px 15px; border-radius:6px; font-size:11px; z-index:9999; font-family:monospace;">';
    echo '🔴 DEBUG MODE ON';
    echo '</div>';
}

?>