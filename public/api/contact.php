<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';
require_once __DIR__ . '/_helpers.php';

define('NOTIFY_EMAIL', 'contact@ecosystemeimmo.fr');
define('SUBJECT_PREFIX', '[Ecosystème Immo] Nouveau lead — ');

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

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$nom = api_sanitize_string(filter_input(INPUT_POST, 'nom', FILTER_UNSAFE_RAW));
$phone = api_sanitize_string(filter_input(INPUT_POST, 'phone', FILTER_UNSAFE_RAW));
$city = api_sanitize_string(filter_input(INPUT_POST, 'city', FILTER_UNSAFE_RAW));
$source = api_sanitize_string(filter_input(INPUT_POST, 'source', FILTER_UNSAFE_RAW)) ?: 'modal';
$visitorId = api_sanitize_string(filter_input(INPUT_POST, 'visitor_id', FILTER_UNSAFE_RAW));

if ($email === null || $email === false) {
    $email = isset($jsonInput['email']) ? filter_var((string) $jsonInput['email'], FILTER_SANITIZE_EMAIL) : '';
}
if ($nom === '' && isset($jsonInput['nom'])) {
    $nom = api_sanitize_string((string) $jsonInput['nom']);
}
if ($phone === '' && isset($jsonInput['phone'])) {
    $phone = api_sanitize_string((string) $jsonInput['phone']);
}
if ($city === '' && isset($jsonInput['city'])) {
    $city = api_sanitize_string((string) $jsonInput['city']);
}
if ($source === 'modal' && isset($jsonInput['source'])) {
    $source = api_sanitize_string((string) $jsonInput['source']) ?: 'modal';
}
if ($visitorId === '' && isset($jsonInput['visitor_id'])) {
    $visitorId = api_sanitize_string((string) $jsonInput['visitor_id']);
}

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    api_error('invalid_email', 422);
    exit;
}

if ($nom === '' || $city === '') {
    api_error('missing_or_invalid_fields', 422);
    exit;
}

$lead = crm_create_lead([
    'nom' => $nom,
    'email' => $email,
    'phone' => $phone,
    'city' => $city,
    'source' => $source,
    'visitor_id' => $visitorId,
]);

crm_attach_visitor_events_to_lead($visitorId, (string) $lead['id']);
crm_track_event('formulaire_rempli', 'Formulaire rempli', [
    'lead_id' => (string) $lead['id'],
    'visitor_id' => $visitorId,
    'page' => '/#modal-form',
]);
crm_track_event('rdv_pris', 'RDV pris', [
    'lead_id' => (string) $lead['id'],
    'visitor_id' => $visitorId,
    'page' => '/#cta-final',
]);

$subject = SUBJECT_PREFIX . $city;
$body = "Nouveau lead capté depuis la landing page\n\n"
    . "Nom       : {$nom}\n"
    . "Email     : {$email}\n"
    . 'Téléphone : ' . ($phone !== '' ? $phone : '—') . "\n"
    . "Ville     : {$city}\n"
    . "Source    : {$source}\n"
    . 'ID lead   : ' . ($lead['id'] ?? 'inconnu') . "\n\n"
    . 'Reçu le : ' . date('d/m/Y à H:i') . "\n";

$headers = "From: noreply@ecosystemeimmo.fr\r\n"
    . "Reply-To: {$email}\r\n"
    . 'X-Mailer: PHP/' . phpversion();

$mailSent = mail(NOTIFY_EMAIL, $subject, $body, $headers);

if (!$mailSent) {
    error_log('[EcosystemeImmo] Échec envoi notification interne pour lead ' . ($lead['id'] ?? 'unknown'));
}

api_json_response([
    'ok' => true,
    'lead_id' => $lead['id'] ?? null,
]);
