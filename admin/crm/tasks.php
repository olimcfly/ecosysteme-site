<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Gestion des Tâches
 * Liste des tâches avec filtres par priorité, statut et lead
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
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
    // Table already exists or other non-critical error
}

// Filtres
$filterPriority = $_GET['priority'] ?? '';
$filterStatus = $_GET['status'] ?? '';
$filterLead = intval($_GET['lead_id'] ?? 0);

$where = [];
$params = [];

if ($filterPriority) {
    $where[] = "t.priority = ?";
    $params[] = $filterPriority;
}
if ($filterStatus) {
    $where[] = "t.status = ?";
    $params[] = $filterStatus;
}
if ($filterLead) {
    $where[] = "t.lead_id = ?";
    $params[] = $filterLead;
}

$whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";

$sql = "
    SELECT t.*,
           CONCAT(l.firstname, ' ', l.lastname) as lead_name,
           l.email as lead_email
    FROM tasks t
    LEFT JOIN leads l ON t.lead_id = l.id
    {$whereClause}
    ORDER BY
        CASE t.status WHEN 'a_faire' THEN 1 WHEN 'en_cours' THEN 2 WHEN 'terminee' THEN 3 WHEN 'annulee' THEN 4 END,
        t.due_date ASC
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$tasks = $stmt->fetchAll();

// Leads pour le filtre
$leads = $pdo->query("SELECT id, CONCAT(firstname, ' ', lastname) as name FROM leads ORDER BY firstname")->fetchAll();

// Compteurs
$totalTasks = count($tasks);
$stmt = $pdo->query("SELECT COUNT(*) as c FROM tasks WHERE status = 'a_faire'");
$todoCount = $stmt->fetch()['c'];
$stmt = $pdo->query("SELECT COUNT(*) as c FROM tasks WHERE due_date <= CURDATE() AND status IN ('a_faire', 'en_cours')");
$overdueCount = $stmt->fetch()['c'];

// Sidebar badge
$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads");
$totalLeads = $stmt->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Tâches - <?= SITE_NAME ?></title>
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

        .filters {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            display: block;
        }

        .filter-select {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.85rem;
            font-family: inherit;
            background: white;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }

        .filter-btn {
            padding: 0.6rem 1.25rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            background: var(--secondary);
        }

        .filter-reset {
            padding: 0.6rem 1.25rem;
            background: var(--gray-200);
            color: var(--gray-800);
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
        }

        .filter-reset:hover {
            background: var(--gray-300);
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

        .badge-basse { background: #dbeafe; color: #1e40af; }
        .badge-normale { background: #e0e7ff; color: #3730a3; }
        .badge-haute { background: #fef3c7; color: #92400e; }
        .badge-urgente { background: #fee2e2; color: #991b1b; }

        .badge-a_faire { background: #93c5fd; color: #1e3a8a; }
        .badge-en_cours { background: #fcd34d; color: #78350f; }
        .badge-terminee { background: #a7f3d0; color: #065f46; }
        .badge-annulee { background: #e5e7eb; color: #374151; }

        .overdue {
            color: var(--danger);
            font-weight: 600;
        }

        .action-btn {
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

        .action-btn:hover {
            opacity: 0.85;
        }

        .action-btn-view {
            background: var(--primary);
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--gray-500);
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .lead-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .lead-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .filters {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'tasks'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <main class="main app-content">
            <div class="header">
                <div>
                    <h1 class="header-title">📋 Tâches</h1>
                </div>
                <div class="header-date"><?= date('d/m/Y H:i') ?></div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-value"><?= $totalTasks ?></div>
                    <div class="stat-label">Total tâches</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🔵</div>
                    <div class="stat-value"><?= $todoCount ?></div>
                    <div class="stat-label">À faire</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🔴</div>
                    <div class="stat-value"><?= $overdueCount ?></div>
                    <div class="stat-label">En retard</div>
                </div>
            </div>

            <!-- Filtres -->
            <form class="filters" method="GET">
                <div class="filter-group">
                    <label class="filter-label">Priorité</label>
                    <select name="priority" class="filter-select">
                        <option value="">Toutes</option>
                        <option value="basse" <?= $filterPriority === 'basse' ? 'selected' : '' ?>>Basse</option>
                        <option value="normale" <?= $filterPriority === 'normale' ? 'selected' : '' ?>>Normale</option>
                        <option value="haute" <?= $filterPriority === 'haute' ? 'selected' : '' ?>>Haute</option>
                        <option value="urgente" <?= $filterPriority === 'urgente' ? 'selected' : '' ?>>Urgente</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Statut</label>
                    <select name="status" class="filter-select">
                        <option value="">Tous</option>
                        <option value="a_faire" <?= $filterStatus === 'a_faire' ? 'selected' : '' ?>>À faire</option>
                        <option value="en_cours" <?= $filterStatus === 'en_cours' ? 'selected' : '' ?>>En cours</option>
                        <option value="terminee" <?= $filterStatus === 'terminee' ? 'selected' : '' ?>>Terminée</option>
                        <option value="annulee" <?= $filterStatus === 'annulee' ? 'selected' : '' ?>>Annulée</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Lead</label>
                    <select name="lead_id" class="filter-select">
                        <option value="">Tous les leads</option>
                        <?php foreach ($leads as $l): ?>
                            <option value="<?= $l['id'] ?>" <?= $filterLead == $l['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($l['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="filter-btn">Filtrer</button>
                <a href="/admin/crm/tasks" class="filter-reset">Réinitialiser</a>
            </form>

            <!-- Table des tâches -->
            <div class="table-section">
                <div class="table-header">
                    <div class="table-title">Liste des tâches (<?= $totalTasks ?>)</div>
                </div>

                <?php if (empty($tasks)): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <p>Aucune tâche trouvée</p>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tâche</th>
                                <th>Lead</th>
                                <th>Échéance</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $task): ?>
                            <?php
                                $isOverdue = $task['status'] !== 'terminee' && $task['status'] !== 'annulee' && $task['due_date'] < date('Y-m-d');
                                $priorityLabels = ['basse' => 'Basse', 'normale' => 'Normale', 'haute' => 'Haute', 'urgente' => 'Urgente'];
                                $statusLabels = ['a_faire' => 'À faire', 'en_cours' => 'En cours', 'terminee' => 'Terminée', 'annulee' => 'Annulée'];
                            ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($task['title']) ?></strong>
                                    <?php if ($task['description']): ?>
                                        <br><small style="color: var(--gray-500);"><?= htmlspecialchars(mb_strimwidth($task['description'], 0, 80, '...')) ?></small>
                                    <?php endif; ?>
                                </td>
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
                                    <span class="badge badge-<?= $task['status'] ?>">
                                        <?= $statusLabels[$task['status']] ?? $task['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <?php if ($task['status'] !== 'terminee' && $task['status'] !== 'annulee'): ?>
                                            <button class="action-btn" onclick="completeTask(<?= $task['id'] ?>)">Terminer</button>
                                        <?php endif; ?>
                                        <?php if ($task['lead_id']): ?>
                                            <a href="/admin/crm/lead-detail?id=<?= $task['lead_id'] ?>" class="action-btn action-btn-view">Voir lead</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
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
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Erreur');
            }
        })
        .catch(() => alert('Erreur réseau'));
    }
    </script>
</body>
</html>
