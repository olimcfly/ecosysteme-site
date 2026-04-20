<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../../lib/survey_storage.php';
require_once '../../config/config.php';

function survey_text_contains(string $haystack, array $keywords): bool
{
    $normalized = mb_strtolower($haystack);
    foreach ($keywords as $keyword) {
        if (str_contains($normalized, mb_strtolower($keyword))) {
            return true;
        }
    }
    return false;
}

function survey_detect_profile(array $answers): string
{
    $experience = is_array($answers['experience'] ?? null) ? $answers['experience'] : [];
    $probleme = is_array($answers['probleme'] ?? null) ? $answers['probleme'] : [];
    $projection = is_array($answers['projection'] ?? null) ? $answers['projection'] : [];
    $empechement = is_array($answers['empechement'] ?? null) ? $answers['empechement'] : [];
    $qualification = is_array($answers['qualification'] ?? null) ? $answers['qualification'] : [];

    $networkStatus = (string) ($experience['network_status'] ?? '');
    $clientsSource = (string) ($experience['clients_source'] ?? '');
    $digitalTools = (string) ($experience['digital_tools'] ?? '');
    $acquisitionPreference = (string) ($projection['acquisition_preference'] ?? '');
    $difficulty = (string) ($probleme['current_difficulty'] ?? '');
    $mainObstacleType = (string) ($empechement['main_obstacle_type'] ?? '');
    $readyToInvest = (string) ($qualification['ready_to_invest'] ?? '');
    $motivation = (int) ($qualification['motivation_score'] ?? 0);

    if ($readyToInvest === 'oui' && $motivation >= 8) {
        return 'conseiller prêt à passer un cap';
    }

    if (
        survey_text_contains($networkStatus, ['réseau', 'network'])
        && survey_text_contains($clientsSource, ['bouche', 'recommandation', 'réseau'])
    ) {
        return 'conseiller dépendant du réseau';
    }

    if ($digitalTools === 'non' || $mainObstacleType === 'visibilite') {
        return 'conseiller en manque de visibilité locale';
    }

    if ($digitalTools === 'un_peu') {
        return 'conseiller motivé mais sans système';
    }

    if (
        $acquisitionPreference === 'mixte'
        || survey_text_contains($difficulty, ['organisation', 'structur', 'priorit'])
    ) {
        return 'conseiller déjà actif mais mal structuré';
    }

    return 'conseiller dispersé';
}

function survey_build_summary(array $submission): array
{
    $answers = is_array($submission['survey_answers'] ?? null) ? $submission['survey_answers'] : [];
    $experience = is_array($answers['experience'] ?? null) ? $answers['experience'] : [];
    $projection = is_array($answers['projection'] ?? null) ? $answers['projection'] : [];
    $empechement = is_array($answers['empechement'] ?? null) ? $answers['empechement'] : [];
    $qualification = is_array($answers['qualification'] ?? null) ? $answers['qualification'] : [];

    $mandates = (int) ($experience['mandates_per_month'] ?? 0);
    $targetMandates = (int) ($projection['target_mandates_month'] ?? 0);
    $motivation = (int) ($qualification['motivation_score'] ?? 0);
    $readyToInvest = (string) ($qualification['ready_to_invest'] ?? '');
    $mainObstacleType = (string) ($empechement['main_obstacle_type'] ?? '');
    $profile = survey_detect_profile($answers);

    $gap = max(0, $targetMandates - $mandates);

    if ($mandates >= 5) {
        $currentLevel = 'Niveau avancé : activité déjà en mouvement, avec un potentiel d’optimisation important.';
    } elseif ($mandates >= 2) {
        $currentLevel = 'Niveau intermédiaire : base solide, mais encore trop dépendante de l’effort ponctuel.';
    } else {
        $currentLevel = 'Niveau fondation : priorité à la régularité des mandats et à la structuration du flux entrant.';
    }

    $blockageLabels = [
        'temps' => 'Manque de temps pour exécuter un plan commercial constant',
        'methode' => 'Absence de méthode claire et répétable',
        'visibilite' => 'Visibilité locale insuffisante auprès des bons vendeurs',
        'budget' => 'Frein budgétaire pour tester les bons leviers',
        'confiance' => 'Manque de confiance dans la stratégie actuelle',
        'mixte' => 'Freins multiples qui dispersent les efforts',
    ];

    $mainBlockage = $blockageLabels[$mainObstacleType] ?? 'Manque de cadre stratégique stable';

    $priorityByProfile = [
        'conseiller dépendant du réseau' => 'Diversifier les canaux d’acquisition pour ne plus dépendre uniquement du réseau.',
        'conseiller motivé mais sans système' => 'Mettre en place un système simple de génération et suivi de leads.',
        'conseiller déjà actif mais mal structuré' => 'Prioriser 1 canal principal et une routine hebdomadaire pilotée.',
        'conseiller en manque de visibilité locale' => 'Renforcer la présence locale et la preuve de valeur sur la zone cible.',
        'conseiller dispersé' => 'Réduire la dispersion et construire un plan 90 jours avec KPI.',
        'conseiller prêt à passer un cap' => 'Accélérer avec un plan d’exécution offensif orienté mandats qualifiés.',
    ];

    $priority = $priorityByProfile[$profile] ?? 'Structurer les priorités avant d’augmenter l’intensité commerciale.';

    if ($motivation >= 8 && $readyToInvest === 'oui') {
        $potential = 'Potentiel de progression élevé : tu as l’état d’esprit pour accélérer rapidement.';
    } elseif ($motivation >= 6) {
        $potential = 'Potentiel de progression réel : quelques ajustements stratégiques peuvent créer un vrai effet levier.';
    } else {
        $potential = 'Potentiel progressif : clarifier les priorités et la méthode sera la première victoire.';
    }

    $nextStep = $gap > 0
        ? "Construire un plan d’action sur 30 jours pour combler environ {$gap} mandat(s)/mois."
        : 'Stabiliser ton système actuel et sécuriser la régularité des résultats.';

    return [
        'profile' => $profile,
        'current_level' => $currentLevel,
        'main_blockage' => $mainBlockage,
        'priority' => $priority,
        'potential' => $potential,
        'next_step' => $nextStep,
    ];
}

$submissionId = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
$token = isset($_GET['token']) ? trim((string) $_GET['token']) : '';

if ($submissionId === '' || $token === '') {
    http_response_code(403);
    exit('Accès non autorisé.');
}

$submissions = survey_storage_load_all();
$submission = null;

foreach ($submissions as $item) {
    if (($item['id'] ?? '') !== $submissionId) {
        continue;
    }

    $hash = (string) ($item['access_token_hash'] ?? '');
    if ($hash === '' || !hash_equals($hash, hash('sha256', $token))) {
        http_response_code(403);
        exit('Accès non autorisé.');
    }

    $submission = $item;
    break;
}

if ($submission === null) {
    http_response_code(404);
    exit('Résultat introuvable.');
}

$summary = survey_build_summary($submission);
$firstName = trim((string) ($submission['nom'] ?? ''));
if ($firstName !== '' && str_contains($firstName, ' ')) {
    $firstName = explode(' ', $firstName)[0];
}
$pageTitle = 'Ta synthèse stratégique';

require_once '../../includes/header.php';
?>

<div class="survey-landing survey-results-page">
    <section class="survey-section section">
        <div class="container">
            <div class="survey-card survey-results-header">
                <p class="survey-kicker">Résultat du diagnostic stratégique</p>
                <h1><?= htmlspecialchars($firstName !== '' ? "{$firstName}, voici ta synthèse" : 'Voici ta synthèse', ENT_QUOTES, 'UTF-8') ?></h1>
                <p>
                    Tu viens de compléter ton diagnostic EPPE. Voici une lecture claire de ta situation actuelle
                    et la prochaine étape à activer en priorité.
                </p>
            </div>

            <div class="survey-results-grid">
                <article class="survey-result-card">
                    <h2>Ton profil</h2>
                    <p class="survey-result-card__highlight"><?= htmlspecialchars(ucfirst($summary['profile']), ENT_QUOTES, 'UTF-8') ?></p>
                </article>

                <article class="survey-result-card">
                    <h2>Ton niveau actuel</h2>
                    <p><?= htmlspecialchars($summary['current_level'], ENT_QUOTES, 'UTF-8') ?></p>
                </article>

                <article class="survey-result-card">
                    <h2>Ton blocage principal</h2>
                    <p><?= htmlspecialchars($summary['main_blockage'], ENT_QUOTES, 'UTF-8') ?></p>
                </article>

                <article class="survey-result-card">
                    <h2>Ta priorité stratégique</h2>
                    <p><?= htmlspecialchars($summary['priority'], ENT_QUOTES, 'UTF-8') ?></p>
                </article>

                <article class="survey-result-card">
                    <h2>Ton potentiel de progression</h2>
                    <p><?= htmlspecialchars($summary['potential'], ENT_QUOTES, 'UTF-8') ?></p>
                </article>

                <article class="survey-result-card">
                    <h2>Prochaine étape recommandée</h2>
                    <p><?= htmlspecialchars($summary['next_step'], ENT_QUOTES, 'UTF-8') ?></p>
                </article>
            </div>

            <div class="survey-card survey-results-cta">
                <h2>Et maintenant ?</h2>
                <p>Tu peux recevoir plus de conseils concrets ou découvrir la suite du parcours pour passer à l’action.</p>
                <div class="survey-results-cta__actions">
                    <a class="btn btn-primary" href="<?= BASE_URL ?>pages/ressources/">Recevoir plus de conseils</a>
                    <a class="btn btn-secondary" href="<?= BASE_URL ?>pages/capture/">Découvrir la suite</a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once '../../includes/footer.php'; ?>
