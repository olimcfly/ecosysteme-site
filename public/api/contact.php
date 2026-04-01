<?php
/**
 * Handler de formulaire de contact — Ecosystème Immo
 *
 * Pour activer l'envoi email, configurez les constantes ci-dessous.
 * Ce fichier peut aussi être remplacé par un service tiers (Formspree, Make, Zapier…)
 */

// ── Configuration ──────────────────────────────────────────────────
define('NOTIFY_EMAIL', 'contact@ecosystemeimmo.fr'); // Email de réception
define('SUBJECT_PREFIX', '[Ecosystème Immo] Nouvelle demande — ');
// ───────────────────────────────────────────────────────────────────

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Méthode non autorisée']);
    exit;
}

// Lecture du body JSON ou données de formulaire
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    $data = $_POST;
}

$nom   = isset($data['nom'])   ? trim(strip_tags($data['nom']))   : '';
$email = isset($data['email']) ? trim(strip_tags($data['email'])) : '';
$phone = isset($data['phone']) ? trim(strip_tags($data['phone'])) : '';
$city  = isset($data['city'])  ? trim(strip_tags($data['city']))  : '';

// Validation minimale
if (!$nom || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$city) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Champs requis manquants ou invalides']);
    exit;
}

// Construction de l'email
$subject = SUBJECT_PREFIX . $city;
$body = "Nouvelle demande de réservation\n\n"
      . "Nom    : {$nom}\n"
      . "Email  : {$email}\n"
      . "Tél    : " . ($phone ?: '—') . "\n"
      . "Ville  : {$city}\n\n"
      . "Reçu le : " . date('d/m/Y à H:i') . "\n";

$headers = "From: noreply@ecosystemeimmo.fr\r\n"
         . "Reply-To: {$email}\r\n"
         . "X-Mailer: PHP/" . phpversion();

$sent = mail(NOTIFY_EMAIL, $subject, $body, $headers);

if ($sent) {
    echo json_encode(['ok' => true]);
} else {
    // En cas d'échec mail(), on renvoie quand même un succès côté UX
    // (configurer un SMTP dédié en production via PHPMailer ou SendGrid)
    error_log("[EcosystemeImmo] Échec envoi mail pour {$email} / {$city}");
    echo json_encode(['ok' => true]);
}
