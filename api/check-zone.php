<?php
/**
 * API — Vérification de disponibilité de zone IMMO LOCAL+
 * 
 * Endpoint : POST /api/check-zone.php
 * Params   : latitude, longitude, ville (optionnel)
 * Response : JSON { disponible, zone_proche, distance_km, zones_prises }
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../includes/rate-limiter.php';
checkRateLimit();

// ─── Configuration DB ───────────────────────────────────────
// Adapter le chemin selon votre structure
$configPath = __DIR__ . '/../../config/database.php';
if (file_exists($configPath)) {
    require_once $configPath;
}

// ─── Fallback si pas de DB (zones en dur pour démarrage) ────
$ZONES_FALLBACK = [
    [
        'id' => 1,
        'ville_centre' => 'Bordeaux',
        'departement' => '33',
        'region' => 'Nouvelle-Aquitaine',
        'latitude' => 44.837789,
        'longitude' => -0.579180,
        'rayon_km' => 50,
        'titulaire_nom' => 'Eduardo De Sul',
        'titulaire_reseau' => 'eXp France',
        'statut' => 'pilote'
    ],
    [
        'id' => 2,
        'ville_centre' => 'Nantes',
        'departement' => '44',
        'region' => 'Pays de la Loire',
        'latitude' => 47.218371,
        'longitude' => -1.553621,
        'rayon_km' => 50,
        'titulaire_nom' => null,
        'titulaire_reseau' => null,
        'statut' => 'en_negociation'
    ],
    [
        'id' => 3,
        'ville_centre' => 'Nandy',
        'departement' => '77',
        'region' => 'Île-de-France',
        'latitude' => 48.579500,
        'longitude' => 2.578100,
        'rayon_km' => 50,
        'titulaire_nom' => null,
        'titulaire_reseau' => null,
        'statut' => 'en_negociation'
    ],
    [
        'id' => 4,
        'ville_centre' => 'Aix-en-Provence',
        'departement' => '13',
        'region' => 'Provence-Alpes-Côte d\'Azur',
        'latitude' => 43.529742,
        'longitude' => 5.447427,
        'rayon_km' => 50,
        'titulaire_nom' => null,
        'titulaire_reseau' => null,
        'statut' => 'en_negociation'
    ],
    [
        'id' => 5,
        'ville_centre' => 'Lannion',
        'departement' => '22',
        'region' => 'Bretagne',
        'latitude' => 48.732084,
        'longitude' => -3.459144,
        'rayon_km' => 50,
        'titulaire_nom' => null,
        'titulaire_reseau' => null,
        'statut' => 'en_negociation'
    ]
];

// ─── Formule Haversine ──────────────────────────────────────
function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371; // Rayon de la Terre en km
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $R * $c;
}

// ─── Récupérer les zones depuis la DB ou fallback ───────────
function getZones() {
    global $ZONES_FALLBACK;
    
    try {
        // Tenter la connexion DB
        if (class_exists('Database')) {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("
                SELECT id, ville_centre, departement, region, 
                       latitude, longitude, rayon_km,
                       titulaire_nom, titulaire_reseau, statut
                FROM zones_territoriales 
                WHERE statut IN ('active', 'pilote', 'reservee', 'en_negociation')
            ");
            $zones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($zones)) return $zones;
        }
    } catch (Exception $e) {
        // Silencieux — on utilise le fallback
    }
    
    return $ZONES_FALLBACK;
}

// ─── Récupérer les paramètres ───────────────────────────────
$latitude = null;
$longitude = null;
$ville = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $latitude = isset($input['latitude']) ? floatval($input['latitude']) : null;
    $longitude = isset($input['longitude']) ? floatval($input['longitude']) : null;
    $ville = isset($input['ville']) ? trim($input['ville']) : '';
} else {
    $latitude = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
    $longitude = isset($_GET['lng']) ? floatval($_GET['lng']) : null;
    $ville = isset($_GET['ville']) ? trim($_GET['ville']) : '';
}

// ─── Mode "toutes les zones" (pour la carte) ────────────────
if (isset($_GET['action']) && $_GET['action'] === 'all_zones') {
    $zones = getZones();
    $zonesPubliques = array_map(function($z) {
        return [
            'ville_centre' => $z['ville_centre'],
            'departement' => $z['departement'],
            'region' => $z['region'],
            'latitude' => floatval($z['latitude']),
            'longitude' => floatval($z['longitude']),
            'rayon_km' => intval($z['rayon_km']),
            'statut' => $z['statut'],
            'titulaire_prenom' => $z['titulaire_nom'] ? explode(' ', $z['titulaire_nom'])[0] : null,
            'reseau' => $z['titulaire_reseau']
        ];
    }, $zones);
    
    echo json_encode(['success' => true, 'zones' => $zonesPubliques]);
    exit;
}

// ─── Validation ─────────────────────────────────────────────
if ($latitude === null || $longitude === null) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Latitude et longitude requises'
    ]);
    exit;
}

// Vérifier que les coordonnées sont en France métropolitaine (approximatif)
if ($latitude < 41.0 || $latitude > 51.5 || $longitude < -5.5 || $longitude > 10.0) {
    echo json_encode([
        'success' => true,
        'disponible' => false,
        'raison' => 'hors_france',
        'message' => 'IMMO LOCAL+ est disponible uniquement en France métropolitaine pour le moment.'
    ]);
    exit;
}

// ─── Vérification de disponibilité ──────────────────────────
$zones = getZones();
$zonePlusProche = null;
$distanceMin = PHP_INT_MAX;
$conflits = [];

foreach ($zones as $zone) {
    $distance = haversineDistance(
        $latitude, $longitude,
        floatval($zone['latitude']), floatval($zone['longitude'])
    );
    
    $rayonZone = intval($zone['rayon_km']);
    
    // Vérifier le chevauchement (les deux zones de 50km ne doivent pas se chevaucher)
    // Deux zones se chevauchent si la distance entre centres < somme des rayons
    // Pour simplifier : distance < rayon de la zone existante
    if ($distance < $rayonZone) {
        $conflits[] = [
            'ville_centre' => $zone['ville_centre'],
            'departement' => $zone['departement'],
            'distance_km' => round($distance, 1),
            'statut' => $zone['statut'],
            'titulaire_prenom' => $zone['titulaire_nom'] ? explode(' ', $zone['titulaire_nom'])[0] : null,
            'reseau' => $zone['titulaire_reseau']
        ];
    }
    
    if ($distance < $distanceMin) {
        $distanceMin = $distance;
        $zonePlusProche = [
            'ville_centre' => $zone['ville_centre'],
            'departement' => $zone['departement'],
            'distance_km' => round($distance, 1),
            'statut' => $zone['statut']
        ];
    }
}

$disponible = empty($conflits);

// ─── Réponse ────────────────────────────────────────────────
$response = [
    'success' => true,
    'ville_recherchee' => $ville,
    'latitude' => $latitude,
    'longitude' => $longitude,
    'disponible' => $disponible,
    'zone_plus_proche' => $zonePlusProche,
    'distance_zone_proche_km' => round($distanceMin, 1)
];

if (!$disponible) {
    $response['conflits'] = $conflits;
    $response['message'] = count($conflits) === 1
        ? "Cette zone est déjà couverte par la zone de {$conflits[0]['ville_centre']} ({$conflits[0]['distance_km']} km)."
        : "Cette localisation est couverte par " . count($conflits) . " zones existantes.";
} else {
    if ($distanceMin < 80) {
        $response['message'] = "Bonne nouvelle ! Votre zone est disponible. La zone la plus proche est {$zonePlusProche['ville_centre']} à {$zonePlusProche['distance_km']} km.";
    } else {
        $response['message'] = "Excellente nouvelle ! Votre zone est disponible et aucune zone existante n'est à proximité.";
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);