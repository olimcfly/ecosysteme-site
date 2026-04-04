<?php

declare(strict_types=1);

const CRM_STORAGE_DIR = __DIR__ . '/../storage';
const CRM_LEADS_FILE = CRM_STORAGE_DIR . '/leads.json';
const CRM_EMAIL_LOG_FILE = CRM_STORAGE_DIR . '/email_log.json';
const CRM_EVENTS_FILE = CRM_STORAGE_DIR . '/events.json';

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
    $pdo = crm_db();
    $where = [];
    $params = [];

    if (!empty($filters['ville'])) {
        $where[] = 'ville = :ville';
        $params[':ville'] = $filters['ville'];
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

        if (array_key_exists('estimated_amount', $updates)) {
            $amount = is_numeric($updates['estimated_amount']) ? (float) $updates['estimated_amount'] : 0.0;
            $lead['estimated_amount'] = max(0, round($amount, 2));
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

    $sql = 'SELECT * FROM contacts';
    if ($where !== []) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }
    $sql .= ' ORDER BY ville ASC, date_creation ' . $sort;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

/**
 * @return array<int, array<string, mixed>>
 */
function crm_get_leads_with_defaults(): array
{
    $defaults = [
        'status' => 'nouveau',
        'notes' => '',
        'estimated_amount' => 0,
    ];

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

    if (isset($updates['statut_tunnel']) && in_array($updates['statut_tunnel'], $allowedStatuses, true)) {
        $fields[] = 'statut_tunnel = :statut_tunnel';
        $params[':statut_tunnel'] = $updates['statut_tunnel'];
    }

    if ($fields === []) {
        return false;
    }

    $pdo = crm_db();
    $stmt = $pdo->prepare('UPDATE contacts SET ' . implode(', ', $fields) . ' WHERE id = :id');

    return $stmt->execute($params);
}

/**
 * @return array<string, mixed>
 */
function crm_dashboard_stats(): array
{
    $pdo = crm_db();

    $total = (int) $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
    $today = (int) $pdo->query('SELECT COUNT(*) FROM contacts WHERE DATE(date_creation) = CURRENT_DATE()')->fetchColumn();
    $converted = (int) $pdo->query("SELECT COUNT(*) FROM contacts WHERE statut_tunnel = 'converti'")->fetchColumn();

    $villes = $pdo->query('SELECT ville, COUNT(*) AS total FROM contacts GROUP BY ville ORDER BY ville ASC')->fetchAll();

    return [
        'total' => $total,
        'today' => $today,
        'converted' => $converted,
        'cities' => $villes,
    ];
}
