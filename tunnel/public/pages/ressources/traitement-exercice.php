<?php
require_once '../../config/config.php';
require_once '../../config/functions.php';

// Vérification du token CSRF
if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
    redirectWithError(BASE_URL . 'pages/ressources/', "Erreur de sécurité. Veuillez recommencer.");
}

// Récupération des données
$ville = sanitizeInput($_POST['ville'] ?? '');
$leadId = isset($_POST['lead_id']) ? (int) $_POST['lead_id'] : 0;
$leadsPerdus = sanitizeInput($_POST['leads_perdus'] ?? '');
$apparait = $_POST['apparait'] ?? [];
$concurrents = $_POST['concurrents'] ?? [];
$concurrentsAutres = $_POST['concurrents_autres'] ?? [];

// Validation des données
if (empty($ville) || empty($leadsPerdus)) {
    redirectWithError(
        BASE_URL . 'pages/ressources/exercice-mots-cles.php?ville=' . urlencode($ville) . '&lead_id=' . $leadId,
        "Veuillez remplir tous les champs."
    );
}

$allowedLeadsPerdus = ['1-5', '5-10', '10-20', '20+'];
if (!in_array($leadsPerdus, $allowedLeadsPerdus, true)) {
    redirectWithError(
        BASE_URL . 'pages/ressources/exercice-mots-cles.php?ville=' . urlencode($ville) . '&lead_id=' . $leadId,
        'Valeur leads_perdus invalide'
    );
}

$allowedApparait = ['oui', 'non', 'parfois'];
foreach ($apparait as $motCleId => $value) {
    if (!ctype_digit((string) $motCleId) || !in_array((string) $value, $allowedApparait, true)) {
        redirectWithError(
            BASE_URL . 'pages/ressources/exercice-mots-cles.php?ville=' . urlencode($ville) . '&lead_id=' . $leadId,
            'Réponse apparait invalide'
        );
    }
}

// Préparation des données pour la base
$concurrentsJson = [];
foreach ($concurrents as $motCleId => $concurrentsList) {
    $concurrentsJson[$motCleId] = $concurrentsList;
    if (isset($concurrentsAutres[$motCleId])) {
        $concurrentsJson[$motCleId][] = sanitizeInput($concurrentsAutres[$motCleId]);
    }
}

$concurrentsJson = json_encode($concurrentsJson, JSON_UNESCAPED_UNICODE);
$apparaitJson = json_encode($apparait, JSON_UNESCAPED_UNICODE);
if ($apparaitJson === false) {
    $apparaitJson = '{}';
}

$firstApparait = $apparait[key($apparait)] ?? 'non';

// Enregistrement en base de données
try {
    $stmt = $pdo->prepare(
        "
        INSERT INTO exercice_mots_cles (id_lead, ville, apparait_premiere_page, concurrents, leads_perdus_estimes)
        VALUES (:id_lead, :ville, :apparait, :concurrents, :leads_perdus)
    "
    );

    $stmt->execute([
        ':id_lead' => $leadId > 0 ? $leadId : null,
        ':ville' => $ville,
        ':apparait' => $firstApparait,
        ':concurrents' => $concurrentsJson,
        ':leads_perdus' => $leadsPerdus,
    ]);

    // Mise à jour du lead
    if ($leadId > 0) {
        $stmt = $pdo->prepare('UPDATE leads SET statut = :statut WHERE id = :lead_id');
        $stmt->execute([
            ':statut' => 'exercice_complet',
            ':lead_id' => $leadId,
        ]);

        // Persiste toutes les réponses apparait en JSON si la colonne existe
        $columnExistsStmt = $pdo->prepare("SHOW COLUMNS FROM leads LIKE 'apparait'");
        $columnExistsStmt->execute();
        $columnExists = $columnExistsStmt->fetch(PDO::FETCH_ASSOC);

        if ($columnExists) {
            $stmt = $pdo->prepare('UPDATE leads SET apparait = :apparait WHERE id = :lead_id');
            $stmt->execute([
                ':apparait' => $apparaitJson,
                ':lead_id' => $leadId,
            ]);
        }
    }

    // Redirection vers la page de résultats
    redirectWithSuccess(
        BASE_URL . 'pages/ressources/resultats-exercice.php?ville=' . urlencode($ville) . '&lead_id=' . $leadId,
        "Merci ! Voici les résultats de votre exercice."
    );
} catch (PDOException $e) {
    error_log('Erreur enregistrement exercice : ' . $e->getMessage());
    redirectWithError(
        BASE_URL . 'pages/ressources/exercice-mots-cles.php?ville=' . urlencode($ville) . '&lead_id=' . $leadId,
        'Une erreur est survenue. Veuillez réessayer.'
    );
}
?>
