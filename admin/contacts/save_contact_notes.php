<?php
/**
 * ÉCOSYSTÈME IMMO+ - API pour sauvegarder notes et type de lead
 */
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/csrf.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'error' => 'Non authentifié']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$action = $_POST['action'] ?? '';
$message_id = isset($_POST['message_id']) ? (int)$_POST['message_id'] : 0;

if (!$message_id || !$action) {
    echo json_encode(['success' => false, 'error' => 'Données manquantes']);
    exit;
}

try {
    if ($action === 'save_notes') {
        $notes = trim($_POST['notes'] ?? '');
        $lead_type = trim($_POST['lead_type'] ?? '');
        
        // Valider le type de lead
        $valid_types = ['Vendeur', 'Acheteur', 'Locataire', 'Investisseur', 'Financement', 'Partenaire 2L courtage', 'Partenaire habitat', 'Partenaire', 'Autre', ''];
        if (!in_array($lead_type, $valid_types)) {
            throw new Exception('Type de lead invalide');
        }
        
        // Mise à jour
        $stmt = $pdo->prepare("UPDATE contact_messages SET notes = ?, lead_type = ? WHERE id = ?");
        $stmt->execute([$notes, $lead_type ?: null, $message_id]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Notes et type de lead enregistrés',
            'notes' => $notes,
            'lead_type' => $lead_type
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Action inconnue']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>