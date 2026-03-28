<?php
/**
 * ECOSYSTEME IMMO LOCAL+ - Gestion des Offres
 * Liste des offres avec filtres, creation et suppression
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

require_once __DIR__ . '/../../includes/OfferService.php';

$offerService = new OfferService();
$offerService->ensureTable();

// ============================================
// STATS
// ============================================
$counts = $offerService->countByStatus();
$totalOffersCount = $counts['total'];
$activeCount = $counts['active'];
$draftCount = $counts['draft'];
$archivedCount = $counts['archived'];

// ============================================
// PAGINATION ET FILTRES
// ============================================
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 20;
$search = trim($_GET['search'] ?? '');
$filterStatus = $_GET['status'] ?? '';
$filterPriceType = $_GET['price_type'] ?? '';

$where = [];
$params = [];

if ($search) {
    $where[] = "(title LIKE ? OR description LIKE ?)";
    $searchTerm = "%{$search}%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

if ($filterStatus) {
    $where[] = "status = ?";
    $params[] = $filterStatus;
}

if ($filterPriceType) {
    $where[] = "price_type = ?";
    $params[] = $filterPriceType;
}

$whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";

// Count total for pagination
$countSql = "SELECT COUNT(*) as total FROM offers {$whereClause}";
$stmt = $pdo->prepare($countSql);
$stmt->execute($params);
$totalFiltered = $stmt->fetch()['total'];
$totalPages = max(1, ceil($totalFiltered / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

// Fetch offers
$sql = "SELECT * FROM offers {$whereClause} ORDER BY created_at DESC LIMIT {$perPage} OFFSET {$offset}";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$offers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Offres - <?= SITE_NAME ?></title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .header-date {
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        .btn-new {
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-new:hover {
            background: var(--secondary);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .filters-section {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .filters-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-input,
        .form-select {
            padding: 0.75rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.2s;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }

        .form-textarea {
            padding: 0.75rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.2s;
            resize: vertical;
            min-height: 80px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }

        .filters-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary);
        }

        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-800);
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--gray-300);
        }

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

        .table-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .table-stats {
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
        }

        .table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gray-700);
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            font-size: 0.9rem;
        }

        .table tbody tr:hover {
            background: var(--gray-50);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-active { background: #a7f3d0; color: #065f46; }
        .badge-draft { background: #fef3c7; color: #92400e; }
        .badge-archived { background: #e5e7eb; color: #374151; }

        .badge-one_time { background: #dbeafe; color: #1e40af; }
        .badge-recurring { background: #e9d5ff; color: #6b21a8; }
        .badge-deposit { background: #ffedd5; color: #9a3412; }

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

        .action-btn:hover {
            background: var(--secondary);
        }

        .action-btn-edit {
            background: var(--warning);
        }

        .action-btn-edit:hover {
            opacity: 0.85;
        }

        .action-btn-delete {
            background: var(--danger);
        }

        .action-btn-delete:hover {
            opacity: 0.85;
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: var(--gray-500);
        }

        .no-results-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .price {
            font-weight: 600;
            color: var(--gray-900);
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            padding: 2rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.4rem;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination a.active,
        .pagination span.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination span.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
        }

        .modal-form .form-group {
            margin-bottom: 1rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        .conditional-field {
            display: none;
        }

        .conditional-field.visible {
            display: flex;
        }

        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .filters-row {
                grid-template-columns: 1fr;
            }
            .filters-buttons {
                flex-direction: column;
            }
            .table {
                font-size: 0.85rem;
            }
            .table th, .table td {
                padding: 0.75rem;
            }
            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php $activePage = 'offers'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <main class="main">
            <div class="header">
                <div>
                    <h1 class="header-title">Offres</h1>
                    <div class="header-date"><?= date('d/m/Y H:i') ?></div>
                </div>
                <div class="header-actions">
                    <button class="btn-new" onclick="openModal()">+ Nouvelle Offre</button>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-value"><?= $totalOffersCount ?></div>
                    <div class="stat-label">Total Offres</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-value"><?= $activeCount ?></div>
                    <div class="stat-label">Actives</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📝</div>
                    <div class="stat-value"><?= $draftCount ?></div>
                    <div class="stat-label">Brouillons</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📁</div>
                    <div class="stat-value"><?= $archivedCount ?></div>
                    <div class="stat-label">Archivees</div>
                </div>
            </div>

            <!-- Filtres -->
            <div class="filters-section">
                <form method="GET" action="/admin/crm/offers.php">
                    <div class="filters-row">
                        <div class="form-group">
                            <label class="form-label">Recherche</label>
                            <input type="text" name="search" class="form-input"
                                   placeholder="Titre, description..." value="<?= htmlspecialchars($search) ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select">
                                <option value="">-- Tous --</option>
                                <option value="active" <?= $filterStatus === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="draft" <?= $filterStatus === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                                <option value="archived" <?= $filterStatus === 'archived' ? 'selected' : '' ?>>Archivee</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Type de prix</label>
                            <select name="price_type" class="form-select">
                                <option value="">-- Tous --</option>
                                <option value="one_time" <?= $filterPriceType === 'one_time' ? 'selected' : '' ?>>Comptant</option>
                                <option value="recurring" <?= $filterPriceType === 'recurring' ? 'selected' : '' ?>>Recurrent</option>
                                <option value="deposit" <?= $filterPriceType === 'deposit' ? 'selected' : '' ?>>Avec acompte</option>
                            </select>
                        </div>
                    </div>

                    <div class="filters-buttons">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                        <a href="/admin/crm/offers.php" class="btn btn-secondary">Reinitialiser</a>
                    </div>
                </form>
            </div>

            <!-- Table des offres -->
            <div class="table-section">
                <div class="table-header">
                    <div class="table-title">Offres (<?= $totalFiltered ?> total)</div>
                    <div class="table-stats">Page <?= $page ?> / <?= max(1, $totalPages) ?></div>
                </div>

                <?php if (empty($offers)): ?>
                    <div class="no-results">
                        <div class="no-results-icon">📦</div>
                        <p>Aucune offre trouvee</p>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Prix</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $priceTypeLabels = [
                                'one_time' => 'Comptant',
                                'recurring' => 'Recurrent',
                                'deposit' => 'Avec acompte',
                            ];
                            $statusLabels = [
                                'active' => 'Active',
                                'draft' => 'Brouillon',
                                'archived' => 'Archivee',
                            ];
                            ?>
                            <?php foreach ($offers as $offer): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($offer['title']) ?></strong>
                                    <?php if (!empty($offer['description'])): ?>
                                        <br><small style="color: var(--gray-500);"><?= htmlspecialchars(mb_strimwidth($offer['description'], 0, 80, '...')) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="price"><?= number_format($offer['price'], 2, ',', ' ') ?> &euro;</span>
                                    <?php if ($offer['price_type'] === 'recurring' && !empty($offer['recurring_interval'])): ?>
                                        <?php
                                        $intervalLabels = ['monthly' => '/mois', 'quarterly' => '/trimestre', 'yearly' => '/an'];
                                        ?>
                                        <br><small style="color: var(--gray-500);"><?= $intervalLabels[$offer['recurring_interval']] ?? '/ ' . htmlspecialchars($offer['recurring_interval']) ?></small>
                                    <?php elseif ($offer['price_type'] === 'deposit' && !empty($offer['deposit_amount'])): ?>
                                        <br><small style="color: var(--gray-500);">Acompte : <?= number_format($offer['deposit_amount'], 2, ',', ' ') ?> &euro;</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $offer['price_type'] ?>">
                                        <?= $priceTypeLabels[$offer['price_type']] ?? $offer['price_type'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $offer['status'] ?>">
                                        <?= $statusLabels[$offer['status']] ?? $offer['status'] ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($offer['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/admin/crm/offer-detail.php?id=<?= $offer['id'] ?>" class="action-btn">Voir</a>
                                        <a href="/admin/crm/offer-edit.php?id=<?= $offer['id'] ?>" class="action-btn action-btn-edit">Modifier</a>
                                        <button class="action-btn action-btn-delete" onclick="deleteOffer(<?= $offer['id'] ?>, '<?= htmlspecialchars(addslashes($offer['title'])) ?>')">Supprimer</button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="/admin/crm/offers.php?page=1<?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?><?= $filterPriceType ? "&price_type=" . urlencode($filterPriceType) : "" ?>">&laquo;</a>
                            <a href="/admin/crm/offers.php?page=<?= $page - 1 ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?><?= $filterPriceType ? "&price_type=" . urlencode($filterPriceType) : "" ?>">&lsaquo;</a>
                        <?php else: ?>
                            <span class="disabled">&laquo;</span>
                            <span class="disabled">&lsaquo;</span>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <?php if ($i === $page): ?>
                                <span class="active"><?= $i ?></span>
                            <?php else: ?>
                                <a href="/admin/crm/offers.php?page=<?= $i ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?><?= $filterPriceType ? "&price_type=" . urlencode($filterPriceType) : "" ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="/admin/crm/offers.php?page=<?= $page + 1 ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?><?= $filterPriceType ? "&price_type=" . urlencode($filterPriceType) : "" ?>">&rsaquo;</a>
                            <a href="/admin/crm/offers.php?page=<?= $totalPages ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?><?= $filterPriceType ? "&price_type=" . urlencode($filterPriceType) : "" ?>">&raquo;</a>
                        <?php else: ?>
                            <span class="disabled">&rsaquo;</span>
                            <span class="disabled">&raquo;</span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Modal Nouvelle Offre -->
    <div class="modal-overlay" id="offerModal">
        <div class="modal">
            <h2 class="modal-title">Nouvelle Offre</h2>
            <form class="modal-form" id="offerForm" onsubmit="submitOffer(event)">
                <div class="form-group">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="title" class="form-input" required placeholder="Nom de l'offre">
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" placeholder="Description de l'offre..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Prix *</label>
                    <input type="number" name="price" class="form-input" required min="0" step="0.01" placeholder="0.00">
                </div>

                <div class="form-group">
                    <label class="form-label">Type de prix</label>
                    <select name="price_type" class="form-select" id="priceTypeSelect" onchange="toggleConditionalFields()">
                        <option value="one_time">Comptant</option>
                        <option value="recurring">Recurrent</option>
                        <option value="deposit">Avec acompte</option>
                    </select>
                </div>

                <div class="form-group conditional-field" id="recurringField">
                    <label class="form-label">Intervalle</label>
                    <select name="recurring_interval" class="form-select">
                        <option value="monthly">Mensuel</option>
                        <option value="quarterly">Trimestriel</option>
                        <option value="yearly">Annuel</option>
                    </select>
                </div>

                <div class="form-group conditional-field" id="depositField">
                    <label class="form-label">Montant acompte</label>
                    <input type="number" name="deposit_amount" class="form-input" min="0" step="0.01" placeholder="0.00">
                </div>

                <div class="form-group">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="draft">Brouillon</option>
                        <option value="active">Active</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Conditions Generales</label>
                    <button type="button" class="btn btn-secondary" style="margin-bottom:0.5rem;font-size:0.8rem;padding:0.4rem 0.8rem;" onclick="generateTerms()">Generer automatiquement</button>
                    <textarea name="terms_conditions" id="termsField" class="form-textarea" style="min-height:150px;" placeholder="Conditions generales de l'offre..."></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Creer l'offre</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    var csrfToken = '<?= generateCsrfToken() ?>';

    function openModal() {
        document.getElementById('offerModal').classList.add('active');
    }

    function closeModal() {
        document.getElementById('offerModal').classList.remove('active');
        document.getElementById('offerForm').reset();
        toggleConditionalFields();
    }

    // Close modal on overlay click
    document.getElementById('offerModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    function toggleConditionalFields() {
        var priceType = document.getElementById('priceTypeSelect').value;
        var recurringField = document.getElementById('recurringField');
        var depositField = document.getElementById('depositField');

        recurringField.classList.remove('visible');
        depositField.classList.remove('visible');

        if (priceType === 'recurring') {
            recurringField.classList.add('visible');
        } else if (priceType === 'deposit') {
            depositField.classList.add('visible');
        }
    }

    function submitOffer(e) {
        e.preventDefault();
        var form = e.target;
        var data = {
            title: form.title.value,
            description: form.description.value,
            price: parseFloat(form.price.value),
            price_type: form.price_type.value,
            status: form.status.value
        };

        if (data.price_type === 'recurring') {
            data.recurring_interval = form.recurring_interval.value;
        }
        if (data.price_type === 'deposit') {
            data.deposit_amount = parseFloat(form.deposit_amount.value) || 0;
        }

        data.terms_conditions = form.terms_conditions.value;
        data.csrf_token = csrfToken;

        fetch('/admin/crm/api.php?action=create_offer', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(function(r) { return r.json(); })
        .then(function(result) {
            if (result.success) {
                location.reload();
            } else {
                alert(result.message || 'Erreur lors de la creation');
            }
        })
        .catch(function() {
            alert('Erreur reseau');
        });
    }

    function generateTerms() {
        var form = document.getElementById('offerForm');
        var title = form.title.value || 'cette offre';
        var price = form.price.value || '0';
        var priceType = form.price_type.value;
        var interval = form.recurring_interval ? form.recurring_interval.value : '';
        var deposit = form.deposit_amount ? form.deposit_amount.value : '';

        var priceLabel = parseFloat(price).toFixed(2).replace('.', ',') + ' EUR';
        var typeLabel = priceType === 'recurring' ? 'abonnement' : (priceType === 'deposit' ? 'avec acompte' : 'paiement unique');

        var intervalText = '';
        if (priceType === 'recurring') {
            var intervals = { monthly: 'mensuel', quarterly: 'trimestriel', yearly: 'annuel' };
            intervalText = '\n- Frequence de facturation : ' + (intervals[interval] || interval);
        }

        var depositText = '';
        if (priceType === 'deposit' && deposit) {
            depositText = '\n- Acompte requis : ' + parseFloat(deposit).toFixed(2).replace('.', ',') + ' EUR a la signature';
            depositText += '\n- Solde restant : ' + (parseFloat(price) - parseFloat(deposit)).toFixed(2).replace('.', ',') + ' EUR payable a la livraison';
        }

        var terms = 'CONDITIONS GENERALES - ' + title.toUpperCase() + '\n';
        terms += '========================================\n\n';
        terms += '1. OBJET\n';
        terms += 'Les presentes conditions regissent la souscription a l\'offre "' + title + '" proposee par Ecosysteme Immo Local+.\n\n';
        terms += '2. TARIFICATION\n';
        terms += '- Prix : ' + priceLabel + ' (' + typeLabel + ')';
        terms += intervalText;
        terms += depositText;
        terms += '\n- TVA non applicable (art. 293 B du CGI) ou TVA en sus selon regime fiscal.\n\n';
        terms += '3. MODALITES DE PAIEMENT\n';
        if (priceType === 'recurring') {
            terms += '- Le paiement est effectue de maniere recurrente selon la frequence choisie.\n';
            terms += '- Le prelevement est realise automatiquement a chaque echeance.\n';
            terms += '- Toute annulation doit etre notifiee au moins 15 jours avant la prochaine echeance.\n\n';
        } else if (priceType === 'deposit') {
            terms += '- Un acompte est verse a la signature du contrat.\n';
            terms += '- Le solde est payable selon les conditions convenues entre les parties.\n\n';
        } else {
            terms += '- Le paiement integral est du a la souscription de l\'offre.\n';
            terms += '- Modes de paiement acceptes : virement bancaire, carte bancaire.\n\n';
        }
        terms += '4. DROIT DE RETRACTATION\n';
        terms += 'Conformement aux articles L221-18 et suivants du Code de la consommation, le client dispose d\'un delai de 14 jours a compter de la souscription pour exercer son droit de retractation, sans avoir a justifier de motifs.\n\n';
        terms += '5. DUREE ET RESILIATION\n';
        if (priceType === 'recurring') {
            terms += '- L\'abonnement est conclu pour une duree indeterminee.\n';
            terms += '- Chaque partie peut resilier avec un preavis de 30 jours.\n';
            terms += '- La resiliation prend effet a la fin de la periode en cours.\n\n';
        } else {
            terms += '- La prestation demarre a la reception du paiement.\n';
            terms += '- Les delais de livraison sont communiques lors de la souscription.\n\n';
        }
        terms += '6. RESPONSABILITE\n';
        terms += 'Ecosysteme Immo Local+ s\'engage a fournir les services decrits dans l\'offre avec diligence et professionnalisme. La responsabilite est limitee au montant de la prestation.\n\n';
        terms += '7. DONNEES PERSONNELLES\n';
        terms += 'Les donnees collectees sont traitees conformement au RGPD. Le client dispose d\'un droit d\'acces, de rectification et de suppression de ses donnees.\n\n';
        terms += '8. LITIGES\n';
        terms += 'En cas de litige, les parties s\'engagent a rechercher une solution amiable. A defaut, les tribunaux competents seront saisis conformement au droit francais.\n\n';
        terms += '---\n';
        terms += 'Date de generation : ' + new Date().toLocaleDateString('fr-FR') + '\n';
        terms += 'Ecosysteme Immo Local+ - Tous droits reserves.';

        document.getElementById('termsField').value = terms;
    }

    function deleteOffer(id, title) {
        if (!confirm('Supprimer l\'offre "' + title + '" ?')) return;

        fetch('/admin/crm/api.php?action=delete_offer', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, csrf_token: csrfToken })
        })
        .then(function(r) { return r.json(); })
        .then(function(result) {
            if (result.success) {
                location.reload();
            } else {
                alert(result.message || 'Erreur lors de la suppression');
            }
        })
        .catch(function() {
            alert('Erreur reseau');
        });
    }
    </script>
</body>
</html>
