<?php

declare(strict_types=1);

const API_ERROR_MESSAGES = [
    'method_not_allowed' => 'Méthode non autorisée',
    'invalid_payload' => 'Payload invalide',
    'missing_or_invalid_fields' => 'Champs requis manquants ou invalides',
    'invalid_email' => 'Email invalide',
    'missing_id' => 'id manquant',
    'no_updates' => 'Aucune mise à jour',
    'invalid_event_key' => 'event_key invalide',
    'unknown_action' => 'Action inconnue',
    'unexpected_error' => 'Une erreur inattendue est survenue',
];

/**
 * @param array<string, mixed> $payload
 */
function api_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode($payload);
}

/**
 * @param array<string, mixed> $extra
 */
function api_error(string $key, int $statusCode = 400, array $extra = []): void
{
    $message = API_ERROR_MESSAGES[$key] ?? API_ERROR_MESSAGES['unexpected_error'];
    api_json_response(array_merge(['ok' => false, 'error' => $message], $extra), $statusCode);
}

function api_sanitize_string(?string $value): string
{
    return trim(strip_tags((string) $value));
}
