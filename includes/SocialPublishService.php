<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Service Publication Sociale
 * Orchestre la création, programmation et publication des posts sociaux
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/SocialPublisherInterface.php';
require_once __DIR__ . '/SocialPublisherFacebook.php';
require_once __DIR__ . '/SocialPublisherInstagram.php';
require_once __DIR__ . '/SocialPublisherLinkedIn.php';
require_once __DIR__ . '/SocialPublisherGoogle.php';

class SocialPublishService
{
    private PDO $pdo;

    /** @var array<string, SocialPublisherInterface> */
    private array $publishers = [];

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? getDB();
        $this->publishers = [
            'facebook'        => new SocialPublisherFacebook(),
            'instagram'       => new SocialPublisherInstagram(),
            'linkedin'        => new SocialPublisherLinkedIn(),
            'google_business' => new SocialPublisherGoogle(),
        ];
    }

    // =========================================================
    // CRUD Posts
    // =========================================================

    /**
     * Créer un post social
     */
    public function createPost(array $data): array
    {
        $title      = trim($data['title'] ?? '');
        $content    = trim($data['content'] ?? '');
        $imageUrl   = trim($data['image_url'] ?? '');
        $linkUrl    = trim($data['link_url'] ?? '');
        $entityType = $data['entity_type'] ?? 'marketing';
        $entityId   = !empty($data['entity_id']) ? (int) $data['entity_id'] : null;
        $channels   = $data['channels'] ?? [];
        $scheduledAt = !empty($data['scheduled_at']) ? $data['scheduled_at'] : null;

        if (empty($content)) {
            return ['success' => false, 'error' => 'Le contenu du post est requis'];
        }
        if (empty($channels)) {
            return ['success' => false, 'error' => 'Sélectionnez au moins un canal de publication'];
        }

        $status = $scheduledAt ? 'programme' : 'brouillon';

        $stmt = $this->pdo->prepare("
            INSERT INTO social_posts
            (title, content, image_url, link_url, entity_type, entity_id, channels, status, scheduled_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $title,
            $content,
            $imageUrl ?: null,
            $linkUrl ?: null,
            $entityType,
            $entityId,
            json_encode($channels),
            $status,
            $scheduledAt,
        ]);

        $postId = (int) $this->pdo->lastInsertId();

        return ['success' => true, 'post_id' => $postId, 'status' => $status];
    }

    /**
     * Mettre à jour un post (uniquement si brouillon ou programmé)
     */
    public function updatePost(int $id, array $data): array
    {
        $post = $this->getPostById($id);
        if (!$post) {
            return ['success' => false, 'error' => 'Post non trouvé'];
        }
        if ($post['status'] === 'publie') {
            return ['success' => false, 'error' => 'Impossible de modifier un post déjà publié'];
        }

        $fields = [];
        $params = [];

        $allowedFields = ['title', 'content', 'image_url', 'link_url', 'entity_type', 'entity_id', 'scheduled_at'];
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "{$field} = ?";
                $params[] = $data[$field] ?: null;
            }
        }

        if (isset($data['channels'])) {
            $fields[] = "channels = ?";
            $params[] = json_encode($data['channels']);
        }

        if (isset($data['status']) && in_array($data['status'], ['brouillon', 'programme'])) {
            $fields[] = "status = ?";
            $params[] = $data['status'];
        }

        if (empty($fields)) {
            return ['success' => false, 'error' => 'Aucun champ à modifier'];
        }

        $params[] = $id;
        $sql = "UPDATE social_posts SET " . implode(', ', $fields) . " WHERE id = ?";
        $this->pdo->prepare($sql)->execute($params);

        return ['success' => true];
    }

    /**
     * Supprimer un post (uniquement si non publié)
     */
    public function deletePost(int $id): array
    {
        $post = $this->getPostById($id);
        if (!$post) {
            return ['success' => false, 'error' => 'Post non trouvé'];
        }
        if ($post['status'] === 'publie') {
            return ['success' => false, 'error' => 'Impossible de supprimer un post déjà publié'];
        }

        $this->pdo->prepare("DELETE FROM social_posts WHERE id = ?")->execute([$id]);
        return ['success' => true];
    }

    /**
     * Récupérer un post par ID
     */
    public function getPostById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM social_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($post) {
            $post['channels'] = json_decode($post['channels'], true) ?: [];
            $post['publish_results'] = json_decode($post['publish_results'] ?? 'null', true);
        }
        return $post ?: null;
    }

    /**
     * Liste paginée des posts avec filtres
     */
    public function getPosts(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $where = [];
        $params = [];

        if (!empty($filters['status'])) {
            $where[] = "status = ?";
            $params[] = $filters['status'];
        }
        if (!empty($filters['channel'])) {
            $where[] = "JSON_CONTAINS(channels, ?)";
            $params[] = json_encode($filters['channel']);
        }
        if (!empty($filters['search'])) {
            $where[] = "(title LIKE ? OR content LIKE ?)";
            $term = '%' . $filters['search'] . '%';
            $params[] = $term;
            $params[] = $term;
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        // Total
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM social_posts {$whereClause}");
        $stmt->execute($params);
        $total = (int) $stmt->fetchColumn();

        // Liste
        $stmt = $this->pdo->prepare("
            SELECT * FROM social_posts {$whereClause}
            ORDER BY
                CASE status
                    WHEN 'programme' THEN 1
                    WHEN 'brouillon' THEN 2
                    WHEN 'erreur' THEN 3
                    WHEN 'publie' THEN 4
                END,
                COALESCE(scheduled_at, created_at) DESC
            LIMIT ? OFFSET ?
        ");
        foreach ($params as $k => $v) {
            $stmt->bindValue($k + 1, $v);
        }
        $stmt->bindValue(count($params) + 1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(count($params) + 2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($posts as &$p) {
            $p['channels'] = json_decode($p['channels'], true) ?: [];
            $p['publish_results'] = json_decode($p['publish_results'] ?? 'null', true);
        }

        return [
            'posts' => $posts,
            'total' => $total,
            'totalPages' => (int) ceil($total / $perPage),
        ];
    }

    /**
     * Posts pour un mois donné (vue calendrier)
     */
    public function getPostsByMonth(int $year, int $month): array
    {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        $stmt = $this->pdo->prepare("
            SELECT id, title, status, channels, scheduled_at, published_at, created_at
            FROM social_posts
            WHERE (scheduled_at BETWEEN ? AND ?)
               OR (published_at BETWEEN ? AND ?)
               OR (scheduled_at IS NULL AND created_at BETWEEN ? AND ?)
            ORDER BY COALESCE(scheduled_at, published_at, created_at) ASC
        ");
        $stmt->execute([$startDate, $endDate . ' 23:59:59', $startDate, $endDate . ' 23:59:59', $startDate, $endDate . ' 23:59:59']);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($posts as &$p) {
            $p['channels'] = json_decode($p['channels'], true) ?: [];
        }

        return $posts;
    }

    // =========================================================
    // Publication
    // =========================================================

    /**
     * Publier un post immédiatement sur tous les canaux sélectionnés
     */
    public function publishNow(int $postId): array
    {
        $post = $this->getPostById($postId);
        if (!$post) {
            return ['success' => false, 'error' => 'Post non trouvé'];
        }
        if ($post['status'] === 'publie') {
            return ['success' => false, 'error' => 'Ce post est déjà publié'];
        }

        $results = [];
        $allSuccess = true;

        foreach ($post['channels'] as $channelName) {
            $channel = $this->getActiveChannel($channelName);
            if (!$channel) {
                $results[$channelName] = ['status' => 'error', 'error' => 'Canal non configuré ou inactif'];
                $allSuccess = false;
                continue;
            }

            $publisher = $this->publishers[$channelName] ?? null;
            if (!$publisher) {
                $results[$channelName] = ['status' => 'error', 'error' => 'Publisher non disponible'];
                $allSuccess = false;
                continue;
            }

            $result = $publisher->publish($post, $channel);
            if ($result['success']) {
                $results[$channelName] = ['status' => 'ok', 'post_id' => $result['post_id']];
            } else {
                $results[$channelName] = ['status' => 'error', 'error' => $result['error']];
                $allSuccess = false;
            }
        }

        $newStatus = $allSuccess ? 'publie' : 'erreur';
        $errorMsg = null;
        if (!$allSuccess) {
            $errors = [];
            foreach ($results as $ch => $r) {
                if ($r['status'] === 'error') {
                    $errors[] = "{$ch}: {$r['error']}";
                }
            }
            $errorMsg = implode(' | ', $errors);
        }

        $stmt = $this->pdo->prepare("
            UPDATE social_posts
            SET status = ?, published_at = NOW(), publish_results = ?, error_message = ?
            WHERE id = ?
        ");
        $stmt->execute([$newStatus, json_encode($results), $errorMsg, $postId]);

        return ['success' => $allSuccess, 'results' => $results, 'status' => $newStatus];
    }

    /**
     * Traiter les posts programmés dont la date est passée (appelé par le cron)
     */
    public function processScheduledPosts(): array
    {
        $stmt = $this->pdo->query("
            SELECT id FROM social_posts
            WHERE status = 'programme' AND scheduled_at <= NOW()
            ORDER BY scheduled_at ASC
            LIMIT 10
        ");
        $posts = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $processed = [];
        foreach ($posts as $postId) {
            $result = $this->publishNow((int) $postId);
            $processed[] = ['post_id' => $postId, 'result' => $result];
        }

        return ['processed' => count($processed), 'details' => $processed];
    }

    // =========================================================
    // Canaux
    // =========================================================

    /**
     * Récupérer un canal actif par plateforme
     */
    public function getActiveChannel(string $platform): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM social_channels
            WHERE platform = ? AND is_active = 1
            LIMIT 1
        ");
        $stmt->execute([$platform]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Liste de tous les canaux
     */
    public function getChannels(): array
    {
        return $this->pdo->query("SELECT * FROM social_channels ORDER BY platform")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajouter ou mettre à jour un canal
     */
    public function saveChannel(array $data): array
    {
        $platform = $data['platform'] ?? '';
        if (!in_array($platform, ['facebook', 'instagram', 'linkedin', 'google_business'])) {
            return ['success' => false, 'error' => 'Plateforme invalide'];
        }

        $id = !empty($data['id']) ? (int) $data['id'] : null;

        if ($id) {
            $stmt = $this->pdo->prepare("
                UPDATE social_channels
                SET account_name = ?, access_token = ?, refresh_token = ?, token_expires_at = ?,
                    platform_user_id = ?, platform_page_id = ?, is_active = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $data['account_name'] ?? '',
                $data['access_token'] ?? '',
                $data['refresh_token'] ?? null,
                $data['token_expires_at'] ?? null,
                $data['platform_user_id'] ?? null,
                $data['platform_page_id'] ?? null,
                isset($data['is_active']) ? (int) $data['is_active'] : 1,
                $id,
            ]);
        } else {
            $stmt = $this->pdo->prepare("
                INSERT INTO social_channels
                (platform, account_name, access_token, refresh_token, token_expires_at, platform_user_id, platform_page_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $platform,
                $data['account_name'] ?? '',
                $data['access_token'] ?? '',
                $data['refresh_token'] ?? null,
                $data['token_expires_at'] ?? null,
                $data['platform_user_id'] ?? null,
                $data['platform_page_id'] ?? null,
            ]);
            $id = (int) $this->pdo->lastInsertId();
        }

        return ['success' => true, 'channel_id' => $id];
    }

    /**
     * Statistiques pour le dashboard
     */
    public function getStats(): array
    {
        $stats = [];
        $stats['total'] = (int) $this->pdo->query("SELECT COUNT(*) FROM social_posts")->fetchColumn();
        $stats['brouillon'] = (int) $this->pdo->query("SELECT COUNT(*) FROM social_posts WHERE status='brouillon'")->fetchColumn();
        $stats['programme'] = (int) $this->pdo->query("SELECT COUNT(*) FROM social_posts WHERE status='programme'")->fetchColumn();
        $stats['publie'] = (int) $this->pdo->query("SELECT COUNT(*) FROM social_posts WHERE status='publie'")->fetchColumn();
        $stats['erreur'] = (int) $this->pdo->query("SELECT COUNT(*) FROM social_posts WHERE status='erreur'")->fetchColumn();
        $stats['channels'] = (int) $this->pdo->query("SELECT COUNT(*) FROM social_channels WHERE is_active=1")->fetchColumn();
        return $stats;
    }

    /**
     * Initialiser les tables si elles n'existent pas
     */
    public function ensureTables(): void
    {
        $sqlFile = __DIR__ . '/../sql/002_create_social_posts.sql';
        if (file_exists($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            // Supprimer les commentaires SQL
            $sql = preg_replace('/--.*$/m', '', $sql);
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    try {
                        $this->pdo->exec($statement);
                    } catch (PDOException $e) {
                        // Table already exists
                    }
                }
            }
        }
    }
}
