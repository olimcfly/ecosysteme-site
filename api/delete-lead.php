<?php
/**
 * API - Supprimer un Lead et son Historique
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: GET, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../includes/LeadService.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$leadService = new LeadService();
$result = $leadService->deleteLead($id);

echo json_encode($result);