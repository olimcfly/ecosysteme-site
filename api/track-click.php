<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Click Tracking Redirect
 *
 * Usage: api/track-click.php?id=TRACKING_ID&url=TARGET_URL
 * Logs the click then redirects to the target URL.
 */

require_once __DIR__ . '/../config/database.php';

$trackingId = isset($_GET['id']) ? trim($_GET['id']) : '';
$url = isset($_GET['url']) ? trim($_GET['url']) : '';

// Validation de l'URL
if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
    header('Location: https://ecosystemeimmo.fr');
    exit;
}

// Empêcher les redirections vers des protocoles dangereux
$parsed = parse_url($url);
if (!isset($parsed['scheme']) || !in_array($parsed['scheme'], ['http', 'https'], true)) {
    header('Location: https://ecosystemeimmo.fr');
    exit;
}

try {
    if (!empty($trackingId)) {
        // Trouver l'email_log correspondant
        $stmt = $pdo->prepare("SELECT id FROM email_logs WHERE tracking_id = ? LIMIT 1");
        $stmt->execute([$trackingId]);
        $emailLog = $stmt->fetch(PDO::FETCH_ASSOC);
        $emailLogId = $emailLog ? $emailLog['id'] : null;

        // Logger le clic
        $stmt = $pdo->prepare("
            INSERT INTO email_click_logs (email_log_id, tracking_id, url, clicked_at, ip_address, user_agent)
            VALUES (?, ?, ?, NOW(), ?, ?)
        ");
        $stmt->execute([
            $emailLogId,
            $trackingId,
            $url,
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);

        // Mettre à jour email_logs
        if ($emailLogId) {
            $stmt = $pdo->prepare("
                UPDATE email_logs
                SET clicked_at = COALESCE(clicked_at, NOW()),
                    clicked_count = clicked_count + 1
                WHERE id = ?
            ");
            $stmt->execute([$emailLogId]);
        }
    }
} catch (Exception $e) {
    // Erreur silencieuse - ne pas bloquer la redirection
    error_log("Track click error: " . $e->getMessage());
}

// Rediriger vers l'URL cible
header('Location: ' . $url, true, 302);
exit;
