<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Email Notification Handler
 * Receives form submissions and sends email notifications
 */

// CORS restreint au domaine ecosystemeimmo.fr
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/api-auth.php';
require_once __DIR__ . '/../includes/rate-limiter.php';

// Authentification et rate limiting
checkRateLimit();
requireApiAuthOrAdmin();

// ============================================
// CONFIGURATION SMTP
// ============================================
$config = [
    'smtp_host' => 'ecosystemeimmo.fr',
    'smtp_port' => 465,
    'smtp_user' => 'admin@ecosystemeimmo.fr',
    'smtp_pass' => '0785611700Fd!', // ⚠️ À déplacer dans un fichier .env en production
    'from_email' => 'admin@ecosystemeimmo.fr',
    'from_name' => 'ÉCOSYSTÈME IMMO LOCAL+',
    'to_email' => 'admin@ecosystemeimmo.fr',
    'crm_url' => 'https://ecosystemeimmo.fr/admin-crm.html'
];

// ============================================
// GET FORM DATA
// ============================================
$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!$data) {
    // Try form data
    $data = $_POST;
}

if (empty($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'No data received']);
    exit();
}

// ============================================
// PREPARE EMAIL CONTENT
// ============================================
$source = $data['source'] ?? 'unknown';
$timestamp = date('d/m/Y H:i:s');

// Subject based on source
$subjects = [
    'demo' => '🎬 Nouvelle demande de DÉMO',
    'devis' => '💰 Nouvelle demande de DEVIS',
    'download_neuropersona' => '📘 Téléchargement Guide NeuroPersona',
    'download_seo-local' => '🔍 Téléchargement Guide SEO Local',
    'download_methode-mere' => '✍️ Téléchargement Méthode MERE',
    'download_offre' => '📄 Téléchargement Offre PDF',
    'newsletter' => '📬 Nouvelle inscription Newsletter',
    'contact' => '✉️ Nouveau message de contact'
];

$subject = $subjects[$source] ?? '📩 Nouveau lead ÉCOSYSTÈME IMMO';

// Build email body
$emailBody = buildEmailBody($data, $source, $timestamp, $config['crm_url']);

// ============================================
// SEND EMAIL
// ============================================
$result = sendEmail($config, $subject, $emailBody);

if ($result['success']) {
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $result['error']]);
}

// ============================================
// FUNCTIONS
// ============================================

function buildEmailBody($data, $source, $timestamp, $crmUrl) {
    $sourceLabels = [
        'demo' => 'Demande de Démo',
        'devis' => 'Demande de Devis',
        'download_neuropersona' => 'Téléchargement Guide NeuroPersona',
        'download_seo-local' => 'Téléchargement Guide SEO Local',
        'download_methode-mere' => 'Téléchargement Méthode MERE',
        'download_offre' => 'Téléchargement Offre PDF',
        'newsletter' => 'Inscription Newsletter',
        'contact' => 'Message de Contact'
    ];
    
    $sourceLabel = $sourceLabels[$source] ?? $source;
    
    // Extract data
    $firstname = htmlspecialchars($data['firstname'] ?? '-');
    $lastname = htmlspecialchars($data['lastname'] ?? '-');
    $email = htmlspecialchars($data['email'] ?? '-');
    $phone = htmlspecialchars($data['phone'] ?? '-');
    $city = htmlspecialchars($data['city'] ?? '-');
    $activity = htmlspecialchars($data['activity'] ?? '-');
    $formula = htmlspecialchars($data['formula'] ?? '-');
    $message = htmlspecialchars($data['message'] ?? '-');
    $page = htmlspecialchars($data['page'] ?? '-');
    
    // HTML Email Template
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        
                        <!-- Header -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;">
                                <h1 style="color: #ffffff; margin: 0; font-size: 24px;">🏠 ÉCOSYSTÈME IMMO LOCAL+</h1>
                                <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 14px;">Nouveau Lead Capturé</p>
                            </td>
                        </tr>
                        
                        <!-- Source Badge -->
                        <tr>
                            <td style="padding: 25px 30px 15px 30px; text-align: center;">
                                <span style="display: inline-block; background-color: #667eea; color: #ffffff; padding: 8px 20px; border-radius: 50px; font-size: 14px; font-weight: bold;">
                                    ' . $sourceLabel . '
                                </span>
                                <p style="color: #888; margin: 15px 0 0 0; font-size: 13px;">
                                    📅 ' . $timestamp . '
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Contact Info -->
                        <tr>
                            <td style="padding: 15px 30px;">
                                <table width="100%" cellpadding="10" cellspacing="0" style="background-color: #f8f9fa; border-radius: 8px;">
                                    <tr>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #666; font-size: 13px; width: 120px;">👤 Prénom</td>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #333; font-weight: bold;">' . $firstname . '</td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #666; font-size: 13px;">👤 Nom</td>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #333; font-weight: bold;">' . $lastname . '</td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #666; font-size: 13px;">📧 Email</td>
                                        <td style="border-bottom: 1px solid #e9ecef;">
                                            <a href="mailto:' . $email . '" style="color: #667eea; text-decoration: none; font-weight: bold;">' . $email . '</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #666; font-size: 13px;">📱 Téléphone</td>
                                        <td style="border-bottom: 1px solid #e9ecef;">
                                            <a href="tel:' . $phone . '" style="color: #667eea; text-decoration: none; font-weight: bold;">' . $phone . '</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #666; font-size: 13px;">📍 Ville</td>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #333; font-weight: bold;">' . $city . '</td>
                                    </tr>';
    
    // Add activity if present
    if ($activity !== '-') {
        $html .= '
                                    <tr>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #666; font-size: 13px;">💼 Activité</td>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #333;">' . $activity . '</td>
                                    </tr>';
    }
    
    // Add formula if present
    if ($formula !== '-') {
        $html .= '
                                    <tr>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #666; font-size: 13px;">📦 Formule</td>
                                        <td style="border-bottom: 1px solid #e9ecef; color: #333;">' . $formula . '</td>
                                    </tr>';
    }
    
    // Add message if present
    if ($message !== '-') {
        $html .= '
                                    <tr>
                                        <td style="color: #666; font-size: 13px; vertical-align: top;">💬 Message</td>
                                        <td style="color: #333;">' . nl2br($message) . '</td>
                                    </tr>';
    }
    
    $html .= '
                                </table>
                            </td>
                        </tr>
                        
                        <!-- CTA Button -->
                        <tr>
                            <td style="padding: 25px 30px; text-align: center;">
                                <a href="' . $crmUrl . '" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 15px 40px; border-radius: 50px; font-weight: bold; font-size: 16px;">
                                    📊 Voir dans le CRM
                                </a>
                            </td>
                        </tr>
                        
                        <!-- Page Info -->
                        <tr>
                            <td style="padding: 0 30px 20px 30px; text-align: center;">
                                <p style="color: #aaa; font-size: 12px; margin: 0;">
                                    Page source : ' . $page . '
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="background-color: #2c3e50; padding: 20px 30px; text-align: center;">
                                <p style="color: rgba(255,255,255,0.7); margin: 0; font-size: 12px;">
                                    ÉCOSYSTÈME IMMO LOCAL+ — 1 Conseiller = 1 Territoire
                                </p>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';
    
    return $html;
}

function sendEmail($config, $subject, $htmlBody) {
    // Use PHPMailer if available, otherwise use native mail with SMTP
    
    // Try using PHP's native mail with custom headers
    // For O2Switch, we'll use fsockopen for SMTP
    
    try {
        $socket = fsockopen('ssl://' . $config['smtp_host'], $config['smtp_port'], $errno, $errstr, 30);
        
        if (!$socket) {
            throw new Exception("Connection failed: $errstr ($errno)");
        }
        
        // Read greeting
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) !== '220') {
            throw new Exception("Invalid greeting: $response");
        }
        
        // EHLO
        fwrite($socket, "EHLO " . $config['smtp_host'] . "\r\n");
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) === ' ') break;
        }
        
        // AUTH LOGIN
        fwrite($socket, "AUTH LOGIN\r\n");
        fgets($socket, 515);
        
        // Username
        fwrite($socket, base64_encode($config['smtp_user']) . "\r\n");
        fgets($socket, 515);
        
        // Password
        fwrite($socket, base64_encode($config['smtp_pass']) . "\r\n");
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) !== '235') {
            throw new Exception("Authentication failed: $response");
        }
        
        // MAIL FROM
        fwrite($socket, "MAIL FROM:<" . $config['from_email'] . ">\r\n");
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) !== '250') {
            throw new Exception("MAIL FROM failed: $response");
        }
        
        // RCPT TO
        fwrite($socket, "RCPT TO:<" . $config['to_email'] . ">\r\n");
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) !== '250') {
            throw new Exception("RCPT TO failed: $response");
        }
        
        // DATA
        fwrite($socket, "DATA\r\n");
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) !== '354') {
            throw new Exception("DATA failed: $response");
        }
        
        // Headers and body
        $headers = "From: " . $config['from_name'] . " <" . $config['from_email'] . ">\r\n";
        $headers .= "To: " . $config['to_email'] . "\r\n";
        $headers .= "Subject: " . $subject . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "Date: " . date('r') . "\r\n";
        $headers .= "\r\n";
        
        fwrite($socket, $headers . $htmlBody . "\r\n.\r\n");
        $response = fgets($socket, 515);
        if (substr($response, 0, 3) !== '250') {
            throw new Exception("Message send failed: $response");
        }
        
        // QUIT
        fwrite($socket, "QUIT\r\n");
        fclose($socket);
        
        return ['success' => true];
        
    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

?>