<?php

declare(strict_types=1);

require_once __DIR__ . '/../lib/crm.php';
require_once __DIR__ . '/tracking.php';

session_start();

$wantsJson = str_contains(strtolower((string) ($_SERVER['HTTP_ACCEPT'] ?? '')), 'application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /video.php');
    exit;
}

$csrfToken = (string) ($_POST['csrf_token'] ?? '');
$sessionCsrfToken = (string) ($_SESSION['csrf_token'] ?? '');

if ($csrfToken === '' || $sessionCsrfToken === '' || !hash_equals($sessionCsrfToken, $csrfToken)) {
    if ($wantsJson) {
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Session expirée, merci de recharger la page.']);
        exit;
    }

    header('Location: /video.php?error=csrf');
    exit;
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$city = trim((string) ($_POST['city'] ?? ''));
$phone = trim((string) ($_POST['phone'] ?? ''));
$website = trim((string) ($_POST['website'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $city === '') {
    if ($wantsJson) {
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Veuillez compléter les champs obligatoires.']);
        exit;
    }

    header('Location: /video.php?error=validation');
    exit;
}

$lead = crm_create_lead([
    'nom' => $name,
    'email' => $email,
    'phone' => $phone,
    'city' => $city,
    'source' => 'video_presentation',
]);

track_event('video_form_submitted', [
    'lead_id' => (string) ($lead['id'] ?? ''),
    'city' => $city,
]);

$_SESSION['prenom'] = $name;
$_SESSION['email'] = $email;
$_SESSION['ville'] = $city;
$_SESSION['telephone'] = $phone;
$_SESSION['source'] = 'video_presentation';

if ($website !== '' || $message !== '') {
    $notes = [];
    if ($website !== '') {
        $notes[] = 'Site web: ' . $website;
    }
    if ($message !== '') {
        $notes[] = 'Message: ' . $message;
    }
    if ($notes !== []) {
        error_log('[ecosysteme-video] Informations complémentaires lead ' . ($lead['id'] ?? 'unknown') . ' | ' . implode(' | ', $notes));
    }
}

$offerUrl = '/offre.php?lead=' . urlencode((string) ($lead['id'] ?? ''));

if ($wantsJson) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        'success' => true,
        'offer_url' => $offerUrl,
    ]);
    exit;
}

header('Location: ' . $offerUrl);
exit;
