<?php
/**
 * Rate Limiter simple basé sur IP
 * Max 60 requêtes par minute par IP
 * Stockage en fichier (compatible sans Redis/Memcached)
 */

define('RATE_LIMIT_MAX_REQUESTS', 60);
define('RATE_LIMIT_WINDOW_SECONDS', 60);
define('RATE_LIMIT_STORAGE_DIR', __DIR__ . '/../storage/rate-limits');

/**
 * Vérifie le rate limit pour l'IP courante
 * Retourne true si la requête est autorisée, sinon termine avec 429
 */
function checkRateLimit() {
    $ip = getClientIp();
    $ipHash = md5($ip); // Hash pour éviter les caractères spéciaux dans le nom de fichier

    // Créer le répertoire de stockage si nécessaire
    $storageDir = RATE_LIMIT_STORAGE_DIR;
    if (!is_dir($storageDir)) {
        @mkdir($storageDir, 0755, true);

        // Protéger le répertoire avec .htaccess
        $htaccess = $storageDir . '/.htaccess';
        if (!file_exists($htaccess)) {
            @file_put_contents($htaccess, "Deny from all\n");
        }
    }

    $file = $storageDir . '/' . $ipHash . '.json';
    $now = time();
    $windowStart = $now - RATE_LIMIT_WINDOW_SECONDS;

    // Lire les requêtes existantes
    $requests = [];
    if (file_exists($file)) {
        $data = @file_get_contents($file);
        if ($data !== false) {
            $requests = json_decode($data, true) ?: [];
        }
    }

    // Filtrer les requêtes dans la fenêtre active
    $requests = array_values(array_filter($requests, function ($timestamp) use ($windowStart) {
        return $timestamp > $windowStart;
    }));

    $requestCount = count($requests);
    $remaining = max(0, RATE_LIMIT_MAX_REQUESTS - $requestCount);

    // Ajouter les headers informatifs
    header('X-RateLimit-Limit: ' . RATE_LIMIT_MAX_REQUESTS);
    header('X-RateLimit-Remaining: ' . $remaining);
    header('X-RateLimit-Reset: ' . ($now + RATE_LIMIT_WINDOW_SECONDS));

    // Vérifier la limite
    if ($requestCount >= RATE_LIMIT_MAX_REQUESTS) {
        $retryAfter = ($requests[0] ?? $now) + RATE_LIMIT_WINDOW_SECONDS - $now;
        header('Retry-After: ' . max(1, $retryAfter));
        http_response_code(429);
        echo json_encode([
            'success' => false,
            'error' => 'Trop de requêtes. Réessayez dans ' . max(1, $retryAfter) . ' secondes.',
            'retry_after' => max(1, $retryAfter)
        ]);
        exit;
    }

    // Enregistrer la nouvelle requête
    $requests[] = $now;
    @file_put_contents($file, json_encode($requests), LOCK_EX);

    return true;
}

/**
 * Récupère l'adresse IP du client
 */
function getClientIp() {
    // Vérifier les headers proxy courants (attention: facilement falsifiables)
    // En production derrière un reverse proxy de confiance, ces headers sont fiables
    $headers = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP'];

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            // X-Forwarded-For peut contenir plusieurs IPs, prendre la première
            $ips = explode(',', $_SERVER[$header]);
            $ip = trim($ips[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return $ip;
            }
        }
    }

    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

/**
 * Nettoyage des fichiers de rate limit expirés
 * À appeler périodiquement (via cron par exemple)
 */
function cleanupRateLimitFiles() {
    $storageDir = RATE_LIMIT_STORAGE_DIR;
    if (!is_dir($storageDir)) {
        return;
    }

    $expiry = time() - (RATE_LIMIT_WINDOW_SECONDS * 2);
    $files = glob($storageDir . '/*.json');

    foreach ($files as $file) {
        if (filemtime($file) < $expiry) {
            @unlink($file);
        }
    }
}
