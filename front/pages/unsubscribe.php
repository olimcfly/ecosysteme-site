<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Page de Désinscription
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/../../includes/security-headers.php';
require_once __DIR__ . '/../../includes/csrf.php';

$message = '';
$messageType = '';
$showForm = true;

// Récupérer les paramètres
$encodedEmail = isset($_GET['e']) ? $_GET['e'] : '';
$subscriptionId = isset($_GET['s']) ? intval($_GET['s']) : 0;
$email = !empty($encodedEmail) ? base64_decode($encodedEmail) : '';

// Traitement du formulaire de confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 if (!validateCsrfToken()) {
 $message = 'Token de sécurité invalide. Veuillez réessayer.';
 $messageType = 'error';
 }
 $confirmEmail = isset($_POST['email']) ? trim($_POST['email']) : '';
 $confirmSubId = isset($_POST['subscription_id']) ? intval($_POST['subscription_id']) : 0;
 
 if (!empty($message) && $messageType === 'error') {
 // CSRF failed, skip processing
 } elseif (!empty($confirmEmail) && filter_var($confirmEmail, FILTER_VALIDATE_EMAIL)) {
 try {
 // Désinscrire de toutes les séquences actives pour cet email
 $stmt = $pdo->prepare("
 UPDATE email_subscriptions sub
 JOIN leads l ON sub.lead_id = l.id
 SET sub.status = 'unsubscribed'
 WHERE l.email = ? AND sub.status = 'active'
 ");
 $stmt->execute([$confirmEmail]);
 $count = $stmt->rowCount();
 
 if ($count > 0) {
 $message = "Vous avez été désinscrit avec succès de $count séquence(s) d'emails.";
 $messageType = 'success';
 } else {
 $message = "Aucune inscription active trouvée pour cet email.";
 $messageType = 'info';
 }
 $showForm = false;
 
 } catch (Exception $e) {
 $message = "Une erreur est survenue. Veuillez réessayer.";
 $messageType = 'error';
 }
 } else {
 $message = "Veuillez entrer une adresse email valide.";
 $messageType = 'error';
 }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Désinscription - ÉCOSYSTÈME IMMO LOCAL+</title>
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
 max-width: 480px;
 width: 100%;
 box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
 text-align: center;
 }
 
 .logo {
 font-size: 2rem;
 margin-bottom: 10px;
 }
 
 h1 {
 color: #1f2937;
 font-size: 1.5rem;
 margin-bottom: 10px;
 }
 
 .subtitle {
 color: #6b7280;
 margin-bottom: 30px;
 line-height: 1.6;
 }
 
 .form-group {
 margin-bottom: 20px;
 text-align: left;
 }
 
 label {
 display: block;
 color: #374151;
 font-weight: 500;
 margin-bottom: 8px;
 }
 
 input[type="email"] {
 width: 100%;
 padding: 12px 16px;
 border: 2px solid #e5e7eb;
 border-radius: 8px;
 font-size: 1rem;
 transition: border-color 0.2s;
 }
 
 input[type="email"]:focus {
 outline: none;
 border-color: #667eea;
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
 
 .btn-secondary {
 background: #f3f4f6;
 color: #374151;
 margin-top: 15px;
 }
 
 .btn-secondary:hover {
 background: #e5e7eb;
 }
 
 .message {
 padding: 16px;
 border-radius: 8px;
 margin-bottom: 20px;
 font-weight: 500;
 }
 
 .message.success {
 background: #d1fae5;
 color: #065f46;
 }
 
 .message.error {
 background: #fee2e2;
 color: #991b1b;
 }
 
 .message.info {
 background: #dbeafe;
 color: #1e40af;
 }
 
 .note {
 margin-top: 30px;
 padding-top: 20px;
 border-top: 1px solid #e5e7eb;
 color: #9ca3af;
 font-size: 0.85rem;
 }
 
 .note a {
 color: #667eea;
 text-decoration: none;
 }
 
 .note a:hover {
 text-decoration: underline;
 }
 
 .icon-success {
 font-size: 4rem;
 margin-bottom: 20px;
 }
 </style>
</head>
<body>
 <div class="container">
 <div class="logo"></div>
 <h1>ÉCOSYSTÈME IMMO LOCAL+</h1>
 
 <?php if (!empty($message)): ?>
 <div class="message <?php echo h($messageType); ?>">
 <?php echo h($message); ?>
 </div>
 <?php endif; ?>
 
 <?php if ($showForm): ?>
 <p class="subtitle">
 Vous souhaitez vous désinscrire de nos emails ?<br>
 Confirmez votre adresse email ci-dessous.
 </p>
 
 <form method="POST" action="">
 <?= csrfField() ?>
 <div class="form-group">
 <label for="email">Adresse email</label>
 <input 
 type="email" 
 id="email" 
 name="email" 
 value="<?php echo h($email); ?>"
 placeholder="votre@email.com"
 required
 >
 </div>
 <input type="hidden" name="subscription_id" value="<?php echo h($subscriptionId); ?>">
 <button type="submit" class="btn btn-primary">Me désinscrire</button>
 </form>
 
 <?php else: ?>
 <div class="icon-success"></div>
 <p class="subtitle">
 Vous ne recevrez plus d'emails automatiques de notre part.<br>
 Vous pouvez toujours nous contacter directement si besoin.
 </p>
 <a href="https://ecosystemeimmo.fr" class="btn btn-secondary">Retour au site</a>
 <?php endif; ?>
 
 <div class="note">
 <p>
 Des questions ? <a href="mailto:contact@ecosystemeimmo.fr">Contactez-nous</a><br>
 <a href="https://ecosystemeimmo.fr">Retour au site</a>
 </p>
 </div>
 </div>
</body>
</html>