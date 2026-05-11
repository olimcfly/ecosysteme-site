<?php
// traitement-demo.php
// Fichier de traitement du formulaire

// Sécurité basique
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: demo.php');
    exit;
}

$honeypot_demo = trim((string) ($_POST['website'] ?? ''));
if ($honeypot_demo !== '') {
    header('Location: demo.php?error=1');
    exit;
}

// Sanitize
function clean($val) {
    return htmlspecialchars(strip_tags(trim($val)));
}

$prenom      = clean($_POST['prenom']      ?? '');
$nom         = clean($_POST['nom']         ?? '');
$telephone   = clean($_POST['telephone']   ?? '');
$email       = clean($_POST['email']       ?? '');
$reseau      = clean($_POST['reseau']      ?? '');
$objectif    = clean($_POST['objectif']    ?? '');
$departement = clean($_POST['departement'] ?? '');
$ville       = clean($_POST['ville']       ?? '');
$message     = clean($_POST['message']     ?? '');
$rgpd        = isset($_POST['rgpd']);

$errors = [];

// Validation
if (strlen($prenom) < 2)   $errors[] = "Prénom invalide.";
if (strlen($nom) < 2)      $errors[] = "Nom invalide.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide.";
if (!preg_match('/^(\+33|0)[1-9](\s?\d{2}){4}$/', $telephone)) $errors[] = "Téléphone invalide.";
if (empty($reseau))        $errors[] = "Réseau manquant.";
if (empty($objectif))      $errors[] = "Objectif manquant.";
if (empty($departement))   $errors[] = "Département manquant.";
if (strlen($ville) < 2)    $errors[] = "Ville invalide.";
if (!$rgpd)                $errors[] = "Consentement RGPD requis.";

if (!empty($errors)) {
    // En production : retourner erreurs en JSON ou rediriger
    header('Location: demo.php?error=1');
    exit;
}

// Envoi email
$to      = 'contact@ecosystemeimmo.fr';
$subject = "Nouvelle demande démo — $prenom $nom ($ville, $departement)";
$body    = "
Prénom    : $prenom
Nom       : $nom
Email     : $email
Téléphone : $telephone
Réseau    : $reseau
Objectif  : $objectif
Département : $departement
Ville ciblée : $ville
Message   : $message
";

$headers  = "From: contact@ecosystemeimmo.fr\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

mail($to, $subject, $body, $headers);

require_once __DIR__ . '/includes/nocodb.php';
nocodb_sync('demo', [
    'prenom'      => $prenom,
    'nom'         => $nom,
    'email'       => $email,
    'telephone'   => $telephone,
    'reseau'      => $reseau,
    'objectif'    => $objectif,
    'departement' => $departement,
    'ville'       => $ville,
    'message'     => $message,
], "Démo — {$prenom} {$nom} ({$ville})");

require_once __DIR__ . '/includes/leads_api_client.php';
ecosystemeimmo_send_lead_to_api([
    'type_demande' => 'demo',
    'prenom'       => $prenom,
    'nom'          => $nom,
    'email'        => $email,
    'telephone'    => $telephone,
    'ville'        => $ville,
    'source'       => 'demo',
    'besoin'       => $objectif,
    'message'      => trim("Département : {$departement}\nRéseau : {$reseau}\n\n{$message}"),
    'website'      => '',
]);

// Redirection confirmation
header('Location: bienvenue.php?prenom=' . urlencode($prenom));
exit;
