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
$telephone = isset($data['phone']) ? trim(strip_tags((string) $data['phone'])) : '';
$ville = isset($data['city']) ? trim(strip_tags((string) $data['city'])) : '';
$source = isset($data['source']) ? trim(strip_tags((string) $data['source'])) : 'landing_ecosystemeimmo';

if (!$nom || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$ville) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Champs requis manquants ou invalides']);
    exit;
}

$lead = crm_create_lead([
    'nom' => $nom,
    'email' => $email,
    'telephone' => $telephone,
    'ville' => $ville,
    'source' => $source,
]);

$subject = SUBJECT_PREFIX . $ville;
$body = "Nouveau lead capté depuis la landing page\n\n"
    . "Nom       : {$nom}\n"
    . "Email     : {$email}\n"
    . 'Téléphone : ' . ($telephone ?: '—') . "\n"
    . "Ville     : {$ville}\n"
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

echo json_encode([
    'ok' => true,
    'lead_id' => $lead['id'] ?? null,
]);
