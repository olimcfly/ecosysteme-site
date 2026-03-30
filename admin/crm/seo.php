<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - SEO Hub
 * Placeholder page - En cours de développement
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

// Vérifier authentification
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: /admin/login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>SEO Hub - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--gray-50); color: var(--gray-900); }
        .container { display: flex; min-height: 100vh; }

        .main {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .coming-soon-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            margin: 2rem auto;
        }

        .coming-soon-card .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .coming-soon-card h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.75rem;
        }

        .coming-soon-card p {
            color: var(--gray-500);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .coming-soon-card a {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            text-decoration: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: opacity 0.2s;
        }

        .coming-soon-card a:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container app-shell">
        <?php $activePage = 'seo'; include __DIR__ . '/../shared/sidebar.php'; ?>

        <main class="main app-content">
            <div class="page-header">
                <h1>SEO Hub</h1>
            </div>

            <div class="coming-soon-card">
                <div class="icon">🔍</div>
                <h2>SEO Hub</h2>
                <p>Cette fonctionnalité est en cours de développement.</p>
                <a href="/admin/crm/index.php">Retour au Dashboard</a>
            </div>
        </main>
    </div>
</body>
</html>
