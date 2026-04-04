<?php

declare(strict_types=1);

const CRM_STORAGE_DIR = __DIR__ . '/../storage';
const CRM_LEADS_FILE = CRM_STORAGE_DIR . '/leads.json';
const CRM_EMAIL_LOG_FILE = CRM_STORAGE_DIR . '/email_log.json';
const CRM_EMAIL_QUEUE_FILE = CRM_STORAGE_DIR . '/email_queue.json';

/**
 * Connexion PDO MySQL pour le CRM.
 */
function crm_db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $name = getenv('DB_NAME') ?: 'ecosystemeimmo';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';

    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $name);

/**
 * @return array<int, array<string, mixed>>
 */
function crm_get_leads(): array
{
    $leads = crm_load_json(CRM_LEADS_FILE);
    $events = crm_get_events();

    crm_ensure_schema($pdo);

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

function crm_ensure_schema(PDO $pdo): void
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS contacts (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(150) NOT NULL,
            email VARCHAR(190) NOT NULL,
            telephone VARCHAR(40) DEFAULT NULL,
            ville VARCHAR(120) NOT NULL,
            source VARCHAR(120) DEFAULT NULL,
            statut_tunnel VARCHAR(50) NOT NULL DEFAULT "nouveau",
            date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_ville (ville),
            INDEX idx_statut_tunnel (statut_tunnel),
            INDEX idx_date_creation (date_creation)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
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
        'estimated_amount' => 0,
        'created_at' => gmdate('c'),
        'automation' => [
            'video_viewed' => false,
            'offer_viewed' => false,
            'meeting_booked' => false,
            'stopped_at' => null,
        ],
        'email_sequence' => crm_build_email_sequence(),
    ];

    $id = (int) $pdo->lastInsertId();

    return crm_find_contact($id) ?? [];
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
    $pdo = crm_db();
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);

    $row = $stmt->fetch();
    return is_array($row) ? $row : null;
}

/**
 * @return array<int, array<string, mixed>>
 */
function crm_get_contacts(array $filters = []): array
{
    $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    $steps = [
        [
            'delay_days' => 0,
            'key' => 'video_access',
            'subject' => 'Vidéo offerte : méthode locale pour générer des vendeurs',
            'body' => "Bonjour {{nom}},\n\nVoici votre accès à la vidéo stratégique pour {{city}} : {{video_url}}\n\nRegardez-la maintenant pour poser les bases de votre système local.",
        ],
        [
            'delay_days' => 1,
            'key' => 'video_reminder',
            'subject' => 'Rappel vidéo : 15 min qui peuvent changer votre prospection',
            'body' => "Bonjour {{nom}},\n\nPetit rappel : votre accès vidéo est ici {{video_url}}\n\nSi vous ne l'avez pas encore vue, prenez 15 minutes aujourd'hui.",
        ],
        [
            'delay_days' => 3,
            'key' => 'offer',
            'subject' => 'Offre : plan d\'implémentation SEO + CRM + automatisation',
            'body' => "Bonjour {{nom}},\n\nNous avons préparé votre plan d'action local. Détails ici : {{offer_url}}\n\nSi c'est pertinent pour vous, réservez un RDV : {{booking_url}}",
        ],
        [
            'delay_days' => 5,
            'key' => 'urgency',
            'subject' => 'Dernière relance : les créneaux d\'accompagnement se ferment',
            'body' => "Bonjour {{nom}},\n\nDernier rappel avant fermeture des créneaux sur {{city}}.\n\nVoir l'offre : {{offer_url}}\nRéserver un RDV : {{booking_url}}",
        ],
    ];

    return array_map(static function (array $step) use ($now): array {
        $dueAt = $now->modify('+' . (int) $step['delay_days'] . ' days')->format('c');

        return [
            'id' => bin2hex(random_bytes(6)),
            'key' => $step['key'],
            'subject' => $step['subject'],
            'body' => $step['body'],
            'due_at' => $dueAt,
            'sent_at' => null,
            'status' => 'pending',
            'open_count' => 0,
            'click_count' => 0,
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
            $allowed = [
                'nouveau',
                'video_non_vue',
                'video_vue',
                'offre_vue',
                'rdv_pris',
                'rdv_realise',
                'qualifie',
                'paiement_envoye',
                'client',
            ];
            if (in_array($updates['status'], $allowed, true)) {
                $lead['status'] = $updates['status'];
            }
        }

        if (isset($updates['notes'])) {
            $lead['notes'] = trim((string) $updates['notes']);
        }

        if (($lead['status'] ?? '') === 'rdv_planifie') {
            crm_mark_meeting_booked($lead);
        }

        $lead['updated_at'] = gmdate('c');
        $updated = true;
        break;
    }

    if (!empty($filters['q'])) {
        $where[] = '(nom LIKE :q OR email LIKE :q OR telephone LIKE :q OR ville LIKE :q OR source LIKE :q)';
        $params[':q'] = '%' . $filters['q'] . '%';
    }

    $sort = strtoupper((string) ($filters['sort'] ?? 'DESC')) === 'ASC' ? 'ASC' : 'DESC';

function crm_mark_meeting_booked(array &$lead): void
{
    $lead['automation']['meeting_booked'] = true;
    $lead['automation']['stopped_at'] = gmdate('c');
    foreach ($lead['email_sequence'] as &$step) {
        if (($step['status'] ?? 'pending') === 'pending') {
            $step['status'] = 'cancelled';
        }
    }
    unset($step);
}

function crm_build_public_base_url(): string
{
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') === '443');
    $scheme = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    return $scheme . '://' . $host;
}

function crm_render_template(string $text, array $lead, string $stepId): string
{
    $baseUrl = crm_build_public_base_url();
    $videoUrl = $baseUrl . '/api/crm.php?action=track-click&type=video&lead_id=' . urlencode((string) $lead['id']) . '&step_id=' . urlencode($stepId) . '&redirect=' . urlencode($baseUrl . '/?video=1');
    $offerUrl = $baseUrl . '/api/crm.php?action=track-click&type=offer&lead_id=' . urlencode((string) $lead['id']) . '&step_id=' . urlencode($stepId) . '&redirect=' . urlencode($baseUrl . '/?offre=1');
    $bookingUrl = $baseUrl . '/api/crm.php?action=track-click&type=rdv&lead_id=' . urlencode((string) $lead['id']) . '&step_id=' . urlencode($stepId) . '&redirect=' . urlencode($baseUrl . '/?rdv=1');

    return strtr($text, [
        '{{nom}}' => (string) ($lead['nom'] ?? ''),
        '{{city}}' => (string) ($lead['city'] ?? ''),
        '{{video_url}}' => $videoUrl,
        '{{offer_url}}' => $offerUrl,
        '{{booking_url}}' => $bookingUrl,
    ]);
}

function crm_should_send_step(array $lead, array $step): bool
{
    $automation = $lead['automation'] ?? [];

    if (!empty($automation['meeting_booked'])) {
        return false;
    }

    $key = (string) ($step['key'] ?? '');

    if ($key === 'video_reminder' && !empty($automation['video_viewed'])) {
        return false;
    }

    if ($key === 'urgency') {
        if (empty($automation['offer_viewed'])) {
            return false;
        }

        if (!empty($automation['meeting_booked'])) {
            return false;
        }
    }

    return true;
}

/**
 * @return array{queued:int, skipped:int}
 */
function crm_enqueue_due_sequence_emails(): array
{
    $leads = crm_get_leads();
    $queue = crm_load_json(CRM_EMAIL_QUEUE_FILE);
    $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    $queued = 0;
    $skipped = 0;

    $allowedStatuses = [
        'nouveau',
        'video_non_vue',
        'video_vue',
        'offre_vue',
        'rdv_pris',
        'rdv_realise',
        'qualifie',
        'paiement_envoye',
        'client',
    ];

    return array_map(static function (array $lead) use ($defaults, $allowedStatuses): array {
        $normalized = array_merge($defaults, $lead);
        if (!in_array($normalized['status'], $allowedStatuses, true)) {
            $normalized['status'] = 'nouveau';
        }

        return $normalized;
    }, crm_get_leads());
}

function crm_render_template(string $text, array $lead): string
{
    $allowedStatuses = ['nouveau', 'contacte', 'qualifie', 'proposition', 'negociation', 'converti', 'perdu'];
    $fields = [];
    $params = [':id' => $id];

            if (!crm_should_send_step($lead, $step)) {
                $step['status'] = 'skipped';
                $step['sent_at'] = gmdate('c');
                $skipped++;
                continue;
            }

            $step['status'] = 'queued';
            $queue[] = [
                'queue_id' => bin2hex(random_bytes(6)),
                'lead_id' => $lead['id'],
                'step_id' => $step['id'],
                'queued_at' => gmdate('c'),
                'status' => 'queued',
            ];
            $queued++;
        }
        unset($step);
    }
    unset($lead);

    crm_save_json(CRM_LEADS_FILE, $leads);
    crm_save_json(CRM_EMAIL_QUEUE_FILE, $queue);

    return ['queued' => $queued, 'skipped' => $skipped];
}

/**
 * @return array{sent:int,errors:array<int,string>}
 */
function crm_process_email_queue(int $batchSize = 50): array
{
    $queue = crm_load_json(CRM_EMAIL_QUEUE_FILE);
    $leads = crm_get_leads();
    $emailLog = crm_load_json(CRM_EMAIL_LOG_FILE);
    $sentCount = 0;
    $errors = [];

    $leadIndex = [];
    foreach ($leads as $index => $lead) {
        $leadIndex[(string) $lead['id']] = $index;
    }

    foreach ($queue as &$job) {
        if (($job['status'] ?? '') !== 'queued') {
            continue;
        }

        if ($sentCount >= $batchSize) {
            break;
        }

        $leadId = (string) ($job['lead_id'] ?? '');
        $stepId = (string) ($job['step_id'] ?? '');

        if (!isset($leadIndex[$leadId])) {
            $job['status'] = 'error';
            $job['error'] = 'lead introuvable';
            continue;
        }

        $leadRef = &$leads[$leadIndex[$leadId]];
        $stepRef = null;
        foreach ($leadRef['email_sequence'] as &$step) {
            if (($step['id'] ?? '') === $stepId) {
                $stepRef = &$step;
                break;
            }
        }

        if ($stepRef === null) {
            $job['status'] = 'error';
            $job['error'] = 'étape introuvable';
            continue;
        }

        $subject = crm_render_template((string) $stepRef['subject'], $leadRef, $stepId);
        $plainBody = crm_render_template((string) $stepRef['body'], $leadRef, $stepId);
        $email = (string) ($leadRef['email'] ?? '');
        $baseUrl = crm_build_public_base_url();
        $pixelUrl = $baseUrl . '/api/crm.php?action=track-open&lead_id=' . urlencode($leadId) . '&step_id=' . urlencode($stepId);

        $htmlBody = nl2br(htmlspecialchars($plainBody, ENT_QUOTES, 'UTF-8'))
            . '<img src="' . htmlspecialchars($pixelUrl, ENT_QUOTES, 'UTF-8') . '" alt="" width="1" height="1" style="display:block;border:0;" />';

        $headers = "MIME-Version: 1.0\r\n"
            . "Content-type:text/html;charset=UTF-8\r\n"
            . "From: noreply@ecosystemeimmo.fr\r\n"
            . "Reply-To: contact@ecosystemeimmo.fr\r\n"
            . 'X-Mailer: PHP/' . phpversion();

        $sent = filter_var($email, FILTER_VALIDATE_EMAIL) ? mail($email, $subject, $htmlBody, $headers) : false;

        if ($sent) {
            $stepRef['status'] = 'sent';
            $stepRef['sent_at'] = gmdate('c');
            $job['status'] = 'sent';
            $job['sent_at'] = $stepRef['sent_at'];
            $sentCount++;
            $emailLog[] = [
                'lead_id' => $leadId,
                'step_id' => $stepId,
                'email' => $email,
                'subject' => $subject,
                'sent_at' => $stepRef['sent_at'],
            ];
        } else {
            $stepRef['status'] = 'error';
            $job['status'] = 'error';
            $job['error'] = 'Échec envoi';
            $errors[] = 'Échec envoi pour ' . $email . ' / étape ' . $stepId;
        }
        unset($step);
    }
    unset($job);

    crm_save_json(CRM_LEADS_FILE, $leads);
    crm_save_json(CRM_EMAIL_QUEUE_FILE, $queue);
    crm_save_json(CRM_EMAIL_LOG_FILE, $emailLog);

    return ['sent' => $sentCount, 'errors' => $errors];
}

/**
 * @return array{queued:int, skipped:int, sent:int, errors:array<int,string>}
 */
function crm_send_due_sequence_emails(): array
{
    $queued = crm_enqueue_due_sequence_emails();
    $sent = crm_process_email_queue();

    return [
        'queued' => $queued['queued'],
        'skipped' => $queued['skipped'],
        'sent' => $sent['sent'],
        'errors' => $sent['errors'],
    ];
}

function crm_track_open(string $leadId, string $stepId): bool
{
    $leads = crm_get_leads();
    $tracked = false;

    foreach ($leads as &$lead) {
        if (($lead['id'] ?? '') !== $leadId) {
            continue;
        }

        foreach ($lead['email_sequence'] as &$step) {
            if (($step['id'] ?? '') !== $stepId) {
                continue;
            }

            $step['open_count'] = (int) ($step['open_count'] ?? 0) + 1;
            $step['last_open_at'] = gmdate('c');
            $tracked = true;
            break;
        }
        unset($step);

        if ($tracked) {
            break;
        }
    }
    unset($lead);

    if ($tracked) {
        crm_save_json(CRM_LEADS_FILE, $leads);
    }

    return $tracked;
}

function crm_track_click(string $leadId, string $stepId, string $type): bool
{
    $leads = crm_get_leads();
    $tracked = false;

    foreach ($leads as &$lead) {
        if (($lead['id'] ?? '') !== $leadId) {
            continue;
        }

        foreach ($lead['email_sequence'] as &$step) {
            if (($step['id'] ?? '') !== $stepId) {
                continue;
            }

            $step['click_count'] = (int) ($step['click_count'] ?? 0) + 1;
            $step['last_click_at'] = gmdate('c');
            $tracked = true;
            break;
        }
        unset($step);

        if ($type === 'video') {
            $lead['automation']['video_viewed'] = true;
        }
        if ($type === 'offer') {
            $lead['automation']['offer_viewed'] = true;
        }
        if ($type === 'rdv') {
            $lead['status'] = 'rdv_planifie';
            crm_mark_meeting_booked($lead);
        }

        if ($tracked) {
            $lead['updated_at'] = gmdate('c');
            break;
        }
    }
    unset($lead);

    if ($tracked) {
        crm_save_json(CRM_LEADS_FILE, $leads);
    }

    return $tracked;
}

function crm_get_stats(): array
{
    $leads = crm_get_leads();
    $totalLeads = count($leads);
    $totalSent = 0;
    $totalOpens = 0;
    $totalClicks = 0;
    $rdvCount = 0;

    foreach ($leads as $lead) {
        if (($lead['status'] ?? '') === 'rdv_planifie' || !empty($lead['automation']['meeting_booked'])) {
            $rdvCount++;
        }

        foreach (($lead['email_sequence'] ?? []) as $step) {
            if (($step['status'] ?? '') === 'sent') {
                $totalSent++;
            }
            $totalOpens += (int) ($step['open_count'] ?? 0);
            $totalClicks += (int) ($step['click_count'] ?? 0);
        }
    }

    return [
        'leads' => $totalLeads,
        'emails_sent' => $totalSent,
        'opens' => $totalOpens,
        'clicks' => $totalClicks,
        'rdv' => $rdvCount,
        'open_rate' => $totalSent > 0 ? round(($totalOpens / $totalSent) * 100, 1) : 0,
        'click_rate' => $totalSent > 0 ? round(($totalClicks / $totalSent) * 100, 1) : 0,
        'queue_pending' => count(array_filter(crm_load_json(CRM_EMAIL_QUEUE_FILE), static fn (array $job): bool => ($job['status'] ?? '') === 'queued')),
    ];
}
