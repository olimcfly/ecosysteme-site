<?php
declare(strict_types=1);

// Redirect immediately if not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: formulaire.php');
    exit;
}

// Sanitize helper
function sanitize(string $value): string {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

$nom              = sanitize($_POST['nom'] ?? '');
$prenom           = sanitize($_POST['prenom'] ?? '');
$email            = sanitize($_POST['email'] ?? '');
$telephone        = sanitize($_POST['telephone'] ?? '');
$ville            = sanitize($_POST['ville'] ?? '');
$formule          = sanitize($_POST['formule'] ?? '');
$experience       = sanitize($_POST['experience'] ?? '');
$contacts_vendeurs = sanitize($_POST['contacts_vendeurs'] ?? '');
$objectif         = sanitize($_POST['objectif'] ?? '');

// Validate
$errors = [];
if ($nom === '') { $errors[] = 'Le nom est requis.'; }
if ($prenom === '') { $errors[] = 'Le prénom est requis.'; }
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'L\'adresse email est invalide.';
}
if ($telephone === '') { $errors[] = 'Le téléphone est requis.'; }
if ($ville === '') { $errors[] = 'La ville est requise.'; }

// If errors, redirect back with data
if (!empty($errors)) {
    $old = compact('nom', 'prenom', 'email', 'telephone', 'ville', 'formule', 'experience', 'contacts_vendeurs', 'objectif');
    $query = http_build_query([
        'errors' => json_encode($errors),
        'old'    => json_encode($old),
        'formule' => $formule,
    ]);
    header('Location: formulaire.php?' . $query);
    exit;
}

// Save lead to JSON storage
$lead = [
    'date'              => date('Y-m-d H:i:s'),
    'nom'               => $nom,
    'prenom'            => $prenom,
    'email'             => $email,
    'telephone'         => $telephone,
    'ville'             => $ville,
    'formule'           => $formule,
    'experience'        => $experience,
    'contacts_vendeurs' => $contacts_vendeurs,
    'objectif'          => $objectif,
    'ip'                => $_SERVER['REMOTE_ADDR'] ?? '',
];

$storage_dir  = __DIR__ . '/../storage';
$storage_file = $storage_dir . '/leads.json';

if (!is_dir($storage_dir)) {
    mkdir($storage_dir, 0755, true);
}

$leads = [];
if (file_exists($storage_file)) {
    $contents = file_get_contents($storage_file);
    if ($contents !== false) {
        $decoded = json_decode($contents, true);
        if (is_array($decoded)) {
            $leads = $decoded;
        }
    }
}

$leads[] = $lead;
file_put_contents($storage_file, json_encode($leads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Send notification email
$to      = 'contact@ecosystemeimmo.fr';
$subject = '[Nouveau lead] ' . $prenom . ' ' . $nom . ' — ' . $ville;
$message = implode("\n", [
    'Nouveau lead Écosystème Immo',
    str_repeat('-', 40),
    'Nom       : ' . $prenom . ' ' . $nom,
    'Email     : ' . $email,
    'Téléphone : ' . $telephone,
    'Ville     : ' . $ville,
    'Formule   : ' . ($formule ?: 'Non précisée'),
    'Expérience: ' . ($experience ?: 'Non précisée'),
    'Contacts  : ' . ($contacts_vendeurs ?: 'Non précisé'),
    'Objectif  : ' . ($objectif ?: 'Non précisé'),
    str_repeat('-', 40),
    'Date      : ' . date('d/m/Y H:i'),
]);
$headers = 'From: Écosystème Immo <noreply@ecosystemeimmo.fr>' . "\r\n" .
           'Reply-To: ' . $email . "\r\n" .
           'Content-Type: text/plain; charset=UTF-8';

@mail($to, $subject, $message, $headers);

header('Location: confirmation.php?ville=' . urlencode($ville));
exit;
