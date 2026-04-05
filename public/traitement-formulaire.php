<?php

declare(strict_types=1);

session_start();

const LOCAL_LEADS_FILE = __DIR__ . '/../storage/local_leads.json';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /formulaire.php');
    exit;
}

$csrfToken = (string) ($_POST['csrf_token'] ?? '');
$sessionCsrfToken = (string) ($_SESSION['csrf_token'] ?? '');

if ($csrfToken === '' || $sessionCsrfToken === '' || !hash_equals($sessionCsrfToken, $csrfToken)) {
    header('Location: /formulaire.php?errors=' . urlencode(json_encode(['Session expirée, merci de renvoyer le formulaire.'])));
    exit;
}

$lead = [
    'nom' => trim((string) ($_POST['nom'] ?? '')),
    'prenom' => trim((string) ($_POST['prenom'] ?? '')),
    'email' => trim((string) ($_POST['email'] ?? '')),
    'telephone' => trim((string) ($_POST['telephone'] ?? '')),
    'zone' => trim((string) ($_POST['zone'] ?? '')),
    'experience' => trim((string) ($_POST['experience'] ?? '')),
    'contacts_vendeurs' => trim((string) ($_POST['contacts_vendeurs'] ?? '')),
    'objectif' => trim((string) ($_POST['objectif'] ?? '')),
    'investissement' => trim((string) ($_POST['investissement'] ?? '')),
];

$errors = [];
if ($lead['nom'] === '') {
    $errors[] = 'Le nom est requis.';
}
if ($lead['prenom'] === '') {
    $errors[] = 'Le prénom est requis.';
}
if (!filter_var($lead['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'L\'email est invalide.';
}
if ($lead['telephone'] === '') {
    $errors[] = 'Le téléphone est requis.';
}
if ($lead['zone'] === '') {
    $errors[] = 'La zone est requise.';
}
if ($lead['experience'] === '') {
    $errors[] = 'L\'expérience est requise.';
}
if ($lead['contacts_vendeurs'] === '') {
    $errors[] = 'Merci d\'indiquer si vous recevez des contacts vendeurs.';
}
if ($lead['objectif'] === '') {
    $errors[] = 'L\'objectif est requis.';
}
if ($lead['investissement'] === '') {
    $errors[] = 'Merci de renseigner votre niveau d\'investissement.';
}

if ($errors !== []) {
    $query = http_build_query([
        'errors' => json_encode($errors, JSON_UNESCAPED_UNICODE),
        'old' => json_encode($lead, JSON_UNESCAPED_UNICODE),
    ]);
    header('Location: /formulaire.php?' . $query);
    exit;
}

$storageDir = dirname(LOCAL_LEADS_FILE);
if (!is_dir($storageDir)) {
    mkdir($storageDir, 0755, true);
}

$existingLeads = [];
if (file_exists(LOCAL_LEADS_FILE)) {
    $raw = file_get_contents(LOCAL_LEADS_FILE);
    if (is_string($raw) && $raw !== '') {
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $existingLeads = $decoded;
        }
    }
}

$lead['id'] = 'local_' . bin2hex(random_bytes(6));
$lead['source'] = 'formulaire';
$lead['created_at'] = gmdate('c');
$existingLeads[] = $lead;

file_put_contents(
    LOCAL_LEADS_FILE,
    json_encode($existingLeads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

$_SESSION['prenom'] = $lead['prenom'];
$_SESSION['email'] = $lead['email'];
$_SESSION['ville'] = $lead['zone'];
$_SESSION['telephone'] = $lead['telephone'];
$_SESSION['source'] = $lead['source'];

header('Location: /confirmation.php');
exit;
