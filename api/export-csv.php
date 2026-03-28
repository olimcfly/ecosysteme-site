<?php
/**
 * API - Export Leads to CSV
 */

header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Content-Type: application/json');
    exit(0);
}

require_once '../config/database.php';
require_once __DIR__ . '/../includes/api-auth.php';
require_once __DIR__ . '/../includes/rate-limiter.php';

// Authentification et rate limiting
checkRateLimit();
requireApiAuthOrAdmin();

try {
    $pdo = getDB();
    
    // Get filter parameters
    $source = $_GET['source'] ?? null;
    $status = $_GET['status'] ?? null;
    
    // Build query
    $where = [];
    $params = [];
    
    if ($source && $source !== 'all') {
        if ($source === 'download') {
            $where[] = "source LIKE 'download_%'";
        } else {
            $where[] = "source = ?";
            $params[] = $source;
        }
    }
    
    if ($status) {
        $where[] = "status = ?";
        $params[] = $status;
    }
    
    $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';
    
    $sql = "SELECT id, source, firstname, lastname, email, phone, city, activity, formula, message, status, notes, created_at FROM leads $whereClause ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $leads = $stmt->fetchAll();
    
    if (empty($leads)) {
        http_response_code(404);
        echo "Aucun lead à exporter";
        exit();
    }
    
    // Set headers for CSV download
    $filename = 'leads_ecosysteme_immo_' . date('Y-m-d_His') . '.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    // Output CSV
    $output = fopen('php://output', 'w');
    
    // Add BOM for Excel UTF-8 compatibility
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Header row
    $headers = ['ID', 'Source', 'Prénom', 'Nom', 'Email', 'Téléphone', 'Ville', 'Activité', 'Formule', 'Message', 'Statut', 'Notes', 'Date'];
    fputcsv($output, $headers, ';');
    
    // Source labels
    $sourceLabels = [
        'demo' => 'Démo',
        'devis' => 'Devis',
        'download_neuropersona' => 'Guide NeuroPersona',
        'download_seo-local' => 'Guide SEO Local',
        'download_methode-mere' => 'Méthode MERE',
        'download_offre' => 'Offre PDF',
        'newsletter' => 'Newsletter',
        'contact' => 'Contact'
    ];
    
    $statusLabels = [
        'new' => 'Nouveau',
        'contacted' => 'Contacté',
        'qualified' => 'Qualifié',
        'converted' => 'Converti',
        'lost' => 'Perdu'
    ];
    
    // Data rows
    foreach ($leads as $lead) {
        $row = [
            $lead['id'],
            $sourceLabels[$lead['source']] ?? $lead['source'],
            $lead['firstname'],
            $lead['lastname'],
            $lead['email'],
            $lead['phone'],
            $lead['city'],
            $lead['activity'],
            $lead['formula'],
            $lead['message'],
            $statusLabels[$lead['status']] ?? $lead['status'],
            $lead['notes'],
            date('d/m/Y H:i', strtotime($lead['created_at']))
        ];
        fputcsv($output, $row, ';');
    }
    
    fclose($output);
    
} catch (Exception $e) {
    http_response_code(500);
    echo "Erreur: " . $e->getMessage();
}
?>
