<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Merci Audit Visibilité
 */
$pageTitle = "Votre Audit Visibilité est en cours ! | ÉCOSYSTÈME IMMO LOCAL+";
$pageDescription = "Découvrez votre score de visibilité Google dans votre ville.";
$bodyClass = "theme-outil";
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/merci-download.css">

<!-- HERO -->
<section class="merci-hero">
    <div class="merci-hero-content">
        <div class="merci-icon">🔍</div>
        <h1>Votre Audit Visibilité est lancé !</h1>
        <p class="subtitle">Découvrez si vous êtes visible ou invisible sur Google</p>
    </div>
</section>

<!-- DOWNLOAD BOX -->
<section class="download-section">
    <div class="download-container">
        <div class="download-box fade-in-up">
            <h2>📊 Votre audit arrive par email</h2>
            <p>Nous analysons votre visibilité Google dans votre ville. Vous recevrez les résultats sous 24h.</p>
            
            <div class="audit-preview">
                <div class="audit-item">
                    <span class="audit-label">Position Google Maps</span>
                    <span class="audit-value">En cours d'analyse...</span>
                </div>
                <div class="audit-item">
                    <span class="audit-label">Mots-clés locaux</span>
                    <span class="audit-value">En cours d'analyse...</span>
                </div>
                <div class="audit-item">
                    <span class="audit-label">Score global</span>
                    <span class="audit-value">En cours d'analyse...</span>
                </div>
            </div>
            
            <div class="download-note">
                💡 <strong>Note :</strong> Vérifiez vos spams si vous ne recevez pas l'audit sous 24h !
            </div>
            
            <!-- Ce que vous allez découvrir -->
            <div class="content-summary">
                <h3>📋 Ce que vous allez découvrir :</h3>
                <ul>
                    <li>Votre <strong>position réelle</strong> sur les recherches locales</li>
                    <li>Vos <strong>mots-clés locaux</strong> principaux (et ceux que vous ratez)</li>
                    <li>Vos <strong>axes d'amélioration</strong> prioritaires</li>
                    <li>Comparaison avec vos <strong>concurrents locaux</strong></li>
                    <li><strong>Plan d'action</strong> personnalisé</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- NEXT STEPS -->
<section class="next-steps">
    <div class="next-steps-container">
        <h2>🚀 En attendant votre audit</h2>
        <p class="section-subtitle">Préparez-vous à agir dès réception</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Vérifiez votre fiche GMB</h3>
                <p>Assurez-vous que toutes vos infos sont à jour sur Google.</p>
                <a href="https://business.google.com" class="btn btn-outline" target="_blank">Voir ma fiche</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number">2</div>
                <h3>Réservez votre appel</h3>
                <p>Analysons ensemble les résultats de votre audit.</p>
                <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn btn-primary" target="_blank">📞 Appel gratuit</a>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Téléchargez le Journal GMB</h3>
                <p>Commencez à poster pendant que l'audit s'exécute.</p>
                <a href="/ressources.php#journal-gmb" class="btn btn-outline">📍 Journal GMB</a>
            </div>
        </div>
    </div>
</section>

<!-- AUTRES RESSOURCES -->
<section class="other-resources">
    <div class="other-resources-container">
        <h2>📚 Préparez votre stratégie</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">📍</div>
                <h4>Journal GMB</h4>
                <p>Planning de posts Google</p>
                <a href="/ressources.php#journal-gmb">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🧮</div>
                <h4>Estimateur Immo</h4>
                <p>Captez des leads propriétaires</p>
                <a href="/ressources.php#estimateur">Tester →</a>
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
        <h2>Prêt à passer de invisible à incontournable ?</h2>
        <p>Réservez votre appel et transformons votre audit en plan d'action concret</p>
        <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn-white" target="_blank">
            📞 Réserver mon appel gratuit
        </a>
    </div>
</section>

<style>
.audit-preview {
    background: #f8fafc;
    border-radius: 12px;
    padding: 20px;
    margin: 20px 0;
}
.audit-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}
.audit-item:last-child { border-bottom: none; }
.audit-label { font-weight: 500; color: #4a5568; }
.audit-value { color: #667eea; font-style: italic; }
</style>

<?php require_once 'includes/footer.php'; ?>