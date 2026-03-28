<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Détail d'une Offre
 * Page pour consulter et modifier les infos d'une offre
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';
require_once __DIR__ . '/../../includes/OfferService.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

// Récupérer l'ID de l'offre
$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header('Location: /admin/crm/offers');
    exit;
}

$offerService = new OfferService();
$offerService->ensureTable();

$offer = $offerService->getOffer($id);

if (!$offer) {
    header('Location: /admin/crm/offers');
    exit;
}

// Badge statut
$statusLabels = [
    'draft'    => 'Brouillon',
    'active'   => 'Active',
    'archived' => 'Archivée',
];

$statusColors = [
    'draft'    => 'badge-draft',
    'active'   => 'badge-active',
    'archived' => 'badge-archived',
];

$priceTypeLabels = [
    'one_time'  => 'Comptant',
    'recurring' => 'Récurrent',
    'deposit'   => 'Acompte',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Détail de l'Offre - <?= SITE_NAME ?></title>
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
            gap: 1rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-left h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .breadcrumb {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .back-btn {
            padding: 0.75rem 1.5rem;
            background: var(--gray-200);
            color: var(--gray-800);
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: var(--gray-300);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.2s;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-textarea-large {
            min-height: 250px;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group .form-input {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-suffix {
            padding: 0.75rem 1rem;
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            border-left: none;
            border-radius: 0 0.5rem 0.5rem 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-500);
        }

        .badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-draft { background: #e5e7eb; color: #374151; }
        .badge-active { background: #a7f3d0; color: #065f46; }
        .badge-archived { background: #fcd34d; color: #78350f; }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background: var(--secondary);
        }

        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-800);
            width: 100%;
        }

        .btn-secondary:hover {
            background: var(--gray-300);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
            width: 100%;
        }

        .btn-danger:hover {
            opacity: 0.85;
        }

        .btn-success {
            background: var(--success);
            color: white;
            width: 100%;
        }

        .btn-success:hover {
            opacity: 0.85;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--gray-500);
        }

        .stat-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .conditional-field {
            display: none;
        }

        .conditional-field.visible {
            display: block;
        }

        /* Toast notifications */
        .toast {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
            z-index: 9999;
            opacity: 0;
            transform: translateY(-1rem);
            transition: all 0.3s ease;
            pointer-events: none;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .toast.visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .toast-success {
            background: var(--success);
        }

        .toast-error {
            background: var(--danger);
        }

        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .main { padding: 1rem; }
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .grid-2 {
                grid-template-columns: 1fr;
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
                    <div class="header-left">
                        <a href="/admin/crm/offers" class="back-btn" title="Retour aux offres">&larr;</a>
                        <h1><?= h($offer['title']) ?></h1>
                        <span class="badge <?= $statusColors[$offer['status']] ?? 'badge-draft' ?>">
                            <?= $statusLabels[$offer['status']] ?? ucfirst($offer['status']) ?>
                        </span>
                    </div>
                    <div class="breadcrumb" style="margin-left: 4.5rem;">Dashboard > Offres > Détail</div>
                </div>
            </div>

            <div class="grid-2">
                <!-- Colonne gauche : infos principales -->
                <div>
                    <!-- Informations de l'offre -->
                    <div class="card">
                        <div class="card-title">Informations de l'offre</div>

                        <div class="form-group">
                            <label class="form-label" for="offer-title">Titre</label>
                            <input type="text" id="offer-title" class="form-input" value="<?= h($offer['title']) ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="offer-slug">Slug</label>
                            <input type="text" id="offer-slug" class="form-input" value="<?= h($offer['slug']) ?>" style="color: var(--gray-500);">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="offer-description">Description courte</label>
                            <textarea id="offer-description" class="form-textarea"><?= h($offer['description'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="offer-detailed-content">Contenu détaillé</label>
                            <textarea id="offer-detailed-content" class="form-textarea form-textarea-large"><?= h($offer['detailed_content'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- Tarification -->
                    <div class="card">
                        <div class="card-title">Tarification</div>

                        <div class="form-group">
                            <label class="form-label" for="offer-price">Prix</label>
                            <div class="input-group">
                                <input type="number" id="offer-price" class="form-input" step="0.01" min="0" value="<?= h($offer['price']) ?>">
                                <span class="input-suffix">&euro;</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="offer-price-type">Type</label>
                            <select id="offer-price-type" class="form-select" onchange="toggleConditionalFields()">
                                <option value="one_time" <?= $offer['price_type'] === 'one_time' ? 'selected' : '' ?>>Comptant</option>
                                <option value="recurring" <?= $offer['price_type'] === 'recurring' ? 'selected' : '' ?>>Récurrent</option>
                                <option value="deposit" <?= $offer['price_type'] === 'deposit' ? 'selected' : '' ?>>Acompte</option>
                            </select>
                        </div>

                        <div class="form-group conditional-field" id="field-recurring-interval">
                            <label class="form-label" for="offer-recurring-interval">Intervalle de récurrence</label>
                            <select id="offer-recurring-interval" class="form-select">
                                <option value="monthly" <?= ($offer['recurring_interval'] ?? '') === 'monthly' ? 'selected' : '' ?>>Mensuel</option>
                                <option value="quarterly" <?= ($offer['recurring_interval'] ?? '') === 'quarterly' ? 'selected' : '' ?>>Trimestriel</option>
                                <option value="yearly" <?= ($offer['recurring_interval'] ?? '') === 'yearly' ? 'selected' : '' ?>>Annuel</option>
                            </select>
                        </div>

                        <div class="form-group conditional-field" id="field-deposit-amount">
                            <label class="form-label" for="offer-deposit-amount">Montant de l'acompte</label>
                            <div class="input-group">
                                <input type="number" id="offer-deposit-amount" class="form-input" step="0.01" min="0" value="<?= h($offer['deposit_amount'] ?? '') ?>">
                                <span class="input-suffix">&euro;</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne droite : métadonnées -->
                <div>
                    <!-- Statut & Actions -->
                    <div class="card">
                        <div class="card-title">Statut & Actions</div>

                        <div class="form-group">
                            <label class="form-label" for="offer-status">Statut</label>
                            <select id="offer-status" class="form-select">
                                <option value="draft" <?= $offer['status'] === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                                <option value="active" <?= $offer['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="archived" <?= $offer['status'] === 'archived' ? 'selected' : '' ?>>Archivée</option>
                            </select>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" onclick="saveOffer()">Enregistrer</button>
                            <?php if ($offer['status'] === 'active'): ?>
                            <a href="/offres/<?= h($offer['slug']) ?>" target="_blank" class="btn btn-secondary">Prévisualiser</a>
                            <?php else: ?>
                            <a href="/offres/<?= h($offer['slug']) ?>?preview=1" target="_blank" class="btn btn-secondary">Prévisualiser</a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-success" onclick="window.open('/offres/<?= h($offer['slug']) ?>/pdf', '_blank')">Générer PDF</button>
                            <button type="button" class="btn btn-danger" onclick="deleteOffer()">Supprimer</button>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="card">
                        <div class="card-title">Statistiques</div>

                        <div class="stat-item">
                            <span class="stat-label">Nombre de vues</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Temps moyen de lecture</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Conversions</span>
                            <span class="stat-value">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Toast notification -->
    <div id="toast" class="toast"></div>

    <script>
    const offerId = <?= intval($offer['id']) ?>;
    const csrfToken = '<?= $_SESSION['csrf_token'] ?? '' ?>';

    // Toggle conditional fields based on price_type
    function toggleConditionalFields() {
        const priceType = document.getElementById('offer-price-type').value;
        const recurringField = document.getElementById('field-recurring-interval');
        const depositField = document.getElementById('field-deposit-amount');

        recurringField.classList.toggle('visible', priceType === 'recurring');
        depositField.classList.toggle('visible', priceType === 'deposit');
    }

    // Init conditional fields on page load
    toggleConditionalFields();

    // Auto-generate slug from title
    document.getElementById('offer-title').addEventListener('input', function() {
        const title = this.value;
        let slug = title.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\-]/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
        document.getElementById('offer-slug').value = slug;
    });

    // Show toast notification
    function showToast(message, type) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = 'toast toast-' + type + ' visible';

        setTimeout(function() {
            toast.classList.remove('visible');
        }, 3000);
    }

    // Save offer
    function saveOffer() {
        const data = {
            id: offerId,
            csrf_token: csrfToken,
            title: document.getElementById('offer-title').value,
            description: document.getElementById('offer-description').value,
            detailed_content: document.getElementById('offer-detailed-content').value,
            price: parseFloat(document.getElementById('offer-price').value) || 0,
            price_type: document.getElementById('offer-price-type').value,
            recurring_interval: document.getElementById('offer-recurring-interval').value,
            deposit_amount: parseFloat(document.getElementById('offer-deposit-amount').value) || 0,
            deposit_enabled: document.getElementById('offer-price-type').value === 'deposit' ? 1 : 0,
            status: document.getElementById('offer-status').value
        };

        fetch('/admin/crm/api.php?action=update_offer', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(function(r) { return r.json(); })
        .then(function(result) {
            if (result.success) {
                showToast('Offre enregistrée avec succès', 'success');
            } else {
                showToast(result.error || result.message || 'Erreur lors de la sauvegarde', 'error');
            }
        })
        .catch(function() {
            showToast('Erreur réseau', 'error');
        });
    }

    // Delete offer
    function deleteOffer() {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette offre ? Cette action est irréversible.')) {
            return;
        }

        fetch('/admin/crm/api.php?action=delete_offer', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: offerId, csrf_token: csrfToken })
        })
        .then(function(r) { return r.json(); })
        .then(function(result) {
            if (result.success) {
                showToast('Offre supprimée', 'success');
                setTimeout(function() {
                    window.location.href = '/admin/crm/offers';
                }, 1000);
            } else {
                showToast(result.error || result.message || 'Erreur lors de la suppression', 'error');
            }
        })
        .catch(function() {
            showToast('Erreur réseau', 'error');
        });
    }
    </script>
</body>
</html>
