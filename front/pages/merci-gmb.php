<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Merci Journal GMB
 */
$pageTitle = "Votre Journal GMB est prêt ! | ÉCOSYSTÈME IMMO LOCAL+";
$pageDescription = "Téléchargez votre planning de communication Google My Business.";
$bodyClass = "theme-ressource";
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/merci-download.css">

<!-- HERO -->
<section class="merci-hero">
    <div class="merci-hero-content">
        <div class="merci-icon">📍</div>
        <h1>Votre Journal GMB est prêt !</h1>
        <p class="subtitle">Ne plus jamais vous demander "je poste quoi sur Google ?"</p>
    </div>
</section>

<!-- DOWNLOAD BOX -->
<section class="download-section">
    <div class="download-container">
        <div class="download-box fade-in-up">
            <h2>📥 Téléchargez votre journal maintenant</h2>
            <p>Cliquez sur le bouton ci-dessous pour accéder à votre planning de communication</p>
            
            <a href="/downloads/journal-gmb.pdf" class="btn-download" download>
                <span class="icon">📄</span>
                <span>Télécharger le Journal GMB</span>
            </a>
            
            <div class="download-note">
                💡 <strong>Astuce :</strong> Programmez 15 minutes chaque lundi pour préparer vos posts de la semaine !
            </div>
            
            <!-- Résumé du contenu -->
            <div class="content-summary">
                <h3>📋 Ce que contient votre journal :</h3>
                <ul>
                    <li><strong>Planning simple</strong> : 2 posts/semaine suffisent</li>
                    <li><strong>5 types de posts</strong> : preuve, conseil, marché, coulisses, pédagogie</li>
                    <li><strong>Exemples rédigés</strong> prêts à copier-coller</li>
                    <li><strong>Calendrier mensuel</strong> avec idées pré-remplies</li>
                    <li><strong>Bonnes pratiques</strong> photos et hashtags</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- NEXT STEPS -->
<section class="next-steps">
    <div class="next-steps-container">
        <h2>🚀 Et maintenant ?</h2>
        <p class="section-subtitle">Voici comment devenir visible sur Google</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Publiez votre 1er post</h3>
                <p>Utilisez un des exemples du journal et postez-le aujourd'hui.</p>
                <a href="/downloads/journal-gmb.pdf" class="btn btn-outline" download>Télécharger</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number">2</div>
                <h3>Réservez votre appel</h3>
                <p>Discutons de votre stratégie de visibilité locale complète.</p>
                <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn btn-primary" target="_blank">📞 Appel gratuit</a>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Faites votre audit</h3>
                <p>Découvrez votre score de visibilité Google actuel.</p>
                <a href="/ressources.php#audit-visibilite" class="btn btn-outline">🔍 Audit gratuit</a>
            </div>
        </div>
    </div>
</section>

<!-- AUTRES RESSOURCES -->
<section class="other-resources">
    <div class="other-resources-container">
        <h2>📚 Boostez votre visibilité locale</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">🔍</div>
                <h4>Audit Visibilité</h4>
                <p>Votre position Google en 2 minutes</p>
                <a href="/ressources.php#audit-visibilite">Lancer →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🧮</div>
                <h4>Estimateur Immo</h4>
                <p>Générez des leads propriétaires</p>
                <a href="/ressources.php#estimateur">Tester →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🧠</div>
                <h4>Diagnostic Vendeur</h4>
                <p>Qualifiez vos prospects</p>
                <a href="/ressources.php#diagnostic-vendeur">Télécharger →</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final">
    <div class="cta-final-container">
        <h2>Prêt à dominer Google dans votre ville ?</h2>
        <p>Réservez votre appel et découvrez la stratégie complète de visibilité locale</p>
        <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn-white" target="_blank">
            📞 Réserver mon appel gratuit
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>