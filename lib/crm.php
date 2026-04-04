<?php

declare(strict_types=1);

const CRM_STORAGE_DIR = __DIR__ . '/../storage';
const CRM_LEADS_FILE = CRM_STORAGE_DIR . '/leads.json';
const CRM_EMAIL_LOG_FILE = CRM_STORAGE_DIR . '/email_log.json';
const CRM_EMAIL_QUEUE_FILE = CRM_STORAGE_DIR . '/email_queue.json';
const CRM_EMAIL_TEMPLATE_ORIGIN = 'https://ecosystemeimmo.fr';
const CRM_VIDEO_URL = CRM_EMAIL_TEMPLATE_ORIGIN . '/video-presentation';
const CRM_OFFER_URL = CRM_EMAIL_TEMPLATE_ORIGIN . '/offre';
const CRM_CALENDAR_URL = CRM_EMAIL_TEMPLATE_ORIGIN . '/rdv';

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
            'video_viewed_at' => null,
            'offer_viewed_at' => null,
            'rdv_taken_at' => null,
            'stopped_at' => null,
        ],
        'email_sequence' => crm_build_email_sequence(),
    ];

    $leads[] = $lead;
    crm_save_json(CRM_LEADS_FILE, $leads);

    crm_schedule_email_jobs();

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
    return [
        [
            'id' => 'email_1_video_access',
            'name' => 'Email 1 : accès vidéo',
            'subject' => 'Accès immédiat à votre vidéo stratégique',
            'body' => "Bonjour {{nom}},\n\nVoici votre accès vidéo : {{video_link}}\n\nRegardez-la aujourd'hui pour poser les bases de votre acquisition locale.",
            'status' => 'pending',
            'sent_at' => null,
            'opened_at' => null,
            'clicked_at' => null,
        ],
        [
            'id' => 'email_2_video_reminder',
            'name' => 'Email 2 : rappel vidéo',
            'subject' => 'Avez-vous vu la vidéo ? (rappel)',
            'body' => "Bonjour {{nom}},\n\nJe vous renvoie la vidéo ici : {{video_link}}\n\nSi vous ne l'avez pas vue, prenez 5 minutes aujourd'hui.",
            'status' => 'pending',
            'sent_at' => null,
            'opened_at' => null,
            'clicked_at' => null,
        ],
        [
            'id' => 'email_3_offer',
            'name' => 'Email 3 : offre',
            'subject' => 'Voici l’offre pour accélérer votre visibilité locale',
            'body' => "Bonjour {{nom}},\n\nVoici l'offre détaillée : {{offer_link}}\n\nSi c'est aligné avec vos objectifs, vous pouvez réserver un RDV : {{rdv_link}}",
            'status' => 'pending',
            'sent_at' => null,
            'opened_at' => null,
            'clicked_at' => null,
        ],
        [
            'id' => 'email_4_urgency',
            'name' => 'Email 4 : urgence / rareté',
            'subject' => 'Dernières places disponibles cette semaine',
            'body' => "Bonjour {{nom}},\n\nLes créneaux se remplissent vite.\n\nSi vous souhaitez avancer, prenez votre RDV maintenant : {{rdv_link}}",
            'status' => 'pending',
            'sent_at' => null,
            'opened_at' => null,
            'clicked_at' => null,
        ],
    ];
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
            $lead['automation']['rdv_taken_at'] = $lead['automation']['rdv_taken_at'] ?? gmdate('c');
            $lead['automation']['stopped_at'] = gmdate('c');
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

function crm_render_template(string $text, array $lead, string $stepId): string
{
    $leadId = (string) ($lead['id'] ?? '');
    $videoLink = crm_build_tracking_link($leadId, $stepId, 'video');
    $offerLink = crm_build_tracking_link($leadId, $stepId, 'offer');
    $rdvLink = crm_build_tracking_link($leadId, $stepId, 'rdv');

    return strtr($text, [
        '{{nom}}' => (string) ($lead['nom'] ?? ''),
        '{{city}}' => (string) ($lead['city'] ?? ''),
        '{{video_link}}' => $videoLink,
        '{{offer_link}}' => $offerLink,
        '{{rdv_link}}' => $rdvLink,
    ]);
}

function crm_build_tracking_link(string $leadId, string $stepId, string $target): string
{
    return CRM_EMAIL_TEMPLATE_ORIGIN . '/api/email-track.php?action=click&lead=' . urlencode($leadId)
        . '&step=' . urlencode($stepId)
        . '&target=' . urlencode($target);
}

/**
 * @return array<int, array<string, mixed>>
 */
function crm_get_email_queue(): array
{
    return crm_load_json(CRM_EMAIL_QUEUE_FILE);
}

function crm_mark_step_queued(array &$lead, string $stepId, string $queuedAt): void
{
    foreach ($lead['email_sequence'] as &$step) {
        if (($step['id'] ?? '') === $stepId && ($step['status'] ?? 'pending') === 'pending') {
            $step['status'] = 'queued';
            $step['queued_at'] = $queuedAt;
            break;
        }
    }
    unset($step);
}

function crm_find_sequence_step(array &$lead, string $stepId): ?array
{
    foreach ($lead['email_sequence'] as &$step) {
        if (($step['id'] ?? '') === $stepId) {
            return $step;
        }
    }

    return null;
}

function crm_get_step(array $lead, string $stepId): ?array
{
    foreach (($lead['email_sequence'] ?? []) as $step) {
        if (($step['id'] ?? '') === $stepId) {
            return $step;
        }
    }

    return null;
}

function crm_has_step_status(array $lead, string $stepId, array $statuses): bool
{
    $step = crm_get_step($lead, $stepId);
    if ($step === null) {
        return false;
    }

    return in_array((string) ($step['status'] ?? 'pending'), $statuses, true);
}

function crm_enqueue_step(array &$lead, array &$queue, string $stepId, DateTimeImmutable $now): bool
{
    if (crm_has_step_status($lead, $stepId, ['queued', 'sent'])) {
        return false;
    }

    $step = crm_get_step($lead, $stepId);
    if ($step === null) {
        return false;
    }

    $queue[] = [
        'id' => bin2hex(random_bytes(8)),
        'lead_id' => $lead['id'],
        'step_id' => $stepId,
        'status' => 'pending',
        'due_at' => $now->format('c'),
        'created_at' => $now->format('c'),
        'sent_at' => null,
        'error' => null,
    ];

    crm_mark_step_queued($lead, $stepId, $now->format('c'));
    return true;
}

/**
 * @return array<string, int>
 */
function crm_schedule_email_jobs(): array
{
    $leads = crm_get_leads();
    $queue = crm_get_email_queue();
    $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));

    $scheduled = 0;
    $stopped = 0;

    foreach ($leads as &$lead) {
        $automation = $lead['automation'] ?? [];
        $rdvTaken = !empty($automation['rdv_taken_at']) || in_array($lead['status'] ?? '', ['rdv_planifie', 'close'], true);

        if ($rdvTaken) {
            $lead['automation']['stopped_at'] = $lead['automation']['stopped_at'] ?? $now->format('c');
            $stopped++;
            continue;
        }

        $email1 = crm_get_step($lead, 'email_1_video_access');
        if ($email1 !== null && ($email1['status'] ?? 'pending') === 'pending') {
            if (crm_enqueue_step($lead, $queue, 'email_1_video_access', $now)) {
                $scheduled++;
            }
            continue;
        }

        $email1SentAt = !empty($email1['sent_at']) ? new DateTimeImmutable((string) $email1['sent_at']) : null;
        $videoViewedAt = !empty($automation['video_viewed_at']) ? new DateTimeImmutable((string) $automation['video_viewed_at']) : null;

        if ($videoViewedAt === null && $email1SentAt !== null && $now >= $email1SentAt->modify('+1 day')) {
            if (crm_enqueue_step($lead, $queue, 'email_2_video_reminder', $now)) {
                $scheduled++;
            }
        }

        $email3 = crm_get_step($lead, 'email_3_offer');
        $email2 = crm_get_step($lead, 'email_2_video_reminder');
        $referenceForOffer = null;
        if (!empty($email2['sent_at'])) {
            $referenceForOffer = new DateTimeImmutable((string) $email2['sent_at']);
        } elseif ($email1SentAt !== null) {
            $referenceForOffer = $email1SentAt;
        }

        if ($referenceForOffer !== null && $now >= $referenceForOffer->modify('+2 days')) {
            if (crm_enqueue_step($lead, $queue, 'email_3_offer', $now)) {
                $scheduled++;
            }
        }

        $offerViewedAt = !empty($automation['offer_viewed_at']) ? new DateTimeImmutable((string) $automation['offer_viewed_at']) : null;
        if ($offerViewedAt !== null && $now >= $offerViewedAt->modify('+1 day')) {
            if (crm_enqueue_step($lead, $queue, 'email_4_urgency', $now)) {
                $scheduled++;
            }
        }
    }
    unset($lead);

    crm_save_json(CRM_LEADS_FILE, $leads);
    crm_save_json(CRM_EMAIL_QUEUE_FILE, $queue);

    return [
        'scheduled' => $scheduled,
        'stopped' => $stopped,
    ];
}

/**
 * @return array<string, mixed>
 */
function crm_process_email_queue(): array
{
    $queue = crm_get_email_queue();
    $leads = crm_get_leads();
    $emailLog = crm_load_json(CRM_EMAIL_LOG_FILE);
    $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));

    $sentCount = 0;
    $errors = [];

    foreach ($queue as &$job) {
        if (($job['status'] ?? 'pending') !== 'pending') {
            continue;
        }

        $dueAt = new DateTimeImmutable((string) ($job['due_at'] ?? $now->format('c')));
        if ($dueAt > $now) {
            continue;
        }

        $leadId = (string) ($job['lead_id'] ?? '');
        $stepId = (string) ($job['step_id'] ?? '');

        foreach ($leads as &$lead) {
            if (($lead['id'] ?? '') !== $leadId) {
                continue;
            }

            $step = crm_get_step($lead, $stepId);
            if ($step === null) {
                $job['status'] = 'error';
                $job['error'] = 'Étape introuvable';
                $errors[] = 'Étape introuvable pour lead ' . $leadId;
                break;
            }

            $subject = crm_render_template((string) $step['subject'], $lead, $stepId);
            $body = crm_render_template((string) $step['body'], $lead, $stepId);
            $trackPixel = CRM_EMAIL_TEMPLATE_ORIGIN . '/api/email-track.php?action=open&lead=' . urlencode($leadId) . '&step=' . urlencode($stepId);
            $body .= "\n\n<img src=\"{$trackPixel}\" width=\"1\" height=\"1\" alt=\"\" />";

            $email = (string) ($lead['email'] ?? '');
            $headers = "From: noreply@ecosystemeimmo.fr\r\n"
                . "Reply-To: contact@ecosystemeimmo.fr\r\n"
                . "Content-Type: text/plain; charset=UTF-8\r\n"
                . 'X-Mailer: PHP/' . phpversion();

            $sent = filter_var($email, FILTER_VALIDATE_EMAIL) ? mail($email, $subject, $body, $headers) : false;

            if ($sent) {
                $sentAt = gmdate('c');
                $job['status'] = 'sent';
                $job['sent_at'] = $sentAt;
                $sentCount++;

                foreach ($lead['email_sequence'] as &$sequenceStep) {
                    if (($sequenceStep['id'] ?? '') === $stepId) {
                        $sequenceStep['status'] = 'sent';
                        $sequenceStep['sent_at'] = $sentAt;
                        break;
                    }
                }
                unset($sequenceStep);

                $emailLog[] = [
                    'lead_id' => $leadId,
                    'email' => $email,
                    'step_id' => $stepId,
                    'subject' => $subject,
                    'sent_at' => $sentAt,
                ];
            } else {
                $job['status'] = 'error';
                $job['error'] = 'Échec envoi';
                foreach ($lead['email_sequence'] as &$sequenceStep) {
                    if (($sequenceStep['id'] ?? '') === $stepId) {
                        $sequenceStep['status'] = 'error';
                        break;
                    }
                }
                unset($sequenceStep);
                $errors[] = 'Échec envoi pour ' . $email;
            }

            break;
        }
        unset($lead);
    }
    unset($job);

    crm_save_json(CRM_EMAIL_QUEUE_FILE, $queue);
    crm_save_json(CRM_LEADS_FILE, $leads);
    crm_save_json(CRM_EMAIL_LOG_FILE, $emailLog);

    return [
        'sent' => $sentCount,
        'errors' => $errors,
        'queue_pending' => count(array_filter($queue, static fn(array $job): bool => ($job['status'] ?? '') === 'pending')),
    ];
}

function crm_send_due_sequence_emails(): array
{
    $scheduled = crm_schedule_email_jobs();
    $processed = crm_process_email_queue();

    return [
        'scheduled' => $scheduled['scheduled'],
        'stopped' => $scheduled['stopped'],
        'sent' => $processed['sent'],
        'errors' => $processed['errors'],
        'queue_pending' => $processed['queue_pending'],
    ];
}

function crm_register_email_event(string $leadId, string $stepId, string $event): bool
{
    $leads = crm_get_leads();
    $updated = false;

    foreach ($leads as &$lead) {
        if (($lead['id'] ?? '') !== $leadId) {
            continue;
        }

        foreach ($lead['email_sequence'] as &$step) {
            if (($step['id'] ?? '') !== $stepId) {
                continue;
            }

            if ($event === 'open') {
                $step['opened_at'] = $step['opened_at'] ?? gmdate('c');
            }

            if ($event === 'click') {
                $step['clicked_at'] = gmdate('c');
            }

            $updated = true;
            break;
        }
        unset($step);

        if ($updated) {
            break;
        }
    }
    unset($lead);

    if ($updated) {
        crm_save_json(CRM_LEADS_FILE, $leads);
    }

    return $updated;
}

function crm_register_automation_action(string $leadId, string $target): void
{
    $leads = crm_get_leads();

    foreach ($leads as &$lead) {
        if (($lead['id'] ?? '') !== $leadId) {
            continue;
        }

        if ($target === 'video') {
            $lead['automation']['video_viewed_at'] = $lead['automation']['video_viewed_at'] ?? gmdate('c');
        } elseif ($target === 'offer') {
            $lead['automation']['offer_viewed_at'] = gmdate('c');
        } elseif ($target === 'rdv') {
            $lead['automation']['rdv_taken_at'] = gmdate('c');
            $lead['automation']['stopped_at'] = gmdate('c');
            $lead['status'] = 'rdv_planifie';
        }

        break;
    }
    unset($lead);

    crm_save_json(CRM_LEADS_FILE, $leads);
}

/**
 * @return array<string, int>
 */
function crm_get_email_stats(): array
{
    $leads = crm_get_leads();

    $stats = [
        'total_leads' => count($leads),
        'emails_sent' => 0,
        'emails_opened' => 0,
        'emails_clicked' => 0,
        'rdv_taken' => 0,
    ];

    foreach ($leads as $lead) {
        foreach (($lead['email_sequence'] ?? []) as $step) {
            if (!empty($step['sent_at'])) {
                $stats['emails_sent']++;
            }
            if (!empty($step['opened_at'])) {
                $stats['emails_opened']++;
            }
            if (!empty($step['clicked_at'])) {
                $stats['emails_clicked']++;
            }
        }

        if (!empty($lead['automation']['rdv_taken_at'])) {
            $stats['rdv_taken']++;
        }
    }

    return $stats;
}
