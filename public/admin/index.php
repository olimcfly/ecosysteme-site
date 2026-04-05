<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

if (isset($_GET['logout'])) {
    Auth::logout();
    header('Location: /admin/login.php');
    exit;
}

if (!Auth::check()) {
    header('Location: /admin/login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin CRM - Ecosystème Immo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100 admin-shell" data-initial-stats="{}" data-initial-leads="[]">
    <div class="admin-layout">
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <div class="admin-main">
            <?php include __DIR__ . '/partials/header.php'; ?>

            <div id="content" class="mt-6 admin-content">
                <?php include __DIR__ . '/partials/leads.php'; ?>
                <?php include __DIR__ . '/partials/calendar.php'; ?>
                <?php include __DIR__ . '/partials/emails.php'; ?>
                <?php include __DIR__ . '/partials/settings.php'; ?>
            </div>
        </div>
    </div>

    <script src="/admin/js/app.js"></script>
</body>
</html>
