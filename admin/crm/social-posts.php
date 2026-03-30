<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Publications Sociales
 * Interface de gestion des posts sociaux dans le CRM
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';
require_once __DIR__ . '/../../includes/SocialPublishService.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

$service = new SocialPublishService($pdo);
$service->ensureTables();

// Filtres
$filterStatus = $_GET['status'] ?? '';
$filterChannel = $_GET['channel'] ?? '';
$search = trim($_GET['search'] ?? '');
$page = max(1, (int) ($_GET['page'] ?? 1));
$view = $_GET['view'] ?? 'list'; // list ou calendar

$filters = [];
if ($filterStatus) $filters['status'] = $filterStatus;
if ($filterChannel) $filters['channel'] = $filterChannel;
if ($search) $filters['search'] = $search;

$result = $service->getPosts($filters, $page, 15);
$posts = $result['posts'];
$total = $result['total'];
$totalPages = $result['totalPages'];

$stats = $service->getStats();
$channels = $service->getChannels();

// Calendrier
$calYear = (int) ($_GET['year'] ?? date('Y'));
$calMonth = (int) ($_GET['month'] ?? date('m'));
$calPosts = $service->getPostsByMonth($calYear, $calMonth);

// Total des leads (pour sidebar)
$totalLeads = (int) $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$clients = (int) $pdo->query("SELECT COUNT(*) FROM leads WHERE status='client' OR status='Clients'")->fetchColumn();

$platformLabels = [
    'facebook' => ['label' => 'Facebook', 'icon' => 'fa-facebook', 'color' => '#1877F2'],
    'instagram' => ['label' => 'Instagram', 'icon' => 'fa-instagram', 'color' => '#E4405F'],
    'linkedin' => ['label' => 'LinkedIn', 'icon' => 'fa-linkedin', 'color' => '#0A66C2'],
    'google_business' => ['label' => 'Google', 'icon' => 'fa-google', 'color' => '#4285F4'],
];

$statusLabels = [
    'brouillon' => ['label' => 'Brouillon', 'class' => 'badge-brouillon'],
    'programme' => ['label' => 'Programmé', 'class' => 'badge-programme'],
    'publie' => ['label' => 'Publié', 'class' => 'badge-publie'],
    'erreur' => ['label' => 'Erreur', 'class' => 'badge-erreur'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Publications Sociales - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
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

        /* Sidebar (identique au dashboard) */
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
        .sidebar-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem; margin-bottom: 0.5rem; border-radius: 0.5rem;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
            color: rgba(255,255,255,0.8); font-size: 0.9rem;
        }
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
        .logout-btn { width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 0.5rem; cursor: pointer; font-size: 0.85rem; font-weight: 500; text-decoration: none; display: block; text-align: center; }

        /* Main */
        .main { flex: 1; margin-left: 220px; padding: 2rem; }

        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .header-title { font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 700; }
        .header-actions { display: flex; gap: 0.75rem; align-items: center; }

        .btn {
            padding: 0.6rem 1.2rem; border: none; border-radius: 0.5rem;
            cursor: pointer; font-size: 0.85rem; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center;
            gap: 0.5rem; transition: all 0.2s;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--secondary); }
        .btn-success { background: var(--success); color: white; }
        .btn-success:hover { opacity: 0.9; }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { opacity: 0.9; }
        .btn-outline { background: white; color: var(--gray-700); border: 1px solid var(--gray-300); }
        .btn-outline:hover { background: var(--gray-50); }
        .btn-outline.active { background: var(--primary); color: white; border-color: var(--primary); }
        .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.8rem; }

        /* Stats */
        .stats-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem; margin-bottom: 2rem;
        }
        .stat-card {
            background: white; border-radius: 0.75rem; padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08); text-align: center;
        }
        .stat-value { font-size: 1.5rem; font-weight: 700; color: var(--gray-900); }
        .stat-label { font-size: 0.8rem; color: var(--gray-500); margin-top: 0.25rem; }

        /* Filters */
        .filters-bar {
            display: flex; gap: 0.75rem; margin-bottom: 1.5rem;
            flex-wrap: wrap; align-items: center;
        }
        .filters-bar select, .filters-bar input {
            padding: 0.5rem 0.75rem; border: 1px solid var(--gray-300);
            border-radius: 0.5rem; font-size: 0.85rem; background: white;
        }

        /* Table */
        .table-section {
            background: white; border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;
        }
        .table { width: 100%; border-collapse: collapse; }
        .table thead { background: var(--gray-50); border-bottom: 1px solid var(--gray-200); }
        .table th { padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--gray-700); }
        .table td { padding: 0.75rem 1rem; border-bottom: 1px solid var(--gray-100); font-size: 0.85rem; }
        .table tbody tr:hover { background: var(--gray-50); }

        /* Badges */
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
        .badge-brouillon { background: #e5e7eb; color: #374151; }
        .badge-programme { background: #dbeafe; color: #1e40af; }
        .badge-publie { background: #d1fae5; color: #065f46; }
        .badge-erreur { background: #fee2e2; color: #991b1b; }

        .channel-icons { display: flex; gap: 0.4rem; }
        .channel-icon { width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.7rem; }

        /* Pagination */
        .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 1.5rem; }
        .pagination a, .pagination span {
            padding: 0.5rem 0.75rem; border-radius: 0.5rem; font-size: 0.85rem;
            text-decoration: none; border: 1px solid var(--gray-200);
        }
        .pagination a { color: var(--gray-700); background: white; }
        .pagination a:hover { background: var(--gray-50); }
        .pagination .current { background: var(--primary); color: white; border-color: var(--primary); }

        /* Calendar */
        .calendar-grid {
            display: grid; grid-template-columns: repeat(7, 1fr);
            gap: 1px; background: var(--gray-200); border-radius: 0.75rem; overflow: hidden;
        }
        .calendar-header-cell {
            background: var(--gray-100); padding: 0.75rem; text-align: center;
            font-weight: 600; font-size: 0.8rem; color: var(--gray-700);
        }
        .calendar-cell {
            background: white; min-height: 100px; padding: 0.5rem;
            vertical-align: top;
        }
        .calendar-cell.empty { background: var(--gray-50); }
        .calendar-cell.today { background: #eff6ff; }
        .calendar-day { font-weight: 600; font-size: 0.8rem; color: var(--gray-700); margin-bottom: 0.25rem; }
        .calendar-post {
            font-size: 0.7rem; padding: 0.2rem 0.4rem; border-radius: 0.25rem;
            margin-bottom: 0.2rem; cursor: pointer; white-space: nowrap;
            overflow: hidden; text-overflow: ellipsis;
        }
        .calendar-post.brouillon { background: #e5e7eb; color: #374151; }
        .calendar-post.programme { background: #dbeafe; color: #1e40af; }
        .calendar-post.publie { background: #d1fae5; color: #065f46; }
        .calendar-post.erreur { background: #fee2e2; color: #991b1b; }

        .calendar-nav { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
        .calendar-nav-title { font-size: 1.1rem; font-weight: 600; }

        /* Modal */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center;
            align-items: center;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: white; border-radius: 1rem; padding: 2rem;
            width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        .modal-title { font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--gray-700); }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%; padding: 0.6rem 0.75rem; border: 1px solid var(--gray-300);
            border-radius: 0.5rem; font-size: 0.9rem; font-family: inherit;
        }
        .form-group textarea { resize: vertical; min-height: 100px; }

        .channel-checkboxes { display: flex; gap: 1rem; flex-wrap: wrap; }
        .channel-checkbox {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 0.75rem; border: 2px solid var(--gray-200);
            border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;
        }
        .channel-checkbox:has(input:checked) { border-color: var(--primary); background: #eff6ff; }
        .channel-checkbox input { display: none; }
        .channel-checkbox i { font-size: 1.1rem; }

        .form-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; justify-content: flex-end; }

        .empty-state {
            text-align: center; padding: 3rem; color: var(--gray-500);
        }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.3; }

        .post-preview { max-width: 300px; }
        .post-title { font-weight: 600; color: var(--gray-900); }
        .post-excerpt { color: var(--gray-500); font-size: 0.8rem; margin-top: 0.2rem; }

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
        <!-- Sidebar -->
        <?php $activePage = 'automation'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <!-- Main -->
        <main class="main app-content">
            <div class="header">
                <div>
                    <h1 class="header-title"><i class="fas fa-share-nodes" style="color:var(--primary)"></i> Publications Sociales</h1>
                </div>
                <div class="header-actions">
                    <a href="?view=list" class="btn btn-outline <?= $view === 'list' ? 'active' : '' ?> btn-sm">
                        <i class="fas fa-list"></i> Liste
                    </a>
                    <a href="?view=calendar" class="btn btn-outline <?= $view === 'calendar' ? 'active' : '' ?> btn-sm">
                        <i class="fas fa-calendar"></i> Calendrier
                    </a>
                    <button class="btn btn-primary" onclick="openCreateModal()">
                        <i class="fas fa-plus"></i> Nouveau post
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?= $stats['total'] ?></div>
                    <div class="stat-label">Total posts</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= $stats['brouillon'] ?></div>
                    <div class="stat-label">Brouillons</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--info)"><?= $stats['programme'] ?></div>
                    <div class="stat-label">Programmés</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--success)"><?= $stats['publie'] ?></div>
                    <div class="stat-label">Publiés</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--danger)"><?= $stats['erreur'] ?></div>
                    <div class="stat-label">Erreurs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--primary)"><?= $stats['channels'] ?></div>
                    <div class="stat-label">Canaux actifs</div>
                </div>
            </div>

            <?php if ($view === 'list'): ?>
            <!-- Vue Liste -->
            <div class="filters-bar">
                <form method="get" style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:center;">
                    <input type="hidden" name="view" value="list">
                    <input type="text" name="search" placeholder="Rechercher..." value="<?= h($search) ?>">
                    <select name="status">
                        <option value="">Tous les statuts</option>
                        <option value="brouillon" <?= $filterStatus === 'brouillon' ? 'selected' : '' ?>>Brouillon</option>
                        <option value="programme" <?= $filterStatus === 'programme' ? 'selected' : '' ?>>Programmé</option>
                        <option value="publie" <?= $filterStatus === 'publie' ? 'selected' : '' ?>>Publié</option>
                        <option value="erreur" <?= $filterStatus === 'erreur' ? 'selected' : '' ?>>Erreur</option>
                    </select>
                    <select name="channel">
                        <option value="">Tous les canaux</option>
                        <option value="facebook" <?= $filterChannel === 'facebook' ? 'selected' : '' ?>>Facebook</option>
                        <option value="instagram" <?= $filterChannel === 'instagram' ? 'selected' : '' ?>>Instagram</option>
                        <option value="linkedin" <?= $filterChannel === 'linkedin' ? 'selected' : '' ?>>LinkedIn</option>
                        <option value="google_business" <?= $filterChannel === 'google_business' ? 'selected' : '' ?>>Google Business</option>
                    </select>
                    <button type="submit" class="btn btn-outline btn-sm"><i class="fas fa-search"></i> Filtrer</button>
                </form>
            </div>

            <div class="table-section">
                <?php if (empty($posts)): ?>
                    <div class="empty-state">
                        <i class="fas fa-share-nodes"></i>
                        <p>Aucune publication trouvée</p>
                        <button class="btn btn-primary" style="margin-top:1rem" onclick="openCreateModal()">
                            <i class="fas fa-plus"></i> Créer votre premier post
                        </button>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Post</th>
                                <th>Canaux</th>
                                <th>Statut</th>
                                <th>Date programmée</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                            <tr>
                                <td>
                                    <div class="post-preview">
                                        <div class="post-title"><?= h($post['title'] ?: 'Sans titre') ?></div>
                                        <div class="post-excerpt"><?= h(mb_substr($post['content'], 0, 80)) ?>...</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="channel-icons">
                                        <?php foreach ($post['channels'] as $ch): ?>
                                            <?php $info = $platformLabels[$ch] ?? null; if ($info): ?>
                                            <span class="channel-icon" style="background:<?= $info['color'] ?>" title="<?= $info['label'] ?>">
                                                <i class="fab <?= $info['icon'] ?>"></i>
                                            </span>
                                            <?php endif; endforeach; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php $si = $statusLabels[$post['status']] ?? ['label' => $post['status'], 'class' => '']; ?>
                                    <span class="badge <?= $si['class'] ?>"><?= $si['label'] ?></span>
                                </td>
                                <td>
                                    <?php if ($post['scheduled_at']): ?>
                                        <?= date('d/m/Y H:i', strtotime($post['scheduled_at'])) ?>
                                    <?php elseif ($post['published_at']): ?>
                                        <span style="color:var(--success)"><?= date('d/m/Y H:i', strtotime($post['published_at'])) ?></span>
                                    <?php else: ?>
                                        <span style="color:var(--gray-500)">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display:flex; gap:0.4rem;">
                                        <?php if ($post['status'] !== 'publie'): ?>
                                            <button class="btn btn-success btn-sm" onclick="publishNow(<?= $post['id'] ?>)" title="Publier maintenant">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                            <button class="btn btn-outline btn-sm" onclick="editPost(<?= $post['id'] ?>)" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="deletePost(<?= $post['id'] ?>)" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php else: ?>
                                            <span class="btn btn-outline btn-sm" style="cursor:default; opacity:0.6;">
                                                <i class="fas fa-check"></i> Publié
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i === $page): ?>
                                <span class="current"><?= $i ?></span>
                            <?php else: ?>
                                <a href="?view=list&page=<?= $i ?>&status=<?= urlencode($filterStatus) ?>&channel=<?= urlencode($filterChannel) ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php else: ?>
            <!-- Vue Calendrier -->
            <?php
                $prevMonth = $calMonth - 1;
                $prevYear = $calYear;
                if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
                $nextMonth = $calMonth + 1;
                $nextYear = $calYear;
                if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }

                $monthNames = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $calMonth, $calYear);
                $firstDayOfWeek = (int) date('N', mktime(0, 0, 0, $calMonth, 1, $calYear)); // 1=Lundi
                $today = date('Y-m-d');

                // Indexer les posts par jour
                $postsByDay = [];
                foreach ($calPosts as $cp) {
                    $dateKey = date('j', strtotime($cp['scheduled_at'] ?? $cp['published_at'] ?? $cp['created_at']));
                    $postsByDay[$dateKey][] = $cp;
                }
            ?>

            <div class="calendar-nav">
                <a href="?view=calendar&year=<?= $prevYear ?>&month=<?= $prevMonth ?>" class="btn btn-outline btn-sm">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <span class="calendar-nav-title"><?= $monthNames[$calMonth] ?> <?= $calYear ?></span>
                <a href="?view=calendar&year=<?= $nextYear ?>&month=<?= $nextMonth ?>" class="btn btn-outline btn-sm">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>

            <div class="table-section" style="padding:1rem;">
                <div class="calendar-grid">
                    <?php foreach (['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $dayName): ?>
                        <div class="calendar-header-cell"><?= $dayName ?></div>
                    <?php endforeach; ?>

                    <?php for ($i = 1; $i < $firstDayOfWeek; $i++): ?>
                        <div class="calendar-cell empty"></div>
                    <?php endfor; ?>

                    <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>
                        <?php
                            $dateStr = sprintf('%04d-%02d-%02d', $calYear, $calMonth, $day);
                            $isToday = $dateStr === $today;
                        ?>
                        <div class="calendar-cell <?= $isToday ? 'today' : '' ?>">
                            <div class="calendar-day"><?= $day ?></div>
                            <?php if (!empty($postsByDay[$day])): ?>
                                <?php foreach ($postsByDay[$day] as $cp): ?>
                                    <div class="calendar-post <?= $cp['status'] ?>" onclick="editPost(<?= $cp['id'] ?>)" title="<?= h($cp['title'] ?: 'Sans titre') ?>">
                                        <?php
                                        $cpChannels = json_decode($cp['channels'], true) ?: $cp['channels'];
                                        foreach ($cpChannels as $cch):
                                            $ci = $platformLabels[$cch] ?? null;
                                            if ($ci): ?>
                                                <i class="fab <?= $ci['icon'] ?>" style="color:<?= $ci['color'] ?>"></i>
                                            <?php endif; endforeach; ?>
                                        <?= h(mb_substr($cp['title'] ?: 'Sans titre', 0, 20)) ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>

                    <?php
                        $totalCells = ($firstDayOfWeek - 1) + $daysInMonth;
                        $remaining = (7 - ($totalCells % 7)) % 7;
                        for ($i = 0; $i < $remaining; $i++):
                    ?>
                        <div class="calendar-cell empty"></div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modal Création / Édition -->
    <div class="modal-overlay" id="postModal">
        <div class="modal">
            <div class="modal-title" id="modalTitle">Nouveau post</div>
            <form id="postForm" onsubmit="submitPost(event)">
                <input type="hidden" id="postId" value="">

                <div class="form-group">
                    <label for="postTitleInput">Titre</label>
                    <input type="text" id="postTitleInput" placeholder="Ex: Nouveau mandat - Villa 4 pièces">
                </div>

                <div class="form-group">
                    <label for="postContent">Contenu *</label>
                    <textarea id="postContent" placeholder="Rédigez votre publication..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="postImage">URL de l'image</label>
                    <input type="url" id="postImage" placeholder="https://...">
                </div>

                <div class="form-group">
                    <label for="postLink">Lien (optionnel)</label>
                    <input type="url" id="postLink" placeholder="https://...">
                </div>

                <div class="form-group">
                    <label for="postEntityType">Lié à</label>
                    <select id="postEntityType">
                        <option value="marketing">Contenu marketing</option>
                        <option value="mandat">Mandat</option>
                        <option value="lead">Lead</option>
                        <option value="evenement">Événement</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Canaux de publication *</label>
                    <div class="channel-checkboxes">
                        <label class="channel-checkbox">
                            <input type="checkbox" name="channels[]" value="facebook">
                            <i class="fab fa-facebook" style="color:#1877F2"></i> Facebook
                        </label>
                        <label class="channel-checkbox">
                            <input type="checkbox" name="channels[]" value="instagram">
                            <i class="fab fa-instagram" style="color:#E4405F"></i> Instagram
                        </label>
                        <label class="channel-checkbox">
                            <input type="checkbox" name="channels[]" value="linkedin">
                            <i class="fab fa-linkedin" style="color:#0A66C2"></i> LinkedIn
                        </label>
                        <label class="channel-checkbox">
                            <input type="checkbox" name="channels[]" value="google_business">
                            <i class="fab fa-google" style="color:#4285F4"></i> Google
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="postSchedule">Programmer pour</label>
                    <input type="datetime-local" id="postSchedule">
                    <small style="color:var(--gray-500);">Laissez vide pour enregistrer en brouillon</small>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const API_URL = '/api/social-publish.php';

    function openCreateModal() {
        document.getElementById('postId').value = '';
        document.getElementById('modalTitle').textContent = 'Nouveau post';
        document.getElementById('postForm').reset();
        document.getElementById('postModal').classList.add('active');
    }

    function closeModal() {
        document.getElementById('postModal').classList.remove('active');
    }

    async function editPost(id) {
        try {
            const res = await fetch(API_URL + '?action=get&id=' + id);
            const data = await res.json();
            if (!data.success) { alert(data.error || 'Erreur'); return; }

            const post = data.data;
            document.getElementById('postId').value = post.id;
            document.getElementById('modalTitle').textContent = 'Modifier le post';
            document.getElementById('postTitleInput').value = post.title || '';
            document.getElementById('postContent').value = post.content || '';
            document.getElementById('postImage').value = post.image_url || '';
            document.getElementById('postLink').value = post.link_url || '';
            document.getElementById('postEntityType').value = post.entity_type || 'marketing';
            document.getElementById('postSchedule').value = post.scheduled_at ? post.scheduled_at.replace(' ', 'T').slice(0, 16) : '';

            // Canaux
            document.querySelectorAll('[name="channels[]"]').forEach(cb => {
                cb.checked = (post.channels || []).includes(cb.value);
            });

            document.getElementById('postModal').classList.add('active');
        } catch (e) {
            alert('Erreur réseau');
        }
    }

    async function submitPost(e) {
        e.preventDefault();

        const channels = Array.from(document.querySelectorAll('[name="channels[]"]:checked')).map(cb => cb.value);
        if (channels.length === 0) {
            alert('Sélectionnez au moins un canal');
            return;
        }

        const postId = document.getElementById('postId').value;
        const payload = {
            action: postId ? 'update' : 'create',
            id: postId || undefined,
            title: document.getElementById('postTitleInput').value,
            content: document.getElementById('postContent').value,
            image_url: document.getElementById('postImage').value,
            link_url: document.getElementById('postLink').value,
            entity_type: document.getElementById('postEntityType').value,
            channels: channels,
            scheduled_at: document.getElementById('postSchedule').value || null,
        };

        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload),
            });
            const data = await res.json();
            if (data.success) {
                closeModal();
                location.reload();
            } else {
                alert(data.error || 'Erreur');
            }
        } catch (e) {
            alert('Erreur réseau');
        }
    }

    async function publishNow(id) {
        if (!confirm('Publier ce post maintenant sur tous les canaux sélectionnés ?')) return;

        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'publish', id: id }),
            });
            const data = await res.json();
            if (data.success) {
                alert('Post publié avec succès !');
                location.reload();
            } else {
                alert('Erreur : ' + (data.error || JSON.stringify(data.results || '')));
            }
        } catch (e) {
            alert('Erreur réseau');
        }
    }

    async function deletePost(id) {
        if (!confirm('Supprimer ce post ?')) return;

        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'delete', id: id }),
            });
            const data = await res.json();
            if (data.success) {
                location.reload();
            } else {
                alert(data.error || 'Erreur');
            }
        } catch (e) {
            alert('Erreur réseau');
        }
    }

    // Fermer modal en cliquant dehors
    document.getElementById('postModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    </script>
</body>
</html>
