<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Client Dashboard
 * Vue d'ensemble pour les agents immobiliers
 */

session_start();

require_once __DIR__ . '/../config/database.php';

// Vérifier authentification
if (!isset($_SESSION['client_logged_in'])) {
    header('Location: /client/login');
    exit;
}

$clientId = $_SESSION['client_id'];

// ============================================
// RÉCUPÉRER LES STATISTIQUES
// ============================================
try {
    // Leads du client
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM leads WHERE client_id = ?");
    $stmt->execute([$clientId]);
    $totalLeads = $stmt->fetch()['total'];
    
    // Leads clients
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM leads WHERE client_id = ? AND status = 'client'");
    $stmt->execute([$clientId]);
    $totalClients = $stmt->fetch()['total'];
    
    // Leads à appeler
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM leads WHERE client_id = ? AND status != 'client'");
    $stmt->execute([$clientId]);
    $totalToCalls = $stmt->fetch()['total'];
    
    // Leads par intent
    $stmt = $pdo->prepare("
        SELECT intent, COUNT(*) as count FROM leads WHERE client_id = ? GROUP BY intent
    ");
    $stmt->execute([$clientId]);
    $leadsByIntent = $stmt->fetchAll();
    
    // Leads récents
    $stmt = $pdo->prepare("
        SELECT id, firstname, lastname, email, intent, status, created_at
        FROM leads WHERE client_id = ?
        ORDER BY created_at DESC LIMIT 5
    ");
    $stmt->execute([$clientId]);
    $recentLeads = $stmt->fetchAll();
    
} catch (Exception $e) {
    $totalLeads = 0;
    $totalClients = 0;
    $totalToCalls = 0;
    $leadsByIntent = [];
    $recentLeads = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Mon Espace - ÉCOSYSTÈME IMMO LOCAL+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
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
        
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 2rem;
        }
        
        .sidebar-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }
        
        .sidebar-section {
            margin-bottom: 2rem;
            padding: 0 1rem;
        }
        
        .sidebar-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.6;
            margin-bottom: 0.75rem;
            padding: 0 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
        }
        
        .sidebar-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar-item.active {
            background: rgba(255,255,255,0.2);
            color: white;
            font-weight: 600;
        }
        
        .sidebar-icon {
            font-size: 1.2rem;
            width: 1.5rem;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .user-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }
        
        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }
        
        .user-info {
            flex: 1;
            font-size: 0.85rem;
        }
        
        .user-name {
            font-weight: 600;
            display: block;
        }
        
        .user-email {
            opacity: 0.7;
            font-size: 0.75rem;
        }
        
        .logout-btn {
            width: 100%;
            padding: 0.5rem;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .main {
            flex: 1;
            margin-left: 250px;
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
        
        .header-subtitle {
            font-size: 0.9rem;
            color: var(--gray-600);
        }
        
        .grid-3 {
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
        }
        
        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }
        
        .stat-link {
            font-size: 0.8rem;
            color: var(--primary);
            text-decoration: none;
            margin-top: 0.75rem;
            display: inline-block;
        }
        
        .stat-link:hover {
            text-decoration: underline;
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
        
        .badge-demo {
            background: #f3e8ff;
            color: #581c87;
        }
        
        .badge-diagnostic {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .badge-client {
            background: #d1fae5;
            color: #065f46;
        }
        
        .welcome-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .welcome-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .welcome-subtitle {
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .btn:hover {
            background: var(--secondary);
        }
        
        @media (max-width: 1024px) {
            .sidebar { width: 200px; }
            .main { margin-left: 200px; }
        }
        
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 1rem 0;
            }
            .main { margin-left: 0; padding: 1rem; }
            .sidebar-footer {
                position: relative;
                bottom: auto;
            }
            .grid-3 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">🎯 MON ESPACE</div>
            </div>
            
            <nav class="sidebar-menu">
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Navigation</div>
                    <a href="/client/dashboard" class="sidebar-item active">
                        <span class="sidebar-icon">📊</span>
                        <span>Tableau de Bord</span>
                    </a>
                    <a href="/client/contacts" class="sidebar-item">
                        <span class="sidebar-icon">👥</span>
                        <span>Mes Contacts</span>
                    </a>
                    <a href="/client/messages" class="sidebar-item">
                        <span class="sidebar-icon">📧</span>
                        <span>Messagerie</span>
                    </a>
                    <a href="/client/resources" class="sidebar-item">
                        <span class="sidebar-icon">📚</span>
                        <span>Ressources</span>
                    </a>
                </div>
                
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Compte</div>
                    <a href="/client/settings" class="sidebar-item">
                        <span class="sidebar-icon">⚙️</span>
                        <span>Paramètres</span>
                    </a>
                </div>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-card">
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['client_firstname'] ?? 'A', 0, 1)) ?></div>
                    <div class="user-info">
                        <span class="user-name"><?= h($_SESSION['client_firstname'] ?? 'Agent') ?></span>
                        <span class="user-email"><?= h($_SESSION['client_email'] ?? '') ?></span>
                    </div>
                </div>
                <a href="/client/logout" class="logout-btn">Déconnexion</a>
            </div>
        </aside>
        
        <main class="main">
            <div class="header">
                <h1 class="header-title">Bienvenue, <?= h($_SESSION['client_firstname']) ?> 👋</h1>
                <p class="header-subtitle">Vue d'ensemble de votre activité commerciale</p>
            </div>
            
            <div class="welcome-card">
                <div class="welcome-title">📈 Continuez à développer votre activité</div>
                <p class="welcome-subtitle">
                    Suivez vos leads, gérez vos contacts et convertissez-les en clients avec ÉCOSYSTÈME IMMO LOCAL+
                </p>
            </div>
            
            <!-- STATISTIQUES -->
            <div class="grid-3">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value"><?= $totalLeads ?></div>
                    <div class="stat-label">Leads Total</div>
                    <a href="/client/contacts" class="stat-link">Voir →</a>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🎯</div>
                    <div class="stat-value"><?= $totalClients ?></div>
                    <div class="stat-label">Clients</div>
                    <a href="/client/contacts?filter=client" class="stat-link">Voir →</a>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📞</div>
                    <div class="stat-value"><?= $totalToCalls ?></div>
                    <div class="stat-label">À Relancer</div>
                    <a href="/client/contacts?filter=pending" class="stat-link">Voir →</a>
                </div>
            </div>
            
            <!-- LEADS RÉCENTS -->
            <div class="card">
                <div class="card-title">📬 Leads Récents</div>
                
                <?php if (empty($recentLeads)): ?>
                    <p style="color: var(--gray-500); text-align: center; padding: 2rem;">
                        Aucun lead pour le moment
                    </p>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Intent</th>
                                <th>Statut</th>
                                <th>Ajouté</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentLeads as $lead): ?>
                            <tr>
                                <td><strong><?= h($lead['firstname'] . ' ' . $lead['lastname']) ?></strong></td>
                                <td><?= h($lead['email']) ?></td>
                                <td><span class="badge badge-<?= strtolower($lead['intent'] ?? 'cold') ?>"><?= h($lead['intent'] ?? 'Cold') ?></span></td>
                                <td><?= h($lead['status']) ?></td>
                                <td><?= date('d/m/Y', strtotime($lead['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            
            <!-- INTENTS BREAKDOWN -->
            <?php if (!empty($leadsByIntent)): ?>
            <div class="card">
                <div class="card-title">📊 Distribution par Intent</div>
                
                <table class="table" style="max-width: 400px;">
                    <thead>
                        <tr>
                            <th>Intent</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leadsByIntent as $item): ?>
                        <tr>
                            <td><strong><?= h($item['intent'] ?? 'Cold') ?></strong></td>
                            <td><?= $item['count'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>