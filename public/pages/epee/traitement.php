<?php
require_once '../../config/config.php';
require_once '../../config/functions.php';

// Vérification du token CSRF
if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
    redirectWithError(BASE_URL . 'pages/capture/', "Erreur de sécurité. Veuillez recommencer.");
}

// Récupération et sanitization des données
$ville = sanitizeInput($_POST['ville'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$reponses = [
    'q1' => sanitizeInput($_POST['q1'] ?? ''),
    'q2' => sanitizeInput($_POST['q2'] ?? ''),
    'q3' => sanitizeInput($_POST['q3'] ?? ''),
    'q4' => sanitizeInput($_POST['q4'] ?? ''),
    'q5' => sanitizeInput($_POST['q5'] ?? ''),
    'q6' => sanitizeInput($_POST['q6'] ?? ''),
    'q7' => sanitizeInput($_POST['q7'] ?? '')
];

// Validation des données
if (empty($ville) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectWithError(BASE_URL . 'pages/epee/formulaire.php?ville=' . urlencode($ville), "Veuillez remplir tous les champs correctement.");
}

// Enregistrement en base de données
try {
    $reponsesJson = json_encode($reponses, JSON_UNESCAPED_UNICODE);

    $stmt = $pdo->prepare("
        INSERT INTO leads (nom, email, telephone, ville, reponse_epee, source, ip_address)
        VALUES (:nom, :email, :telephone, :ville, :reponses, 'formulaire_epee', :ip)
    ");

    $stmt->execute([
        ':nom' => '', // Nom non demandé dans ce formulaire
        ':email' => $email,
        ':telephone' => '', // Téléphone non demandé
        ':ville' => $ville,
        ':reponses' => $reponsesJson,
        ':ip' => $_SERVER['REMOTE_ADDR'] ?? ''
    ]);

    $idLead = $pdo->lastInsertId();

    // Redirection vers la page vidéo
    redirectWithSuccess(
        BASE_URL . 'pages/video/video.php?lead_id=' . $idLead,
        "Merci ! Votre analyse est en cours de préparation."
    );

} catch (PDOException $e) {
    error_log("Erreur lors de l'enregistrement du lead : " . $e->getMessage());
    redirectWithError(
        BASE_URL . 'pages/epee/formulaire.php?ville=' . urlencode($ville),
        "Une erreur est survenue. Veuillez réessayer."
    );
}
?>
