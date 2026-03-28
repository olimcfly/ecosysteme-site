<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Cron Publication Sociale
 *
 * Ce script doit être exécuté toutes les minutes (ou toutes les 5 min) via crontab :
 *   * * * * * /usr/bin/php /chemin/vers/api/cron/social-publish-cron.php >> /chemin/vers/logs/social-cron.log 2>&1
 *
 * Il traite les posts dont le statut est "programme" et dont scheduled_at <= NOW()
 */

// CLI only
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    echo "Accès interdit";
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/SocialPublishService.php';

$service = new SocialPublishService();
$service->ensureTables();

echo "[" . date('Y-m-d H:i:s') . "] Démarrage du cron publications sociales\n";

$result = $service->processScheduledPosts();

echo "[" . date('Y-m-d H:i:s') . "] {$result['processed']} post(s) traité(s)\n";

foreach ($result['details'] as $detail) {
    $postId = $detail['post_id'];
    $status = $detail['result']['success'] ? 'OK' : 'ERREUR';
    echo "  - Post #{$postId}: {$status}\n";

    if (!empty($detail['result']['results'])) {
        foreach ($detail['result']['results'] as $channel => $r) {
            echo "    [{$channel}] {$r['status']}";
            if (!empty($r['error'])) echo " - {$r['error']}";
            echo "\n";
        }
    }
}

echo "[" . date('Y-m-d H:i:s') . "] Fin du cron\n\n";
