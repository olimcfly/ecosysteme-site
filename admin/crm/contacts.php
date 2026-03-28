<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Gestion des Contacts
 * Page pour importer, gérer et exporter les contacts
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
// TRAITER LES UPLOADS
// ============================================
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!validateCsrfToken()) {
        die('Token de sécurité invalide.');
    }
    $action = $_POST['action'] ?? '';
    
    // =============================================
    // IMPORTER CSV
    // =============================================
    if ($action === 'import_csv' && isset($_FILES['csv_file'])) {
        $file = $_FILES['csv_file'];
        
        // Vérifier le fichier
        if ($file['error'] === UPLOAD_ERR_OK && $file['size'] > 0) {
            $filename = $file['tmp_name'];
            $csvData = array_map('str_getcsv', file($filename));
            $headers = array_shift($csvData);
            
            // Mapper les colonnes
            $columnMap = [
                'firstname' => 'firstname',
                'prenom' => 'firstname',
                'lastname' => 'lastname',
                'nom' => 'lastname',
                'email' => 'email',
                'phone' => 'phone',
                'telephone' => 'phone',
                'city' => 'city',
                'ville' => 'city',
                'intent' => 'intent',
                'status' => 'status',
                'message' => 'message',
                'notes' => 'notes',
            ];
            
            $insertedCount = 0;
            $skippedCount = 0;
            
            foreach ($csvData as $row) {
                if (empty($row[0])) continue;
                
                $data = [];
                foreach ($headers as $i => $header) {
                    $header = strtolower(trim($header));
                    $mappedHeader = $columnMap[$header] ?? $header;
                    $data[$mappedHeader] = trim($row[$i] ?? '');
                }
                
                // Vérifier si le lead existe déjà (email unique)
                if (!empty($data['email'])) {
                    $stmt = $pdo->prepare("SELECT id FROM leads WHERE email = ?");
                    $stmt->execute([$data['email']]);
                    
                    if ($stmt->fetch()) {
                        $skippedCount++;
                        continue;
                    }
                }
                
                // Insérer le lead
                $stmt = $pdo->prepare("
                    INSERT INTO leads (firstname, lastname, email, phone, city, intent, status, message, notes, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                ");
                
                if ($stmt->execute([
                    $data['firstname'] ?? '',
                    $data['lastname'] ?? '',
                    $data['email'] ?? '',
                    $data['phone'] ?? '',
                    $data['city'] ?? '',
                    $data['intent'] ?? 'cold',
                    $data['status'] ?? 'nouveau',
                    $data['message'] ?? '',
                    $data['notes'] ?? '',
                ])) {
                    $insertedCount++;
                }
            }
            
            $message = "✅ Import terminé : {$insertedCount} ajoutés, {$skippedCount} ignorés (doublons)";
            $messageType = 'success';
        } else {
            $message = '❌ Erreur lors du téléchargement du fichier';
            $messageType = 'error';
        }
    }
    
    // =============================================
    // EXPORTER CSV
    // =============================================
    if ($action === 'export_csv') {
        $stmt = $pdo->query("
            SELECT id, firstname, lastname, email, phone, city, intent, status, score, created_at
            FROM leads
            ORDER BY created_at DESC
        ");
        
        $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Créer le CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=leads_' . date('Y-m-d_H-i-s') . '.csv');
        
        $output = fopen('php://output', 'w');
        
        // En-têtes
        fputcsv($output, ['ID', 'Prénom', 'Nom', 'Email', 'Téléphone', 'Ville', 'Intent', 'Statut', 'Score', 'Date'], ';');
        
        // Données
        foreach ($leads as $lead) {
            fputcsv($output, [
                $lead['id'],
                $lead['firstname'],
                $lead['lastname'],
                $lead['email'],
                $lead['phone'],
                $lead['city'],
                $lead['intent'],
                $lead['status'],
                $lead['score'],
                $lead['created_at'],
            ], ';');
        }
        
        fclose($output);
        exit;
    }
}

// ============================================
// RÉCUPÉRER LES DOUBLONS POTENTIELS
// ============================================
$stmt = $pdo->query("
    SELECT 
        email,
        COUNT(*) as count,
        GROUP_CONCAT(id) as ids,
        GROUP_CONCAT(CONCAT(firstname, ' ', lastname)) as names
    FROM leads
    WHERE email IS NOT NULL AND email != ''
    GROUP BY email
    HAVING count > 1
    LIMIT 20
");
$duplicates = $stmt->fetchAll();

// ============================================
// STATISTIQUES
// ============================================
$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads");
$totalLeads = $stmt->fetch()['total'];

$stmt = $pdo->query("
    SELECT COUNT(*) as total FROM leads 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
")->fetch()['total'];
$leadsToday = $stmt;

$stmt = $pdo->query("
    SELECT COUNT(*) as total FROM leads 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
")->fetch()['total'];
$leadsWeek = $stmt;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Gestion des Contacts - <?= SITE_NAME ?></title>
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
        
        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
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
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-800);
        }
        
        .btn-secondary:hover {
            background: var(--gray-300);
        }
        
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
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
            background: var(--danger);
            color: white;
        }
        
        .help-text {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-top: 0.5rem;
        }
        
        .info-box {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #92400e;
        }
        
        .no-results {
            text-align: center;
            padding: 2rem;
            color: var(--gray-500);
        }
        
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .main { padding: 1rem; }
            .grid-3 {
                grid-template-columns: 1fr;
            }
            .btn-group {
                flex-direction: column;
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
                    <a href="/admin/crm" class="sidebar-item">
                        <span class="sidebar-icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="/admin/crm/leads" class="sidebar-item">
                        <span class="sidebar-icon">👥</span>
                        <span>Tous les Leads</span>
                    </a>
                    <a href="/admin/crm/analytics.php" class="sidebar-item">
                        <span class="sidebar-icon">📈</span>
                        <span>Analytics</span>
                    </a>
                    <a href="/admin/crm/calls" class="sidebar-item">
                        <span class="sidebar-icon">☎️</span>
                        <span>À Appeler</span>
                    </a>
                    <a href="/admin/crm/analytics.php" class="sidebar-item">
                        <span class="sidebar-icon">📈</span>
                        <span>Analytics</span>
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
                    <a href="/admin/crm/contacts" class="sidebar-item active">
                        <span class="sidebar-icon">📇</span>
                        <span>Contacts</span>
                    </a>
                    <a href="/admin/emails" class="sidebar-item">
                        <span class="sidebar-icon">📧</span>
                        <span>Messages</span>
                    </a>
                    <a href="/admin/crm/settings" class="sidebar-item">
                        <span class="sidebar-icon">⚙️</span>
                        <span>Paramètres</span>
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
                <a href="/admin/auth/logout" class="logout-btn">Déconnexion</a>
            </div>
        </aside>
        
        <main class="main">
            <div class="header">
                <h1 class="header-title">📇 Gestion des Contacts</h1>
                <div class="header-breadcrumb">Dashboard > Contacts</div>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>
            
            <!-- ============================================
                 STATISTIQUES
                 ============================================ -->
            <div class="grid-3">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value"><?= $totalLeads ?></div>
                    <div class="stat-label">Total Contacts</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-value"><?= $leadsToday ?></div>
                    <div class="stat-label">Aujourd'hui</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📈</div>
                    <div class="stat-value"><?= $leadsWeek ?></div>
                    <div class="stat-label">Cette semaine</div>
                </div>
            </div>
            
            <!-- ============================================
                 IMPORT CSV
                 ============================================ -->
            <div class="card">
                <div class="card-title">📥 Importer des Contacts (CSV)</div>
                
                <div class="info-box">
                    📋 Format attendu : CSV avec colonnes firstname, lastname, email, phone, city, intent, status (optionnel)<br>
                    Colonnes acceptées : prenom/firstname, nom/lastname, telephone/phone, ville/city
                </div>
                
                <form method="POST" enctype="multipart/form-data">
                    <?= csrfField() ?>
                    <div class="form-group">
                        <label class="form-label">Fichier CSV</label>
                        <input type="file" name="csv_file" class="form-input" accept=".csv" required>
                        <div class="help-text">Téléchargez un fichier CSV avec vos contacts</div>
                    </div>
                    
                    <input type="hidden" name="action" value="import_csv">
                    <button type="submit" class="btn btn-primary">📥 Importer</button>
                </form>
            </div>
            
            <!-- ============================================
                 EXPORT CSV
                 ============================================ -->
            <div class="card">
                <div class="card-title">📤 Exporter les Contacts</div>
                
                <div class="info-box">
                    💾 Téléchargez tous vos contacts au format CSV (séparateur ;)
                </div>
                
                <form method="POST">
                    <?= csrfField() ?>
                    <input type="hidden" name="action" value="export_csv">
                    <button type="submit" class="btn btn-success">📤 Télécharger CSV</button>
                </form>
            </div>
            
            <!-- ============================================
                 DOUBLONS
                 ============================================ -->
            <div class="card">
                <div class="card-title">🔍 Doublons Détectés</div>
                
                <?php if (empty($duplicates)): ?>
                    <div class="no-results">
                        ✅ Aucun doublon trouvé
                    </div>
                <?php else: ?>
                    <div class="info-box">
                        ⚠️ <?= count($duplicates) ?> email(s) en doublon détecté(s)
                    </div>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Contacts</th>
                                <th>Count</th>
                                <th>Noms</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($duplicates as $dup): ?>
                            <tr>
                                <td>
                                    <strong><?= h($dup['email']) ?></strong>
                                </td>
                                <td>
                                    <?php 
                                    $ids = explode(',', $dup['ids']);
                                    foreach ($ids as $id): ?>
                                        <a href="/admin/crm/lead-detail?id=<?= $id ?>" class="btn btn-secondary" style="display: inline-block; text-decoration: none; font-size: 0.75rem; padding: 0.3rem 0.6rem; margin-right: 0.25rem;">
                                            #<?= $id ?>
                                        </a>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <span class="badge"><?= $dup['count'] ?></span>
                                </td>
                                <td><?= h($dup['names']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            
            <!-- ============================================
                 FORMAT EXEMPLE
                 ============================================ -->
            <div class="card">
                <div class="card-title">📋 Format d'Import Exemple</div>
                
                <p style="margin-bottom: 1rem; font-size: 0.9rem; color: var(--gray-500);">
                    Voici un exemple de format CSV accepté. Vous pouvez utiliser les variantes listées entre parenthèses.
                </p>
                
                <pre style="background: var(--gray-50); padding: 1rem; border-radius: 0.5rem; overflow-x: auto; font-size: 0.85rem;">
firstname (ou prenom);lastname (ou nom);email;phone (ou telephone);city (ou ville);intent;status;message
John;Doe;john@example.com;+33612345678;Paris;diagnostic;nouveau;Intéressé par diagnostic
Jane;Smith;jane@example.com;+33687654321;Lyon;demo;nouveau;Veut voir une démo
Pierre;Martin;pierre@example.com;+33698765432;Marseille;ressource;en_reflexion;A téléchargé ressource
                </pre>
            </div>
        </main>
    </div>
</body>
</html>