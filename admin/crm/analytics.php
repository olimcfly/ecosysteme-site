<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Analytics Dashboard
 * Métriques clés et visualisations des données leads
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: //admin/login');
    exit;
}

// ============================================
// REQUÊTES ANALYTICS
// ============================================

// 1. Leads par semaine (12 dernières semaines)
$stmt = $pdo->query("
    SELECT
        YEARWEEK(created_at, 1) AS yw,
        DATE_FORMAT(MIN(created_at), '%d/%m') AS week_label,
        COUNT(*) AS total
    FROM leads
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 12 WEEK)
    GROUP BY YEARWEEK(created_at, 1)
    ORDER BY yw ASC
");
$leadsPerWeek = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. Taux de conversion par intent (client / total par intent)
$stmt = $pdo->query("
    SELECT
        intent,
        COUNT(*) AS total,
        SUM(CASE WHEN status = 'client' THEN 1 ELSE 0 END) AS converted
    FROM leads
    WHERE intent IS NOT NULL
    GROUP BY intent
    ORDER BY intent
");
$conversionByIntent = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Répartition des leads par statut
$stmt = $pdo->query("
    SELECT
        status,
        COUNT(*) AS total
    FROM leads
    WHERE status IS NOT NULL
    GROUP BY status
    ORDER BY total DESC
");
$leadsByStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4. Top 5 villes par nombre de leads
$stmt = $pdo->query("
    SELECT
        COALESCE(city, 'Non renseigné') AS city,
        COUNT(*) AS total
    FROM leads
    GROUP BY city
    ORDER BY total DESC
    LIMIT 5
");
$topCities = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 5. Évolution du score moyen par mois (12 derniers mois)
$stmt = $pdo->query("
    SELECT
        DATE_FORMAT(created_at, '%Y-%m') AS month_key,
        DATE_FORMAT(created_at, '%m/%Y') AS month_label,
        ROUND(AVG(score), 1) AS avg_score
    FROM leads
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
      AND score IS NOT NULL
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY month_key ASC
");
$scoreByMonth = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 6. Leads convertis en clients ce mois vs mois précédent
$stmt = $pdo->query("
    SELECT
        SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) THEN 1 ELSE 0 END) AS this_month,
        SUM(CASE WHEN YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 ELSE 0 END) AS last_month
    FROM leads
    WHERE status = 'client'
");
$clientsComparison = $stmt->fetch(PDO::FETCH_ASSOC);
$clientsThisMonth = intval($clientsComparison['this_month'] ?? 0);
$clientsLastMonth = intval($clientsComparison['last_month'] ?? 0);
$clientsDiff = $clientsThisMonth - $clientsLastMonth;
$clientsDiffPct = $clientsLastMonth > 0 ? round(($clientsDiff / $clientsLastMonth) * 100) : ($clientsThisMonth > 0 ? 100 : 0);

// Totaux rapides
$stmt = $pdo->query("SELECT COUNT(*) FROM leads");
$totalLeads = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'client'");
$totalClients = $stmt->fetchColumn();

$globalConversion = $totalLeads > 0 ? round(($totalClients / $totalLeads) * 100, 1) : 0;

// Encode data for JS
$jsWeekLabels = json_encode(array_column($leadsPerWeek, 'week_label'));
$jsWeekData = json_encode(array_map('intval', array_column($leadsPerWeek, 'total')));

$jsIntentLabels = json_encode(array_map('ucfirst', array_column($conversionByIntent, 'intent')));
$jsIntentRates = json_encode(array_map(function($r) {
    return $r['total'] > 0 ? round(($r['converted'] / $r['total']) * 100, 1) : 0;
}, $conversionByIntent));

$jsStatusLabels = json_encode(array_map(function($s) {
    return ucfirst(str_replace('_', ' ', $s));
}, array_column($leadsByStatus, 'status')));
$jsStatusData = json_encode(array_map('intval', array_column($leadsByStatus, 'total')));

$jsScoreLabels = json_encode(array_column($scoreByMonth, 'month_label'));
$jsScoreData = json_encode(array_map('floatval', array_column($scoreByMonth, 'avg_score')));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Analytics - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
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

        /* KPI Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .kpi-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .kpi-label {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gray-500);
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .kpi-value {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .kpi-sub {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .kpi-diff {
            font-weight: 600;
        }

        .kpi-diff.positive { color: var(--success); }
        .kpi-diff.negative { color: var(--danger); }
        .kpi-diff.neutral { color: var(--gray-500); }

        /* Chart Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .chart-card.full-width {
            grid-column: 1 / -1;
        }

        .chart-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1rem;
        }

        .chart-container {
            position: relative;
            width: 100%;
        }

        .chart-container.bar-chart {
            height: 300px;
        }

        .chart-container.pie-chart {
            height: 300px;
            max-width: 400px;
            margin: 0 auto;
        }

        .chart-container.line-chart {
            height: 300px;
        }

        /* Top Cities Table */
        .cities-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cities-table th {
            text-align: left;
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-200);
            letter-spacing: 0.5px;
        }

        .cities-table td {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .cities-table tr:last-child td {
            border-bottom: none;
        }

        .city-rank {
            font-weight: 700;
            color: var(--primary);
            width: 2rem;
        }

        .city-bar-bg {
            background: var(--gray-100);
            border-radius: 999px;
            height: 8px;
            flex: 1;
        }

        .city-bar-fill {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            height: 100%;
            border-radius: 999px;
            transition: width 0.5s ease;
        }

        .city-bar-cell {
            width: 50%;
        }

        .city-count {
            font-weight: 600;
            color: var(--gray-700);
            text-align: right;
            width: 4rem;
        }

        @media (max-width: 1024px) {
            .charts-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .kpi-grid { grid-template-columns: 1fr 1fr; }
            .charts-grid { grid-template-columns: 1fr; }
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
                    <a href="/admin/crm/index.php" class="sidebar-item">
                        <span class="sidebar-icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="/admin/crm/leads.php" class="sidebar-item">
                        <span class="sidebar-icon">👥</span>
                        <span>Tous les Leads</span>
                    </a>
                    <a href="/admin/crm/analytics.php" class="sidebar-item active">
                        <span class="sidebar-icon">📈</span>
                        <span>Analytics</span>
                    </a>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-section-title">Par Intent</div>
                    <a href="/admin/crm/leads.php?intent=diagnostic" class="sidebar-item">
                        <span class="sidebar-icon">🔍</span>
                        <span>Diagnostic</span>
                    </a>
                    <a href="/admin/crm/leads.php?intent=demo" class="sidebar-item">
                        <span class="sidebar-icon">🎥</span>
                        <span>Demo</span>
                    </a>
                    <a href="/admin/crm/leads.php?intent=outil" class="sidebar-item">
                        <span class="sidebar-icon">🛠️</span>
                        <span>Outil</span>
                    </a>
                    <a href="/admin/crm/leads.php?intent=ressource" class="sidebar-item">
                        <span class="sidebar-icon">📚</span>
                        <span>Ressource</span>
                    </a>
                    <a href="/admin/crm/leads.php?intent=cold" class="sidebar-item">
                        <span class="sidebar-icon">❄️</span>
                        <span>Cold</span>
                    </a>
                    <a href="/admin/crm/leads.php?status=client" class="sidebar-item">
                        <span class="sidebar-icon">✅</span>
                        <span>Clients</span>
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
                    <a href="/admin/emails/index.php" class="sidebar-item">
                        <span class="sidebar-icon">📧</span>
                        <span>Messages</span>
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
                <a href="//admin/logout" class="logout-btn">Déconnexion</a>
            </div>
        </aside>

        <main class="main">
            <div class="header">
                <h1 class="header-title">📈 Analytics</h1>
                <div class="header-breadcrumb">Dashboard > Analytics</div>
            </div>

            <!-- KPI Cards -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-label">Total Leads</div>
                    <div class="kpi-value"><?= number_format($totalLeads) ?></div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Total Clients</div>
                    <div class="kpi-value"><?= number_format($totalClients) ?></div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Taux de conversion global</div>
                    <div class="kpi-value"><?= $globalConversion ?>%</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-label">Clients ce mois</div>
                    <div class="kpi-value"><?= $clientsThisMonth ?></div>
                    <div class="kpi-sub">
                        vs <?= $clientsLastMonth ?> mois dernier
                        <?php if ($clientsDiff > 0): ?>
                            <span class="kpi-diff positive">+<?= $clientsDiff ?> (+<?= $clientsDiffPct ?>%)</span>
                        <?php elseif ($clientsDiff < 0): ?>
                            <span class="kpi-diff negative"><?= $clientsDiff ?> (<?= $clientsDiffPct ?>%)</span>
                        <?php else: ?>
                            <span class="kpi-diff neutral">=</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="charts-grid">
                <!-- Leads par semaine -->
                <div class="chart-card full-width">
                    <div class="chart-title">Leads par semaine (12 dernières semaines)</div>
                    <div class="chart-container bar-chart">
                        <canvas id="chartLeadsWeek"></canvas>
                    </div>
                </div>

                <!-- Taux de conversion par intent -->
                <div class="chart-card">
                    <div class="chart-title">Taux de conversion par intent (%)</div>
                    <div class="chart-container bar-chart">
                        <canvas id="chartConversionIntent"></canvas>
                    </div>
                </div>

                <!-- Répartition par statut -->
                <div class="chart-card">
                    <div class="chart-title">Répartition des leads par statut</div>
                    <div class="chart-container pie-chart">
                        <canvas id="chartStatusPie"></canvas>
                    </div>
                </div>

                <!-- Score moyen par mois -->
                <div class="chart-card">
                    <div class="chart-title">Score moyen par mois</div>
                    <div class="chart-container line-chart">
                        <canvas id="chartScoreMonth"></canvas>
                    </div>
                </div>

                <!-- Top 5 villes -->
                <div class="chart-card">
                    <div class="chart-title">Top 5 villes par nombre de leads</div>
                    <?php if (!empty($topCities)):
                        $maxCity = intval($topCities[0]['total']);
                    ?>
                    <table class="cities-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ville</th>
                                <th class="city-bar-cell"></th>
                                <th style="text-align:right">Leads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topCities as $i => $city): ?>
                            <tr>
                                <td class="city-rank"><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($city['city']) ?></td>
                                <td class="city-bar-cell">
                                    <div class="city-bar-bg">
                                        <div class="city-bar-fill" style="width: <?= $maxCity > 0 ? round(($city['total'] / $maxCity) * 100) : 0 ?>%"></div>
                                    </div>
                                </td>
                                <td class="city-count"><?= intval($city['total']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <p style="color: var(--gray-500); text-align: center; padding: 2rem;">Aucune donnée disponible</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        const weekLabels = <?= $jsWeekLabels ?>;
        const weekData = <?= $jsWeekData ?>;
        const intentLabels = <?= $jsIntentLabels ?>;
        const intentRates = <?= $jsIntentRates ?>;
        const statusLabels = <?= $jsStatusLabels ?>;
        const statusData = <?= $jsStatusData ?>;
        const scoreLabels = <?= $jsScoreLabels ?>;
        const scoreData = <?= $jsScoreData ?>;

        const primaryColor = '#667eea';
        const secondaryColor = '#764ba2';

        const statusColors = [
            '#93c5fd', // nouveau
            '#fbcfe8', // en_reflexion
            '#c7d2fe', // actif
            '#fecaca', // appel_re
            '#a7f3d0', // client
            '#fcd34d', // fallback
            '#f9a8d4',
        ];

        const intentColors = {
            'Cold': '#fcd34d',
            'Ressource': '#86efac',
            'Outil': '#a7f3d0',
            'Diagnostic': '#fca5a5',
            'Demo': '#c7d2fe',
        };

        // 1. Leads par semaine (bar chart)
        new Chart(document.getElementById('chartLeadsWeek'), {
            type: 'bar',
            data: {
                labels: weekLabels,
                datasets: [{
                    label: 'Leads',
                    data: weekData,
                    backgroundColor: primaryColor + 'cc',
                    borderColor: primaryColor,
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

        // 2. Taux de conversion par intent (horizontal bar)
        new Chart(document.getElementById('chartConversionIntent'), {
            type: 'bar',
            data: {
                labels: intentLabels,
                datasets: [{
                    label: 'Conversion %',
                    data: intentRates,
                    backgroundColor: intentLabels.map(l => (intentColors[l] || primaryColor) + 'cc'),
                    borderColor: intentLabels.map(l => intentColors[l] || primaryColor),
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, max: 100, ticks: { callback: v => v + '%' } }
                }
            }
        });

        // 3. Répartition par statut (pie chart)
        new Chart(document.getElementById('chartStatusPie'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: statusColors.slice(0, statusLabels.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true } }
                }
            }
        });

        // 4. Score moyen par mois (line chart)
        new Chart(document.getElementById('chartScoreMonth'), {
            type: 'line',
            data: {
                labels: scoreLabels,
                datasets: [{
                    label: 'Score moyen',
                    data: scoreData,
                    borderColor: primaryColor,
                    backgroundColor: primaryColor + '20',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: primaryColor
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
