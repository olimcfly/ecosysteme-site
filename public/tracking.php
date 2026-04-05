<?php

declare(strict_types=1);

const TRACKING_DIR = __DIR__ . '/../storage';
const TRACKING_FILE = TRACKING_DIR . '/tracking_events.json';

/**
 * @param array<string, mixed> $meta
 */
function track_event(string $event, array $meta = []): void
{
    if (!is_dir(TRACKING_DIR)) {
        mkdir(TRACKING_DIR, 0775, true);
    }

    $events = [];
    if (file_exists(TRACKING_FILE)) {
        $raw = file_get_contents(TRACKING_FILE);
        if ($raw !== false && $raw !== '') {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $events = $decoded;
            }
        }
    }

    $events[] = [
        'event' => $event,
        'meta' => $meta,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'created_at' => gmdate('c'),
    ];

    file_put_contents(TRACKING_FILE, json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
