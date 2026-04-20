<?php

declare(strict_types=1);

require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../../../lib/survey_insights.php';

if (!Auth::check()) {
    header('Location: /admin/login.php');
    exit;
}

$id = trim((string) ($_GET['id'] ?? ''));
if ($id === '') {
    http_response_code(404);
    exit('Réponse introuvable.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStatus = trim((string) ($_POST['status'] ?? 'nouveau'));
    $allowed = ['nouveau', 'analyse', 'traite'];
    if (in_array($newStatus, $allowed, true)) {
        survey_storage_update_status($id, $newStatus);
    }
    header('Location: /admin/sondage/detail.php?id=' . urlencode($id));
    exit;
}

$submission = survey_find_submission_by_id($id);
if ($submission === null) {
    http_response_code(404);
    exit('Réponse introuvable.');
}

$analysis = (array) ($submission['analysis'] ?? []);
$answers = (array) ($submission['survey_answers'] ?? []);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail réponse sondage</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-5xl mx-auto p-4 sm:p-6">
        <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
            <div>
                <h1 class="text-2xl font-bold">Fiche réponse — Sondage stratégique</h1>
                <p class="text-sm text-gray-500">Soumis le <?= htmlspecialchars(date('d/m/Y H:i', strtotime((string) ($submission['created_at'] ?? 'now'))), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <a href="/admin/sondage/" class="btn btn-ghost">← Retour à la liste</a>
        </div>

        <div class="grid gap-4 md:grid-cols-3 mb-4">
            <div class="panel-card">
                <h2 class="text-sm text-gray-500">Nom</h2>
                <p class="text-lg font-semibold"><?= htmlspecialchars((string) ($submission['nom'] ?? '—'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div class="panel-card">
                <h2 class="text-sm text-gray-500">Email</h2>
                <p class="text-lg font-semibold"><?= htmlspecialchars((string) ($submission['email'] ?? '—'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div class="panel-card">
                <h2 class="text-sm text-gray-500">Statut</h2>
                <form method="post" class="mt-2 flex gap-2 items-center">
                    <select name="status">
                        <?php foreach (['nouveau', 'analyse', 'traite'] as $status): ?>
                            <option value="<?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>" <?= (($submission['status'] ?? 'nouveau') === $status) ? 'selected' : '' ?>><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>

        <div class="panel-card mb-4">
            <h2 class="text-lg font-semibold mb-2">Synthèse automatique</h2>
            <div class="grid gap-3 md:grid-cols-2">
                <p><strong>Niveau :</strong> <?= htmlspecialchars((string) ($analysis['level'] ?? '—'), ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Score :</strong> <?= htmlspecialchars((string) ($analysis['score'] ?? '0'), ENT_QUOTES, 'UTF-8') ?>/100</p>
                <p class="md:col-span-2"><strong>Priorité stratégique :</strong> <?= htmlspecialchars((string) ($analysis['priority'] ?? '—'), ENT_QUOTES, 'UTF-8') ?></p>
                <p class="md:col-span-2"><strong>Tags :</strong>
                    <?php foreach ((array) ($analysis['tags'] ?? []) as $tag): ?>
                        <span class="inline-block text-xs bg-blue-50 text-blue-700 border border-blue-200 rounded-full px-2 py-1 mr-1 mb-1"><?= htmlspecialchars((string) $tag, ENT_QUOTES, 'UTF-8') ?></span>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>

        <div class="panel-card">
            <h2 class="text-lg font-semibold mb-3">Réponses complètes</h2>
            <?php foreach ($answers as $sectionName => $sectionValues): ?>
                <div class="mb-5">
                    <h3 class="font-semibold text-base mb-2 uppercase text-gray-700"><?= htmlspecialchars((string) $sectionName, ENT_QUOTES, 'UTF-8') ?></h3>
                    <div class="grid gap-2">
                        <?php foreach ((array) $sectionValues as $key => $value): ?>
                            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                                <p class="text-xs text-gray-500 mb-1"><?= htmlspecialchars((string) $key, ENT_QUOTES, 'UTF-8') ?></p>
                                <p class="text-sm text-gray-800 whitespace-pre-line"><?= htmlspecialchars(is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
