<?php
require_once '../vendor/autoload.php';

header('Content-Type: application/json');

$stripe_secret = 'sk_live_VOTRE_CLE_SECRETE'; // À remplacer
\Stripe\Stripe::setApiKey($stripe_secret);

try {
    $input = json_decode(file_get_contents('php://input'), true);

    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $input['montant'] * 120, // Montant TTC en centimes
        'currency' => 'eur',
        'description' => 'Guide : ' . $input['guide_id'],
        'metadata' => [
            'guide_id' => $input['guide_id'],
            'email' => $input['email'],
            'prenom' => $input['prenom'],
            'nom' => $input['nom']
        ],
        'receipt_email' => $input['email']
    ]);

    echo json_encode(['client_secret' => $paymentIntent->client_secret]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
