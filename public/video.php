<?php
header('Content-Type: application/json');

// Configuration initiale
const REQUIRED_FIELDS = [
    '1' => ['email'],
    '2' => ['email', 'name', 'phone', 'lead_id']
];

// 1. Vérification initiale
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// 2. Chargement des dépendances
try {
    require_once __DIR__ . '/../config/loader.php';
    $pdo = ConfigLoader::getPDO();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur de configuration']);
    exit;
}

// 3. Récupération et validation des données
$step = filter_input(INPUT_POST, 'step', FILTER_SANITIZE_STRING) ?? '';
$leadId = filter_input(INPUT_POST, 'lead_id', FILTER_SANITIZE_STRING);
$source = filter_input(INPUT_POST, 'source', FILTER_SANITIZE_STRING) ?? 'unknown';

// Validation de l'étape
if (!in_array($step, ['1', '2', '3'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Étape invalide']);
    exit;
}

// Validation des champs requis
$missingFields = [];
foreach (REQUIRED_FIELDS[$step] ?? [] as $field) {
    if (empty($_POST[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Champs manquants: ' . implode(', ', $missingFields)
    ]);
    exit;
}

// Sanitization des données
$data = [
    'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
    'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
    'phone' => preg_replace('/[^0-9+]/', '', $_POST['phone'] ?? ''),
    'agency' => filter_input(INPUT_POST, 'agency', FILTER_SANITIZE_STRING),
    'challenge' => filter_input(INPUT_POST, 'challenge', FILTER_SANITIZE_STRING),
    'source' => $source
];

// Validation supplémentaire
if ($step === '1' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email invalide']);
    exit;
}

if ($step === '2' && !preg_match('/^(\+33|0)[1-9](\d{2}){4}$/', $data['phone'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Numéro de téléphone invalide']);
    exit;
}

// 4. Traitement selon l'étape
try {
    switch ($step) {
        case '1': // Étape 1: Lead intéressé
            $leadId = handleStep1($pdo, $data);
            triggerEmailCampaign($leadId, 'interesse');
            break;

        case '2': // Étape 2: Lead qualifié
            handleStep2($pdo, $leadId, $data);
            triggerEmailCampaign($leadId, 'qualifie');
            break;

        case '3': // Étape 3: RDV confirmé (webhook Calendly)
            // Ce cas est géré par un webhook séparé
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Utilisez le webhook Calendly']);
            exit;
    }

    echo json_encode([
        'success' => true,
        'lead_id' => $leadId,
        'message' => 'Lead enregistré avec succès'
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    error_log("Erreur PDO: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur de base de données']);
} catch (Exception $e) {
    http_response_code(500);
    error_log("Erreur: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Une erreur est survenue']);
}

/**
 * Gère l'étape 1: Création ou mise à jour du lead
 */
function handleStep1(PDO $pdo, array $data): string {
    // Vérifier si le lead existe déjà
    $stmt = $pdo->prepare("SELECT id FROM leads WHERE email = ?");
    $stmt->execute([$data['email']]);
    $existingLead = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingLead) {
        // Mettre à jour le lead existant
        $stmt = $pdo->prepare("UPDATE leads SET step = 1, source = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$data['source'], $existingLead['id']]);
        return $existingLead['id'];
    }

    // Créer un nouveau lead
    $stmt = $pdo->prepare("
        INSERT INTO leads (email, step, source, created_at, updated_at)
        VALUES (?, 1, ?, NOW(), NOW())
    ");
    $stmt->execute([$data['email'], $data['source']]);
    return $pdo->lastInsertId();
}

/**
 * Gère l'étape 2: Mise à jour du lead qualifié
 */
function handleStep2(PDO $pdo, string $leadId, array $data): void {
    $stmt = $pdo->prepare("
        UPDATE leads
        SET name = ?,
            phone = ?,
            agency = ?,
            challenge = ?,
            step = 2,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([
        $data['name'],
        $data['phone'],
        $data['agency'],
        $data['challenge'],
        $leadId
    ]);
}

/**
 * Déclenche une campagne email
 */
function triggerEmailCampaign(string $leadId, string $campaignType): void {
    // Implémentez ici votre logique d'envoi d'email
    // Exemple avec Mailchimp, Sendinblue, ou votre propre système

    // Pour cet exemple, on log simplement l'action
    error_log("Campagne '$campaignType' déclenchée pour lead ID: $leadId");

    // Exemple d'intégration avec un service d'email:
    /*
    $emailService = new EmailService();
    $emailService->sendCampaign(
        $leadId,
        $campaignType,
        [
            'lead_id' => $leadId,
            'campaign' => $campaignType
        ]
    );
    */
}
