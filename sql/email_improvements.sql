-- ============================================
-- ÉCOSYSTÈME IMMO LOCAL+ - Email System Improvements
-- Tables: email_bounces, email_preferences, email_click_logs
-- ============================================

-- Table des bounces email
CREATE TABLE IF NOT EXISTS email_bounces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    type ENUM('hard', 'soft') NOT NULL DEFAULT 'hard',
    reason TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des préférences email
CREATE TABLE IF NOT EXISTS email_preferences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    frequency ENUM('all', 'weekly', 'never') NOT NULL DEFAULT 'all',
    unsubscribed TINYINT(1) NOT NULL DEFAULT 0,
    token VARCHAR(64) NOT NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_token (token),
    INDEX idx_unsubscribed (unsubscribed)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des clics trackés
CREATE TABLE IF NOT EXISTS email_click_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email_log_id INT DEFAULT NULL,
    tracking_id VARCHAR(64) DEFAULT NULL,
    url TEXT NOT NULL,
    clicked_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    INDEX idx_email_log_id (email_log_id),
    INDEX idx_tracking_id (tracking_id),
    INDEX idx_clicked_at (clicked_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ajouter colonnes de tracking aux email_logs si manquantes
ALTER TABLE email_logs ADD COLUMN IF NOT EXISTS opened_at DATETIME DEFAULT NULL;
ALTER TABLE email_logs ADD COLUMN IF NOT EXISTS opened_count INT DEFAULT 0;
ALTER TABLE email_logs ADD COLUMN IF NOT EXISTS clicked_at DATETIME DEFAULT NULL;
ALTER TABLE email_logs ADD COLUMN IF NOT EXISTS clicked_count INT DEFAULT 0;
