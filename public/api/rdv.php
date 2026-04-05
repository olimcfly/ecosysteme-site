<?php

declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://ton-domaine.com');
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$userId = (int) $_SESSION['user_id'];

/** @var PDO|null $db */
$db = null;

if (isset($pdo) && $pdo instanceof PDO) {
    $db = $pdo;
} elseif (isset($db) && $db instanceof PDO) {
    /** @var PDO $db */
} else {
    $dbHost = (string) (getenv('DB_HOST') ?: 'localhost');
    $dbName = (string) (getenv('DB_NAME') ?: '');
    $dbUser = (string) (getenv('DB_USER') ?: '');
    $dbPass = (string) (getenv('DB_PASS') ?: '');

    if ($dbName === '' || $dbUser === '') {
        http_response_code(500);
        echo json_encode(['error' => 'Configuration base de données manquante']);
        exit;
    }

    $db = new PDO(
        sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $dbHost, $dbName),
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
}

function validateSlotData(array $data): array
{
    $errors = [];

    if (empty($data['start_time'])) {
        $errors[] = "Le champ 'start_time' est requis.";
    }

    if (empty($data['end_time'])) {
        $errors[] = "Le champ 'end_time' est requis.";
    }

    if (!empty($data['start_time']) && !empty($data['end_time']) && strtotime((string) $data['end_time']) <= strtotime((string) $data['start_time'])) {
        $errors[] = "L'heure de fin doit être postérieure à l'heure de début.";
    }

    return $errors;
}

switch ($method) {
    case 'GET':
        $action = (string) ($_GET['action'] ?? '');

        switch ($action) {
            case 'types':
                $stmt = $db->prepare('SELECT * FROM rdv_types WHERE user_id = ? AND is_active = 1');
                $stmt->execute([$userId]);
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                break;

            case 'slots':
                $date = (string) ($_GET['date'] ?? date('Y-m-d'));

                $stmt = $db->prepare(
                    'SELECT s.*, t.name as type_name, t.color
                     FROM rdv_slots s
                     JOIN rdv_types t ON s.rdv_type_id = t.id
                     WHERE s.user_id = ? AND DATE(s.start_time) = ? AND s.is_booked = 0
                     ORDER BY s.start_time'
                );
                $stmt->execute([$userId, $date]);
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                break;

            case 'appointments':
                $stmt = $db->prepare(
                    'SELECT a.*, s.start_time, s.end_time, t.name as type_name
                     FROM rdv_appointments a
                     JOIN rdv_slots s ON a.rdv_slot_id = s.id
                     JOIN rdv_types t ON s.rdv_type_id = t.id
                     WHERE s.user_id = ?
                     ORDER BY s.start_time'
                );
                $stmt->execute([$userId]);
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                break;

            default:
                http_response_code(404);
                echo json_encode(['error' => 'Action inconnue']);
                break;
        }
        break;

    case 'POST':
        $data = json_decode((string) file_get_contents('php://input'), true) ?: [];
        $action = (string) ($data['action'] ?? '');

        switch ($action) {
            case 'create_slot':
                $errors = validateSlotData($data);
                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(['errors' => $errors]);
                    exit;
                }

                $stmt = $db->prepare(
                    'INSERT INTO rdv_slots
                     (user_id, rdv_type_id, start_time, end_time, is_recurring, recurring_pattern)
                     VALUES (?, ?, ?, ?, ?, ?)'
                );

                $stmt->execute([
                    $userId,
                    $data['rdv_type_id'] ?? null,
                    $data['start_time'] ?? null,
                    $data['end_time'] ?? null,
                    $data['is_recurring'] ?? 0,
                    $data['recurring_pattern'] ?? null,
                ]);

                echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
                break;

            case 'book_appointment':
                $slotId = $data['slot_id'] ?? null;
                if (!$slotId) {
                    http_response_code(422);
                    echo json_encode(['error' => 'slot_id requis']);
                    exit;
                }

                $stmt = $db->prepare('SELECT * FROM rdv_slots WHERE id = ? AND user_id = ? AND is_booked = 0');
                $stmt->execute([$slotId, $userId]);
                $slot = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$slot) {
                    http_response_code(409);
                    echo json_encode(['error' => 'Créneau indisponible']);
                    exit;
                }

                $db->beginTransaction();
                try {
                    $stmt = $db->prepare('UPDATE rdv_slots SET is_booked = 1 WHERE id = ? AND user_id = ?');
                    $stmt->execute([$slotId, $userId]);

                    $stmt = $db->prepare(
                        'INSERT INTO rdv_appointments
                         (rdv_slot_id, client_id, client_name, client_email, client_phone, bien_id, notes)
                         VALUES (?, ?, ?, ?, ?, ?, ?)'
                    );
                    $stmt->execute([
                        $slotId,
                        $data['client_id'] ?? null,
                        $data['client_name'] ?? null,
                        $data['client_email'] ?? null,
                        $data['client_phone'] ?? null,
                        $data['bien_id'] ?? null,
                        $data['notes'] ?? null,
                    ]);

                    $db->commit();
                    echo json_encode(['success' => true, 'appointment_id' => $db->lastInsertId()]);
                } catch (Throwable $e) {
                    $db->rollBack();
                    http_response_code(500);
                    echo json_encode(['error' => 'Erreur lors de la réservation']);
                }
                break;

            default:
                http_response_code(404);
                echo json_encode(['error' => 'Action inconnue']);
                break;
        }
        break;

    case 'PUT':
        $data = json_decode((string) file_get_contents('php://input'), true) ?: [];

        if (($data['action'] ?? '') !== 'update_appointment') {
            http_response_code(404);
            echo json_encode(['error' => 'Action inconnue']);
            exit;
        }

        $appointmentId = $data['appointment_id'] ?? null;
        $status = $data['status'] ?? null;

        if (!$appointmentId || !$status) {
            http_response_code(422);
            echo json_encode(['error' => 'appointment_id et status requis']);
            exit;
        }

        $stmt = $db->prepare(
            'UPDATE rdv_appointments a
             JOIN rdv_slots s ON a.rdv_slot_id = s.id
             SET a.status = ?
             WHERE a.id = ? AND s.user_id = ?'
        );
        $stmt->execute([$status, $appointmentId, $userId]);

        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}
