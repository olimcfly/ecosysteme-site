<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Merci Téléchargement Offre Complète
 */
$pageTitle = "Votre Offre Complète est prête ! | ÉCOSYSTÈME IMMO LOCAL+";
$pageDescription = "Téléchargez notre offre complète avec toutes les formules et tarifs détaillés.";
$bodyClass = "theme-offre";
require_once 'includes/header.php';
?>

<link rel="stylesheet" href="css/merci-download.css">

<!-- HERO -->
<section class="merci-hero">
    <div class="merci-hero-content">
        <div class="merci-icon">📄</div>
        <h1>Votre Offre Complète est prête !</h1>
        <p class="subtitle">Toutes nos formules et tarifs détaillés</p>
    </div>
</section>

<!-- DOWNLOAD BOX -->
<section class="download-section">
    <div class="download-container">
        <div class="download-box fade-in-up">
            <h2>📥 Téléchargez l'offre maintenant</h2>
            <p>Cliquez sur le bouton ci-dessous pour accéder immédiatement au PDF complet</p>
            
            <a href="/downloads/offre-complete-ecosysteme-immo.pdf" class="btn-download" download>
                <span class="icon">📄</span>
                <span>Télécharger l'Offre Complète</span>
            </a>
            
            <div class="download-note">
                💡 <strong>Important :</strong> Vérifiez la disponibilité de votre zone avant de choisir votre formule !
            </div>
            
            <!-- Résumé du contenu -->
            <div class="content-summary">
                <h3>📋 Ce que contient ce document :</h3>
                <ul>
                    <li>Présentation complète d'ÉCOSYSTÈME IMMO LOCAL+</li>
                    <li>Comparatif détaillé : Formule SaaS vs Formule Dédiée</li>
                    <li>Grille tarifaire complète et transparente</li>
                    <li>Toutes les fonctionnalités détaillées par formule</li>
                    <li>Programme partenaire et commissions</li>
                    <li>Nos garanties + FAQ (questions fréquentes)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- COMPARATIF RAPIDE -->
<section class="next-steps" style="background: #f8f9fa;">
    <div class="next-steps-container">
        <h2>⚡ Aperçu rapide des formules</h2>
        <p class="section-subtitle">Trouvez la formule adaptée à vos besoins</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number" style="background: linear-gradient(135deg, #667eea, #764ba2);">S</div>
                <h3>Formule SaaS</h3>
                <p><strong>47€/mois</strong><br>Site clé en main + CRM + Outils marketing. Idéal pour démarrer rapidement.</p>
                <a href="/tarifs#saas" class="btn btn-outline">En savoir plus</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number" style="background: linear-gradient(135deg, #f093fb, #f5576c);">D</div>
                <h3>Formule Dédiée</h3>
                <p><strong>Sur devis</strong><br>Site 100% personnalisé + accompagnement premium. Pour se démarquer totalement.</p>
                <a href="/tarifs#dedie" class="btn btn-primary">En savoir plus</a>
            </div>
            
            <div class="step-card">
                <div class="step-number" style="background: linear-gradient(135deg, #11998e, #38ef7d);">P</div>
                <h3>Programme Partenaire</h3>
                <p><strong>Jusqu'à 30%</strong><br>Recommandez ÉCOSYSTÈME IMMO+ et gagnez des commissions récurrentes.</p>
                <a href="/partenaire" class="btn btn-outline">Devenir partenaire</a>
            </div>
        </div>
    </div>
</section>

<!-- NEXT STEPS -->
<section class="next-steps">
    <div class="next-steps-container">
        <h2>🚀 Prochaine étape ?</h2>
        <p class="section-subtitle">Choisissez votre parcours</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Vérifiez votre zone</h3>
                <p>Un seul agent par zone géographique. Assurez-vous que la vôtre est disponible.</p>
                <a href="/carte" class="btn btn-outline">🗺️ Voir la carte</a>
            </div>
            
            <div class="step-card featured">
                <div class="step-number">2</div>
                <h3>Réservez votre appel</h3>
                <p>30 minutes pour répondre à toutes vos questions et trouver LA formule pour vous.</p>
                <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn btn-primary" target="_blank">📞 Appel gratuit</a>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Lancez-vous !</h3>
                <p>Votre site est en ligne sous 48h. On s'occupe de tout, vous vous concentrez sur vos clients.</p>
                <a href="/inscription" class="btn btn-outline">🚀 S'inscrire</a>
            </div>
        </div>
    </div>
</section>

<!-- GARANTIES -->
<section class="other-resources" style="background: white;">
    <div class="other-resources-container">
        <h2>🛡️ Nos garanties</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">🎯</div>
                <h4>Exclusivité territoriale</h4>
                <p>Un seul agent par zone. Votre secteur vous appartient.</p>
            </div>
            
            <div class="resource-card">
                <div class="icon">⏱️</div>
                <h4>Mise en ligne 48h</h4>
                <p>Votre site est opérationnel en 2 jours ouvrés maximum.</p>
            </div>
            
            <div class="resource-card">
                <div class="icon">💬</div>
                <h4>Support réactif</h4>
                <p>Une vraie personne vous répond sous 24h max.</p>
            </div>
            
            <div class="resource-card">
                <div class="icon">🔄</div>
                <h4>Sans engagement</h4>
                <p>Résiliez quand vous voulez, sans frais cachés.</p>
            </div>
        </div>
    </div>
</section>

<!-- AUTRES RESSOURCES -->
<section class="other-resources">
    <div class="other-resources-container">
        <h2>📚 Ressources gratuites</h2>
        
        <div class="resources-grid">
            <div class="resource-card">
                <div class="icon">🎭</div>
                <h4>Guide Personas</h4>
                <p>Les 4 profils psychologiques de vos clients</p>
                <a href="/ressources#personas">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">🔍</div>
                <h4>Guide SEO Local</h4>
                <p>Dominez Google dans votre zone</p>
                <a href="/ressources#seo">Télécharger →</a>
            </div>
            
            <div class="resource-card">
                <div class="icon">✍️</div>
                <h4>Méthode MERE</h4>
                <p>Écrivez des articles qui convertissent</p>
                <a href="/ressources#mere">Télécharger →</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final">
    <div class="cta-final-container">
        <h2>Des questions sur les formules ?</h2>
        <p>Réservez un appel de 30 minutes - je réponds à toutes vos questions personnellement</p>
        <a href="https://calendly.com/ecosysteme-immo/appel-strategique" class="btn-white" target="_blank">
            📞 Réserver mon appel gratuit
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>