<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - CRON Email Automation
 * 
 * Exécution : toutes les 15 minutes via CRON
 * Commande : /usr/bin/php /home/tasq5564/public_html/cron/send-emails.php
 * 
 * Ce script :
 * 1. Récupère les emails programmés (next_send_at <= NOW)
 * 2. Personnalise le contenu
 * 3. Ajoute le tracking
 * 4. Envoie via SMTP ou mail()
 * 5. Programme l'étape suivante
 */

// Empêcher l'exécution via navigateur
if (php_sapi_name() !== 'cli' && !defined('CRON_ALLOWED')) {
    header('HTTP/1.0 403 Forbidden');
    exit('Accès interdit');
}

// Configuration
define('MAX_EMAILS_PER_RUN', 20); // Limite par exécution
define('LOG_FILE', __DIR__ . '/email_cron.log');

// Charger la config database et EmailSender (pour les checks bounce/prefs)
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(dirname(__DIR__)) . '/includes/EmailSender.php';

// Fonction de log
function logMessage($message, $type = 'INFO') {
    $timestamp = date('Y-m-d H:i:s');
    $logLine = "[$timestamp] [$type] $message\n";
    file_put_contents(LOG_FILE, $logLine, FILE_APPEND | LOCK_EX);
    if (php_sapi_name() === 'cli') {
        echo $logLine;
    }
}

// Démarrage
logMessage("=== Démarrage du CRON Email ===");

try {
    // Vérifier que les tables existent
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'email_subscriptions'");
    if ($tableCheck->rowCount() === 0) {
        logMessage("Tables email non trouvées. Exécutez email_automation.sql", 'ERROR');
        exit(1);
    }
    
    // Récupérer les paramètres SMTP
    $settings = [];
    $settingsQuery = $pdo->query("SELECT setting_key, setting_value FROM email_settings");
    while ($row = $settingsQuery->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    // Vérifier les heures d'envoi autorisées
    $currentHour = (int)date('H');
    $sendHourStart = isset($settings['send_hour_start']) ? (int)$settings['send_hour_start'] : 9;
    $sendHourEnd = isset($settings['send_hour_end']) ? (int)$settings['send_hour_end'] : 19;
    
    if ($currentHour < $sendHourStart || $currentHour >= $sendHourEnd) {
        logMessage("Heure actuelle ($currentHour h) hors plage d'envoi ($sendHourStart h - $sendHourEnd h)");
        exit(0);
    }
    
    // Récupérer les emails à envoyer
    $query = $pdo->prepare("
        SELECT 
            sub.id as subscription_id,
            sub.lead_id,
            sub.sequence_id,
            sub.current_step,
            l.firstname,
            l.email,
            l.resource as lead_resource,
            l.city,
            seq.name as sequence_name,
            step.id as step_id,
            step.step_order,
            step.subject,
            step.body_html,
            step.body_text,
            step.cta_text,
            step.cta_url,
            step.cta_type
        FROM email_subscriptions sub
        JOIN leads l ON sub.lead_id = l.id
        JOIN email_sequences seq ON sub.sequence_id = seq.id
        JOIN email_sequence_steps step ON step.sequence_id = seq.id 
            AND step.step_order = sub.current_step + 1
        WHERE sub.status = 'active'
            AND sub.next_send_at <= NOW()
            AND step.is_active = 1
            AND seq.is_active = 1
        ORDER BY sub.next_send_at ASC
        LIMIT :limit
    ");
    $query->bindValue(':limit', MAX_EMAILS_PER_RUN, PDO::PARAM_INT);
    $query->execute();
    $emailsToSend = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $count = count($emailsToSend);
    logMessage("$count email(s) à envoyer");
    
    if ($count === 0) {
        logMessage("=== Fin du CRON (rien à envoyer) ===");
        exit(0);
    }
    
    // Traiter chaque email
    $sent = 0;
    $failed = 0;
    
    foreach ($emailsToSend as $emailData) {
        try {
            logMessage("Traitement: {$emailData['email']} - Séquence: {$emailData['sequence_name']} - Étape {$emailData['step_order']}");

            // Vérifier bounces et préférences avant envoi
            if (!canSendEmail($pdo, $emailData['email'])) {
                logMessage("⊘ Email bloqué (bounce/prefs) pour {$emailData['email']}", 'SKIP');
                continue;
            }

            // Vérifier fréquence hebdo
            $prefStmt = $pdo->prepare("SELECT frequency FROM email_preferences WHERE email = ? LIMIT 1");
            $prefStmt->execute([$emailData['email']]);
            $emailPref = $prefStmt->fetch(PDO::FETCH_ASSOC);
            if ($emailPref && $emailPref['frequency'] === 'weekly' && hasReceivedEmailThisWeek($pdo, $emailData['email'])) {
                logMessage("⊘ Email différé (fréquence hebdo) pour {$emailData['email']}", 'SKIP');
                // Reporter à dans 7 jours
                $nextWeek = date('Y-m-d H:i:s', strtotime('+7 days'));
                $pdo->prepare("UPDATE email_subscriptions SET next_send_at = ? WHERE id = ?")->execute([$nextWeek, $emailData['subscription_id']]);
                continue;
            }

            // Personnaliser le contenu
            $subject = personalizeContent($emailData['subject'], $emailData);
            $bodyHtml = personalizeContent($emailData['body_html'], $emailData);
            
            // Générer les tokens de tracking
            $openToken = generateToken();
            $clickToken = !empty($emailData['cta_url']) ? generateToken() : null;
            
            // Ajouter le pixel de tracking
            $trackingPixel = '<img src="https://ecosystemeimmo.fr/track.php?t=' . $openToken . '&a=open" width="1" height="1" style="display:none" alt="">';
            
            // Ajouter le CTA avec tracking
            if (!empty($emailData['cta_text']) && !empty($emailData['cta_url'])) {
                $trackedUrl = 'https://ecosystemeimmo.fr/track.php?t=' . $clickToken . '&a=click';
                $ctaHtml = '<p style="text-align:center; margin: 30px 0;">
                    <a href="' . $trackedUrl . '" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block;">' . htmlspecialchars($emailData['cta_text']) . '</a>
                </p>';
                $bodyHtml .= $ctaHtml;
            }
            
            // Générer token de préférences
            $prefsToken = getPreferencesToken($pdo, $emailData['email']);
            $prefsUrl = 'https://ecosystemeimmo.fr/preferences-email.php?e=' . urlencode(base64_encode($emailData['email'])) . '&t=' . urlencode($prefsToken);
            $unsubscribeUrl = 'https://ecosystemeimmo.fr/unsubscribe.php?e=' . urlencode(base64_encode($emailData['email'])) . '&s=' . $emailData['subscription_id'];

            // Ajouter le footer avec préférences et désinscription
            $footer = '<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">
                <p style="font-size: 12px; color: #6b7280; text-align: center;">
                    Vous recevez cet email car vous avez téléchargé une ressource sur ÉCOSYSTÈME IMMO LOCAL+.<br>
                    <a href="' . $prefsUrl . '" style="color: #6b7280;">Gérer mes préférences</a> |
                    <a href="' . $unsubscribeUrl . '" style="color: #6b7280;">Se désinscrire</a>
                </p>';
            
            // Wrapper les liens pour le tracking des clics
            $bodyHtml = wrapLinksForTracking($bodyHtml, $openToken);

            // Assembler l'email HTML complet
            $fullHtml = buildEmailTemplate($subject, $bodyHtml . $footer . $trackingPixel, $settings);
            
            // Envoyer l'email
            $fromEmail = isset($settings['from_email']) ? $settings['from_email'] : 'contact@ecosystemeimmo.fr';
            $fromName = isset($settings['from_name']) ? $settings['from_name'] : 'ÉCOSYSTÈME IMMO LOCAL+';
            
            $sendResult = sendEmail(
                $emailData['email'],
                $subject,
                $fullHtml,
                $fromEmail,
                $fromName,
                $settings
            );
            
            if ($sendResult['success']) {
                // Enregistrer dans email_sent
                $insertSent = $pdo->prepare("
                    INSERT INTO email_sent (subscription_id, step_id, lead_id, email_to, subject, status)
                    VALUES (?, ?, ?, ?, ?, 'sent')
                ");
                $insertSent->execute([
                    $emailData['subscription_id'],
                    $emailData['step_id'],
                    $emailData['lead_id'],
                    $emailData['email'],
                    $subject
                ]);
                $emailSentId = $pdo->lastInsertId();
                
                // Enregistrer les tokens de tracking
                $insertToken = $pdo->prepare("
                    INSERT INTO email_tracking_tokens (token, email_sent_id, token_type, target_url)
                    VALUES (?, ?, ?, ?)
                ");
                $insertToken->execute([$openToken, $emailSentId, 'open', null]);
                
                if ($clickToken) {
                    $insertToken->execute([$clickToken, $emailSentId, 'click', $emailData['cta_url']]);
                }
                
                // Mettre à jour la subscription
                $nextStep = $emailData['step_order'];
                
                // Vérifier s'il y a une étape suivante
                $checkNext = $pdo->prepare("
                    SELECT delay_days, delay_hours 
                    FROM email_sequence_steps 
                    WHERE sequence_id = ? AND step_order = ? AND is_active = 1
                ");
                $checkNext->execute([$emailData['sequence_id'], $nextStep + 1]);
                $nextStepData = $checkNext->fetch(PDO::FETCH_ASSOC);
                
                if ($nextStepData) {
                    // Programmer la prochaine étape
                    $nextSendAt = date('Y-m-d H:i:s', strtotime("+{$nextStepData['delay_days']} days +{$nextStepData['delay_hours']} hours"));
                    $updateSub = $pdo->prepare("
                        UPDATE email_subscriptions 
                        SET current_step = ?, next_send_at = ?
                        WHERE id = ?
                    ");
                    $updateSub->execute([$nextStep, $nextSendAt, $emailData['subscription_id']]);
                } else {
                    // Séquence terminée
                    $updateSub = $pdo->prepare("
                        UPDATE email_subscriptions 
                        SET current_step = ?, status = 'completed', completed_at = NOW(), next_send_at = NULL
                        WHERE id = ?
                    ");
                    $updateSub->execute([$nextStep, $emailData['subscription_id']]);
                }
                
                $sent++;
                logMessage("✓ Email envoyé à {$emailData['email']}", 'SUCCESS');
                
            } else {
                // Enregistrer l'échec
                $insertSent = $pdo->prepare("
                    INSERT INTO email_sent (subscription_id, step_id, lead_id, email_to, subject, status, error_message)
                    VALUES (?, ?, ?, ?, ?, 'failed', ?)
                ");
                $insertSent->execute([
                    $emailData['subscription_id'],
                    $emailData['step_id'],
                    $emailData['lead_id'],
                    $emailData['email'],
                    $subject,
                    $sendResult['error']
                ]);
                
                $failed++;
                logMessage("✗ Échec envoi à {$emailData['email']}: {$sendResult['error']}", 'ERROR');
            }
            
            // Petite pause entre les envois
            usleep(500000); // 0.5 seconde
            
        } catch (Exception $e) {
            $failed++;
            logMessage("✗ Exception pour {$emailData['email']}: " . $e->getMessage(), 'ERROR');
        }
    }
    
    logMessage("=== Fin du CRON: $sent envoyé(s), $failed échec(s) ===");
    
} catch (Exception $e) {
    logMessage("Erreur fatale: " . $e->getMessage(), 'FATAL');
    exit(1);
}

// =====================================================
// FONCTIONS
// =====================================================

/**
 * Personnaliser le contenu avec les variables
 */
function personalizeContent($content, $data) {
    $replacements = [
        '{{firstname}}' => !empty($data['firstname']) ? htmlspecialchars($data['firstname']) : 'there',
        '{{prenom}}' => !empty($data['firstname']) ? htmlspecialchars($data['firstname']) : 'there',
        '{{email}}' => htmlspecialchars($data['email']),
        '{{resource}}' => !empty($data['lead_resource']) ? htmlspecialchars($data['lead_resource']) : 'notre ressource',
        '{{ressource}}' => !empty($data['lead_resource']) ? htmlspecialchars($data['lead_resource']) : 'notre ressource',
        '{{city}}' => !empty($data['city']) ? htmlspecialchars($data['city']) : 'votre ville',
        '{{ville}}' => !empty($data['city']) ? htmlspecialchars($data['city']) : 'votre ville',
        '{{sequence}}' => !empty($data['sequence_name']) ? htmlspecialchars($data['sequence_name']) : '',
    ];
    
    return str_replace(array_keys($replacements), array_values($replacements), $content);
}

/**
 * Générer un token unique pour le tracking
 */
function generateToken() {
    return bin2hex(random_bytes(32));
}

/**
 * Construire le template HTML de l'email
 */
function buildEmailTemplate($subject, $bodyContent, $settings) {
    $fromName = isset($settings['from_name']) ? htmlspecialchars($settings['from_name']) : 'ÉCOSYSTÈME IMMO LOCAL+';
    
    return '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($subject) . '</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f3f4f6;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 30px 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px 12px 0 0;">
                            <h1 style="margin: 0; color: white; font-size: 24px; font-weight: 700;">' . $fromName . '</h1>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px; color: #374151; font-size: 16px; line-height: 1.6;">
                            ' . $bodyContent . '
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
}

/**
 * Envoyer l'email via SMTP ou mail()
 */
function sendEmail($to, $subject, $htmlBody, $fromEmail, $fromName, $settings) {
    // Vérifier si SMTP est configuré
    $smtpHost = isset($settings['smtp_host']) ? $settings['smtp_host'] : '';
    $smtpUser = isset($settings['smtp_user']) ? $settings['smtp_user'] : '';
    $smtpPass = isset($settings['smtp_pass']) ? $settings['smtp_pass'] : '';
    
    // Si SMTP configuré et PHPMailer disponible, utiliser SMTP
    if (!empty($smtpHost) && !empty($smtpUser) && !empty($smtpPass)) {
        // Vérifier si PHPMailer est installé
        $phpmailerPath = dirname(__DIR__) . '/vendor/autoload.php';
        if (file_exists($phpmailerPath)) {
            require_once $phpmailerPath;
            return sendViaSMTP($to, $subject, $htmlBody, $fromEmail, $fromName, $settings);
        }
    }
    
    // Fallback: utiliser mail() natif PHP
    return sendViaMail($to, $subject, $htmlBody, $fromEmail, $fromName);
}

/**
 * Envoyer via la fonction mail() native
 */
function sendViaMail($to, $subject, $htmlBody, $fromEmail, $fromName) {
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $fromName . ' <' . $fromEmail . '>',
        'Reply-To: ' . $fromEmail,
        'X-Mailer: PHP/' . phpversion()
    ];
    
    $result = @mail($to, $subject, $htmlBody, implode("\r\n", $headers));
    
    if ($result) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => 'Fonction mail() a échoué'];
    }
}

/**
 * Envoyer via PHPMailer SMTP
 */
function sendViaSMTP($to, $subject, $htmlBody, $fromEmail, $fromName, $settings) {
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = $settings['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $settings['smtp_user'];
        $mail->Password = $settings['smtp_pass'];
        $mail->SMTPSecure = isset($settings['smtp_secure']) ? $settings['smtp_secure'] : 'tls';
        $mail->Port = isset($settings['smtp_port']) ? (int)$settings['smtp_port'] : 587;
        $mail->CharSet = 'UTF-8';
        
        // Destinataires
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to);
        
        if (!empty($settings['reply_to'])) {
            $mail->addReplyTo($settings['reply_to']);
        }
        
        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlBody));
        
        $mail->send();
        return ['success' => true];
        
    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}