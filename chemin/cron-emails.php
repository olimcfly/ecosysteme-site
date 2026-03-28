<?php
/**
 * CRON : Envoi des emails de séquence
 * À exécuter toutes les 15 minutes
 * Commande : php /chemin/cron-emails.php
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/EmailSender.php';

// 1. Récupérer les leads avec email à envoyer
$stmt = $pdo->prepare("
    SELECT l.*, es.slug as sequence_slug, est.subject, est.body_html, est.body_text, est.step_number, est.delay_hours
    FROM leads l
    JOIN email_sequences es ON l.current_sequence_id = es.id
    JOIN email_steps est ON est.sequence_id = es.id AND est.step_number = l.current_step + 1
    WHERE l.next_email_at <= NOW()
      AND l.call_booked_at IS NULL
      AND l.sequence_paused = 0
      AND l.current_sequence_id IS NOT NULL
      AND es.is_active = 1
    LIMIT 50
");
$stmt->execute();
$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($leads as $lead) {
    // 2. Vérifier encore une fois que pas d'appel réservé (sécurité)
    if (!empty($lead['call_booked_at'])) {
        stopSequence($pdo, $lead['id'], 'call_booked');
        continue;
    }
    
    // 3. Envoyer l'email
    $sent = sendEmail($lead['email'], $lead['subject'], $lead['body_html'], $lead['firstname']);
    
    if ($sent) {
        // 4. Logger l'envoi
        logEmail($pdo, $lead['id'], $lead['current_sequence_id'], $lead['step_number']);
        
        // 5. Calculer prochain email
        $nextStep = getNextStep($pdo, $lead['current_sequence_id'], $lead['step_number']);
        
        if ($nextStep) {
            // Prochain email prévu
            $nextAt = date('Y-m-d H:i:s', strtotime('+' . $nextStep['delay_hours'] . ' hours'));
            updateLeadSequence($pdo, $lead['id'], $lead['step_number'], $nextAt);
        } else {
            // Séquence terminée
            completeSequence($pdo, $lead['id']);
        }
    }
}
```

---

## 4. PARCOURS LEAD → APPEL

### Scénario complet
```
1. ENTRÉE
   Visiteur remplit formulaire "Diagnostic vendeur bloqué"
   → INSERT leads (type='diagnostic', intent='diagnostic', status='nouveau')
   → INSERT lead_downloads
   → INSERT lead_events (event_type='created')

2. DÉCLENCHEMENT SÉQUENCE
   → Chercher séquence WHERE trigger_intent = 'diagnostic'
   → UPDATE leads SET current_sequence_id = X, sequence_started_at = NOW(), current_step = 0
   → Envoyer email step 1 immédiatement
   → UPDATE leads SET current_step = 1, last_email_sent_at = NOW(), next_email_at = NOW + delay_step_2
   → INSERT lead_events (event_type='sequence_started')
   → INSERT email_logs

3. CRON (15 min)
   → Pour chaque lead avec next_email_at <= NOW
   → Envoyer email step N
   → Mettre à jour current_step, next_email_at

4. APPEL RÉSERVÉ (action admin)
   → Admin clique "Appel réservé" sur fiche lead
   → UPDATE leads SET call_booked_at = NOW(), intent = 'call_booked', status = 'appel_reserve', current_sequence_id = NULL
   → INSERT lead_events (event_type='call_booked')
   → Lead apparaît dans "À appeler"

5. POST-APPEL
   → Admin change status : 'client' ou 'inactif'
   → UPDATE leads SET intent = 'client', status = 'client'