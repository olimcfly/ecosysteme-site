<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Leads à Appeler
 * Page pour gérer les leads à relancer / appeler
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

// ============================================
// PAGINATION ET FILTRES
// ============================================
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$search = trim($_GET['search'] ?? '');
$filterIntent = $_GET['intent'] ?? '';

// ============================================
// TRAITER LES ACTIONS RAPIDES
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        die('Token de sécurité invalide.');
    }
    $leadId = intval($_POST['lead_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    
    if ($leadId && $action) {
        if ($action === 'mark_called') {
            $stmt = $pdo->prepare("
                UPDATE leads 
                SET status = 'appel_re', call_completed_at = NOW(), updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$leadId]);
        } elseif ($action === 'mark_client') {
            $stmt = $pdo->prepare("
                UPDATE leads 
                SET status = 'client', updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$leadId]);
        } elseif ($action === 'schedule_call') {
            $stmt = $pdo->prepare("
                UPDATE leads 
                SET call_booked_at = NOW(), status = 'actif', updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$leadId]);
        }
    }
}

// ============================================
// CONSTRUIRE LA REQUÊTE
// ============================================
$where = ["(status != 'client' OR status IS NULL)"];
$params = [];

// Recherche
if ($search) {
    $where[] = "(firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)";
    $searchTerm = "%{$search}%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

// Filtre intent
if ($filterIntent) {
    $where[] = "intent = ?";
    $params[] = $filterIntent;
}

$whereClause = implode(" AND ", $where);

// ============================================
// RÉCUPÉRER LES DONNÉES
// ============================================

// Total des leads
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM leads WHERE {$whereClause}");
$stmt->execute($params);
$totalLeads = $stmt->fetch()['total'];
$totalPages = ceil($totalLeads / $perPage);

// Liste des leads
$sql = "
    SELECT 
        id, 
        firstname, 
        lastname, 
        email, 
        phone, 
        intent, 
        status, 
        score, 
        call_booked_at,
        call_completed_at,
        created_at 
    FROM leads 
    WHERE {$whereClause}
    ORDER BY score DESC, created_at DESC
    LIMIT ? OFFSET ?
";

$stmt = $pdo->prepare($sql);

foreach ($params as $key => $value) {
    $stmt->bindValue($key + 1, $value);
}
$stmt->bindValue(count($params) + 1, $perPage, PDO::PARAM_INT);
$stmt->bindValue(count($params) + 2, $offset, PDO::PARAM_INT);

$stmt->execute();
$leads = $stmt->fetchAll();

// Options uniques pour les filtres
$stmt = $pdo->query("SELECT DISTINCT intent FROM leads WHERE intent IS NOT NULL AND status != 'client' ORDER BY intent");
$intents = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Leads à Appeler - <?= SITE_NAME ?></title>
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
        }
        
        .btn-secondary:hover {
            background: var(--gray-300);
        }
        
        .btn-small {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
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
        
        .badge-cold { background: #fcd34d; color: #78350f; }
        .badge-ressource { background: #86efac; color: #166534; }
        .badge-outil { background: #a7f3d0; color: #065f46; }
        .badge-diagnostic { background: #fca5a5; color: #7f1d1d; }
        .badge-demo { background: #c7d2fe; color: #3730a3; }
        
        .badge-nouveau { background: #93c5fd; color: #1e3a8a; }
        .badge-reflexion { background: #fbcfe8; color: #831843; }
        .badge-actif { background: #c7d2fe; color: #3730a3; }
        .badge-appel { background: #fecaca; color: #7f1d1d; }
        .badge-client { background: #a7f3d0; color: #065f46; }
        
        .score {
            font-weight: 600;
            color: var(--primary);
        }
        
        .actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 0.35rem 0.7rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0.35rem;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
            white-space: nowrap;
        }
        
        .action-btn:hover {
            background: var(--secondary);
        }
        
        .action-btn-success {
            background: var(--success);
        }
        
        .action-btn-success:hover {
            background: #059669;
        }
        
        .action-btn-small {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
        }
        
        .priority-high {
            border-left: 4px solid var(--danger);
        }
        
        .priority-medium {
            border-left: 4px solid var(--warning);
        }
        
        .priority-low {
            border-left: 4px solid var(--gray-200);
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
        
        .no-results {
            text-align: center;
            padding: 3rem;
            color: var(--gray-500);
        }
        
        .no-results-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .filters-row {
                grid-template-columns: 1fr;
            }
            .filters-buttons {
                flex-direction: column;
            }
            .actions {
                flex-direction: column;
            }
            .table {
                font-size: 0.85rem;
            }
            .table th, .table td {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'calls'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <main class="main app-content">
            <div class="header">
                <h1 class="header-title">☎️ Leads à Appeler</h1>
                <div class="header-breadcrumb">Dashboard > À Appeler</div>
            </div>
            
            <!-- Filters -->
            <div class="filters-section">
                <form method="GET" action="/admin/crm/calls">
                    <div class="filters-row">
                        <div class="form-group">
                            <label class="form-label">Recherche</label>
                            <input type="text" name="search" class="form-input" 
                                   placeholder="Nom, email..." value="<?= h($search) ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Intent</label>
                            <select name="intent" class="form-select">
                                <option value="">-- Tous --</option>
                                <?php foreach ($intents as $intent): ?>
                                    <option value="<?= h($intent) ?>" 
                                            <?= $filterIntent === $intent ? 'selected' : '' ?>>
                                        <?= ucfirst(h($intent)) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="filters-buttons">
                        <button type="submit" class="btn btn-primary">🔍 Rechercher</button>
                        <a href="/admin/crm/calls" class="btn btn-secondary">↻ Réinitialiser</a>
                    </div>
                </form>
            </div>
            
            <!-- Table -->
            <div class="table-section">
                <div class="table-header">
                    <div class="table-title">Leads à appeler (<?= $totalLeads ?> total)</div>
                    <div class="table-stats">Page <?= $page ?> / <?= max(1, $totalPages) ?></div>
                </div>
                
                <?php if (empty($leads)): ?>
                    <div class="no-results">
                        <div class="no-results-icon">🎉</div>
                        <p>Aucun lead à appeler ! Bravo !</p>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Contact</th>
                                <th>Intent</th>
                                <th>Score</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leads as $lead): 
                                // Déterminer la priorité basée sur le score
                                $priority = 'priority-low';
                                if ($lead['score'] >= 50) $priority = 'priority-high';
                                elseif ($lead['score'] >= 20) $priority = 'priority-medium';
                            ?>
                            <tr class="<?= $priority ?>">
                                <td>
                                    <strong><?= h($lead['firstname'] ?? '') ?> <?= h($lead['lastname'] ?? '') ?></strong>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        <a href="mailto:<?= h($lead['email']) ?>" style="color: var(--primary); text-decoration: none;">
                                            📧 <?= h($lead['email']) ?>
                                        </a><br>
                                        <?php if ($lead['phone']): ?>
                                            <a href="tel:<?= h($lead['phone']) ?>" style="color: var(--primary); text-decoration: none;">
                                                ☎️ <?= h($lead['phone']) ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $intentMap = [
                                        'cold' => 'badge-cold',
                                        'ressource' => 'badge-ressource',
                                        'outil' => 'badge-outil',
                                        'diagnostic' => 'badge-diagnostic',
                                        'demo' => 'badge-demo',
                                    ];
                                    $intentClass = $intentMap[$lead['intent']] ?? 'badge-cold';
                                    ?>
                                    <span class="badge <?= $intentClass ?>"><?= ucfirst(h($lead['intent'] ?? 'cold')) ?></span>
                                </td>
                                <td><span class="score"><?= intval($lead['score'] ?? 0) ?></span></td>
                                <td>
                                    <?php
                                    $statusMap = [
                                        'nouveau' => 'badge-nouveau',
                                        'en_reflexion' => 'badge-reflexion',
                                        'actif' => 'badge-actif',
                                        'appel_re' => 'badge-appel',
                                    ];
                                    $statusClass = $statusMap[$lead['status']] ?? 'badge-nouveau';
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= ucfirst(str_replace('_', ' ', h($lead['status'] ?? 'nouveau'))) ?></span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <form method="POST" style="display: inline;">
                                            <?= csrfField() ?>
                                            <input type="hidden" name="lead_id" value="<?= $lead['id'] ?>">
                                            <input type="hidden" name="action" value="mark_called">
                                            <button type="submit" class="action-btn" title="Marquer comme appelé">📞 Appelé</button>
                                        </form>
                                        <form method="POST" style="display: inline;">
                                            <?= csrfField() ?>
                                            <input type="hidden" name="lead_id" value="<?= $lead['id'] ?>">
                                            <input type="hidden" name="action" value="mark_client">
                                            <button type="submit" class="action-btn action-btn-success" title="Convertir en client">✅ Client</button>
                                        </form>
                                        <a href="/admin/crm/lead-detail?id=<?= $lead['id'] ?>" class="action-btn" style="text-decoration: none; text-align: center; display: inline-block;">📝 Détail</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="/admin/crm/calls?page=1<?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?>">«</a>
                            <a href="/admin/crm/calls?page=<?= $page - 1 ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?>">‹</a>
                        <?php else: ?>
                            <span class="disabled">«</span>
                            <span class="disabled">‹</span>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <?php if ($i === $page): ?>
                                <span class="active"><?= $i ?></span>
                            <?php else: ?>
                                <a href="/admin/crm/calls?page=<?= $i ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <a href="/admin/crm/calls?page=<?= $page + 1 ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?>">›</a>
                            <a href="/admin/crm/calls?page=<?= $totalPages ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?>">»</a>
                        <?php else: ?>
                            <span class="disabled">›</span>
                            <span class="disabled">»</span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>