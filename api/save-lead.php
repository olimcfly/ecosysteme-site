<?php
/**
 * API - Enregistrement Lead + Déclenchement Séquences
 * CRM v2.5 - Compatible GET et POST
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../includes/LeadService.php';

// Authentification et rate limiting
checkRateLimit();
requireApiAuthOrAdmin();

// ============================================
// Récupérer les données (GET ou POST)
// ============================================
$input = [];

// Priorité : JSON body > POST > GET
$jsonInput = json_decode(file_get_contents('php://input'), true);
if ($jsonInput) {
    $input = $jsonInput;
} elseif (!empty($_POST)) {
    $input = $_POST;
} elseif (!empty($_GET)) {
    $input = $_GET;
}

// ============================================
// Validation
// ============================================
$email = isset($input['email']) ? trim(strtolower($input['email'])) : '';
$firstname = isset($input['firstname']) ? trim($input['firstname']) : '';
$lastname = isset($input['lastname']) ? trim($input['lastname']) : '';
$phone = isset($input['phone']) ? trim($input['phone']) : '';
$city = isset($input['city']) ? trim($input['city']) : '';
$type = isset($input['type']) ? trim($input['type']) : 'contact';
$resource = isset($input['resource']) ? trim($input['resource']) : '';
$source = isset($input['source']) ? trim($input['source']) : '';
$message = isset($input['message']) ? trim($input['message']) : '';

// Validation email
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false, 
        'error' => 'Email invalide',
        'received' => $input
    ]);
    exit;
}

// ============================================
// Créer le lead avec EmailSender
// ============================================
try {
    $leadService = new LeadService();
    $result = $leadService->createLead([
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'phone' => $phone,
        'city' => $city,
        'type' => $type,
        'resource' => $resource,
        'source' => $source,
        'message' => $message,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
        'referrer' => $_SERVER['HTTP_REFERER'] ?? null,
    ], true);
    
    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'lead_id' => $result['lead_id'],
            'is_new' => $result['is_new'],
            'intent' => $result['intent'],
            'sequence_started' => $result['sequence_started'],
            'message' => $result['is_new'] ? 'Lead créé avec succès' : 'Lead mis à jour'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => $result['error'] ?? 'Erreur inconnue'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Erreur serveur',
        'debug' => $e->getMessage()
    ]);
}