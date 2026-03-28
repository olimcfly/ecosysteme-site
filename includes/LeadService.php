<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - LeadService
 * Centralise la logique métier des leads
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/EmailSender.php';

class LeadService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? getDB();
    }

    /**
     * Récupérer une liste paginée de leads avec filtres
     * @return array{leads: array, total: int, totalPages: int, intents: array, statuses: array}
     */
    public function getLeads(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $where = [];
        $params = [];

        $search = trim($filters['search'] ?? '');
        $filterIntent = $filters['intent'] ?? '';
        $filterStatus = $filters['status'] ?? '';

        if ($search) {
            $where[] = "(firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if ($filterIntent) {
            $where[] = "intent = ?";
            $params[] = $filterIntent;
        }

        if ($filterStatus) {
            $where[] = "status = ?";
            $params[] = $filterStatus;
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        // Total
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM leads {$whereClause}");
        $stmt->execute($params);
        $total = (int) $stmt->fetch()['total'];
        $totalPages = (int) ceil($total / $perPage);

        // Liste
        $stmt = $this->pdo->prepare("
            SELECT id, firstname, lastname, email, phone, intent, status, score, created_at
            FROM leads {$whereClause}
            ORDER BY created_at DESC
            LIMIT ? OFFSET ?
        ");

        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value);
        }
        $stmt->bindValue(count($params) + 1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(count($params) + 2, $offset, PDO::PARAM_INT);

        $stmt->execute();
        $leads = $stmt->fetchAll();

        // Options pour filtres
        $intents = $this->pdo->query("SELECT DISTINCT intent FROM leads WHERE intent IS NOT NULL ORDER BY intent")
            ->fetchAll(PDO::FETCH_COLUMN);
        $statuses = $this->pdo->query("SELECT DISTINCT status FROM leads WHERE status IS NOT NULL ORDER BY status")
            ->fetchAll(PDO::FETCH_COLUMN);

        return [
            'leads' => $leads,
            'total' => $total,
            'totalPages' => $totalPages,
            'intents' => $intents,
            'statuses' => $statuses,
        ];
    }

    /**
     * Récupérer un lead par ID avec son historique complet
     */
    public function getLeadById(int $id): array
    {
        if ($id <= 0) {
            return ['success' => false, 'error' => 'ID invalide'];
        }

        $stmt = $this->pdo->prepare("SELECT * FROM leads WHERE id = ?");
        $stmt->execute([$id]);
        $lead = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$lead) {
            return ['success' => false, 'error' => 'Lead non trouvé'];
        }

        // Historique téléchargements
        $downloads = [];
        try {
            $tableCheck = $this->pdo->query("SHOW TABLES LIKE 'lead_downloads'");
            if ($tableCheck->rowCount() > 0) {
                $downloadStmt = $this->pdo->prepare("
                    SELECT type, resource, source, downloaded_at
                    FROM lead_downloads
                    WHERE lead_id = ?
                    ORDER BY downloaded_at DESC
                ");
                $downloadStmt->execute([$id]);
                $downloads = $downloadStmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            // Table n'existe pas
        }

        // Tags uniques
        $allTypes = [];
        $allResources = [];

        foreach ($downloads as $dl) {
            if (!empty($dl['type'])) {
                $allTypes[$dl['type']] = true;
            }
            if (!empty($dl['resource'])) {
                $allResources[$dl['resource']] = true;
            }
        }

        if (!empty($lead['type']) && $lead['type'] !== 'contact') {
            $allTypes[$lead['type']] = true;
        }
        if (!empty($lead['resource'])) {
            $allResources[$lead['resource']] = true;
        }

        $firstContact = isset($lead['created_at']) ? date('d/m/Y H:i', strtotime($lead['created_at'])) : '-';
        $lastActivity = $firstContact;

        if (!empty($downloads) && isset($downloads[0]['downloaded_at'])) {
            $lastActivity = date('d/m/Y H:i', strtotime($downloads[0]['downloaded_at']));
        }

        return [
            'success' => true,
            'lead' => $lead,
            'downloads' => $downloads,
            'tags' => [
                'types' => array_keys($allTypes),
                'resources' => array_keys($allResources),
            ],
            'stats' => [
                'total_downloads' => count($downloads),
                'first_contact' => $firstContact,
                'last_activity' => $lastActivity,
            ],
        ];
    }

    /**
     * Créer un lead (délègue à la fonction createLead existante dans EmailSender)
     */
    public function createLead(array $data, bool $startSequence = true): array
    {
        return createLead($this->pdo, $data, $startSequence);
    }

    /**
     * Mettre à jour un lead
     */
    public function updateLead(int $id, array $data): array
    {
        if (!$id) {
            return ['success' => false, 'error' => 'ID requis'];
        }

        $updates = [];
        $params = [];

        $allowedFields = ['status', 'notes', 'firstname', 'lastname', 'email', 'phone', 'city'];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $updates[] = "$field = ?";
                $params[] = sanitize($data[$field]);
            }
        }

        if (empty($updates)) {
            return ['success' => false, 'error' => 'Aucun champ à mettre à jour'];
        }

        $params[] = $id;
        $sql = "UPDATE leads SET " . implode(', ', $updates) . " WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'error' => 'Lead non trouvé ou aucune modification'];
        }

        $stmt = $this->pdo->prepare("SELECT * FROM leads WHERE id = ?");
        $stmt->execute([$id]);
        $lead = $stmt->fetch();

        return ['success' => true, 'lead' => $lead];
    }

    /**
     * Supprimer un lead et son historique
     */
    public function deleteLead(int $id): array
    {
        if ($id <= 0) {
            return ['success' => false, 'error' => 'ID invalide'];
        }

        try {
            $this->pdo->beginTransaction();

            $tableExists = $this->pdo->query("SHOW TABLES LIKE 'lead_downloads'")->rowCount() > 0;
            if ($tableExists) {
                $stmt = $this->pdo->prepare("DELETE FROM lead_downloads WHERE lead_id = ?");
                $stmt->execute([$id]);
            }

            $stmt = $this->pdo->prepare("DELETE FROM leads WHERE id = ?");
            $stmt->execute([$id]);

            $this->pdo->commit();

            return ['success' => true, 'message' => 'Contact et historique supprimés'];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'error' => 'Erreur lors de la suppression', 'debug' => $e->getMessage()];
        }
    }

    /**
     * Statistiques globales des leads
     */
    public function getLeadStats(): array
    {
        $total = (int) $this->pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();

        $byIntent = $this->pdo->query("
            SELECT intent, COUNT(*) as count FROM leads GROUP BY intent ORDER BY count DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $byStatus = $this->pdo->query("
            SELECT status, COUNT(*) as count FROM leads GROUP BY status ORDER BY count DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total' => $total,
            'by_intent' => $byIntent,
            'by_status' => $byStatus,
        ];
    }
}
