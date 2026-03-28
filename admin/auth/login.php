<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Connexion Admin (OTP)
 * CRM v2.5
 */

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../config/admin-config.php';

$error = '';
$success = '';
$step = 'email';

// Générer le token CSRF
generateCsrfToken();

// ============================================
// Déjà connecté ? Rediriger
// ============================================
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: /admin/crm/index.php');
    exit;
}

// ============================================
// Reset demandé ?
// ============================================
if (isset($_GET['reset'])) {
    unset($_SESSION['otp_email'], $_SESSION['otp_admin_id']);
    header('Location: /admin/login');
    exit;
}

// ============================================
// Traitement formulaire
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!validateCsrfToken()) {
        $error = 'Token de sécurité invalide. Veuillez réessayer.';
    } else {
    // -----------------------------------------
    // ÉTAPE 1 : Envoi du code OTP
    // -----------------------------------------
    if (isset($_POST['send_code'])) {
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email invalide.';
        } else {
            // Vérifier si admin autorisé dans la BDD
            $stmt = $pdo->prepare("SELECT id, email, firstname FROM admins WHERE email = ? AND is_active = 1 LIMIT 1");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$admin) {
                $error = 'Accès non autorisé.';
            } else {
                // Vérifier rate limiting (max 5 codes en 15 min)
                $stmt = $pdo->prepare("
                    SELECT COUNT(*) as cnt FROM admin_otp 
                    WHERE email = ? AND created_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
                ");
                $stmt->execute([$email]);
                $check = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($check['cnt'] >= OTP_MAX_ATTEMPTS) {
                    $error = 'Trop de tentatives. Réessayez dans 15 minutes.';
                } else {
                    // Générer code OTP
                    $code = str_pad(random_int(0, 999999), OTP_LENGTH, '0', STR_PAD_LEFT);

                    // Invalider anciens codes
                    $stmt = $pdo->prepare("UPDATE admin_otp SET is_used = 1 WHERE admin_id = ? AND is_used = 0");
                    $stmt->execute([$admin['id']]);

                    // Enregistrer nouveau code (expires_at calculé par MySQL pour éviter les décalages de timezone)
                    $stmt = $pdo->prepare("
                        INSERT INTO admin_otp (admin_id, email, otp_code, expires_at, ip_address, user_agent)
                        VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL ? SECOND), ?, ?)
                    ");
                    $stmt->execute([
                        $admin['id'],
                        $email,
                        $code,
                        OTP_EXPIRY,
                        $_SERVER['REMOTE_ADDR'] ?? '',
                        $_SERVER['HTTP_USER_AGENT'] ?? ''
                    ]);
                    
                    // Envoyer email
                    $subject = "Code de connexion - " . SITE_NAME;
                    $message = '
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px;">
    <div style="max-width: 500px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 22px;">Code de connexion</h1>
        </div>
        <div style="padding: 30px; text-align: center;">
            <p style="color: #333; margin-bottom: 20px;">Bonjour ' . h($admin['firstname'] ?? '') . ',</p>
            <p style="color: #666; margin-bottom: 25px;">Votre code de connexion est :</p>
            <div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin: 20px 0;">
                <span style="font-size: 36px; font-weight: bold; letter-spacing: 8px; color: #667eea;">' . $code . '</span>
            </div>
            <p style="color: #888; font-size: 14px;">Ce code expire dans <strong>10 minutes</strong>.</p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 25px 0;">
            <p style="color: #999; font-size: 12px;">Si vous n\'avez pas demandé ce code, ignorez cet email.</p>
        </div>
    </div>
</body>
</html>';
                    
                    $headers = [
                        'From: ' . EMAIL_FROM_NAME . ' <' . EMAIL_FROM . '>',
                        'Reply-To: ' . EMAIL_REPLY_TO,
                        'MIME-Version: 1.0',
                        'Content-Type: text/html; charset=UTF-8'
                    ];
                    
                    if (mail($email, $subject, $message, implode("\r\n", $headers))) {
                        $_SESSION['otp_email'] = $email;
                        $_SESSION['otp_admin_id'] = $admin['id'];
                        $success = 'Code envoye ! Verifiez votre boite email.';
                        $step = 'code';
                    } else {
                        $error = 'Erreur d\'envoi. Reessayez.';
                    }
                }
            }
        }
    }
    
    // -----------------------------------------
    // ÉTAPE 2 : Vérification du code OTP
    // -----------------------------------------
    if (isset($_POST['verify_code'])) {
        $code = preg_replace('/\D/', '', $_POST['code'] ?? '');
        $email = $_SESSION['otp_email'] ?? '';
        $adminId = $_SESSION['otp_admin_id'] ?? 0;
        
        if (empty($email) || empty($adminId)) {
            $error = 'Session expiree. Recommencez.';
            $step = 'email';
        } elseif (strlen($code) !== OTP_LENGTH) {
            $error = 'Code invalide.';
            $step = 'code';
        } else {
            // Vérifier code en BDD
            $stmt = $pdo->prepare("
                SELECT * FROM admin_otp 
                WHERE admin_id = ? AND otp_code = ? AND expires_at > NOW() AND is_used = 0 
                ORDER BY created_at DESC LIMIT 1
            ");
            $stmt->execute([$adminId, $code]);
            $otp = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($otp) {
                // Marquer utilisé
                $stmt = $pdo->prepare("UPDATE admin_otp SET is_used = 1 WHERE id = ?");
                $stmt->execute([$otp['id']]);
                
                // Mettre à jour last_login
                $stmt = $pdo->prepare("UPDATE admins SET last_login_at = NOW() WHERE id = ?");
                $stmt->execute([$adminId]);
                
                // Récupérer infos admin
                $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
                $stmt->execute([$adminId]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Créer session
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $adminId;
                $_SESSION['admin_email'] = $email;
                $_SESSION['admin_firstname'] = $admin['firstname'] ?? '';
                $_SESSION['admin_role'] = $admin['role'] ?? 'admin';
                $_SESSION['login_time'] = time();
                
                // Enregistrer session en BDD
                $token = bin2hex(random_bytes(32));
                $stmt = $pdo->prepare("
                    INSERT INTO admin_sessions (admin_id, session_token, ip_address, user_agent, expires_at) 
                    VALUES (?, ?, ?, ?, DATE_ADD(NOW(), INTERVAL 24 HOUR))
                ");
                $stmt->execute([
                    $adminId,
                    $token,
                    $_SERVER['REMOTE_ADDR'] ?? '',
                    $_SERVER['HTTP_USER_AGENT'] ?? ''
                ]);
                
                // Nettoyer
                unset($_SESSION['otp_email'], $_SESSION['otp_admin_id']);
                
                // Rediriger
                header('Location: /admin/crm/index.php');
                exit;
            } else {
                $error = 'Code invalide ou expire.';
                $step = 'code';
            }
        }
    }
    } // end CSRF validation
}

// Détecter étape
if (isset($_SESSION['otp_email'])) {
    $step = 'code';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Connexion Admin - <?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
            --danger: #ef4444;
            --gray-100: #f3f4f6;
            --gray-500: #6b7280;
            --gray-800: #1f2937;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
        }
        
        .login-icon { font-size: 3.5rem; margin-bottom: 1rem; }
        .login-header h1 { font-size: 1.4rem; font-weight: 700; margin-bottom: 0.5rem; }
        .login-header p { opacity: 0.9; font-size: 0.9rem; }
        
        .login-body { padding: 2rem; }
        
        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        
        .form-group { margin-bottom: 1.5rem; }
        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--gray-100);
            border-radius: 0.75rem;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s;
            text-align: center;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        
        .code-input {
            font-size: 1.75rem !important;
            letter-spacing: 0.75rem;
            font-weight: 700;
            font-family: 'Courier New', monospace;
        }
        
        .btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102,126,234,0.4);
        }
        
        .back-link {
            display: inline-block;
            color: var(--gray-500);
            text-decoration: none;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .back-link:hover { color: var(--primary); }
        
        .help-text {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-100);
        }
        
        .resend-btn {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            font-weight: 500;
            font-family: inherit;
            font-size: 0.9rem;
            text-decoration: underline;
        }
        .resend-btn:hover { color: var(--secondary); }
        
        .timer { color: var(--gray-500); font-size: 0.85rem; margin-top: 0.5rem; }
        
        .email-hint {
            margin-top: 1rem;
            padding: 0.75rem;
            background: #fef3c7;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            color: #92400e;
            text-align: center;
        }
        
        .login-footer {
            text-align: center;
            padding: 1.5rem;
            background: var(--gray-100);
        }
        .login-footer a { color: var(--gray-500); text-decoration: none; font-size: 0.9rem; }
        .login-footer a:hover { color: var(--primary); }
        
        @media (max-width: 480px) {
            .login-header { padding: 2rem 1.5rem; }
            .login-body { padding: 1.5rem; }
            .code-input { font-size: 1.5rem !important; letter-spacing: 0.5rem; }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="login-icon">🔐</div>
            <h1>Espace Administrateur</h1>
            <p><?= SITE_NAME ?></p>
        </div>
        
        <div class="login-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= h($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?= h($success) ?></div>
            <?php endif; ?>
            
            <?php if ($step === 'email'): ?>
                <!-- ÉTAPE 1 : Email -->
                <form method="POST">
                    <?= csrfField() ?>
                    <div class="form-group">
                        <label class="form-label">Email administrateur</label>
                        <input type="email" name="email" class="form-input" 
                               placeholder="votre@email.com" required autofocus>
                    </div>
                    <button type="submit" name="send_code" value="1" class="btn">
                        Recevoir mon code
                    </button>
                </form>
                
            <?php else: ?>
                <!-- ÉTAPE 2 : Code OTP -->
                <a href="/admin/login?reset=1" class="back-link">← Changer d'email</a>
                
                <form method="POST">
                    <?= csrfField() ?>
                    <div class="form-group">
                        <label class="form-label">Code a <?= OTP_LENGTH ?> chiffres</label>
                        <input type="text" name="code" class="form-input code-input" 
                               maxlength="<?= OTP_LENGTH ?>" inputmode="numeric" 
                               pattern="[0-9]*" placeholder="000000" required autofocus>
                    </div>
                    <button type="submit" name="verify_code" value="1" class="btn">
                        Verifier et acceder
                    </button>
                </form>
                
                <div class="help-text">
                    <p class="timer">Code valide 10 minutes</p>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="email" value="<?= h($_SESSION['otp_email'] ?? '') ?>">
                        <button type="submit" name="send_code" value="1" class="resend-btn">
                            Renvoyer le code
                        </button>
                    </form>
                </div>
                
                <div class="email-hint">
                    Code envoye a <strong><?= h($_SESSION['otp_email'] ?? '') ?></strong>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="login-footer">
            <a href="/">← Retour au site</a>
        </div>
    </div>
    
    <script>
        const codeInput = document.querySelector('.code-input');
        if (codeInput) {
            codeInput.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });
            codeInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                this.value = paste.replace(/\D/g, '').substring(0, <?= OTP_LENGTH ?>);
            });
        }
    </script>
</body>
</html>