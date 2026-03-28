<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - GMB Dashboard
 * Score santé, vue d'ensemble, alertes
 */
$pageTitle = 'Dashboard GMB';
require_once __DIR__ . '/includes/header.php';

$stats = $gmbStats;
$topListings = $gmb->getTopListings(5);
$weakListings = $gmb->getWeakListings(5);
$reviewStats = $gmb->getReviewStats();

// Health score color
function healthClass($score) {
    if ($score >= 80) return 'health-excellent';
    if ($score >= 60) return 'health-good';
    if ($score >= 40) return 'health-average';
    return 'health-poor';
}

function healthLabel($score) {
    if ($score >= 80) return 'Excellent';
    if ($score >= 60) return 'Bon';
    if ($score >= 40) return 'Moyen';
    return 'Faible';
}

function barColor($score, $max) {
    $pct = $max > 0 ? ($score / $max) * 100 : 0;
    if ($pct >= 80) return '#10b981';
    if ($pct >= 60) return '#3b82f6';
    if ($pct >= 40) return '#f59e0b';
    return '#ef4444';
}
?>

<?php include __DIR__ . '/includes/sidebar.php'; ?>

<main class="main-content">
    <div class="content-header">
        <div>
            <h1 class="page-title">📊 Dashboard Google Business Profile</h1>
            <p class="page-subtitle">Vue d'ensemble de vos fiches Google Business</p>
        </div>
        <div class="flex gap-10">
            <a href="/admin/gmb/listings" class="btn btn-primary">+ Nouvelle fiche</a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="dashboard-grid" style="grid-template-columns: repeat(4, 1fr);">
        <div class="stat-card stat-total">
            <div class="stat-icon">📍</div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['total_listings'] ?></div>
                <div class="stat-label">Fiches GBP</div>
            </div>
        </div>
        <div class="stat-card stat-week">
            <div class="stat-icon">💯</div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['avg_health'] ?>/100</div>
                <div class="stat-label">Score santé moyen</div>
            </div>
        </div>
        <div class="stat-card stat-month">
            <div class="stat-icon">⭐</div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['avg_rating'] ?></div>
                <div class="stat-label">Note moyenne (<?= $stats['total_reviews'] ?> avis)</div>
            </div>
        </div>
        <div class="stat-card stat-demo">
            <div class="stat-icon">⚠️</div>
            <div class="stat-content">
                <div class="stat-value"><?= $stats['pending_replies'] ?></div>
                <div class="stat-label">Avis sans réponse</div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <?php if ($stats['nap_alerts'] > 0): ?>
        <div class="alert alert-danger">
            🚨 <strong><?= $stats['nap_alerts'] ?> incohérence(s) NAP détectée(s)</strong> - Des différences de nom, adresse ou téléphone ont été trouvées sur les annuaires.
            <a href="/admin/gmb/citations" style="color:inherit;font-weight:700;">Voir les alertes →</a>
        </div>
    <?php endif; ?>

    <?php if ($stats['pending_replies'] > 0): ?>
        <div class="alert alert-warning">
            💬 <strong><?= $stats['pending_replies'] ?> avis en attente de réponse</strong> - Répondez rapidement pour améliorer votre e-réputation.
            <a href="/admin/gmb/reviews?has_reply=no" style="color:inherit;font-weight:700;">Répondre aux avis →</a>
        </div>
    <?php endif; ?>

    <?php if ($stats['low_health'] > 0): ?>
        <div class="alert alert-info">
            📉 <strong><?= $stats['low_health'] ?> fiche(s) avec un score santé inférieur à 50</strong> - Optimisez-les pour améliorer votre visibilité.
        </div>
    <?php endif; ?>

    <div class="dashboard-charts">
        <!-- Score santé global -->
        <div class="chart-card">
            <div class="chart-title">🏥 Score santé global</div>
            <div class="text-center mb-20">
                <div class="health-score-big <?= healthClass($stats['avg_health']) ?>">
                    <span class="score-value"><?= $stats['avg_health'] ?></span>
                    <span class="score-label"><?= healthLabel($stats['avg_health']) ?></span>
                </div>
                <p class="text-sm text-muted">Moyenne de toutes vos fiches GBP</p>
            </div>

            <div class="mb-10 text-sm fw-600">Répartition des scores</div>
            <?php
            // Get score distribution
            try {
                $dist = $pdo->query("
                    SELECT
                        SUM(CASE WHEN health_score >= 80 THEN 1 ELSE 0 END) as excellent,
                        SUM(CASE WHEN health_score >= 60 AND health_score < 80 THEN 1 ELSE 0 END) as good,
                        SUM(CASE WHEN health_score >= 40 AND health_score < 60 THEN 1 ELSE 0 END) as average,
                        SUM(CASE WHEN health_score < 40 THEN 1 ELSE 0 END) as poor
                    FROM gmb_listings
                ")->fetch();
            } catch (Exception $e) {
                $dist = ['excellent' => 0, 'good' => 0, 'average' => 0, 'poor' => 0];
            }
            $total = max(1, $stats['total_listings']);
            ?>
            <div class="health-bar">
                <span class="health-bar-label">Excellent (80+)</span>
                <div class="health-bar-track"><div class="health-bar-fill" style="width:<?= ($dist['excellent']/$total)*100 ?>%;background:#10b981"></div></div>
                <span class="health-bar-value"><?= (int)$dist['excellent'] ?></span>
            </div>
            <div class="health-bar">
                <span class="health-bar-label">Bon (60-79)</span>
                <div class="health-bar-track"><div class="health-bar-fill" style="width:<?= ($dist['good']/$total)*100 ?>%;background:#3b82f6"></div></div>
                <span class="health-bar-value"><?= (int)$dist['good'] ?></span>
            </div>
            <div class="health-bar">
                <span class="health-bar-label">Moyen (40-59)</span>
                <div class="health-bar-track"><div class="health-bar-fill" style="width:<?= ($dist['average']/$total)*100 ?>%;background:#f59e0b"></div></div>
                <span class="health-bar-value"><?= (int)$dist['average'] ?></span>
            </div>
            <div class="health-bar">
                <span class="health-bar-label">Faible (&lt;40)</span>
                <div class="health-bar-track"><div class="health-bar-fill" style="width:<?= ($dist['poor']/$total)*100 ?>%;background:#ef4444"></div></div>
                <span class="health-bar-value"><?= (int)$dist['poor'] ?></span>
            </div>
        </div>

        <!-- Review Stats -->
        <div class="chart-card">
            <div class="chart-title">⭐ Répartition des avis</div>
            <?php
            $totalReviews = max(1, (int)($reviewStats['total'] ?? 1));
            $starsData = [
                5 => (int)($reviewStats['stars_5'] ?? 0),
                4 => (int)($reviewStats['stars_4'] ?? 0),
                3 => (int)($reviewStats['stars_3'] ?? 0),
                2 => (int)($reviewStats['stars_2'] ?? 0),
                1 => (int)($reviewStats['stars_1'] ?? 0),
            ];
            ?>
            <div class="text-center mb-20">
                <div style="font-size:2.5rem;font-weight:800;color:var(--gray-900);">
                    <?= number_format((float)($reviewStats['avg_rating'] ?? 0), 1) ?>
                </div>
                <div class="stars" style="font-size:1.5rem;">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?= $i <= round((float)($reviewStats['avg_rating'] ?? 0)) ? '★' : '<span class="stars-gray">★</span>' ?>
                    <?php endfor; ?>
                </div>
                <p class="text-sm text-muted"><?= $reviewStats['total'] ?? 0 ?> avis au total</p>
            </div>

            <?php foreach ($starsData as $star => $count): ?>
            <div class="health-bar">
                <span class="health-bar-label"><?= $star ?> ★</span>
                <div class="health-bar-track"><div class="health-bar-fill" style="width:<?= ($count/$totalReviews)*100 ?>%;background:#f59e0b"></div></div>
                <span class="health-bar-value"><?= $count ?></span>
            </div>
            <?php endforeach; ?>

            <div style="margin-top:15px;padding-top:15px;border-top:1px solid var(--gray-200);">
                <div class="flex-between">
                    <span class="text-sm text-muted">Taux de réponse</span>
                    <span class="fw-600"><?= $totalReviews > 0 ? round(((int)($reviewStats['replied'] ?? 0) / $totalReviews) * 100) : 0 ?>%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Top & Weak Listings -->
    <div class="dashboard-charts">
        <div class="chart-card">
            <div class="chart-title">🏆 Meilleures fiches</div>
            <?php if (empty($topListings)): ?>
                <p class="empty-text">Aucune fiche enregistrée</p>
            <?php else: ?>
                <div class="recent-leads-list">
                    <?php foreach ($topListings as $l): ?>
                    <a href="/admin/gmb/listings?id=<?= $l['id'] ?>" class="recent-lead-item" style="text-decoration:none;">
                        <div class="lead-avatar" style="background:<?= barColor($l['health_score'], 100) ?>;font-size:0.7rem;">
                            <?= $l['health_score'] ?>
                        </div>
                        <div class="lead-info">
                            <span class="lead-name"><?= htmlspecialchars($l['name']) ?></span>
                            <span class="lead-email"><?= htmlspecialchars($l['city']) ?> (<?= htmlspecialchars($l['postal_code']) ?>)</span>
                        </div>
                        <span class="stars text-sm">
                            <?= number_format((float)($l['avg_rating'] ?? 0), 1) ?> ★
                        </span>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="chart-card">
            <div class="chart-title">⚠️ Fiches à optimiser</div>
            <?php if (empty($weakListings)): ?>
                <p class="empty-text">Toutes les fiches sont en bonne santé !</p>
            <?php else: ?>
                <div class="recent-leads-list">
                    <?php foreach ($weakListings as $l): ?>
                    <a href="/admin/gmb/listings?id=<?= $l['id'] ?>" class="recent-lead-item" style="text-decoration:none;">
                        <div class="lead-avatar" style="background:<?= barColor($l['health_score'], 100) ?>;font-size:0.7rem;">
                            <?= $l['health_score'] ?>
                        </div>
                        <div class="lead-info">
                            <span class="lead-name"><?= htmlspecialchars($l['name']) ?></span>
                            <span class="lead-email"><?= htmlspecialchars($l['city']) ?> (<?= htmlspecialchars($l['postal_code']) ?>)</span>
                        </div>
                        <span class="text-sm text-muted"><?= (int)($l['reviews_count'] ?? 0) ?> avis</span>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-title">⚡ Actions rapides</div>
        <div class="flex gap-10" style="flex-wrap:wrap;">
            <a href="/admin/gmb/listings" class="btn btn-primary">📍 Gérer les fiches</a>
            <a href="/admin/gmb/reviews?has_reply=no" class="btn btn-warning">💬 Répondre aux avis</a>
            <a href="/admin/gmb/posts" class="btn btn-success">📝 Créer une publication</a>
            <a href="/admin/gmb/positions" class="btn btn-outline">🗺️ Voir les positions</a>
            <a href="/admin/gmb/citations" class="btn btn-outline">🔗 Vérifier les citations</a>
            <a href="/admin/gmb/reports" class="btn btn-outline">📄 Générer un rapport</a>
        </div>
    </div>
</main>
</div>
</body>
</html>
