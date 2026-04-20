<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';
require_once __DIR__ . '/_helpers.php';

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

$eventKey = api_sanitize_string(filter_input(INPUT_POST, 'event_key', FILTER_UNSAFE_RAW));
if ($eventKey === '' && isset($jsonInput['event_key'])) {
    $eventKey = api_sanitize_string((string) $jsonInput['event_key']);
}

$labels = [
    'page_capture_vue' => 'Page capture vue',
    'video_vue' => 'Vidéo vue',
    'offre_vue' => 'Offre vue',
    'clic_cta' => 'Clic CTA',
    'formulaire_rempli' => 'Formulaire rempli',
    'rdv_pris' => 'RDV pris',
];

if (!isset($labels[$eventKey])) {
    api_error('invalid_event_key', 422);
    exit;
}

$leadId = api_sanitize_string(filter_input(INPUT_POST, 'lead_id', FILTER_UNSAFE_RAW));
$visitorId = api_sanitize_string(filter_input(INPUT_POST, 'visitor_id', FILTER_UNSAFE_RAW));
$page = api_sanitize_string(filter_input(INPUT_POST, 'page', FILTER_UNSAFE_RAW));
$meta = filter_input(INPUT_POST, 'meta', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

if ($leadId === '' && isset($jsonInput['lead_id'])) {
    $leadId = api_sanitize_string((string) $jsonInput['lead_id']);
}
if ($visitorId === '' && isset($jsonInput['visitor_id'])) {
    $visitorId = api_sanitize_string((string) $jsonInput['visitor_id']);
}
if ($page === '' && isset($jsonInput['page'])) {
    $page = api_sanitize_string((string) $jsonInput['page']);
}
if (!is_array($meta) && isset($jsonInput['meta']) && is_array($jsonInput['meta'])) {
    $meta = $jsonInput['meta'];
}

$event = crm_track_event($eventKey, $labels[$eventKey], [
    'lead_id' => $leadId,
    'visitor_id' => $visitorId,
    'page' => $page,
    'meta' => is_array($meta) ? $meta : [],
]);

api_json_response([
    'ok' => true,
    'event_id' => $event['id'],
]);
