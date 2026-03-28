<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Merci Calculateur ROI
 */
$pageTitle = "Votre Calculateur ROI est prêt ! | ÉCOSYSTÈME IMMO LOCAL+";
$pageDescription = "Téléchargez votre calculateur pour mesurer le retour sur investissement marketing.";
$bodyClass = "theme-outil";
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/merci-download.css">

<!-- HERO -->
<section class="merci-hero" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
    <div class="merci-hero-content">
        <div class="merci-icon">🚀</div>
        <h1>Votre Calculateur ROI est prêt !</h1>
        <p class="subtitle">Mesurez votre retour sur investissement en 2 minutes</p>
    </div>
</section>

<!-- DOWNLOAD BOX -->
<section class="download-section">
    <div class="download-container">
        <div class="download-box fade-in-up">
            <h2>📥 Téléchargez votre calculateur maintenant</h2>
            <p>Cliquez sur le bouton ci-dessous pour accéder à votre outil de calcul</p>
            
            <a href="/downloads/calculateur-roi.xlsx" class="btn-download" style="background: linear-gradient(135deg, #10b981, #059669);" download>
                <span class="icon">📊</span>
                <span>Télécharger le Calculateur ROI</span>
            </a>
            
            <div class="download-note">
                💡 <strong>Astuce :</strong> Remplissez les cases jaunes et les résultats s'affichent automatiquement !
            </div>
            
            <!-- Résumé du contenu -->
            <div class="content-summary">
                <h3>📋 Ce que contient votre calculateur :</h3>
                <ul>
                    <li><strong>Calcul automatique</strong> du coût par lead</li>
                    <li><strong>Taux de conversion</strong> prospects → mandats</li>
                    <li><strong>ROI mensuel et annuel</strong> de vos actions marketing</li>
                    <li><strong>Comparaison</strong> entre canaux (SEO, pubs, réseau...)</li>
                    <li><strong>Projection</strong> sur 12 mois</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- NEXT STEPS -->
<section class="next-steps">
    <div class="next-steps-container">
        <h2>🚀 Et maintenant ?</h2>
        <p class="section-subtitle">Voici comment maximiser votre ROI</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Remplissez le calculateur</h3>
                <p>Entrez vos données actuelles pour voir votre situation réelle.</p>
                <a href="/downloads/calculateur-roi.xlsx" class="btn btn-outline" download>Télécharger</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number">2</div>
                <h3>Réservez votre appel</h3>
                <p>Analysons ensemble vos chiffres et optimisons votre stratégie.</p>
                <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn btn-primary" target="_blank">📞 Appel gratuit</a>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Vérifiez votre zone</h3>
                <p>L'exclusivité territoriale multiplie votre ROI.</p>
                <a href="/verifier-zone.php" class="btn btn-outline">📍 Vérifier</a>
            </div>
        </div>
    </div>
</section>

<!-- AUTRES RESSOURCES -->
<section class="other-resources">
    <div class="other-resources-container">
        <h2>📚 Maximisez vos résultats</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">🧮</div>
                <h4>Estimateur Immo</h4>
                <p>Générez des leads propriétaires</p>
                <a href="/ressources.php#estimateur">Tester →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🔍</div>
                <h4>Audit Visibilité</h4>
                <p>Où en êtes-vous sur Google ?</p>
                <a href="/ressources.php#audit-visibilite">Lancer →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">📍</div>
                <h4>Journal GMB</h4>
                <p>Boostez votre visibilité locale</p>
                <a href="/ressources.php#journal-gmb">Télécharger →</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
    <div class="cta-final-container">
        <h2>Prêt à multiplier votre ROI par 3 ?</h2>
        <p>Réservez votre appel et découvrez la stratégie qui génère le meilleur retour</p>
        <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn-white" target="_blank">
            📞 Réserver mon appel gratuit
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>