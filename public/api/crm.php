<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';
require_once __DIR__ . '/_helpers.php';

$actionInput = filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW);
$action = api_sanitize_string($actionInput) ?: 'list';

if ($action === 'track-open') {
    $leadId = api_sanitize_string(filter_input(INPUT_GET, 'lead_id', FILTER_UNSAFE_RAW));
    $stepId = api_sanitize_string(filter_input(INPUT_GET, 'step_id', FILTER_UNSAFE_RAW));

    if ($leadId !== '' && $stepId !== '') {
        crm_track_open($leadId, $stepId);
    }

    header('Content-Type: image/gif');
    echo base64_decode('R0lGODlhAQABAPAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
    exit;
}

if ($action === 'track-click') {
    $leadId = api_sanitize_string(filter_input(INPUT_GET, 'lead_id', FILTER_UNSAFE_RAW));
    $stepId = api_sanitize_string(filter_input(INPUT_GET, 'step_id', FILTER_UNSAFE_RAW));
    $type = api_sanitize_string(filter_input(INPUT_GET, 'type', FILTER_UNSAFE_RAW));
    $redirect = filter_input(INPUT_GET, 'redirect', FILTER_SANITIZE_URL) ?: '/';

    if ($leadId !== '' && $stepId !== '') {
        crm_track_click($leadId, $stepId, $type);
    }

    header('Location: ' . $redirect);
    exit;
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'list') {
        api_json_response([
            'ok' => true,
            'leads' => crm_get_leads(),
            'stats' => crm_get_email_stats(),
            'queue' => crm_get_email_queue(),
        ]);
        exit;
    }

    if ($action === 'stats') {
        api_json_response(['ok' => true, 'stats' => crm_get_stats()]);
        exit;
    }

    api_error('unknown_action', 404);
    exit;
}

/** @var array<string, mixed> $jsonInput */
$jsonInput = json_decode(file_get_contents('php://input'), true) ?: [];

if ($action === 'update') {
    $leadId = api_sanitize_string(filter_input(INPUT_POST, 'lead_id', FILTER_UNSAFE_RAW));
    if ($leadId === '' && isset($jsonInput['lead_id'])) {
        $leadId = api_sanitize_string((string) $jsonInput['lead_id']);
    }
    if ($leadId === '' && isset($jsonInput['id'])) {
        $leadId = api_sanitize_string((string) $jsonInput['id']);
    }
    if ($leadId === '') {
        http_response_code(422);
        echo json_encode(['ok' => false, 'error' => 'lead_id manquant']);
        exit;
    }

    $status = filter_input(INPUT_POST, 'status', FILTER_UNSAFE_RAW);
    $notes = filter_input(INPUT_POST, 'notes', FILTER_UNSAFE_RAW);
    $estimatedAmount = filter_input(INPUT_POST, 'estimated_amount', FILTER_UNSAFE_RAW);

    if (($status === null || $status === false) && isset($jsonInput['status'])) {
        $status = (string) $jsonInput['status'];
    }
    if (($notes === null || $notes === false) && isset($jsonInput['notes'])) {
        $notes = (string) $jsonInput['notes'];
    }
    if (($estimatedAmount === null || $estimatedAmount === false) && isset($jsonInput['estimated_amount'])) {
        $estimatedAmount = (string) $jsonInput['estimated_amount'];
    }

    $updated = crm_update_lead($leadId, [
        'status' => api_sanitize_string(is_string($status) ? $status : null) ?: null,
        'notes' => api_sanitize_string(is_string($notes) ? $notes : null) ?: null,
        'estimated_amount' => is_scalar($estimatedAmount) ? (string) $estimatedAmount : null,
    ]);

    if (!$updated) {
        api_error('no_updates', 422);
        exit;
    }

    api_json_response(['ok' => true]);
    exit;
}

if ($action === 'send-sequence') {
    $result = crm_send_due_sequence_emails();
    api_json_response(['ok' => true, 'result' => $result, 'stats' => crm_get_stats()]);
    exit;
}

api_error('unknown_action', 404);
