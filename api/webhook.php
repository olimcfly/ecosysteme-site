<?php
/**
 * Webhook Stripe sécurisé
 * Reçoit les événements de paiement depuis Stripe
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

// Fonction de logging
function log_webhook($message, $data = []) {
    $log_file = __DIR__ . '/../logs/webhook.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[{$timestamp}] {$message}";
    
    if (!empty($data)) {
        $log_entry .= "\n" . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
    $log_entry .= "\n" . str_repeat('=', 80) . "\n";
    
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

// ============================================
// 1. VÉRIFIER LA REQUÊTE
// ============================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    log_webhook('❌ Méthode non autorisée', ['method' => $_SERVER['REQUEST_METHOD']]);
    exit;
}

// Récupérer le corps brut
$input = file_get_contents('php://input');

// Logs de débogage
log_webhook('📥 Requête reçue', [
    'headers' => getallheaders(),
    'body_size' => strlen($input),
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'undefined'
]);

// ============================================
// 2. VALIDER LA SIGNATURE STRIPE
// ============================================

$stripe_webhook_secret = STRIPE_WEBHOOK_SECRET;

if (empty($stripe_webhook_secret)) {
    http_response_code(500);
    echo json_encode(['error' => 'Webhook secret not configured']);
    log_webhook('❌ Webhook secret manquant');
    exit;
}

// Récupérer le header de signature
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null;

if (!$sig_header) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing stripe-signature header']);
    log_webhook('❌ Header stripe-signature manquant');
    exit;
}

// Vérifier la signature
try {
    $event = \Stripe\Webhook::constructEvent(
        $input,
        $sig_header,
        $stripe_webhook_secret
    );
    log_webhook('✅ Signature valide', ['event_type' => $event->type]);
} catch (\UnexpectedValueException $e) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    log_webhook('❌ Payload invalide', ['error' => $e->getMessage()]);
    exit;
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid signature']);
    log_webhook('❌ Signature invalide', ['error' => $e->getMessage()]);
    exit;
}

// ============================================
// 3. TRAITER L'ÉVÉNEMENT
// ============================================

try {
    \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
    
    switch ($event->type) {
        
        // ===== PAIEMENT RÉUSSI =====
        case 'payment_intent.succeeded':
            $payment_intent = $event->data->object;
            handle_payment_succeeded($payment_intent);
            break;
        
        // ===== SESSION COMPLÉTÉE (CHECKOUT) =====
        case 'checkout.session.completed':
            $session = $event->data->object;
            handle_checkout_completed($session);
            break;
        
        // ===== PAIEMENT ÉCHOUÉ =====
        case 'payment_intent.payment_failed':
            $payment_intent = $event->data->object;
            handle_payment_failed($payment_intent);
            break;
        
        // ===== REMBOURSEMENT =====
        case 'charge.refunded':
            $charge = $event->data->object;
            handle_refund($charge);
            break;
        
        // ===== ÉVÉNEMENT NON GÉRÉ =====
        default:
            log_webhook('⚠️ Événement non géré', ['type' => $event->type]);
    }
    
    http_response_code(200);
    echo json_encode(['success' => true, 'event' => $event->type]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    log_webhook('❌ Erreur traitement', ['error' => $e->getMessage()]);
}

// ============================================
// 4. HANDLERS DES ÉVÉNEMENTS
// ============================================

function handle_payment_succeeded($payment_intent) {
    global $pdo;
    
    $metadata = $payment_intent->metadata;
    $email = $payment_intent->receipt_email ?? $metadata->email ?? null;
    $guide_id = $metadata->guide_id ?? null;
    $customer_name = $metadata->customer_name ?? 'Unknown';
    
    log_webhook('💳 Paiement réussi', [
        'payment_intent_id' => $payment_intent->id,
        'amount' => $payment_intent->amount / 100 . ' €',
        'email' => $email,
        'guide_id' => $guide_id
    ]);
    
    if (!$email || !$guide_id) {
        log_webhook('⚠️ Métadonnées incomplètes', $metadata->jsonSerialize());
        return;
    }
    
    try {
        // Créer un token de téléchargement
        require_once __DIR__ . '/../config.php';
        
        $token = generate_token();
        $expires_at = date('Y-m-d H:i:s', strtotime('+' . TOKEN_EXPIRY_HOURS . ' hours'));
        
        $stmt = $pdo->prepare("
            INSERT INTO download_tokens 
            (token, email, guide_id, payment_id, expires_at, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([$token, $email, $guide_id, $payment_intent->id, $expires_at]);
        
        log_webhook('✅ Token créé', [
            'token' => substr($token, 0, 10) . '***',
            'email' => $email,
            'expires_at' => $expires_at
        ]);
        
        // Envoyer l'email avec le lien de téléchargement
        send_download_email(
            $email,
            $customer_name,
            $guide_id,
            $token
        );
        
        log_webhook('📧 Email envoyé', ['email' => $email]);
        
    } catch (Exception $e) {
        log_webhook('❌ Erreur création token', ['error' => $e->getMessage()]);
    }
}

function handle_checkout_completed($session) {
    log_webhook('✅ Checkout complété', [
        'session_id' => $session->id,
        'payment_status' => $session->payment_status,
        'customer_email' => $session->customer_email
    ]);
    
    // Le payment_intent.succeeded sera aussi déclenché
    // Pas besoin de traiter deux fois
}

function handle_payment_failed($payment_intent) {
    log_webhook('❌ Paiement échoué', [
        'payment_intent_id' => $payment_intent->id,
        'last_payment_error' => $payment_intent->last_payment_error,
        'email' => $payment_intent->receipt_email
    ]);
    
    // Optionnel : envoyer un email à l'utilisateur
    $email = $payment_intent->receipt_email;
    if ($email) {
        $subject = "Votre paiement a échoué - Écosystème Immo";
        $message = "Votre paiement n'a pas pu être traité. Veuillez réessayer.";
        mail($email, $subject, $message);
    }
}

function handle_refund($charge) {
    log_webhook('💰 Remboursement', [
        'charge_id' => $charge->id,
        'amount_refunded' => $charge->amount_refunded / 100 . ' €',
        'receipt_url' => $charge->receipt_url
    ]);
}

?>