<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - GMB API Endpoints
 */
session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/GMBService.php';

// Auth check
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'data' => ['error' => 'Non autorisé']]);
    exit;
}

$action = $_GET['action'] ?? '';
$input = json_decode(file_get_contents('php://input'), true) ?? [];

$gmb = new GMBService($pdo);

try {
    switch ($action) {
        case 'create_listing':
            if (empty($input['name']) || empty($input['address_line1']) || empty($input['city']) || empty($input['postal_code'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'Champs obligatoires manquants']]);
                exit;
            }
            $input['country'] = $input['country'] ?? 'FR';
            $id = $gmb->createListing($input);
            echo json_encode(['success' => true, 'data' => ['id' => $id, 'message' => 'Fiche créée']]);
            break;

        case 'update_listing':
            if (empty($input['listing_id'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'ID requis']]);
                exit;
            }
            $id = (int)$input['listing_id'];
            unset($input['listing_id']);
            $gmb->updateListing($id, $input);
            echo json_encode(['success' => true, 'data' => ['message' => 'Fiche mise à jour']]);
            break;

        case 'delete_listing':
            if (empty($input['listing_id'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'ID requis']]);
                exit;
            }
            $gmb->deleteListing((int)$input['listing_id']);
            echo json_encode(['success' => true, 'data' => ['message' => 'Fiche supprimée']]);
            break;

        case 'recalc_score':
            if (empty($input['listing_id'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'ID requis']]);
                exit;
            }
            $score = $gmb->calculateHealthScore((int)$input['listing_id']);
            echo json_encode(['success' => true, 'data' => ['score' => $score]]);
            break;

        case 'reply_review':
            if (empty($input['review_id']) || empty($input['reply'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'ID et réponse requis']]);
                exit;
            }
            $gmb->replyToReview((int)$input['review_id'], $input['reply']);
            echo json_encode(['success' => true, 'data' => ['message' => 'Réponse enregistrée']]);
            break;

        case 'create_post':
            if (empty($input['listing_id']) || empty($input['content'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'Champs obligatoires manquants']]);
                exit;
            }
            $id = $gmb->createPost($input);
            echo json_encode(['success' => true, 'data' => ['id' => $id, 'message' => 'Publication créée']]);
            break;

        case 'update_post':
            if (empty($input['post_id'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'ID requis']]);
                exit;
            }
            $id = (int)$input['post_id'];
            unset($input['post_id']);
            $gmb->updatePost($id, $input);
            echo json_encode(['success' => true, 'data' => ['message' => 'Publication mise à jour']]);
            break;

        case 'delete_post':
            if (empty($input['post_id'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'ID requis']]);
                exit;
            }
            $gmb->deletePost((int)$input['post_id']);
            echo json_encode(['success' => true, 'data' => ['message' => 'Publication supprimée']]);
            break;

        case 'add_position':
            if (empty($input['listing_id']) || empty($input['keyword']) || empty($input['city'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'Champs obligatoires manquants']]);
                exit;
            }
            $id = $gmb->addPosition($input);
            echo json_encode(['success' => true, 'data' => ['id' => $id, 'message' => 'Position ajoutée']]);
            break;

        case 'add_citation':
            if (empty($input['listing_id']) || empty($input['directory_name'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'Champs obligatoires manquants']]);
                exit;
            }
            $id = $gmb->addCitation($input);
            echo json_encode(['success' => true, 'data' => ['id' => $id, 'message' => 'Citation ajoutée']]);
            break;

        case 'update_citation':
            if (empty($input['citation_id'])) {
                echo json_encode(['success' => false, 'data' => ['error' => 'ID requis']]);
                exit;
            }
            $id = (int)$input['citation_id'];
            unset($input['citation_id']);
            $gmb->updateCitation($id, $input);
            echo json_encode(['success' => true, 'data' => ['message' => 'Citation mise à jour']]);
            break;

        case 'get_stats':
            $stats = $gmb->getDashboardStats();
            echo json_encode(['success' => true, 'data' => $stats]);
            break;

        case 'get_templates':
            $rating = (int)($input['rating'] ?? $_GET['rating'] ?? 0);
            $templates = $gmb->getReplyTemplates($rating);
            echo json_encode(['success' => true, 'data' => $templates]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'data' => ['error' => 'Action inconnue: ' . $action]]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'data' => ['error' => 'Erreur serveur: ' . $e->getMessage()]]);
}
