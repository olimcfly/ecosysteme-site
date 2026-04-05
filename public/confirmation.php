<?php
// Sécurité renforcée
session_start();

// Configuration
const SECURITY_HEADERS = [
    "X-Frame-Options: DENY",
    "X-Content-Type-Options: nosniff",
    "X-XSS-Protection: 1; mode=block",
    "Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; connect-src 'self'",
    "Referrer-Policy: strict-origin-when-cross-origin",
    "Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"
];

const SESSION_FIELDS = ['prenom', 'email', 'ville', 'telephone', 'source'];

// Vérification stricte des données de session
$sessionValid = false;
foreach (SESSION_FIELDS as $field) {
    if (!empty($_SESSION[$field]) && is_string($_SESSION[$field])) {
        $sessionValid = true;
        break;
    }
}

if (!$sessionValid) {
    error_log('Tentative d\'accès à la page de confirmation sans session valide');
    header('Location: /index.php?error=session_expired');
    exit;
}

// Nettoyage et validation des données
$leadData = [];
foreach (SESSION_FIELDS as $field) {
    $value = $_SESSION[$field] ?? '';
    if (is_string($value)) {
        $leadData[$field] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}

// Validation spécifique
if (mb_strlen($leadData['prenom'] ?? '') < 2 || mb_strlen($leadData['prenom'] ?? '') > 50) {
    error_log('Prénom invalide dans la session: ' . ($leadData['prenom'] ?? ''));
    header('Location: /index.php?error=invalid_data');
    exit;
}

// Configuration des en-têtes de sécurité
foreach (SECURITY_HEADERS as $header) {
    header($header);
}

// Nettoyage de la session après utilisation
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Confirmation de votre demande d'accès à la démonstration ECOSYSTEMEIMMO - Découvrez les prochaines étapes">
    <meta name="robots" content="noindex, nofollow">
    <title>ECOSYSTEMEIMMO | Votre demande a bien été enregistrée</title>

    <!-- Préconnexion aux polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- CSS optimisé avec variables et animations -->
    <style>
        :root {
            --primary: #f0b429;
            --primary-dark: #d69e2e;
            --bg-dark: #2a303c;
            --bg-darker: #1e222a;
            --text-light: #ffffff;
            --text-secondary: #bfc8d6;
            --text-muted: #8a95a3;
            --text-dark: #1a1f2e;
            --success: #48bb78;
            --shadow: 0 0 0 4px rgba(240, 180, 41, 0.12), 0 8px 40px rgba(0, 0, 0, 0.5);
            --border-radius: 16px;
            --border-radius-sm: 12px;
            --border-radius-xs: 10px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        /* Logo */
        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 1px;
            z-index: 10;
        }

        /* ══ CONFIRMATION ══ */
        .confirm-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            position: relative;
        }

        .confirm-card {
            background: var(--bg-darker);
            border: 1px solid rgba(240, 180, 41, 0.2);
            border-radius: var(--border-radius);
            padding: 48px 40px;
            max-width: 580px;
            width: 100%;
            text-align: center;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
        }

        .confirm-card.animate-fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        .confirm-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), #ff8c42);
        }

        .confirm-icone {
            font-size: 3.5rem;
            margin-bottom: 12px;
            line-height: 1;
            color: var(--success);
            opacity: 0;
            transform: scale(0.8);
        }

        .confirm-card.animate-fade-in .confirm-icone {
            opacity: 1;
            transform: scale(1);
            transition: all 0.5s ease-out 0.2s;
        }

        .confirm-badge {
            display: inline-block;
            background: rgba(72, 187, 120, 0.15);
            border: 1px solid var(--success);
            color: var(--success);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 20px;
            opacity: 0;
        }

        .confirm-card.animate-fade-in .confirm-badge {
            opacity: 1;
            transition: opacity 0.3s ease-out 0.3s;
        }

        .confirm-card h1 {
            font-size: clamp(1.3rem, 4vw, 1.7rem);
            color: var(--text-light);
            margin-bottom: 14px;
            line-height: 1.4;
            opacity: 0;
        }

        .confirm-card.animate-fade-in h1 {
            opacity: 1;
            transition: opacity 0.3s ease-out 0.4s;
        }

        .confirm-card h1 span {
            color: var(--primary);
            display: block;
        }

        .confirm-card .intro {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 32px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0;
        }

        .confirm-card.animate-fade-in .intro {
            opacity: 1;
            transition: opacity 0.3s ease-out 0.5s;
        }

        /* ── Étapes ── */
        .etapes {
            text-align: left;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(240, 180, 41, 0.1);
            border-radius: var(--border-radius-sm);
            padding: 24px 28px;
            margin-bottom: 32px;
            opacity: 0;
            transform: translateX(-20px);
        }

        .confirm-card.animate-fade-in .etapes {
            opacity: 1;
            transform: translateX(0);
            transition: all 0.4s ease-out 0.6s;
        }

        .etapes h2 {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 18px;
            position: relative;
            padding-bottom: 8px;
        }

        .etapes h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--primary);
        }

        .etape-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 16px;
            opacity: 0;
            transform: translateX(-10px);
        }

        .confirm-card.animate-fade-in .etape-item {
            opacity: 1;
            transform: translateX(0);
            transition: all 0.3s ease-out;
        }

        .confirm-card.animate-fade-in .etape-item:nth-child(1) {
            transition-delay: 0.7s;
        }

        .confirm-card.animate-fade-in .etape-item:nth-child(2) {
            transition-delay: 0.8s;
        }

        .confirm-card.animate-fade-in .etape-item:nth-child(3) {
            transition-delay: 0.9s;
        }

        .etape-item:last-child {
            margin-bottom: 0;
        }

        .etape-num {
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            background: var(--primary);
            color: var(--text-dark);
            font-weight: 700;
            font-size: 0.85rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .etape-texte strong {
            display: block;
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 3px;
        }

        .etape-texte span {
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ── Urgence ── */
        .urgence-box {
            background: rgba(240, 180, 41, 0.08);
            border: 1px solid rgba(240, 180, 41, 0.3);
            border-radius: var(--border-radius-xs);
            padding: 16px 20px;
            margin-bottom: 28px;
            font-size: 0.85rem;
            color: var(--primary);
            line-height: 1.7;
            text-align: left;
            opacity: 0;
            transform: translateY(10px);
        }

        .confirm-card.animate-fade-in .urgence-box {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.4s ease-out 1s;
        }

        .urgence-box strong {
            color: var(--primary);
            display: block;
            margin-bottom: 4px;
        }

        .urgence-box::before {
            content: '⚠️';
            margin-right: 8px;
        }

        /* ── Signature ── */
        .signature {
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-top: 24px;
            text-align: left;
            opacity: 0;
            transform: translateY(10px);
        }

        .confirm-card.animate-fade-in .signature {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.4s ease-out 1.1s;
        }

        .signature strong {
            color: var(--text-secondary);
            display: block;
            margin-bottom: 4px;
        }

        /* ── Bouton d'action ── */
        .action-container {
            margin-top: 32px;
            opacity: 0;
            transform: translateY(10px);
        }

        .confirm-card.animate-fade-in .action-container {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.4s ease-out 1.2s;
        }

        .btn-action {
            display: inline-block;
            background: var(--primary);
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 12px 24px;
            border-radius: var(--border-radius-xs);
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-action:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .confirm-card {
                padding: 36px 24px;
                margin: 0 15px;
            }

            .etapes {
                padding: 20px 18px;
            }
        }

        @media (max-width: 480px) {
            .confirm-card {
                padding: 30px 20px;
            }

            .confirm-card h1 {
                font-size: 1.35rem;
            }

            .intro {
                font-size: 0.9rem;
            }

            .etape-num {
                width: 26px;
                height: 26px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

    <div class="logo">ECOSYSTÈME IMMO</div>

    <div class="confirm-wrap">
        <div class="confirm-card animate-fade-in">

            <div class="confirm-icone" aria-hidden="true">✅</div>

            <div class="confirm-badge">Demande enregistrée</div>

            <h1>
                Merci <span><?= $leadData['prenom'] ?></span>,
                <br>votre accès est en cours de validation
            </h1>

            <p class="intro">
                Nous avons bien reçu votre demande pour la zone <strong><?= $leadData['ville'] ?? 'non spécifiée' ?></strong>.
                Voici les prochaines étapes pour accéder à votre démonstration personnalisée.
            </p>

            <!-- ÉTAPES -->
            <div class="etapes" role="region" aria-label="Prochaines étapes">
                <h2>Votre parcours d'accès</h2>

                <div class="etape-item">
                    <div class="etape-num" aria-hidden="true">1</div>
                    <div class="etape-texte">
                        <strong>Email de confirmation envoyé</strong>
                        <span>Vérifiez votre boîte mail (<strong><?= $leadData['email'] ?></strong>) et cliquez sur le lien de confirmation.</span>
                    </div>
                </div>

                <div class="etape-item">
                    <div class="etape-num" aria-hidden="true">2</div>
                    <div class="etape-texte">
                        <strong>Analyse de votre secteur</strong>
                        <span>Notre équipe vérifie la disponibilité sur <strong><?= $leadData['ville'] ?? 'votre zone' ?></strong> et prépare votre accès personnalisé.</span>
                    </div>
                </div>

                <div class="etape-item">
                    <div class="etape-num" aria-hidden="true">3</div>
                    <div class="etape-texte">
                        <strong>Accès à la démonstration</strong>
                        <span>Sous 24 à 48h, vous recevrez un email avec votre lien d'accès personnalisé à la plateforme.</span>
                    </div>
                </div>
            </div>

            <!-- URGENCE -->
            <div class="urgence-box" role="alert">
                <strong>Exclusivité territoriale</strong>
                Nous limitons à un seul conseiller par secteur pour garantir la qualité de notre accompagnement.
                Si votre zone est déjà attribuée, nous vous proposerons une alternative sous 48h.
            </div>

            <!-- BOUTON D'ACTION -->
            <div class="action-container">
                <a href="mailto:<?= htmlspecialchars('contact@ecosystemeimmo.fr', ENT_QUOTES) ?>" class="btn-action">
                    <span aria-hidden="true">✉️</span> Une question ? Contactez-nous
                </a>
            </div>

            <!-- SIGNATURE -->
            <p class="signature">
                À très bientôt,<br>
                <strong>L'équipe EcosystèmeImmo</strong><br><br>
                <em>PS: Votre numéro (<?= $leadData['telephone'] ?? 'non fourni' ?>) nous servira uniquement pour vous contacter en cas de besoin urgent.</em>
            </p>
        </div>
    </div>

    <!-- Script pour le tracking et animations -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation au chargement
            const card = document.querySelector('.confirm-card');
            card.classList.add('animate-fade-in');

            // Envoi d'un événement de tracking
            const trackingData = {
                event: 'confirmation_page_view',
                lead: {
                    prenom: <?= json_encode($leadData['prenom'] ?? '') ?>,
                    email: <?= json_encode($leadData['email'] ?? '') ?>,
                    ville: <?= json_encode($leadData['ville'] ?? '') ?>,
                    source: <?= json_encode($leadData['source'] ?? '') ?>
                },
                meta: {
                    user_agent: navigator.userAgent,
                    screen_width: window.screen.width,
                    screen_height: window.screen.height,
                    referrer: document.referrer,
                    timestamp: new Date().toISOString()
                }
            };

            fetch('/api/tracking.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(trackingData)
            }).catch(error => {
                console.error('Tracking error:', error);
            });

            // Gestion du bouton mailto
            const mailBtn = document.querySelector('.btn-action');
            mailBtn.addEventListener('click', function(e) {
                if (!navigator.onLine) {
                    e.preventDefault();
                    alert('Vous semblez être hors ligne. Veuillez vérifier votre connexion.');
                }
            });
        });
    </script>
</body>
</html>
