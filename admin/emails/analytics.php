<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Email Analytics Dashboard
 * Stats agrégées depuis email_logs : envois, ouvertures, clics, graphique par jour
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

// Période de filtrage
$period = $_GET['period'] ?? '30';
$periodDays = in_array($period, ['7', '14', '30', '90', '365']) ? (int)$period : 30;

try {
    // Stats globales
    $stats = $pdo->prepare("
        SELECT
            COUNT(*) as total_sent,
            SUM(CASE WHEN opened_at IS NOT NULL THEN 1 ELSE 0 END) as total_opened,
            SUM(CASE WHEN clicked_at IS NOT NULL THEN 1 ELSE 0 END) as total_clicked,
            SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as total_failed
        FROM email_logs
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
    ");
    $stats->execute([$periodDays]);
    $globalStats = $stats->fetch(PDO::FETCH_ASSOC);

    $totalSent = (int)($globalStats['total_sent'] ?? 0);
    $totalOpened = (int)($globalStats['total_opened'] ?? 0);
    $totalClicked = (int)($globalStats['total_clicked'] ?? 0);
    $totalFailed = (int)($globalStats['total_failed'] ?? 0);

    $openRate = $totalSent > 0 ? round(($totalOpened / $totalSent) * 100, 1) : 0;
    $clickRate = $totalSent > 0 ? round(($totalClicked / $totalSent) * 100, 1) : 0;
    $failRate = $totalSent > 0 ? round(($totalFailed / $totalSent) * 100, 1) : 0;

    // Emails par jour (pour le graphique)
    $daily = $pdo->prepare("
        SELECT
            DATE(created_at) as day,
            COUNT(*) as sent,
            SUM(CASE WHEN opened_at IS NOT NULL THEN 1 ELSE 0 END) as opened,
            SUM(CASE WHEN clicked_at IS NOT NULL THEN 1 ELSE 0 END) as clicked
        FROM email_logs
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        GROUP BY DATE(created_at)
        ORDER BY day ASC
    ");
    $daily->execute([$periodDays]);
    $dailyData = $daily->fetchAll(PDO::FETCH_ASSOC);

    $chartLabels = [];
    $chartSent = [];
    $chartOpened = [];
    $chartClicked = [];
    foreach ($dailyData as $row) {
        $chartLabels[] = date('d/m', strtotime($row['day']));
        $chartSent[] = (int)$row['sent'];
        $chartOpened[] = (int)$row['opened'];
        $chartClicked[] = (int)$row['clicked'];
    }

    // Top séquences
    $topSequences = $pdo->prepare("
        SELECT
            es.name as sequence_name,
            COUNT(el.id) as total,
            SUM(CASE WHEN el.opened_at IS NOT NULL THEN 1 ELSE 0 END) as opened,
            SUM(CASE WHEN el.clicked_at IS NOT NULL THEN 1 ELSE 0 END) as clicked
        FROM email_logs el
        LEFT JOIN email_sequences es ON el.sequence_id = es.id
        WHERE el.created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        GROUP BY el.sequence_id, es.name
        ORDER BY total DESC
        LIMIT 10
    ");
    $topSequences->execute([$periodDays]);
    $sequences = $topSequences->fetchAll(PDO::FETCH_ASSOC);

    // Derniers emails envoyés
    $recentEmails = $pdo->prepare("
        SELECT el.*, l.firstname, l.email as lead_email
        FROM email_logs el
        LEFT JOIN leads l ON el.lead_id = l.id
        ORDER BY el.created_at DESC
        LIMIT 20
    ");
    $recentEmails->execute();
    $recentList = $recentEmails->fetchAll(PDO::FETCH_ASSOC);

    // Bounces count
    $bouncesCount = $pdo->query("SELECT COUNT(*) FROM email_bounces")->fetchColumn();

} catch (Exception $e) {
    error_log("Analytics error: " . $e->getMessage());
    $totalSent = $totalOpened = $totalClicked = $totalFailed = 0;
    $openRate = $clickRate = $failRate = 0;
    $chartLabels = $chartSent = $chartOpened = $chartClicked = [];
    $sequences = [];
    $recentList = [];
    $bouncesCount = 0;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Analytics Email - <?= SITE_NAME ?? 'ÉCOSYSTÈME IMMO LOCAL+' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --green: #10b981;
            --orange: #f59e0b;
            --red: #ef4444;
            --blue: #3b82f6;
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

        .sidebar-section { margin-bottom: 2rem; padding: 0 1rem; }

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
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
        }

        .sidebar-item:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-item.active { background: rgba(255,255,255,0.2); color: white; font-weight: 600; }
        .sidebar-icon { font-size: 1.2rem; width: 1.5rem; }

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

        .user-info { flex: 1; font-size: 0.85rem; }
        .user-name { font-weight: 600; }
        .user-email { opacity: 0.7; font-size: 0.75rem; }

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
            font-size: 1.5rem;
            font-weight: 700;
        }

        .header-actions { display: flex; gap: 0.5rem; }

        .period-btn {
            padding: 0.5rem 1rem;
            border: 1px solid var(--gray-200);
            background: white;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: none;
            color: var(--gray-700);
            transition: all 0.2s;
        }

        .period-btn:hover { border-color: var(--primary); color: var(--primary); }
        .period-btn.active { background: var(--primary); color: white; border-color: var(--primary); }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--gray-500);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
        }

        .stat-sub {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .stat-value.blue { color: var(--blue); }
        .stat-value.green { color: var(--green); }
        .stat-value.orange { color: var(--orange); }
        .stat-value.red { color: var(--red); }

        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .chart-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .table-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .table-card h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        th {
            text-align: left;
            padding: 0.6rem 0.5rem;
            border-bottom: 2px solid var(--gray-200);
            color: var(--gray-500);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        td {
            padding: 0.6rem 0.5rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-sent { background: #dbeafe; color: #1e40af; }
        .badge-opened { background: #d1fae5; color: #065f46; }
        .badge-clicked { background: #fef3c7; color: #92400e; }
        .badge-failed { background: #fee2e2; color: #991b1b; }

        .link-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.85rem;
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.2s;
        }

        .link-btn:hover { border-color: var(--primary); color: var(--primary); }

        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .grid-2 { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr; }
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
                    <a href="/admin/crm" class="sidebar-item">
                        <span class="sidebar-icon">📊</span><span>Dashboard</span>
                    </a>
                    <a href="/admin/crm/leads" class="sidebar-item">
                        <span class="sidebar-icon">👥</span><span>Leads</span>
                    </a>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-section-title">Emails</div>
                    <a href="/admin/emails" class="sidebar-item">
                        <span class="sidebar-icon">📧</span><span>Messagerie</span>
                    </a>
                    <a href="/admin/emails/analytics.php" class="sidebar-item active">
                        <span class="sidebar-icon">📈</span><span>Analytics</span>
                    </a>
                    <a href="/admin/emails/bounces.php" class="sidebar-item">
                        <span class="sidebar-icon">🚫</span><span>Bounces</span>
                    </a>
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
                <h1 class="header-title">📈 Analytics Email</h1>
                <div class="header-actions">
                    <?php foreach ([7 => '7j', 14 => '14j', 30 => '30j', 90 => '90j', 365 => '1an'] as $val => $label): ?>
                        <a href="?period=<?= $val ?>" class="period-btn <?= $periodDays == $val ? 'active' : '' ?>"><?= $label ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Emails envoyés</div>
                    <div class="stat-value blue"><?= number_format($totalSent) ?></div>
                    <div class="stat-sub">sur <?= $periodDays ?> jours</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Taux d'ouverture</div>
                    <div class="stat-value green"><?= $openRate ?>%</div>
                    <div class="stat-sub"><?= number_format($totalOpened) ?> ouvert(s)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Taux de clic</div>
                    <div class="stat-value orange"><?= $clickRate ?>%</div>
                    <div class="stat-sub"><?= number_format($totalClicked) ?> clic(s)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Bounces</div>
                    <div class="stat-value red"><?= number_format($bouncesCount) ?></div>
                    <div class="stat-sub">
                        <a href="/admin/emails/bounces.php" style="color: var(--red); text-decoration: none;">Voir les bounces →</a>
                    </div>
                </div>
            </div>

            <!-- Graphique par jour -->
            <div class="chart-container">
                <div class="chart-title">Emails par jour</div>
                <canvas id="dailyChart" height="80"></canvas>
            </div>

            <div class="grid-2">
                <!-- Top séquences -->
                <div class="table-card">
                    <h3>Top séquences</h3>
                    <?php if (empty($sequences)): ?>
                        <p style="color: var(--gray-500); font-size: 0.9rem;">Aucune donnée pour cette période.</p>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Séquence</th>
                                    <th>Envoyés</th>
                                    <th>Ouverture</th>
                                    <th>Clic</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sequences as $seq): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($seq['sequence_name'] ?? 'Direct') ?></td>
                                        <td><?= number_format($seq['total']) ?></td>
                                        <td><?= $seq['total'] > 0 ? round(($seq['opened'] / $seq['total']) * 100, 1) : 0 ?>%</td>
                                        <td><?= $seq['total'] > 0 ? round(($seq['clicked'] / $seq['total']) * 100, 1) : 0 ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

                <!-- Derniers emails -->
                <div class="table-card">
                    <h3>Derniers emails envoyés</h3>
                    <?php if (empty($recentList)): ?>
                        <p style="color: var(--gray-500); font-size: 0.9rem;">Aucun email envoyé.</p>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Destinataire</th>
                                    <th>Sujet</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentList as $em): ?>
                                    <tr>
                                        <td title="<?= htmlspecialchars($em['to_email'] ?? '') ?>">
                                            <?= htmlspecialchars($em['firstname'] ?? substr($em['to_email'] ?? '', 0, 15)) ?>
                                        </td>
                                        <td title="<?= htmlspecialchars($em['subject'] ?? '') ?>">
                                            <?= htmlspecialchars(mb_substr($em['subject'] ?? '', 0, 30)) ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($em['clicked_at'])): ?>
                                                <span class="badge badge-clicked">Cliqué</span>
                                            <?php elseif (!empty($em['opened_at'])): ?>
                                                <span class="badge badge-opened">Ouvert</span>
                                            <?php elseif ($em['status'] === 'failed'): ?>
                                                <span class="badge badge-failed">Échoué</span>
                                            <?php else: ?>
                                                <span class="badge badge-sent">Envoyé</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-size: 0.8rem; color: var(--gray-500);">
                                            <?= date('d/m H:i', strtotime($em['created_at'])) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
    const ctx = document.getElementById('dailyChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chartLabels) ?>,
            datasets: [
                {
                    label: 'Envoyés',
                    data: <?= json_encode($chartSent) ?>,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2
                },
                {
                    label: 'Ouverts',
                    data: <?= json_encode($chartOpened) ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2
                },
                {
                    label: 'Cliqués',
                    data: <?= json_encode($chartClicked) ?>,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { usePointStyle: true, padding: 20 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
    </script>
</body>
</html>
