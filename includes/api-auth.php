<?php
/**
 * Middleware d'authentification API par Bearer Token
 * Vérifie le header Authorization: Bearer <token>
 * Les tokens sont stockés dans la table api_tokens
 */

/**
 * Vérifie le token Bearer et retourne les infos utilisateur
 * @return array ['user_id' => int, 'token' => string] ou termine avec 401
 */
function requireApiAuth() {
    // Récupérer le header Authorization
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';

    // Apache mod_rewrite peut supprimer le header, essayer via apache_request_headers
    if (empty($authHeader) && function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
    }

    if (empty($authHeader)) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Token d\'authentification requis']);
        exit;
    }

    // Extraire le token du format "Bearer <token>"
    if (!preg_match('/^Bearer\s+(.+)$/i', $authHeader, $matches)) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Format d\'authentification invalide. Utilisez: Bearer <token>']);
        exit;
    }

    $token = trim($matches[1]);

    if (empty($token)) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Token vide']);
        exit;
    }

    // Vérifier le token en base de données
    try {
        $pdo = getDB();
        $stmt = $pdo->prepare(
            "SELECT id, user_id, token, expires_at
             FROM api_tokens
             WHERE token = ?
             LIMIT 1"
        );
        $stmt->execute([$token]);
        $tokenRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tokenRow) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Token invalide']);
            exit;
        }

        // Vérifier l'expiration
        if ($tokenRow['expires_at'] !== null && strtotime($tokenRow['expires_at']) < time()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Token expiré']);
            exit;
        }

        return [
            'user_id' => (int) $tokenRow['user_id'],
            'token_id' => (int) $tokenRow['id']
        ];

    } catch (PDOException $e) {
        error_log('API Auth error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erreur d\'authentification']);
        exit;
    }
}

/**
 * Vérifie le token Bearer OU la session admin
 * Utile pour les endpoints appelés depuis le panel admin ET l'API
 */
function requireApiAuthOrAdmin() {
    // D'abord vérifier la session admin
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        return ['user_id' => 0, 'auth_type' => 'session'];
    }

    // Sinon vérifier le token API
    $authResult = requireApiAuth();
    $authResult['auth_type'] = 'token';
    return $authResult;
}
