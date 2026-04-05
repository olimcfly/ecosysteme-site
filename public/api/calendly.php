<?php

declare(strict_types=1);

const CALENDLY_STORAGE_DIR = __DIR__ . '/../../storage';
const CALENDLY_LEADS_FILE = CALENDLY_STORAGE_DIR . '/leads.json';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Calendly-Webhook-Signature, X-Calendly-Webhook-Signature');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Méthode non autorisée']);
    exit;
}

$rawBody = file_get_contents('php://input') ?: '';
$payload = json_decode($rawBody, true);
$signature = (string) ($_SERVER['HTTP_CALENDLY_WEBHOOK_SIGNATURE'] ?? $_SERVER['HTTP_X_CALENDLY_WEBHOOK_SIGNATURE'] ?? '');

if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Payload JSON invalide']);
    exit;
}

try {
    if (!verify_calendly_signature($rawBody, $signature)) {
        throw new RuntimeException('Signature invalide');
    }

    $eventType = extract_event_type($payload);
    $inviteeEmail = extract_invitee_email($payload);

    if ($inviteeEmail === '') {
        throw new RuntimeException('Email invité introuvable dans le payload');
    }

    $updated = false;

    if ($eventType === 'invitee.created') {
        $updated = update_lead_status_by_email($inviteeEmail, 'rdv_pris');
    } elseif ($eventType === 'invitee.canceled') {
        $updated = update_lead_status_by_email($inviteeEmail, 'rdv_annule');
    }

    http_response_code(200);
    echo json_encode([
        'ok' => true,
        'event' => $eventType,
        'email' => $inviteeEmail,
        'updated' => $updated,
    ]);
} catch (Throwable $e) {
    http_response_code(400);
    error_log('Calendly webhook error: ' . $e->getMessage());
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}

function verify_calendly_signature(string $rawBody, string $headerValue): bool
{
    $secret = (string) getenv('CALENDLY_WEBHOOK_SIGNING_KEY');

    if ($secret === '') {
        return false;
    }

    if ($headerValue === '') {
        return false;
    }

    $parts = [];
    foreach (explode(',', $headerValue) as $segment) {
        $bits = explode('=', trim($segment), 2);
        if (count($bits) === 2) {
            $parts[$bits[0]] = $bits[1];
        }
    }

    $timestamp = (string) ($parts['t'] ?? '');
    $signature = (string) ($parts['v1'] ?? '');

    if ($timestamp === '' || $signature === '') {
        return false;
    }

    $signedPayload = $timestamp . '.' . $rawBody;
    $expected = hash_hmac('sha256', $signedPayload, $secret);

    return hash_equals($expected, $signature);
}

function extract_event_type(array $payload): string
{
    if (isset($payload['event']) && is_string($payload['event'])) {
        return $payload['event'];
    }

    return (string) ($payload['event_type'] ?? '');
}

function extract_invitee_email(array $payload): string
{
    $email = $payload['payload']['email']
        ?? $payload['payload']['invitee']['email']
        ?? $payload['email']
        ?? '';

    $email = trim((string) $email);

    return filter_var($email, FILTER_VALIDATE_EMAIL) ? strtolower($email) : '';
}

function update_lead_status_by_email(string $email, string $status): bool
{
    if (!is_file(CALENDLY_LEADS_FILE)) {
        return false;
    }

    $raw = file_get_contents(CALENDLY_LEADS_FILE);
    $leads = json_decode($raw ?: '[]', true);

    if (!is_array($leads)) {
        return false;
    }

    $updated = false;

    foreach ($leads as &$lead) {
        $leadEmail = strtolower(trim((string) ($lead['email'] ?? '')));
        if ($leadEmail !== $email) {
            continue;
        }

        $lead['status'] = $status;
        $lead['updated_at'] = gmdate('c');

        if (!isset($lead['automation']) || !is_array($lead['automation'])) {
            $lead['automation'] = [];
        }

        if ($status === 'rdv_pris') {
            $lead['automation']['rdv_taken_at'] = $lead['automation']['rdv_taken_at'] ?? gmdate('c');
            $lead['automation']['stopped_at'] = gmdate('c');
        }

        if ($status === 'rdv_annule') {
            $lead['automation']['rdv_taken_at'] = null;
        }

        $updated = true;
    }
    unset($lead);

    if ($updated) {
        file_put_contents(
            CALENDLY_LEADS_FILE,
            json_encode($leads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }

    return $updated;
}
