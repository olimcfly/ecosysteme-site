<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'track-open') {
    $leadId = (string) ($_GET['lead_id'] ?? '');
    $stepId = (string) ($_GET['step_id'] ?? '');

    if ($leadId !== '' && $stepId !== '') {
        crm_track_open($leadId, $stepId);
    }

    header('Content-Type: image/gif');
    echo base64_decode('R0lGODlhAQABAPAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
    exit;
}

if ($action === 'track-click') {
    $leadId = (string) ($_GET['lead_id'] ?? '');
    $stepId = (string) ($_GET['step_id'] ?? '');
    $type = (string) ($_GET['type'] ?? '');
    $redirect = (string) ($_GET['redirect'] ?? '/');

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
        echo json_encode([
            'ok' => true,
            'leads' => crm_get_leads(),
            'stats' => crm_get_stats(),
        ]);
        exit;
    }

    if ($action === 'stats') {
        echo json_encode(['ok' => true, 'stats' => crm_get_stats()]);
        exit;
    }

    http_response_code(404);
    echo json_encode(['ok' => false, 'error' => 'Action inconnue']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

if ($action === 'update') {
    $id = (int) ($input['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(422);
        echo json_encode(['ok' => false, 'error' => 'id manquant']);
        exit;
    }

    $updated = crm_update_lead($leadId, [
        'status' => $input['status'] ?? null,
        'notes' => $input['notes'] ?? null,
        'estimated_amount' => $input['estimated_amount'] ?? null,
    ]);

    if (!$updated) {
        http_response_code(422);
        echo json_encode(['ok' => false, 'error' => 'Aucune mise à jour']);
        exit;
    }

    echo json_encode(['ok' => true]);
    exit;
}

if ($action === 'send-sequence') {
    $result = crm_send_due_sequence_emails();
    echo json_encode(['ok' => true, 'result' => $result, 'stats' => crm_get_stats()]);
    exit;
}

http_response_code(404);
echo json_encode(['ok' => false, 'error' => 'Action inconnue']);
