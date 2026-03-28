<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - API CRM
 * Endpoints REST pour la gestion des leads
 * 
 * GET    /admin/crm/api?action=list_leads
 * POST   /admin/crm/api?action=create_lead
 * PUT    /admin/crm/api?action=update_lead&id=1
 * DELETE /admin/crm/api?action=delete_lead&id=1
 * GET    /admin/crm/api?action=get_lead&id=1
 * POST   /admin/crm/api?action=bulk_action
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// ============================================
// VÉRIFIER AUTHENTIFICATION
// ============================================
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

// Valider CSRF pour les requêtes POST/PUT/DELETE
if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'DELETE']) && !validateCsrfToken()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Token de sécurité invalide.']);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Helper: envoyer une reponse JSON et terminer
 */
function jsonResponse(bool $success, $data = [], int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode(array_merge(['success' => $success], is_array($data) ? $data : ['data' => $data]));
    exit;
}

// ============================================
// ACTIONS API
// ============================================

switch ($action) {
    
    // =============================================
    // LIST LEADS
    // =============================================
    case 'list_leads':
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = intval($_GET['per_page'] ?? 20);
        $offset = ($page - 1) * $perPage;
        $search = $_GET['search'] ?? '';
        $intent = $_GET['intent'] ?? '';
        $status = $_GET['status'] ?? '';
        
        $where = [];
        $params = [];
        
        if ($search) {
            $where[] = "(firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)";
            $term = "%{$search}%";
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
        }
        
        if ($intent) {
            $where[] = "intent = ?";
            $params[] = $intent;
        }
        
        if ($status) {
            $where[] = "status = ?";
            $params[] = $status;
        }
        
        $whereClause = implode(" AND ", $where);
        
        // Total
        $sql = "SELECT COUNT(*) as total FROM leads" . ($whereClause ? " WHERE {$whereClause}" : "");
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $total = $stmt->fetch()['total'];
        
        // Data
        $sql = "
            SELECT id, firstname, lastname, email, phone, city, intent, status, score, created_at
            FROM leads
            " . ($whereClause ? "WHERE {$whereClause}" : "") . "
            ORDER BY created_at DESC
            LIMIT ? OFFSET ?
        ";
        
        $stmt = $pdo->prepare($sql);
        $paramCount = count($params);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value);
        }
        $stmt->bindValue($paramCount + 1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue($paramCount + 2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        echo json_encode([
            'success' => true,
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'pages' => ceil($total / $perPage)
            ]
        ]);
        break;
    
    // =============================================
    // GET LEAD
    // =============================================
    case 'get_lead':
        $leadId = intval($_GET['id'] ?? 0);
        
        $stmt = $pdo->prepare("SELECT * FROM leads WHERE id = ?");
        $stmt->execute([$leadId]);
        $lead = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($lead) {
            echo json_encode(['success' => true, 'data' => $lead]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Lead non trouvé']);
        }
        break;
    
    // =============================================
    // CREATE LEAD
    // =============================================
    case 'create_lead':
        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }
        
        $data = ($GLOBALS['_JSON_INPUT'] ?? json_decode(file_get_contents('php://input'), true)) ?? $_POST;
        
        $stmt = $pdo->prepare("
            INSERT INTO leads (firstname, lastname, email, phone, city, intent, status, message, score, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        
        if ($stmt->execute([
            $data['firstname'] ?? '',
            $data['lastname'] ?? '',
            $data['email'] ?? '',
            $data['phone'] ?? '',
            $data['city'] ?? '',
            $data['intent'] ?? 'cold',
            $data['status'] ?? 'nouveau',
            $data['message'] ?? '',
            $data['score'] ?? 0
        ])) {
            echo json_encode([
                'success' => true,
                'message' => 'Lead créé',
                'id' => $pdo->lastInsertId()
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création']);
        }
        break;
    
    // =============================================
    // UPDATE LEAD
    // =============================================
    case 'update_lead':
        if ($method !== 'PUT' && $method !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }
        
        $leadId = intval($_GET['id'] ?? $_POST['id'] ?? 0);
        $data = ($GLOBALS['_JSON_INPUT'] ?? json_decode(file_get_contents('php://input'), true)) ?? $_POST;
        
        $updates = [];
        $params = [];
        
        $fields = ['firstname', 'lastname', 'email', 'phone', 'city', 'intent', 'status', 'message', 'notes', 'score'];
        
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $updates[] = "{$field} = ?";
                $params[] = $data[$field];
            }
        }
        
        if (empty($updates)) {
            echo json_encode(['success' => false, 'message' => 'Aucune mise à jour']);
            exit;
        }
        
        $updates[] = "updated_at = NOW()";
        $params[] = $leadId;
        
        $sql = "UPDATE leads SET " . implode(", ", $updates) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute($params)) {
            echo json_encode(['success' => true, 'message' => 'Lead mis à jour']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
        }
        break;
    
    // =============================================
    // DELETE LEAD
    // =============================================
    case 'delete_lead':
        if ($method !== 'DELETE' && $method !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }
        
        $leadId = intval($_GET['id'] ?? $_POST['id'] ?? 0);
        
        $stmt = $pdo->prepare("DELETE FROM leads WHERE id = ?");
        
        if ($stmt->execute([$leadId])) {
            echo json_encode(['success' => true, 'message' => 'Lead supprimé']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
        }
        break;
    
    // =============================================
    // BULK ACTION
    // =============================================
    case 'bulk_action':
        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }
        
        $data = ($GLOBALS['_JSON_INPUT'] ?? json_decode(file_get_contents('php://input'), true)) ?? $_POST;
        $leadIds = $data['lead_ids'] ?? [];
        $actionType = $data['action_type'] ?? '';
        $actionValue = $data['action_value'] ?? '';
        
        if (empty($leadIds) || !$actionType) {
            echo json_encode(['success' => false, 'message' => 'Données invalides']);
            exit;
        }
        
        $placeholders = implode(',', array_fill(0, count($leadIds), '?'));
        $count = 0;
        
        switch ($actionType) {
            case 'update_status':
                $sql = "UPDATE leads SET status = ?, updated_at = NOW() WHERE id IN ({$placeholders})";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array_merge([$actionValue], $leadIds));
                $count = $stmt->rowCount();
                break;
            
            case 'update_intent':
                $sql = "UPDATE leads SET intent = ?, updated_at = NOW() WHERE id IN ({$placeholders})";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array_merge([$actionValue], $leadIds));
                $count = $stmt->rowCount();
                break;
            
            case 'delete':
                $sql = "DELETE FROM leads WHERE id IN ({$placeholders})";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($leadIds);
                $count = $stmt->rowCount();
                break;
            
            default:
                echo json_encode(['success' => false, 'message' => 'Action inconnue']);
                exit;
        }
        
        echo json_encode([
            'success' => true,
            'message' => "{$count} lead(s) affecté(s)",
            'count' => $count
        ]);
        break;
    
    // =============================================
    // STATS
    // =============================================
    case 'stats':
        $stats = [];
        
        // Total leads
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM leads");
        $stats['total_leads'] = $stmt->fetch()['count'];
        
        // Clients
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM leads WHERE status = 'client'");
        $stats['total_clients'] = $stmt->fetch()['count'];
        
        // Par intent
        $stmt = $pdo->query("SELECT intent, COUNT(*) as count FROM leads GROUP BY intent");
        $stats['by_intent'] = [];
        foreach ($stmt->fetchAll() as $row) {
            $stats['by_intent'][$row['intent']] = $row['count'];
        }
        
        // Par statut
        $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM leads GROUP BY status");
        $stats['by_status'] = [];
        foreach ($stmt->fetchAll() as $row) {
            $stats['by_status'][$row['status']] = $row['count'];
        }
        
        // Score moyen
        $stmt = $pdo->query("SELECT AVG(score) as avg_score FROM leads");
        $stats['avg_score'] = round($stmt->fetch()['avg_score'], 2);
        
        echo json_encode(['success' => true, 'data' => $stats]);
        break;
    
    // =============================================
    // COMPLETE TASK
    // =============================================
    case 'complete_task':
        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }

        $data = ($GLOBALS['_JSON_INPUT'] ?? json_decode(file_get_contents('php://input'), true)) ?? $_POST;
        $taskId = intval($data['task_id'] ?? 0);

        if (!$taskId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID de tâche requis']);
            exit;
        }

        $stmt = $pdo->prepare("
            UPDATE tasks
            SET status = 'terminee', completed_at = NOW()
            WHERE id = ? AND status IN ('a_faire', 'en_cours')
        ");

        if ($stmt->execute([$taskId]) && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Tâche marquée comme terminée']);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Tâche non trouvée ou déjà terminée']);
        }
        break;

    // =============================================
    // CREATE TASK
    // =============================================
    case 'create_task':
        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            exit;
        }

        $data = ($GLOBALS['_JSON_INPUT'] ?? json_decode(file_get_contents('php://input'), true)) ?? $_POST;

        $title = trim($data['title'] ?? '');
        $description = trim($data['description'] ?? '');
        $dueDate = $data['due_date'] ?? '';
        $priority = $data['priority'] ?? 'normale';
        $leadId = intval($data['lead_id'] ?? 0);

        if (!$title || !$dueDate) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Titre et date d\'échéance requis']);
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO tasks (lead_id, title, description, due_date, priority, status, created_at)
            VALUES (?, ?, ?, ?, ?, 'a_faire', NOW())
        ");

        if ($stmt->execute([
            $leadId ?: null,
            $title,
            $description ?: null,
            $dueDate,
            $priority
        ])) {
            echo json_encode([
                'success' => true,
                'message' => 'Tâche créée',
                'id' => $pdo->lastInsertId()
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création']);
        }
        break;

    // =============================================
    // LIST OFFERS
    // =============================================
    case 'list_offers':
        require_once __DIR__ . '/../../includes/OfferService.php';
        $service = new OfferService();
        $service->ensureTable();
        $page = max(1, intval($_GET['page'] ?? 1));
        $perPage = intval($_GET['per_page'] ?? 20);
        $filters = [
            'search' => $_GET['search'] ?? '',
            'status' => $_GET['status'] ?? '',
            'price_type' => $_GET['price_type'] ?? '',
        ];
        jsonResponse(true, $service->getOffers($filters, $page, $perPage));
        break;

    // =============================================
    // GET OFFER
    // =============================================
    case 'get_offer':
        require_once __DIR__ . '/../../includes/OfferService.php';
        $service = new OfferService();
        $service->ensureTable();
        $id = intval($_GET['id'] ?? 0);
        $offer = $service->getOffer($id);
        if (!$offer) jsonResponse(false, ['message' => 'Offre introuvable'], 404);
        jsonResponse(true, $offer);
        break;

    // =============================================
    // CREATE OFFER
    // =============================================
    case 'create_offer':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(false, ['message' => 'Method not allowed'], 405);
        require_once __DIR__ . '/../../includes/OfferService.php';
        $service = new OfferService();
        $service->ensureTable();
        $input = $GLOBALS['_JSON_INPUT'] ?? json_decode(file_get_contents('php://input'), true);
        if (empty($input['title'])) jsonResponse(false, ['message' => 'Le titre est requis'], 400);
        if (!isset($input['price']) || $input['price'] < 0) jsonResponse(false, ['message' => 'Le prix est requis'], 400);
        $offer = $service->createOffer($input);
        jsonResponse(true, $offer);
        break;

    // =============================================
    // UPDATE OFFER
    // =============================================
    case 'update_offer':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(false, ['message' => 'Method not allowed'], 405);
        require_once __DIR__ . '/../../includes/OfferService.php';
        $service = new OfferService();
        $input = $GLOBALS['_JSON_INPUT'] ?? json_decode(file_get_contents('php://input'), true);
        $id = intval($input['id'] ?? $_GET['id'] ?? 0);
        if (!$id) jsonResponse(false, ['message' => 'ID requis'], 400);
        $offer = $service->updateOffer($id, $input);
        if (!$offer) jsonResponse(false, ['message' => 'Offre introuvable'], 404);
        jsonResponse(true, $offer);
        break;

    // =============================================
    // DELETE OFFER
    // =============================================
    case 'delete_offer':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonResponse(false, ['message' => 'Method not allowed'], 405);
        require_once __DIR__ . '/../../includes/OfferService.php';
        $service = new OfferService();
        $input = $GLOBALS['_JSON_INPUT'] ?? json_decode(file_get_contents('php://input'), true);
        $id = intval($input['id'] ?? $_GET['id'] ?? 0);
        if (!$id) jsonResponse(false, ['message' => 'ID requis'], 400);
        $result = $service->deleteOffer($id);
        if (!$result) jsonResponse(false, ['message' => 'Offre introuvable'], 404);
        jsonResponse(true, ['message' => 'Offre supprimee']);
        break;

    // =============================================
    // DEFAULT
    // =============================================
    default:
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Action inconnue',
            'available_actions' => [
                'list_leads',
                'get_lead',
                'create_lead',
                'update_lead',
                'delete_lead',
                'bulk_action',
                'stats',
                'complete_task',
                'create_task'
            ]
        ]);
}

exit;
?>