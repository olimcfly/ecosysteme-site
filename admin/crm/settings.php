<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Paramètres Admin
 * Page pour gérer les paramètres du CRM
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

// ============================================
// TRAITER LES MODIFICATIONS
// ============================================
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        die('Token de sécurité invalide.');
    }
    $settingKey = $_POST['setting_key'] ?? '';
    $settingValue = $_POST['setting_value'] ?? '';
    
    // Vérifier que la clé est valide
    $validKeys = ['site_name', 'site_url', 'support_email', 'admin_email'];
    
    if (in_array($settingKey, $validKeys)) {
        // Stocker en base de données ou fichier
        // Pour l'instant, on stocke juste en session
        $_SESSION['settings'][$settingKey] = $settingValue;
        
        $message = '✅ Paramètre mise à jour';
        $messageType = 'success';
    }
}

// Récupérer les stats
$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads");
$totalLeads = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads WHERE status = 'client'");
$totalClients = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
$leadsLast30Days = $stmt->fetch()['total'];

// Récupérer les statuts et intents
$stmt = $pdo->query("SELECT DISTINCT status FROM leads WHERE status IS NOT NULL ORDER BY status");
$statuses = $stmt->fetchAll(PDO::FETCH_COLUMN);

$stmt = $pdo->query("SELECT DISTINCT intent FROM leads WHERE intent IS NOT NULL ORDER BY intent");
$intents = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Paramètres - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
        }
        
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        .main {
            flex: 1;
            padding: 2rem;
        }
        
        .header {
            margin-bottom: 2rem;
        }
        
        .header-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }
        
        .header-breadcrumb {
            font-size: 0.85rem;
            color: var(--gray-500);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }
        
        .card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.2s;
        }
        
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        
        .form-help {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary);
        }
        
        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-800);
        }
        
        .btn-secondary:hover {
            background: var(--gray-300);
        }
        
        .badge-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 0.5rem;
        }
        
        .badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            background: var(--primary);
            color: white;
        }
        
        .section-divider {
            height: 1px;
            background: var(--gray-200);
            margin: 2rem 0;
        }
        
        .info-box {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #92400e;
        }
        
        .danger-zone {
            border: 2px solid var(--danger);
            border-radius: 0.75rem;
            padding: 1.5rem;
            background: #fff5f5;
            margin-top: 2rem;
        }
        
        .danger-zone .card-title {
            color: var(--danger);
        }
        
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .main { padding: 1rem; }
            .grid-3 {
                grid-template-columns: 1fr;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'settings'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <main class="main app-content">
            <div class="header">
                <h1 class="header-title">⚙️ Paramètres</h1>
                <div class="header-breadcrumb">Dashboard > Paramètres</div>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>">
                    <span><?= $message ?></span>
                </div>
            <?php endif; ?>
            
            <!-- ============================================
                 STATISTIQUES GÉNÉRALES
                 ============================================ -->
            <div class="grid-3">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value"><?= $totalLeads ?></div>
                    <div class="stat-label">Total Leads</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-value"><?= $totalClients ?></div>
                    <div class="stat-label">Clients</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📈</div>
                    <div class="stat-value"><?= $leadsLast30Days ?></div>
                    <div class="stat-label">30 derniers jours</div>
                </div>
            </div>
            
            <!-- ============================================
                 PARAMÈTRES GÉNÉRAUX
                 ============================================ -->
            <div class="card">
                <div class="card-title">🏢 Paramètres Généraux</div>
                
                <div class="info-box">
                    💡 Les paramètres sont actuellement stockés en session. Pour une persistance complète, activez la sauvegarde en base de données.
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nom du Site</label>
                        <input type="text" class="form-input" value="<?= SITE_NAME ?>" disabled>
                        <div class="form-help">Défini dans /config/database.php</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">URL du Site</label>
                        <input type="text" class="form-input" value="<?= SITE_URL ?>" disabled>
                        <div class="form-help">Défini dans /config/database.php</div>
                    </div>
                </div>
            </div>
            
            <!-- ============================================
                 STATUTS DISPONIBLES
                 ============================================ -->
            <div class="card">
                <div class="card-title">🏷️ Statuts Disponibles</div>
                
                <p style="margin-bottom: 1rem; color: var(--gray-500);">Statuts utilisés dans le CRM (basés sur les données actuelles) :</p>
                
                <div class="badge-list">
                    <?php foreach ($statuses as $status): ?>
                        <span class="badge"><?= ucfirst(str_replace('_', ' ', h($status))) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- ============================================
                 INTENTS DISPONIBLES
                 ============================================ -->
            <div class="card">
                <div class="card-title">🎯 Intents Disponibles</div>
                
                <p style="margin-bottom: 1rem; color: var(--gray-500);">Intentions de contact détectées dans le CRM :</p>
                
                <div class="badge-list">
                    <?php foreach ($intents as $intent): ?>
                        <span class="badge"><?= ucfirst(h($intent)) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- ============================================
                 CONFIGURATION EMAIL
                 ============================================ -->
            <div class="card">
                <div class="card-title">📧 Configuration Email</div>
                
                <div class="info-box">
                    Ces paramètres sont définis dans /config/database.php. Pour modifier, contactez votre administrateur système.
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Serveur SMTP</label>
                        <input type="text" class="form-input" value="<?= SMTP_HOST ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Port SMTP</label>
                        <input type="number" class="form-input" value="<?= SMTP_PORT ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email Expéditeur</label>
                        <input type="email" class="form-input" value="<?= EMAIL_FROM ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nom Expéditeur</label>
                        <input type="text" class="form-input" value="<?= EMAIL_FROM_NAME ?>" disabled>
                    </div>
                </div>
            </div>
            
            <!-- ============================================
                 SCORING
                 ============================================ -->
            <div class="card">
                <div class="card-title">📊 Configuration du Scoring</div>
                
                <p style="margin-bottom: 1rem; color: var(--gray-500);">Points attribués pour chaque action :</p>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Télécharger Ressource</label>
                        <input type="number" class="form-input" value="<?= SCORE_DOWNLOAD_RESSOURCE ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Télécharger Outil</label>
                        <input type="number" class="form-input" value="<?= SCORE_DOWNLOAD_OUTIL ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Télécharger Diagnostic</label>
                        <input type="number" class="form-input" value="<?= SCORE_DOWNLOAD_DIAGNOSTIC ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Demander une Demo</label>
                        <input type="number" class="form-input" value="<?= SCORE_DEMO_REQUEST ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Appel Programmé</label>
                        <input type="number" class="form-input" value="<?= SCORE_CALL_BOOKED ?>" disabled>
                    </div>
                </div>
            </div>
            
            <!-- ============================================
                 SÉCURITÉ & OTP
                 ============================================ -->
            <div class="card">
                <div class="card-title">🔐 Sécurité & Authentification</div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Longueur du Code OTP</label>
                        <input type="number" class="form-input" value="<?= OTP_LENGTH ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Expiration OTP (secondes)</label>
                        <input type="number" class="form-input" value="<?= OTP_EXPIRY ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Max tentatives OTP</label>
                        <input type="number" class="form-input" value="<?= OTP_MAX_ATTEMPTS ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Durée session (secondes)</label>
                        <input type="number" class="form-input" value="<?= SESSION_DURATION ?>" disabled>
                    </div>
                </div>
            </div>
            
            <!-- ============================================
                 INFORMATIONS SYSTÈME
                 ============================================ -->
            <div class="card">
                <div class="card-title">💻 Informations Système</div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Version PHP</label>
                        <input type="text" class="form-input" value="<?= phpversion() ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Base de Données</label>
                        <input type="text" class="form-input" value="<?= DB_NAME ?> (<?= DB_HOST ?>)" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Répertoire Courant</label>
                        <input type="text" class="form-input" value="<?= __DIR__ ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Utilisateur Connecté</label>
                        <input type="text" class="form-input" value="<?= h($_SESSION['admin_firstname'] ?? '') ?> (<?= h($_SESSION['admin_email'] ?? '') ?>)" disabled>
                    </div>
                </div>
            </div>
            
            <!-- ============================================
                 ZONE DANGER
                 ============================================ -->
            <div class="danger-zone">
                <div class="card-title">🚨 Zone Dangereuse</div>
                
                <div class="info-box" style="background: #fecaca; border-color: var(--danger); color: var(--danger);">
                    ⚠️ Attention : Les actions ci-dessous ne peuvent pas être annulées.
                </div>
                
                <form method="POST" onsubmit="return confirm('⚠️ Êtes-vous sûr ? Cette action est irréversible.');">
                    <?= csrfField() ?>
                    <input type="hidden" name="action" value="clear_cache">
                    <button type="submit" class="btn btn-secondary" style="margin-bottom: 1rem;">🗑️ Vider le Cache</button>
                </form>
                
                <p style="font-size: 0.9rem; color: var(--gray-500);">
                    Pour supprimer des leads ou réinitialiser la base de données, contactez votre administrateur système.
                </p>
            </div>
        </main>
    </div>
</body>
</html>