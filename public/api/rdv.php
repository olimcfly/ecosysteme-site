<?php
header('Content-Type: application/json');
require_once '../config/database.php'; // Fichier de connexion à la base de données

// Récupérer la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=mahe6420_site_immo;charset=utf8mb4', 'votre_utilisateur', 'votre_mot_de_passe');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fonction pour vérifier l'authentification (JWT ou session)
function isAuthenticated() {
    // Implémentez votre logique d'authentification ici
    return isset($_SESSION['user_id']);
}

// Fonction pour valider les données
function validateSlotData($data) {
    $errors = [];
    if (empty($data['start_time'])) $errors[] = "Le champ 'start_time' est requis.";
    if (empty($data['end_time'])) $errors[] = "Le champ 'end_time' est requis.";
    if (strtotime($data['end_time']) <= strtotime($data['start_time'])) {
        $errors[] = "L'heure de fin doit être postérieure à l'heure de début.";
    }
    return $errors;
}

// Routes de l'API
switch ($method) {
    case 'GET':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'types':
                    // Récupérer les types de RDV pour un conseiller
                    $userId = $_GET['user_id'] ?? null;
                    if (!$userId) {
                        echo json_encode(['error' => 'user_id requis']);
                        exit;
                    }
                    $stmt = $db->prepare("SELECT * FROM rdv_types WHERE user_id = ? AND is_active = 1");
                    $stmt->execute([$userId]);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                    break;

                case 'slots':
                    // Récupérer les créneaux disponibles pour un conseiller
                    $userId = $_GET['user_id'] ?? null;
                    $date = $_GET['date'] ?? date('Y-m-d');
                    if (!$userId) {
                        echo json_encode(['error' => 'user_id requis']);
                        exit;
                    }
                    $stmt = $db->prepare("
                        SELECT s.*, t.name as type_name, t.color
                        FROM rdv_slots s
                        JOIN rdv_types t ON s.rdv_type_id = t.id
                        WHERE s.user_id = ? AND DATE(s.start_time) = ? AND s.is_booked = 0
                        ORDER BY s.start_time
                    ");
                    $stmt->execute([$userId, $date]);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                    break;

                case 'appointments':
                    // Récupérer les RDV d'un conseiller
                    $userId = $_GET['user_id'] ?? null;
                    if (!$userId) {
                        echo json_encode(['error' => 'user_id requis']);
                        exit;
                    }
                    $stmt = $db->prepare("
                        SELECT a.*, s.start_time, s.end_time, t.name as type_name
                        FROM rdv_appointments a
                        JOIN rdv_slots s ON a.rdv_slot_id = s.id
                        JOIN rdv_types t ON s.rdv_type_id = t.id
                        WHERE s.user_id = ?
                        ORDER BY s.start_time
                    ");
                    $stmt->execute([$userId]);
                    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                    break;
            }
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['action'])) {
            switch ($data['action']) {
                case 'create_slot':
                    // Créer un nouveau créneau
                    if (!isAuthenticated()) {
                        echo json_encode(['error' => 'Non autorisé']);
                        exit;
                    }

                    $errors = validateSlotData($data);
                    if (!empty($errors)) {
                        echo json_encode(['errors' => $errors]);
                        exit;
                    }

                    $stmt = $db->prepare("
                        INSERT INTO rdv_slots
                        (user_id, rdv_type_id, start_time, end_time, is_recurring, recurring_pattern)
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([
                        $_SESSION['user_id'],
                        $data['rdv_type_id'],
                        $data['start_time'],
                        $data['end_time'],
                        $data['is_recurring'] ?? 0,
                        $data['recurring_pattern'] ?? null
                    ]);
                    echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
                    break;

                case 'book_appointment':
                    // Réserver un RDV
                    $slotId = $data['slot_id'] ?? null;
                    if (!$slotId) {
                        echo json_encode(['error' => 'slot_id requis']);
                        exit;
                    }

                    // Vérifier que le créneau est disponible
                    $stmt = $db->prepare("SELECT * FROM rdv_slots WHERE id = ? AND is_booked = 0");
                    $stmt->execute([$slotId]);
                    $slot = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (!$slot) {
                        echo json_encode(['error' => 'Créneau indisponible']);
                        exit;
                    }

                    // Réserver le créneau
                    $db->beginTransaction();
                    try {
                        $stmt = $db->prepare("UPDATE rdv_slots SET is_booked = 1 WHERE id = ?");
                        $stmt->execute([$slotId]);

                        $stmt = $db->prepare("
                            INSERT INTO rdv_appointments
                            (rdv_slot_id, client_id, client_name, client_email, client_phone, bien_id, notes)
                            VALUES (?, ?, ?, ?, ?, ?, ?)
                        ");
                        $stmt->execute([
                            $slotId,
                            $data['client_id'] ?? null,
                            $data['client_name'],
                            $data['client_email'],
                            $data['client_phone'] ?? null,
                            $data['bien_id'] ?? null,
                            $data['notes'] ?? null
                        ]);

                        $db->commit();
                        echo json_encode(['success' => true, 'appointment_id' => $db->lastInsertId()]);
                    } catch (Exception $e) {
                        $db->rollBack();
                        echo json_encode(['error' => 'Erreur lors de la réservation: ' . $e->getMessage()]);
                    }
                    break;
            }
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['action']) && $data['action'] === 'update_appointment') {
            // Mettre à jour un RDV (ex: annuler)
            $appointmentId = $data['appointment_id'] ?? null;
            if (!$appointmentId) {
                echo json_encode(['error' => 'appointment_id requis']);
                exit;
            }

            $stmt = $db->prepare("UPDATE rdv_appointments SET status = ? WHERE id = ?");
            $stmt->execute([$data['status'], $appointmentId]);
            echo json_encode(['success' => true]);
        }
        break;
}
?>
