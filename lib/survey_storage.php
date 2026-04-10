<?php

declare(strict_types=1);

require_once __DIR__ . '/crm.php';

const SURVEY_SUBMISSIONS_FILE = CRM_STORAGE_DIR . '/survey_submissions.json';

function survey_storage_get_pdo(): ?PDO
{
    static $pdo = false;

    if ($pdo instanceof PDO) {
        return $pdo;
    }
    if ($pdo === null) {
        return null;
    }

    if (isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof PDO) {
        $pdo = $GLOBALS['pdo'];
        return $pdo;
    }

    $host = getenv('DB_HOST') ?: '';
    $dbName = getenv('DB_NAME') ?: '';
    $user = getenv('DB_USER') ?: '';
    $pass = getenv('DB_PASSWORD') ?: '';

    if ($host === '' || $dbName === '' || $user === '') {
        $pdo = null;
        return null;
    }

    try {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $dbName);
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (Throwable $exception) {
        $pdo = null;
        return null;
    }
}

function survey_storage_db_available(): bool
{
    $pdo = survey_storage_get_pdo();
    if (!$pdo instanceof PDO) {
        return false;
    }

    try {
        $pdo->query('SELECT 1 FROM survey_responses LIMIT 1');
        return true;
    } catch (Throwable $exception) {
        return false;
    }
}

/** @return array<int, array<string,mixed>> */
function survey_storage_load_all(): array
{
    if (!survey_storage_db_available()) {
        return crm_load_json(SURVEY_SUBMISSIONS_FILE);
    }

    $pdo = survey_storage_get_pdo();
    if (!$pdo instanceof PDO) {
        return crm_load_json(SURVEY_SUBMISSIONS_FILE);
    }

    $stmt = $pdo->query('SELECT * FROM survey_responses ORDER BY created_at DESC');
    $rows = $stmt ? $stmt->fetchAll() : [];

    return array_map(static function (array $row): array {
        return [
            'id' => (string) ($row['id'] ?? ''),
            'access_token_hash' => (string) ($row['access_token_hash'] ?? ''),
            'lead_id' => $row['lead_id'] ?? null,
            'nom' => (string) ($row['nom'] ?? ''),
            'email' => (string) ($row['email'] ?? ''),
            'city' => (string) ($row['city'] ?? ''),
            'phone' => (string) ($row['phone'] ?? ''),
            'source' => (string) ($row['source'] ?? 'sondage_conseillers_2026'),
            'status' => (string) ($row['status'] ?? 'nouveau'),
            'survey_answers' => json_decode((string) ($row['answers_json'] ?? '{}'), true) ?: [],
            'analysis' => json_decode((string) ($row['analysis_json'] ?? '{}'), true) ?: [],
            'created_at' => isset($row['created_at']) ? gmdate('c', strtotime((string) $row['created_at'])) : gmdate('c'),
            'updated_at' => isset($row['updated_at']) ? gmdate('c', strtotime((string) $row['updated_at'])) : gmdate('c'),
        ];
    }, $rows);
}

function survey_storage_save_submission(array $submission): void
{
    if (!survey_storage_db_available()) {
        $items = crm_load_json(SURVEY_SUBMISSIONS_FILE);
        $items[] = $submission;
        crm_save_json(SURVEY_SUBMISSIONS_FILE, $items);
        return;
    }

    $pdo = survey_storage_get_pdo();
    if (!$pdo instanceof PDO) {
        return;
    }

    $analysis = is_array($submission['analysis'] ?? null) ? $submission['analysis'] : [];
    $tagsJson = json_encode((array) ($analysis['tags'] ?? []), JSON_UNESCAPED_UNICODE);

    $stmt = $pdo->prepare('INSERT INTO survey_responses
        (id, access_token_hash, lead_id, nom, email, city, phone, source, status, maturity_level, score, tags_json, priority_text, answers_json, analysis_json, created_at, updated_at)
        VALUES
        (:id, :access_token_hash, :lead_id, :nom, :email, :city, :phone, :source, :status, :maturity_level, :score, :tags_json, :priority_text, :answers_json, :analysis_json, :created_at, :updated_at)');

    $stmt->execute([
        ':id' => (string) ($submission['id'] ?? ''),
        ':access_token_hash' => (string) ($submission['access_token_hash'] ?? ''),
        ':lead_id' => $submission['lead_id'] ?? null,
        ':nom' => (string) ($submission['nom'] ?? ''),
        ':email' => (string) ($submission['email'] ?? ''),
        ':city' => (string) ($submission['city'] ?? ''),
        ':phone' => (string) ($submission['phone'] ?? ''),
        ':source' => (string) ($submission['source'] ?? 'sondage_conseillers_2026'),
        ':status' => (string) ($submission['status'] ?? 'nouveau'),
        ':maturity_level' => (string) ($analysis['level'] ?? 'debutant'),
        ':score' => (int) ($analysis['score'] ?? 0),
        ':tags_json' => $tagsJson ?: '[]',
        ':priority_text' => (string) ($analysis['priority'] ?? ''),
        ':answers_json' => json_encode((array) ($submission['survey_answers'] ?? []), JSON_UNESCAPED_UNICODE),
        ':analysis_json' => json_encode($analysis, JSON_UNESCAPED_UNICODE),
        ':created_at' => gmdate('Y-m-d H:i:s', strtotime((string) ($submission['created_at'] ?? gmdate('c')))),
        ':updated_at' => gmdate('Y-m-d H:i:s'),
    ]);
}

function survey_storage_update_status(string $id, string $status): bool
{
    if (!survey_storage_db_available()) {
        $items = crm_load_json(SURVEY_SUBMISSIONS_FILE);
        $updated = false;
        foreach ($items as &$item) {
            if (($item['id'] ?? '') === $id) {
                $item['status'] = $status;
                $updated = true;
                break;
            }
        }
        unset($item);
        if ($updated) {
            crm_save_json(SURVEY_SUBMISSIONS_FILE, $items);
        }
        return $updated;
    }

    $pdo = survey_storage_get_pdo();
    if (!$pdo instanceof PDO) {
        return false;
    }

    $stmt = $pdo->prepare('UPDATE survey_responses SET status = :status, updated_at = :updated_at WHERE id = :id');
    $stmt->execute([
        ':status' => $status,
        ':updated_at' => gmdate('Y-m-d H:i:s'),
        ':id' => $id,
    ]);

    return $stmt->rowCount() > 0;
}
