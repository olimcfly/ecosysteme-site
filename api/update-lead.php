<?php
/**
 * API - Update Lead
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit();
}

require_once __DIR__ . '/../includes/LeadService.php';

try {
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    if (!$data) {
        $data = $_POST;
    }

    $id = (int)($data['id'] ?? 0);

    if (!$id) {
        throw new Exception('ID requis');
    }

    $leadService = new LeadService();
    $result = $leadService->updateLead($id, $data);

    if (!$result['success']) {
        throw new Exception($result['error']);
    }

    echo json_encode($result);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
