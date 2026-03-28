<?php
/**
 * API - Récupérer un Lead avec son Historique Complet
 * Chemin: /api/get-lead.php
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once dirname(__DIR__) . '/includes/LeadService.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

try {
    $leadService = new LeadService();
    $result = $leadService->getLeadById($id);
    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Erreur serveur',
        'debug' => $e->getMessage()
    ]);
}