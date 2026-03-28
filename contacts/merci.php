<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Page de Remerciement
 * À copier dans /contacts/merci.php
 */
require_once __DIR__ . '/../includes/helpers.php';

$email = isset($_GET['email']) ? $_GET['email'] : '';
$intent = isset($_GET['intent']) ? $_GET['intent'] : '';

$intentMap = [
    'diagnostic' => 'diagnostic immobilier',
    'demo' => 'démo de la plateforme',
    'ressource' => 'ressource',
    'outil' => 'outil',
    'cold' => 'demande'
];

$intentLabel = isset($intentMap[$intent]) ? $intentMap[$intent] : 'demande';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci ! - ÉCOSYSTÈME IMMO LOCAL+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #10b981;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-500: #6b7280;
            --gray-900: #111827;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: var(--gray-900);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }
        
        .container {
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        
        .card {
            background: white;
            border-radius: 1.5rem;
            padding: 3rem 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        
        .icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: bounce 0.6s ease-in-out;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .title {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1rem;
        }
        
        .subtitle {
            font-size: 1rem;
            color: var(--gray-500);
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .info-box {
            background: var(--gray-50);
            border-left: 4px solid var(--success);
            padding: 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            text-align: left;
        }
        
        .info-label {
            font-size: 0.85rem;
            color: var(--gray-500);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.35rem;
        }
        
        .info-value {
            font-size: 1.1rem;
            color: var(--gray-900);
            font-weight: 600;
        }
        
        .next-steps {
            background: var(--gray-50);
            padding: 1.5rem;
            border-radius: 0.75rem;
            text-align: left;
            margin-bottom: 2rem;
        }
        
        .next-steps h3 {
            font-size: 0.95rem;
            color: var(--gray-900);
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .step {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .step-num {
            background: var(--success);
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 600;
        }
        
        .step-text {
            color: #4b5563;
            line-height: 1.5;
        }
        
        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            font-family: inherit;
            margin-bottom: 1rem;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102,126,234,0.3);
        }
        
        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }
        
        .btn-secondary:hover {
            background: var(--gray-50);
        }
        
        .footer {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-top: 2rem;
        }
        
        .footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .card {
                padding: 2rem;
            }
            
            .title {
                font-size: 1.5rem;
            }
            
            .icon {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="icon">✅</div>
            
            <h1 class="title">Merci !</h1>
            
            <p class="subtitle">
                Votre demande de <?php echo h($intentLabel); ?> a été reçue avec succès.
            </p>
            
            <?php if (!empty($email)): ?>
            <div class="info-box">
                <div class="info-label">Confirmation envoyée à :</div>
                <div class="info-value">📧 <?php echo h($email); ?></div>
            </div>
            <?php endif; ?>
            
            <div class="next-steps">
                <h3>📋 Prochaines étapes :</h3>
                
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">
                        Vous recevrez une confirmation par email dans quelques minutes
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">
                        Notre équipe examinera votre demande et vous recontactera dans les 24 heures
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">
                        Nous vous proposerons la meilleure solution adaptée à vos besoins
                    </div>
                </div>
            </div>
            
            <div>
                <a href="/" class="btn">
                    🏠 Retour à l'accueil
                </a>
                <a href="/front/pages/ressources.php" class="btn btn-secondary">
                    📚 Découvrir nos ressources
                </a>
            </div>
            
            <div class="footer">
                Des questions ? <a href="mailto:contact@ecosystemeimmo.fr">Contactez-nous directement</a>
            </div>
        </div>
    </div>
</body>
</html>