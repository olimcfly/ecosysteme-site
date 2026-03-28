<?php
/**
 * ÉCOSYSTÈME IMMO+ - Email Tracking
 * 
 * URLs:
 * - Ouverture: track.php?t=TOKEN&a=open (retourne une image 1x1)
 * - Clic: track.php?t=TOKEN&a=click (redirige vers l'URL cible)
 */

require_once __DIR__ . '/../../config/database.php';

$token = isset($_GET['t']) ? trim($_GET['t']) : '';
$action = isset($_GET['a']) ? trim($_GET['a']) : '';

if (empty($token) || !in_array($action, ['open', 'click'])) {
    // Token invalide - retourner silencieusement
    if ($action === 'open') {
        outputTrackingPixel();
    } else {
        header('Location: https://ecosystemeimmo.fr');
    }
    exit;
}

try {
    // Récupérer le token
    $stmt = $pdo->prepare("
        SELECT t.*, s.email_to, s.id as email_sent_id
        FROM email_tracking_tokens t
        JOIN email_sent s ON t.email_sent_id = s.id
        WHERE t.token = ? AND t.token_type = ?
    ");
    $stmt->execute([$token, $action]);
    $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($tokenData) {
        $emailSentId = $tokenData['email_sent_id'];
        
        if ($action === 'open') {
            // Enregistrer l'ouverture
            $update = $pdo->prepare("
                UPDATE email_sent 
                SET opened_at = COALESCE(opened_at, NOW()),
                    opened_count = opened_count + 1
                WHERE id = ?
            ");
            $update->execute([$emailSentId]);
            
            // Marquer le token comme utilisé (première fois)
            if (empty($tokenData['used_at'])) {
                $pdo->prepare("UPDATE email_tracking_tokens SET used_at = NOW() WHERE id = ?")->execute([$tokenData['id']]);
            }
            
            // Retourner le pixel de tracking
            outputTrackingPixel();
            
        } elseif ($action === 'click') {
            // Enregistrer le clic
            $update = $pdo->prepare("
                UPDATE email_sent 
                SET clicked_at = COALESCE(clicked_at, NOW()),
                    clicked_count = clicked_count + 1,
                    clicked_url = COALESCE(clicked_url, ?)
                WHERE id = ?
            ");
            $update->execute([$tokenData['target_url'], $emailSentId]);
            
            // Marquer le token comme utilisé
            if (empty($tokenData['used_at'])) {
                $pdo->prepare("UPDATE email_tracking_tokens SET used_at = NOW() WHERE id = ?")->execute([$tokenData['id']]);
            }
            
            // Rediriger vers l'URL cible
            $targetUrl = !empty($tokenData['target_url']) ? $tokenData['target_url'] : 'https://ecosystemeimmo.fr';
            header('Location: ' . $targetUrl, true, 302);
            exit;
        }
    } else {
        // Token non trouvé
        if ($action === 'open') {
            outputTrackingPixel();
        } else {
            header('Location: https://ecosystemeimmo.fr');
        }
    }
    
} catch (Exception $e) {
    // Erreur silencieuse
    if ($action === 'open') {
        outputTrackingPixel();
    } else {
        header('Location: https://ecosystemeimmo.fr');
    }
}

/**
 * Retourner une image GIF transparente 1x1 pixel
 */
function outputTrackingPixel() {
    header('Content-Type: image/gif');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
    
    // GIF transparent 1x1 pixel
    echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
    exit;
}