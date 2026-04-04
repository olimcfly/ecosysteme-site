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
    $pdo = crm_db();

    $stmt = $pdo->prepare(
        'INSERT INTO contacts (nom, email, telephone, ville, source, statut_tunnel)
         VALUES (:nom, :email, :telephone, :ville, :source, :statut_tunnel)'
    );

    $stmt->execute([
        ':nom' => $payload['nom'],
        ':email' => $payload['email'],
        ':telephone' => $payload['telephone'] ?? null,
        ':ville' => $payload['ville'],
        ':source' => $payload['source'] ?? 'landing_ecosystemeimmo',
        ':statut_tunnel' => $payload['statut_tunnel'] ?? 'nouveau',
    ]);

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

    if (!empty($filters['statut_tunnel'])) {
        $where[] = 'statut_tunnel = :statut_tunnel';
        $params[':statut_tunnel'] = $filters['statut_tunnel'];
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

function crm_update_contact(int $id, array $updates): bool
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
