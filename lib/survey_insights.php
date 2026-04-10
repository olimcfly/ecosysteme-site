<?php

declare(strict_types=1);

require_once __DIR__ . '/survey_storage.php';

/**
 * @return array{score:int,level:string,tags:array<int,string>,priority:string,status:string}
 */
function survey_compute_analysis(array $submission): array
{
    $answers = is_array($submission['survey_answers'] ?? null) ? $submission['survey_answers'] : [];
    $experience = is_array($answers['experience'] ?? null) ? $answers['experience'] : [];
    $probleme = is_array($answers['probleme'] ?? null) ? $answers['probleme'] : [];
    $projection = is_array($answers['projection'] ?? null) ? $answers['projection'] : [];
    $empechement = is_array($answers['empechement'] ?? null) ? $answers['empechement'] : [];
    $qualification = is_array($answers['qualification'] ?? null) ? $answers['qualification'] : [];

    $mandates = (int) ($experience['mandates_per_month'] ?? 0);
    $sales = (int) ($experience['sales_per_year'] ?? 0);
    $digitalTools = (string) ($experience['digital_tools'] ?? '');
    $clientsSource = mb_strtolower((string) ($experience['clients_source'] ?? ''));

    $targetMandates = (int) ($projection['target_mandates_month'] ?? 0);
    $motivation = (int) ($qualification['motivation_score'] ?? 0);
    $readyToInvest = (string) ($qualification['ready_to_invest'] ?? '');
    $timeline = (string) ($qualification['desired_timeline'] ?? '');

    $obstacleType = (string) ($empechement['main_obstacle_type'] ?? '');
    $obstacleRaw = mb_strtolower((string) ($empechement['current_obstacle'] ?? ''));

    $score = 20;
    $score += min(25, $mandates * 5);
    $score += min(15, (int) floor($sales / 2));

    if ($digitalTools === 'oui_structures') {
        $score += 15;
    } elseif ($digitalTools === 'un_peu') {
        $score += 7;
    }

    $score += min(10, max(0, $motivation));

    if ($readyToInvest === 'oui') {
        $score += 10;
    } elseif ($readyToInvest === 'peut_etre') {
        $score += 4;
    }

    if ($obstacleType === 'mixte') {
        $score -= 8;
    }
    if ($obstacleType === 'confiance') {
        $score -= 5;
    }

    $score = max(0, min(100, $score));

    if ($score >= 70) {
        $level = 'avance';
    } elseif ($score >= 40) {
        $level = 'intermediaire';
    } else {
        $level = 'debutant';
    }

    $tags = [$level];

    if (str_contains($clientsSource, 'bouche') || str_contains($clientsSource, 'recommand')) {
        $tags[] = 'dependance-reseau';
    }
    if ($digitalTools === 'non' || $digitalTools === 'un_peu') {
        $tags[] = 'pas-de-systeme';
    }
    if ($obstacleType === 'visibilite') {
        $tags[] = 'manque-visibilite';
    }
    if ($targetMandates > $mandates + 2) {
        $tags[] = 'besoin-leads';
    }
    if (str_contains($obstacleRaw, 'positionnement') || str_contains($obstacleRaw, 'différenc')) {
        $tags[] = 'besoin-positionnement';
    }
    if (str_contains($obstacleRaw, 'offre') || str_contains($obstacleRaw, 'tarif')) {
        $tags[] = 'besoin-offre';
    }
    if ($obstacleType === 'budget') {
        $tags[] = 'budget-faible';
    }
    if ($motivation >= 8) {
        $tags[] = 'motive-fort';
    }
    if ($timeline === '0_30_jours') {
        $tags[] = 'urgence-elevee';
    }
    if ($obstacleType === 'confiance' || str_contains($obstacleRaw, 'peur')) {
        $tags[] = 'bloque-psychologique';
    }
    if ($obstacleType === 'mixte' || str_contains($obstacleRaw, 'clar')) {
        $tags[] = 'besoin-clarte';
    }

    $priority = 'Structurer un plan de génération de mandats régulier.';

    if (in_array('manque-visibilite', $tags, true)) {
        $priority = 'Renforcer la visibilité locale auprès des vendeurs qualifiés.';
    } elseif (in_array('pas-de-systeme', $tags, true)) {
        $priority = 'Mettre en place un système simple et répétable de prospection + suivi.';
    } elseif (in_array('besoin-positionnement', $tags, true)) {
        $priority = 'Clarifier le positionnement et la promesse commerciale.';
    } elseif ($level === 'avance' && in_array('motive-fort', $tags, true)) {
        $priority = 'Accélérer avec un plan 90 jours orienté performance et scalabilité.';
    }

    return [
        'score' => $score,
        'level' => $level,
        'tags' => array_values(array_unique($tags)),
        'priority' => $priority,
        'status' => (string) ($submission['status'] ?? 'nouveau'),
    ];
}

function survey_enrich_submission(array $submission): array
{
    $analysis = survey_compute_analysis($submission);
    $submission['analysis'] = $analysis;
    if (!isset($submission['status']) || !is_string($submission['status'])) {
        $submission['status'] = 'nouveau';
    }
    return $submission;
}

/**
 * @return array<int, array<string, mixed>>
 */
function survey_get_all_submissions_enriched(): array
{
    $submissions = survey_storage_load_all();
    $updated = false;

    foreach ($submissions as $index => $submission) {
        $enriched = survey_enrich_submission($submission);
        if (($submission['analysis'] ?? null) !== ($enriched['analysis'] ?? null) || !isset($submission['status'])) {
            $updated = true;
        }
        $submissions[$index] = $enriched;
    }

    usort($submissions, static function (array $a, array $b): int {
        return strcmp((string) ($b['created_at'] ?? ''), (string) ($a['created_at'] ?? ''));
    });

    if ($updated) {
        // Persistance best-effort : si la DB est active, les nouvelles soumissions y sont déjà stockées.
        // On conserve ici une synchro JSON uniquement pour les environnements legacy.
        if (!survey_storage_db_available()) {
            crm_save_json(SURVEY_SUBMISSIONS_FILE, $submissions);
        }
    }

    return $submissions;
}

/**
 * @return array{items:array<int,array<string,mixed>>,total:int,pages:int,page:int,per_page:int}
 */
function survey_get_filtered_submissions(array $filters, int $page = 1, int $perPage = 20): array
{
    $submissions = survey_get_all_submissions_enriched();

    $level = trim((string) ($filters['level'] ?? ''));
    $tag = trim((string) ($filters['tag'] ?? ''));
    $status = trim((string) ($filters['status'] ?? ''));
    $dateFrom = trim((string) ($filters['date_from'] ?? ''));
    $dateTo = trim((string) ($filters['date_to'] ?? ''));

    $filtered = array_values(array_filter($submissions, static function (array $submission) use ($level, $tag, $status, $dateFrom, $dateTo): bool {
        $analysis = is_array($submission['analysis'] ?? null) ? $submission['analysis'] : [];
        $createdAt = (string) ($submission['created_at'] ?? '');

        if ($level !== '' && (($analysis['level'] ?? '') !== $level)) {
            return false;
        }
        if ($tag !== '' && !in_array($tag, (array) ($analysis['tags'] ?? []), true)) {
            return false;
        }
        if ($status !== '' && (($submission['status'] ?? '') !== $status)) {
            return false;
        }
        if ($dateFrom !== '' && $createdAt < $dateFrom . 'T00:00:00') {
            return false;
        }
        if ($dateTo !== '' && $createdAt > $dateTo . 'T23:59:59') {
            return false;
        }

        return true;
    }));

    $total = count($filtered);
    $pages = max(1, (int) ceil($total / $perPage));
    $page = max(1, min($page, $pages));

    $offset = ($page - 1) * $perPage;
    $items = array_slice($filtered, $offset, $perPage);

    return [
        'items' => $items,
        'total' => $total,
        'pages' => $pages,
        'page' => $page,
        'per_page' => $perPage,
    ];
}

function survey_find_submission_by_id(string $id): ?array
{
    $submissions = survey_get_all_submissions_enriched();
    foreach ($submissions as $submission) {
        if (($submission['id'] ?? '') === $id) {
            return $submission;
        }
    }
    return null;
}
