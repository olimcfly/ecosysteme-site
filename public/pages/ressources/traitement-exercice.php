<?php
require_once '../../config/config.php';
require_once '../../config/functions.php';

// Vérification du token CSRF
if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
    redirectWithError(BASE_URL . 'pages/ressources/', "Erreur de sécurité. Veuillez recommencer.");
}

// Récupération des données
$ville = sanitizeInput($_POST['ville'] ?? '');
$leadId = isset($_POST['lead_id']) ? (int)$_POST['lead_id'] : 0;
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

// Préparation des données pour la base
$concurrentsJson = [];
foreach ($concurrents as $motCleId => $concurrentsList) {
    $concurrentsJson[$motCleId] = $concurrentsList;
    if (isset($concurrentsAutres[$motCleId])) {
        $concurrentsJson[$motCleId][] = sanitizeInput($concurrentsAutres[$motCleId]);
    }
}
$concurrentsJson = json_encode($concurrentsJson, JSON_UNESCAPED_UNICODE);

// Enregistrement en base de données
try {
    $stmt = $pdo->prepare("
        INSERT INTO exercice_mots_cles (id_lead, ville, apparait_premiere_page, concurrents, leads_perdus_estimes)
        VALUES (:id_lead, :ville, :apparait, :concurrents, :leads_perdus)
    ");

    $stmt->execute([
        ':id_lead' => $leadId > 0 ? $leadId : null,
        ':ville' => $ville,
        ':apparait' => $apparait[key($apparait)] ?? 'non', // Valeur par défaut si aucun mot-clé coché
        ':concurrents' => $concurrentsJson,
        ':leads_perdus' => $leadsPerdus
    ]);

    // Mise à jour du statut du lead
    if ($leadId > 0) {
        $stmt = $pdo->prepare("UPDATE leads SET statut = 'exercice_complet' WHERE id = ?");
        $stmt->execute([$leadId]);
    }

    // Redirection vers la page de résultats
    redirectWithSuccess(
        BASE_URL . 'pages/ressources/resultats-exercice.php?ville=' . urlencode($ville) . '&lead_id=' . $leadId,
        "Merci ! Voici les résultats de votre exercice."
    );

} catch (PDOException $e) {
    error_log("Erreur enregistrement exercice : " . $e->getMessage());
    redirectWithError(
        BASE_URL . 'pages/ressources/exercice-mots-cles.php?ville=' . urlencode($ville) . '&lead_id=' . $leadId,
        "Une erreur est survenue. Veuillez réessayer."
    );
}
?>
