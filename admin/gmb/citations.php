<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Citations & Cohérence NAP
 */
$pageTitle = 'Citations NAP';
require_once __DIR__ . '/includes/header.php';

$allListings = $gmb->getListings([], 1, 1000)['listings'];
$selectedListing = (int)($_GET['listing_id'] ?? ($allListings[0]['id'] ?? 0));
$listing = $selectedListing > 0 ? $gmb->getListingById($selectedListing) : null;
$citations = $selectedListing > 0 ? $gmb->getCitations($selectedListing) : [];
$citationScore = $selectedListing > 0 ? $gmb->getCitationScore($selectedListing) : [];

// Default directories for real estate
$defaultDirectories = [
    ['name' => 'Google Business Profile', 'type' => 'general', 'url' => 'https://business.google.com'],
    ['name' => 'Pages Jaunes', 'type' => 'general', 'url' => 'https://www.pagesjaunes.fr'],
    ['name' => 'Yelp', 'type' => 'general', 'url' => 'https://www.yelp.fr'],
    ['name' => 'Facebook Business', 'type' => 'social', 'url' => 'https://www.facebook.com'],
    ['name' => 'LinkedIn', 'type' => 'social', 'url' => 'https://www.linkedin.com'],
    ['name' => 'SeLoger', 'type' => 'immobilier', 'url' => 'https://www.seloger.com'],
    ['name' => 'Bien\'ici', 'type' => 'immobilier', 'url' => 'https://www.bienici.com'],
    ['name' => 'Logic-Immo', 'type' => 'immobilier', 'url' => 'https://www.logic-immo.com'],
    ['name' => 'LeBonCoin Immo', 'type' => 'immobilier', 'url' => 'https://www.leboncoin.fr'],
    ['name' => 'MeilleursAgents', 'type' => 'immobilier', 'url' => 'https://www.meilleursagents.com'],
    ['name' => 'Immo2', 'type' => 'immobilier', 'url' => 'https://www.immo2.com'],
    ['name' => 'ParuVendu', 'type' => 'immobilier', 'url' => 'https://www.paruvendu.fr'],
    ['name' => 'Waze', 'type' => 'local', 'url' => 'https://www.waze.com'],
    ['name' => 'Apple Maps', 'type' => 'local', 'url' => 'https://maps.apple.com'],
    ['name' => 'Bing Places', 'type' => 'local', 'url' => 'https://www.bingplaces.com'],
    ['name' => 'TomTom / HERE', 'type' => 'local', 'url' => 'https://www.here.com'],
    ['name' => 'Foursquare', 'type' => 'local', 'url' => 'https://foursquare.com'],
    ['name' => 'Chambre des Notaires', 'type' => 'immobilier', 'url' => 'https://www.notaires.fr'],
];
?>

<?php include __DIR__ . '/includes/sidebar.php'; ?>

<main class="main-content">
    <div class="content-header">
        <div>
            <h1 class="page-title">🔗 Citations & Cohérence NAP</h1>
            <p class="page-subtitle">Vérifiez la cohérence de vos informations sur les annuaires</p>
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('addCitationModal').classList.add('active')">+ Vérifier un annuaire</button>
    </div>

    <!-- Listing Selection -->
    <div class="card">
        <form method="GET" class="flex gap-20" style="align-items:flex-end;flex-wrap:wrap;">
            <div class="form-group mb-0" style="flex:1;min-width:250px;">
                <label>Fiche GBP</label>
                <select name="listing_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Sélectionner une fiche...</option>
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

    <!-- Reference NAP -->
    <div class="card" style="border-left:4px solid var(--primary);">
        <div class="card-title">📋 Informations de référence (NAP)</div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
            <div>
                <div class="text-sm text-muted fw-600 mb-10" style="text-transform:uppercase;letter-spacing:1px;">Nom</div>
                <div class="fw-700" style="font-size:1.1rem;"><?= htmlspecialchars($listing['name']) ?></div>
            </div>
            <div>
                <div class="text-sm text-muted fw-600 mb-10" style="text-transform:uppercase;letter-spacing:1px;">Adresse</div>
                <div class="fw-600"><?= htmlspecialchars($listing['address_line1']) ?>, <?= htmlspecialchars($listing['postal_code']) ?> <?= htmlspecialchars($listing['city']) ?></div>
            </div>
            <div>
                <div class="text-sm text-muted fw-600 mb-10" style="text-transform:uppercase;letter-spacing:1px;">Téléphone</div>
                <div class="fw-700" style="font-size:1.1rem;"><?= htmlspecialchars($listing['phone'] ?? '—') ?></div>
            </div>
        </div>
    </div>

    <!-- NAP Score -->
    <div class="dashboard-grid" style="grid-template-columns:repeat(4,1fr);">
        <div class="stat-card stat-total" style="padding:15px;">
            <div class="stat-content" style="width:100%;text-align:center;">
                <div class="stat-value" style="font-size:1.5rem;"><?= round((float)($citationScore['avg_score'] ?? 0)) ?>%</div>
                <div class="stat-label">Score NAP moyen</div>
            </div>
        </div>
        <div class="stat-card stat-week" style="padding:15px;">
            <div class="stat-content" style="width:100%;text-align:center;">
                <div class="stat-value" style="font-size:1.5rem;color:#10b981;"><?= (int)($citationScore['verified'] ?? 0) ?></div>
                <div class="stat-label">Cohérentes</div>
            </div>
        </div>
        <div class="stat-card" style="padding:15px;">
            <div class="stat-content" style="width:100%;text-align:center;">
                <div class="stat-value" style="font-size:1.5rem;color:#ef4444;"><?= (int)($citationScore['mismatch'] ?? 0) ?></div>
                <div class="stat-label">Incohérentes</div>
            </div>
        </div>
        <div class="stat-card" style="padding:15px;">
            <div class="stat-content" style="width:100%;text-align:center;">
                <div class="stat-value" style="font-size:1.5rem;color:var(--gray-500);"><?= (int)($citationScore['not_found'] ?? 0) ?></div>
                <div class="stat-label">Non trouvées</div>
            </div>
        </div>
    </div>

    <!-- Citations Table -->
    <?php if (!empty($citations)): ?>
    <div class="leads-table-container">
        <table class="leads-table">
            <thead>
                <tr>
                    <th>Annuaire</th>
                    <th>Type</th>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Score</th>
                    <th>Statut</th>
                    <th>Vérifié le</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citations as $cit): ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($cit['directory_name']) ?></strong>
                        <?php if ($cit['directory_url']): ?>
                            <br><a href="<?= htmlspecialchars($cit['directory_url']) ?>" target="_blank" class="text-sm" style="color:var(--primary);">Visiter →</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="lead-type-badge type-<?= ['general'=>'contact','immobilier'=>'offre','local'=>'demo','social'=>'newsletter'][$cit['directory_type']] ?? 'contact' ?>">
                            <?= ucfirst($cit['directory_type']) ?>
                        </span>
                    </td>
                    <td class="<?= $cit['name_match'] ? 'nap-match' : 'nap-mismatch' ?>">
                        <?= $cit['name_match'] ? '✅' : '❌' ?>
                        <?= htmlspecialchars($cit['found_name'] ?? '—') ?>
                    </td>
                    <td class="<?= $cit['address_match'] ? 'nap-match' : 'nap-mismatch' ?>">
                        <?= $cit['address_match'] ? '✅' : '❌' ?>
                        <span class="text-sm"><?= htmlspecialchars($cit['found_address'] ?? '—') ?></span>
                    </td>
                    <td class="<?= $cit['phone_match'] ? 'nap-match' : 'nap-mismatch' ?>">
                        <?= $cit['phone_match'] ? '✅' : '❌' ?>
                        <?= htmlspecialchars($cit['found_phone'] ?? '—') ?>
                    </td>
                    <td>
                        <div class="grid-position <?= $cit['nap_score'] >= 80 ? 'pos-1' : ($cit['nap_score'] >= 50 ? 'pos-top5' : 'pos-top20') ?>" style="width:40px;height:30px;font-size:0.75rem;">
                            <?= $cit['nap_score'] ?>%
                        </div>
                    </td>
                    <td>
                        <span class="citation-status citation-<?= $cit['status'] ?>">
                            <?= ['verified'=>'Cohérent','mismatch'=>'Incohérent','not_found'=>'Non trouvé','pending'=>'En attente'][$cit['status']] ?? $cit['status'] ?>
                        </span>
                    </td>
                    <td class="text-sm text-muted"><?= $cit['last_checked_at'] ? date('d/m/Y', strtotime($cit['last_checked_at'])) : '—' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Suggested Directories -->
    <?php
    $existingDirs = array_column($citations, 'directory_name');
    $suggestedDirs = array_filter($defaultDirectories, function($d) use ($existingDirs) {
        return !in_array($d['name'], $existingDirs);
    });
    ?>
    <?php if (!empty($suggestedDirs)): ?>
    <div class="card">
        <div class="card-title">📌 Annuaires suggérés à vérifier</div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:10px;">
            <?php foreach ($suggestedDirs as $dir): ?>
            <div class="flex-between" style="padding:10px;background:var(--gray-50);border-radius:var(--radius-sm);">
                <div>
                    <div class="fw-600 text-sm"><?= htmlspecialchars($dir['name']) ?></div>
                    <div class="text-sm text-muted"><?= ucfirst($dir['type']) ?></div>
                </div>
                <button class="btn btn-outline btn-sm" onclick="quickAddCitation(<?= $selectedListing ?>, '<?= addslashes($dir['name']) ?>', '<?= addslashes($dir['url']) ?>', '<?= $dir['type'] ?>')">
                    Vérifier
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php elseif (empty($allListings)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon">📍</div>
            <h3>Aucune fiche GBP</h3>
            <p>Ajoutez d'abord une fiche GBP pour vérifier les citations.</p>
            <a href="/admin/gmb/listings" class="btn btn-primary mt-20">Ajouter une fiche</a>
        </div>
    </div>
    <?php endif; ?>
</main>

<!-- Add Citation Modal -->
<div class="modal-overlay" id="addCitationModal">
    <div class="modal-content" style="max-width:650px;">
        <button class="modal-close" onclick="this.closest('.modal-overlay').classList.remove('active')">×</button>
        <h2 style="margin-bottom:20px;">🔗 Vérifier un annuaire</h2>
        <form id="citationForm">
            <input type="hidden" name="listing_id" value="<?= $selectedListing ?>">
            <div class="form-row">
                <div class="form-group">
                    <label>Nom de l'annuaire *</label>
                    <input type="text" name="directory_name" class="form-control" required id="citDirName">
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select name="directory_type" class="form-control" id="citDirType">
                        <option value="general">Général</option>
                        <option value="immobilier">Immobilier</option>
                        <option value="local">Local / GPS</option>
                        <option value="social">Réseau social</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>URL de l'annuaire</label>
                <input type="url" name="directory_url" class="form-control" id="citDirUrl" placeholder="https://...">
            </div>

            <div style="padding:15px;background:var(--gray-50);border-radius:var(--radius-sm);margin-bottom:15px;">
                <div class="fw-600 text-sm mb-10">Informations trouvées sur l'annuaire</div>
                <div class="form-group">
                    <label>Nom trouvé</label>
                    <input type="text" name="found_name" class="form-control" placeholder="Tel que listé sur l'annuaire">
                </div>
                <div class="form-group">
                    <label>Adresse trouvée</label>
                    <input type="text" name="found_address" class="form-control" placeholder="Adresse complète sur l'annuaire">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Téléphone trouvé</label>
                        <input type="text" name="found_phone" class="form-control" placeholder="Numéro sur l'annuaire">
                    </div>
                    <div class="form-group">
                        <label>Site web trouvé</label>
                        <input type="url" name="found_website" class="form-control" placeholder="URL sur l'annuaire">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Statut</label>
                    <select name="status" class="form-control">
                        <option value="pending">En attente</option>
                        <option value="verified">Cohérent</option>
                        <option value="mismatch">Incohérent</option>
                        <option value="not_found">Non trouvé</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-10" style="justify-content:flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addCitationModal').classList.remove('active')">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
function quickAddCitation(listingId, name, url, type) {
    document.getElementById('citDirName').value = name;
    document.getElementById('citDirUrl').value = url;
    document.getElementById('citDirType').value = type;
    document.querySelector('[name="listing_id"]').value = listingId;
    document.getElementById('addCitationModal').classList.add('active');
}

document.getElementById('citationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const data = {};
    fd.forEach((v, k) => { if(v) data[k] = v; });

    // Auto-calculate NAP matches
    <?php if ($listing): ?>
    const refName = <?= json_encode($listing['name']) ?>;
    const refAddress = <?= json_encode(($listing['address_line1'] ?? '') . ', ' . ($listing['postal_code'] ?? '') . ' ' . ($listing['city'] ?? '')) ?>;
    const refPhone = <?= json_encode($listing['phone'] ?? '') ?>;

    if (data.found_name) {
        data.name_match = data.found_name.toLowerCase().trim() === refName.toLowerCase().trim() ? 1 : 0;
    }
    if (data.found_address) {
        data.address_match = data.found_address.toLowerCase().includes(<?= json_encode(strtolower($listing['city'] ?? '')) ?>) ? 1 : 0;
    }
    if (data.found_phone && refPhone) {
        const cleanFound = data.found_phone.replace(/\s+/g, '');
        const cleanRef = refPhone.replace(/\s+/g, '');
        data.phone_match = cleanFound === cleanRef ? 1 : 0;
    }

    // Calculate NAP score
    let score = 0;
    let checks = 0;
    if (data.name_match !== undefined) { score += data.name_match ? 33 : 0; checks++; }
    if (data.address_match !== undefined) { score += data.address_match ? 34 : 0; checks++; }
    if (data.phone_match !== undefined) { score += data.phone_match ? 33 : 0; checks++; }
    data.nap_score = checks > 0 ? score : 0;

    // Auto-set status based on score
    if (data.status === 'pending' && checks > 0) {
        data.status = score >= 80 ? 'verified' : 'mismatch';
    }
    <?php endif; ?>

    fetch('/api/gmb/api.php?action=add_citation', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) location.reload();
        else alert(result.data?.error || 'Erreur');
    })
    .catch(() => alert('Erreur réseau'));
});
</script>
</div>
</body>
</html>
