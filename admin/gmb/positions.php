<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Suivi positions Maps & SERP
 * Grille type "Local Dominator"
 */
$pageTitle = 'Positions Maps & SERP';
require_once __DIR__ . '/includes/header.php';

$allListings = $gmb->getListings([], 1, 1000)['listings'];
$selectedListing = (int)($_GET['listing_id'] ?? ($allListings[0]['id'] ?? 0));
$selectedKeyword = $_GET['keyword'] ?? '';

$listing = $selectedListing > 0 ? $gmb->getListingById($selectedListing) : null;
$keywords = $selectedListing > 0 ? $gmb->getTrackedKeywords($selectedListing) : [];
$grid = ($selectedListing > 0 && $selectedKeyword) ? $gmb->getPositionGrid($selectedListing, $selectedKeyword) : [];
$history = ($selectedListing > 0 && $selectedKeyword) ? $gmb->getPositionHistory($selectedListing, $selectedKeyword) : [];

function posClass($pos) {
    if ($pos === null) return 'pos-none';
    if ($pos <= 1) return 'pos-1';
    if ($pos <= 2) return 'pos-2';
    if ($pos <= 3) return 'pos-3';
    if ($pos <= 5) return 'pos-top5';
    if ($pos <= 10) return 'pos-top10';
    return 'pos-top20';
}
?>

<?php include __DIR__ . '/includes/sidebar.php'; ?>

<main class="main-content">
    <div class="content-header">
        <div>
            <h1 class="page-title">🗺️ Suivi Positions Maps & SERP</h1>
            <p class="page-subtitle">Grille de positionnement local type "Local Dominator"</p>
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('addKeywordModal').classList.add('active')">+ Ajouter un mot-clé</button>
    </div>

    <!-- Selection -->
    <div class="card">
        <form method="GET" class="flex gap-20" style="align-items:flex-end;flex-wrap:wrap;">
            <div class="form-group mb-0" style="flex:1;min-width:200px;">
                <label>Fiche GBP</label>
                <select name="listing_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Sélectionner une fiche...</option>
                    <?php foreach ($allListings as $l): ?>
                        <option value="<?= $l['id'] ?>" <?= $selectedListing == $l['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($l['name']) ?> — <?= htmlspecialchars($l['city']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if (!empty($keywords)): ?>
            <div class="form-group mb-0" style="flex:1;min-width:200px;">
                <label>Mot-clé</label>
                <select name="keyword" class="form-control" onchange="this.form.submit()">
                    <option value="">Sélectionner...</option>
                    <?php foreach ($keywords as $kw): ?>
                        <option value="<?= htmlspecialchars($kw['keyword']) ?>" <?= $selectedKeyword === $kw['keyword'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kw['keyword']) ?> — <?= htmlspecialchars($kw['city']) ?>
                            (pos: <?= $kw['best_position'] ?? '—' ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($selectedListing > 0 && !empty($keywords)): ?>

    <!-- Keywords Overview -->
    <div class="card">
        <div class="card-title">🎯 Mots-clés suivis</div>
        <div class="leads-table-container" style="box-shadow:none;">
            <table class="leads-table">
                <thead>
                    <tr>
                        <th>Mot-clé</th>
                        <th>Ville</th>
                        <th>Meilleure position</th>
                        <th>Dernier check</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keywords as $kw): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($kw['keyword']) ?></strong></td>
                        <td><?= htmlspecialchars($kw['city']) ?></td>
                        <td>
                            <span class="grid-position <?= posClass($kw['best_position']) ?>">
                                <?= $kw['best_position'] ?? '—' ?>
                            </span>
                        </td>
                        <td class="text-sm text-muted"><?= $kw['last_check'] ? date('d/m/Y', strtotime($kw['last_check'])) : '—' ?></td>
                        <td>
                            <a href="?listing_id=<?= $selectedListing ?>&keyword=<?= urlencode($kw['keyword']) ?>" class="btn btn-outline btn-sm">Voir grille</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($selectedKeyword && !empty($grid)): ?>
    <!-- Position Grid -->
    <div class="card">
        <div class="card-title">📍 Grille de position : "<?= htmlspecialchars($selectedKeyword) ?>"</div>
        <p class="text-sm text-muted mb-20">Chaque cellule représente un point géographique autour de votre fiche. Le chiffre indique votre position dans les résultats Maps.</p>

        <div class="text-center mb-20">
            <div style="display:inline-grid;grid-template-columns:repeat(<?= min(7, max(3, count($grid))) ?>,1fr);gap:4px;">
                <?php foreach ($grid as $point): ?>
                    <div class="grid-position <?= posClass($point['position_maps']) ?>" title="Lat: <?= $point['grid_lat'] ?>, Lng: <?= $point['grid_lng'] ?>">
                        <?= $point['position_maps'] ?? '—' ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex gap-20" style="justify-content:center;flex-wrap:wrap;">
            <div class="flex gap-10 flex-center"><span class="grid-position pos-1" style="width:25px;height:25px;font-size:0.7rem;">1</span> <span class="text-sm">Position 1</span></div>
            <div class="flex gap-10 flex-center"><span class="grid-position pos-2" style="width:25px;height:25px;font-size:0.7rem;">2</span> <span class="text-sm">Position 2</span></div>
            <div class="flex gap-10 flex-center"><span class="grid-position pos-3" style="width:25px;height:25px;font-size:0.7rem;">3</span> <span class="text-sm">Position 3</span></div>
            <div class="flex gap-10 flex-center"><span class="grid-position pos-top5" style="width:25px;height:25px;font-size:0.7rem;">4-5</span> <span class="text-sm">Top 5</span></div>
            <div class="flex gap-10 flex-center"><span class="grid-position pos-top10" style="width:25px;height:25px;font-size:0.7rem;">6+</span> <span class="text-sm">Top 10</span></div>
            <div class="flex gap-10 flex-center"><span class="grid-position pos-top20" style="width:25px;height:25px;font-size:0.7rem;">11+</span> <span class="text-sm">Top 20</span></div>
            <div class="flex gap-10 flex-center"><span class="grid-position pos-none" style="width:25px;height:25px;font-size:0.7rem;">—</span> <span class="text-sm">Non trouvé</span></div>
        </div>
    </div>

    <!-- Competitors on this keyword -->
    <?php
    $latestPoint = $grid[0] ?? null;
    if ($latestPoint && ($latestPoint['competitor1_name'] || $latestPoint['competitor2_name'] || $latestPoint['competitor3_name'])):
    ?>
    <div class="card">
        <div class="card-title">🏁 Concurrents sur "<?= htmlspecialchars($selectedKeyword) ?>"</div>
        <div class="leads-table-container" style="box-shadow:none;">
            <table class="leads-table">
                <thead>
                    <tr><th>Concurrent</th><th>Position</th></tr>
                </thead>
                <tbody>
                    <?php if ($listing): ?>
                    <tr style="background:#f0fdf4;">
                        <td><strong>🏢 <?= htmlspecialchars($listing['name']) ?> (vous)</strong></td>
                        <td><span class="grid-position <?= posClass($latestPoint['position_maps']) ?>"><?= $latestPoint['position_maps'] ?? '—' ?></span></td>
                    </tr>
                    <?php endif; ?>
                    <?php for ($c = 1; $c <= 3; $c++): ?>
                        <?php if (!empty($latestPoint["competitor{$c}_name"])): ?>
                        <tr>
                            <td><?= htmlspecialchars($latestPoint["competitor{$c}_name"]) ?></td>
                            <td><span class="grid-position <?= posClass($latestPoint["competitor{$c}_position"]) ?>"><?= $latestPoint["competitor{$c}_position"] ?? '—' ?></span></td>
                        </tr>
                        <?php endif; ?>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- History Chart -->
    <?php if (!empty($history)): ?>
    <div class="card">
        <div class="card-title">📈 Évolution de la position — "<?= htmlspecialchars($selectedKeyword) ?>"</div>
        <div style="display:flex;align-items:flex-end;gap:8px;height:200px;padding:20px 0;">
            <?php
            $maxPos = 20;
            foreach ($history as $h):
                $pos = $h['best_position_maps'] ?? $maxPos;
                $height = max(10, ((($maxPos - $pos) / $maxPos) * 100));
            ?>
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;">
                    <span class="text-sm fw-600" style="color:<?= $pos <= 3 ? '#10b981' : ($pos <= 5 ? '#f59e0b' : '#ef4444') ?>">
                        <?= $pos <= $maxPos ? $pos : '—' ?>
                    </span>
                    <div style="width:100%;height:<?= $height ?>%;background:<?= $pos <= 3 ? '#10b981' : ($pos <= 5 ? '#f59e0b' : '#ef4444') ?>;border-radius:4px 4px 0 0;min-height:5px;"></div>
                    <span style="font-size:0.65rem;color:var(--gray-500);writing-mode:vertical-rl;transform:rotate(180deg);max-height:50px;overflow:hidden;">
                        <?= date('d/m', strtotime($h['check_date'])) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center text-sm text-muted">Plus la barre est haute, meilleure est la position (1 = top)</div>
    </div>
    <?php endif; ?>

    <?php endif; // end keyword selected ?>

    <?php elseif ($selectedListing > 0 && empty($keywords)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon">🎯</div>
            <h3>Aucun mot-clé suivi</h3>
            <p>Ajoutez des mots-clés pour suivre votre positionnement Maps.</p>
            <button class="btn btn-primary mt-20" onclick="document.getElementById('addKeywordModal').classList.add('active')">+ Ajouter un mot-clé</button>
        </div>
    </div>
    <?php endif; ?>
</main>

<!-- Add Keyword Modal -->
<div class="modal-overlay" id="addKeywordModal">
    <div class="modal-content">
        <button class="modal-close" onclick="this.closest('.modal-overlay').classList.remove('active')">×</button>
        <h2 style="margin-bottom:20px;">🎯 Ajouter un suivi de mot-clé</h2>
        <form id="keywordForm">
            <div class="form-group">
                <label>Fiche GBP *</label>
                <select name="listing_id" class="form-control" required>
                    <option value="">Sélectionner...</option>
                    <?php foreach ($allListings as $l): ?>
                        <option value="<?= $l['id'] ?>" <?= $selectedListing == $l['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($l['name']) ?> — <?= htmlspecialchars($l['city']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Mot-clé *</label>
                <input type="text" name="keyword" class="form-control" required placeholder="Ex: agent immobilier">
            </div>
            <div class="form-group">
                <label>Ville *</label>
                <input type="text" name="city" class="form-control" required placeholder="Ex: Lyon">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Position Maps (si connue)</label>
                    <input type="number" name="position_maps" class="form-control" min="1" max="100" placeholder="Ex: 3">
                </div>
                <div class="form-group">
                    <label>Position SERP (si connue)</label>
                    <input type="number" name="position_serp" class="form-control" min="1" max="100" placeholder="Ex: 5">
                </div>
            </div>

            <div style="margin:15px 0;padding:15px;background:var(--gray-50);border-radius:var(--radius-sm);">
                <div class="fw-600 text-sm mb-10">Concurrents (optionnel)</div>
                <div class="form-row">
                    <div class="form-group"><input type="text" name="competitor1_name" class="form-control" placeholder="Concurrent 1"></div>
                    <div class="form-group"><input type="number" name="competitor1_position" class="form-control" placeholder="Pos." min="1" max="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><input type="text" name="competitor2_name" class="form-control" placeholder="Concurrent 2"></div>
                    <div class="form-group"><input type="number" name="competitor2_position" class="form-control" placeholder="Pos." min="1" max="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><input type="text" name="competitor3_name" class="form-control" placeholder="Concurrent 3"></div>
                    <div class="form-group"><input type="number" name="competitor3_position" class="form-control" placeholder="Pos." min="1" max="100"></div>
                </div>
            </div>

            <div class="flex gap-10" style="justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addKeywordModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('keywordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const data = {};
    fd.forEach((v, k) => { if(v) data[k] = v; });

    fetch('/api/gmb/api.php?action=add_position', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) {
            window.location.href = '/admin/gmb/positions?listing_id=' + data.listing_id + '&keyword=' + encodeURIComponent(data.keyword);
        } else {
            alert(result.data?.error || 'Erreur');
        }
    })
    .catch(() => alert('Erreur réseau'));
});
</script>
</div>
</body>
</html>
