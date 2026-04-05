<?php
require_once '../../config/config.php';
require_once '../../config/functions.php';

// Vérification des paramètres
$leadId = filter_input(INPUT_GET, 'lead_id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$offre = isset($_GET['offre']) ? sanitizeInput($_GET['offre']) : '';

if ($leadId === false || !in_array($offre, ['standard', 'exclusive'], true)) {
    redirectWithError('/pages/capture/', "Paramètres invalides.");
}

try {
    // Récupération des infos du lead
    $stmt = $pdo->prepare("SELECT ville, email FROM leads WHERE id = ?");
    $stmt->execute([$leadId]);
    $lead = $stmt->fetch();
} catch (PDOException $e) {
    error_log("Erreur SQL récupération lead : " . $e->getMessage());
    redirectWithError('/pages/capture/', "Une erreur est survenue. Veuillez réessayer.");
}

if (!$lead) {
    redirectWithError('/pages/capture/', "Lead introuvable.");
}

if (!filter_var($lead['email'], FILTER_VALIDATE_EMAIL) || strlen($lead['ville']) < 2) {
    redirectWithError('/pages/capture/', "Les données du lead sont invalides.");
}

// Traitement selon l'offre choisie
if ($offre === 'standard') {
    // Redirection vers la page de paiement standard
    redirectWithSuccess(
        '/pages/rdv/rdv.php?lead_id=' . $leadId . '&offre=standard',
        "Vous avez choisi l'offre Standard. Prenez rendez-vous pour finaliser."
    );
} elseif ($offre === 'exclusive') {
    // Vérification si la ville est toujours disponible
    if (isVilleReserved($lead['ville'])) {
        redirectWithError(
            '/pages/offre/offre.php?lead_id=' . $leadId,
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
            '/pages/rdv/rdv.php?lead_id=' . $leadId . '&offre=exclusive',
            "Félicitations ! " . htmlspecialchars($lead['ville'], ENT_QUOTES, 'UTF-8') . " est réservée pour vous. Prenez rendez-vous pour finaliser."
        );

    } catch (PDOException $e) {
        error_log("Erreur réservation ville : " . $e->getMessage());
        redirectWithError(
            '/pages/offre/offre.php?lead_id=' . $leadId,
            "Une erreur est survenue. Veuillez réessayer."
        );
    }
}
?>
