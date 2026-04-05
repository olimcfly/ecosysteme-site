<?php
declare(strict_types=1);
require_once __DIR__ . '/tracking.php';

// Récupération du lead_id depuis l'URL
$leadId = $_GET['lead'] ?? '';
$leadData = [];

// Si lead_id présent, charger les données du lead depuis la base
if ($leadId && file_exists(__DIR__ . '/../config/loader.php')) {
    try {
        require_once __DIR__ . '/../config/loader.php';
        $pdo = ConfigLoader::getPDO();

        $stmt = $pdo->prepare("SELECT prenom, email, ville, agence FROM leads WHERE id = ?");
        $stmt->execute([$leadId]);
        $leadData = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    } catch (Exception $e) {
        error_log("Erreur chargement lead: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcosystèmeImmo — L'offre complète pour dominer votre zone</title>
    <meta name="description" content="Devenez la référence vendeur sur votre zone avec notre système marketing clé en main. Exclusivité territoriale, site optimisé et outils de conversion.">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="/js/lead-tracking.js" defer></script>
</head>
<body data-lead-id="<?= htmlspecialchars($leadId) ?>">

<div class="logo">Ecosystème Immo</div>

<div class="hero offre-page">

    <span class="badge">Offre complète - Étape 2/3</span>

    <h1>Devenez la <span>référence vendeur</span><br>sur <span id="zone-title"><?= htmlspecialchars($leadData['ville'] ?? 'votre zone') ?></span></h1>

    <?php if ($leadData): ?>
    <div class="lead-info">
        <p>Bonjour <?= htmlspecialchars($leadData['prenom']) ?>,</p>
        <p>Voici l'offre complète pour <strong><?= htmlspecialchars($leadData['ville']) ?></strong>
        <?php if ($leadData['agence']): ?>avec <strong><?= htmlspecialchars($leadData['agence']) ?></strong><?php endif; ?>.</p>
    </div>
    <?php endif; ?>

    <p class="sous-titre">
        Un système marketing local clé en main pour capter des vendeurs
        sans dépendre des portails.
    </p>

    <div class="video-container">
        <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_ID" allowfullscreen></iframe>
        <p class="video-caption">Présentation complète de l'offre (2 min)</p>
    </div>

    <div class="sep"></div>

    <p class="bloc-titre">Le problème</p>
    <p class="bloc-texte">
        Vous êtes compétent. Vous connaissez votre secteur.<br><br>
        Mais en ligne, vous êtes invisible.<br>
        Les leads sont partagés. Les portails contrôlent l'accès.<br><br>
        <strong>Ce n'est pas un problème de niveau. C'est un problème de système.</strong>
    </p>

    <div class="sep"></div>

    <p class="bloc-titre">La solution</p>
    <p class="bloc-texte">
        Un écosystème local déployé pour vous, sur <strong><?= htmlspecialchars($leadData['ville'] ?? 'votre zone') ?></strong>,
        avec votre nom. Vous devenez trouvable, identifiable,
        et contacté directement par les vendeurs.
    </p>

    <div class="sep"></div>

    <p class="bloc-titre">Ce que vous obtenez</p>

    <div class="cards">
        <div class="card">
            <div class="card-icon"><i class="fas fa-globe"></i></div>
            <div class="card-content">
                <h3>Site local optimisé</h3>
                <p>Site web professionnel positionné sur les recherches vendeurs de <strong><?= htmlspecialchars($leadData['ville'] ?? 'votre ville') ?></strong>.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-icon"><i class="fas fa-search-location"></i></div>
            <div class="card-content">
                <h3>Audit de zone exclusif</h3>
                <p>Analyse complète de <strong><?= htmlspecialchars($leadData['ville'] ?? 'votre secteur') ?></strong> avec opportunités identifiées.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-icon"><i class="fas fa-bullseye"></i></div>
            <div class="card-content">
                <h3>Positionnement unique</h3>
                <p>Stratégie différenciante pour vous démarquer des autres agences.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-icon"><i class="fas fa-file-alt"></i></div>
            <div class="card-content">
                <h3>Contenus prêts à l'emploi</h3>
                <p>Pages de capture, articles et emails rédigés pour convertir.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-icon"><i class="fas fa-comments"></i></div>
            <div class="card-content">
                <h3>Scripts de conversion</h3>
                <p>Modèles de réponses pour transformer les contacts en rendez-vous.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-icon"><i class="fas fa-chart-line"></i></div>
            <div class="card-content">
                <h3>Tableau de bord</h3>
                <p>Suivi en temps réel des leads et performances de votre zone.</p>
            </div>
        </div>
    </div>

    <div class="sep"></div>

    <p class="bloc-titre">Bonus exclusifs</p>
    <div class="bonus-grid">
        <div class="bonus-item">
            <i class="fas fa-lock"></i>
            <span>Exclusivité territoriale</span>
        </div>
        <div class="bonus-item">
            <i class="fas fa-headset"></i>
            <span>Support prioritaire</span>
        </div>
        <div class="bonus-item">
            <i class="fas fa-sync-alt"></i>
            <span>Mises à jour gratuites</span>
        </div>
        <div class="bonus-item">
            <i class="fas fa-shield-alt"></i>
            <span>Garantie satisfaction</span>
        </div>
    </div>

    <div class="sep"></div>

    <p class="bloc-titre">Ils ont rejoint l'écosystème</p>

    <div class="cards">
        <div class="card testimonial">
            <div class="card-content">
                <h3>Julien — Nantes</h3>
                <p><em>"C'est structuré. Je vois enfin comment capter des vendeurs localement. Le système est clé en main et les résultats sont là."</em></p>
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>

        <div class="card testimonial">
            <div class="card-content">
                <h3>Claire — Bordeaux</h3>
                <p><em>"Tout est clair. On comprend exactement comment se positionner. Le support est réactif et l'exclusivité de zone est un vrai plus."</em></p>
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
        </div>

        <div class="card testimonial">
            <div class="card-content">
                <h3>Stéphanie — Lannion</h3>
                <p><em>"La mise en place est rapide et bien cadrée. J'ai déjà reçu mes premiers contacts qualifiés après seulement 2 semaines."</em></p>
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>

    <p class="bloc-texte">
        Les systèmes sont récents mais les premiers résultats sont prometteurs.
        Nous partagerons des données de performance consolidées dès que disponibles.
    </p>

    <div class="sep"></div>

    <div class="prix-bloc">
        <div class="prix-label">Accès complet</div>
        <div class="prix-montant">990€ <span class="prix-ancien">1490€</span></div>
        <div class="prix-detail">paiement unique - <strong>Offre de lancement</strong></div>

        <p class="prix-inclus">
            Site local · Tunnel de capture · Contenus rédigés · Audit de zone ·
            Positionnement stratégique · Scripts de conversion · Tableau de bord ·
            Support prioritaire · Exclusivité de zone · Mises à jour gratuites
        </p>

        <div class="garantie">
            <i class="fas fa-shield-alt"></i>
            <span>Garantie satisfaction 30 jours</span>
        </div>
    </div>

    <div class="urgence-bloc">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <strong>1 seul conseiller par zone.</strong><br>
            Votre secteur <strong><?= htmlspecialchars($leadData['ville'] ?? 'sera') ?></strong> définitivement verrouillé après validation.
        </div>
    </div>

    <div class="bloc-cta">
        <form id="qualification-form" method="POST" action="/traitement-formulaire.php">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <input type="hidden" name="step" value="2">
            <input type="hidden" name="lead_id" value="<?= htmlspecialchars($leadId) ?>">

            <button type="submit" class="btn-cta">
                Vérifier la disponibilité de ma zone
            </button>

            <p class="sous-cta">
                <i class="fas fa-lock"></i> Vérification gratuite — réponse sous 24h
            </p>
        </form>
    </div>

    <div class="faq-section">
        <h2>Questions fréquentes</h2>

        <div class="faq-item">
            <div class="faq-question">
                <i class="fas fa-plus"></i>
                Combien de temps pour mettre en place le système ?
            </div>
            <div class="faq-answer">
                <p>La mise en place complète prend entre 7 et 14 jours. Nous commençons par l'audit de votre zone, puis déployons le site et les contenus optimisés pour votre secteur.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <i class="fas fa-plus"></i>
                Puis-je personnaliser les contenus ?
            </div>
            <div class="faq-answer">
                <p>Absolument ! Tous les contenus sont fournis en version modifiable. Vous pouvez les adapter à votre style et à votre marché local tout en conservant la structure optimisée.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <i class="fas fa-plus"></i>
                Comment fonctionne l'exclusivité territoriale ?
            </div>
            <div class="faq-answer">
                <p>Une fois votre zone validée, elle est définitivement réservée à votre agence. Aucun autre conseiller de notre réseau ne pourra cibler votre secteur géographique.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <i class="fas fa-plus"></i>
                Que se passe-t-il si je ne suis pas satisfait ?
            </div>
            <div class="faq-answer">
                <p>Nous offrons une garantie satisfaction de 30 jours. Si le système ne répond pas à vos attentes, nous vous remboursons intégralement sans poser de questions.</p>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du FAQ
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const icon = question.querySelector('i');

        question.addEventListener('click', () => {
            const isOpen = answer.style.display === 'block';

            if (isOpen) {
                answer.style.display = 'none';
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            } else {
                answer.style.display = 'block';
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        });
    });

    // Gestion du formulaire
    const form = document.getElementById('qualification-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validation simple côté client
        const leadId = form.querySelector('[name="lead_id"]').value;
        if (!leadId) {
            alert('Une erreur est survenue. Veuillez recharger la page.');
            return;
        }

        // Soumission via fetch pour éviter le rechargement
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/formulaire.php?lead=' + encodeURIComponent(leadId);
            } else {
                alert(data.message || 'Une erreur est survenue');
            }
        })
        .catch(() => {
            alert('Erreur de connexion. Veuillez réessayer.');
        });
    });
});
</script>

</body>
</html>
