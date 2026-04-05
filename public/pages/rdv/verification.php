<?php
require_once '../../config/config.php';
require_once '../../config/functions.php';

// Vérification si la ville est toujours disponible (pour l'offre exclusive)
$ville = isset($_GET['ville']) ? sanitizeInput($_GET['ville']) : '';

if (!empty($ville)) {
    $villeReservee = isVilleReserved($ville);

    if ($villeReservee) {
        redirectWithError(
            BASE_URL . 'pages/offre/offre.php?ville=' . urlencode($ville),
            "Désolé, cette ville a été réservée entre-temps."
        );
    } else {
        redirectWithSuccess(
            BASE_URL . 'pages/rdv/rdv.php?ville=' . urlencode($ville) . '&offre=exclusive',
            "Ville disponible ! Prenez rendez-vous pour finaliser."
        );
    }
} else {
    redirectWithError(BASE_URL . 'pages/capture/', "Ville non spécifiée.");
}
?>
