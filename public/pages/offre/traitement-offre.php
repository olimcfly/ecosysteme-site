<?php
require_once '../../config/config.php';
require_once '../../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    redirectWithError(BASE_URL . 'pages/capture/', "Méthode non autorisée.");
}

if (!isset($_POST['csrf_token']) || !verifyCsrfToken((string) $_POST['csrf_token'])) {
    http_response_code(403);
    redirectWithError(BASE_URL . 'pages/capture/', "Token CSRF invalide !");
}

// Vérification des paramètres
$leadId = isset($_POST['lead_id']) ? (int) $_POST['lead_id'] : 0;
$offre = isset($_POST['offre']) ? sanitizeInput((string) $_POST['offre']) : '';

if ($leadId <= 0 || !in_array($offre, ['standard', 'exclusive'])) {
    redirectWithError(BASE_URL . 'pages/capture/', "Paramètres invalides.");
}

// Récupération des infos du lead
$stmt = $pdo->prepare("SELECT ville, email FROM leads WHERE id = ?");
$stmt->execute([$leadId]);
$lead = $stmt->fetch();

if (!$lead) {
    redirectWithError(BASE_URL . 'pages/capture/', "Lead introuvable.");
}

// Traitement selon l'offre choisie
if ($offre === 'standard') {
    // Redirection vers la page de paiement standard
    redirectWithSuccess(
        BASE_URL . 'pages/rdv/rdv.php?lead_id=' . $leadId . '&offre=standard',
        "Vous avez choisi l'offre Standard. Prenez rendez-vous pour finaliser."
    );
} elseif ($offre === 'exclusive') {
    // Vérification si la ville est toujours disponible
    if (isVilleReserved($lead['ville'])) {
        redirectWithError(
            BASE_URL . 'pages/offre/offre.php?lead_id=' . $leadId,
            "Désolé, cette ville a été réservée entre-temps."
        );
    }

    try {
        // Réservation de la ville
        $stmt = $pdo->prepare("
            UPDATE territoires
            SET statut = 'reserve', id_conseiller = NULL, date_reservation = NOW()
            WHERE ville = ?
        ");
        $stmt->execute([$lead['ville']]);

        // Mise à jour du lead
        $stmt = $pdo->prepare("UPDATE leads SET statut = 'offre_exclusive' WHERE id = ?");
        $stmt->execute([$leadId]);

        // Redirection vers la page de RDV
        redirectWithSuccess(
            BASE_URL . 'pages/rdv/rdv.php?lead_id=' . $leadId . '&offre=exclusive',
            "Félicitations ! " . htmlspecialchars((string) $lead['ville'], ENT_QUOTES, "UTF-8") . " est réservée pour vous. Prenez rendez-vous pour finaliser."
        );

    } catch (PDOException $e) {
        error_log("Erreur réservation ville : " . $e->getMessage());
        redirectWithError(
            BASE_URL . 'pages/offre/offre.php?lead_id=' . $leadId,
            "Une erreur est survenue. Veuillez réessayer."
        );
    }
}
?>
