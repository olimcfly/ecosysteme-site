<?php

declare(strict_types=1);

require_once __DIR__ . '/tracking.php';

$leadId = trim((string) ($_REQUEST['lead'] ?? ''));

try {
    track_event('video_to_offer_click', [
        'from' => 'video.php',
        'lead' => $leadId,
        'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
    ]);
} catch (Throwable $exception) {
    error_log('Erreur tracking video_to_offer_click: ' . $exception->getMessage());
}

$query = ['src' => 'video_cta'];
if ($leadId !== '') {
    $query['lead'] = $leadId;
}

header('Location: /offre.php?' . http_build_query($query));
exit;
