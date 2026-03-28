-- Migration: Création de la table api_tokens
-- À exécuter sur la base de données tasq5564_ecosystemeimmolocal

CREATE TABLE IF NOT EXISTS api_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME DEFAULT NULL,
    UNIQUE KEY uk_token (token),
    INDEX idx_user_id (user_id),
    INDEX idx_expires_at (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exemple pour générer un token (à exécuter manuellement) :
-- INSERT INTO api_tokens (user_id, token, expires_at)
-- VALUES (1, SHA2(CONCAT(RAND(), NOW(), UUID()), 256), DATE_ADD(NOW(), INTERVAL 1 YEAR));
