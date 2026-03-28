-- =====================================================
-- ÉCOSYSTÈME IMMO LOCAL+ - Module Publication Sociale
-- Migration : Tables social_channels & social_posts
-- =====================================================

-- Table des canaux sociaux connectés
CREATE TABLE IF NOT EXISTS social_channels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform ENUM('facebook', 'instagram', 'linkedin', 'google_business') NOT NULL,
    account_name VARCHAR(255) NOT NULL,
    access_token TEXT NOT NULL,
    refresh_token TEXT NULL,
    token_expires_at DATETIME NULL,
    platform_user_id VARCHAR(255) NULL,
    platform_page_id VARCHAR(255) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_platform (platform),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des publications sociales
CREATE TABLE IF NOT EXISTS social_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(500) NULL,
    link_url VARCHAR(500) NULL,
    -- Lien métier (mandat, lead, événement)
    entity_type ENUM('mandat', 'lead', 'evenement', 'marketing') NULL DEFAULT 'marketing',
    entity_id INT NULL,
    -- Canaux ciblés (JSON array: ["facebook","instagram","linkedin","google_business"])
    channels JSON NOT NULL,
    -- Programmation
    status ENUM('brouillon', 'programme', 'publie', 'erreur') NOT NULL DEFAULT 'brouillon',
    scheduled_at DATETIME NULL,
    published_at DATETIME NULL,
    -- Résultats par canal (JSON: {"facebook":{"post_id":"xxx","status":"ok"}, ...})
    publish_results JSON NULL,
    error_message TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_scheduled (scheduled_at),
    INDEX idx_entity (entity_type, entity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
