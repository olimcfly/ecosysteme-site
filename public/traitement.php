<?php

declare(strict_types=1);

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /index.php');
    exit;
}

$csrfToken = (string) ($_POST['csrf_token'] ?? '');
$sessionCsrfToken = (string) ($_SESSION['csrf_token'] ?? '');

if ($csrfToken === '' || $sessionCsrfToken === '' || !hash_equals($sessionCsrfToken, $csrfToken)) {
    $_SESSION['form_errors'] = '⚠️ Session expirée, merci de réessayer.';
    header('Location: /index.php?erreur=csrf');
    exit;
}

$lead = [
    'prenom' => trim((string) ($_POST['prenom'] ?? '')),
    'email' => trim((string) ($_POST['email'] ?? '')),
    'phone' => trim((string) ($_POST['phone'] ?? '')),
    'agency' => trim((string) ($_POST['agency'] ?? '')),
    'ville' => trim((string) ($_POST['ville'] ?? '')),
    'source' => trim((string) ($_POST['source'] ?? 'popup_7_erreurs')),
];

$errors = [];

if ($lead['prenom'] === '') {
    $errors[] = 'Le prénom est obligatoire.';
}

if (!filter_var($lead['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Veuillez entrer un email valide.';
}

if ($lead['ville'] === '') {
    $errors[] = 'La ville / le secteur est obligatoire.';
}

if ($errors !== []) {
    $_SESSION['form_old'] = $lead;
    $_SESSION['form_errors'] = '⚠️ ' . implode(' ', $errors);

    header('Location: /index.php?erreur=validation');
    exit;
}

$_SESSION['lead'] = [
    'prenom' => $lead['prenom'],
    'email' => $lead['email'],
    'phone' => $lead['phone'],
    'agency' => $lead['agency'],
    'ville' => $lead['ville'],
    'source' => $lead['source'],
];

header('Location: /video.php');
exit;
