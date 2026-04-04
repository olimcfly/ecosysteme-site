<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';

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

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$eventKey = trim((string) ($input['event_key'] ?? ''));

$labels = [
    'page_capture_vue' => 'Page capture vue',
    'video_vue' => 'Vidéo vue',
    'offre_vue' => 'Offre vue',
    'clic_cta' => 'Clic CTA',
    'formulaire_rempli' => 'Formulaire rempli',
    'rdv_pris' => 'RDV pris',
];

if (!isset($labels[$eventKey])) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'event_key invalide']);
    exit;
}

$event = crm_track_event($eventKey, $labels[$eventKey], [
    'lead_id' => trim((string) ($input['lead_id'] ?? '')),
    'visitor_id' => trim((string) ($input['visitor_id'] ?? '')),
    'page' => trim((string) ($input['page'] ?? '')),
    'meta' => is_array($input['meta'] ?? null) ? $input['meta'] : [],
]);

echo json_encode([
    'ok' => true,
    'event_id' => $event['id'],
]);
