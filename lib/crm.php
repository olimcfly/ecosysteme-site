<?php

declare(strict_types=1);

const CRM_STORAGE_DIR = __DIR__ . '/../storage';
const CRM_LEADS_FILE = CRM_STORAGE_DIR . '/leads.json';
const CRM_EMAIL_LOG_FILE = CRM_STORAGE_DIR . '/email_log.json';
const CRM_EMAIL_QUEUE_FILE = CRM_STORAGE_DIR . '/email_queue.json';

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

    usort($leads, static function (array $a, array $b): int {
        return strcmp((string) ($b['created_at'] ?? ''), (string) ($a['created_at'] ?? ''));
    });

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
        'notes' => '',
        'created_at' => gmdate('c'),
        'automation' => [
            'video_viewed' => false,
            'offer_viewed' => false,
            'meeting_booked' => false,
            'stopped_at' => null,
        ],
        'email_sequence' => crm_build_email_sequence(),
    ];

    $leads[] = $lead;
    crm_save_json(CRM_LEADS_FILE, $leads);

    return $lead;
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
            $allowed = ['nouveau', 'qualifie', 'rdv_planifie', 'close', 'perdu'];
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

    if ($updated) {
        crm_save_json(CRM_LEADS_FILE, $leads);
    }

    return $updated;
}

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
