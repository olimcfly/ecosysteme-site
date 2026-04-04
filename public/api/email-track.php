<?php

declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';

$action = (string) ($_GET['action'] ?? 'open');
$leadId = (string) ($_GET['lead'] ?? '');
$stepId = (string) ($_GET['step'] ?? '');
$target = (string) ($_GET['target'] ?? '');

if ($leadId !== '' && $stepId !== '') {
    crm_register_email_event($leadId, $stepId, $action);
}

if ($action === 'click') {
    if ($leadId !== '' && $target !== '') {
        crm_register_automation_action($leadId, $target);
        crm_schedule_email_jobs();
    }

    $redirect = CRM_VIDEO_URL;
    if ($target === 'offer') {
        $redirect = CRM_OFFER_URL;
    } elseif ($target === 'rdv') {
        $redirect = CRM_CALENDAR_URL;
    }

    header('Location: ' . $redirect, true, 302);
    exit;
}

header('Content-Type: image/gif');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
echo base64_decode('R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');
