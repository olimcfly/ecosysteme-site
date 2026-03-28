<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Gestion des Bounces Email
 * Voir et gérer les adresses email en bounce
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

$message = '';
$messageType = '';

// Traiter les actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_bounce') {
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $type = in_array($_POST['type'] ?? '', ['hard', 'soft']) ? $_POST['type'] : 'hard';
        $reason = trim($_POST['reason'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Adresse email invalide.';
            $messageType = 'error';
        } else {
            try {
                // Vérifier si déjà présent
                $check = $pdo->prepare("SELECT id FROM email_bounces WHERE email = ?");
                $check->execute([$email]);
                if ($check->fetch()) {
                    $message = 'Cette adresse est déjà dans la liste des bounces.';
                    $messageType = 'error';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO email_bounces (email, type, reason, created_at) VALUES (?, ?, ?, NOW())");
                    $stmt->execute([$email, $type, $reason]);
                    $message = 'Bounce ajouté avec succès.';
                    $messageType = 'success';
                }
            } catch (Exception $e) {
                $message = 'Erreur : ' . $e->getMessage();
                $messageType = 'error';
            }
        }
    } elseif ($action === 'remove_bounce') {
        $id = (int)($_POST['bounce_id'] ?? 0);
        if ($id > 0) {
            try {
                $stmt = $pdo->prepare("DELETE FROM email_bounces WHERE id = ?");
                $stmt->execute([$id]);
                $message = 'Bounce supprimé.';
                $messageType = 'success';
            } catch (Exception $e) {
                $message = 'Erreur : ' . $e->getMessage();
                $messageType = 'error';
            }
        }
    }
}

// Pagination
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 25;
$offset = ($page - 1) * $perPage;

// Filtre
$filterType = $_GET['type'] ?? '';
$search = trim($_GET['search'] ?? '');

try {
    $where = "1=1";
    $params = [];

    if ($filterType && in_array($filterType, ['hard', 'soft'])) {
        $where .= " AND type = ?";
        $params[] = $filterType;
    }

    if ($search) {
        $where .= " AND (email LIKE ? OR reason LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM email_bounces WHERE $where");
    $countStmt->execute($params);
    $total = (int)$countStmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM email_bounces WHERE $where ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $allParams = array_merge($params, [$perPage, $offset]);
    $stmt->execute($allParams);
    $bounces = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalPages = ceil($total / $perPage);

    // Stats rapides
    $hardCount = $pdo->query("SELECT COUNT(*) FROM email_bounces WHERE type = 'hard'")->fetchColumn();
    $softCount = $pdo->query("SELECT COUNT(*) FROM email_bounces WHERE type = 'soft'")->fetchColumn();

} catch (Exception $e) {
    error_log("Bounces error: " . $e->getMessage());
    $bounces = [];
    $total = 0;
    $totalPages = 0;
    $hardCount = $softCount = 0;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Bounces Email - <?= SITE_NAME ?? 'ÉCOSYSTÈME IMMO+' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --green: #10b981;
            --red: #ef4444;
            --orange: #f59e0b;
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
        .sidebar-title { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; opacity: 0.8; }
        .sidebar-section { margin-bottom: 2rem; padding: 0 1rem; }
        .sidebar-section-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; opacity: 0.6; margin-bottom: 0.75rem; padding: 0 0.5rem; }

        .sidebar-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem; margin-bottom: 0.5rem; border-radius: 0.5rem;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
            color: rgba(255,255,255,0.8); font-size: 0.9rem;
        }
        .sidebar-item:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-item.active { background: rgba(255,255,255,0.2); color: white; font-weight: 600; }
        .sidebar-icon { font-size: 1.2rem; width: 1.5rem; }

        .sidebar-footer {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1);
        }
        .user-card { display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 1rem; }
        .user-avatar { width: 2.5rem; height: 2.5rem; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-weight: 700; }
        .user-info { flex: 1; font-size: 0.85rem; }
        .user-name { font-weight: 600; }
        .user-email { opacity: 0.7; font-size: 0.75rem; }
        .logout-btn { width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 0.5rem; cursor: pointer; font-size: 0.85rem; font-weight: 500; text-decoration: none; display: block; text-align: center; }

        .main { flex: 1; margin-left: 220px; padding: 2rem; }

        .header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2rem;
        }
        .header-title { font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 700; }

        .stats-row { display: flex; gap: 1rem; margin-bottom: 2rem; }
        .mini-stat {
            background: white; border-radius: 10px; padding: 1rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); flex: 1; text-align: center;
        }
        .mini-stat-value { font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 700; }
        .mini-stat-label { font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; font-weight: 600; }

        .card {
            background: white; border-radius: 12px; padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1.5rem;
        }
        .card h3 { font-family: 'Poppins', sans-serif; font-size: 1rem; font-weight: 600; margin-bottom: 1rem; }

        .form-row { display: flex; gap: 0.75rem; align-items: flex-end; flex-wrap: wrap; }
        .form-group { flex: 1; min-width: 150px; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--gray-700); margin-bottom: 0.35rem; }
        .form-input, .form-select {
            width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--gray-200);
            border-radius: 0.4rem; font-size: 0.85rem; font-family: inherit;
        }
        .form-input:focus, .form-select:focus { outline: none; border-color: var(--primary); }

        .btn {
            padding: 0.5rem 1rem; border: none; border-radius: 0.4rem;
            font-size: 0.85rem; font-weight: 600; cursor: pointer; font-family: inherit;
            transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--secondary); }
        .btn-danger { background: var(--red); color: white; }
        .btn-danger:hover { opacity: 0.9; }
        .btn-sm { padding: 0.3rem 0.6rem; font-size: 0.75rem; }

        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        th { text-align: left; padding: 0.6rem 0.5rem; border-bottom: 2px solid var(--gray-200); color: var(--gray-500); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; }
        td { padding: 0.6rem 0.5rem; border-bottom: 1px solid var(--gray-100); }

        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; }
        .badge-hard { background: #fee2e2; color: #991b1b; }
        .badge-soft { background: #fef3c7; color: #92400e; }

        .pagination { display: flex; gap: 0.5rem; justify-content: center; margin-top: 1rem; }
        .pagination a {
            padding: 0.4rem 0.8rem; border: 1px solid var(--gray-200); border-radius: 0.4rem;
            text-decoration: none; color: var(--gray-700); font-size: 0.85rem;
        }
        .pagination a.active { background: var(--primary); color: white; border-color: var(--primary); }
        .pagination a:hover { border-color: var(--primary); }

        .alert {
            padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.85rem;
        }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }

        .search-bar { display: flex; gap: 0.75rem; margin-bottom: 1rem; }

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main { margin-left: 0; }
            .form-row { flex-direction: column; }
            .stats-row { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">ÉCOSYSTÈME IMMO LOCAL+</div>
            </div>
            <nav>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Principal</div>
                    <a href="/admin/crm" class="sidebar-item"><span class="sidebar-icon">📊</span><span>Dashboard</span></a>
                    <a href="/admin/crm/leads" class="sidebar-item"><span class="sidebar-icon">👥</span><span>Leads</span></a>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Emails</div>
                    <a href="/admin/emails" class="sidebar-item"><span class="sidebar-icon">📧</span><span>Messagerie</span></a>
                    <a href="/admin/emails/analytics.php" class="sidebar-item"><span class="sidebar-icon">📈</span><span>Analytics</span></a>
                    <a href="/admin/emails/bounces.php" class="sidebar-item active"><span class="sidebar-icon">🚫</span><span>Bounces</span></a>
                </div>
            </nav>
            <div class="sidebar-footer">
                <div class="user-card">
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['admin_firstname'] ?? 'A', 0, 1)) ?></div>
                    <div class="user-info">
                        <span class="user-name"><?= htmlspecialchars($_SESSION['admin_firstname'] ?? 'Admin') ?></span>
                        <span class="user-email"><?= htmlspecialchars($_SESSION['admin_email'] ?? '') ?></span>
                    </div>
                </div>
                <a href="/admin/auth/logout" class="logout-btn">Déconnexion</a>
            </div>
        </aside>

        <main class="main">
            <div class="header">
                <h1 class="header-title">🚫 Gestion des Bounces</h1>
                <a href="/admin/emails/analytics.php" class="btn btn-primary">← Analytics</a>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <!-- Mini stats -->
            <div class="stats-row">
                <div class="mini-stat">
                    <div class="mini-stat-value" style="color: var(--gray-900);"><?= $total ?></div>
                    <div class="mini-stat-label">Total bounces</div>
                </div>
                <div class="mini-stat">
                    <div class="mini-stat-value" style="color: var(--red);"><?= $hardCount ?></div>
                    <div class="mini-stat-label">Hard bounces</div>
                </div>
                <div class="mini-stat">
                    <div class="mini-stat-value" style="color: var(--orange);"><?= $softCount ?></div>
                    <div class="mini-stat-label">Soft bounces</div>
                </div>
            </div>

            <!-- Ajouter un bounce -->
            <div class="card">
                <h3>Ajouter un bounce manuellement</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add_bounce">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-input" placeholder="email@example.com" required>
                        </div>
                        <div class="form-group" style="max-width: 150px;">
                            <label>Type</label>
                            <select name="type" class="form-select">
                                <option value="hard">Hard</option>
                                <option value="soft">Soft</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Raison</label>
                            <input type="text" name="reason" class="form-input" placeholder="Mailbox not found...">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Liste des bounces -->
            <div class="card">
                <h3>Liste des bounces (<?= $total ?>)</h3>

                <!-- Recherche & filtre -->
                <div class="search-bar">
                    <form method="GET" style="display: flex; gap: 0.75rem; width: 100%;">
                        <input type="text" name="search" class="form-input" placeholder="Rechercher email ou raison..." value="<?= htmlspecialchars($search) ?>" style="flex: 1;">
                        <select name="type" class="form-select" style="width: auto;">
                            <option value="">Tous types</option>
                            <option value="hard" <?= $filterType === 'hard' ? 'selected' : '' ?>>Hard</option>
                            <option value="soft" <?= $filterType === 'soft' ? 'selected' : '' ?>>Soft</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                    </form>
                </div>

                <?php if (empty($bounces)): ?>
                    <p style="color: var(--gray-500); text-align: center; padding: 2rem;">Aucun bounce trouvé.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Raison</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bounces as $bounce): ?>
                                <tr>
                                    <td><?= htmlspecialchars($bounce['email']) ?></td>
                                    <td><span class="badge badge-<?= $bounce['type'] ?>"><?= ucfirst($bounce['type']) ?></span></td>
                                    <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($bounce['reason'] ?? '') ?>">
                                        <?= htmlspecialchars($bounce['reason'] ?? '-') ?>
                                    </td>
                                    <td style="font-size: 0.8rem; color: var(--gray-500);">
                                        <?= date('d/m/Y H:i', strtotime($bounce['created_at'])) ?>
                                    </td>
                                    <td>
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Supprimer ce bounce ?');">
                                            <input type="hidden" name="action" value="remove_bounce">
                                            <input type="hidden" name="bounce_id" value="<?= $bounce['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php if ($totalPages > 1): ?>
                        <div class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i ?>&type=<?= urlencode($filterType) ?>&search=<?= urlencode($search) ?>"
                                   class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
