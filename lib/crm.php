<?php

declare(strict_types=1);

const CRM_STORAGE_DIR = __DIR__ . '/../storage';
const CRM_LEADS_FILE = CRM_STORAGE_DIR . '/leads.json';
const CRM_EMAIL_LOG_FILE = CRM_STORAGE_DIR . '/email_log.json';
const CRM_EVENTS_FILE = CRM_STORAGE_DIR . '/events.json';

/**
 * @return array<int, array<string, mixed>>
 */
function crm_load_json(string $path): array
{
    if (!file_exists($path)) {
        return [];
    }

    $raw = file_get_contents($path);
    if ($raw === false || $raw === '') {
        return [];
    }

    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

/**
 * @param array<int, array<string, mixed>> $payload
 */
function crm_save_json(string $path, array $payload): void
{
    if (!is_dir(CRM_STORAGE_DIR)) {
        mkdir(CRM_STORAGE_DIR, 0775, true);
    }

    file_put_contents($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * @return array<int, array<string, mixed>>
 */
function crm_get_leads(): array
{
    $leads = crm_load_json(CRM_LEADS_FILE);
    $events = crm_get_events();

    usort($leads, static function (array $a, array $b): int {
        return strcmp((string) ($b['created_at'] ?? ''), (string) ($a['created_at'] ?? ''));
    });

    foreach ($leads as &$lead) {
        $leadEvents = [];
        foreach ($events as $event) {
            if (($event['lead_id'] ?? '') === ($lead['id'] ?? '')) {
                $leadEvents[] = $event;
            }
        }
        $lead['timeline'] = $leadEvents;
    }
    unset($lead);

    return $leads;
}

function crm_find_lead(string $leadId): ?array
{
    foreach (crm_get_leads() as $lead) {
        if (($lead['id'] ?? '') === $leadId) {
            return $lead;
        }
    }

    return null;
}

function crm_create_lead(array $payload): array
{
    $leads = crm_get_leads();
    $lead = [
        'id' => bin2hex(random_bytes(8)),
        'nom' => $payload['nom'],
        'email' => $payload['email'],
        'phone' => $payload['phone'] ?? '',
        'city' => $payload['city'],
        'status' => 'nouveau',
        'score' => crm_compute_score($payload),
        'source' => 'landing_ecosystemeimmo',
        'visitor_id' => $payload['visitor_id'] ?? null,
        'notes' => '',
        'created_at' => gmdate('c'),
        'email_sequence' => crm_build_email_sequence(),
    ];

    $leads[] = $lead;
    crm_save_json(CRM_LEADS_FILE, $leads);

    return $lead;
}

/**
 * @return array<int, array<string, mixed>>
 */
function crm_get_events(): array
{
    $events = crm_load_json(CRM_EVENTS_FILE);

    usort($events, static function (array $a, array $b): int {
        return strcmp((string) ($b['created_at'] ?? ''), (string) ($a['created_at'] ?? ''));
    });

    return $events;
}

function crm_compute_status_from_event(string $currentStatus, string $eventKey): string
{
    $allowed = ['nouveau', 'qualifie', 'rdv_planifie', 'close', 'perdu'];
    if (!in_array($currentStatus, $allowed, true)) {
        $currentStatus = 'nouveau';
    }

    if ($eventKey === 'rdv_pris') {
        return 'rdv_planifie';
    }

    if ($eventKey === 'formulaire_rempli' && $currentStatus === 'nouveau') {
        return 'qualifie';
    }

    return $currentStatus;
}

function crm_update_status_from_event(string $leadId, string $eventKey): void
{
    $leads = crm_get_leads();
    $updated = false;

    foreach ($leads as &$lead) {
        if (($lead['id'] ?? '') !== $leadId) {
            continue;
        }

        $newStatus = crm_compute_status_from_event((string) ($lead['status'] ?? 'nouveau'), $eventKey);
        if ($newStatus !== ($lead['status'] ?? '')) {
            $lead['status'] = $newStatus;
            $lead['updated_at'] = gmdate('c');
            $updated = true;
        }
        break;
    }
    unset($lead);

    if ($updated) {
        crm_save_json(CRM_LEADS_FILE, $leads);
    }
}

function crm_track_event(string $eventKey, string $eventLabel, array $payload = []): array
{
    $events = crm_get_events();
    $event = [
        'id' => bin2hex(random_bytes(8)),
        'event_key' => $eventKey,
        'event_label' => $eventLabel,
        'lead_id' => $payload['lead_id'] ?? null,
        'visitor_id' => $payload['visitor_id'] ?? null,
        'page' => $payload['page'] ?? null,
        'meta' => is_array($payload['meta'] ?? null) ? $payload['meta'] : [],
        'created_at' => gmdate('c'),
    ];

    $events[] = $event;
    crm_save_json(CRM_EVENTS_FILE, $events);

    if (!empty($event['lead_id'])) {
        crm_update_status_from_event((string) $event['lead_id'], $eventKey);
    }

    return $event;
}

function crm_attach_visitor_events_to_lead(string $visitorId, string $leadId): int
{
    if ($visitorId === '' || $leadId === '') {
        return 0;
    }

    $events = crm_get_events();
    $updatedCount = 0;

    foreach ($events as &$event) {
        if (($event['visitor_id'] ?? '') !== $visitorId || !empty($event['lead_id'])) {
            continue;
        }

        $event['lead_id'] = $leadId;
        $updatedCount++;
    }
    unset($event);

    if ($updatedCount > 0) {
        crm_save_json(CRM_EVENTS_FILE, $events);
    }

    return $updatedCount;
}

function crm_compute_score(array $payload): int
{
    $score = 35;
    if (!empty($payload['phone'])) {
        $score += 20;
    }

    if (!empty($payload['city']) && mb_strlen(trim((string) $payload['city'])) >= 4) {
        $score += 20;
    }

    if (!empty($payload['nom']) && str_word_count((string) $payload['nom']) >= 2) {
        $score += 25;
    }

    return min($score, 100);
}

/**
 * @return array<int, array<string, mixed>>
 */
function crm_build_email_sequence(): array
{
    $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    $steps = [
        [
            'delay_days' => 0,
            'subject' => 'Bienvenue dans ECOSYSTEMEIMMO — Vérification de votre zone',
            'body' => "Bonjour {{nom}},\n\nMerci pour votre demande. Nous vérifions la disponibilité de votre zone ({{city}}).\n\nDans les prochaines heures, vous recevrez un plan d'action clair pour gagner en visibilité locale et capter des vendeurs qualifiés.",
        ],
        [
            'delay_days' => 1,
            'subject' => 'Pourquoi les conseillers visibles signent plus vite',
            'body' => "Bonjour {{nom}},\n\nRappel clé : ce n'est pas le niveau qui fait la différence, c'est la visibilité.\n\nSans preuve sociale locale, même un excellent conseiller reste invisible.\n\nNous vous montrons comment corriger cela sur votre secteur.",
        ],
        [
            'delay_days' => 3,
            'subject' => 'Votre plan local en 3 étapes (SEO + CRM + automatisation)',
            'body' => "Bonjour {{nom}},\n\nVoici le plan recommandé :\n1) Positionnement local\n2) Capture des leads\n3) Suivi automatisé\n\nCe système vous permet de ne plus dépendre des plateformes et de construire un actif durable.",
        ],
        [
            'delay_days' => 5,
            'subject' => 'Dernier rappel — valider votre zone avant fermeture',
            'body' => "Bonjour {{nom}},\n\nNous finalisons les zones en cours.\n\nSi vous souhaitez réserver {{city}}, répondez à cet email pour bloquer votre créneau d'appel stratégique.",
        ],
    ];

    return array_map(static function (array $step) use ($now): array {
        $dueAt = $now->modify('+' . (int) $step['delay_days'] . ' days')->format('c');

        return [
            'id' => bin2hex(random_bytes(6)),
            'subject' => $step['subject'],
            'body' => $step['body'],
            'due_at' => $dueAt,
            'sent_at' => null,
            'status' => 'pending',
        ];
    }, $steps);
}

function crm_update_lead(string $leadId, array $updates): bool
{
    $leads = crm_get_leads();
    $updated = false;

    foreach ($leads as &$lead) {
        if (($lead['id'] ?? '') !== $leadId) {
            continue;
        }

        if (isset($updates['status'])) {
            $allowed = ['nouveau', 'qualifie', 'rdv_planifie', 'close', 'perdu'];
            if (in_array($updates['status'], $allowed, true)) {
                $lead['status'] = $updates['status'];
            }
        }

        if (isset($updates['notes'])) {
            $lead['notes'] = trim((string) $updates['notes']);
        }

        $lead['updated_at'] = gmdate('c');
        $updated = true;
        break;
    }

    if ($updated) {
        crm_save_json(CRM_LEADS_FILE, $leads);
    }

    return $updated;
}

function crm_render_template(string $text, array $lead): string
{
    return strtr($text, [
        '{{nom}}' => (string) ($lead['nom'] ?? ''),
        '{{city}}' => (string) ($lead['city'] ?? ''),
    ]);
}

function crm_send_due_sequence_emails(): array
{
    $leads = crm_get_leads();
    $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    $sentCount = 0;
    $errors = [];
    $emailLog = crm_load_json(CRM_EMAIL_LOG_FILE);

    foreach ($leads as &$lead) {
        if (empty($lead['email_sequence']) || !is_array($lead['email_sequence'])) {
            continue;
        }

        foreach ($lead['email_sequence'] as &$step) {
            if (($step['status'] ?? 'pending') !== 'pending') {
                continue;
            }

            $dueAt = new DateTimeImmutable((string) $step['due_at']);
            if ($dueAt > $now) {
                continue;
            }

            $subject = crm_render_template((string) $step['subject'], $lead);
            $body = crm_render_template((string) $step['body'], $lead);
            $email = (string) ($lead['email'] ?? '');

            $headers = "From: noreply@ecosystemeimmo.fr\r\n"
                . "Reply-To: contact@ecosystemeimmo.fr\r\n"
                . 'X-Mailer: PHP/' . phpversion();

            $sent = filter_var($email, FILTER_VALIDATE_EMAIL) ? mail($email, $subject, $body, $headers) : false;

            if ($sent) {
                $step['status'] = 'sent';
                $step['sent_at'] = gmdate('c');
                $sentCount++;
                $emailLog[] = [
                    'lead_id' => $lead['id'],
                    'email' => $email,
                    'subject' => $subject,
                    'sent_at' => $step['sent_at'],
                ];
            } else {
                $step['status'] = 'error';
                $errors[] = 'Échec envoi pour ' . $email . ' / étape ' . ($step['id'] ?? '');
            }
        }
        unset($step);
    }
    unset($lead);

    crm_save_json(CRM_LEADS_FILE, $leads);
    crm_save_json(CRM_EMAIL_LOG_FILE, $emailLog);

    return [
        'sent' => $sentCount,
        'errors' => $errors,
    ];
}
