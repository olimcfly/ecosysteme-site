<?php
// Démarrer la session et générer un token CSRF
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Charger les anciennes valeurs du formulaire si elles existent
$old = $_SESSION['form_old'] ?? [];
unset($_SESSION['form_old']);

// Charger les erreurs du formulaire si elles existent
$errors = $_SESSION['form_errors'] ?? '';
unset($_SESSION['form_errors']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>EcosystèmeImmo — Les 7 erreurs qui coûtent des vendeurs</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Vos styles CSS existants restent inchangés */
        /* ══ OVERLAY ══ */
        #overlay {
            display:     none;
            position:    fixed;
            inset:       0;
            background:  rgba(0,0,0,0.82);
            z-index:     99999;
            overflow-y:  auto;
            padding:     20px;
        }
        #overlay.active { display: block; }

        /* ══ POPUP ══ */
        #popup {
            position:      relative;
            background:    linear-gradient(160deg, #2e3849 0%, #1e2433 100%);
            border:        1.5px solid #f0b429;
            border-radius: 16px;
            padding:       44px 32px 36px;
            width:         100%;
            max-width:     460px;
            margin:        40px auto;
            box-shadow:    0 12px 60px rgba(0,0,0,0.7);
        }

        #popup .popup-badge {
            display:       block;
            text-align:    center;
            font-size:     0.72rem;
            font-weight:   700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color:         #f0b429;
            margin-bottom: 14px;
        }

        #popup h2 {
            font-family:   Arial, sans-serif;
            font-size:     1.4rem;
            color:         #ffffff;
            text-align:    center;
            margin-bottom: 10px;
            line-height:   1.4;
        }

        #popup h2 span { color: #f0b429; }

        #popup .sous-pop {
            font-family:   Arial, sans-serif;
            font-size:     0.88rem;
            color:         #8a96aa;
            text-align:    center;
            margin-bottom: 28px;
            line-height:   1.7;
        }

        /* ══ CLOSE ══ */
        #close-btn {
            position:        absolute;
            top:             14px;
            right:           14px;
            width:           36px;
            height:          36px;
            background:      rgba(255,255,255,0.06);
            border:          1px solid rgba(255,255,255,0.1);
            border-radius:   50%;
            color:           #8a96aa;
            font-size:       1.2rem;
            cursor:          pointer;
            display:         flex;
            align-items:     center;
            justify-content: center;
            transition:      background 0.2s;
        }
        #close-btn:hover { background: rgba(255,255,255,0.12); color: #fff; }

        /* ══ INPUTS ══ */
        #popup input {
            display:       block;
            width:         100%;
            padding:       14px 16px;
            margin-bottom: 12px;
            background:    rgba(255,255,255,0.04);
            border:        1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color:         #ffffff;
            font-family:   Arial, sans-serif;
            font-size:     16px;
            outline:       none;
            transition:    border-color 0.2s;
        }
        #popup input:focus  { border-color: #f0b429; }
        #popup input::placeholder { color: #4a5568; }

        /* ══ BOUTON SUBMIT ══ */
        #popup .btn-submit {
            display:     block;
            width:       100%;
            padding:     16px;
            margin-top:  6px;
            background:  linear-gradient(135deg, #f0b429 0%, #e0a820 100%);
            border:      none;
            border-radius: 8px;
            color:       #1a1f2e;
            font-family: Arial, sans-serif;
            font-size:   1rem;
            font-weight: 700;
            cursor:      pointer;
            text-align:  center;
            letter-spacing: 0.02em;
            transition:  opacity 0.2s, transform 0.1s;
        }
        #popup .btn-submit:hover  { opacity: 0.92; }
        #popup .btn-submit:active { transform: scale(0.98); }

        /* ══ GARANTIE SOUS BOUTON ══ */
        #popup .popup-garantie {
            text-align:  center;
            font-size:   0.75rem;
            color:       #4a5568;
            margin-top:  14px;
            line-height: 1.6;
        }

        /* ══ ERREUR ══ */
        #msg-erreur {
            display:       none;
            background:    rgba(248,113,113,0.10);
            border:        1px solid rgba(248,113,113,0.35);
            border-radius: 6px;
            padding:       10px 14px;
            margin-bottom: 14px;
            font-family:   Arial, sans-serif;
            font-size:     0.85rem;
            color:         #f87171;
            text-align:    center;
        }

        /* Vos autres styles CSS restent inchangés */
        .bullets {
            list-style:  none;
            padding:     0;
            margin:      28px 0 0;
            text-align:  left;
        }
        .bullets li {
            position:    relative;
            padding:     14px 16px 14px 48px;
            margin-bottom: 10px;
            background:  rgba(255,255,255,0.03);
            border:      1px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            font-size:   0.93rem;
            color:       #bfc8d6;
            line-height: 1.5;
        }
        .bullets li::before {
            content:     attr(data-n);
            position:    absolute;
            left:        14px;
            top:         50%;
            transform:   translateY(-50%);
            width:       24px;
            height:      24px;
            background:  rgba(240,180,41,0.12);
            border:      1px solid rgba(240,180,41,0.35);
            border-radius: 50%;
            color:       #f0b429;
            font-size:   0.75rem;
            font-weight: 700;
            display:     flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

    <div class="logo">ECOSYSTÈME IMMO</div>

    <div class="hero">

        <span class="badge">Diagnostic gratuit · Places limitées par secteur</span>

        <h1>Vous faites peut-être<br><span>ces 7 erreurs sans le savoir.</span></h1>

        <p class="sous-titre">
            Chaque mois, des conseillers expérimentés perdent des vendeurs qualifiés —
            non par manque de travail, mais à cause de
            <strong style="color:#fff;">7 erreurs précises</strong>
            qui les rendent invisibles au moment exact où un vendeur cherche.
        </p>

        <ul class="bullets">
            <li data-n="1">Du trafic qui arrive — mais des contacts qui ne convertissent pas</li>
            <li data-n="2">Des contenus publiés — qui travaillent pour votre concurrence, pas pour vous</li>
            <li data-n="3">Une expertise réelle — mais aucun système pour la rendre visible au bon moment</li>
        </ul>

        <br>

        <button class="btn-cta" id="btn-ouvrir">→ Découvrir les 7 erreurs</button>

        <p class="rarete" style="margin-top: 18px;">
            <i class="fas fa-lock" style="margin-right: 6px;"></i>
            Accès limité — un seul conseiller par secteur géographique.
        </p>

    </div>

    <!-- ══ OVERLAY ══ -->
    <div id="overlay">
        <div id="popup">

            <button id="close-btn" aria-label="Fermer">×</button>

            <span class="popup-badge">Accès gratuit · Sans engagement</span>

            <h2>Découvrez les <span>7 erreurs</span><br>qui vous coûtent des vendeurs</h2>
            <p class="sous-pop">
                Renseignez vos informations pour accéder<br>
                à la démonstration complète.
            </p>

            <form method="POST" action="traitement.php" id="form-popup">
                <!-- Token CSRF caché -->
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="source" value="popup_7_erreurs">

                <!-- Message d'erreur -->
                <?php if ($errors): ?>
                    <div id="msg-erreur" style="display: block;"><?= $errors ?></div>
                <?php else: ?>
                    <div id="msg-erreur">⚠️ Merci de remplir tous les champs obligatoires.</div>
                <?php endif; ?>

                <!-- Champs du formulaire -->
                <input
                    type="text"
                    name="prenom"
                    id="prenom"
                    placeholder="Votre prénom *"
                    autocomplete="given-name"
                    value="<?= htmlspecialchars($old['prenom'] ?? '') ?>"
                    required
                >
                <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Votre email professionnel *"
                    autocomplete="email"
                    inputmode="email"
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                    required
                >
                <input
                    type="tel"
                    name="phone"
                    id="phone"
                    placeholder="Votre téléphone (optionnel)"
                    autocomplete="tel"
                    value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                >
                <input
                    type="text"
                    name="agency"
                    id="agency"
                    placeholder="Votre agence (optionnel)"
                    value="<?= htmlspecialchars($old['agency'] ?? '') ?>"
                >
                <input
                    type="text"
                    name="ville"
                    id="ville"
                    placeholder="Votre ville / secteur *"
                    value="<?= htmlspecialchars($old['ville'] ?? '') ?>"
                    required
                >

                <button type="submit" class="btn-submit">
                    Voir la démonstration →
                </button>

                <p class="popup-garantie">
                    🔒 Vos données restent confidentielles.<br>
                    * Champs obligatoires. Réponse sous 24h.
                </p>
            </form>
        </div>
    </div>

    <script>
        var overlay   = document.getElementById('overlay');
        var btnOuvrir = document.getElementById('btn-ouvrir');
        var btnClose  = document.getElementById('close-btn');

        // Ouvrir le popup
        btnOuvrir.addEventListener('click', function() {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Fermer le popup
        btnClose.addEventListener('click', fermer);
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) fermer();
        });

        function fermer() {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Validation du formulaire
        document.getElementById('form-popup').addEventListener('submit', function(e) {
            var prenom = document.getElementById('prenom').value.trim();
            var email = document.getElementById('email').value.trim();
            var ville = document.getElementById('ville').value.trim();
            var msgErreur = document.getElementById('msg-erreur');

            // Validation simple côté client
            if (!prenom || !email || !ville) {
                e.preventDefault();
                msgErreur.style.display = 'block';
                return;
            }

            // Validation basique de l'email
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                msgErreur.textContent = '⚠️ Veuillez entrer un email valide.';
                msgErreur.style.display = 'block';
                return;
            }

            msgErreur.style.display = 'none';
        });

        // Ouvrir le popup si une erreur est présente
        <?php if (isset($_GET['erreur']) || $errors): ?>
        window.addEventListener('DOMContentLoaded', function() {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        <?php endif; ?>
    </script>

</body>
</html>
