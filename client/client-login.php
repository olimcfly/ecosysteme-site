<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Client Login
 * Authentification pour l'espace client des agents
 */

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/security-headers.php';
require_once __DIR__ . '/../includes/csrf.php';

// Redirection si déjà connecté
if (isset($_SESSION['client_logged_in'])) {
    header('Location: /client/dashboard');
    exit;
}

// ============================================
// TRAITER LA CONNEXION
// ============================================
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        $error = 'Token de sécurité invalide. Veuillez réessayer.';
    }
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$error && !$email || !$password) {
        $error = 'Email et mot de passe requis';
    } else {
        try {
            // Récupérer l'agent
            $stmt = $pdo->prepare("SELECT id, firstname, lastname, email, password FROM clients WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $client = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($client && password_verify($password, $client['password'])) {
                // Authentification réussie
                $_SESSION['client_logged_in'] = true;
                $_SESSION['client_id'] = $client['id'];
                $_SESSION['client_email'] = $client['email'];
                $_SESSION['client_firstname'] = $client['firstname'];
                $_SESSION['client_lastname'] = $client['lastname'];
                
                header('Location: /client/dashboard');
                exit;
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        } catch (Exception $e) {
            error_log("Client login error: " . $e->getMessage());
            $error = 'Une erreur est survenue. Veuillez réessayer.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - ÉCOSYSTÈME IMMO LOCAL+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --danger: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-900: #111827;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body {
            height: 100%;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--gray-900);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }
        
        .container {
            width: 100%;
            max-width: 420px;
        }
        
        .card {
            background: white;
            border-radius: 1rem;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }
        
        .subtitle {
            font-size: 0.9rem;
            color: var(--gray-600);
        }
        
        .error {
            padding: 1rem;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(102,126,234,0.1);
        }
        
        .btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
            margin-top: 1rem;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102,126,234,0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .footer {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: 0.5rem;
        }
        
        .forgot-password a {
            font-size: 0.85rem;
            color: var(--primary);
            text-decoration: none;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .card {
                padding: 2rem;
            }
            
            .title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="logo">🔐</div>
                <h1 class="title">Espace Client</h1>
                <p class="subtitle">Connectez-vous à votre espace personnel</p>
            </div>
            
            <?php if ($error): ?>
                <div class="error">
                    ❌ <?= h($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <?= csrfField() ?>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="votre@email.fr" required 
                           value="<?= h($_POST['email'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                    <div class="forgot-password">
                        <a href="/client/forgot-password">Mot de passe oublié ?</a>
                    </div>
                </div>
                
                <button type="submit" class="btn">
                    ✓ Me Connecter
                </button>
            </form>
            
            <div class="footer">
                <p style="color: var(--gray-600); font-size: 0.9rem; margin-bottom: 1rem;">
                    Pas encore inscrit ?
                </p>
                <a href="/inscription">Créer un compte</a>
            </div>
        </div>
    </div>
</body>
</html>