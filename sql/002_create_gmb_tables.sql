-- ============================================
-- ÉCOSYSTÈME IMMO LOCAL+ - Google Business Profile Tables
-- Migration 002 - GMB Module
-- ============================================

-- Fiches GBP (Business Listings)
CREATE TABLE IF NOT EXISTS gmb_listings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL COMMENT 'Nom de la fiche',
    store_code VARCHAR(100) NULL COMMENT 'Code magasin interne',
    address_line1 VARCHAR(255) NOT NULL,
    address_line2 VARCHAR(255) NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    country VARCHAR(2) NOT NULL DEFAULT 'FR',
    phone VARCHAR(20) NULL,
    website VARCHAR(500) NULL,
    primary_category VARCHAR(255) NULL COMMENT 'Catégorie principale GBP',
    secondary_categories TEXT NULL COMMENT 'JSON array de catégories secondaires',
    description TEXT NULL,
    opening_hours TEXT NULL COMMENT 'JSON des horaires',
    special_hours TEXT NULL COMMENT 'JSON des horaires spéciaux',
    services TEXT NULL COMMENT 'JSON des services',
    attributes TEXT NULL COMMENT 'JSON des attributs GBP',
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    google_place_id VARCHAR(255) NULL,
    google_maps_url VARCHAR(500) NULL,
    photos_count INT DEFAULT 0,
    logo_url VARCHAR(500) NULL,
    cover_photo_url VARCHAR(500) NULL,
    status ENUM('active', 'suspended', 'pending', 'closed') DEFAULT 'active',
    verification_status ENUM('verified', 'unverified', 'pending') DEFAULT 'unverified',
    health_score INT DEFAULT 0 COMMENT 'Score santé 0-100',
    health_details TEXT NULL COMMENT 'JSON breakdown du score',
    agent_name VARCHAR(255) NULL COMMENT 'Nom du conseiller associé',
    last_synced_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_postal_code (postal_code),
    INDEX idx_city (city),
    INDEX idx_status (status),
    INDEX idx_health_score (health_score),
    INDEX idx_agent_name (agent_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Avis Google
CREATE TABLE IF NOT EXISTS gmb_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    listing_id INT NOT NULL,
    reviewer_name VARCHAR(255) NOT NULL,
    reviewer_photo_url VARCHAR(500) NULL,
    rating TINYINT NOT NULL COMMENT '1-5 étoiles',
    comment TEXT NULL,
    reply TEXT NULL COMMENT 'Réponse du propriétaire',
    reply_date DATETIME NULL,
    review_date DATETIME NOT NULL,
    google_review_id VARCHAR(255) NULL,
    sentiment ENUM('positive', 'neutral', 'negative') NULL,
    keywords TEXT NULL COMMENT 'JSON mots-clés extraits',
    is_flagged TINYINT(1) DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id) REFERENCES gmb_listings(id) ON DELETE CASCADE,
    INDEX idx_listing_id (listing_id),
    INDEX idx_rating (rating),
    INDEX idx_review_date (review_date),
    INDEX idx_sentiment (sentiment)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Publications GBP (Posts)
CREATE TABLE IF NOT EXISTS gmb_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    listing_id INT NOT NULL,
    type ENUM('update', 'offer', 'event', 'product') NOT NULL DEFAULT 'update',
    title VARCHAR(255) NULL,
    content TEXT NOT NULL,
    cta_type ENUM('none', 'book', 'order', 'shop', 'learn_more', 'sign_up', 'call') DEFAULT 'none',
    cta_url VARCHAR(500) NULL,
    media_url VARCHAR(500) NULL COMMENT 'URL image/vidéo',
    event_start DATETIME NULL,
    event_end DATETIME NULL,
    offer_coupon VARCHAR(100) NULL,
    offer_terms TEXT NULL,
    status ENUM('draft', 'scheduled', 'published', 'expired', 'failed') DEFAULT 'draft',
    scheduled_at DATETIME NULL,
    published_at DATETIME NULL,
    views INT DEFAULT 0,
    clicks INT DEFAULT 0,
    google_post_id VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id) REFERENCES gmb_listings(id) ON DELETE CASCADE,
    INDEX idx_listing_id (listing_id),
    INDEX idx_status (status),
    INDEX idx_type (type),
    INDEX idx_scheduled_at (scheduled_at),
    INDEX idx_published_at (published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Suivi positions Maps / SERP
CREATE TABLE IF NOT EXISTS gmb_positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    listing_id INT NOT NULL,
    keyword VARCHAR(255) NOT NULL COMMENT 'Mot-clé ciblé',
    city VARCHAR(100) NOT NULL COMMENT 'Ville de recherche',
    grid_lat DECIMAL(10, 8) NULL,
    grid_lng DECIMAL(11, 8) NULL,
    position_maps INT NULL COMMENT 'Position dans Maps (1-20, NULL=non trouvé)',
    position_serp INT NULL COMMENT 'Position SERP local pack',
    competitor1_name VARCHAR(255) NULL,
    competitor1_position INT NULL,
    competitor2_name VARCHAR(255) NULL,
    competitor2_position INT NULL,
    competitor3_name VARCHAR(255) NULL,
    competitor3_position INT NULL,
    checked_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_listing_keyword (listing_id, keyword),
    INDEX idx_city (city),
    INDEX idx_checked_at (checked_at),
    FOREIGN KEY (listing_id) REFERENCES gmb_listings(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Citations NAP (annuaires)
CREATE TABLE IF NOT EXISTS gmb_citations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    listing_id INT NOT NULL,
    directory_name VARCHAR(255) NOT NULL COMMENT 'Nom de l annuaire',
    directory_url VARCHAR(500) NULL,
    directory_type ENUM('general', 'immobilier', 'local', 'social') DEFAULT 'general',
    found_name VARCHAR(255) NULL,
    found_address VARCHAR(500) NULL,
    found_phone VARCHAR(50) NULL,
    found_website VARCHAR(500) NULL,
    name_match TINYINT(1) DEFAULT 0,
    address_match TINYINT(1) DEFAULT 0,
    phone_match TINYINT(1) DEFAULT 0,
    nap_score INT DEFAULT 0 COMMENT '0-100 coherence score',
    status ENUM('verified', 'mismatch', 'not_found', 'pending') DEFAULT 'pending',
    last_checked_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id) REFERENCES gmb_listings(id) ON DELETE CASCADE,
    INDEX idx_listing_id (listing_id),
    INDEX idx_status (status),
    INDEX idx_directory_type (directory_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insights / Métriques GBP
CREATE TABLE IF NOT EXISTS gmb_insights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    listing_id INT NOT NULL,
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    views_maps INT DEFAULT 0,
    views_search INT DEFAULT 0,
    views_total INT DEFAULT 0,
    clicks_website INT DEFAULT 0,
    clicks_phone INT DEFAULT 0,
    clicks_directions INT DEFAULT 0,
    clicks_total INT DEFAULT 0,
    photo_views INT DEFAULT 0,
    searches_direct INT DEFAULT 0 COMMENT 'Recherches directes',
    searches_discovery INT DEFAULT 0 COMMENT 'Recherches découverte',
    searches_branded INT DEFAULT 0 COMMENT 'Recherches marque',
    reviews_count INT DEFAULT 0,
    avg_rating DECIMAL(2,1) DEFAULT 0.0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id) REFERENCES gmb_listings(id) ON DELETE CASCADE,
    INDEX idx_listing_period (listing_id, period_start),
    UNIQUE KEY uq_listing_period (listing_id, period_start, period_end)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Photos GBP
CREATE TABLE IF NOT EXISTS gmb_photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    listing_id INT NOT NULL,
    type ENUM('logo', 'cover', 'interior', 'exterior', 'team', 'product', 'other') DEFAULT 'other',
    url VARCHAR(500) NOT NULL,
    caption VARCHAR(255) NULL,
    views INT DEFAULT 0,
    uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id) REFERENCES gmb_listings(id) ON DELETE CASCADE,
    INDEX idx_listing_id (listing_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Modèles de réponses aux avis
CREATE TABLE IF NOT EXISTS gmb_reply_templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    rating_target TINYINT NULL COMMENT 'Pour quel rating (1-5, NULL=tous)',
    template_text TEXT NOT NULL,
    variables TEXT NULL COMMENT 'JSON des variables disponibles',
    usage_count INT DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insérer des modèles de réponse par défaut
INSERT INTO gmb_reply_templates (name, rating_target, template_text, variables) VALUES
('Remerciement 5 étoiles', 5, 'Merci beaucoup {reviewer_name} pour votre excellent avis ! Nous sommes ravis que notre accompagnement vous ait satisfait. N''hésitez pas à nous recommander auprès de votre entourage. À très bientôt !', '["reviewer_name"]'),
('Remerciement 4 étoiles', 4, 'Merci {reviewer_name} pour votre retour positif ! Nous sommes heureux d''avoir pu vous accompagner. Si vous avez des suggestions d''amélioration, n''hésitez pas à nous en faire part. Au plaisir !', '["reviewer_name"]'),
('Réponse 3 étoiles', 3, 'Merci pour votre avis {reviewer_name}. Nous prenons note de vos remarques et nous efforçons constamment d''améliorer nos services. N''hésitez pas à nous contacter directement pour en discuter.', '["reviewer_name"]'),
('Réponse avis négatif', 2, 'Merci d''avoir pris le temps de nous faire un retour {reviewer_name}. Nous sommes désolés que votre expérience n''ait pas été à la hauteur de vos attentes. Nous aimerions en discuter avec vous pour comprendre et améliorer nos services. Contactez-nous au {phone}.', '["reviewer_name", "phone"]'),
('Réponse 1 étoile', 1, '{reviewer_name}, nous regrettons sincèrement cette expérience. La satisfaction de nos clients est notre priorité. Nous souhaitons comprendre ce qui s''est passé. Pourriez-vous nous contacter au {phone} afin que nous puissions en discuter ?', '["reviewer_name", "phone"]');
