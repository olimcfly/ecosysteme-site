<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - GMBService
 * Service centralisé pour la gestion Google Business Profile
 */

require_once __DIR__ . '/../config/database.php';

class GMBService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? getDB();
        $this->ensureTables();
    }

    /**
     * Créer les tables si elles n'existent pas
     */
    private function ensureTables(): void
    {
        try {
            $this->pdo->query("SELECT 1 FROM gmb_listings LIMIT 1");
        } catch (PDOException $e) {
            $sql = file_get_contents(__DIR__ . '/../sql/002_create_gmb_tables.sql');
            if ($sql) {
                $statements = array_filter(array_map('trim', explode(';', $sql)));
                foreach ($statements as $statement) {
                    if (!empty($statement) && stripos($statement, '--') !== 0) {
                        try {
                            $this->pdo->exec($statement);
                        } catch (PDOException $ex) {
                            // Table may already exist
                        }
                    }
                }
            }
        }
    }

    // ==========================================
    // LISTINGS
    // ==========================================

    public function getListings(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(name LIKE ? OR city LIKE ? OR postal_code LIKE ?)";
            $s = "%" . trim($filters['search']) . "%";
            $params = array_merge($params, [$s, $s, $s]);
        }
        if (!empty($filters['postal_code'])) {
            $where[] = "postal_code = ?";
            $params[] = $filters['postal_code'];
        }
        if (!empty($filters['city'])) {
            $where[] = "city = ?";
            $params[] = $filters['city'];
        }
        if (!empty($filters['status'])) {
            $where[] = "status = ?";
            $params[] = $filters['status'];
        }
        if (!empty($filters['agent_name'])) {
            $where[] = "agent_name = ?";
            $params[] = $filters['agent_name'];
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
        $offset = ($page - 1) * $perPage;

        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM gmb_listings {$whereClause}");
        $stmt->execute($params);
        $total = (int)$stmt->fetch()['total'];

        $stmt = $this->pdo->prepare("
            SELECT l.*,
                   (SELECT COUNT(*) FROM gmb_reviews WHERE listing_id = l.id) as reviews_count,
                   (SELECT COALESCE(AVG(rating), 0) FROM gmb_reviews WHERE listing_id = l.id) as avg_rating
            FROM gmb_listings l
            {$whereClause}
            ORDER BY l.created_at DESC
            LIMIT ? OFFSET ?
        ");
        foreach ($params as $k => $v) {
            $stmt->bindValue($k + 1, $v);
        }
        $stmt->bindValue(count($params) + 1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(count($params) + 2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'listings' => $stmt->fetchAll(),
            'total' => $total,
            'totalPages' => (int)ceil($total / $perPage),
        ];
    }

    public function getListingById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM gmb_listings WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function createListing(array $data): int
    {
        $fields = ['name', 'store_code', 'address_line1', 'address_line2', 'city', 'postal_code',
            'country', 'phone', 'website', 'primary_category', 'secondary_categories',
            'description', 'opening_hours', 'special_hours', 'services', 'attributes',
            'latitude', 'longitude', 'google_place_id', 'google_maps_url',
            'logo_url', 'cover_photo_url', 'status', 'verification_status', 'agent_name'];

        $insert = [];
        $params = [];
        foreach ($fields as $f) {
            if (isset($data[$f])) {
                $insert[] = $f;
                $params[] = $data[$f];
            }
        }

        $placeholders = implode(', ', array_fill(0, count($insert), '?'));
        $columns = implode(', ', $insert);
        $stmt = $this->pdo->prepare("INSERT INTO gmb_listings ({$columns}) VALUES ({$placeholders})");
        $stmt->execute($params);

        $id = (int)$this->pdo->lastInsertId();
        $this->calculateHealthScore($id);
        return $id;
    }

    public function updateListing(int $id, array $data): bool
    {
        $allowed = ['name', 'store_code', 'address_line1', 'address_line2', 'city', 'postal_code',
            'country', 'phone', 'website', 'primary_category', 'secondary_categories',
            'description', 'opening_hours', 'special_hours', 'services', 'attributes',
            'latitude', 'longitude', 'google_place_id', 'google_maps_url', 'photos_count',
            'logo_url', 'cover_photo_url', 'status', 'verification_status', 'agent_name'];

        $updates = [];
        $params = [];
        foreach ($allowed as $f) {
            if (array_key_exists($f, $data)) {
                $updates[] = "{$f} = ?";
                $params[] = $data[$f];
            }
        }
        if (empty($updates)) return false;

        $params[] = $id;
        $stmt = $this->pdo->prepare("UPDATE gmb_listings SET " . implode(', ', $updates) . " WHERE id = ?");
        $result = $stmt->execute($params);

        $this->calculateHealthScore($id);
        return $result;
    }

    public function deleteListing(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM gmb_listings WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ==========================================
    // HEALTH SCORE (Audit GBP)
    // ==========================================

    public function calculateHealthScore(int $listingId): int
    {
        $listing = $this->getListingById($listingId);
        if (!$listing) return 0;

        $details = [];
        $score = 0;

        // NAP completeness (25 points)
        $napScore = 0;
        if (!empty($listing['name'])) $napScore += 8;
        if (!empty($listing['address_line1']) && !empty($listing['city']) && !empty($listing['postal_code'])) $napScore += 9;
        if (!empty($listing['phone'])) $napScore += 8;
        $details['nap'] = ['score' => $napScore, 'max' => 25, 'label' => 'NAP (Nom, Adresse, Téléphone)'];
        $score += $napScore;

        // Categories (10 points)
        $catScore = 0;
        if (!empty($listing['primary_category'])) $catScore += 7;
        $secondary = json_decode($listing['secondary_categories'] ?? '[]', true);
        if (!empty($secondary) && count($secondary) >= 2) $catScore += 3;
        $details['categories'] = ['score' => $catScore, 'max' => 10, 'label' => 'Catégories'];
        $score += $catScore;

        // Description (10 points)
        $descScore = 0;
        if (!empty($listing['description'])) {
            $len = mb_strlen($listing['description']);
            if ($len >= 250) $descScore = 10;
            elseif ($len >= 100) $descScore = 6;
            else $descScore = 3;
        }
        $details['description'] = ['score' => $descScore, 'max' => 10, 'label' => 'Description'];
        $score += $descScore;

        // Opening hours (10 points)
        $hoursScore = 0;
        $hours = json_decode($listing['opening_hours'] ?? '[]', true);
        if (!empty($hours)) {
            $hoursScore = count($hours) >= 5 ? 10 : 5;
        }
        $details['hours'] = ['score' => $hoursScore, 'max' => 10, 'label' => 'Horaires'];
        $score += $hoursScore;

        // Photos (15 points)
        $photoScore = 0;
        $photoCount = (int)$listing['photos_count'];
        if (!empty($listing['logo_url'])) $photoScore += 3;
        if (!empty($listing['cover_photo_url'])) $photoScore += 3;
        if ($photoCount >= 10) $photoScore += 9;
        elseif ($photoCount >= 5) $photoScore += 6;
        elseif ($photoCount >= 1) $photoScore += 3;
        $details['photos'] = ['score' => $photoScore, 'max' => 15, 'label' => 'Photos'];
        $score += $photoScore;

        // Reviews (15 points)
        $reviewScore = 0;
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as cnt, COALESCE(AVG(rating), 0) as avg_rating FROM gmb_reviews WHERE listing_id = ?");
        $stmt->execute([$listingId]);
        $reviewData = $stmt->fetch();
        $reviewCount = (int)$reviewData['cnt'];
        $avgRating = (float)$reviewData['avg_rating'];
        if ($reviewCount >= 20) $reviewScore += 5;
        elseif ($reviewCount >= 10) $reviewScore += 3;
        elseif ($reviewCount >= 1) $reviewScore += 1;
        if ($avgRating >= 4.5) $reviewScore += 5;
        elseif ($avgRating >= 4.0) $reviewScore += 3;
        elseif ($avgRating >= 3.0) $reviewScore += 1;
        // Check reply rate
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as cnt FROM gmb_reviews WHERE listing_id = ? AND reply IS NOT NULL");
        $stmt->execute([$listingId]);
        $repliedCount = (int)$stmt->fetch()['cnt'];
        $replyRate = $reviewCount > 0 ? ($repliedCount / $reviewCount) : 0;
        if ($replyRate >= 0.8) $reviewScore += 5;
        elseif ($replyRate >= 0.5) $reviewScore += 3;
        elseif ($replyRate > 0) $reviewScore += 1;
        $details['reviews'] = ['score' => $reviewScore, 'max' => 15, 'label' => 'Avis & Réponses'];
        $score += $reviewScore;

        // Posts activity (10 points)
        $postScore = 0;
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as cnt FROM gmb_posts WHERE listing_id = ? AND published_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
        $stmt->execute([$listingId]);
        $recentPosts = (int)$stmt->fetch()['cnt'];
        if ($recentPosts >= 4) $postScore = 10;
        elseif ($recentPosts >= 2) $postScore = 6;
        elseif ($recentPosts >= 1) $postScore = 3;
        $details['posts'] = ['score' => $postScore, 'max' => 10, 'label' => 'Publications récentes'];
        $score += $postScore;

        // Website & Services (5 points)
        $extraScore = 0;
        if (!empty($listing['website'])) $extraScore += 3;
        $services = json_decode($listing['services'] ?? '[]', true);
        if (!empty($services)) $extraScore += 2;
        $details['extras'] = ['score' => $extraScore, 'max' => 5, 'label' => 'Site web & Services'];
        $score += $extraScore;

        // Save score
        $detailsJson = json_encode($details);
        $stmt = $this->pdo->prepare("UPDATE gmb_listings SET health_score = ?, health_details = ? WHERE id = ?");
        $stmt->execute([$score, $detailsJson, $listingId]);

        return $score;
    }

    public function getHealthBreakdown(int $listingId): array
    {
        $listing = $this->getListingById($listingId);
        if (!$listing) return [];
        return json_decode($listing['health_details'] ?? '{}', true) ?: [];
    }

    // ==========================================
    // REVIEWS
    // ==========================================

    public function getReviews(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['listing_id'])) {
            $where[] = "r.listing_id = ?";
            $params[] = $filters['listing_id'];
        }
        if (!empty($filters['rating'])) {
            $where[] = "r.rating = ?";
            $params[] = $filters['rating'];
        }
        if (!empty($filters['has_reply'])) {
            $where[] = ($filters['has_reply'] === 'yes' ? "r.reply IS NOT NULL" : "r.reply IS NULL");
        }
        if (!empty($filters['postal_code'])) {
            $where[] = "l.postal_code = ?";
            $params[] = $filters['postal_code'];
        }
        if (!empty($filters['agent_name'])) {
            $where[] = "l.agent_name = ?";
            $params[] = $filters['agent_name'];
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
        $offset = ($page - 1) * $perPage;

        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM gmb_reviews r LEFT JOIN gmb_listings l ON r.listing_id = l.id {$whereClause}");
        $stmt->execute($params);
        $total = (int)$stmt->fetch()['total'];

        $stmt = $this->pdo->prepare("
            SELECT r.*, l.name as listing_name, l.city as listing_city, l.postal_code as listing_postal_code, l.agent_name
            FROM gmb_reviews r
            LEFT JOIN gmb_listings l ON r.listing_id = l.id
            {$whereClause}
            ORDER BY r.review_date DESC
            LIMIT ? OFFSET ?
        ");
        foreach ($params as $k => $v) {
            $stmt->bindValue($k + 1, $v);
        }
        $stmt->bindValue(count($params) + 1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(count($params) + 2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'reviews' => $stmt->fetchAll(),
            'total' => $total,
            'totalPages' => (int)ceil($total / $perPage),
        ];
    }

    public function getReviewStats(int $listingId = 0): array
    {
        $where = $listingId > 0 ? "WHERE listing_id = ?" : "";
        $params = $listingId > 0 ? [$listingId] : [];

        $stmt = $this->pdo->prepare("
            SELECT
                COUNT(*) as total,
                COALESCE(AVG(rating), 0) as avg_rating,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as stars_5,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as stars_4,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as stars_3,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as stars_2,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as stars_1,
                SUM(CASE WHEN reply IS NOT NULL THEN 1 ELSE 0 END) as replied
            FROM gmb_reviews {$where}
        ");
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function replyToReview(int $reviewId, string $reply): bool
    {
        $stmt = $this->pdo->prepare("UPDATE gmb_reviews SET reply = ?, reply_date = NOW() WHERE id = ?");
        return $stmt->execute([$reply, $reviewId]);
    }

    public function getReplyTemplates(int $rating = 0): array
    {
        if ($rating > 0) {
            $stmt = $this->pdo->prepare("SELECT * FROM gmb_reply_templates WHERE rating_target = ? OR rating_target IS NULL ORDER BY rating_target DESC");
            $stmt->execute([$rating]);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM gmb_reply_templates ORDER BY rating_target DESC");
        }
        return $stmt->fetchAll();
    }

    // ==========================================
    // POSTS
    // ==========================================

    public function getPosts(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['listing_id'])) {
            $where[] = "p.listing_id = ?";
            $params[] = $filters['listing_id'];
        }
        if (!empty($filters['status'])) {
            $where[] = "p.status = ?";
            $params[] = $filters['status'];
        }
        if (!empty($filters['type'])) {
            $where[] = "p.type = ?";
            $params[] = $filters['type'];
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
        $offset = ($page - 1) * $perPage;

        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM gmb_posts p {$whereClause}");
        $stmt->execute($params);
        $total = (int)$stmt->fetch()['total'];

        $stmt = $this->pdo->prepare("
            SELECT p.*, l.name as listing_name, l.city as listing_city
            FROM gmb_posts p
            LEFT JOIN gmb_listings l ON p.listing_id = l.id
            {$whereClause}
            ORDER BY COALESCE(p.scheduled_at, p.created_at) DESC
            LIMIT ? OFFSET ?
        ");
        foreach ($params as $k => $v) {
            $stmt->bindValue($k + 1, $v);
        }
        $stmt->bindValue(count($params) + 1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(count($params) + 2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'posts' => $stmt->fetchAll(),
            'total' => $total,
            'totalPages' => (int)ceil($total / $perPage),
        ];
    }

    public function createPost(array $data): int
    {
        $fields = ['listing_id', 'type', 'title', 'content', 'cta_type', 'cta_url',
            'media_url', 'event_start', 'event_end', 'offer_coupon', 'offer_terms',
            'status', 'scheduled_at'];

        $insert = [];
        $params = [];
        foreach ($fields as $f) {
            if (isset($data[$f])) {
                $insert[] = $f;
                $params[] = $data[$f];
            }
        }

        $placeholders = implode(', ', array_fill(0, count($insert), '?'));
        $columns = implode(', ', $insert);
        $stmt = $this->pdo->prepare("INSERT INTO gmb_posts ({$columns}) VALUES ({$placeholders})");
        $stmt->execute($params);
        return (int)$this->pdo->lastInsertId();
    }

    public function updatePost(int $id, array $data): bool
    {
        $allowed = ['type', 'title', 'content', 'cta_type', 'cta_url', 'media_url',
            'event_start', 'event_end', 'offer_coupon', 'offer_terms', 'status', 'scheduled_at', 'published_at'];
        $updates = [];
        $params = [];
        foreach ($allowed as $f) {
            if (array_key_exists($f, $data)) {
                $updates[] = "{$f} = ?";
                $params[] = $data[$f];
            }
        }
        if (empty($updates)) return false;
        $params[] = $id;
        $stmt = $this->pdo->prepare("UPDATE gmb_posts SET " . implode(', ', $updates) . " WHERE id = ?");
        return $stmt->execute($params);
    }

    public function deletePost(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM gmb_posts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ==========================================
    // POSITIONS (Maps & SERP)
    // ==========================================

    public function getPositions(int $listingId, string $keyword = '', int $limit = 50): array
    {
        $where = "WHERE listing_id = ?";
        $params = [$listingId];
        if ($keyword) {
            $where .= " AND keyword = ?";
            $params[] = $keyword;
        }
        $stmt = $this->pdo->prepare("
            SELECT * FROM gmb_positions {$where}
            ORDER BY checked_at DESC LIMIT ?
        ");
        foreach ($params as $k => $v) {
            $stmt->bindValue($k + 1, $v);
        }
        $stmt->bindValue(count($params) + 1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPositionGrid(int $listingId, string $keyword): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM gmb_positions
            WHERE listing_id = ? AND keyword = ?
            AND checked_at = (
                SELECT MAX(checked_at) FROM gmb_positions
                WHERE listing_id = ? AND keyword = ?
            )
            ORDER BY grid_lat DESC, grid_lng ASC
        ");
        $stmt->execute([$listingId, $keyword, $listingId, $keyword]);
        return $stmt->fetchAll();
    }

    public function getPositionHistory(int $listingId, string $keyword, int $weeks = 8): array
    {
        $stmt = $this->pdo->prepare("
            SELECT DATE(checked_at) as check_date,
                   MIN(position_maps) as best_position_maps,
                   MIN(position_serp) as best_position_serp
            FROM gmb_positions
            WHERE listing_id = ? AND keyword = ?
            AND checked_at >= DATE_SUB(NOW(), INTERVAL ? WEEK)
            GROUP BY DATE(checked_at)
            ORDER BY check_date ASC
        ");
        $stmt->execute([$listingId, $keyword, $weeks]);
        return $stmt->fetchAll();
    }

    public function getTrackedKeywords(int $listingId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT keyword, city,
                   MIN(position_maps) as best_position,
                   MAX(checked_at) as last_check
            FROM gmb_positions
            WHERE listing_id = ?
            GROUP BY keyword, city
            ORDER BY keyword ASC
        ");
        $stmt->execute([$listingId]);
        return $stmt->fetchAll();
    }

    public function addPosition(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO gmb_positions (listing_id, keyword, city, grid_lat, grid_lng,
                position_maps, position_serp, competitor1_name, competitor1_position,
                competitor2_name, competitor2_position, competitor3_name, competitor3_position)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['listing_id'], $data['keyword'], $data['city'],
            $data['grid_lat'] ?? null, $data['grid_lng'] ?? null,
            $data['position_maps'] ?? null, $data['position_serp'] ?? null,
            $data['competitor1_name'] ?? null, $data['competitor1_position'] ?? null,
            $data['competitor2_name'] ?? null, $data['competitor2_position'] ?? null,
            $data['competitor3_name'] ?? null, $data['competitor3_position'] ?? null,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    // ==========================================
    // CITATIONS NAP
    // ==========================================

    public function getCitations(int $listingId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM gmb_citations WHERE listing_id = ?
            ORDER BY directory_type ASC, directory_name ASC
        ");
        $stmt->execute([$listingId]);
        return $stmt->fetchAll();
    }

    public function getCitationScore(int $listingId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total,
                SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified,
                SUM(CASE WHEN status = 'mismatch' THEN 1 ELSE 0 END) as mismatch,
                SUM(CASE WHEN status = 'not_found' THEN 1 ELSE 0 END) as not_found,
                COALESCE(AVG(nap_score), 0) as avg_score
            FROM gmb_citations WHERE listing_id = ?
        ");
        $stmt->execute([$listingId]);
        return $stmt->fetch();
    }

    public function addCitation(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO gmb_citations (listing_id, directory_name, directory_url, directory_type,
                found_name, found_address, found_phone, found_website,
                name_match, address_match, phone_match, nap_score, status, last_checked_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([
            $data['listing_id'], $data['directory_name'], $data['directory_url'] ?? null,
            $data['directory_type'] ?? 'general',
            $data['found_name'] ?? null, $data['found_address'] ?? null,
            $data['found_phone'] ?? null, $data['found_website'] ?? null,
            $data['name_match'] ?? 0, $data['address_match'] ?? 0,
            $data['phone_match'] ?? 0, $data['nap_score'] ?? 0,
            $data['status'] ?? 'pending',
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function updateCitation(int $id, array $data): bool
    {
        $allowed = ['found_name', 'found_address', 'found_phone', 'found_website',
            'name_match', 'address_match', 'phone_match', 'nap_score', 'status'];
        $updates = ['last_checked_at = NOW()'];
        $params = [];
        foreach ($allowed as $f) {
            if (array_key_exists($f, $data)) {
                $updates[] = "{$f} = ?";
                $params[] = $data[$f];
            }
        }
        $params[] = $id;
        $stmt = $this->pdo->prepare("UPDATE gmb_citations SET " . implode(', ', $updates) . " WHERE id = ?");
        return $stmt->execute($params);
    }

    // ==========================================
    // INSIGHTS
    // ==========================================

    public function getInsights(int $listingId, int $months = 6): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM gmb_insights
            WHERE listing_id = ? AND period_start >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)
            ORDER BY period_start ASC
        ");
        $stmt->execute([$listingId, $months]);
        return $stmt->fetchAll();
    }

    public function getInsightsSummary(int $listingId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                SUM(views_total) as total_views,
                SUM(clicks_total) as total_clicks,
                SUM(clicks_phone) as total_calls,
                SUM(clicks_directions) as total_directions,
                SUM(clicks_website) as total_website,
                SUM(searches_direct) as total_direct,
                SUM(searches_discovery) as total_discovery,
                AVG(views_total) as avg_views,
                AVG(clicks_total) as avg_clicks
            FROM gmb_insights
            WHERE listing_id = ? AND period_start >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
        ");
        $stmt->execute([$listingId]);
        return $stmt->fetch() ?: [];
    }

    // ==========================================
    // DASHBOARD STATS
    // ==========================================

    public function getDashboardStats(): array
    {
        $totalListings = (int)$this->pdo->query("SELECT COUNT(*) FROM gmb_listings")->fetchColumn();
        $avgHealth = (float)$this->pdo->query("SELECT COALESCE(AVG(health_score), 0) FROM gmb_listings")->fetchColumn();
        $totalReviews = (int)$this->pdo->query("SELECT COUNT(*) FROM gmb_reviews")->fetchColumn();
        $avgRating = (float)$this->pdo->query("SELECT COALESCE(AVG(rating), 0) FROM gmb_reviews")->fetchColumn();
        $pendingReplies = (int)$this->pdo->query("SELECT COUNT(*) FROM gmb_reviews WHERE reply IS NULL")->fetchColumn();
        $scheduledPosts = (int)$this->pdo->query("SELECT COUNT(*) FROM gmb_posts WHERE status = 'scheduled'")->fetchColumn();
        $napAlerts = (int)$this->pdo->query("SELECT COUNT(*) FROM gmb_citations WHERE status = 'mismatch'")->fetchColumn();

        // Listings needing attention (health score < 50)
        $lowHealth = (int)$this->pdo->query("SELECT COUNT(*) FROM gmb_listings WHERE health_score < 50")->fetchColumn();

        return [
            'total_listings' => $totalListings,
            'avg_health' => round($avgHealth),
            'total_reviews' => $totalReviews,
            'avg_rating' => round($avgRating, 1),
            'pending_replies' => $pendingReplies,
            'scheduled_posts' => $scheduledPosts,
            'nap_alerts' => $napAlerts,
            'low_health' => $lowHealth,
        ];
    }

    public function getTopListings(int $limit = 5): array
    {
        $stmt = $this->pdo->prepare("
            SELECT l.*,
                (SELECT COUNT(*) FROM gmb_reviews WHERE listing_id = l.id) as reviews_count,
                (SELECT COALESCE(AVG(rating), 0) FROM gmb_reviews WHERE listing_id = l.id) as avg_rating
            FROM gmb_listings l
            ORDER BY l.health_score DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getWeakListings(int $limit = 5): array
    {
        $stmt = $this->pdo->prepare("
            SELECT l.*,
                (SELECT COUNT(*) FROM gmb_reviews WHERE listing_id = l.id) as reviews_count,
                (SELECT COALESCE(AVG(rating), 0) FROM gmb_reviews WHERE listing_id = l.id) as avg_rating
            FROM gmb_listings l
            WHERE l.health_score < 60
            ORDER BY l.health_score ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getAllAgents(): array
    {
        return $this->pdo->query("SELECT DISTINCT agent_name FROM gmb_listings WHERE agent_name IS NOT NULL ORDER BY agent_name")->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAllPostalCodes(): array
    {
        return $this->pdo->query("SELECT DISTINCT postal_code FROM gmb_listings WHERE postal_code IS NOT NULL ORDER BY postal_code")->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAllCities(): array
    {
        return $this->pdo->query("SELECT DISTINCT city FROM gmb_listings WHERE city IS NOT NULL ORDER BY city")->fetchAll(PDO::FETCH_COLUMN);
    }
}
