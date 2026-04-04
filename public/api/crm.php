<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$action = $_GET['action'] ?? 'list';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'list') {
        echo json_encode([
            'ok' => true,
            'leads' => crm_get_leads_with_defaults(),
        ]);
        exit;
    }

    http_response_code(404);
    echo json_encode(['ok' => false, 'error' => 'Action inconnue']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

if ($action === 'update') {
    $leadId = (string) ($input['lead_id'] ?? '');
    if ($leadId === '') {
        http_response_code(422);
        echo json_encode(['ok' => false, 'error' => 'lead_id manquant']);
        exit;
    }

    $updated = crm_update_lead($leadId, [
        'status' => $input['status'] ?? null,
        'notes' => $input['notes'] ?? null,
        'estimated_amount' => $input['estimated_amount'] ?? null,
    ]);

    if (!$updated) {
        http_response_code(404);
        echo json_encode(['ok' => false, 'error' => 'Lead introuvable']);
        exit;
    }

    echo json_encode(['ok' => true]);
    exit;
}

if ($action === 'send-sequence') {
    $result = crm_send_due_sequence_emails();
    echo json_encode(['ok' => true, 'result' => $result]);
    exit;
}

http_response_code(404);
echo json_encode(['ok' => false, 'error' => 'Action inconnue']);
