<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Détail d'une Offre
 * Affichage complet d'une offre avec ses 8 composantes
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/auth/login');
    exit;
}

$offreId = intval($_GET['id'] ?? 0);
if ($offreId <= 0) {
    header('Location: /admin/crm/offres');
    exit;
}

// Créer la table si nécessaire
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS offres (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titre VARCHAR(255) NOT NULL,
            persona TEXT NULL,
            probleme TEXT NULL,
            motivation TEXT NULL,
            promesse TEXT NULL,
            methode TEXT NULL,
            contenu_offre TEXT NULL,
            prix_valeur TEXT NULL,
            preuves TEXT NULL,
            resume_offre TEXT NULL,
            conversation JSON NULL,
            statut ENUM('brouillon', 'validee', 'active', 'archivee') NOT NULL DEFAULT 'brouillon',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_statut (statut),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
} catch (PDOException $e) {
    // Already exists
}

$stmt = $pdo->prepare("SELECT * FROM offres WHERE id = ?");
$stmt->execute([$offreId]);
$offre = $stmt->fetch();

if (!$offre) {
    header('Location: /admin/crm/offres');
    exit;
}

// Stats sidebar
$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads");
$totalLeads = $stmt->fetch()['total'];

try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM offres");
    $totalOffres = $stmt->fetch()['total'];
} catch (PDOException $e) {
    $totalOffres = 0;
}

$statutLabels = [
    'brouillon' => 'Brouillon',
    'validee' => 'Validee',
    'active' => 'Active',
    'archivee' => 'Archivee'
];

$components = [
    ['key' => 'persona', 'icon' => '👤', 'label' => 'Persona (Client ideal)'],
    ['key' => 'probleme', 'icon' => '🔥', 'label' => 'Probleme principal'],
    ['key' => 'motivation', 'icon' => '💎', 'label' => 'Motivation profonde'],
    ['key' => 'promesse', 'icon' => '🎯', 'label' => 'Promesse de resultat'],
    ['key' => 'methode', 'icon' => '⚙️', 'label' => 'Methode / Approche'],
    ['key' => 'contenu_offre', 'icon' => '📦', 'label' => 'Contenu de l\'offre'],
    ['key' => 'prix_valeur', 'icon' => '💰', 'label' => 'Prix et valeur'],
    ['key' => 'preuves', 'icon' => '🔒', 'label' => 'Preuves et reassurance'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= h($offre['titre']) ?> - <?= SITE_NAME ?></title>
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
            --gray-300: #d1d5db;
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

        .container { display: flex; min-height: 100vh; }

        .sidebar {
            width: 220px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-header { padding: 0 1.5rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 2rem; }
        .sidebar-title { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; opacity: 0.8; letter-spacing: 0.5px; }
        .sidebar-section { margin-bottom: 2rem; padding: 0 1rem; }
        .sidebar-section-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; opacity: 0.6; margin-bottom: 0.75rem; padding: 0 0.5rem; letter-spacing: 0.5px; }
        .sidebar-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; margin-bottom: 0.5rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; text-decoration: none; color: rgba(255,255,255,0.8); font-size: 0.9rem; }
        .sidebar-item:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-item.active { background: rgba(255,255,255,0.2); color: white; font-weight: 600; }
        .sidebar-icon { font-size: 1.2rem; width: 1.5rem; }
        .sidebar-badge { margin-left: auto; background: rgba(255,255,255,0.3); padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
        .sidebar-footer { position: absolute; bottom: 0; left: 0; right: 0; padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-card { display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 1rem; }
        .user-avatar { width: 2.5rem; height: 2.5rem; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; }
        .user-info { flex: 1; font-size: 0.85rem; }
        .user-name { font-weight: 600; display: block; }
        .user-email { opacity: 0.7; font-size: 0.75rem; }
        .logout-btn { width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 0.5rem; cursor: pointer; font-size: 0.85rem; font-weight: 500; transition: all 0.2s; text-decoration: none; display: block; text-align: center; }
        .logout-btn:hover { background: rgba(255,255,255,0.3); }

        .main {
            flex: 1;
            margin-left: 220px;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .header-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .header-meta {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--secondary); }
        .btn-success { background: var(--success); color: white; }
        .btn-success:hover { opacity: 0.9; }
        .btn-warning { background: var(--warning); color: white; }
        .btn-warning:hover { opacity: 0.9; }
        .btn-outline { background: white; color: var(--gray-700); border: 1px solid var(--gray-300); }
        .btn-outline:hover { background: var(--gray-50); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { opacity: 0.9; }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-brouillon { background: #fef3c7; color: #92400e; }
        .badge-validee { background: #d1fae5; color: #065f46; }
        .badge-active { background: #dbeafe; color: #1e40af; }
        .badge-archivee { background: #e5e7eb; color: #374151; }

        /* Resume section */
        .resume-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 1rem;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
        }

        .resume-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .resume-content {
            line-height: 1.8;
            opacity: 0.95;
            white-space: pre-wrap;
        }

        /* Components grid */
        .components-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .component-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .component-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .component-icon { font-size: 1.5rem; }

        .component-label {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--gray-800);
        }

        .component-content {
            font-size: 0.9rem;
            line-height: 1.7;
            color: var(--gray-700);
            white-space: pre-wrap;
        }

        .component-empty {
            font-style: italic;
            color: var(--gray-400);
        }

        /* Statut actions */
        .statut-section {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .statut-section-title {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .statut-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: relative; padding: 1rem 0; }
            .main { margin-left: 0; }
            .sidebar-footer { position: relative; }
            .components-grid { grid-template-columns: 1fr; }
            .header { flex-direction: column; gap: 1rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">ECOSYSTEME IMMO LOCAL+</div>
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
                        <span class="sidebar-badge"><?= $totalLeads ?></span>
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
                        <span>Generateur IA</span>
                    </a>
                    <a href="/admin/crm/offres" class="sidebar-item active">
                        <span class="sidebar-icon">📋</span>
                        <span>Mes Offres</span>
                        <span class="sidebar-badge"><?= $totalOffres ?></span>
                    </a>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-section-title">Outils</div>
                    <a href="/admin/emails" class="sidebar-item">
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
                <a href="/admin/auth/logout" class="logout-btn">Deconnexion</a>
            </div>
        </aside>

        <main class="main">
            <div class="header">
                <div>
                    <h1 class="header-title"><?= h($offre['titre']) ?></h1>
                    <div class="header-meta">
                        <span class="badge badge-<?= $offre['statut'] ?>"><?= $statutLabels[$offre['statut']] ?? $offre['statut'] ?></span>
                        &nbsp; Creee le <?= date('d/m/Y a H:i', strtotime($offre['created_at'])) ?>
                        <?php if ($offre['updated_at'] !== $offre['created_at']): ?>
                            &middot; Modifiee le <?= date('d/m/Y', strtotime($offre['updated_at'])) ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="/admin/crm/offres" class="btn btn-outline">Retour aux offres</a>
                    <a href="/admin/crm/offre-generator" class="btn btn-primary">Creer une nouvelle offre</a>
                </div>
            </div>

            <!-- Changer le statut -->
            <div class="statut-section">
                <div class="statut-section-title">Changer le statut</div>
                <div class="statut-actions">
                    <?php if ($offre['statut'] !== 'brouillon'): ?>
                        <button class="btn btn-warning" onclick="updateStatut('brouillon')">Remettre en brouillon</button>
                    <?php endif; ?>
                    <?php if ($offre['statut'] !== 'validee'): ?>
                        <button class="btn btn-success" onclick="updateStatut('validee')">Valider l'offre</button>
                    <?php endif; ?>
                    <?php if ($offre['statut'] !== 'active'): ?>
                        <button class="btn btn-primary" onclick="updateStatut('active')">Activer</button>
                    <?php endif; ?>
                    <?php if ($offre['statut'] !== 'archivee'): ?>
                        <button class="btn btn-outline" onclick="updateStatut('archivee')">Archiver</button>
                    <?php endif; ?>
                    <button class="btn btn-danger" onclick="deleteOffre()">Supprimer</button>
                </div>
            </div>

            <!-- Résumé -->
            <?php if (!empty($offre['resume_offre'])): ?>
            <div class="resume-section">
                <div class="resume-title">Resume de l'offre</div>
                <div class="resume-content"><?= h($offre['resume_offre']) ?></div>
            </div>
            <?php endif; ?>

            <!-- Les 8 composantes -->
            <div class="components-grid">
                <?php foreach ($components as $comp): ?>
                <div class="component-card">
                    <div class="component-header">
                        <span class="component-icon"><?= $comp['icon'] ?></span>
                        <span class="component-label"><?= $comp['label'] ?></span>
                    </div>
                    <div class="component-content">
                        <?php if (!empty($offre[$comp['key']])): ?>
                            <?= h($offre[$comp['key']]) ?>
                        <?php else: ?>
                            <span class="component-empty">Non renseigne</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
    async function updateStatut(newStatut) {
        const labels = { brouillon: 'brouillon', validee: 'validee', active: 'active', archivee: 'archivee' };
        if (!confirm('Passer cette offre en "' + (labels[newStatut] || newStatut) + '" ?')) return;

        try {
            const response = await fetch('/api/api-ai-offre.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ action: 'update_statut', id: <?= $offreId ?>, statut: newStatut })
            });

            const data = await response.json();
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur: ' + (data.error || 'Impossible de mettre a jour.'));
            }
        } catch (error) {
            alert('Erreur de connexion.');
        }
    }

    async function deleteOffre() {
        if (!confirm('Supprimer cette offre ? Cette action est irreversible.')) return;

        try {
            const response = await fetch('/api/api-ai-offre.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({ action: 'delete_offre', id: <?= $offreId ?> })
            });

            const data = await response.json();
            if (data.success) {
                window.location.href = '/admin/crm/offres';
            } else {
                alert('Erreur: ' + (data.error || 'Impossible de supprimer.'));
            }
        } catch (error) {
            alert('Erreur de connexion.');
        }
    }
    </script>
</body>
</html>
