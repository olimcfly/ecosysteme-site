<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Détail et Réponse à une Demande
 * Page admin pour voir le détail et répondre
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/security-headers.php';
require_once __DIR__ . '/../../includes/csrf.php';

$id = $_GET['id'] ?? 0;

if (!$id) {
    header('Location: /admin/contacts/');
    exit;
}

// Récupérer la demande
$stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->execute([$id]);
$contact = $stmt->fetch();

if (!$contact) {
    die('Demande non trouvée');
}

// Marquer comme lue
if (!$contact['is_read']) {
    $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = 1, read_at = NOW() WHERE id = ?");
    $stmt->execute([$id]);
}

// Traiter réponse si POST
$reply_sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_message'])) {
    if (!validateCsrfToken()) {
        die('Token de sécurité invalide.');
    }
    $reply_message = trim($_POST['reply_message']);
    
    if ($reply_message) {
        // Envoyer email
        $subject = "Re: Votre demande - ÉCOSYSTÈME IMMO LOCAL+";
        $body = $reply_message . "\n\n---\nÉCOSYSTÈME IMMO LOCAL+\ncontact@ecosystemeimmo.fr";
        
        $from_email = defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : 'admin@ecosystemeimmo.fr';
        $headers = "From: {$from_email}\r\nContent-Type: text/plain; charset=UTF-8";
        
        @mail($contact['email'], $subject, $body, $headers);
        
        // Marquer comme répondue
        $stmt = $pdo->prepare("UPDATE contact_messages SET is_replied = 1, replied_at = NOW() WHERE id = ?");
        $stmt->execute([$id]);
        
        $reply_sent = true;
        $contact['is_replied'] = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande #<?= $contact['id'] ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-900: #111827;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .header {
            margin-bottom: 2rem;
        }
        
        .back-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1rem;
            display: inline-block;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
        }
        
        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        
        .card {
            background: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .card h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-100);
        }
        
        .field {
            margin-bottom: 1.5rem;
        }
        
        .field-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gray-500);
            margin-bottom: 0.35rem;
        }
        
        .field-value {
            font-size: 1rem;
            color: var(--gray-900);
            word-break: break-word;
        }
        
        .message-box {
            background: var(--gray-50);
            padding: 1.5rem;
            border-left: 4px solid var(--primary);
            border-radius: 0.5rem;
            font-style: italic;
            line-height: 1.6;
            color: var(--gray-700);
        }
        
        .sidebar-item {
            margin-bottom: 1.5rem;
        }
        
        .badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .badge-replied {
            background: #d1fae5;
            color: #065f46;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .form-textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.95rem;
            resize: vertical;
            min-height: 150px;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            opacity: 0.9;
        }
        
        .success-message {
            background: #d1fae5;
            color: #065f46;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #6ee7b7;
        }
        
        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/contacts/" class="back-link">← Retour aux demandes</a>
        
        <div class="header">
            <h1>Demande #<?= $contact['id'] ?></h1>
        </div>
        
        <div class="grid">
            <!-- CONTENU PRINCIPAL -->
            <div>
                <!-- MESSAGE DE SUCCÈS -->
                <?php if ($reply_sent): ?>
                <div class="success-message">
                    ✓ Réponse envoyée avec succès à <?= h($contact['email']) ?>
                </div>
                <?php endif; ?>
                
                <!-- DÉTAIL DE LA DEMANDE -->
                <div class="card">
                    <h2>Détail de la demande</h2>
                    
                    <div class="field">
                        <div class="field-label">Nom</div>
                        <div class="field-value"><?= h($contact['nom']) ?></div>
                    </div>
                    
                    <div class="field">
                        <div class="field-label">Email</div>
                        <div class="field-value">
                            <a href="mailto:<?= h($contact['email']) ?>" style="color: var(--primary); text-decoration: none;">
                                <?= h($contact['email']) ?>
                            </a>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="field-label">Téléphone</div>
                        <div class="field-value"><?= h($contact['telephone'] ?? '-') ?></div>
                    </div>
                    
                    <div class="field">
                        <div class="field-label">Ville</div>
                        <div class="field-value"><?= h($contact['ville'] ?? '-') ?></div>
                    </div>
                    
                    <div class="field">
                        <div class="field-label">Type de demande</div>
                        <div class="field-value"><?= h($contact['type_demande']) ?></div>
                    </div>
                    
                    <div class="field">
                        <div class="field-label">Message</div>
                        <div class="message-box">
                            <?= nl2br(h($contact['message'])) ?>
                        </div>
                    </div>
                </div>
                
                <!-- FORMULAIRE DE RÉPONSE -->
                <?php if (!$contact['is_replied']): ?>
                <div class="card">
                    <h2>Envoyer une réponse</h2>
                    
                    <form method="POST">
                        <?= csrfField() ?>
                        <div class="form-group">
                            <label class="form-label">Votre message</label>
                            <textarea name="reply_message" class="form-textarea" required placeholder="Composez votre réponse..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            📧 Envoyer la réponse
                        </button>
                    </form>
                </div>
                <?php else: ?>
                <div class="card" style="background: #f0fdf4; border-left: 4px solid var(--success);">
                    <h2>✓ Réponse envoyée</h2>
                    <p>Vous avez déjà répondu à cette demande le <?= date('d/m/Y à H:i', strtotime($contact['replied_at'])) ?></p>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- SIDEBAR -->
            <div>
                <!-- STATUT -->
                <div class="card">
                    <h2>Statut</h2>
                    
                    <div class="sidebar-item">
                        <div class="field-label">État</div>
                        <?php if ($contact['is_replied']): ?>
                            <span class="badge badge-replied">✓ Répondue</span>
                        <?php else: ?>
                            <span class="badge badge-pending">⚠ En attente</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="sidebar-item">
                        <div class="field-label">Date de réception</div>
                        <div class="field-value"><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></div>
                    </div>
                    
                    <?php if ($contact['read_at']): ?>
                    <div class="sidebar-item">
                        <div class="field-label">Lue le</div>
                        <div class="field-value"><?= date('d/m/Y H:i', strtotime($contact['read_at'])) ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($contact['replied_at']): ?>
                    <div class="sidebar-item">
                        <div class="field-label">Répondue le</div>
                        <div class="field-value"><?= date('d/m/Y H:i', strtotime($contact['replied_at'])) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- NOTES -->
                <div class="card">
                    <h2>Notes</h2>
                    <p style="color: var(--gray-500);">
                        <?= h($contact['notes'] ?? 'Aucune note') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>