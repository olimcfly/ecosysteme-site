-- Table V1 pour stocker les réponses du sondage stratégique
CREATE TABLE IF NOT EXISTS survey_responses (
    id VARCHAR(32) PRIMARY KEY,
    access_token_hash CHAR(64) NOT NULL,
    lead_id VARCHAR(32) NULL,
    nom VARCHAR(191) NOT NULL,
    email VARCHAR(191) NOT NULL,
    city VARCHAR(120) NULL,
    phone VARCHAR(60) NULL,
    source VARCHAR(100) NOT NULL DEFAULT 'sondage_conseillers_2026',
    status VARCHAR(32) NOT NULL DEFAULT 'nouveau',
    maturity_level VARCHAR(32) NOT NULL DEFAULT 'debutant',
    score INT NOT NULL DEFAULT 0,
    tags_json TEXT NOT NULL,
    priority_text TEXT NOT NULL,
    answers_json LONGTEXT NOT NULL,
    analysis_json LONGTEXT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_survey_responses_created_at (created_at),
    INDEX idx_survey_responses_status (status),
    INDEX idx_survey_responses_level (maturity_level),
    INDEX idx_survey_responses_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
