<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function respondJson(array $payload, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($payload);
    exit;
}

function requireAuthUserId(): int
{
    $userId = filter_var($_SESSION['user_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($userId === false) {
        respondJson(['error' => 'Unauthorized'], 401);
    }

    return (int) $userId;
}

function getDbConnection(): PDO
{
    $dbHost = (string) (getenv('DB_HOST') ?: 'localhost');
    $dbName = (string) (getenv('DB_NAME') ?: '');
    $dbUser = (string) (getenv('DB_USER') ?: '');
    $dbPass = (string) (getenv('DB_PASSWORD') ?: getenv('DB_PASS') ?: '');

    if ($dbName === '' || $dbUser === '') {
        respondJson(['error' => 'Configuration base de données manquante'], 500);
    }

    return new PDO(
        sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $dbHost, $dbName),
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
}

function validateSlotData(array $data): array
{
    $errors = [];

    $rdvTypeId = filter_var($data['rdv_type_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($rdvTypeId === false) {
        $errors[] = "Le champ 'rdv_type_id' est invalide.";
    }

    $startRaw = (string) ($data['start_time'] ?? '');
    $endRaw = (string) ($data['end_time'] ?? '');

    if ($startRaw === '') {
        $errors[] = "Le champ 'start_time' est requis.";
    }

    if ($endRaw === '') {
        $errors[] = "Le champ 'end_time' est requis.";
    }

    if ($startRaw !== '' && $endRaw !== '') {
        $startTime = strtotime($startRaw);
        $endTime = strtotime($endRaw);

        if ($startTime === false || $endTime === false) {
            $errors[] = 'Format de date/heure invalide.';
        } elseif ($endTime <= $startTime) {
            $errors[] = "L'heure de fin doit être postérieure à l'heure de début.";
        }
    }

    return $errors;
}

$method = $_SERVER['REQUEST_METHOD'];
$db = getDbConnection();

try {
    switch ($method) {
        case 'GET':
            $action = (string) ($_GET['action'] ?? '');
            $userId = filter_var($_GET['user_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

            if ($userId === false) {
                respondJson(['error' => 'user_id invalide'], 422);
            }

            if ($action === 'types') {
                $stmt = $db->prepare('SELECT * FROM rdv_types WHERE user_id = ? AND is_active = 1 ORDER BY id DESC');
                $stmt->execute([$userId]);
                respondJson($stmt->fetchAll());
            }

            if ($action === 'slots') {
                $date = (string) ($_GET['date'] ?? date('Y-m-d'));
                $dateObj = DateTime::createFromFormat('Y-m-d', $date);
                if ($dateObj === false || $dateObj->format('Y-m-d') !== $date) {
                    respondJson(['error' => 'Date invalide. Format attendu : YYYY-MM-DD'], 422);
                }

                $stmt = $db->prepare(
                    'SELECT s.*, t.name AS type_name, t.color
                     FROM rdv_slots s
                     JOIN rdv_types t ON s.rdv_type_id = t.id
                     WHERE s.user_id = ? AND DATE(s.start_time) = ? AND s.is_booked = 0
                     ORDER BY s.start_time'
                );
                $stmt->execute([$userId, $date]);
                respondJson($stmt->fetchAll());
            }

            if ($action === 'appointments') {
                $stmt = $db->prepare(
                    'SELECT a.*, s.start_time, s.end_time, t.name AS type_name
                     FROM rdv_appointments a
                     JOIN rdv_slots s ON a.rdv_slot_id = s.id
                     JOIN rdv_types t ON s.rdv_type_id = t.id
                     WHERE s.user_id = ?
                     ORDER BY s.start_time DESC'
                );
                $stmt->execute([$userId]);
                respondJson($stmt->fetchAll());
            }

            respondJson(['error' => 'Action GET invalide'], 400);

        case 'POST':
            $data = json_decode((string) file_get_contents('php://input'), true);
            if (!is_array($data)) {
                respondJson(['error' => 'Payload JSON invalide'], 400);
            }

            $action = (string) ($data['action'] ?? '');

            if ($action === 'create_slot') {
                $authUserId = requireAuthUserId();
                $errors = validateSlotData($data);

                if (!empty($errors)) {
                    respondJson(['errors' => $errors], 422);
                }

                $stmt = $db->prepare(
                    'INSERT INTO rdv_slots
                     (user_id, rdv_type_id, start_time, end_time, is_recurring, recurring_pattern)
                     VALUES (?, ?, ?, ?, ?, ?)'
                );

                $stmt->execute([
                    $authUserId,
                    (int) $data['rdv_type_id'],
                    (string) $data['start_time'],
                    (string) $data['end_time'],
                    !empty($data['is_recurring']) ? 1 : 0,
                    isset($data['recurring_pattern']) ? substr(trim((string) $data['recurring_pattern']), 0, 50) : null,
                ]);

                respondJson(['success' => true, 'id' => $db->lastInsertId()], 201);
            }

            if ($action === 'book_appointment') {
                $slotId = filter_var($data['slot_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
                $clientName = trim((string) ($data['client_name'] ?? ''));
                $clientEmail = trim((string) ($data['client_email'] ?? ''));

                if ($slotId === false) {
                    respondJson(['error' => 'slot_id invalide'], 422);
                }
                if (mb_strlen($clientName) < 2 || mb_strlen($clientName) > 120) {
                    respondJson(['error' => 'client_name invalide'], 422);
                }
                if (!filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
                    respondJson(['error' => 'client_email invalide'], 422);
                }

                $db->beginTransaction();

                $lockSlot = $db->prepare('SELECT id FROM rdv_slots WHERE id = ? AND is_booked = 0 FOR UPDATE');
                $lockSlot->execute([$slotId]);
                if ($lockSlot->fetch() === false) {
                    $db->rollBack();
                    respondJson(['error' => 'Créneau indisponible'], 409);
                }

                $updateSlot = $db->prepare('UPDATE rdv_slots SET is_booked = 1 WHERE id = ?');
                $updateSlot->execute([$slotId]);

                $insert = $db->prepare(
                    'INSERT INTO rdv_appointments
                     (rdv_slot_id, client_id, client_name, client_email, client_phone, bien_id, notes)
                     VALUES (?, ?, ?, ?, ?, ?, ?)'
                );
                $insert->execute([
                    $slotId,
                    filter_var($data['client_id'] ?? null, FILTER_VALIDATE_INT) ?: null,
                    $clientName,
                    $clientEmail,
                    isset($data['client_phone']) ? substr(trim((string) $data['client_phone']), 0, 30) : null,
                    filter_var($data['bien_id'] ?? null, FILTER_VALIDATE_INT) ?: null,
                    isset($data['notes']) ? substr(trim((string) $data['notes']), 0, 1000) : null,
                ]);

                $db->commit();
                respondJson(['success' => true, 'appointment_id' => $db->lastInsertId()], 201);
            }

            respondJson(['error' => 'Action POST invalide'], 400);

        case 'PUT':
            $authUserId = requireAuthUserId();
            $data = json_decode((string) file_get_contents('php://input'), true);

            if (!is_array($data) || (string) ($data['action'] ?? '') !== 'update_appointment') {
                respondJson(['error' => 'Action PUT invalide'], 400);
            }

            $appointmentId = filter_var($data['appointment_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            $status = trim((string) ($data['status'] ?? ''));

            if ($appointmentId === false) {
                respondJson(['error' => 'appointment_id invalide'], 422);
            }
            if (!in_array($status, ['pending', 'confirmed', 'cancelled'], true)) {
                respondJson(['error' => 'status invalide'], 422);
            }

            $stmt = $db->prepare(
                'UPDATE rdv_appointments a
                 JOIN rdv_slots s ON a.rdv_slot_id = s.id
                 SET a.status = ?
                 WHERE a.id = ? AND s.user_id = ?'
            );
            $stmt->execute([$status, $appointmentId, $authUserId]);

            respondJson(['success' => true]);

        default:
            respondJson(['error' => 'Méthode non supportée'], 405);
    }
} catch (PDOException $e) {
    error_log('Erreur SQL API RDV : ' . $e->getMessage());
    respondJson(['error' => 'Erreur interne'], 500);
}
