<?php
/**
 * ÉCOSYSTÈME IMMO+ - EmailSender
 * Fonctions pour l'envoi et la gestion des séquences email
 * CRM v2.5
 */

require_once __DIR__ . '/../admin/config/admin-config.php';

// ============================================
// VÉRIFICATIONS PRÉ-ENVOI (Bounces & Préférences)
// ============================================

/**
 * Vérifier si un email est dans la liste des bounces
 */
function isEmailBounced($pdo, $email) {
    $stmt = $pdo->prepare("SELECT id, type FROM email_bounces WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Vérifier les préférences email d'un utilisateur
 * Retourne false si l'envoi est bloqué, true si autorisé
 */
function canSendEmail($pdo, $email) {
    // Vérifier bounces
    $bounce = isEmailBounced($pdo, $email);
    if ($bounce && $bounce['type'] === 'hard') {
        if (DEBUG_MODE) {
            error_log("EmailSender: Email bloqué (hard bounce) pour $email");
        }
        return false;
    }

    // Vérifier préférences
    $stmt = $pdo->prepare("SELECT frequency, unsubscribed FROM email_preferences WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $prefs = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($prefs) {
        if ($prefs['unsubscribed']) {
            if (DEBUG_MODE) {
                error_log("EmailSender: Email bloqué (désinscrit) pour $email");
            }
            return false;
        }
        if ($prefs['frequency'] === 'never') {
            if (DEBUG_MODE) {
                error_log("EmailSender: Email bloqué (fréquence: jamais) pour $email");
            }
            return false;
        }
    }

    return true;
}

/**
 * Générer ou récupérer le token de préférences pour un email
 */
function getPreferencesToken($pdo, $email) {
    $stmt = $pdo->prepare("SELECT token FROM email_preferences WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return $row['token'];
    }

    // Créer une entrée par défaut
    $token = bin2hex(random_bytes(32));
    $stmt = $pdo->prepare("INSERT INTO email_preferences (email, frequency, unsubscribed, token, updated_at) VALUES (?, 'all', 0, ?, NOW())");
    $stmt->execute([$email, $token]);
    return $token;
}

/**
 * Wrapper les liens dans un email pour le tracking des clics
 */
function wrapLinksForTracking($html, $trackingId) {
    return preg_replace_callback(
        '/<a\s+([^>]*?)href=["\']([^"\']+)["\']([^>]*?)>/i',
        function ($matches) use ($trackingId) {
            $before = $matches[1];
            $url = $matches[2];
            $after = $matches[3];

            // Ne pas tracker les liens de désinscription, préférences ou tracking
            if (strpos($url, 'unsubscribe') !== false
                || strpos($url, 'preferences-email') !== false
                || strpos($url, 'track-click') !== false
                || strpos($url, 'track.php') !== false
                || strpos($url, 'mailto:') === 0
                || strpos($url, '#') === 0) {
                return $matches[0];
            }

            $trackedUrl = SITE_URL . '/api/track-click.php?id=' . urlencode($trackingId) . '&url=' . urlencode($url);
            return '<a ' . $before . 'href="' . htmlspecialchars($trackedUrl) . '"' . $after . '>';
        },
        $html
    );
}

// ============================================
// ENVOI D'EMAIL
// ============================================

/**
 * Envoyer un email avec personnalisation
 */
function sendEmail($to, $subject, $bodyHtml, $firstname = '', $bodyText = null) {
    // Personnalisation
    $replacements = [
        '{{prenom}}' => $firstname ?: 'there',
        '{{firstname}}' => $firstname ?: 'there',
        '{{lien_calendly}}' => CALENDLY_LINK,
        '{{calendly}}' => CALENDLY_LINK,
        '{{site_name}}' => SITE_NAME,
        '{{site_url}}' => SITE_URL,
    ];
    
    $subject = str_replace(array_keys($replacements), array_values($replacements), $subject);
    $bodyHtml = str_replace(array_keys($replacements), array_values($replacements), $bodyHtml);
    
    if ($bodyText) {
        $bodyText = str_replace(array_keys($replacements), array_values($replacements), $bodyText);
    }
    
    // Construction email HTML
    $htmlMessage = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    ' . $bodyHtml . '
</body>
</html>';
    
    // Headers
    $headers = [
        'From: ' . EMAIL_FROM_NAME . ' <' . EMAIL_FROM . '>',
        'Reply-To: ' . EMAIL_REPLY_TO,
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'X-Mailer: PHP/' . phpversion()
    ];
    
    // Envoi
    $sent = mail($to, $subject, $htmlMessage, implode("\r\n", $headers));
    
    if (DEBUG_MODE && !$sent) {
        error_log("EmailSender: Échec envoi email à $to - Sujet: $subject");
    }
    
    return $sent;
}

// ============================================
// GESTION DES SÉQUENCES
// ============================================

/**
 * Démarrer une séquence pour un lead
 */
function startSequence($pdo, $leadId, $intent) {
    // Trouver la séquence correspondant à l'intent
    $stmt = $pdo->prepare("
        SELECT * FROM email_sequences 
        WHERE trigger_intent = ? AND is_active = 1 
        ORDER BY priority ASC 
        LIMIT 1
    ");
    $stmt->execute([$intent]);
    $sequence = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$sequence) {
        return false; // Pas de séquence pour cet intent
    }
    
    // Récupérer le premier step
    $stmt = $pdo->prepare("
        SELECT * FROM email_steps 
        WHERE sequence_id = ? AND step_number = 1 AND is_active = 1
    ");
    $stmt->execute([$sequence['id']]);
    $firstStep = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$firstStep) {
        return false; // Pas de premier step
    }
    
    // Récupérer les infos du lead
    $stmt = $pdo->prepare("SELECT * FROM leads WHERE id = ?");
    $stmt->execute([$leadId]);
    $lead = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$lead) {
        return false;
    }

    // Vérifier bounces et préférences avant envoi
    if (!canSendEmail($pdo, $lead['email'])) {
        logEvent($pdo, $leadId, 'email_blocked', [
            'reason' => 'bounce_or_preference',
            'email' => $lead['email']
        ]);
        return false;
    }

    // Envoyer le premier email immédiatement
    $sent = sendEmail(
        $lead['email'],
        $firstStep['subject'],
        $firstStep['body_html'],
        $lead['firstname'],
        $firstStep['body_text']
    );
    
    if (!$sent) {
        return false;
    }
    
    // Calculer le prochain email
    $nextStep = getNextStep($pdo, $sequence['id'], 1);
    $nextEmailAt = null;
    
    if ($nextStep) {
        $nextEmailAt = date('Y-m-d H:i:s', strtotime('+' . $nextStep['delay_hours'] . ' hours'));
    }
    
    // Mettre à jour le lead
    $stmt = $pdo->prepare("
        UPDATE leads SET 
            current_sequence_id = ?,
            sequence_started_at = NOW(),
            current_step = 1,
            last_email_sent_at = NOW(),
            next_email_at = ?,
            sequence_paused = 0,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$sequence['id'], $nextEmailAt, $leadId]);
    
    // Logger l'email envoyé
    logEmail($pdo, $leadId, $sequence['id'], $firstStep['id'], 1, $firstStep['subject']);
    
    // Logger l'événement
    logEvent($pdo, $leadId, 'sequence_started', [
        'sequence_id' => $sequence['id'],
        'sequence_name' => $sequence['name']
    ]);
    
    return true;
}

/**
 * Arrêter une séquence
 */
function stopSequence($pdo, $leadId, $reason = 'manual') {
    // Récupérer infos actuelles
    $stmt = $pdo->prepare("SELECT current_sequence_id FROM leads WHERE id = ?");
    $stmt->execute([$leadId]);
    $lead = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Mettre à jour
    $stmt = $pdo->prepare("
        UPDATE leads SET 
            current_sequence_id = NULL,
            next_email_at = NULL,
            sequence_paused = 0,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$leadId]);
    
    // Logger
    logEvent($pdo, $leadId, 'sequence_stopped', [
        'reason' => $reason,
        'previous_sequence_id' => $lead['current_sequence_id'] ?? null
    ]);
    
    return true;
}

/**
 * Mettre en pause une séquence
 */
function pauseSequence($pdo, $leadId) {
    $stmt = $pdo->prepare("
        UPDATE leads SET sequence_paused = 1, updated_at = NOW() WHERE id = ?
    ");
    $stmt->execute([$leadId]);
    
    logEvent($pdo, $leadId, 'sequence_paused');
    
    return true;
}

/**
 * Reprendre une séquence
 */
function resumeSequence($pdo, $leadId) {
    // Recalculer next_email_at depuis maintenant
    $stmt = $pdo->prepare("
        SELECT l.*, est.delay_hours 
        FROM leads l
        JOIN email_steps est ON est.sequence_id = l.current_sequence_id 
            AND est.step_number = l.current_step + 1
        WHERE l.id = ?
    ");
    $stmt->execute([$leadId]);
    $lead = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($lead && isset($lead['delay_hours'])) {
        $nextEmailAt = date('Y-m-d H:i:s', strtotime('+' . $lead['delay_hours'] . ' hours'));
    } else {
        $nextEmailAt = null;
    }
    
    $stmt = $pdo->prepare("
        UPDATE leads SET 
            sequence_paused = 0, 
            next_email_at = ?,
            updated_at = NOW() 
        WHERE id = ?
    ");
    $stmt->execute([$nextEmailAt, $leadId]);
    
    logEvent($pdo, $leadId, 'sequence_resumed');
    
    return true;
}

/**
 * Marquer une séquence comme terminée
 */
function completeSequence($pdo, $leadId) {
    $stmt = $pdo->prepare("
        UPDATE leads SET 
            current_sequence_id = NULL,
            next_email_at = NULL,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$leadId]);
    
    logEvent($pdo, $leadId, 'sequence_completed');
    
    return true;
}

/**
 * Mettre à jour le lead après envoi d'un email
 */
function updateLeadSequence($pdo, $leadId, $currentStep, $nextEmailAt) {
    $stmt = $pdo->prepare("
        UPDATE leads SET 
            current_step = ?,
            last_email_sent_at = NOW(),
            next_email_at = ?,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$currentStep, $nextEmailAt, $leadId]);
    
    return true;
}

// ============================================
// HELPERS
// ============================================

/**
 * Récupérer le prochain step d'une séquence
 */
function getNextStep($pdo, $sequenceId, $currentStepNumber) {
    $stmt = $pdo->prepare("
        SELECT * FROM email_steps 
        WHERE sequence_id = ? 
        AND step_number = ? 
        AND is_active = 1
    ");
    $stmt->execute([$sequenceId, $currentStepNumber + 1]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Déterminer l'intent selon le type et la ressource
 */
function determineIntent($type, $resource = null) {
    // Mapping type → intent
    $typeMap = [
        'demo' => 'demo',
        'diagnostic' => 'diagnostic',
        'outil' => 'outil',
        'ressource' => 'ressource',
        'offre' => 'ressource',
        'newsletter' => 'cold',
        'contact' => 'cold',
    ];
    
    // Mapping ressource spécifique → intent (prioritaire)
$resourceMap = [
    // Diagnostic (intent fort)
    'diagnostic-vendeur' => 'diagnostic',
    'diagnostic-vendeur-bloque' => 'diagnostic',
    
    // Outils (intent moyen-fort)
    'calculateur-roi' => 'outil',
    'audit-visibilite' => 'outil',
    'estimateur' => 'outil',
    
    // Ressources (intent moyen)
    'journal-gmb' => 'ressource',
    'matrice-vendeur' => 'ressource',
    'templates-reponses' => 'ressource',
    'guide-mandats' => 'ressource',
    'checklist' => 'ressource',
    'ebook' => 'ressource',
];
    
    // Priorité à la ressource spécifique
    if ($resource && isset($resourceMap[$resource])) {
        return $resourceMap[$resource];
    }
    
    // Sinon, selon le type
    if ($type && isset($typeMap[$type])) {
        return $typeMap[$type];
    }
    
    return 'cold';
}

/**
 * Calculer le score d'un lead
 */
function calculateScore($intent, $actionsCount = 0) {
    $baseScores = [
        'cold' => 0,
        'ressource' => SCORE_DOWNLOAD_RESSOURCE ?? 10,
        'outil' => SCORE_DOWNLOAD_OUTIL ?? 20,
        'diagnostic' => SCORE_DOWNLOAD_DIAGNOSTIC ?? 30,
        'demo' => SCORE_DEMO_REQUEST ?? 50,
        'call_booked' => SCORE_CALL_BOOKED ?? 100,
        'client' => 150,
    ];
    
    $score = $baseScores[$intent] ?? 0;
    $score += ($actionsCount * 5); // Bonus par action
    
    return $score;
}

// ============================================
// LOGGING
// ============================================

/**
 * Logger un email envoyé
 */
function logEmail($pdo, $leadId, $sequenceId, $stepId, $stepNumber, $subject, $status = 'sent') {
    $trackingId = bin2hex(random_bytes(16));

    $stmt = $pdo->prepare("
        INSERT INTO email_logs
        (lead_id, sequence_id, step_id, step_number, email_type, to_email, subject, status, sent_at, tracking_id, created_at)
        SELECT ?, ?, ?, ?, 'sequence', email, ?, ?, NOW(), ?, NOW()
        FROM leads WHERE id = ?
    ");
    $stmt->execute([
        $leadId,
        $sequenceId,
        $stepId,
        $stepNumber,
        $subject,
        $status,
        $trackingId,
        $leadId
    ]);

    // Logger aussi l'événement
    logEvent($pdo, $leadId, 'email_sent', [
        'step_number' => $stepNumber,
        'subject' => $subject,
        'tracking_id' => $trackingId
    ]);

    return $trackingId;
}

/**
 * Vérifier la fréquence hebdo : a-t-on déjà envoyé un email cette semaine ?
 */
function hasReceivedEmailThisWeek($pdo, $email) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM email_logs
        WHERE to_email = ? AND sent_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND status = 'sent'
    ");
    $stmt->execute([$email]);
    return (int)$stmt->fetchColumn() > 0;
}

/**
 * Logger un événement lead
 */
function logEvent($pdo, $leadId, $eventType, $data = null, $createdBy = 'system') {
    $stmt = $pdo->prepare("
        INSERT INTO lead_events (lead_id, event_type, event_data, created_by, created_at)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->execute([
        $leadId,
        $eventType,
        $data ? json_encode($data) : null,
        $createdBy
    ]);
    
    return $pdo->lastInsertId();
}

// ============================================
// CRÉATION DE LEAD
// ============================================

/**
 * Créer un nouveau lead avec démarrage automatique de séquence
 */
function createLead($pdo, $data, $startSequence = true) {
    $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'error' => 'Email invalide'];
    }
    
    // Vérifier si existe déjà
    $stmt = $pdo->prepare("SELECT id, intent FROM leads WHERE email = ?");
    $stmt->execute([$email]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $type = $data['type'] ?? 'contact';
    $resource = $data['resource'] ?? null;
    $intent = determineIntent($type, $resource);
    $score = calculateScore($intent);
    
    if ($existing) {
        // Lead existe → mettre à jour si intent plus fort
        $intentPriority = ['cold' => 0, 'ressource' => 1, 'outil' => 2, 'diagnostic' => 3, 'demo' => 4];
        
        if (($intentPriority[$intent] ?? 0) > ($intentPriority[$existing['intent']] ?? 0)) {
            $stmt = $pdo->prepare("
                UPDATE leads SET 
                    intent = ?, 
                    score = score + ?,
                    updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$intent, $score, $existing['id']]);
        } else {
            // Juste incrémenter le score
            $stmt = $pdo->prepare("UPDATE leads SET score = score + ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$score, $existing['id']]);
        }
        
        $leadId = $existing['id'];
        $isNew = false;
    } else {
        // Nouveau lead
        $stmt = $pdo->prepare("
            INSERT INTO leads 
            (firstname, lastname, email, phone, city, message, type, resource, source, intent, status, score, ip_address, user_agent, referrer, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'nouveau', ?, ?, ?, ?, NOW(), NOW())
        ");
        $stmt->execute([
            $data['firstname'] ?? null,
            $data['lastname'] ?? null,
            $email,
            $data['phone'] ?? null,
            $data['city'] ?? null,
            $data['message'] ?? null,
            $type,
            $resource,
            $data['source'] ?? null,
            $intent,
            $score,
            $data['ip_address'] ?? $_SERVER['REMOTE_ADDR'] ?? null,
            $data['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? null,
            $data['referrer'] ?? $_SERVER['HTTP_REFERER'] ?? null,
        ]);
        
        $leadId = $pdo->lastInsertId();
        $isNew = true;
        
        // Logger création
        logEvent($pdo, $leadId, 'created', ['type' => $type, 'resource' => $resource, 'intent' => $intent]);
    }
    
    // Logger le téléchargement
    if ($type && $type !== 'contact') {
        $stmt = $pdo->prepare("
            INSERT INTO lead_downloads (lead_id, type, resource, source, ip_address, downloaded_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([
            $leadId,
            $type,
            $resource,
            $data['source'] ?? null,
            $data['ip_address'] ?? $_SERVER['REMOTE_ADDR'] ?? null
        ]);
        
        logEvent($pdo, $leadId, 'download', ['type' => $type, 'resource' => $resource]);
    }
    
    // Démarrer la séquence si nouveau lead et intent éligible
    $sequenceStarted = false;
    if ($startSequence && $isNew && in_array($intent, ['diagnostic', 'demo', 'outil', 'ressource'])) {
        $sequenceStarted = startSequence($pdo, $leadId, $intent);
    }
    
    return [
        'success' => true,
        'lead_id' => $leadId,
        'is_new' => $isNew,
        'intent' => $intent,
        'sequence_started' => $sequenceStarted
    ];
}

/**
 * Marquer un appel comme réservé
 */
function markCallBooked($pdo, $leadId, $adminEmail = 'system') {
    $stmt = $pdo->prepare("
        UPDATE leads SET 
            call_booked_at = NOW(),
            intent = 'call_booked',
            status = 'appel_reserve',
            current_sequence_id = NULL,
            next_email_at = NULL,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$leadId]);
    
    logEvent($pdo, $leadId, 'call_booked', null, $adminEmail);
    
    return true;
}

/**
 * Marquer un appel comme effectué
 */
function markCallCompleted($pdo, $leadId, $newStatus, $notes = null, $adminEmail = 'system') {
    $newIntent = ($newStatus === 'client') ? 'client' : 'call_booked';
    
    $stmt = $pdo->prepare("
        UPDATE leads SET 
            call_completed_at = NOW(),
            call_notes = ?,
            status = ?,
            intent = ?,
            updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$notes, $newStatus, $newIntent, $leadId]);
    
    logEvent($pdo, $leadId, 'call_completed', [
        'status' => $newStatus,
        'notes' => $notes
    ], $adminEmail);
    
    return true;
}