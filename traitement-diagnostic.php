<?php
declare(strict_types=1);

/**
 * Traitement du formulaire de diagnostic
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot
    if (!empty($_POST['website'])) {
        error_log('Spam detected via honeypot');
        header('Location: /diagnostic-visibilite-locale?status=error');
        exit;
    }

    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    if (!$email || empty($_POST['consent'])) {
        header('Location: /diagnostic-visibilite-locale?status=invalid');
        exit;
    }

    $fields = [
        'first_name' => strip_tags($_POST['first_name'] ?? ''),
        'last_name'  => strip_tags($_POST['last_name'] ?? ''),
        'email'      => $email,
        'phone'      => strip_tags($_POST['phone'] ?? ''),
        'network'    => strip_tags($_POST['network'] ?? 'ImmoForfait'),
        'city'       => strip_tags($_POST['city_or_department'] ?? ''),
        'source'     => 'diagnostic-visibilite-locale',
        'source_url' => 'https://ecosystemeimmo.fr/diagnostic-visibilite-locale',
        'notes'      => strip_tags($_POST['message'] ?? ''),
        'message'    => strip_tags($_POST['message'] ?? ''),
        'consent_rgpd' => 1,
        'status'     => 'new',
        'score'      => 50,
        'utm_source' => $_POST['utm_source'] ?? '',
        'utm_medium' => $_POST['utm_medium'] ?? '',
        'utm_campaign' => $_POST['utm_campaign'] ?? '',
    ];

    $ch = curl_init('https://admin.ecosystemeimmo.fr/api/public/lead-capture.php');
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($fields),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);
    curl_exec($ch);
    curl_close($ch);

    header('Location: /rdv.php?src=audit');
    exit;
}

header('Location: /diagnostic-visibilite-locale');
exit;
