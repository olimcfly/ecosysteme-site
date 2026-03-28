<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Rapports clients GBP
 * Dashboard en 1 page pour le conseiller
 */
$pageTitle = 'Rapports clients';
require_once __DIR__ . '/includes/header.php';

$allListings = $gmb->getListings([], 1, 1000)['listings'];
$selectedListing = (int)($_GET['listing_id'] ?? ($allListings[0]['id'] ?? 0));
$listing = $selectedListing > 0 ? $gmb->getListingById($selectedListing) : null;

$reviewStats = $selectedListing > 0 ? $gmb->getReviewStats($selectedListing) : [];
$healthBreakdown = $selectedListing > 0 ? $gmb->getHealthBreakdown($selectedListing) : [];
$keywords = $selectedListing > 0 ? $gmb->getTrackedKeywords($selectedListing) : [];
$citationScore = $selectedListing > 0 ? $gmb->getCitationScore($selectedListing) : [];
$insights = $selectedListing > 0 ? $gmb->getInsightsSummary($selectedListing) : [];
$citations = $selectedListing > 0 ? $gmb->getCitations($selectedListing) : [];

function reportBarColor($score, $max) {
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
            <h1 class="page-title">📄 Rapports clients</h1>
            <p class="page-subtitle">Rapport synthétique en 1 page pour votre conseiller</p>
        </div>
        <?php if ($listing): ?>
        <button class="btn btn-primary" onclick="window.print()">🖨️ Imprimer / PDF</button>
        <?php endif; ?>
    </div>

    <!-- Listing Selection -->
    <div class="card" id="no-print">
        <form method="GET" class="flex gap-20" style="align-items:flex-end;">
            <div class="form-group mb-0" style="flex:1;">
                <label>Sélectionner une fiche GBP</label>
                <select name="listing_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Choisir...</option>
                    <?php foreach ($allListings as $l): ?>
                        <option value="<?= $l['id'] ?>" <?= $selectedListing == $l['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($l['name']) ?> — <?= htmlspecialchars($l['city']) ?> (<?= htmlspecialchars($l['postal_code']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>

    <?php if ($listing): ?>
    <!-- Printable Report -->
    <div id="report-content">
        <!-- Report Header -->
        <div class="card" style="background:linear-gradient(135deg,var(--primary),var(--secondary));color:white;text-align:center;padding:30px;">
            <h1 style="font-size:1.5rem;font-weight:700;margin-bottom:5px;">Rapport Google Business Profile</h1>
            <p style="opacity:0.9;font-size:1.1rem;"><?= htmlspecialchars($listing['name']) ?></p>
            <p style="opacity:0.7;font-size:0.9rem;"><?= htmlspecialchars($listing['address_line1']) ?>, <?= htmlspecialchars($listing['postal_code']) ?> <?= htmlspecialchars($listing['city']) ?></p>
            <p style="opacity:0.6;font-size:0.8rem;margin-top:10px;">Généré le <?= date('d/m/Y à H:i') ?> — ÉCOSYSTÈME IMMO LOCAL+</p>
        </div>

        <!-- Score + Key Metrics -->
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:20px;">
            <!-- Health Score -->
            <div class="card text-center">
                <div class="health-score-big <?= $listing['health_score'] >= 80 ? 'health-excellent' : ($listing['health_score'] >= 60 ? 'health-good' : ($listing['health_score'] >= 40 ? 'health-average' : 'health-poor')) ?>" style="margin-top:10px;">
                    <span class="score-value"><?= $listing['health_score'] ?></span>
                    <span class="score-label">/100</span>
                </div>
                <p class="fw-600" style="margin-top:5px;">Score de santé GBP</p>
                <p class="text-sm text-muted">
                    <?php if ($listing['health_score'] >= 80): ?>Excellent ! Votre fiche est très bien optimisée.
                    <?php elseif ($listing['health_score'] >= 60): ?>Bon niveau. Quelques améliorations possibles.
                    <?php elseif ($listing['health_score'] >= 40): ?>Score moyen. Des optimisations sont nécessaires.
                    <?php else: ?>Score faible. Action urgente recommandée.<?php endif; ?>
                </p>
            </div>

            <!-- Key Metrics -->
            <div class="card">
                <div class="card-title">📊 Métriques clés</div>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;">
                    <div style="text-align:center;padding:15px;background:var(--gray-50);border-radius:var(--radius-sm);">
                        <div style="font-size:2rem;font-weight:800;color:var(--gray-900);"><?= number_format((float)($reviewStats['avg_rating'] ?? 0), 1) ?></div>
                        <div class="stars"><?php for ($i=1;$i<=5;$i++) echo $i <= round((float)($reviewStats['avg_rating'] ?? 0)) ? '★' : '<span class="stars-gray">★</span>'; ?></div>
                        <div class="text-sm text-muted mt-20">Note moyenne</div>
                    </div>
                    <div style="text-align:center;padding:15px;background:var(--gray-50);border-radius:var(--radius-sm);">
                        <div style="font-size:2rem;font-weight:800;color:var(--gray-900);"><?= (int)($reviewStats['total'] ?? 0) ?></div>
                        <div class="text-sm text-muted mt-20">Avis total</div>
                    </div>
                    <div style="text-align:center;padding:15px;background:var(--gray-50);border-radius:var(--radius-sm);">
                        <div style="font-size:2rem;font-weight:800;color:var(--gray-900);">
                            <?= (int)($reviewStats['total'] ?? 0) > 0 ? round(((int)($reviewStats['replied'] ?? 0) / (int)$reviewStats['total']) * 100) : 0 ?>%
                        </div>
                        <div class="text-sm text-muted mt-20">Taux de réponse</div>
                    </div>
                </div>

                <?php if (!empty($insights) && (int)($insights['total_views'] ?? 0) > 0): ?>
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:15px;margin-top:15px;">
                    <div style="text-align:center;">
                        <div class="fw-700" style="font-size:1.3rem;"><?= number_format((int)($insights['total_views'] ?? 0)) ?></div>
                        <div class="text-sm text-muted">Vues (3 mois)</div>
                    </div>
                    <div style="text-align:center;">
                        <div class="fw-700" style="font-size:1.3rem;"><?= number_format((int)($insights['total_calls'] ?? 0)) ?></div>
                        <div class="text-sm text-muted">Appels</div>
                    </div>
                    <div style="text-align:center;">
                        <div class="fw-700" style="font-size:1.3rem;"><?= number_format((int)($insights['total_website'] ?? 0)) ?></div>
                        <div class="text-sm text-muted">Clics site web</div>
                    </div>
                    <div style="text-align:center;">
                        <div class="fw-700" style="font-size:1.3rem;"><?= number_format((int)($insights['total_directions'] ?? 0)) ?></div>
                        <div class="text-sm text-muted">Itinéraires</div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Health Breakdown -->
        <?php if (!empty($healthBreakdown)): ?>
        <div class="card">
            <div class="card-title">🏥 Détail de l'audit GBP</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px 30px;">
                <?php foreach ($healthBreakdown as $item): ?>
                <div class="health-bar">
                    <span class="health-bar-label"><?= htmlspecialchars($item['label']) ?></span>
                    <div class="health-bar-track">
                        <div class="health-bar-fill" style="width:<?= $item['max'] > 0 ? ($item['score']/$item['max'])*100 : 0 ?>%;background:<?= reportBarColor($item['score'], $item['max']) ?>"></div>
                    </div>
                    <span class="health-bar-value"><?= $item['score'] ?>/<?= $item['max'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Positions & Citations side by side -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <!-- Positions -->
            <div class="card">
                <div class="card-title">🗺️ Positionnement Maps</div>
                <?php if (!empty($keywords)): ?>
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="text-align:left;padding:8px;font-size:0.8rem;color:var(--gray-500);border-bottom:1px solid var(--gray-200);">Mot-clé</th>
                                <th style="text-align:center;padding:8px;font-size:0.8rem;color:var(--gray-500);border-bottom:1px solid var(--gray-200);">Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($keywords, 0, 8) as $kw): ?>
                            <tr>
                                <td style="padding:8px;font-size:0.9rem;"><?= htmlspecialchars($kw['keyword']) ?> <span class="text-muted text-sm">— <?= htmlspecialchars($kw['city']) ?></span></td>
                                <td style="padding:8px;text-align:center;">
                                    <span class="grid-position <?= $kw['best_position'] ? ($kw['best_position'] <= 3 ? 'pos-'.min(3,$kw['best_position']) : ($kw['best_position'] <= 5 ? 'pos-top5' : ($kw['best_position'] <= 10 ? 'pos-top10' : 'pos-top20'))) : 'pos-none' ?>" style="width:35px;height:30px;font-size:0.8rem;">
                                        <?= $kw['best_position'] ?? '—' ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-sm text-muted">Aucun mot-clé suivi pour le moment.</p>
                <?php endif; ?>
            </div>

            <!-- Citations -->
            <div class="card">
                <div class="card-title">🔗 Cohérence NAP</div>
                <?php if (!empty($citations)): ?>
                    <div class="mb-10">
                        <span class="fw-700" style="font-size:1.5rem;"><?= round((float)($citationScore['avg_score'] ?? 0)) ?>%</span>
                        <span class="text-sm text-muted">de cohérence moyenne</span>
                    </div>
                    <?php foreach (array_slice($citations, 0, 8) as $cit): ?>
                    <div class="flex-between" style="padding:6px 0;border-bottom:1px solid var(--gray-100);">
                        <span class="text-sm"><?= htmlspecialchars($cit['directory_name']) ?></span>
                        <span class="citation-status citation-<?= $cit['status'] ?>" style="font-size:0.75rem;">
                            <?= $cit['name_match'] ? '✅N' : '❌N' ?>
                            <?= $cit['address_match'] ? '✅A' : '❌A' ?>
                            <?= $cit['phone_match'] ? '✅P' : '❌P' ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-sm text-muted">Aucune citation vérifiée.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Review Summary -->
        <div class="card">
            <div class="card-title">⭐ Répartition des avis</div>
            <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:15px;text-align:center;">
                <?php
                $totalRev = max(1, (int)($reviewStats['total'] ?? 1));
                for ($s = 5; $s >= 1; $s--):
                    $count = (int)($reviewStats["stars_{$s}"] ?? 0);
                    $pct = round(($count / $totalRev) * 100);
                ?>
                <div>
                    <div style="height:80px;display:flex;align-items:flex-end;justify-content:center;margin-bottom:5px;">
                        <div style="width:40px;height:<?= max(5, $pct) ?>%;background:<?= $s >= 4 ? '#10b981' : ($s === 3 ? '#f59e0b' : '#ef4444') ?>;border-radius:4px 4px 0 0;"></div>
                    </div>
                    <div class="fw-700"><?= $count ?></div>
                    <div class="text-sm text-muted"><?= $s ?> ★</div>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="card" style="border-left:4px solid var(--primary);">
            <div class="card-title">💡 Recommandations</div>
            <ul style="list-style:none;padding:0;">
                <?php
                $recommendations = [];
                if ($listing['health_score'] < 80) {
                    foreach ($healthBreakdown as $key => $item) {
                        $pct = $item['max'] > 0 ? ($item['score'] / $item['max']) * 100 : 0;
                        if ($pct < 70) {
                            $tips = [
                                'nap' => 'Complétez les informations NAP (nom, adresse, téléphone) de votre fiche.',
                                'categories' => 'Ajoutez des catégories secondaires pertinentes à votre fiche.',
                                'description' => 'Rédigez une description d\'au moins 250 caractères avec des mots-clés locaux.',
                                'hours' => 'Renseignez vos horaires d\'ouverture pour tous les jours de la semaine.',
                                'photos' => 'Ajoutez plus de photos (logo, couverture, intérieur, équipe). Objectif : 10+ photos.',
                                'reviews' => 'Encouragez vos clients satisfaits à laisser un avis et répondez à tous les avis.',
                                'posts' => 'Publiez au moins 4 posts par mois pour maintenir votre fiche active.',
                                'extras' => 'Ajoutez votre site web et listez vos services sur la fiche GBP.',
                            ];
                            if (isset($tips[$key])) {
                                $recommendations[] = $tips[$key];
                            }
                        }
                    }
                }
                if ((int)($reviewStats['total'] ?? 0) < 10) {
                    $recommendations[] = 'Objectif : atteignez 10 avis minimum pour améliorer votre crédibilité.';
                }
                if (!empty($citationScore) && (float)($citationScore['avg_score'] ?? 0) < 80) {
                    $recommendations[] = 'Corrigez les incohérences NAP détectées sur les annuaires pour améliorer votre SEO local.';
                }
                if (empty($recommendations)) {
                    $recommendations[] = 'Votre fiche est bien optimisée ! Continuez à publier régulièrement et à répondre aux avis.';
                }
                foreach ($recommendations as $rec):
                ?>
                <li style="padding:8px 0;border-bottom:1px solid var(--gray-100);display:flex;gap:10px;">
                    <span>→</span>
                    <span class="text-sm"><?= $rec ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-muted" style="padding:20px;">
            Rapport généré par ÉCOSYSTÈME IMMO LOCAL+ — <?= date('d/m/Y') ?>
        </div>
    </div>

    <?php elseif (empty($allListings)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon">📄</div>
            <h3>Aucune fiche GBP</h3>
            <p>Ajoutez des fiches pour générer des rapports.</p>
        </div>
    </div>
    <?php endif; ?>
</main>

<style>
@media print {
    .sidebar, #no-print, .content-header { display: none !important; }
    .main-content { margin-left: 0 !important; padding: 0 !important; }
    .card { box-shadow: none !important; border: 1px solid #eee; break-inside: avoid; }
    body { background: white !important; }
}
</style>
</div>
</body>
</html>
