<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';

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
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Méthode non autorisée']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    $data = $_POST;
}

$nom = isset($data['nom']) ? trim(strip_tags((string) $data['nom'])) : '';
$email = isset($data['email']) ? trim(strip_tags((string) $data['email'])) : '';
$phone = isset($data['phone']) ? trim(strip_tags((string) $data['phone'])) : '';
$city = isset($data['city']) ? trim(strip_tags((string) $data['city'])) : '';
$visitorId = isset($data['visitor_id']) ? trim(strip_tags((string) $data['visitor_id'])) : '';

if (!$nom || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$city) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Champs requis manquants ou invalides']);
    exit;
}

$lead = crm_create_lead([
    'nom' => $nom,
    'email' => $email,
    'phone' => $phone,
    'city' => $city,
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
    . "Nom    : {$nom}\n"
    . "Email  : {$email}\n"
    . 'Tél    : ' . ($phone ?: '—') . "\n"
    . "Ville  : {$city}\n"
    . 'Score  : ' . $lead['score'] . "/100\n"
    . "ID lead: {$lead['id']}\n\n"
    . 'Reçu le : ' . date('d/m/Y à H:i') . "\n";

$headers = "From: noreply@ecosystemeimmo.fr\r\n"
    . "Reply-To: {$email}\r\n"
    . 'X-Mailer: PHP/' . phpversion();

$mailSent = mail(NOTIFY_EMAIL, $subject, $body, $headers);

if (!$mailSent) {
    error_log('[EcosystemeImmo] Échec envoi notification interne pour lead ' . $lead['id']);
}

echo json_encode([
    'ok' => true,
    'lead_id' => $lead['id'],
    'score' => $lead['score'],
]);
