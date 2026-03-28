<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Merci Matrice Vendeur
 */
$pageTitle = "Votre Matrice Vendeur est prête ! | ÉCOSYSTÈME IMMO LOCAL+";
$pageDescription = "Téléchargez la matrice pour distinguer les vendeurs rentables des épuisants.";
$bodyClass = "theme-ressource";
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/merci-download.css">

<!-- HERO -->
<section class="merci-hero">
    <div class="merci-hero-content">
        <div class="merci-icon">🧩</div>
        <h1>Votre Matrice Vendeur est prête !</h1>
        <p class="subtitle">Arrêtez de perdre du temps avec les mauvais profils</p>
    </div>
</section>

<!-- DOWNLOAD BOX -->
<section class="download-section">
    <div class="download-container">
        <div class="download-box fade-in-up">
            <h2>📥 Téléchargez votre matrice maintenant</h2>
            <p>Cliquez sur le bouton ci-dessous pour accéder à votre outil de filtrage</p>
            
            <a href="/downloads/matrice-vendeur.pdf" class="btn-download" download>
                <span class="icon">📄</span>
                <span>Télécharger la Matrice Vendeur</span>
            </a>
            
            <div class="download-note">
                💡 <strong>Astuce :</strong> Gardez cette matrice à portée de main lors de vos appels de prospection !
            </div>
            
            <!-- Résumé du contenu -->
            <div class="content-summary">
                <h3>📋 Ce que contient votre matrice :</h3>
                <ul>
                    <li>Les <strong>4 profils de vendeurs</strong> que vous rencontrez</li>
                    <li>Le <strong>seul profil vraiment rentable</strong> (et pourquoi)</li>
                    <li>Comment les <strong>identifier dès le premier contact</strong></li>
                    <li><strong>Questions de filtrage</strong> à poser</li>
                    <li><strong>Scripts de qualification</strong> prêts à l'emploi</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- NEXT STEPS -->
<section class="next-steps">
    <div class="next-steps-container">
        <h2>🚀 Et maintenant ?</h2>
        <p class="section-subtitle">Voici comment retrouver du plaisir dans le métier</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Analysez vos derniers RDV</h3>
                <p>Classez vos 5 derniers vendeurs dans la matrice. Vous verrez le pattern !</p>
                <a href="/downloads/matrice-vendeur.pdf" class="btn btn-outline" download>Télécharger</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number">2</div>
                <h3>Réservez votre appel</h3>
                <p>Discutons de comment attirer uniquement les bons profils.</p>
                <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn btn-primary" target="_blank">📞 Appel gratuit</a>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Complétez avec le Diagnostic</h3>
                <p>L'outil parfait pour qualifier en rendez-vous.</p>
                <a href="/ressources.php#diagnostic-vendeur" class="btn btn-outline">🧠 Diagnostic</a>
            </div>
        </div>
    </div>
</section>

<!-- AUTRES RESSOURCES -->
<section class="other-resources">
    <div class="other-resources-container">
        <h2>📚 Votre kit de qualification complet</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">🧠</div>
                <h4>Diagnostic Vendeur</h4>
                <p>Score de vendabilité en 5 min</p>
                <a href="/ressources.php#diagnostic-vendeur">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">✍️</div>
                <h4>Templates Réponses</h4>
                <p>Répondez aux objections</p>
                <a href="/ressources.php#templates-reponses">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🚀</div>
                <h4>Calculateur ROI</h4>
                <p>Justifiez votre valeur</p>
                <a href="/ressources.php#calculateur-roi">Télécharger →</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final">
    <div class="cta-final-container">
        <h2>Prêt à ne travailler qu'avec les bons vendeurs ?</h2>
        <p>Réservez votre appel et découvrez comment attirer uniquement les profils rentables</p>
        <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn-white" target="_blank">
            📞 Réserver mon appel gratuit
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>