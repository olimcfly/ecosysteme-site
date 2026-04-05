<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';
require_once __DIR__ . '/_helpers.php';

define('LOGEMENT_NOTIFY_EMAIL', 'contact@ecosystemeimmo.fr');
define('LOGEMENT_FROM_EMAIL', 'noreply@ecosystemeimmo.fr');
define('LOGEMENT_SUBJECT_PREFIX', '[Ecosystème Immo] Demande logement automatisée — ');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    api_error('method_not_allowed', 405);
    exit;
}

/** @var array<string, mixed> $jsonInput */
$jsonInput = json_decode(file_get_contents('php://input'), true) ?: [];

$nom = api_sanitize_string((string) ($jsonInput['nom'] ?? ''));
$email = filter_var((string) ($jsonInput['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone = api_sanitize_string((string) ($jsonInput['telephone'] ?? ''));
$city = api_sanitize_string((string) ($jsonInput['ville'] ?? ''));
$budget = api_sanitize_string((string) ($jsonInput['budget'] ?? ''));
$message = api_sanitize_string((string) ($jsonInput['message'] ?? ''));
$source = api_sanitize_string((string) ($jsonInput['source'] ?? 'automation_logement'));

if ($nom === '' || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || $city === '') {
    api_error('missing_or_invalid_fields', 422, ['fields' => ['nom', 'email', 'ville']]);
    exit;
}

$lead = crm_create_lead([
    'nom' => $nom,
    'email' => $email,
    'phone' => $phone,
    'city' => $city,
    'source' => $source,
]);

$requestCode = sprintf(
    'LOG-%s-%s',
    gmdate('Ymd-His'),
    strtoupper(substr((string) $lead['id'], 0, 6))
);

$subject = LOGEMENT_SUBJECT_PREFIX . $city;
$body = "Nouvelle demande logement automatique\n\n"
    . "Code dossier : {$requestCode}\n"
    . "Nom          : {$nom}\n"
    . "Email        : {$email}\n"
    . 'Téléphone    : ' . ($phone !== '' ? $phone : '—') . "\n"
    . "Ville        : {$city}\n"
    . 'Budget       : ' . ($budget !== '' ? $budget : '—') . "\n"
    . 'Message      : ' . ($message !== '' ? $message : '—') . "\n"
    . 'Source       : ' . ($source !== '' ? $source : '—') . "\n"
    . 'ID lead      : ' . ($lead['id'] ?? 'inconnu') . "\n"
    . 'Date UTC     : ' . gmdate('d/m/Y H:i:s') . "\n";

$headers = "From: " . LOGEMENT_FROM_EMAIL . "\r\n"
    . "Reply-To: {$email}\r\n"
    . 'X-Mailer: PHP/' . phpversion();

$mailSent = mail(LOGEMENT_NOTIFY_EMAIL, $subject, $body, $headers);

crm_track_event('demande_logement_auto', 'Demande logement automatique', [
    'lead_id' => (string) $lead['id'],
    'page' => '/api/logement-automation.php',
    'meta' => [
        'request_code' => $requestCode,
        'mail_sent' => $mailSent,
    ],
]);

if (!$mailSent) {
    error_log('[EcosystemeImmo] Échec envoi email demande logement pour lead ' . ($lead['id'] ?? 'unknown'));
}

api_json_response([
    'ok' => true,
    'lead_id' => $lead['id'] ?? null,
    'request_code' => $requestCode,
    'mail_sent' => $mailSent,
]);
