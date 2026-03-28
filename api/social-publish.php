<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - API Publication Sociale
 * Endpoints CRUD et publication des posts sociaux
 *
 * Actions :
 *   GET  ?action=get&id=X       → Récupérer un post
 *   GET  ?action=list            → Liste paginée
 *   GET  ?action=calendar&year=&month= → Posts du mois
 *   POST {action: "create", ...} → Créer un post
 *   POST {action: "update", ...} → Modifier un post
 *   POST {action: "delete", id}  → Supprimer un post
 *   POST {action: "publish", id} → Publier immédiatement
 */

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/SocialPublishService.php';

// Authentification : session admin requise
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Non authentifié']);
    exit;
}

$service = new SocialPublishService($pdo);
$service->ensureTables();

// GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';

    if ($action === 'get' && !empty($_GET['id'])) {
        $post = $service->getPostById((int) $_GET['id']);
        if ($post) {
            jsonResponse(true, $post);
        } else {
            jsonResponse(false, ['error' => 'Post non trouvé'], 404);
        }
    }

    if ($action === 'list') {
        $filters = [];
        if (!empty($_GET['status'])) $filters['status'] = $_GET['status'];
        if (!empty($_GET['channel'])) $filters['channel'] = $_GET['channel'];
        if (!empty($_GET['search'])) $filters['search'] = $_GET['search'];
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $result = $service->getPosts($filters, $page);
        jsonResponse(true, $result);
    }

    if ($action === 'calendar') {
        $year = (int) ($_GET['year'] ?? date('Y'));
        $month = (int) ($_GET['month'] ?? date('m'));
        $posts = $service->getPostsByMonth($year, $month);
        jsonResponse(true, $posts);
    }

    if ($action === 'stats') {
        jsonResponse(true, $service->getStats());
    }

    if ($action === 'channels') {
        jsonResponse(true, $service->getChannels());
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Action invalide']);
    exit;
}

// POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || empty($input['action'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Données invalides']);
        exit;
    }

    $action = $input['action'];

    switch ($action) {
        case 'create':
            $result = $service->createPost($input);
            echo json_encode($result);
            break;

        case 'update':
            if (empty($input['id'])) {
                echo json_encode(['success' => false, 'error' => 'ID requis']);
                break;
            }
            $result = $service->updatePost((int) $input['id'], $input);
            echo json_encode($result);
            break;

        case 'delete':
            if (empty($input['id'])) {
                echo json_encode(['success' => false, 'error' => 'ID requis']);
                break;
            }
            $result = $service->deletePost((int) $input['id']);
            echo json_encode($result);
            break;

        case 'publish':
            if (empty($input['id'])) {
                echo json_encode(['success' => false, 'error' => 'ID requis']);
                break;
            }
            $result = $service->publishNow((int) $input['id']);
            echo json_encode($result);
            break;

        case 'save_channel':
            $result = $service->saveChannel($input);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['success' => false, 'error' => 'Action inconnue']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
