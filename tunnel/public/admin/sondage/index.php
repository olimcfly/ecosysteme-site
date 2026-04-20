<?php

declare(strict_types=1);

require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../../../lib/survey_insights.php';

if (!Auth::check()) {
    header('Location: /admin/login.php');
    exit;
}

$page = max(1, (int) ($_GET['page'] ?? 1));
$filters = [
    'level' => (string) ($_GET['level'] ?? ''),
    'tag' => (string) ($_GET['tag'] ?? ''),
    'status' => (string) ($_GET['status'] ?? ''),
    'date_from' => (string) ($_GET['date_from'] ?? ''),
    'date_to' => (string) ($_GET['date_to'] ?? ''),
];

$result = survey_get_filtered_submissions($filters, $page, 20);
$items = $result['items'];

$allSubmissions = survey_get_all_submissions_enriched();
$allTags = [];
foreach ($allSubmissions as $submission) {
    foreach ((array) (($submission['analysis'] ?? [])['tags'] ?? []) as $tag) {
        if (!in_array($tag, $allTags, true)) {
            $allTags[] = $tag;
        }
    }
}
sort($allTags);

$levels = ['debutant', 'intermediaire', 'avance'];
$statuses = ['nouveau', 'analyse', 'traite'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Sondage stratégique</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto p-4 sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Sondage stratégique — Réponses</h1>
                <p class="text-sm text-gray-500">Lecture business des réponses, scores et tags automatiques.</p>
            </div>
            <div class="flex gap-2">
                <a href="/admin/" class="btn btn-ghost">Retour CRM</a>
            </div>
        </div>

        <form method="get" class="bg-white border border-gray-200 rounded-xl p-4 grid gap-3 md:grid-cols-5 mb-4">
            <div>
                <label class="text-xs text-gray-500">Niveau</label>
                <select name="level">
                    <option value="">Tous</option>
                    <?php foreach ($levels as $level): ?>
                        <option value="<?= htmlspecialchars($level, ENT_QUOTES, 'UTF-8') ?>" <?= $filters['level'] === $level ? 'selected' : '' ?>><?= htmlspecialchars($level, ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500">Tag</label>
                <select name="tag">
                    <option value="">Tous</option>
                    <?php foreach ($allTags as $tag): ?>
                        <option value="<?= htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') ?>" <?= $filters['tag'] === $tag ? 'selected' : '' ?>><?= htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500">Statut</label>
                <select name="status">
                    <option value="">Tous</option>
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>" <?= $filters['status'] === $status ? 'selected' : '' ?>><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500">Date min</label>
                <input type="date" name="date_from" value="<?= htmlspecialchars($filters['date_from'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div>
                <label class="text-xs text-gray-500">Date max</label>
                <input type="date" name="date_to" value="<?= htmlspecialchars($filters['date_to'], ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="md:col-span-5 flex gap-2">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a href="/admin/sondage/" class="btn btn-ghost">Réinitialiser</a>
            </div>
        </form>

        <div class="bg-white border border-gray-200 rounded-xl overflow-auto">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nom / Email</th>
                        <th>Statut</th>
                        <th>Niveau</th>
                        <th>Score</th>
                        <th>Tags</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($items === []): ?>
                        <tr><td colspan="7" class="text-center text-gray-500 py-6">Aucune réponse trouvée.</td></tr>
                    <?php endif; ?>

                    <?php foreach ($items as $item): ?>
                        <?php $analysis = (array) ($item['analysis'] ?? []); ?>
                        <tr>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime((string) ($item['created_at'] ?? 'now'))), ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <strong><?= htmlspecialchars((string) ($item['nom'] ?? '—'), ENT_QUOTES, 'UTF-8') ?></strong><br>
                                <span class="small"><?= htmlspecialchars((string) ($item['email'] ?? '—'), ENT_QUOTES, 'UTF-8') ?></span>
                            </td>
                            <td><?= htmlspecialchars((string) ($item['status'] ?? 'nouveau'), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) ($analysis['level'] ?? '—'), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) ($analysis['score'] ?? '0'), ENT_QUOTES, 'UTF-8') ?>/100</td>
                            <td>
                                <?php foreach ((array) ($analysis['tags'] ?? []) as $tag): ?>
                                    <span class="inline-block text-xs bg-blue-50 text-blue-700 border border-blue-200 rounded-full px-2 py-1 mr-1 mb-1"><?= htmlspecialchars((string) $tag, ENT_QUOTES, 'UTF-8') ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td><a class="btn btn-primary" href="/admin/sondage/detail.php?id=<?= urlencode((string) ($item['id'] ?? '')) ?>">Voir détail</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
            <p><?= (int) $result['total'] ?> réponse(s)</p>
            <div class="flex gap-2">
                <?php for ($p = 1; $p <= (int) $result['pages']; $p++): ?>
                    <?php
                    $query = $_GET;
                    $query['page'] = $p;
                    ?>
                    <a href="?<?= htmlspecialchars(http_build_query($query), ENT_QUOTES, 'UTF-8') ?>" class="px-3 py-1 rounded border <?= $p === (int) $result['page'] ? 'bg-blue-600 text-white border-blue-600' : 'bg-white border-gray-300' ?>">
                        <?= $p ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</body>
</html>
