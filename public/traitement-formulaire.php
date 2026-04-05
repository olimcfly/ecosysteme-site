<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';

$crm = new CRM();

$data = [
    'email' => $_POST['email'] ?? '',
    'name' => $_POST['name'] ?? '',
    'phone' => $_POST['phone'] ?? '',
    'city' => $_POST['city'] ?? '',
    'source' => 'formulaire',
];

try {
    $leadId = $crm->createLead($data);
    header('Location: /confirmation.php?lead_id=' . $leadId);
    exit;
} catch (Exception $e) {
    header('Location: /formulaire.php?error=' . urlencode($e->getMessage()));
    exit;
}
