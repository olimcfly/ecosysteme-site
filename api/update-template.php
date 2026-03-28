<?php
/**
 * API - Mise à jour template email
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/database.php';
require_once __DIR__ . '/../includes/api-auth.php';
require_once __DIR__ . '/../includes/rate-limiter.php';

// Authentification (token API ou session admin) et rate limiting
checkRateLimit();
requireApiAuthOrAdmin();

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['id'])) {
    echo json_encode(['success' => false, 'error' => 'ID manquant']);
    exit;
}

$id = intval($input['id']);

// Update is_active
if (isset($input['is_active'])) {
    $stmt = $pdo->prepare("UPDATE email_templates SET is_active = ? WHERE id = ?");
    $stmt->execute([$input['is_active'] ? 1 : 0, $id]);
}

// Update subject and body
if (isset($input['subject']) || isset($input['body_html'])) {
    $updates = [];
    $params = [];
    
    if (isset($input['subject'])) {
        $updates[] = "subject = ?";
        $params[] = $input['subject'];
    }
    if (isset($input['body_html'])) {
        $updates[] = "body_html = ?";
        $params[] = $input['body_html'];
    }
    if (isset($input['delay_minutes'])) {
        $updates[] = "delay_minutes = ?";
        $params[] = intval($input['delay_minutes']);
    }
    
    $params[] = $id;
    $stmt = $pdo->prepare("UPDATE email_templates SET " . implode(', ', $updates) . " WHERE id = ?");
    $stmt->execute($params);
}

echo json_encode(['success' => true]);