<?php

declare(strict_types=1);

const TRACKING_DIR = __DIR__ . '/../storage/private';
const TRACKING_FILE = TRACKING_DIR . '/tracking_events.json';
const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB max
const MAX_EVENTS = 10000; // Nombre maximum d'événements à conserver

/**
 * Enregistre un événement de tracking
 *
 * @param string $event Nom de l'événement
 * @param array<string, mixed> $meta Données supplémentaires
 * @param bool $force Écrire même si le fichier est trop gros
 * @throws RuntimeException Si impossible d'écrire le fichier
 */
function track_event(string $event, array $meta = [], bool $force = false): void
{
    // 1. Vérification des permissions et création du répertoire
    if (!is_dir(TRACKING_DIR)) {
        if (!mkdir(TRACKING_DIR, 0750, true)) {
            throw new RuntimeException("Impossible de créer le répertoire de tracking");
        }
    }

    // 2. Vérification de la taille du fichier
    if (!$force && file_exists(TRACKING_FILE) && filesize(TRACKING_FILE) > MAX_FILE_SIZE) {
        rotate_tracking_file();
    }

    // 3. Chargement des événements existants
    $events = [];
    if (file_exists(TRACKING_FILE)) {
        $raw = file_get_contents(TRACKING_FILE);
        if ($raw === false) {
            throw new RuntimeException("Impossible de lire le fichier de tracking");
        }

        if ($raw !== '') {
            $decoded = json_decode($raw, true);
            if (!is_array($decoded)) {
                throw new RuntimeException("Fichier de tracking corrompu");
            }
            $events = $decoded;
        }
    }

    // 4. Limitation du nombre d'événements
    if (count($events) >= MAX_EVENTS) {
        array_shift($events); // Supprime le plus ancien événement
    }

    // 5. Préparation des données de l'événement
    $eventData = [
        'event' => htmlspecialchars($event, ENT_QUOTES, 'UTF-8'),
        'meta' => sanitize_meta_data($meta),
        'ip' => get_client_ip(),
        'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
        'created_at' => gmdate('c'),
        'server_time' => time(),
    ];

    // 6. Ajout du nouvel événement
    $events[] = $eventData;

    // 7. Écriture atomique du fichier
    $tempFile = tempnam(dirname(TRACKING_FILE), 'tmp');
    if ($tempFile === false) {
        throw new RuntimeException("Impossible de créer un fichier temporaire");
    }

    try {
        $bytesWritten = file_put_contents(
            $tempFile,
            json_encode($events, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
        );

        if ($bytesWritten === false) {
            throw new RuntimeException("Échec de l'écriture dans le fichier temporaire");
        }

        if (!rename($tempFile, TRACKING_FILE)) {
            throw new RuntimeException("Impossible de renommer le fichier temporaire");
        }

        // Définition des permissions
        chmod(TRACKING_FILE, 0640);
    } catch (Exception $e) {
        @unlink($tempFile); // Suppression du fichier temporaire en cas d'erreur
        throw new RuntimeException("Erreur lors de l'écriture du fichier de tracking: " . $e->getMessage());
    }
}

/**
 * Nettoie et valide les métadonnées
 *
 * @param array<string, mixed> $meta
 * @return array<string, mixed>
 */
function sanitize_meta_data(array $meta): array
{
    $sanitized = [];

    foreach ($meta as $key => $value) {
        $key = htmlspecialchars(trim((string)$key), ENT_QUOTES, 'UTF-8');

        if (is_scalar($value)) {
            $sanitized[$key] = htmlspecialchars(trim((string)$value), ENT_QUOTES, 'UTF-8');
        } elseif (is_array($value)) {
            $sanitized[$key] = sanitize_meta_data($value);
        }
        // Les objets et autres types sont ignorés
    }

    return $sanitized;
}

/**
 * Récupère l'IP réelle du client
 */
function get_client_ip(): string
{
    $ip = '';

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Nettoyage de l'IP (en cas de proxy)
    $ip = trim(explode(',', $ip)[0]);

    // Validation basique de l'IP
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {
        $ip = '';
    }

    return $ip;
}

/**
 * Rotation du fichier de tracking
 */
function rotate_tracking_file(): void
{
    if (!file_exists(TRACKING_FILE)) {
        return;
    }

    $backupFile = TRACKING_DIR . '/tracking_events_' . date('Y-m-d_H-i-s') . '.json';

    if (!rename(TRACKING_FILE, $backupFile)) {
        throw new RuntimeException("Impossible de renommer le fichier de tracking pour rotation");
    }
}
