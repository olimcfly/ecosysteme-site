<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Merci Diagnostic Vendeur
 */
$pageTitle = "Votre Diagnostic Vendeur est prêt ! | ÉCOSYSTÈME IMMO LOCAL+";
$pageDescription = "Téléchargez votre diagnostic pour identifier les blocages de vos vendeurs.";
$bodyClass = "theme-diagnostic";
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/merci-download.css">

<!-- HERO -->
<section class="merci-hero">
    <div class="merci-hero-content">
        <div class="merci-icon">🧠</div>
        <h1>Votre Diagnostic Vendeur est prêt !</h1>
        <p class="subtitle">Identifiez en 5 minutes pourquoi un bien ne se vend pas</p>
    </div>
</section>

<!-- DOWNLOAD BOX -->
<section class="download-section">
    <div class="download-container">
        <div class="download-box fade-in-up">
            <h2>📥 Téléchargez votre diagnostic maintenant</h2>
            <p>Cliquez sur le bouton ci-dessous pour accéder immédiatement à votre outil</p>
            
            <a href="/downloads/diagnostic-vendeur.pdf" class="btn-download" download>
                <span class="icon">📄</span>
                <span>Télécharger le Diagnostic Vendeur</span>
            </a>
            
            <div class="download-note">
                💡 <strong>Astuce :</strong> Imprimez ce diagnostic et utilisez-le à chaque rendez-vous vendeur !
            </div>
            
            <!-- Résumé du contenu -->
            <div class="content-summary">
                <h3>📋 Ce que contient votre diagnostic :</h3>
                <ul>
                    <li>Un <strong>score de vendabilité</strong> (0–100)</li>
                    <li>Identification du <strong>blocage principal</strong> (prix / marché / stratégie / psychologie)</li>
                    <li><strong>3 recommandations</strong> concrètes et actionnables</li>
                    <li>Questions clés pour <strong>pré-qualifier</strong> vos vendeurs</li>
                    <li>Grille d'évaluation <strong>prête à l'emploi</strong></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- NEXT STEPS -->
<section class="next-steps">
    <div class="next-steps-container">
        <h2>🚀 Et maintenant ?</h2>
        <p class="section-subtitle">Voici comment tirer le maximum de ce diagnostic</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Testez le diagnostic</h3>
                <p>Utilisez-le sur votre prochain rendez-vous vendeur pour voir sa puissance.</p>
                <a href="/downloads/diagnostic-vendeur.pdf" class="btn btn-outline" download>Télécharger</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number">2</div>
                <h3>Réservez votre appel</h3>
                <p>Discutons de comment automatiser ce diagnostic sur votre zone.</p>
                <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn btn-primary" target="_blank">📞 Appel gratuit</a>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Vérifiez votre zone</h3>
                <p>Assurez-vous que votre secteur est encore disponible en exclusivité.</p>
                <a href="/verifier-zone.php" class="btn btn-outline">🗺️ Vérifier</a>
            </div>
        </div>
    </div>
</section>

<!-- AUTRES RESSOURCES -->
<section class="other-resources">
    <div class="other-resources-container">
        <h2>📚 Complétez votre boîte à outils</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">🧩</div>
                <h4>Matrice Vendeur</h4>
                <p>Rentable vs Épuisant : filtrez les bons profils</p>
                <a href="/ressources.php#matrice-vendeur">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">✍️</div>
                <h4>Templates Réponses</h4>
                <p>Emails et WhatsApp prêts à l'emploi</p>
                <a href="/ressources.php#templates-reponses">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🚀</div>
                <h4>Calculateur ROI</h4>
                <p>Prouvez la rentabilité en 1 clic</p>
                <a href="/ressources.php#calculateur-roi">Télécharger →</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final">
    <div class="cta-final-container">
        <h2>Prêt à ne plus perdre de temps avec les mauvais vendeurs ?</h2>
        <p>Réservez votre appel stratégique gratuit et découvrez comment automatiser votre qualification</p>
        <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn-white" target="_blank">
            📞 Réserver mon appel gratuit
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>