<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Gestion des fiches GBP
 */
$pageTitle = 'Fiches GBP';
require_once __DIR__ . '/includes/header.php';

$page = max(1, (int)($_GET['page'] ?? 1));
$filters = [
    'search' => $_GET['search'] ?? '',
    'postal_code' => $_GET['postal_code'] ?? '',
    'city' => $_GET['city'] ?? '',
    'status' => $_GET['status'] ?? '',
    'agent_name' => $_GET['agent_name'] ?? '',
];
$data = $gmb->getListings($filters, $page);
$listings = $data['listings'];

$allPostalCodes = $gmb->getAllPostalCodes();
$allCities = $gmb->getAllCities();
$allAgents = $gmb->getAllAgents();

// Detail view?
$detailId = (int)($_GET['id'] ?? 0);
$detail = $detailId > 0 ? $gmb->getListingById($detailId) : null;
$healthBreakdown = $detail ? $gmb->getHealthBreakdown($detailId) : [];

function healthClassFn($score) {
    if ($score >= 80) return 'health-excellent';
    if ($score >= 60) return 'health-good';
    if ($score >= 40) return 'health-average';
    return 'health-poor';
}
function barColorFn($score, $max) {
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
            <h1 class="page-title">📍 Fiches Google Business Profile</h1>
            <p class="page-subtitle"><?= $data['total'] ?> fiche(s) enregistrée(s)</p>
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('addModal').classList.add('active')">+ Ajouter une fiche</button>
    </div>

    <?php if ($detail): ?>
    <!-- Detail View -->
    <div class="card" style="border-left:4px solid <?= barColorFn($detail['health_score'], 100) ?>">
        <div class="flex-between mb-20">
            <div>
                <h2 style="font-size:1.3rem;font-weight:700;"><?= htmlspecialchars($detail['name']) ?></h2>
                <p class="text-muted"><?= htmlspecialchars($detail['address_line1']) ?>, <?= htmlspecialchars($detail['postal_code']) ?> <?= htmlspecialchars($detail['city']) ?></p>
            </div>
            <a href="/admin/gmb/listings" class="btn btn-outline btn-sm">← Retour</a>
        </div>

        <div style="display:grid;grid-template-columns:200px 1fr;gap:30px;">
            <!-- Health Score -->
            <div class="text-center">
                <div class="health-score-big <?= healthClassFn($detail['health_score']) ?>">
                    <span class="score-value"><?= $detail['health_score'] ?></span>
                    <span class="score-label">/100</span>
                </div>
                <p class="text-sm fw-600">Score de santé</p>
            </div>

            <!-- Health Breakdown -->
            <div>
                <h3 class="text-sm fw-700 mb-10" style="text-transform:uppercase;letter-spacing:1px;color:var(--gray-500);">Détail de l'audit</h3>
                <?php if (!empty($healthBreakdown)): ?>
                    <?php foreach ($healthBreakdown as $key => $item): ?>
                    <div class="health-bar">
                        <span class="health-bar-label"><?= htmlspecialchars($item['label']) ?></span>
                        <div class="health-bar-track">
                            <div class="health-bar-fill" style="width:<?= $item['max'] > 0 ? ($item['score']/$item['max'])*100 : 0 ?>%;background:<?= barColorFn($item['score'], $item['max']) ?>"></div>
                        </div>
                        <span class="health-bar-value"><?= $item['score'] ?>/<?= $item['max'] ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-sm">Aucun détail disponible. Recalculez le score.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Listing Details -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:25px;padding-top:20px;border-top:1px solid var(--gray-200);">
            <div>
                <div class="detail-row">
                    <span class="detail-label">Téléphone</span>
                    <span class="detail-value"><?= htmlspecialchars($detail['phone'] ?? '—') ?></span>
                </div>
                <div class="detail-row" style="margin-top:8px;">
                    <span class="detail-label">Site web</span>
                    <span class="detail-value"><?= $detail['website'] ? '<a href="'.htmlspecialchars($detail['website']).'" target="_blank">'.htmlspecialchars($detail['website']).'</a>' : '—' ?></span>
                </div>
                <div class="detail-row" style="margin-top:8px;">
                    <span class="detail-label">Catégorie</span>
                    <span class="detail-value"><?= htmlspecialchars($detail['primary_category'] ?? '—') ?></span>
                </div>
                <div class="detail-row" style="margin-top:8px;">
                    <span class="detail-label">Conseiller</span>
                    <span class="detail-value"><?= htmlspecialchars($detail['agent_name'] ?? '—') ?></span>
                </div>
            </div>
            <div>
                <div class="detail-row">
                    <span class="detail-label">Statut</span>
                    <span class="detail-value">
                        <span class="citation-<?= $detail['status'] === 'active' ? 'verified' : 'pending' ?>">
                            <?= ucfirst($detail['status']) ?>
                        </span>
                    </span>
                </div>
                <div class="detail-row" style="margin-top:8px;">
                    <span class="detail-label">Vérification</span>
                    <span class="detail-value">
                        <span class="citation-<?= $detail['verification_status'] === 'verified' ? 'verified' : 'pending' ?>">
                            <?= ucfirst($detail['verification_status']) ?>
                        </span>
                    </span>
                </div>
                <div class="detail-row" style="margin-top:8px;">
                    <span class="detail-label">Photos</span>
                    <span class="detail-value"><?= (int)$detail['photos_count'] ?> photo(s)</span>
                </div>
                <div class="detail-row" style="margin-top:8px;">
                    <span class="detail-label">Dernière sync</span>
                    <span class="detail-value"><?= $detail['last_synced_at'] ? date('d/m/Y H:i', strtotime($detail['last_synced_at'])) : '—' ?></span>
                </div>
            </div>
        </div>

        <?php if (!empty($detail['description'])): ?>
        <div style="margin-top:15px;padding-top:15px;border-top:1px solid var(--gray-200);">
            <div class="text-sm fw-600 mb-10">Description</div>
            <p class="text-sm" style="color:var(--gray-600);line-height:1.6;"><?= nl2br(htmlspecialchars($detail['description'])) ?></p>
        </div>
        <?php endif; ?>

        <div class="flex gap-10 mt-20">
            <a href="/admin/gmb/reviews?listing_id=<?= $detail['id'] ?>" class="btn btn-outline btn-sm">⭐ Voir les avis</a>
            <a href="/admin/gmb/posts?listing_id=<?= $detail['id'] ?>" class="btn btn-outline btn-sm">📝 Publications</a>
            <a href="/admin/gmb/positions?listing_id=<?= $detail['id'] ?>" class="btn btn-outline btn-sm">🗺️ Positions</a>
            <a href="/admin/gmb/citations?listing_id=<?= $detail['id'] ?>" class="btn btn-outline btn-sm">🔗 Citations</a>
            <button class="btn btn-primary btn-sm" onclick="recalcScore(<?= $detail['id'] ?>)">🔄 Recalculer le score</button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="filters-bar">
        <form class="filters-form" method="GET">
            <div class="filter-group">
                <input type="text" name="search" class="filter-input" placeholder="Rechercher..." value="<?= htmlspecialchars($filters['search']) ?>">
            </div>
            <div class="filter-group" style="min-width:140px;">
                <select name="postal_code" class="filter-select">
                    <option value="">Code postal</option>
                    <?php foreach ($allPostalCodes as $cp): ?>
                        <option value="<?= htmlspecialchars($cp) ?>" <?= $filters['postal_code'] === $cp ? 'selected' : '' ?>><?= htmlspecialchars($cp) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group" style="min-width:140px;">
                <select name="agent_name" class="filter-select">
                    <option value="">Conseiller</option>
                    <?php foreach ($allAgents as $agent): ?>
                        <option value="<?= htmlspecialchars($agent) ?>" <?= $filters['agent_name'] === $agent ? 'selected' : '' ?>><?= htmlspecialchars($agent) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group" style="min-width:120px;">
                <select name="status" class="filter-select">
                    <option value="">Statut</option>
                    <option value="active" <?= $filters['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="suspended" <?= $filters['status'] === 'suspended' ? 'selected' : '' ?>>Suspendue</option>
                    <option value="pending" <?= $filters['status'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filtrer</button>
            <a href="/admin/gmb/listings" class="btn btn-ghost">Reset</a>
        </form>
    </div>

    <!-- Listings Table -->
    <div class="leads-table-container">
        <?php if (empty($listings)): ?>
            <div class="empty-state">
                <div class="empty-icon">📍</div>
                <h3>Aucune fiche GBP</h3>
                <p>Ajoutez votre première fiche Google Business Profile pour commencer l'audit.</p>
            </div>
        <?php else: ?>
            <table class="leads-table">
                <thead>
                    <tr>
                        <th>Score</th>
                        <th>Nom de la fiche</th>
                        <th>Ville / CP</th>
                        <th>Conseiller</th>
                        <th>Avis</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listings as $l): ?>
                    <tr>
                        <td>
                            <div class="grid-position <?= $l['health_score'] >= 80 ? 'pos-1' : ($l['health_score'] >= 60 ? 'pos-top5' : ($l['health_score'] >= 40 ? 'pos-top10' : 'pos-top20')) ?>" style="width:45px;height:45px;border-radius:10px;">
                                <?= $l['health_score'] ?>
                            </div>
                        </td>
                        <td>
                            <a href="/admin/gmb/listings?id=<?= $l['id'] ?>" style="text-decoration:none;color:inherit;">
                                <strong><?= htmlspecialchars($l['name']) ?></strong>
                                <div class="text-sm text-muted"><?= htmlspecialchars($l['primary_category'] ?? '') ?></div>
                            </a>
                        </td>
                        <td>
                            <?= htmlspecialchars($l['city']) ?><br>
                            <span class="text-sm text-muted"><?= htmlspecialchars($l['postal_code']) ?></span>
                        </td>
                        <td><?= htmlspecialchars($l['agent_name'] ?? '—') ?></td>
                        <td>
                            <span class="stars"><?= number_format((float)($l['avg_rating'] ?? 0), 1) ?> ★</span>
                            <span class="text-sm text-muted">(<?= (int)($l['reviews_count'] ?? 0) ?>)</span>
                        </td>
                        <td>
                            <span class="citation-<?= $l['status'] === 'active' ? 'verified' : ($l['status'] === 'suspended' ? 'mismatch' : 'pending') ?>">
                                <?= ucfirst($l['status']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="/admin/gmb/listings?id=<?= $l['id'] ?>" class="action-btn" title="Voir détail">👁️</a>
                                <a href="/admin/gmb/reviews?listing_id=<?= $l['id'] ?>" class="action-btn" title="Avis">⭐</a>
                                <a href="/admin/gmb/positions?listing_id=<?= $l['id'] ?>" class="action-btn" title="Positions">🗺️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($data['totalPages'] > 1): ?>
            <div style="padding:15px 20px;display:flex;justify-content:center;gap:5px;">
                <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                    <a href="?page=<?= $i ?>&<?= http_build_query(array_filter($filters)) ?>" class="btn <?= $i === $page ? 'btn-primary' : 'btn-outline' ?> btn-sm"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>

<!-- Add Listing Modal -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content" style="max-width:700px;">
        <button class="modal-close" onclick="this.closest('.modal-overlay').classList.remove('active')">×</button>
        <h2 style="margin-bottom:20px;">📍 Ajouter une fiche GBP</h2>
        <form id="addListingForm">
            <div class="form-row">
                <div class="form-group">
                    <label>Nom de la fiche *</label>
                    <input type="text" name="name" class="form-control" required placeholder="Ex: Agence Immobilière Dupont">
                </div>
                <div class="form-group">
                    <label>Catégorie principale</label>
                    <input type="text" name="primary_category" class="form-control" placeholder="Ex: Agent immobilier">
                </div>
            </div>
            <div class="form-group">
                <label>Adresse *</label>
                <input type="text" name="address_line1" class="form-control" required placeholder="Numéro et rue">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Ville *</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Code postal *</label>
                    <input type="text" name="postal_code" class="form-control" required pattern="[0-9]{5}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="tel" name="phone" class="form-control" placeholder="01 23 45 67 89">
                </div>
                <div class="form-group">
                    <label>Site web</label>
                    <input type="url" name="website" class="form-control" placeholder="https://...">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Conseiller associé</label>
                    <input type="text" name="agent_name" class="form-control" placeholder="Nom du conseiller">
                </div>
                <div class="form-group">
                    <label>Google Place ID</label>
                    <input type="text" name="google_place_id" class="form-control" placeholder="ChIJ...">
                </div>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Description de l'activité (250 caractères min. recommandé)"></textarea>
            </div>
            <div class="flex gap-10" style="justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="btn btn-primary">Ajouter la fiche</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('addListingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = {};
    formData.forEach((v, k) => { if(v) data[k] = v; });

    fetch('/api/gmb/api.php?action=create_listing', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) {
            window.location.href = '/admin/gmb/listings?id=' + result.data.id;
        } else {
            alert(result.data?.error || 'Erreur lors de la création');
        }
    })
    .catch(() => alert('Erreur réseau'));
});

function recalcScore(id) {
    fetch('/api/gmb/api.php?action=recalc_score', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ listing_id: id })
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) location.reload();
        else alert('Erreur');
    });
}
</script>
</div>
</body>
</html>
