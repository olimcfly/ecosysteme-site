<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Centre de Préférences Email
 *
 * Accessible via lien dans chaque email.
 * URL: preferences-email.php?e=BASE64_EMAIL&t=TOKEN
 *
 * Permet de choisir la fréquence ou se désinscrire.
 */

require_once __DIR__ . '/config/database.php';

$message = '';
$messageType = '';
$showForm = true;
$prefs = null;

// Récupérer les paramètres
$encodedEmail = isset($_GET['e']) ? $_GET['e'] : '';
$token = isset($_GET['t']) ? trim($_GET['t']) : '';
$email = !empty($encodedEmail) ? base64_decode($encodedEmail) : '';

// Valider le token
$tokenValid = false;
if (!empty($email) && !empty($token)) {
 try {
 $stmt = $pdo->prepare("SELECT * FROM email_preferences WHERE email = ? AND token = ? LIMIT 1");
 $stmt->execute([$email, $token]);
 $prefs = $stmt->fetch(PDO::FETCH_ASSOC);
 if ($prefs) {
 $tokenValid = true;
 }
 } catch (Exception $e) {
 // Silencieux
 }
}

// Si pas de token valide mais email valide, on cherche par email seul
if (!$tokenValid && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
 try {
 $stmt = $pdo->prepare("SELECT * FROM email_preferences WHERE email = ? LIMIT 1");
 $stmt->execute([$email]);
 $prefs = $stmt->fetch(PDO::FETCH_ASSOC);
 if ($prefs) {
 $tokenValid = true;
 $token = $prefs['token'];
 }
 } catch (Exception $e) {
 // Silencieux
 }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $postEmail = trim($_POST['email'] ?? '');
 $postToken = trim($_POST['token'] ?? '');
 $action = $_POST['action'] ?? '';

 if (!filter_var($postEmail, FILTER_VALIDATE_EMAIL)) {
 $message = 'Adresse email invalide.';
 $messageType = 'error';
 } else {
 try {
 // Vérifier token
 $stmt = $pdo->prepare("SELECT * FROM email_preferences WHERE email = ? AND token = ? LIMIT 1");
 $stmt->execute([$postEmail, $postToken]);
 $existingPref = $stmt->fetch(PDO::FETCH_ASSOC);

 if (!$existingPref) {
 $message = 'Lien invalide. Veuillez utiliser le lien dans votre email.';
 $messageType = 'error';
 } else {
 if ($action === 'update_frequency') {
 $frequency = $_POST['frequency'] ?? 'all';
 if (!in_array($frequency, ['all', 'weekly', 'never'])) {
 $frequency = 'all';
 }
 $unsubscribed = ($frequency === 'never') ? 1 : 0;

 $stmt = $pdo->prepare("
 UPDATE email_preferences
 SET frequency = ?, unsubscribed = ?, updated_at = NOW()
 WHERE email = ? AND token = ?
 ");
 $stmt->execute([$frequency, $unsubscribed, $postEmail, $postToken]);

 // Si désinscription complète, arrêter les séquences aussi
 if ($unsubscribed) {
 $stmt = $pdo->prepare("
 UPDATE email_subscriptions sub
 JOIN leads l ON sub.lead_id = l.id
 SET sub.status = 'unsubscribed'
 WHERE l.email = ? AND sub.status = 'active'
 ");
 $stmt->execute([$postEmail]);
 }

 $frequencyLabels = [
 'all' => 'Tous les emails',
 'weekly' => 'Hebdomadaire',
 'never' => 'Aucun email (désinscrit)'
 ];

 $message = 'Préférences mises à jour : ' . ($frequencyLabels[$frequency] ?? $frequency);
 $messageType = 'success';

 // Recharger les prefs
 $stmt = $pdo->prepare("SELECT * FROM email_preferences WHERE email = ? LIMIT 1");
 $stmt->execute([$postEmail]);
 $prefs = $stmt->fetch(PDO::FETCH_ASSOC);

 } elseif ($action === 'unsubscribe') {
 $stmt = $pdo->prepare("
 UPDATE email_preferences
 SET frequency = 'never', unsubscribed = 1, updated_at = NOW()
 WHERE email = ? AND token = ?
 ");
 $stmt->execute([$postEmail, $postToken]);

 // Arrêter les séquences
 $stmt = $pdo->prepare("
 UPDATE email_subscriptions sub
 JOIN leads l ON sub.lead_id = l.id
 SET sub.status = 'unsubscribed'
 WHERE l.email = ? AND sub.status = 'active'
 ");
 $stmt->execute([$postEmail]);

 $message = 'Vous avez été désinscrit avec succès. Vous ne recevrez plus d\'emails.';
 $messageType = 'success';
 $showForm = false;
 }
 }
 } catch (Exception $e) {
 $message = 'Une erreur est survenue. Veuillez réessayer.';
 $messageType = 'error';
 }
 }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Préférences Email - ÉCOSYSTÈME IMMO LOCAL+</title>
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
 <style>
 * { margin: 0; padding: 0; box-sizing: border-box; }

 body {
 font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
 background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
 min-height: 100vh;
 display: flex;
 align-items: center;
 justify-content: center;
 padding: 20px;
 }

 .container {
 background: white;
 border-radius: 16px;
 padding: 40px;
 max-width: 520px;
 width: 100%;
 box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
 }

 .logo { font-size: 2rem; margin-bottom: 10px; text-align: center; }

 h1 {
 color: #1f2937;
 font-size: 1.5rem;
 text-align: center;
 margin-bottom: 10px;
 }

 .subtitle {
 color: #6b7280;
 margin-bottom: 30px;
 line-height: 1.6;
 text-align: center;
 }

 .email-display {
 background: #f3f4f6;
 padding: 12px 16px;
 border-radius: 8px;
 text-align: center;
 font-weight: 600;
 color: #374151;
 margin-bottom: 24px;
 font-size: 0.95rem;
 }

 .option-group { margin-bottom: 24px; }

 .option-group label {
 display: block;
 color: #374151;
 font-weight: 600;
 margin-bottom: 12px;
 font-size: 0.95rem;
 }

 .radio-card {
 display: block;
 padding: 16px;
 border: 2px solid #e5e7eb;
 border-radius: 10px;
 margin-bottom: 10px;
 cursor: pointer;
 transition: all 0.2s;
 }

 .radio-card:hover { border-color: #667eea; background: #f8faff; }
 .radio-card.selected { border-color: #667eea; background: #eff2ff; }

 .radio-card input[type="radio"] { display: none; }

 .radio-card .radio-title {
 font-weight: 600;
 color: #1f2937;
 margin-bottom: 4px;
 }

 .radio-card .radio-desc {
 font-size: 0.85rem;
 color: #6b7280;
 }

 .radio-indicator {
 display: inline-block;
 width: 18px;
 height: 18px;
 border: 2px solid #d1d5db;
 border-radius: 50%;
 margin-right: 10px;
 vertical-align: middle;
 transition: all 0.2s;
 }

 .radio-card.selected .radio-indicator {
 border-color: #667eea;
 background: #667eea;
 box-shadow: inset 0 0 0 3px white;
 }

 .btn {
 display: inline-block;
 padding: 14px 28px;
 font-size: 1rem;
 font-weight: 600;
 border-radius: 8px;
 cursor: pointer;
 border: none;
 transition: all 0.2s;
 text-decoration: none;
 text-align: center;
 }

 .btn-primary {
 background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
 color: white;
 width: 100%;
 }

 .btn-primary:hover {
 transform: translateY(-2px);
 box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
 }

 .btn-danger {
 background: none;
 color: #ef4444;
 border: 2px solid #fecaca;
 width: 100%;
 margin-top: 12px;
 }

 .btn-danger:hover { background: #fef2f2; }

 .message {
 padding: 16px;
 border-radius: 8px;
 margin-bottom: 20px;
 font-weight: 500;
 text-align: center;
 }

 .message.success { background: #d1fae5; color: #065f46; }
 .message.error { background: #fee2e2; color: #991b1b; }

 .note {
 margin-top: 30px;
 padding-top: 20px;
 border-top: 1px solid #e5e7eb;
 color: #9ca3af;
 font-size: 0.85rem;
 text-align: center;
 }

 .note a { color: #667eea; text-decoration: none; }
 .note a:hover { text-decoration: underline; }

 .icon-success { font-size: 4rem; margin-bottom: 20px; text-align: center; }

 .separator {
 text-align: center;
 color: #d1d5db;
 margin: 20px 0;
 font-size: 0.8rem;
 }
 </style>
</head>
<body>
 <div class="container">
 <div class="logo"></div>
 <h1>ÉCOSYSTÈME IMMO LOCAL+</h1>

 <?php if (!empty($message)): ?>
 <div class="message <?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
 <?php endif; ?>

 <?php if (!$tokenValid && $showForm): ?>
 <p class="subtitle">
 Lien invalide ou expiré.<br>
 Veuillez utiliser le lien dans l'un de vos emails pour accéder à vos préférences.
 </p>
 <a href="https://ecosystemeimmo.fr" class="btn btn-primary">Retour au site</a>

 <?php elseif ($showForm && $prefs): ?>
 <p class="subtitle">Gérez vos préférences de réception d'emails.</p>

 <div class="email-display"><?= htmlspecialchars($email) ?></div>

 <form method="POST" id="prefForm">
 <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
 <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
 <input type="hidden" name="action" value="update_frequency">

 <div class="option-group">
 <label>Fréquence de réception</label>

 <label class="radio-card <?= ($prefs['frequency'] ?? 'all') === 'all' ? 'selected' : '' ?>" onclick="selectRadio(this)">
 <input type="radio" name="frequency" value="all" <?= ($prefs['frequency'] ?? 'all') === 'all' ? 'checked' : '' ?>>
 <span class="radio-indicator"></span>
 <span class="radio-title">Tous les emails</span>
 <div class="radio-desc">Recevez tous nos emails et séquences normalement.</div>
 </label>

 <label class="radio-card <?= ($prefs['frequency'] ?? '') === 'weekly' ? 'selected' : '' ?>" onclick="selectRadio(this)">
 <input type="radio" name="frequency" value="weekly" <?= ($prefs['frequency'] ?? '') === 'weekly' ? 'checked' : '' ?>>
 <span class="radio-indicator"></span>
 <span class="radio-title">Hebdomadaire</span>
 <div class="radio-desc">Maximum un email par semaine.</div>
 </label>

 <label class="radio-card <?= ($prefs['frequency'] ?? '') === 'never' ? 'selected' : '' ?>" onclick="selectRadio(this)">
 <input type="radio" name="frequency" value="never" <?= ($prefs['frequency'] ?? '') === 'never' ? 'checked' : '' ?>>
 <span class="radio-indicator"></span>
 <span class="radio-title">Aucun email</span>
 <div class="radio-desc">Ne plus recevoir d'emails automatiques.</div>
 </label>
 </div>

 <button type="submit" class="btn btn-primary">Enregistrer mes préférences</button>
 </form>

 <div class="separator">— ou —</div>

 <form method="POST">
 <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
 <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
 <input type="hidden" name="action" value="unsubscribe">
 <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir vous désinscrire complètement ?');">
 Me désinscrire complètement
 </button>
 </form>

 <?php else: ?>
 <div class="icon-success"></div>
 <p class="subtitle">
 Vos préférences ont été mises à jour.<br>
 Vous pouvez fermer cette page.
 </p>
 <a href="https://ecosystemeimmo.fr" class="btn btn-primary" style="margin-top: 20px;">Retour au site</a>
 <?php endif; ?>

 <div class="note">
 <p>
 Des questions ? <a href="mailto:contact@ecosystemeimmo.fr">Contactez-nous</a><br>
 <a href="https://ecosystemeimmo.fr">Retour au site</a>
 </p>
 </div>
 </div>

 <script>
 function selectRadio(card) {
 document.querySelectorAll('.radio-card').forEach(function(c) { c.classList.remove('selected'); });
 card.classList.add('selected');
 var radio = card.querySelector('input[type="radio"]');
 if (radio) radio.checked = true;
 }
 </script>
</body>
</html>
