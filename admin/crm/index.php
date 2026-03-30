<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Dashboard CRM
 * Page principale de l'espace administrateur
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

// Total des leads
$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads");
$totalLeads = $stmt->fetch()['total'];

// Leads cette semaine
$stmt = $pdo->query("
    SELECT COUNT(*) as total FROM leads 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
");
$thisWeekLeads = $stmt->fetch()['total'];

// À appeler
$stmt = $pdo->query("SELECT COUNT(*) as total FROM v_leads_to_call");
$toCall = $stmt->fetch()['total'] ?? 0;

// Clients
$stmt = $pdo->query("
    SELECT COUNT(*) as total FROM leads 
    WHERE status = 'client' OR status = 'Clients'
");
$clients = $stmt->fetch()['total'];

// En séquence
$stmt = $pdo->query("SELECT COUNT(*) as total FROM v_leads_in_sequence");
$inSequence = $stmt->fetch()['total'] ?? 0;

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

// Tâches du jour (aujourd'hui ou en retard)
$stmt = $pdo->query("
    SELECT t.*,
           CONCAT(l.firstname, ' ', l.lastname) as lead_name
    FROM tasks t
    LEFT JOIN leads l ON t.lead_id = l.id
    WHERE t.due_date <= CURDATE()
      AND t.status IN ('a_faire', 'en_cours')
    ORDER BY t.due_date ASC,
             FIELD(t.priority, 'urgente', 'haute', 'normale', 'basse')
    LIMIT 10
");
$todayTasks = $stmt->fetchAll();

$stmt = $pdo->query("SELECT COUNT(*) as total FROM tasks WHERE status = 'a_faire'");
$todoTaskCount = $stmt->fetch()['total'];

// Leads récents
$stmt = $pdo->query("
    SELECT 
        id, 
        CONCAT(firstname, ' ', lastname) as name, 
        email, 
        intent, 
        status, 
        created_at 
    FROM leads 
    ORDER BY created_at DESC 
    LIMIT 10
");
$recentLeads = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Dashboard CRM - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <?php $activePage = 'dashboard'; ?>
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
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .header-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
        }
        
        .header-date {
            font-size: 0.85rem;
            color: var(--gray-500);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }
        
        .stat-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: var(--gray-500);
            font-weight: 500;
        }
        
        .table-section {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .table-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-900);
        }
        
        .view-all-btn {
            padding: 0.5rem 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .view-all-btn:hover {
            background: var(--secondary);
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table thead {
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
        }
        
        .table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gray-700);
            letter-spacing: 0.5px;
        }
        
        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            font-size: 0.9rem;
        }
        
        .table tbody tr:hover {
            background: var(--gray-50);
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
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
        
        .action-btn {
            padding: 0.4rem 0.8rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0.4rem;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            background: var(--secondary);
        }

        .badge-basse { background: #dbeafe; color: #1e40af; }
        .badge-normale { background: #e0e7ff; color: #3730a3; }
        .badge-haute { background: #fef3c7; color: #92400e; }
        .badge-urgente { background: #fee2e2; color: #991b1b; }

        .badge-a_faire { background: #93c5fd; color: #1e3a8a; }
        .badge-en_cours { background: #fcd34d; color: #78350f; }

        .overdue {
            color: var(--danger);
            font-weight: 600;
        }

        .task-complete-btn {
            padding: 0.4rem 0.8rem;
            background: var(--success);
            color: white;
            border: none;
            border-radius: 0.4rem;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .task-complete-btn:hover {
            opacity: 0.85;
        }

        .tasks-section {
            margin-bottom: 2rem;
        }

        .lead-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        .lead-link:hover { text-decoration: underline; }
        
        @media (max-width: 1024px) {
            .sidebar { width: 200px; }
            .main { margin-left: 200px; }
        }
        
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'dashboard'; include __DIR__ . '/../shared/sidebar.php'; ?>
        
        <main class="main app-content">
            <div class="header">
                <div>
                    <h1 class="header-title">📊 Dashboard</h1>
                </div>
                <div class="header-date"><?= date('d/m/Y H:i') ?></div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value"><?= $totalLeads ?></div>
                    <div class="stat-label">Total Leads</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-value"><?= $thisWeekLeads ?></div>
                    <div class="stat-label">Cette semaine</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">☎️</div>
                    <div class="stat-value"><?= $toCall ?></div>
                    <div class="stat-label">À appeler</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-value"><?= $clients ?></div>
                    <div class="stat-label">Clients</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📧</div>
                    <div class="stat-value"><?= $inSequence ?></div>
                    <div class="stat-label">En séquence</div>
                </div>
            </div>
            
            <!-- Tâches du jour -->
            <div class="table-section tasks-section">
                <div class="table-header">
                    <div class="table-title">📋 Tâches du jour</div>
                    <a href="/admin/crm/tasks" class="view-all-btn">Toutes les tâches</a>
                </div>

                <?php if (empty($todayTasks)): ?>
                    <div style="text-align: center; padding: 2rem; color: var(--gray-500);">
                        Aucune tâche pour aujourd'hui
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tâche</th>
                                <th>Lead</th>
                                <th>Échéance</th>
                                <th>Priorité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($todayTasks as $task): ?>
                            <?php
                                $isOverdue = $task['due_date'] < date('Y-m-d');
                                $priorityLabels = ['basse' => 'Basse', 'normale' => 'Normale', 'haute' => 'Haute', 'urgente' => 'Urgente'];
                            ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($task['title']) ?></strong></td>
                                <td>
                                    <?php if ($task['lead_id']): ?>
                                        <a href="/admin/crm/lead-detail?id=<?= $task['lead_id'] ?>" class="lead-link">
                                            <?= htmlspecialchars($task['lead_name'] ?? 'Lead #' . $task['lead_id']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span style="color: var(--gray-500);">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="<?= $isOverdue ? 'overdue' : '' ?>">
                                    <?= date('d/m/Y', strtotime($task['due_date'])) ?>
                                    <?= $isOverdue ? ' (en retard)' : '' ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $task['priority'] ?>">
                                        <?= $priorityLabels[$task['priority']] ?? $task['priority'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="task-complete-btn" onclick="completeTask(<?= $task['id'] ?>)">Terminer</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="table-section">
                <div class="table-header">
                    <div class="table-title">Leads récents</div>
                    <a href="/admin/crm/leads" class="view-all-btn">Voir tout</a>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Intent</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentLeads as $lead): ?>
                        <tr>
                            <td><strong><?= h($lead['name']) ?></strong></td>
                            <td><?= h($lead['email']) ?></td>
                            <td>
                                <?php
                                $intentMap = [
                                    'cold' => ['label' => 'Cold', 'class' => 'badge-cold'],
                                    'ressource' => ['label' => 'Ressource', 'class' => 'badge-ressource'],
                                    'outil' => ['label' => 'Outil', 'class' => 'badge-outil'],
                                    'diagnostic' => ['label' => 'Diagnostic', 'class' => 'badge-diagnostic'],
                                    'demo' => ['label' => 'Demo', 'class' => 'badge-demo'],
                                ];
                                $intent = $lead['intent'] ?? 'cold';
                                $intentInfo = $intentMap[$intent] ?? ['label' => ucfirst($intent), 'class' => 'badge-outil'];
                                ?>
                                <span class="badge <?= $intentInfo['class'] ?>"><?= h($intentInfo['label']) ?></span>
                            </td>
                            <td>
                                <?php
                                $statusMap = [
                                    'nouveau' => 'badge-nouveau',
                                    'en_reflexion' => 'badge-reflexion',
                                    'actif' => 'badge-actif',
                                    'appel_re' => 'badge-appel',
                                    'client' => 'badge-client',
                                ];
                                $statusClass = $statusMap[$lead['status']] ?? 'badge-nouveau';
                                $statusLabel = ucfirst(str_replace('_', ' ', $lead['status'] ?? 'nouveau'));
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= h($statusLabel) ?></span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($lead['created_at'])) ?></td>
                            <td>
                                <a href="/admin/crm/lead-detail?id=<?= $lead['id'] ?>" class="action-btn">Voir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
