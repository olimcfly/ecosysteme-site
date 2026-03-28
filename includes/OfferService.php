<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - OfferService
 * Centralise la logique métier des offres
 */

require_once __DIR__ . '/../config/database.php';

class OfferService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? getDB();
    }

    /**
     * Créer la table offers si elle n'existe pas
     */
    public function ensureTable(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS offers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL UNIQUE,
                description TEXT,
                detailed_content LONGTEXT,
                price DECIMAL(10,2) NOT NULL DEFAULT 0,
                price_type ENUM('one_time','recurring','deposit') NOT NULL DEFAULT 'one_time',
                recurring_interval ENUM('monthly','quarterly','yearly') NULL,
                deposit_enabled TINYINT(1) NOT NULL DEFAULT 0,
                deposit_amount DECIMAL(10,2) NULL,
                terms_conditions LONGTEXT NULL,
                currency VARCHAR(3) NOT NULL DEFAULT 'EUR',
                status ENUM('draft','active','archived') NOT NULL DEFAULT 'draft',
                sort_order INT NOT NULL DEFAULT 0,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_status (status),
                INDEX idx_slug (slug)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Add terms_conditions column if missing (existing installs)
        try {
            $this->pdo->exec("ALTER TABLE offers ADD COLUMN terms_conditions LONGTEXT NULL AFTER deposit_amount");
        } catch (\PDOException $e) {
            // Column already exists - ignore
        }
    }

    /**
     * Récupérer une liste paginée d'offres avec filtres
     * @return array{offers: array, total: int, totalPages: int, statuses: array, types: array}
     */
    public function getOffers(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $where = [];
        $params = [];

        $search = trim($filters['search'] ?? '');
        $filterStatus = $filters['status'] ?? '';
        $filterPriceType = $filters['price_type'] ?? '';

        if ($search) {
            $where[] = "(title LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
        }

        if ($filterStatus) {
            $where[] = "status = ?";
            $params[] = $filterStatus;
        }

        if ($filterPriceType) {
            $where[] = "price_type = ?";
            $params[] = $filterPriceType;
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        // Total
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM offers {$whereClause}");
        $stmt->execute($params);
        $total = (int) $stmt->fetch()['total'];
        $totalPages = (int) ceil($total / $perPage);

        // Liste
        $stmt = $this->pdo->prepare("
            SELECT id, title, slug, description, price, price_type, recurring_interval,
                   deposit_enabled, deposit_amount, currency, status, sort_order, created_at, updated_at
            FROM offers {$whereClause}
            ORDER BY sort_order ASC, created_at DESC
            LIMIT ? OFFSET ?
        ");

        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value);
        }
        $stmt->bindValue(count($params) + 1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(count($params) + 2, $offset, PDO::PARAM_INT);

        $stmt->execute();
        $offers = $stmt->fetchAll();

        // Options pour filtres
        $statuses = $this->pdo->query("SELECT DISTINCT status FROM offers WHERE status IS NOT NULL ORDER BY status")
            ->fetchAll(PDO::FETCH_COLUMN);
        $types = $this->pdo->query("SELECT DISTINCT price_type FROM offers WHERE price_type IS NOT NULL ORDER BY price_type")
            ->fetchAll(PDO::FETCH_COLUMN);

        return [
            'offers' => $offers,
            'total' => $total,
            'totalPages' => $totalPages,
            'statuses' => $statuses,
            'types' => $types,
        ];
    }

    /**
     * Récupérer une offre par ID
     */
    public function getOffer(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM offers WHERE id = ?");
        $stmt->execute([$id]);
        $offer = $stmt->fetch(PDO::FETCH_ASSOC);

        return $offer ?: null;
    }

    /**
     * Créer une offre
     */
    public function createOffer(array $data): array
    {
        $title = trim($data['title'] ?? '');
        $price = $data['price'] ?? 0;

        if (!$title) {
            return ['success' => false, 'error' => 'Le titre est requis'];
        }

        $slug = $this->generateSlug($title);

        $stmt = $this->pdo->prepare("
            INSERT INTO offers (title, slug, description, detailed_content, price, price_type,
                                recurring_interval, deposit_enabled, deposit_amount, terms_conditions, currency, status, sort_order)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $title,
            $slug,
            $data['description'] ?? null,
            $data['detailed_content'] ?? null,
            $price,
            $data['price_type'] ?? 'one_time',
            $data['recurring_interval'] ?? null,
            $data['deposit_enabled'] ?? 0,
            $data['deposit_amount'] ?? null,
            $data['terms_conditions'] ?? null,
            $data['currency'] ?? 'EUR',
            $data['status'] ?? 'draft',
            $data['sort_order'] ?? 0,
        ]);

        $id = (int) $this->pdo->lastInsertId();
        $offer = $this->getOffer($id);

        return ['success' => true, 'offer' => $offer];
    }

    /**
     * Mettre à jour une offre
     */
    public function updateOffer(int $id, array $data): array
    {
        if (!$id) {
            return ['success' => false, 'error' => 'ID requis'];
        }

        $updates = [];
        $params = [];

        $allowedFields = [
            'title', 'description', 'detailed_content', 'price', 'price_type',
            'recurring_interval', 'deposit_enabled', 'deposit_amount', 'terms_conditions',
            'currency', 'status', 'sort_order',
        ];

        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $updates[] = "$field = ?";
                $params[] = $data[$field];
            }
        }

        // Régénérer le slug si le titre change
        if (isset($data['title']) && trim($data['title']) !== '') {
            $updates[] = "slug = ?";
            $params[] = $this->generateSlug(trim($data['title']), $id);
        }

        if (empty($updates)) {
            return ['success' => false, 'error' => 'Aucun champ à mettre à jour'];
        }

        $params[] = $id;
        $sql = "UPDATE offers SET " . implode(', ', $updates) . " WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'error' => 'Offre non trouvée ou aucune modification'];
        }

        $offer = $this->getOffer($id);

        return ['success' => true, 'offer' => $offer];
    }

    /**
     * Supprimer une offre
     */
    public function deleteOffer(int $id): bool
    {
        if ($id <= 0) {
            return false;
        }

        $stmt = $this->pdo->prepare("DELETE FROM offers WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Générer un slug unique à partir du titre
     */
    public function generateSlug(string $title, ?int $excludeId = null): string
    {
        // Convertir en minuscules et remplacer les caractères spéciaux
        $slug = mb_strtolower($title, 'UTF-8');
        $slug = transliterator_transliterate('Any-Latin; Latin-ASCII', $slug) ?: $slug;
        $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        // Vérifier l'unicité
        $baseSlug = $slug;
        $counter = 1;

        while (true) {
            $sql = "SELECT COUNT(*) FROM offers WHERE slug = ?";
            $params = [$slug];

            if ($excludeId) {
                $sql .= " AND id != ?";
                $params[] = $excludeId;
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            if ((int) $stmt->fetchColumn() === 0) {
                break;
            }

            $counter++;
            $slug = $baseSlug . '-' . $counter;
        }

        return $slug;
    }

    /**
     * Compter les offres par statut (pour les stats cards)
     */
    public function countByStatus(): array
    {
        $stmt = $this->pdo->query("
            SELECT status, COUNT(*) as count FROM offers GROUP BY status ORDER BY status
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $counts = [
            'draft' => 0,
            'active' => 0,
            'archived' => 0,
            'total' => 0,
        ];

        foreach ($rows as $row) {
            $counts[$row['status']] = (int) $row['count'];
            $counts['total'] += (int) $row['count'];
        }

        return $counts;
    }
}
