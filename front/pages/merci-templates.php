<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Merci Templates Réponses
 */
$pageTitle = "Vos Templates Réponses sont prêts ! | ÉCOSYSTÈME IMMO LOCAL+";
$pageDescription = "Téléchargez vos templates de réponses prêts à l'emploi pour vendeurs et acheteurs.";
$bodyClass = "theme-ressource";
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/merci-download.css">

<!-- HERO -->
<section class="merci-hero" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
    <div class="merci-hero-content">
        <div class="merci-icon">✍️</div>
        <h1>Vos Templates Réponses sont prêts !</h1>
        <p class="subtitle">Ne réinventez plus jamais la roue pour répondre</p>
    </div>
</section>

<!-- DOWNLOAD BOX -->
<section class="download-section">
    <div class="download-container">
        <div class="download-box fade-in-up">
            <h2>📥 Téléchargez vos templates maintenant</h2>
            <p>Cliquez sur le bouton ci-dessous pour accéder à votre kit de réponses</p>
            
            <a href="/downloads/templates-reponses.pdf" class="btn-download" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);" download>
                <span class="icon">📄</span>
                <span>Télécharger les Templates</span>
            </a>
            
            <div class="download-note">
                💡 <strong>Astuce :</strong> Copiez ces templates dans vos réponses rapides WhatsApp et Gmail !
            </div>
            
            <!-- Résumé du contenu -->
            <div class="content-summary">
                <h3>📋 Ce que contient votre kit :</h3>
                <ul>
                    <li><strong>Réponses objections vendeurs</strong> ("vos honoraires sont trop élevés", "je vais vendre seul"...)</li>
                    <li><strong>Réponses objections acheteurs</strong> ("c'est trop cher", "je veux réfléchir"...)</li>
                    <li><strong>Relances polies</strong> après visite sans retour</li>
                    <li><strong>Messages WhatsApp</strong> pré-rédigés</li>
                    <li><strong>Emails de suivi</strong> automatisables</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- NEXT STEPS -->
<section class="next-steps">
    <div class="next-steps-container">
        <h2>🚀 Et maintenant ?</h2>
        <p class="section-subtitle">Voici comment gagner 2h par jour</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Configurez vos réponses rapides</h3>
                <p>Ajoutez ces templates dans Gmail et WhatsApp Business.</p>
                <a href="/downloads/templates-reponses.pdf" class="btn btn-outline" download>Télécharger</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number">2</div>
                <h3>Réservez votre appel</h3>
                <p>Discutons de comment automatiser encore plus votre communication.</p>
                <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn btn-primary" target="_blank">📞 Appel gratuit</a>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Complétez avec la Matrice</h3>
                <p>Identifiez les vendeurs qui méritent ces réponses.</p>
                <a href="/ressources.php#matrice-vendeur" class="btn btn-outline">🧩 Matrice</a>
            </div>
        </div>
    </div>
</section>

<!-- AUTRES RESSOURCES -->
<section class="other-resources">
    <div class="other-resources-container">
        <h2>📚 Automatisez votre activité</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">🧠</div>
                <h4>Diagnostic Vendeur</h4>
                <p>Qualifiez avant de répondre</p>
                <a href="/ressources.php#diagnostic-vendeur">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🧩</div>
                <h4>Matrice Vendeur</h4>
                <p>Filtrez les profils rentables</p>
                <a href="/ressources.php#matrice-vendeur">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">📍</div>
                <h4>Journal GMB</h4>
                <p>Postez sans réfléchir</p>
                <a href="/ressources.php#journal-gmb">Télécharger →</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
    <div class="cta-final-container">
        <h2>Prêt à répondre en 30 secondes au lieu de 10 minutes ?</h2>
        <p>Réservez votre appel et découvrez comment automatiser toute votre communication</p>
        <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn-white" target="_blank">
            📞 Réserver mon appel gratuit
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>