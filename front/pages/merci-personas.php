<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Merci Téléchargement Guide Personas
 */
$pageTitle = "Votre Guide Personas est prêt ! | ÉCOSYSTÈME IMMO LOCAL+";
$pageDescription = "Téléchargez votre guide sur les 4 profils psychologiques de vos clients immobiliers.";
$bodyClass = "theme-personas";
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/merci-download.css">

<!-- HERO -->
<section class="merci-hero">
    <div class="merci-hero-content">
        <div class="merci-icon">🎭</div>
        <h1>Votre Guide Personas est prêt !</h1>
        <p class="subtitle">Découvrez les 4 profils psychologiques de vos clients</p>
    </div>
</section>

<!-- DOWNLOAD BOX -->
<section class="download-section">
    <div class="download-container">
        <div class="download-box fade-in-up">
            <h2>📥 Téléchargez votre guide maintenant</h2>
            <p>Cliquez sur le bouton ci-dessous pour accéder immédiatement à votre guide PDF</p>
            
            <a href="/downloads/guide-personas-immobilier.pdf" class="btn-download" download>
                <span class="icon">📄</span>
                <span>Télécharger le Guide Personas</span>
            </a>
            
            <div class="download-note">
                💡 <strong>Astuce :</strong> Enregistrez ce guide dans vos favoris pour y accéder facilement !
            </div>
            
            <!-- Résumé du contenu -->
            <div class="content-summary">
                <h3>📋 Ce que contient votre guide :</h3>
                <ul>
                    <li>Les 4 profils psychologiques de vos clients immobiliers</li>
                    <li>Comment identifier le profil de chaque prospect en 3 questions</li>
                    <li>Adapter votre discours et votre approche selon le profil</li>
                    <li>Les déclencheurs émotionnels de chaque type de client</li>
                    <li>Scripts de vente adaptés par persona (prêts à l'emploi)</li>
                    <li>Tableau récapitulatif des caractéristiques</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- NEXT STEPS -->
<section class="next-steps">
    <div class="next-steps-container">
        <h2>🚀 Et maintenant ?</h2>
        <p class="section-subtitle">Voici comment tirer le maximum de ce guide</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Lisez le guide</h3>
                <p>Prenez 15 minutes pour découvrir les 4 profils et leurs caractéristiques.</p>
                <a href="/downloads/guide-personas-immobilier.pdf" class="btn btn-outline" download>Lire maintenant</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number">2</div>
                <h3>Réservez votre appel</h3>
                <p>Discutons de comment appliquer ces personas à VOTRE zone géographique.</p>
                <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn btn-primary" target="_blank">📞 Appel gratuit</a>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Vérifiez votre zone</h3>
                <p>Assurez-vous que votre secteur est encore disponible en exclusivité.</p>
                <a href="/carte" class="btn btn-outline">🗺️ Voir la carte</a>
            </div>
        </div>
    </div>
</section>

<!-- AUTRES RESSOURCES -->
<section class="other-resources">
    <div class="other-resources-container">
        <h2>📚 Complétez votre formation</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">🔍</div>
                <h4>Guide SEO Local</h4>
                <p>Dominez Google dans votre zone géographique</p>
                <a href="/ressources#seo">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">✍️</div>
                <h4>Méthode MERE</h4>
                <p>Écrivez des articles qui convertissent</p>
                <a href="/ressources#mere">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">📄</div>
                <h4>Offre Complète</h4>
                <p>Découvrez toutes nos formules</p>
                <a href="/ressources#offre">Télécharger →</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final">
    <div class="cta-final-container">
        <h2>Prêt à conquérir votre zone ?</h2>
        <p>Réservez votre appel stratégique gratuit et découvrez comment dominer votre marché local</p>
        <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn-white" target="_blank">
            📞 Réserver mon appel gratuit
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>