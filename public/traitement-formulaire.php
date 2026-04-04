<?php

declare(strict_types=1);

require_once __DIR__ . '/tracking.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: /formulaire.php');
    exit;
}

$input = [
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
$requiredFields = [
    'nom' => 'Le nom est requis.',
    'prenom' => 'Le prénom est requis.',
    'email' => 'L’email est requis.',
    'telephone' => 'Le téléphone est requis.',
    'zone' => 'La zone géographique est requise.',
    'experience' => 'Le niveau d’expérience est requis.',
    'contacts_vendeurs' => 'Merci de préciser si vous recevez des contacts vendeurs.',
    'objectif' => 'L’objectif principal est requis.',
    'investissement' => 'Merci de préciser votre intention d’investissement.',
];

foreach ($requiredFields as $field => $message) {
    if ($input[$field] === '') {
        $errors[] = $message;
    }
}

if ($input['email'] !== '' && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Le format de l’email est invalide.';
}

if ($errors !== []) {
    $query = http_build_query([
        'errors' => json_encode($errors, JSON_UNESCAPED_UNICODE),
        'old' => json_encode($input, JSON_UNESCAPED_UNICODE),
    ]);
    header('Location: /formulaire.php?' . $query);
    exit;
}

$storageDir = __DIR__ . '/../storage';
$leadsFile = $storageDir . '/tunnel_leads.json';
if (!is_dir($storageDir)) {
    mkdir($storageDir, 0775, true);
}

$existing = [];
if (file_exists($leadsFile)) {
    $raw = file_get_contents($leadsFile);
    if ($raw !== false && $raw !== '') {
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $existing = $decoded;
        }
    }
}

$lead = [
    'id' => bin2hex(random_bytes(8)),
    'nom' => $input['nom'],
    'prenom' => $input['prenom'],
    'email' => $input['email'],
    'telephone' => $input['telephone'],
    'zone' => $input['zone'],
    'experience' => $input['experience'],
    'contacts_vendeurs' => $input['contacts_vendeurs'],
    'objectif' => $input['objectif'],
    'investissement' => $input['investissement'],
    'source' => 'tunnel_ecosystemeimmo',
    'created_at' => gmdate('c'),
];

$existing[] = $lead;
file_put_contents($leadsFile, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

track_event('form_submission_success', [
    'lead_id' => $lead['id'],
    'zone' => $lead['zone'],
    'email' => $lead['email'],
]);

header('Location: /confirmation.php');
exit;
