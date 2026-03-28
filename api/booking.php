<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ — API Prise de RDV
 * Endpoint: /api/bookings.php
 * 
 * GET  ?action=slots&date=2026-02-20  → créneaux dispo pour une date
 * GET  ?action=month&month=2026-02    → jours avec dispo sur un mois
 * POST ?action=book                   → réserver un créneau
 * GET  ?action=cancel&token=xxx       → annuler un RDV
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../includes/rate-limiter.php';
checkRateLimit();

// ── CONFIG ────────────────────────────────────────────────
define('SLOT_DURATION', 30);  // minutes par créneau
define('MIN_NOTICE_HOURS', 2); // délai minimum avant un RDV
define('MAX_DAYS_AHEAD', 60);  // réservation max X jours à l'avance
define('TIMEZONE', 'Europe/Paris');

date_default_timezone_set(TIMEZONE);

// ── DISPONIBILITÉS PAR DÉFAUT ─────────────────────────────
// 1=Lundi ... 7=Dimanche
$DEFAULT_AVAILABILITY = [
    1 => ['start' => '09:00', 'end' => '18:00', 'active' => true],  // Lundi
    2 => ['start' => '09:00', 'end' => '18:00', 'active' => true],  // Mardi
    3 => ['start' => '09:00', 'end' => '18:00', 'active' => true],  // Mercredi
    4 => ['start' => '09:00', 'end' => '18:00', 'active' => true],  // Jeudi
    5 => ['start' => '09:00', 'end' => '18:00', 'active' => true],  // Vendredi
    6 => ['start' => '10:00', 'end' => '13:00', 'active' => false], // Samedi
    7 => ['start' => '00:00', 'end' => '00:00', 'active' => false], // Dimanche
];

// Pause déjeuner
$LUNCH_BREAK = ['start' => '12:30', 'end' => '14:00'];

// Jours bloqués manuellement (vacances, etc.)
$BLOCKED_DATES = [
    // '2026-03-15', '2026-04-01',
];

// ── DB CONNECTION (optionnel) ─────────────────────────────
$pdo = null;
try {
    $dbConfig = __DIR__ . '/../config/database.php';
    if (file_exists($dbConfig)) {
        require_once $dbConfig;
        if (defined('DB_HOST') && defined('DB_NAME')) {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
    }
} catch (Exception $e) {
    // Pas de DB → on fonctionne en mode fichier
    $pdo = null;
}

// ── ROUTER ────────────────────────────────────────────────
$action = $_GET['action'] ?? ($_POST['action'] ?? '');

switch ($action) {
    case 'slots':
        getSlots();
        break;
    case 'month':
        getMonth();
        break;
    case 'book':
        createBooking();
        break;
    case 'cancel':
        cancelBooking();
        break;
    default:
        jsonResponse(['error' => 'Action invalide'], 400);
}

// ══════════════════════════════════════════════════════════
// FONCTIONS
// ══════════════════════════════════════════════════════════

function getSlots() {
    global $DEFAULT_AVAILABILITY, $LUNCH_BREAK, $BLOCKED_DATES, $pdo;
    
    $date = $_GET['date'] ?? '';
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        jsonResponse(['error' => 'Format date invalide (YYYY-MM-DD)'], 400);
    }
    
    $dateObj = new DateTime($date . ' 00:00:00', new DateTimeZone(TIMEZONE));
    $now = new DateTime('now', new DateTimeZone(TIMEZONE));
    $today = new DateTime('today', new DateTimeZone(TIMEZONE));
    
    // Pas dans le passé
    if ($dateObj < $today) {
        jsonResponse(['date' => $date, 'slots' => [], 'message' => 'Date passée']);
    }
    
    // Pas trop loin
    $maxDate = (clone $today)->modify('+' . MAX_DAYS_AHEAD . ' days');
    if ($dateObj > $maxDate) {
        jsonResponse(['date' => $date, 'slots' => [], 'message' => 'Date trop éloignée']);
    }
    
    // Jour bloqué ?
    if (in_array($date, $BLOCKED_DATES)) {
        jsonResponse(['date' => $date, 'slots' => [], 'message' => 'Jour non disponible']);
    }
    
    // Jour bloqué en DB ?
    if ($pdo) {
        $stmt = $pdo->prepare('SELECT id FROM booking_blocked_dates WHERE blocked_date = ?');
        $stmt->execute([$date]);
        if ($stmt->fetch()) {
            jsonResponse(['date' => $date, 'slots' => [], 'message' => 'Jour non disponible']);
        }
    }
    
    // Jour de la semaine (1=Lundi ... 7=Dimanche)
    $dayOfWeek = (int)$dateObj->format('N');
    
    // Récupérer la dispo du jour
    $avail = null;
    if ($pdo) {
        $stmt = $pdo->prepare('SELECT start_time, end_time, is_active FROM booking_availability WHERE day_of_week = ?');
        $stmt->execute([$dayOfWeek]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $avail = [
                'start' => substr($row['start_time'], 0, 5),
                'end' => substr($row['end_time'], 0, 5),
                'active' => (bool)$row['is_active']
            ];
        }
    }
    if (!$avail) {
        $avail = $DEFAULT_AVAILABILITY[$dayOfWeek] ?? null;
    }
    
    if (!$avail || !$avail['active']) {
        jsonResponse(['date' => $date, 'slots' => [], 'message' => 'Jour non travaillé']);
    }
    
    // Générer les créneaux
    $slots = [];
    $slotTime = new DateTime($date . ' ' . $avail['start'], new DateTimeZone(TIMEZONE));
    $endTime = new DateTime($date . ' ' . $avail['end'], new DateTimeZone(TIMEZONE));
    $lunchStart = new DateTime($date . ' ' . $LUNCH_BREAK['start'], new DateTimeZone(TIMEZONE));
    $lunchEnd = new DateTime($date . ' ' . $LUNCH_BREAK['end'], new DateTimeZone(TIMEZONE));
    $minNotice = (clone $now)->modify('+' . MIN_NOTICE_HOURS . ' hours');
    
    while ($slotTime < $endTime) {
        $slotEnd = (clone $slotTime)->modify('+' . SLOT_DURATION . ' minutes');
        $timeStr = $slotTime->format('H:i');
        
        // Pas pendant la pause déjeuner
        $duringLunch = ($slotTime >= $lunchStart && $slotTime < $lunchEnd);
        
        // Pas trop proche
        $tooSoon = ($slotTime <= $minNotice);
        
        if (!$duringLunch && !$tooSoon) {
            $slots[] = [
                'time' => $timeStr,
                'end' => $slotEnd->format('H:i'),
                'available' => true
            ];
        }
        
        $slotTime->modify('+' . SLOT_DURATION . ' minutes');
    }
    
    // Retirer les créneaux déjà réservés
    $bookedSlots = getBookedSlots($date);
    foreach ($slots as &$slot) {
        if (in_array($slot['time'], $bookedSlots)) {
            $slot['available'] = false;
        }
    }
    
    jsonResponse([
        'date' => $date,
        'day_label' => getDayLabel($dayOfWeek),
        'slots' => $slots
    ]);
}

function getMonth() {
    global $DEFAULT_AVAILABILITY, $BLOCKED_DATES, $pdo;
    
    $month = $_GET['month'] ?? '';
    if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
        jsonResponse(['error' => 'Format mois invalide (YYYY-MM)'], 400);
    }
    
    $year = (int)substr($month, 0, 4);
    $mon = (int)substr($month, 5, 2);
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $mon, $year);
    
    $today = new DateTime('today', new DateTimeZone(TIMEZONE));
    $maxDate = (clone $today)->modify('+' . MAX_DAYS_AHEAD . ' days');
    
    // Bloquer depuis DB
    $dbBlocked = [];
    if ($pdo) {
        $stmt = $pdo->prepare('SELECT blocked_date FROM booking_blocked_dates WHERE blocked_date LIKE ?');
        $stmt->execute([$month . '%']);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dbBlocked[] = $row['blocked_date'];
        }
    }
    $allBlocked = array_merge($BLOCKED_DATES, $dbBlocked);
    
    // Compter les réservations par jour
    $bookingCounts = [];
    if ($pdo) {
        $stmt = $pdo->prepare(
            'SELECT booking_date, COUNT(*) as cnt FROM bookings 
             WHERE booking_date LIKE ? AND status = "confirmed" 
             GROUP BY booking_date'
        );
        $stmt->execute([$month . '%']);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bookingCounts[$row['booking_date']] = (int)$row['cnt'];
        }
    }
    
    $days = [];
    for ($d = 1; $d <= $daysInMonth; $d++) {
        $dateStr = sprintf('%04d-%02d-%02d', $year, $mon, $d);
        $dateObj = new DateTime($dateStr, new DateTimeZone(TIMEZONE));
        $dayOfWeek = (int)$dateObj->format('N');
        
        $avail = $DEFAULT_AVAILABILITY[$dayOfWeek] ?? null;
        $isPast = $dateObj < $today;
        $isTooFar = $dateObj > $maxDate;
        $isBlocked = in_array($dateStr, $allBlocked);
        $isActive = $avail && $avail['active'];
        
        $status = 'available';
        if ($isPast) $status = 'past';
        elseif ($isTooFar) $status = 'too_far';
        elseif ($isBlocked) $status = 'blocked';
        elseif (!$isActive) $status = 'closed';
        
        // Estimer le nombre de créneaux total pour ce jour
        $totalSlots = 0;
        if ($status === 'available' && $avail) {
            $start = strtotime($avail['start']);
            $end = strtotime($avail['end']);
            $totalSlots = max(0, ($end - $start) / 60 / SLOT_DURATION - 3); // -3 pour pause déjeuner
        }
        
        $booked = $bookingCounts[$dateStr] ?? 0;
        if ($status === 'available' && $totalSlots > 0 && $booked >= $totalSlots) {
            $status = 'full';
        }
        
        $days[] = [
            'date' => $dateStr,
            'day' => $d,
            'dow' => $dayOfWeek,
            'status' => $status
        ];
    }
    
    jsonResponse([
        'month' => $month,
        'year' => $year,
        'month_num' => $mon,
        'month_label' => getMonthLabel($mon),
        'days' => $days
    ]);
}

function createBooking() {
    global $pdo;
    
    // Lire le body JSON
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        $input = $_POST;
    }
    
    // Validation
    $required = ['first_name', 'last_name', 'email', 'date', 'time'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            jsonResponse(['error' => "Champ requis manquant : $field"], 400);
        }
    }
    
    $firstName = trim($input['first_name']);
    $lastName  = trim($input['last_name']);
    $email     = trim($input['email']);
    $phone     = trim($input['phone'] ?? '');
    $message   = trim($input['message'] ?? '');
    $date      = $input['date'];
    $time      = $input['time'];
    $source    = $input['source'] ?? 'site';
    
    // Valider l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonResponse(['error' => 'Email invalide'], 400);
    }
    
    // Valider le format date/heure
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        jsonResponse(['error' => 'Format date invalide'], 400);
    }
    if (!preg_match('/^\d{2}:\d{2}$/', $time)) {
        jsonResponse(['error' => 'Format heure invalide'], 400);
    }
    
    // Vérifier que le créneau n'est pas dans le passé
    $slotDateTime = new DateTime($date . ' ' . $time, new DateTimeZone(TIMEZONE));
    $minNotice = new DateTime('+' . MIN_NOTICE_HOURS . ' hours', new DateTimeZone(TIMEZONE));
    if ($slotDateTime <= $minNotice) {
        jsonResponse(['error' => 'Ce créneau n\'est plus disponible'], 409);
    }
    
    // Token d'annulation
    $cancelToken = bin2hex(random_bytes(32));
    
    if ($pdo) {
        // Vérifier que le créneau est libre (anti-doublon)
        $stmt = $pdo->prepare(
            'SELECT id FROM bookings WHERE booking_date = ? AND booking_time = ? AND status = "confirmed"'
        );
        $stmt->execute([$date, $time . ':00']);
        if ($stmt->fetch()) {
            jsonResponse(['error' => 'Ce créneau vient d\'être réservé par quelqu\'un d\'autre'], 409);
        }
        
        // Insérer
        $stmt = $pdo->prepare(
            'INSERT INTO bookings (first_name, last_name, email, phone, message, booking_date, booking_time, source, cancel_token, ip_address) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $firstName, $lastName, $email, $phone, $message,
            $date, $time . ':00', $source, $cancelToken,
            $_SERVER['REMOTE_ADDR'] ?? ''
        ]);
        
        $bookingId = $pdo->lastInsertId();
    } else {
        // Mode fichier (fallback)
        $bookingId = time();
        $bookingsFile = __DIR__ . '/../logs/bookings.json';
        $bookings = [];
        if (file_exists($bookingsFile)) {
            $bookings = json_decode(file_get_contents($bookingsFile), true) ?: [];
        }
        
        // Vérifier anti-doublon
        foreach ($bookings as $b) {
            if ($b['date'] === $date && $b['time'] === $time && $b['status'] === 'confirmed') {
                jsonResponse(['error' => 'Ce créneau vient d\'être réservé'], 409);
            }
        }
        
        $bookings[] = [
            'id' => $bookingId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
            'date' => $date,
            'time' => $time,
            'source' => $source,
            'cancel_token' => $cancelToken,
            'status' => 'confirmed',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        @mkdir(dirname($bookingsFile), 0755, true);
        file_put_contents($bookingsFile, json_encode($bookings, JSON_PRETTY_PRINT));
    }
    
    // Notification par email (si mail() est dispo)
    sendNotificationEmail($firstName, $lastName, $email, $phone, $date, $time, $message);
    
    jsonResponse([
        'success' => true,
        'booking_id' => $bookingId,
        'message' => 'RDV confirmé !',
        'details' => [
            'date' => $date,
            'time' => $time,
            'duration' => SLOT_DURATION . ' min',
            'name' => $firstName . ' ' . $lastName
        ]
    ]);
}

function cancelBooking() {
    global $pdo;
    
    $token = $_GET['token'] ?? '';
    if (empty($token)) {
        jsonResponse(['error' => 'Token manquant'], 400);
    }
    
    if ($pdo) {
        $stmt = $pdo->prepare('UPDATE bookings SET status = "cancelled" WHERE cancel_token = ? AND status = "confirmed"');
        $stmt->execute([$token]);
        if ($stmt->rowCount() > 0) {
            jsonResponse(['success' => true, 'message' => 'RDV annulé avec succès']);
        }
    }
    
    jsonResponse(['error' => 'RDV introuvable ou déjà annulé'], 404);
}

// ── HELPERS ───────────────────────────────────────────────

function getBookedSlots($date) {
    global $pdo;
    $booked = [];
    
    if ($pdo) {
        $stmt = $pdo->prepare(
            'SELECT TIME_FORMAT(booking_time, "%H:%i") as t FROM bookings WHERE booking_date = ? AND status = "confirmed"'
        );
        $stmt->execute([$date]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $booked[] = $row['t'];
        }
    } else {
        $bookingsFile = __DIR__ . '/../logs/bookings.json';
        if (file_exists($bookingsFile)) {
            $bookings = json_decode(file_get_contents($bookingsFile), true) ?: [];
            foreach ($bookings as $b) {
                if ($b['date'] === $date && $b['status'] === 'confirmed') {
                    $booked[] = $b['time'];
                }
            }
        }
    }
    
    return $booked;
}

function sendNotificationEmail($firstName, $lastName, $email, $phone, $date, $time, $message) {
    // Email au propriétaire
    $to = 'contact@ecosystemeimmo.fr'; // À modifier
    $subject = "📅 Nouveau RDV — $firstName $lastName — $date à $time";
    
    $dateFormatted = (new DateTime($date))->format('d/m/Y');
    
    $body = "Nouveau rendez-vous réservé :\n\n";
    $body .= "Nom : $firstName $lastName\n";
    $body .= "Email : $email\n";
    $body .= "Téléphone : $phone\n";
    $body .= "Date : $dateFormatted à $time\n";
    $body .= "Durée : " . SLOT_DURATION . " min\n";
    if ($message) $body .= "Message : $message\n";
    
    $headers = "From: noreply@ecosystemeimmo.fr\r\nReply-To: $email\r\n";
    
    @mail($to, $subject, $body, $headers);
    
    // Email de confirmation au prospect
    $subjectClient = "✅ Votre RDV est confirmé — $dateFormatted à $time";
    $bodyClient = "Bonjour $firstName,\n\n";
    $bodyClient .= "Votre rendez-vous est confirmé !\n\n";
    $bodyClient .= "📅 Date : $dateFormatted\n";
    $bodyClient .= "🕐 Heure : $time\n";
    $bodyClient .= "⏱️ Durée : " . SLOT_DURATION . " minutes\n";
    $bodyClient .= "📞 Appel vidéo ou téléphonique\n\n";
    $bodyClient .= "Olivier Colas vous contactera au numéro indiqué ou par email.\n\n";
    $bodyClient .= "À très bientôt !\n";
    $bodyClient .= "— L'équipe ÉCOSYSTÈME IMMO LOCAL+\n";
    
    $headersClient = "From: Olivier Colas <noreply@ecosystemeimmo.fr>\r\n";
    
    @mail($email, $subjectClient, $bodyClient, $headersClient);
}

function getDayLabel($dow) {
    $labels = [1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi',7=>'Dimanche'];
    return $labels[$dow] ?? '';
}

function getMonthLabel($m) {
    $labels = [1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',
               7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre'];
    return $labels[$m] ?? '';
}

function jsonResponse($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}