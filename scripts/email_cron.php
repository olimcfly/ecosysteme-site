<?php

declare(strict_types=1);

require_once __DIR__ . '/../lib/crm.php';

$result = crm_send_due_sequence_emails();

echo json_encode([
    'ok' => true,
    'executed_at' => gmdate('c'),
    'result' => $result,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
