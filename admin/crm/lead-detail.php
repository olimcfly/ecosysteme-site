<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Détail d'un Lead
 * Page pour consulter et modifier les infos d'un lead
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

// Récupérer l'ID du lead
$leadId = intval($_GET['id'] ?? 0);
if (!$leadId) {
    header('Location: /admin/crm/leads');
    exit;
}

// ============================================
// RÉCUPÉRER LE LEAD
// ============================================
$stmt = $pdo->prepare("SELECT * FROM leads WHERE id = ?");
$stmt->execute([$leadId]);
$lead = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lead) {
    header('Location: /admin/crm/leads');
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
    $newStatus = $_POST['status'] ?? $lead['status'];
    $newNotes = $_POST['notes'] ?? $lead['notes'];
    $callBooked = isset($_POST['call_booked']) ? 1 : 0;
    
    $stmt = $pdo->prepare("
        UPDATE leads 
        SET status = ?, notes = ?, call_booked_at = IF(? = 1, NOW(), call_booked_at), updated_at = NOW()
        WHERE id = ?
    ");
    
    if ($stmt->execute([$newStatus, $newNotes, $callBooked, $leadId])) {
        $message = '✅ Lead mis à jour avec succès';
        $messageType = 'success';
        
        // Recharger les données
        $stmt = $pdo->prepare("SELECT * FROM leads WHERE id = ?");
        $stmt->execute([$leadId]);
        $lead = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $message = '❌ Erreur lors de la mise à jour';
        $messageType = 'error';
    }
}

// Créer la table tasks si elle n'existe pas
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tasks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            lead_id INT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NULL,
            due_date DATE NOT NULL,
            priority ENUM('basse', 'normale', 'haute', 'urgente') NOT NULL DEFAULT 'normale',
            status ENUM('a_faire', 'en_cours', 'terminee', 'annulee') NOT NULL DEFAULT 'a_faire',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            completed_at DATETIME NULL,
            INDEX idx_due_date (due_date),
            INDEX idx_status (status),
            INDEX idx_priority (priority),
            INDEX idx_lead_id (lead_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
} catch (PDOException $e) {
    // Table already exists
}

// Traiter création de tâche
$taskMessage = '';
$taskMessageType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_task'])) {
    $taskTitle = trim($_POST['task_title'] ?? '');
    $taskDesc = trim($_POST['task_description'] ?? '');
    $taskDueDate = $_POST['task_due_date'] ?? '';
    $taskPriority = $_POST['task_priority'] ?? 'normale';

    if ($taskTitle && $taskDueDate) {
        $stmt = $pdo->prepare("
            INSERT INTO tasks (lead_id, title, description, due_date, priority, status, created_at)
            VALUES (?, ?, ?, ?, ?, 'a_faire', NOW())
        ");
        if ($stmt->execute([$leadId, $taskTitle, $taskDesc ?: null, $taskDueDate, $taskPriority])) {
            $taskMessage = 'Tâche créée avec succès';
            $taskMessageType = 'success';
        } else {
            $taskMessage = 'Erreur lors de la création de la tâche';
            $taskMessageType = 'error';
        }
    } else {
        $taskMessage = 'Titre et date d\'échéance requis';
        $taskMessageType = 'error';
    }
}

// Tâches du lead
$stmt = $pdo->prepare("
    SELECT * FROM tasks
    WHERE lead_id = ?
    ORDER BY
        CASE status WHEN 'a_faire' THEN 1 WHEN 'en_cours' THEN 2 WHEN 'terminee' THEN 3 WHEN 'annulee' THEN 4 END,
        due_date ASC
");
$stmt->execute([$leadId]);
$leadTasks = $stmt->fetchAll();

// Récupérer les statuts disponibles
$stmt = $pdo->query("SELECT DISTINCT status FROM leads WHERE status IS NOT NULL ORDER BY status");
$statuses = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Détail du Lead - <?= SITE_NAME ?></title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }
        
        .header-left h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb {
            font-size: 0.85rem;
            color: var(--gray-500);
        }
        
        .back-btn {
            padding: 0.75rem 1.5rem;
            background: var(--gray-200);
            color: var(--gray-800);
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .back-btn:hover {
            background: var(--gray-300);
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
        
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
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
        
        .info-group {
            margin-bottom: 1.5rem;
        }
        
        .info-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--gray-500);
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }
        
        .info-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--gray-900);
            word-break: break-all;
        }
        
        .badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-diagnostic { background: #fca5a5; color: #7f1d1d; }
        .badge-ressource { background: #86efac; color: #166534; }
        .badge-outil { background: #fcd34d; color: #78350f; }
        .badge-nouveau { background: #93c5fd; color: #1e3a8a; }
        .badge-reflexion { background: #fbcfe8; color: #831843; }
        .badge-actif { background: #c7d2fe; color: #3730a3; }
        .badge-appel { background: #fecaca; color: #7f1d1d; }
        .badge-client { background: #a7f3d0; color: #065f46; }
        .badge-cold { background: #fcd34d; color: #78350f; }
        .badge-demo { background: #c7d2fe; color: #3730a3; }
        
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
        
        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
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
        
        .score-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 0.5rem;
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .button-group .btn {
            flex: 1;
        }

        .badge-basse { background: #dbeafe; color: #1e40af; }
        .badge-normale { background: #e0e7ff; color: #3730a3; }
        .badge-haute { background: #fef3c7; color: #92400e; }
        .badge-urgente { background: #fee2e2; color: #991b1b; }

        .badge-a_faire { background: #93c5fd; color: #1e3a8a; }
        .badge-en_cours { background: #fcd34d; color: #78350f; }
        .badge-terminee { background: #a7f3d0; color: #065f46; }
        .badge-annulee { background: #e5e7eb; color: #374151; }

        .overdue { color: var(--danger); font-weight: 600; }

        .task-complete-btn {
            padding: 0.4rem 0.8rem;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 0.4rem;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .task-complete-btn:hover { opacity: 0.85; }

        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
            gap: 1rem;
        }
        .task-item:last-child { border-bottom: none; }

        .task-info { flex: 1; }
        .task-title-text { font-weight: 600; font-size: 0.9rem; }
        .task-meta { font-size: 0.8rem; color: var(--gray-500); margin-top: 0.25rem; display: flex; gap: 0.75rem; align-items: center; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .main { padding: 1rem; }
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .grid-2 {
                grid-template-columns: 1fr;
            }
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'leads'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <main class="main app-content">
            <div class="header">
                <div class="header-left">
                    <h1>👤 <?= h($lead['firstname'] ?? '') ?> <?= h($lead['lastname'] ?? '') ?></h1>
                    <div class="breadcrumb">Dashboard > Leads > Détail</div>
                </div>
                <a href="/admin/crm/leads" class="back-btn">← Retour</a>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>">
                    <span><?= $message ?></span>
                </div>
            <?php endif; ?>
            
            <div class="grid-2">
                <!-- Infos Lead -->
                <div class="card">
                    <div class="card-title">ℹ️ Informations Générales</div>
                    
                    <div class="info-group">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            <a href="mailto:<?= h($lead['email']) ?>" style="color: var(--primary); text-decoration: none;">
                                <?= h($lead['email']) ?>
                            </a>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Téléphone</div>
                        <div class="info-value">
                            <?php if ($lead['phone']): ?>
                                <a href="tel:<?= h($lead['phone']) ?>" style="color: var(--primary); text-decoration: none;">
                                    <?= h($lead['phone']) ?>
                                </a>
                            <?php else: ?>
                                <span style="color: var(--gray-500);">Non fourni</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Ville</div>
                        <div class="info-value"><?= h($lead['city'] ?? 'Non fournie') ?></div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Intent</div>
                        <div class="info-value">
                            <?php
                            $intentMap = [
                                'cold' => 'badge-cold',
                                'ressource' => 'badge-ressource',
                                'outil' => 'badge-outil',
                                'diagnostic' => 'badge-diagnostic',
                                'demo' => 'badge-demo',
                            ];
                            $intentClass = $intentMap[$lead['intent']] ?? 'badge-cold';
                            ?>
                            <span class="badge <?= $intentClass ?>"><?= ucfirst(h($lead['intent'] ?? 'cold')) ?></span>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Score</div>
                        <div class="info-value">
                            <span class="score-badge"><?= intval($lead['score'] ?? 0) ?></span>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Date d'ajout</div>
                        <div class="info-value"><?= date('d/m/Y H:i', strtotime($lead['created_at'])) ?></div>
                    </div>
                </div>
                
                <!-- Modification -->
                <div class="card">
                    <div class="card-title">✏️ Modifier</div>
                    
                    <form method="POST">
                        <?= csrfField() ?>
                        <div class="form-group">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select">
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?= h($status) ?>" 
                                            <?= $lead['status'] === $status ? 'selected' : '' ?>>
                                        <?= ucfirst(str_replace('_', ' ', h($status))) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-textarea" placeholder="Ajouter des notes sur ce lead..."><?= h($lead['notes'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="call_booked" name="call_booked" class="checkbox" 
                                       <?= !empty($lead['call_booked_at']) ? 'checked' : '' ?>>
                                <label for="call_booked" style="margin: 0; cursor: pointer;">
                                    ☎️ Appel programmé
                                </label>
                            </div>
                        </div>
                        
                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                            <a href="/admin/crm/leads" class="btn btn-secondary" style="text-decoration: none; text-align: center;">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Message Lead -->
            <?php if (!empty($lead['message'])): ?>
            <div class="card" style="margin-top: 2rem;">
                <div class="card-title">💬 Message Initial</div>
                <div class="info-value" style="line-height: 1.6;">
                    <?= nl2br(h($lead['message'])) ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Section Tâches -->
            <div style="margin-top: 2rem;">
                <div class="grid-2">
                    <!-- Créer une tâche -->
                    <div class="card">
                        <div class="card-title">📋 Nouvelle Tâche</div>

                        <?php if ($taskMessage): ?>
                            <div class="alert alert-<?= $taskMessageType ?>" style="margin-bottom: 1rem;">
                                <span><?= $taskMessageType === 'success' ? '✅' : '❌' ?> <?= htmlspecialchars($taskMessage) ?></span>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <input type="hidden" name="create_task" value="1">

                            <div class="form-group">
                                <label class="form-label">Titre</label>
                                <input type="text" name="task_title" class="form-input" placeholder="Ex: Rappeler le lead..." required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Description (optionnel)</label>
                                <textarea name="task_description" class="form-textarea" style="min-height: 80px;" placeholder="Détails de la tâche..."></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Échéance</label>
                                    <input type="date" name="task_due_date" class="form-input" value="<?= date('Y-m-d') ?>" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Priorité</label>
                                    <select name="task_priority" class="form-select">
                                        <option value="basse">Basse</option>
                                        <option value="normale" selected>Normale</option>
                                        <option value="haute">Haute</option>
                                        <option value="urgente">Urgente</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%;">Créer la tâche</button>
                        </form>
                    </div>

                    <!-- Liste des tâches du lead -->
                    <div class="card">
                        <div class="card-title">✅ Tâches de ce lead (<?= count($leadTasks) ?>)</div>

                        <?php if (empty($leadTasks)): ?>
                            <div style="text-align: center; padding: 2rem; color: var(--gray-500);">
                                Aucune tâche pour ce lead
                            </div>
                        <?php else: ?>
                            <?php
                            $priorityLabels = ['basse' => 'Basse', 'normale' => 'Normale', 'haute' => 'Haute', 'urgente' => 'Urgente'];
                            $statusLabels = ['a_faire' => 'À faire', 'en_cours' => 'En cours', 'terminee' => 'Terminée', 'annulee' => 'Annulée'];
                            ?>
                            <?php foreach ($leadTasks as $task): ?>
                            <?php $isOverdue = $task['status'] !== 'terminee' && $task['status'] !== 'annulee' && $task['due_date'] < date('Y-m-d'); ?>
                            <div class="task-item">
                                <div class="task-info">
                                    <div class="task-title-text" style="<?= $task['status'] === 'terminee' ? 'text-decoration: line-through; opacity: 0.6;' : '' ?>">
                                        <?= htmlspecialchars($task['title']) ?>
                                    </div>
                                    <div class="task-meta">
                                        <span class="<?= $isOverdue ? 'overdue' : '' ?>"><?= date('d/m/Y', strtotime($task['due_date'])) ?><?= $isOverdue ? ' (retard)' : '' ?></span>
                                        <span class="badge badge-<?= $task['priority'] ?>"><?= $priorityLabels[$task['priority']] ?? $task['priority'] ?></span>
                                        <span class="badge badge-<?= $task['status'] ?>"><?= $statusLabels[$task['status']] ?? $task['status'] ?></span>
                                    </div>
                                </div>
                                <?php if ($task['status'] !== 'terminee' && $task['status'] !== 'annulee'): ?>
                                    <button class="task-complete-btn" onclick="completeTask(<?= $task['id'] ?>)">Terminer</button>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
    function completeTask(taskId) {
        if (!confirm('Marquer cette tâche comme terminée ?')) return;
        fetch('/admin/crm/api?action=complete_task', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ task_id: taskId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) location.reload();
            else alert(data.message || 'Erreur');
        })
        .catch(() => alert('Erreur réseau'));
    }
    </script>
</body>
</html>