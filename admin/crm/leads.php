<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Liste des Leads
 * Page pour gérer et consulter tous les leads
 */

session_start();

require_once __DIR__ . '/../../includes/LeadService.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/login');
    exit;
}

// ============================================
// PAGINATION ET FILTRES via LeadService
// ============================================
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 20;
$search = trim($_GET['search'] ?? '');
$filterIntent = $_GET['intent'] ?? '';
$filterStatus = $_GET['status'] ?? '';

$leadService = new LeadService();
$result = $leadService->getLeads([
    'search' => $search,
    'intent' => $filterIntent,
    'status' => $filterStatus,
], $page, $perPage);

$leads = $result['leads'];
$totalLeads = $result['total'];
$totalPages = $result['totalPages'];
$intents = $result['intents'];
$statuses = $result['statuses'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Tous les Leads - <?= SITE_NAME ?></title>
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
                    <a href="/admin/crm/leads.php" class="sidebar-item active">
                        <span class="sidebar-icon">👥</span>
                        <span>Tous les Leads</span>
                    </a>
                    <a href="/admin/crm/analytics.php" class="sidebar-item">
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
                        <span class="user-name"><?= h($_SESSION['admin_firstname'] ?? 'Admin') ?></span>
                        <span class="user-email"><?= h($_SESSION['admin_email'] ?? '') ?></span>
                    </div>
                </div>
                <a href="//admin/logout" class="logout-btn">Déconnexion</a>
            </div>
        </aside>
        
        <main class="main">
            <div class="header">
                <h1 class="header-title">👥 Tous les Leads</h1>
                <div class="header-breadcrumb">Dashboard > Leads</div>
            </div>
            
            <div class="filters-section">
                <form method="GET" action="/admin/crm/leads.php">
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
                        
                        <div class="form-group">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select">
                                <option value="">-- Tous --</option>
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?= h($status) ?>" 
                                            <?= $filterStatus === $status ? 'selected' : '' ?>>
                                        <?= ucfirst(str_replace('_', ' ', h($status))) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="filters-buttons">
                        <button type="submit" class="btn btn-primary">🔍 Rechercher</button>
                        <a href="/admin/crm/leads.php" class="btn btn-secondary">↻ Réinitialiser</a>
                    </div>
                </form>
            </div>
            
            <div class="table-section">
                <div class="table-header">
                    <div class="table-title">Leads (<?= $totalLeads ?> total)</div>
                    <div class="table-stats">Page <?= $page ?> / <?= max(1, $totalPages) ?></div>
                </div>
                
                <?php if (empty($leads)): ?>
                    <div class="no-results">
                        <div class="no-results-icon">📭</div>
                        <p>Aucun lead trouvé</p>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Intent</th>
                                <th>Statut</th>
                                <th>Score</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leads as $lead): ?>
                            <tr>
                                <td><strong><?= h($lead['firstname'] ?? '') ?> <?= h($lead['lastname'] ?? '') ?></strong></td>
                                <td><?= h($lead['email'] ?? '') ?></td>
                                <td><?= h($lead['phone'] ?? '-') ?></td>
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
                                <td>
                                    <?php
                                    $statusMap = [
                                        'nouveau' => 'badge-nouveau',
                                        'en_reflexion' => 'badge-reflexion',
                                        'actif' => 'badge-actif',
                                        'appel_re' => 'badge-appel',
                                        'client' => 'badge-client',
                                    ];
                                    $statusClass = $statusMap[$lead['status']] ?? 'badge-nouveau';
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= ucfirst(str_replace('_', ' ', h($lead['status'] ?? 'nouveau'))) ?></span>
                                </td>
                                <td><span class="score"><?= intval($lead['score'] ?? 0) ?></span></td>
                                <td><?= date('d/m/Y', strtotime($lead['created_at'])) ?></td>
                                <td>
                                    <a href="/admin/crm/lead-detail.php?id=<?= $lead['id'] ?>" class="action-btn">Voir</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="/admin/crm/leads.php?page=1<?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?>">«</a>
                            <a href="/admin/crm/leads.php?page=<?= $page - 1 ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?>">‹</a>
                        <?php else: ?>
                            <span class="disabled">«</span>
                            <span class="disabled">‹</span>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <?php if ($i === $page): ?>
                                <span class="active"><?= $i ?></span>
                            <?php else: ?>
                                <a href="/admin/crm/leads.php?page=<?= $i ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <a href="/admin/crm/leads.php?page=<?= $page + 1 ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?>">›</a>
                            <a href="/admin/crm/leads.php?page=<?= $totalPages ?><?= $search ? "&search=" . urlencode($search) : "" ?><?= $filterIntent ? "&intent=" . urlencode($filterIntent) : "" ?><?= $filterStatus ? "&status=" . urlencode($filterStatus) : "" ?>">»</a>
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