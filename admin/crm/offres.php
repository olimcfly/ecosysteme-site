<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Mes Offres
 * Liste et gestion des offres sauvegardées
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

// Créer la table si elle n'existe pas
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS offres (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titre VARCHAR(255) NOT NULL,
            persona TEXT NULL,
            probleme TEXT NULL,
            motivation TEXT NULL,
            promesse TEXT NULL,
            methode TEXT NULL,
            contenu_offre TEXT NULL,
            prix_valeur TEXT NULL,
            preuves TEXT NULL,
            resume_offre TEXT NULL,
            conversation JSON NULL,
            statut ENUM('brouillon', 'validee', 'active', 'archivee') NOT NULL DEFAULT 'brouillon',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_statut (statut),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
} catch (PDOException $e) {
    // Already exists
}

// Stats sidebar
$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads");
$totalLeads = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads WHERE status = 'client' OR status = 'Clients'");
$clients = $stmt->fetch()['total'];

// Filtre par statut
$statutFilter = $_GET['statut'] ?? '';
$sql = "SELECT id, titre, persona, promesse, statut, created_at, updated_at FROM offres";
$params = [];

if ($statutFilter && in_array($statutFilter, ['brouillon', 'validee', 'active', 'archivee'])) {
    $sql .= " WHERE statut = ?";
    $params[] = $statutFilter;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$offres = $stmt->fetchAll();

$totalOffres = count($offres);

// Compteurs par statut
$stmt = $pdo->query("SELECT statut, COUNT(*) as total FROM offres GROUP BY statut");
$statutCounts = [];
while ($row = $stmt->fetch()) {
    $statutCounts[$row['statut']] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Mes Offres - <?= SITE_NAME ?></title>
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
            --gray-300: #d1d5db;
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

        .container { display: flex; min-height: 100vh; }

        .sidebar {
            width: 220px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-header { padding: 0 1.5rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 2rem; }
        .sidebar-title { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; opacity: 0.8; letter-spacing: 0.5px; }
        .sidebar-section { margin-bottom: 2rem; padding: 0 1rem; }
        .sidebar-section-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; opacity: 0.6; margin-bottom: 0.75rem; padding: 0 0.5rem; letter-spacing: 0.5px; }
        .sidebar-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; margin-bottom: 0.5rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; text-decoration: none; color: rgba(255,255,255,0.8); font-size: 0.9rem; }
        .sidebar-item:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-item.active { background: rgba(255,255,255,0.2); color: white; font-weight: 600; }
        .sidebar-icon { font-size: 1.2rem; width: 1.5rem; }
        .sidebar-badge { margin-left: auto; background: rgba(255,255,255,0.3); padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
        .sidebar-footer { position: absolute; bottom: 0; left: 0; right: 0; padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-card { display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 1rem; }
        .user-avatar { width: 2.5rem; height: 2.5rem; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; }
        .user-info { flex: 1; font-size: 0.85rem; }
        .user-name { font-weight: 600; display: block; }
        .user-email { opacity: 0.7; font-size: 0.75rem; }
        .logout-btn { width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 0.5rem; cursor: pointer; font-size: 0.85rem; font-weight: 500; transition: all 0.2s; text-decoration: none; display: block; text-align: center; }
        .logout-btn:hover { background: rgba(255,255,255,0.3); }

        .main {
            flex: 1;
            margin-left: 220px;
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
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--secondary); }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-card:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .stat-card.active-filter { border: 2px solid var(--primary); }

        .stat-value { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem; }
        .stat-label { font-size: 0.8rem; color: var(--gray-500); font-weight: 500; }

        /* Table */
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

        .table-title { font-size: 1.1rem; font-weight: 600; }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead { background: var(--gray-50); border-bottom: 1px solid var(--gray-200); }
        .table th { padding: 1rem 1.5rem; text-align: left; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; color: var(--gray-700); letter-spacing: 0.5px; }
        .table td { padding: 1rem 1.5rem; border-bottom: 1px solid var(--gray-100); font-size: 0.9rem; }
        .table tbody tr:hover { background: var(--gray-50); }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-brouillon { background: #fef3c7; color: #92400e; }
        .badge-validee { background: #d1fae5; color: #065f46; }
        .badge-active { background: #dbeafe; color: #1e40af; }
        .badge-archivee { background: #e5e7eb; color: #374151; }

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
            text-decoration: none;
            display: inline-block;
        }

        .action-btn:hover { background: var(--secondary); }

        .action-btn-danger {
            background: var(--danger);
        }

        .action-btn-danger:hover { opacity: 0.9; }

        .actions-cell {
            display: flex;
            gap: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-500);
        }

        .empty-state-icon { font-size: 3rem; margin-bottom: 1rem; }
        .empty-state-title { font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700); }
        .empty-state-text { margin-bottom: 1.5rem; }

        .offre-title-cell {
            max-width: 250px;
        }

        .offre-title {
            font-weight: 600;
            color: var(--gray-900);
            text-decoration: none;
            display: block;
        }

        .offre-title:hover { color: var(--primary); }

        .offre-excerpt {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }

        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: relative; padding: 1rem 0; }
            .main { margin-left: 0; }
            .sidebar-footer { position: relative; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'offers'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <main class="main app-content">
            <div class="header">
                <div>
                    <h1 class="header-title">📋 Mes Offres</h1>
                </div>
                <a href="/admin/crm/offre-generator" class="btn btn-primary">🤖 Creer une offre avec l'IA</a>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <a href="/admin/crm/offres" class="stat-card <?= empty($statutFilter) ? 'active-filter' : '' ?>">
                    <div class="stat-value"><?= array_sum($statutCounts) ?></div>
                    <div class="stat-label">Total</div>
                </a>
                <a href="/admin/crm/offres?statut=brouillon" class="stat-card <?= $statutFilter === 'brouillon' ? 'active-filter' : '' ?>">
                    <div class="stat-value" style="color: var(--warning)"><?= $statutCounts['brouillon'] ?? 0 ?></div>
                    <div class="stat-label">Brouillons</div>
                </a>
                <a href="/admin/crm/offres?statut=validee" class="stat-card <?= $statutFilter === 'validee' ? 'active-filter' : '' ?>">
                    <div class="stat-value" style="color: var(--success)"><?= $statutCounts['validee'] ?? 0 ?></div>
                    <div class="stat-label">Validees</div>
                </a>
                <a href="/admin/crm/offres?statut=active" class="stat-card <?= $statutFilter === 'active' ? 'active-filter' : '' ?>">
                    <div class="stat-value" style="color: var(--primary)"><?= $statutCounts['active'] ?? 0 ?></div>
                    <div class="stat-label">Actives</div>
                </a>
                <a href="/admin/crm/offres?statut=archivee" class="stat-card <?= $statutFilter === 'archivee' ? 'active-filter' : '' ?>">
                    <div class="stat-value" style="color: var(--gray-500)"><?= $statutCounts['archivee'] ?? 0 ?></div>
                    <div class="stat-label">Archivees</div>
                </a>
            </div>

            <!-- Table -->
            <div class="table-section">
                <div class="table-header">
                    <div class="table-title">
                        <?php if ($statutFilter): ?>
                            Offres - <?= ucfirst($statutFilter) ?>s
                        <?php else: ?>
                            Toutes les offres
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (empty($offres)): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">🤖</div>
                        <div class="empty-state-title">Aucune offre pour le moment</div>
                        <div class="empty-state-text">Utilise le generateur IA pour creer ta premiere offre signature.</div>
                        <a href="/admin/crm/offre-generator" class="btn btn-primary">Creer une offre</a>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Offre</th>
                                <th>Persona</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($offres as $offre): ?>
                            <tr>
                                <td class="offre-title-cell">
                                    <a href="/admin/crm/offre-detail?id=<?= $offre['id'] ?>" class="offre-title">
                                        <?= h($offre['titre']) ?>
                                    </a>
                                    <?php if (!empty($offre['promesse'])): ?>
                                        <div class="offre-excerpt"><?= h(substr($offre['promesse'], 0, 80)) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td><?= h(substr($offre['persona'] ?? '-', 0, 60)) ?></td>
                                <td>
                                    <span class="badge badge-<?= $offre['statut'] ?>">
                                        <?= ucfirst($offre['statut']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($offre['created_at'])) ?></td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="/admin/crm/offre-detail?id=<?= $offre['id'] ?>" class="action-btn">Voir</a>
                                        <button class="action-btn action-btn-danger" onclick="deleteOffre(<?= $offre['id'] ?>, '<?= h(addslashes($offre['titre'])) ?>')">Suppr.</button>
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
    async function deleteOffre(id, titre) {
        if (!confirm('Supprimer l\'offre "' + titre + '" ? Cette action est irreversible.')) return;

        try {
            const response = await fetch('/api/api-ai-offre.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ action: 'delete_offre', id: id })
            });

            const data = await response.json();
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur: ' + (data.error || 'Impossible de supprimer.'));
            }
        } catch (error) {
            alert('Erreur de connexion.');
        }
    }
    </script>
</body>
</html>
