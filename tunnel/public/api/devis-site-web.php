<?php
/**
 * API formulaire devis site web
 * Workflow prévu : Formulaire -> API -> OpenAI -> Réponse auto -> CRM
 */

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

$payload = json_decode(file_get_contents('php://input'), true);
if (!$payload) {
    $payload = $_POST;
}

$lead = [
    'langue' => trim((string)($payload['langue'] ?? 'fr')),
    'nom' => trim((string)($payload['nom'] ?? '')),
    'activite' => trim((string)($payload['activite'] ?? '')),
    'ville' => trim((string)($payload['ville'] ?? '')),
    'type_site' => trim((string)($payload['type_site'] ?? '')),
    'objectif' => trim((string)($payload['objectif'] ?? '')),
    'site_actuel' => trim((string)($payload['site_actuel'] ?? '')),
    'message' => trim((string)($payload['message'] ?? '')),
    'delai' => trim((string)($payload['delai'] ?? '')),
];

$requiredFields = ['langue', 'nom', 'activite', 'ville', 'type_site', 'objectif', 'site_actuel', 'message', 'delai'];
foreach ($requiredFields as $field) {
    if ($lead[$field] === '') {
        http_response_code(422);
        echo json_encode(['ok' => false, 'error' => 'Champs requis manquants']);
        exit;
    }
}

function containsWord(string $value, array $terms): bool
{
    $normalized = mb_strtolower($value, 'UTF-8');
    foreach ($terms as $term) {
        if (mb_strpos($normalized, mb_strtolower($term, 'UTF-8')) !== false) {
            return true;
        }
    }
    return false;
}

$score = 0;

if (containsWord($lead['activite'], ['immobilier', 'conseiller immobilier', 'real estate'])) {
    $score += 20;
}

if (containsWord($lead['objectif'], ['prospect', 'lead'])) {
    $score += 20;
}

if (containsWord($lead['delai'], ['urgent'])) {
    $score += 30;
}

if (mb_strlen($lead['message'], 'UTF-8') >= 40) {
    $score += 10;
}

$score = min($score, 100);

$recommendation = [
    'fr' => "Merci {$lead['nom']}, nous vous recommandons un site orienté conversion avec SEO local et automatisation des demandes.",
    'en' => "Thanks {$lead['nom']}, we recommend a conversion-focused website with local SEO and request automation.",
];

// Point d'intégration futur: OpenAI + webhook CRM + envoi email/WhatsApp
// Exemple: POST vers Make/Zapier/HubSpot avec $lead, $score et la recommandation.

http_response_code(200);
echo json_encode([
    'ok' => true,
    'score' => $score,
    'lead_temperature' => $score >= 60 ? 'hot' : 'warm',
    'recommendation' => $recommendation[$lead['langue']] ?? $recommendation['fr'],
    'stored' => [
        'langue' => $lead['langue'],
        'activite' => $lead['activite'],
        'ville' => $lead['ville'],
        'type_site' => $lead['type_site'],
        'objectif' => $lead['objectif'],
        'message' => $lead['message'],
        'delai' => $lead['delai'],
    ],
]);
