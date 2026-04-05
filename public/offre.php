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
        error_log('Erreur chargement lead: ' . $e->getMessage());
    }
}

$ville = htmlspecialchars($leadData['ville'] ?? 'votre zone');
$prenom = htmlspecialchars($leadData['prenom'] ?? '');
$agence = htmlspecialchars($leadData['agence'] ?? '');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcosystèmeImmo — L'offre complète pour dominer votre zone</title>
    <meta name="description" content="Devenez la référence vendeur sur <?= $ville ?> avec notre système marketing immobilier clé en main. Exclusivité territoriale garantie.">
    <meta property="og:title" content="EcosystèmeImmo - Offre complète pour dominer votre zone">
    <meta property="og:description" content="Système marketing local clé en main pour capter des vendeurs sans dépendre des portails. Offre de lancement à 990€.">
    <meta property="og:image" content="https://votresite.com/images/og-image-offre.jpg">
    <meta property="og:url" content="https://votresite.com/offre.php">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="/js/lead-tracking.js" defer></script>
</head>
<body data-lead-id="<?= htmlspecialchars($leadId) ?>">

<div class="offre-page">
    <section class="hero hero-offre animate-on-scroll">
        <div class="hero-header">
            <div class="logo-container">
                <div class="logo logo-offre">Ecosystème<span>Immo</span></div>
                <span class="badge">Offre complète - Étape 2/3</span>
            </div>

            <h1 class="hero-title">
                Devenez <span class="highlight">la référence</span><br>
                vendeur sur <span id="zone-title"><?= $ville ?></span>
            </h1>

            <div class="hero-subtitle">
                <p>Un système marketing local clé en main pour capter des vendeurs<br>
                sans dépendre des portails - Exclusivité territoriale garantie</p>
            </div>
        </div>

        <?php if ($leadData): ?>
        <div class="lead-info animate-on-scroll">
            <p>Bonjour <?= $prenom ?>,</p>
            <p>Voici l'offre complète pour <strong><?= $ville ?></strong>
            <?php if (!empty($leadData['agence'])): ?>avec <strong><?= $agence ?></strong><?php endif; ?>.</p>
        </div>
        <?php endif; ?>

        <div class="video-presentation animate-on-scroll">
            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_ID?autoplay=0&amp;rel=0"
                        title="Présentation de l'offre EcosystèmeImmo"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            </div>
            <div class="video-overlay" aria-hidden="true">
                <div class="play-button">
                    <i class="fas fa-play"></i>
                    <span>Voir la présentation (2 min)</span>
                </div>
            </div>
        </div>
    </section>

    <section class="content-section animate-on-scroll">
        <p class="bloc-titre">Le problème</p>
        <p class="bloc-texte">
            Vous êtes compétent. Vous connaissez votre secteur.<br><br>
            Mais en ligne, vous êtes invisible.<br>
            Les leads sont partagés. Les portails contrôlent l'accès.<br><br>
            <strong>Ce n'est pas un problème de niveau. C'est un problème de système.</strong>
        </p>

        <p class="bloc-titre">La solution</p>
        <p class="bloc-texte">
            Un écosystème local déployé pour vous, sur <strong><?= $ville ?></strong>,
            avec votre nom. Vous devenez trouvable, identifiable,
            et contacté directement par les vendeurs.
        </p>
    </section>

    <section class="features-section animate-on-scroll">
        <h2 class="section-title">Ce que vous obtenez</h2>
        <div class="features-grid">
            <article class="feature-card">
                <div class="feature-icon"><i class="fas fa-globe"></i></div>
                <h3>Site local optimisé</h3>
                <p>Site web professionnel positionné sur les recherches vendeurs de <strong><?= $ville ?></strong> avec SEO local intégré.</p>
                <span class="feature-tag">Inclus</span>
            </article>

            <article class="feature-card">
                <div class="feature-icon"><i class="fas fa-search-location"></i></div>
                <h3>Audit de zone exclusif</h3>
                <p>Analyse complète de votre marché local avec opportunités identifiées et recommandations actionnables.</p>
                <span class="feature-tag">Inclus</span>
            </article>

            <article class="feature-card">
                <div class="feature-icon"><i class="fas fa-bullseye"></i></div>
                <h3>Positionnement unique</h3>
                <p>Stratégie de différenciation claire pour devenir la référence vendeur dans votre zone.</p>
                <span class="feature-tag">Inclus</span>
            </article>

            <article class="feature-card">
                <div class="feature-icon"><i class="fas fa-file-alt"></i></div>
                <h3>Contenus prêts à l'emploi</h3>
                <p>Pages de capture, articles et emails rédigés pour convertir les vendeurs en rendez-vous qualifiés.</p>
                <span class="feature-tag">Inclus</span>
            </article>

            <article class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Tableau de bord</h3>
                <p>Suivi en temps réel des performances, des contacts entrants et des opportunités générées.</p>
                <span class="feature-tag">Inclus</span>
            </article>

            <article class="feature-card">
                <div class="feature-icon"><i class="fas fa-headset"></i></div>
                <h3>Support prioritaire</h3>
                <p>Accompagnement dédié pour déployer rapidement votre dispositif et optimiser vos résultats.</p>
                <span class="feature-tag">Inclus</span>
            </article>
        </div>
    </section>

    <section class="testimonials-section animate-on-scroll">
        <h2 class="section-title">Ils ont transformé leur activité</h2>
        <div class="testimonials-grid">
            <article class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">J</div>
                    <div>
                        <h4>Julien R.</h4>
                        <p>Nantes</p>
                    </div>
                </div>
                <div class="testimonial-rating" aria-label="5 étoiles">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Le système est incroyablement bien structuré. En 3 semaines, j'ai capté 5 nouveaux mandats vendeurs directement via mon site."</p>
            </article>

            <article class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">C</div>
                    <div>
                        <h4>Claire M.</h4>
                        <p>Bordeaux</p>
                    </div>
                </div>
                <div class="testimonial-rating" aria-label="5 étoiles">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Tout est clair et orienté conversion. J'ai enfin une méthode fiable pour générer des vendeurs localement."</p>
            </article>

            <article class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">S</div>
                    <div>
                        <h4>Stéphanie L.</h4>
                        <p>Lannion</p>
                    </div>
                </div>
                <div class="testimonial-rating" aria-label="5 étoiles">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"En moins d'un mois, j'ai obtenu des contacts qualifiés sur ma zone. Le support est rapide et très pro."</p>
            </article>
        </div>
    </section>

    <section class="pricing-section animate-on-scroll">
        <div class="pricing-header">
            <h2>Accès complet à l'écosystème</h2>
            <p>Offre de lancement - Disponible uniquement cette semaine</p>
        </div>

        <div class="pricing-card">
            <div class="price">
                <span class="original-price">1490€</span>
                <span class="current-price">990€</span>
                <span class="price-period">Paiement unique</span>
            </div>

            <div class="price-features">
                <div class="feature-list">
                    <div class="feature-item"><i class="fas fa-check-circle"></i> Site web local optimisé</div>
                    <div class="feature-item"><i class="fas fa-check-circle"></i> Audit de zone exclusif</div>
                    <div class="feature-item"><i class="fas fa-check-circle"></i> Contenus prêts à l'emploi</div>
                    <div class="feature-item"><i class="fas fa-check-circle"></i> Exclusivité territoriale</div>
                    <div class="feature-item"><i class="fas fa-check-circle"></i> Support prioritaire</div>
                </div>
            </div>

            <div class="price-cta">
                <form id="qualification-form" method="POST" action="/traitement-formulaire.php">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="lead_id" value="<?= htmlspecialchars($leadId) ?>">

                    <button class="btn-primary" type="submit" id="cta-button">
                        Vérifier la disponibilité de ma zone
                    </button>
                </form>
                <p class="cta-subtext">
                    <i class="fas fa-lock"></i> Vérification gratuite - Réponse sous 24h
                </p>
            </div>
        </div>

        <div class="guarantee">
            <i class="fas fa-shield-alt"></i>
            <span>Garantie satisfaction 30 jours - Remboursement intégral si insatisfait</span>
        </div>
    </section>

    <section class="scarcity-section animate-on-scroll">
        <div class="scarcity-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="scarcity-content">
            <h3>Disponibilité limitée</h3>
            <p>Nous n'acceptons qu'<strong>un seul conseiller par zone</strong> pour garantir l'exclusivité territoriale.</p>
            <div class="scarcity-timer">
                <span>Votre secteur <strong><?= $ville ?></strong> définitivement verrouillé après validation.</span>
            </div>
            <div class="scarcity-stats">
                <span>✓ 87% des zones principales déjà réservées</span>
                <span>✓ 3 zones disponibles dans votre département</span>
            </div>
        </div>
    </section>

    <section class="faq-container animate-on-scroll">
        <h2 class="faq-title">Questions fréquentes</h2>

        <div class="faq-list">
            <article class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false">
                    <span>Combien de temps pour voir les premiers résultats ?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Les premiers contacts vendeurs apparaissent généralement entre 2 et 4 semaines après la mise en ligne du système.</p>
                </div>
            </article>

            <article class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false">
                    <span>Puis-je personnaliser les contenus ?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Oui. Tous les contenus sont modifiables pour s'aligner sur votre image de marque et vos spécificités locales.</p>
                </div>
            </article>

            <article class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false">
                    <span>Comment fonctionne l'exclusivité territoriale ?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Une fois votre zone validée, elle est réservée et nous n'intégrons aucun autre conseiller sur le même secteur.</p>
                </div>
            </article>

            <article class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false">
                    <span>Y a-t-il une garantie ?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Oui, vous bénéficiez d'une garantie satisfaction 30 jours avec remboursement intégral en cas d'insatisfaction.</p>
                </div>
            </article>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // FAQ interactif
    document.querySelectorAll('.faq-item').forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');

        question.addEventListener('click', function () {
            const isOpen = item.classList.toggle('is-open');
            question.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            answer.style.maxHeight = isOpen ? answer.scrollHeight + 'px' : '0px';
        });
    });

    // Soumission formulaire avec feedback visuel
    const form = document.getElementById('qualification-form');
    const ctaButton = document.getElementById('cta-button');

    if (form && ctaButton) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            ctaButton.style.transform = 'scale(0.97)';
            setTimeout(() => {
                ctaButton.style.transform = 'scale(1)';
            }, 150);

            const leadId = form.querySelector('[name="lead_id"]').value;
            if (!leadId) {
                alert('Une erreur est survenue. Veuillez recharger la page.');
                return;
            }

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    Accept: 'application/json'
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
    }
});
</script>

</body>
</html>
