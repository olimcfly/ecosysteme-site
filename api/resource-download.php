<?php
/**
 * resource-download.php - VERSION TEST
 * Enregistre dans un fichier texte, pas de BDD
 */
require_once __DIR__ . '/../includes/helpers.php';

require_once __DIR__ . '/../includes/rate-limiter.php';

// Rate limiting (pas d'auth token car c'est un formulaire public avec redirection)
checkRateLimit();

// Log immédiat
$logFile = '/home/tasq5564/ecosystemeimmo.fr/logs/test-download.log';
@mkdir(dirname($logFile), 0755, true);

file_put_contents($logFile, "\n\n=== NOUVEAU REQUEST ===\n", FILE_APPEND);
file_put_contents($logFile, "Timestamp: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
file_put_contents($logFile, "Méthode: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);
file_put_contents($logFile, "POST data: " . json_encode($_POST) . "\n", FILE_APPEND);

// Vérification méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    file_put_contents($logFile, "❌ ERREUR: Pas une requête POST\n", FILE_APPEND);
    http_response_code(405);
    exit('Méthode non autorisée');
}

file_put_contents($logFile, "✓ POST reçu\n", FILE_APPEND);

// Récupération données
$firstname = isset($_POST['firstname']) ? trim(h($_POST['firstname'])) : '';
$email = isset($_POST['email']) ? trim(strtolower($_POST['email'])) : '';
$city = isset($_POST['city']) ? trim(h($_POST['city'])) : '';
$resource = isset($_POST['resource']) ? trim($_POST['resource']) : '';

file_put_contents($logFile, "Données reçues: firstname=$firstname, email=$email, resource=$resource\n", FILE_APPEND);

// Validation email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    file_put_contents($logFile, "❌ Email invalide: $email\n", FILE_APPEND);
    header('Location: /front/ressources/erreur-telecharge.php?msg=Email%20invalide');
    exit;
}

file_put_contents($logFile, "✓ Email valide\n", FILE_APPEND);

// Validation prénom
if (empty($firstname) || strlen($firstname) < 2) {
    file_put_contents($logFile, "❌ Prénom invalide: $firstname\n", FILE_APPEND);
    header('Location: /front/ressources/erreur-telecharge.php?msg=Pr%C3%A9nom%20requis');
    exit;
}

file_put_contents($logFile, "✓ Prénom valide\n", FILE_APPEND);

// Ressources
$resources = [
    'neuropersona' => '/front/ressources/merci-neuropersona.php',
    'mere' => '/front/ressources/merci-mere.php',
    'seo' => '/front/ressources/merci-seo.php',
    'journal-gmb' => '/front/ressources/merci-gmb.php',
    'audit-visibilite' => '/front/ressources/audit-visibilite.php',
    'estimateur' => '/front/ressources/estimateur.php',
    'calculateur-roi' => '/front/ressources/calculateur-roi.php'
];

if (!isset($resources[$resource])) {
    file_put_contents($logFile, "❌ Ressource inconnue: $resource\n", FILE_APPEND);
    header('Location: /front/ressources/erreur-telecharge.php?msg=Ressource%20inconnue');
    exit;
}

file_put_contents($logFile, "✓ Ressource valide\n", FILE_APPEND);

// Enregistrement en fichier
$now = date('Y-m-d H:i:s');
$entry = "$now | $firstname | $email | $city | $resource\n";
file_put_contents('/home/tasq5564/ecosystemeimmo.fr/logs/leads-test.txt', $entry, FILE_APPEND);

file_put_contents($logFile, "✓ Données enregistrées dans leads-test.txt\n", FILE_APPEND);
file_put_contents($logFile, "✓ Redirection vers: " . $resources[$resource] . "\n", FILE_APPEND);

// REDIRECTION
header('Location: ' . $resources[$resource]);
exit;

?>