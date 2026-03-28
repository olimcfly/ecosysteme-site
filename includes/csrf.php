<?php
/**
 * Protection CSRF - ÉCOSYSTÈME IMMO LOCAL+
 * Génère et valide un token CSRF unique par session.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Génère un token CSRF et le stocke en session.
 * Retourne le token existant s'il y en a déjà un.
 */
function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valide le token CSRF reçu en POST.
 * Retourne true si le token est valide, false sinon.
 */
function validateCsrfToken(?string $token = null): bool
{
    if ($token === null) {
        // Check POST data first
        $token = $_POST['csrf_token'] ?? '';
        // Then X-CSRF-Token header
        if (empty($token)) {
            $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        }
        // Then JSON body (cache it globally so php://input can be re-read)
        if (empty($token)) {
            if (!isset($GLOBALS['_JSON_INPUT'])) {
                $raw = file_get_contents('php://input');
                $GLOBALS['_JSON_INPUT_RAW'] = $raw;
                $GLOBALS['_JSON_INPUT'] = json_decode($raw, true) ?: [];
            }
            $token = $GLOBALS['_JSON_INPUT']['csrf_token'] ?? '';
        }
    }
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Génère le champ hidden HTML pour le formulaire.
 */
function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(generateCsrfToken()) . '">';
}
