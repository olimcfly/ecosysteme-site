<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Messagerie Complète
 * Style Gmail: Reçus | Envoyés | Brouillons
 * Layout: Liste (gauche) + Détail + Réponse (droite)
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

    if ($action === 'send_reply') {
        $to = trim($_POST['to'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $body = trim($_POST['body'] ?? '');
        
        if (!$to || !$subject || !$body) {
            $message = '❌ Tous les champs sont requis';
            $messageType = 'error';
        } elseif (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $message = '❌ Email invalide';
            $messageType = 'error';
        } else {
            try {
                // Envoyer l'email via SMTP
                $headers = "From: " . SMTP_FROM_EMAIL . "\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                
                if (@mail($to, $subject, nl2br($body), $headers)) {
                    // Enregistrer en BD table emails
                    $stmt = $pdo->prepare("
                        INSERT INTO emails (type, from_email, to_email, subject, body, sent_at)
                        VALUES ('sent', ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([SMTP_FROM_EMAIL, $to, $subject, $body]);
                    
                    $message = '✅ Email envoyé avec succès';
                    $messageType = 'success';
                } else {
                    $message = '❌ Erreur lors de l\'envoi de l\'email';
                    $messageType = 'error';
                }
            } catch (Exception $e) {
                error_log("Send email error: " . $e->getMessage());
                $message = '❌ Erreur: ' . $e->getMessage();
                $messageType = 'error';
            }
        }
    }
}

// ============================================
// PARAMÈTRES
// ============================================
$tab = $_GET['tab'] ?? 'received';
$emailId = intval($_GET['email_id'] ?? 0);
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 15;
$offset = ($page - 1) * $perPage;

// ============================================
// RÉCUPÉRER LES EMAILS
// ============================================
$emails = [];
$totalEmails = 0;
$selectedEmail = null;

try {
    $typeMap = [
        'received' => 'received',
        'sent' => 'sent',
        'drafts' => 'draft'
    ];
    $type = $typeMap[$tab] ?? 'received';
    
    // Total
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM emails WHERE type = ?");
    $stmt->execute([$type]);
    $totalEmails = $stmt->fetch()['total'];
    
    // Liste emails - Corriger l'ordre
    $stmt = $pdo->prepare("
        SELECT id, from_email, to_email, subject, body, created_at, sent_at, updated_at, type
        FROM emails
        WHERE type = ?
        ORDER BY COALESCE(sent_at, created_at) DESC
        LIMIT ? OFFSET ?
    ");
    $stmt->execute([$type, $perPage, $offset]);
    $emails = $stmt->fetchAll();
    
    // Email sélectionné
    if ($emailId) {
        $stmt = $pdo->prepare("SELECT * FROM emails WHERE id = ? AND type = ?");
        $stmt->execute([$emailId, $type]);
        $selectedEmail = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Marquer comme lu si reçu
        if ($selectedEmail && $type === 'received' && !$selectedEmail['is_read']) {
            $stmt = $pdo->prepare("UPDATE emails SET is_read = 1, read_at = NOW() WHERE id = ?");
            $stmt->execute([$emailId]);
            $selectedEmail['is_read'] = 1;
        }
    }
    
} catch (Exception $e) {
    error_log("Email fetch error: " . $e->getMessage());
    $emails = [];
    $totalEmails = 0;
}

$totalPages = ceil($totalEmails / $perPage);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Messagerie - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-700: #374151;
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
        
        .sidebar {
            width: 220px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 2rem;
        }
        
        .sidebar-title {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }
        
        .sidebar-section {
            margin-bottom: 2rem;
            padding: 0 1rem;
        }
        
        .sidebar-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.6;
            margin-bottom: 0.75rem;
            padding: 0 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
        }
        
        .sidebar-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar-item.active {
            background: rgba(255,255,255,0.2);
            color: white;
            font-weight: 600;
        }
        
        .sidebar-icon {
            font-size: 1.2rem;
            width: 1.5rem;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .user-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }
        
        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        
        .user-info {
            flex: 1;
            font-size: 0.85rem;
        }
        
        .user-name {
            font-weight: 600;
        }
        
        .user-email {
            opacity: 0.7;
            font-size: 0.75rem;
        }
        
        .logout-btn {
            width: 100%;
            padding: 0.5rem;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .main {
            flex: 1;
            margin-left: 220px;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        
        .header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--gray-200);
            background: white;
        }
        
        .header-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .content {
            flex: 1;
            display: grid;
            grid-template-columns: 35% 1fr;
            gap: 0;
            overflow: hidden;
        }
        
        .list-panel {
            background: white;
            border-right: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
        }
        
        .detail-panel {
            background: white;
            overflow-y: auto;
        }
        
        .tabs {
            display: flex;
            padding: 0;
            border-bottom: 2px solid var(--gray-200);
        }
        
        .tab-btn {
            flex: 1;
            padding: 0.75rem;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            color: var(--gray-600);
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }
        
        .tab-btn:hover {
            background: var(--gray-50);
        }
        
        .email-list {
            flex: 1;
            overflow-y: auto;
        }
        
        .email-item {
            padding: 0.75rem;
            border-bottom: 1px solid var(--gray-100);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .email-item:hover {
            background: var(--gray-50);
        }
        
        .email-item.selected {
            background: var(--gray-100);
            border-left: 4px solid var(--primary);
            padding-left: calc(0.75rem - 4px);
        }
        
        .email-from {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        .email-subject {
            font-size: 0.85rem;
            color: var(--gray-700);
            margin-bottom: 0.35rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .email-preview {
            font-size: 0.8rem;
            color: var(--gray-500);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-bottom: 0.35rem;
        }
        
        .email-date {
            font-size: 0.75rem;
            color: var(--gray-400);
        }
        
        .empty-state {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--gray-500);
            text-align: center;
            flex-direction: column;
        }
        
        .empty-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .detail-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background: white;
        }
        
        .detail-from {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }
        
        .detail-subject {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }
        
        .detail-meta {
            font-size: 0.8rem;
            color: var(--gray-500);
        }
        
        .detail-body {
            padding: 1.5rem;
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            white-space: pre-wrap;
            word-wrap: break-word;
            line-height: 1.6;
            color: var(--gray-700);
            min-height: 200px;
        }
        
        .reply-form {
            padding: 1.5rem;
            background: white;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.35rem;
            display: block;
        }
        
        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.4rem;
            font-size: 0.85rem;
            font-family: inherit;
            transition: all 0.2s;
        }
        
        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 0.4rem;
            font-size: 0.85rem;
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
        
        .btn-group {
            display: flex;
            gap: 0.75rem;
        }
        
        .alert {
            padding: 0.75rem;
            border-radius: 0.4rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
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
        
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main { margin-left: 0; }
            .content { grid-template-columns: 1fr; }
            .list-panel { border-right: none; max-height: 40vh; }
            .detail-panel { border-top: 1px solid var(--gray-200); }
            .sidebar-footer { position: relative; bottom: auto; }
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">🎯 ÉCOSYSTÈME IMMO LOCAL+</div>
            </div>
            
            <nav class="sidebar-menu">
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Principal</div>
                    <a href="/admin/crm" class="sidebar-item">
                        <span class="sidebar-icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="/admin/crm/leads" class="sidebar-item">
                        <span class="sidebar-icon">👥</span>
                        <span>Leads</span>
                    </a>
                </div>
                
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Offres</div>
                    <a href="/admin/crm/offre-generator" class="sidebar-item">
                        <span class="sidebar-icon">🤖</span>
                        <span>Générateur IA</span>
                    </a>
                    <a href="/admin/crm/offres" class="sidebar-item">
                        <span class="sidebar-icon">📋</span>
                        <span>Mes Offres</span>
                    </a>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-section-title">Outils</div>
                    <a href="/admin/contacts" class="sidebar-item">
                        <span class="sidebar-icon">💌</span>
                        <span>Demandes</span>
                    </a>
                    <a href="/admin/emails" class="sidebar-item active">
                        <span class="sidebar-icon">📧</span>
                        <span>Messagerie</span>
                    </a>
                    <a href="/admin/emails/analytics.php" class="sidebar-item">
                        <span class="sidebar-icon">📈</span>
                        <span>Analytics</span>
                    </a>
                    <a href="/admin/emails/bounces.php" class="sidebar-item">
                        <span class="sidebar-icon">🚫</span>
                        <span>Bounces</span>
                    </a>
                </div>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-card">
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['admin_firstname'] ?? 'A', 0, 1)) ?></div>
                    <div class="user-info">
                        <span class="user-name"><?= h($_SESSION['admin_firstname'] ?? 'Admin') ?></span>
                        <span class="user-email"><?= h($_SESSION['admin_email'] ?? '') ?></span>
                    </div>
                </div>
                <a href="/admin/auth/logout" class="logout-btn">Déconnexion</a>
            </div>
        </aside>
        
        <main class="main">
            <div class="header">
                <h1 class="header-title">📧 Messagerie</h1>
            </div>
            
            <?php if ($message): ?>
                <div style="padding: 0 1.5rem;">
                    <div class="alert alert-<?= $messageType ?>">
                        <?= $message ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="content">
                <!-- LISTE GAUCHE -->
                <div class="list-panel">
                    <div class="tabs">
                        <a href="?tab=received" class="tab-btn <?= $tab === 'received' ? 'active' : '' ?>">
                            📥 Reçus
                        </a>
                        <a href="?tab=sent" class="tab-btn <?= $tab === 'sent' ? 'active' : '' ?>">
                            📤 Envoyés
                        </a>
                        <a href="?tab=drafts" class="tab-btn <?= $tab === 'drafts' ? 'active' : '' ?>">
                            📝 Brouillons
                        </a>
                    </div>
                    
                    <div class="email-list">
                        <?php if (empty($emails)): ?>
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <div>Aucun email</div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($emails as $email): ?>
                            <a href="?tab=<?= $tab ?>&email_id=<?= $email['id'] ?>" class="email-item <?= $selectedEmail && $selectedEmail['id'] === $email['id'] ? 'selected' : '' ?>">
                                <div class="email-from">
                                    <?= $email['type'] === 'sent' ? h($email['to_email']) : h($email['from_email']) ?>
                                </div>
                                <div class="email-subject">
                                    <?= h($email['subject']) ?>
                                </div>
                                <div class="email-preview">
                                    <?= h(substr(strip_tags($email['body']), 0, 35)) ?>...
                                </div>
                                <div class="email-date">
                                    <?= date('d/m H:i', strtotime($email['sent_at'] ?? $email['created_at'] ?? $email['updated_at'])) ?>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- DÉTAIL DROITE -->
                <div class="detail-panel">
                    <?php if ($selectedEmail): ?>
                        <div class="detail-header">
                            <div class="detail-from">
                                <?php if ($selectedEmail['type'] === 'sent'): ?>
                                    ✓ À: <?= h($selectedEmail['to_email']) ?>
                                <?php else: ?>
                                    📬 De: <?= h($selectedEmail['from_email']) ?>
                                <?php endif; ?>
                            </div>
                            <div class="detail-subject">
                                <?= h($selectedEmail['subject']) ?>
                            </div>
                            <div class="detail-meta">
                                <?= date('d/m/Y H:i', strtotime($selectedEmail['sent_at'] ?? $selectedEmail['created_at'] ?? $selectedEmail['updated_at'])) ?>
                            </div>
                        </div>
                        
                        <div class="detail-body">
                            <?= h($selectedEmail['body']) ?>
                        </div>
                        
                        <?php if ($selectedEmail['type'] === 'received'): ?>
                        <div class="reply-form">
                            <form method="POST">
                                <?= csrfField() ?>
                                <input type="hidden" name="action" value="send_reply">
                                <input type="hidden" name="to" value="<?= h($selectedEmail['from_email']) ?>">
                                
                                <div class="form-group">
                                    <label class="form-label">Sujet</label>
                                    <input type="text" name="subject" class="form-input" 
                                           value="RE: <?= h($selectedEmail['subject']) ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Votre réponse</label>
                                    <textarea name="body" class="form-textarea" required></textarea>
                                </div>
                                
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">✉️ Envoyer</button>
                                    <button type="reset" class="btn btn-secondary">↺ Annuler</button>
                                </div>
                            </form>
                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon">👈</div>
                            <div>Sélectionnez un email</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>