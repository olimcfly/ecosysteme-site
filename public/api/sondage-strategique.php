<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';
require_once __DIR__ . '/../../lib/survey_insights.php';
require_once __DIR__ . '/_helpers.php';


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    api_error('method_not_allowed', 405);
    exit;
}

/** @var array<string, mixed> $payload */
$payload = json_decode(file_get_contents('php://input'), true) ?: [];

$email = filter_var((string) ($payload['email'] ?? ''), FILTER_SANITIZE_EMAIL) ?: '';
$nom = api_sanitize_string((string) ($payload['nom'] ?? ''));
$city = api_sanitize_string((string) ($payload['city'] ?? ''));
$phone = api_sanitize_string((string) ($payload['phone'] ?? ''));
$source = api_sanitize_string((string) ($payload['source'] ?? 'sondage_conseillers_2026'));
$surveyAnswers = is_array($payload['survey_answers'] ?? null) ? $payload['survey_answers'] : [];

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    api_error('invalid_email', 422);
    exit;
}

if ($nom === '') {
    $emailParts = explode('@', $email);
    $nom = isset($emailParts[0]) ? ucfirst(str_replace(['.', '_', '-'], ' ', $emailParts[0])) : 'Conseiller immobilier';
}

$lead = crm_create_lead([
    'nom' => $nom,
    'email' => $email,
    'phone' => $phone,
    'city' => $city,
    'source' => $source,
]);

$submissionId = bin2hex(random_bytes(8));
$accessToken = bin2hex(random_bytes(16));

$submission = [
    'id' => $submissionId,
    'access_token_hash' => hash('sha256', $accessToken),
    'lead_id' => $lead['id'] ?? null,
    'nom' => $nom,
    'email' => $email,
    'city' => $city,
    'phone' => $phone,
    'source' => $source,
    'status' => 'nouveau',
    'survey_answers' => $surveyAnswers,
    'created_at' => gmdate('c'),
];
$submission['analysis'] = survey_compute_analysis($submission);

survey_storage_save_submission($submission);

$resultUrl = '/pages/sondage-conseillers/resultat.php?id=' . urlencode($submissionId) . '&token=' . urlencode($accessToken);

api_json_response([
    'ok' => true,
    'lead_id' => $lead['id'] ?? null,
    'submission_id' => $submissionId,
    'result_url' => $resultUrl,
]);
