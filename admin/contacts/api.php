<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - API Contacts
 * Endpoints pour traiter les soumissions de contact en AJAX
 * CORRECTION: Utilise contact_messages au lieu de leads
 */

require_once __DIR__ . '/../../includes/ContactService.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$contactService = new ContactService();

switch ($action) {

    case 'submit_contact':
        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }

        try {
            $result = $contactService->createContactAdmin($_POST);

            if (!$result['success']) {
                echo json_encode($result);
                exit;
            }

            echo json_encode($result);

        } catch (Exception $e) {
            http_response_code(500);
            error_log("Contact API Error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage()
            ]);
        }
        break;

    case 'check_email':
        $email = trim($_POST['email'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'exists' => false]);
            exit;
        }

        try {
            $exists = $contactService->checkEmailExists($email);
            echo json_encode([
                'success' => true,
                'exists' => $exists,
                'message' => $exists ? 'Email déjà enregistré' : 'Email disponible'
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur']);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Action inconnue',
            'available_actions' => ['submit_contact', 'check_email']
        ]);
}

exit;
?>