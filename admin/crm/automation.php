<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Automations
 * Gestion des séquences d'emails et automations
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
// TRAITER LES ACTIONS
// ============================================
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        die('Token de sécurité invalide.');
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'create_automation') {
        $name = $_POST['name'] ?? '';
        $trigger = $_POST['trigger'] ?? '';
        $description = $_POST['description'] ?? '';
        
        if (!$name || !$trigger) {
            $message = '❌ Nom et déclencheur requis';
            $messageType = 'error';
        } else {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO automations (name, trigger, description, is_active, created_at)
                    VALUES (?, ?, ?, 1, NOW())
                ");
                
                if ($stmt->execute([$name, $trigger, $description])) {
                    $message = '✅ Automation créée';
                    $messageType = 'success';
                } else {
                    $message = '❌ Erreur lors de la création';
                    $messageType = 'error';
                }
            } catch (Exception $e) {
                $message = '❌ Table automations non trouvée';
                $messageType = 'error';
            }
        }
    }
    
    if ($action === 'activate_automation') {
        $automationId = intval($_POST['automation_id'] ?? 0);
        
        try {
            $stmt = $pdo->prepare("UPDATE automations SET is_active = 1 WHERE id = ?");
            if ($stmt->execute([$automationId])) {
                $message = '✅ Automation activée';
                $messageType = 'success';
            }
        } catch (Exception $e) {
            // Ignore
        }
    }
    
    if ($action === 'deactivate_automation') {
        $automationId = intval($_POST['automation_id'] ?? 0);
        
        try {
            $stmt = $pdo->prepare("UPDATE automations SET is_active = 0 WHERE id = ?");
            if ($stmt->execute([$automationId])) {
                $message = '✅ Automation désactivée';
                $messageType = 'success';
            }
        } catch (Exception $e) {
            // Ignore
        }
    }
}

// ============================================
// RÉCUPÉRER LES AUTOMATIONS
// ============================================
$automations = [];
try {
    $stmt = $pdo->query("SELECT * FROM automations ORDER BY created_at DESC");
    $automations = $stmt->fetchAll();
} catch (Exception $e) {
    // Table n'existe pas
}

// Automations prédéfinies
$defaultAutomations = [
    [
        'id' => 'diagnostic_welcome',
        'name' => '📋 Bienvenue Diagnostic',
        'trigger' => 'diagnostic_intent',
        'description' => 'Envoie un email de bienvenue quand un contact télécharge le diagnostic',
        'emails' => [
            ['day' => 0, 'subject' => 'Diagnostic - Première étape vers votre transformation']
        ]
    ],
    [
        'id' => 'demo_request',
        'name' => '🎥 Suivi Demo',
        'trigger' => 'demo_request',
        'description' => 'Envoie les infos de demo et relance après 3 jours',
        'emails' => [
            ['day' => 0, 'subject' => 'Voici votre lien de démonstration'],
            ['day' => 3, 'subject' => 'Qu\'avez-vous pensé de la démo ?']
        ]
    ],
    [
        'id' => 'resource_nurture',
        'name' => '📚 Nurturing Ressources',
        'trigger' => 'resource_download',
        'description' => 'Séquence d\'emails pour nurturing après téléchargement de ressource',
        'emails' => [
            ['day' => 0, 'subject' => 'Ressource téléchargée avec succès'],
            ['day' => 2, 'subject' => 'Avez-vous trouvé ce que vous cherchiez ?'],
            ['day' => 7, 'subject' => 'Parlons de vos besoins'],
        ]
    ],
    [
        'id' => 'cold_follow_up',
        'name' => '❄️ Suivi Cold',
        'trigger' => 'cold_lead',
        'description' => 'Séquence d\'emails pour les leads froids',
        'emails' => [
            ['day' => 0, 'subject' => 'Marketing immobilier qui fonctionne vraiment'],
            ['day' => 3, 'subject' => 'Pourquoi les agents utilisent ÉCOSYSTÈME IMMO LOCAL+'],
            ['day' => 7, 'subject' => 'Une opportunité à ne pas manquer'],
            ['day' => 14, 'subject' => 'Dernière chance de vous joindre']
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Automations - <?= SITE_NAME ?></title>
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
        }
        
        .automation-item {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .automation-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .automation-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-900);
        }
        
        .automation-description {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-bottom: 0.75rem;
        }
        
        .automation-trigger {
            display: inline-block;
            padding: 0.3rem 0.75rem;
            background: var(--primary);
            color: white;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .automation-emails {
            background: white;
            border: 1px dashed var(--gray-200);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .email-step {
            padding: 0.75rem;
            background: var(--gray-50);
            border-left: 3px solid var(--primary);
            margin-bottom: 0.75rem;
            border-radius: 0.35rem;
        }
        
        .email-day {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.85rem;
        }
        
        .email-subject {
            font-size: 0.9rem;
            color: var(--gray-700);
            margin-top: 0.25rem;
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
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        .btn-small {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
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
        
        .info-box {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #92400e;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive {
            background: #f3f4f6;
            color: #6b7280;
        }
        
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .main { padding: 1rem; }
            .automation-header {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'automation'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <main class="main app-content">
            <div class="header">
                <h1 class="header-title">⚡ Automations</h1>
                <div class="header-breadcrumb">Dashboard > Automations</div>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>
            
            <div class="info-box">
                💡 Les automations envoient des séquences d'emails automatiques en fonction des déclencheurs (intent, actions, etc.)
            </div>
            
            <!-- AUTOMATIONS PRÉDÉFINIES -->
            <div class="card">
                <div class="card-title">📋 Automations Recommandées</div>
                
                <?php foreach ($defaultAutomations as $auto): ?>
                <div class="automation-item">
                    <div class="automation-header">
                        <div>
                            <div class="automation-name"><?= h($auto['name']) ?></div>
                            <div class="automation-description"><?= h($auto['description']) ?></div>
                            <span class="automation-trigger"><?= h($auto['trigger']) ?></span>
                        </div>
                        <button class="btn btn-primary btn-small" onclick="alert('À implémenter : Activer cette automation')">
                            ➕ Activer
                        </button>
                    </div>
                    
                    <div class="automation-emails">
                        <strong style="font-size: 0.85rem;">📧 Séquence d'emails :</strong>
                        <?php foreach ($auto['emails'] as $email): ?>
                        <div class="email-step">
                            <div class="email-day">
                                <?php if ($email['day'] === 0): ?>
                                    Immédiatement
                                <?php elseif ($email['day'] === 1): ?>
                                    Demain
                                <?php else: ?>
                                    J+<?= $email['day'] ?>
                                <?php endif; ?>
                            </div>
                            <div class="email-subject"><?= h($email['subject']) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- AUTOMATIONS ACTIVES -->
            <?php if (!empty($automations)): ?>
            <div class="card">
                <div class="card-title">✅ Automations Actives</div>
                
                <?php foreach ($automations as $auto): ?>
                <div class="automation-item">
                    <div class="automation-header">
                        <div>
                            <div class="automation-name"><?= h($auto['name']) ?></div>
                            <div class="automation-description"><?= h($auto['description']) ?></div>
                            <span class="automation-trigger"><?= h($auto['trigger']) ?></span>
                        </div>
                        <span class="status-badge <?= $auto['is_active'] ? 'status-active' : 'status-inactive' ?>">
                            <?= $auto['is_active'] ? '🟢 Active' : '🔴 Inactive' ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>