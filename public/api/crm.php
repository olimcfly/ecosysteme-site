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
            'leads' => crm_get_contacts([
                'ville' => $_GET['ville'] ?? '',
                'statut_tunnel' => $_GET['statut'] ?? '',
                'q' => $_GET['q'] ?? '',
                'sort' => $_GET['sort'] ?? 'DESC',
            ]),
            'stats' => crm_dashboard_stats(),
        ]);
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

    $updated = crm_update_contact($id, [
        'statut_tunnel' => $input['statut_tunnel'] ?? null,
    ]);

    if (!$updated) {
        http_response_code(422);
        echo json_encode(['ok' => false, 'error' => 'Aucune mise à jour']);
        exit;
    }

    echo json_encode(['ok' => true]);
    exit;
}

http_response_code(404);
echo json_encode(['ok' => false, 'error' => 'Action inconnue']);
