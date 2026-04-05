<?php
declare(strict_types=1);

require_once __DIR__ . '/tracking.php';

// Tracking des clics
if (isset($_GET['src']) && $_GET['src'] === 'offre_cta') {
    track_event('offer_to_form_click', [
        'from' => 'offre.php',
        'referrer' => $_SERVER['HTTP_REFERER'] ?? null,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
    ]);
}

// Initialisation des variables
$old = [
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'telephone' => '',
    'zone' => '',
    'experience' => '',
    'contacts_vendeurs' => '',
    'objectif' => '',
    'investissement' => '',
];

$errors = [];
$hasErrors = false;

// Traitement des erreurs et anciennes valeurs
if (isset($_GET['errors'])) {
    $decodedErrors = json_decode((string) $_GET['errors'], true, 512, JSON_THROW_ON_ERROR);
    $decodedOld = json_decode((string) ($_GET['old'] ?? ''), true, 512, JSON_THROW_ON_ERROR);

    if (is_array($decodedErrors)) {
        $errors = array_map('htmlspecialchars', $decodedErrors);
        $hasErrors = true;
    }

    if (is_array($decodedOld)) {
        $old = array_merge($old, array_map('htmlspecialchars', $decodedOld));
    }
}

// Génération du token CSRF
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Vérifiez la disponibilité de votre zone pour notre solution d'acquisition de mandats exclusifs">
    <meta name="robots" content="noindex, nofollow">
    <title>EcosystèmeImmo — Vérifiez la disponibilité de votre zone</title>

    <!-- Préconnexion aux ressources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- CSS optimisé -->
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #f0b429;
            --text: #1f2937;
            --text-light: #374151;
            --text-lighter: #6b7280;
            --bg: #f9fafb;
            --bg-dark: #111827;
            --border: #e5e7eb;
            --error: #ef4444;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text);
        }

        /* Bandeau urgence */
        .bandeau-urgence {
            background-color: #fff8e1;
            color: var(--text);
            padding: 12px 20px;
            text-align: center;
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border);
        }

        .bandeau-urgence strong {
            color: var(--secondary);
        }

        /* Hero section */
        .hero {
            padding: 60px 20px;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 2.8rem);
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero h1 span {
            color: var(--secondary);
        }

        .sous-titre {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Benefices */
        .benefices {
            display: grid;
            gap: 20px;
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .benefice {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .benefice-icone {
            color: var(--success);
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .benefice-texte {
            flex: 1;
        }

        .benefice-texte strong {
            color: var(--text);
            display: block;
            margin-bottom: 4px;
        }

        /* Formulaire */
        .carte {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto 60px;
        }

        .carte-titre {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
        }

        .carte-sous-titre {
            color: var(--text-light);
            text-align: center;
            margin-bottom: 30px;
        }

        /* Gestion des erreurs */
        .bloc-erreurs {
            background-color: #fee2e2;
            color: var(--error);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #fecaca;
        }

        .bloc-erreurs ul {
            margin-top: 8px;
            padding-left: 20px;
        }

        .bloc-erreurs li {
            margin-bottom: 4px;
        }

        /* Sections du formulaire */
        .form-section {
            margin-bottom: 30px;
        }

        .section-label {
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--text);
        }

        .grid-2 {
            display: grid;
            gap: 20px;
            grid-template-columns: 1fr 1fr;
        }

        .grid-1 {
            display: grid;
            gap: 20px;
        }

        .champ {
            margin-bottom: 15px;
        }

        .champ label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: var(--text-light);
        }

        .champ input,
        .champ select,
        .champ textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .champ input:focus,
        .champ select:focus,
        .champ textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        .champ textarea {
            min-height: 100px;
            resize: vertical;
        }

        .separateur {
            height: 1px;
            background: var(--border);
            margin: 30px 0;
        }

        /* Rassurance */
        .rassurance {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .rassurance-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-lighter);
            font-size: 0.9rem;
        }

        .rassurance-item .icone {
            color: var(--success);
        }

        /* Bouton */
        .btn-submit {
            width: 100%;
            background-color: var(--secondary);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-bottom: 15px;
        }

        .btn-submit:hover {
            background-color: #d69e2e;
        }

        .sous-bouton {
            text-align: center;
            color: var(--text-lighter);
            font-size: 0.9rem;
        }

        /* Preuve sociale */
        .preuve {
            display: grid;
            gap: 20px;
            max-width: 800px;
            margin: 0 auto 60px;
            padding: 0 20px;
        }

        .preuve-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .preuve-chiffre {
            color: var(--success);
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }

            .carte {
                padding: 30px 20px;
            }

            .rassurance {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="logo">EcosystèmeImmo</div>

    <!-- ── URGENCE ── -->
    <div class="bandeau-urgence" role="alert">
        ⚠️ <strong>Zones en nombre limité.</strong>
        Une seule zone par conseiller est accordée — vérifiez la disponibilité de la vôtre maintenant.
    </div>

    <!-- ── HERO ── -->
    <div class="hero">
        <h1>Réservez votre zone<br><span>avant qu'un concurrent le fasse</span></h1>
        <p class="sous-titre">
            Remplissez ce formulaire en 2 minutes. Notre équipe vérifie
            la disponibilité de votre secteur et vous rappelle avec
            une proposition claire — sans engagement.
        </p>

        <div class="benefices">
            <div class="benefice">
                <div class="benefice-icone" aria-hidden="true">✓</div>
                <div class="benefice-texte">
                    <strong>Un appel stratégique offert</strong> — on analyse votre zone ensemble
                </div>
            </div>
            <div class="benefice">
                <div class="benefice-icone" aria-hidden="true">✓</div>
                <div class="benefice-texte">
                    <strong>Zéro engagement</strong> — vous décidez après l'appel, pas avant
                </div>
            </div>
            <div class="benefice">
                <div class="benefice-icone" aria-hidden="true">✓</div>
                <div class="benefice-texte">
                    <strong>Réponse sous 24h</strong> — on revient vers vous rapidement
                </div>
            </div>
        </div>
    </div>

    <!-- ── FORMULAIRE ── -->
    <div class="carte">

        <p class="carte-titre">Vérifiez la disponibilité de votre zone</p>
        <p class="carte-sous-titre">
            Ces informations nous permettent de vous préparer
            un échange utile et personnalisé.
        </p>

        <?php if ($hasErrors): ?>
            <div class="bloc-erreurs" role="alert">
                <strong>⚠️ Merci de corriger les points suivants :</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="/traitement-formulaire.php" novalidate>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="tracking_event" value="form_submission">

            <!-- Coordonnées -->
            <div class="form-section">
                <p class="section-label">Vos coordonnées</p>
                <div class="grid-2">
                    <div class="champ">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom"
                            placeholder="Dupont"
                            value="<?= $old['nom'] ?>"
                            required autocomplete="family-name">
                    </div>
                    <div class="champ">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom"
                            placeholder="Jean"
                            value="<?= $old['prenom'] ?>"
                            required autocomplete="given-name">
                    </div>
                    <div class="champ">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email"
                            placeholder="jean@email.com"
                            value="<?= $old['email'] ?>"
                            required autocomplete="email">
                    </div>
                    <div class="champ">
                        <label for="telephone">Téléphone *</label>
                        <input type="tel" id="telephone" name="telephone"
                            placeholder="+1 514 000 0000"
                            value="<?= $old['telephone'] ?>"
                            required autocomplete="tel">
                    </div>
                </div>
            </div>

            <!-- Votre marché -->
            <div class="form-section">
                <p class="section-label">Votre marché</p>
                <div class="grid-1">
                    <div class="champ">
                        <label for="zone">Dans quelle zone exercez-vous ? *</label>
                        <input type="text" id="zone" name="zone"
                            placeholder="Ex : Laval, Longueuil, Rive-Nord..."
                            value="<?= $old['zone'] ?>"
                            required>
                    </div>
                    <div class="champ">
                        <label for="experience">Depuis combien de temps êtes-vous conseiller ? *</label>
                        <input type="text" id="experience" name="experience"
                            placeholder="Ex : 3 ans"
                            value="<?= $old['experience'] ?>"
                            required>
                    </div>
                    <div class="champ">
                        <label for="contacts_vendeurs">Recevez-vous des contacts vendeurs en ce moment ? *</label>
                        <select id="contacts_vendeurs" name="contacts_vendeurs" required>
                            <option value="">Sélectionner...</option>
                            <?php foreach (['oui régulièrement', 'parfois', 'jamais'] as $opt): ?>
                                <option value="<?= htmlspecialchars($opt) ?>"
                                    <?= $old['contacts_vendeurs'] === $opt ? 'selected' : '' ?>>
                                    <?= ucfirst($opt) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Vos ambitions -->
            <div class="form-section">
                <p class="section-label">Vos ambitions</p>
                <div class="grid-1">
                    <div class="champ">
                        <label for="objectif">Qu'est-ce que vous voulez changer dans les 90 prochains jours ? *</label>
                        <textarea id="objectif" name="objectif"
                            placeholder="Ex : Obtenir plus de mandats exclusifs dans mon secteur sans courir après les clients..."
                            required><?= $old['objectif'] ?></textarea>
                    </div>
                    <div class="champ">
                        <label for="investissement">Seriez-vous prêt à investir pour dominer votre zone ? *</label>
                        <select id="investissement" name="investissement" required>
                            <option value="">Sélectionner...</option>
                            <?php foreach (['oui', 'non', 'à discuter'] as $opt): ?>
                                <option value="<?= htmlspecialchars($opt) ?>"
                                    <?= $old['investissement'] === $opt ? 'selected' : '' ?>>
                                    <?= ucfirst($opt) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="separateur"></div>

            <!-- Rassurance -->
            <div class="rassurance">
                <div class="rassurance-item">
                    <span class="icone" aria-hidden="true">✓</span>
                    <span>100% confidentiel</span>
                </div>
                <div class="rassurance-item">
                    <span class="icone" aria-hidden="true">✓</span>
                    <span>Aucun engagement</span>
                </div>
                <div class="rassurance-item">
                    <span class="icone" aria-hidden="true">✓</span>
                    <span>Réponse sous 24h</span>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                → Vérifier la disponibilité de ma zone
            </button>
            <p class="sous-bouton">
                Notre équipe vous contacte dans les 24h avec une réponse claire
            </p>
        </form>
    </div>

    <!-- ── PREUVE SOCIALE ── -->
    <div class="preuve">
        <div class="preuve-item">
            <div class="preuve-chiffre" aria-hidden="true">✔</div>
            <div class="preuve-label">Systèmes déjà déployés sur plusieurs zones</div>
        </div>
        <div class="preuve-item">
            <div class="preuve-chiffre" aria-hidden="true">✔</div>
            <div class="preuve-label">Méthode structurée et duplicable localement</div>
        </div>
        <div class="preuve-item">
            <div class="preuve-chiffre" aria-hidden="true">✔</div>
            <div class="preuve-label">Accompagnement et mise en place inclus</div>
        </div>
    </div>

    <!-- Script de validation client-side -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');

            // Validation client-side basique
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validation email
                const email = document.getElementById('email');
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                    showError(email, 'Veuillez entrer un email valide');
                    isValid = false;
                }

                // Validation téléphone
                const phone = document.getElementById('telephone');
                if (!/^(\+?\d{1,3}[- ]?)?\d{10}$/.test(phone.value)) {
                    showError(phone, 'Veuillez entrer un numéro de téléphone valide');
                    isValid = false;
                }

                // Validation champs requis
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        showError(field, 'Ce champ est requis');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    // Faire défiler vers la première erreur
                    const firstError = document.querySelector('.error-message');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });

            function showError(field, message) {
                // Supprimer les erreurs précédentes
                const existingError = field.nextElementSibling;
                if (existingError && existingError.classList.contains('error-message')) {
                    existingError.remove();
                }

                // Ajouter le message d'erreur
                const error = document.createElement('div');
                error.className = 'error-message';
                error.style.color = '#ef4444';
                error.style.fontSize = '0.8rem';
                error.style.marginTop = '5px';
                error.textContent = message;
                field.parentNode.insertBefore(error, field.nextSibling);

                // Ajouter la classe d'erreur au champ
                field.classList.add('error');
            }

            // Supprimer les erreurs quand l'utilisateur corrige
            form.querySelectorAll('input, select, textarea').forEach(field => {
                field.addEventListener('input', function() {
                    const error = this.nextElementSibling;
                    if (error && error.classList.contains('error-message')) {
                        error.remove();
                    }
                    this.classList.remove('error');
                });
            });
        });
    </script>
</body>
</html>
