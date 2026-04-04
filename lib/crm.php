<?php

declare(strict_types=1);

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

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    crm_ensure_schema($pdo);

    return $pdo;
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
        'notes' => '',
        'estimated_amount' => 0,
        'created_at' => gmdate('c'),
        'email_sequence' => crm_build_email_sequence(),
    ];

    $id = (int) $pdo->lastInsertId();

    return crm_find_contact($id) ?? [];
}

function crm_find_contact(int $id): ?array
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
