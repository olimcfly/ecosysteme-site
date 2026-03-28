<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Merci Estimateur
 */
$pageTitle = "Votre accès Estimateur est prêt ! | ÉCOSYSTÈME IMMO LOCAL+";
$pageDescription = "Testez l'estimateur immobilier et découvrez comment l'intégrer à votre activité.";
$bodyClass = "theme-outil";
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/merci-download.css">

<!-- HERO -->
<section class="merci-hero">
    <div class="merci-hero-content">
        <div class="merci-icon">🧮</div>
        <h1>Votre accès Estimateur est prêt !</h1>
        <p class="subtitle">Testez l'outil et générez vos premiers leads propriétaires</p>
    </div>
</section>

<!-- DOWNLOAD BOX -->
<section class="download-section">
    <div class="download-container">
        <div class="download-box fade-in-up">
            <h2>🧮 Accédez à l'estimateur démo</h2>
            <p>Cliquez sur le bouton ci-dessous pour tester l'estimateur en conditions réelles</p>
            
            <a href="/estimateur-demo.php" class="btn-download">
                <span class="icon">🚀</span>
                <span>Tester l'Estimateur</span>
            </a>
            
            <div class="download-note">
                💡 <strong>Astuce :</strong> Testez avec une vraie adresse de votre secteur pour voir le rendu !
            </div>
            
            <!-- Résumé du contenu -->
            <div class="content-summary">
                <h3>📋 Ce que vous allez découvrir :</h3>
                <ul>
                    <li><strong>Estimation indicative</strong> basée sur les données du marché</li>
                    <li><strong>Capture email</strong> automatique et RGPD-compliant</li>
                    <li><strong>Message pédagogique</strong> qui cadre les attentes</li>
                    <li>Interface <strong>personnalisable</strong> à vos couleurs</li>
                    <li>Intégration possible sur <strong>votre site</strong></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- NEXT STEPS -->
<section class="next-steps">
    <div class="next-steps-container">
        <h2>🚀 Et maintenant ?</h2>
        <p class="section-subtitle">Voici comment exploiter cet outil au maximum</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Testez l'estimateur</h3>
                <p>Faites une estimation sur votre ville pour voir le parcours utilisateur.</p>
                <a href="/estimateur-demo.php" class="btn btn-outline">Tester</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number">2</div>
                <h3>Réservez votre appel</h3>
                <p>Discutons de l'intégration de cet estimateur sur votre propre site.</p>
                <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn btn-primary" target="_blank">📞 Appel gratuit</a>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Vérifiez votre zone</h3>
                <p>L'estimateur sera personnalisé pour VOTRE secteur exclusif.</p>
                <a href="/verifier-zone.php" class="btn btn-outline">🗺️ Vérifier</a>
            </div>
        </div>
    </div>
</section>

<!-- AUTRES RESSOURCES -->
<section class="other-resources">
    <div class="other-resources-container">
        <h2>📚 Complétez votre arsenal</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">🧠</div>
                <h4>Diagnostic Vendeur</h4>
                <p>Qualifiez vos vendeurs en 5 minutes</p>
                <a href="/ressources.php#diagnostic-vendeur">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🔍</div>
                <h4>Audit Visibilité</h4>
                <p>Votre score Google local</p>
                <a href="/ressources.php#audit-visibilite">Lancer →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🚀</div>
                <h4>Calculateur ROI</h4>
                <p>Prouvez la rentabilité</p>
                <a href="/ressources.php#calculateur-roi">Télécharger →</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final">
    <div class="cta-final-container">
        <h2>Prêt à générer des leads propriétaires en automatique ?</h2>
        <p>Réservez votre appel et découvrez comment intégrer l'estimateur sur votre zone exclusive</p>
        <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn-white" target="_blank">
            📞 Réserver mon appel gratuit
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>