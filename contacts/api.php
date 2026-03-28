<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - API Traitement Contact
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/ContactService.php';

header('Content-Type: application/json; charset=utf-8');

// Valider le token CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !validateCsrfToken()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Token de sécurité invalide.']);
    exit;
}

// Récupérer l'action
$action = isset($_POST['action']) ? trim($_POST['action']) : '';

if (empty($action)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Action manquante']);
    exit;
}

if ($action !== 'submit_contact') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Action invalide']);
    exit;
}

try {
    $contactService = new ContactService();
    $result = $contactService->createContact($_POST);

    if (!$result['success']) {
        http_response_code(400);
        echo json_encode($result);
        exit;
    }

    http_response_code(200);
    echo json_encode($result);

} catch (Exception $e) {
    http_response_code(500);
    error_log("Contact API Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur'
    ]);
}

exit;
?>
