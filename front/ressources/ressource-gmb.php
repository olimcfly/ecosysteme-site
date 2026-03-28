<?php
$pageTitle = 'Journal Communication GMB | ÉCOSYSTÈME IMMO LOCAL+';
$pageDescription = 'Téléchargez le Journal Communication Google My Business : un planning complet pour rester visible et attirer des prospects.';
$currentPage = 'ressources';
include '../../includes/header.php';
?>
<script src="/js/form-handler.js"></script>

<section class="capture-hero" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
    <div class="container">
        <a href="/front/pages/ressources.php" class="back-link">← Retour aux ressources</a>
        <div class="capture-hero-content">
            <span class="capture-icon">📍</span>
            <h1>Journal Communication GMB</h1>
            <p>Restez <strong>actif et visible</strong> sur Google My Business</p>
        </div>
    </div>
</section>

<section class="capture-main">
    <div class="container">
        <div class="capture-grid">
            
            <div class="capture-content">
                <h2>Ce que vous découvrez :</h2>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <span class="feature-icon">📅</span>
                        <div>
                            <h4>Planning complet d'une année</h4>
                            <p>Publiez régulièrement sans réfléchir</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">📱</span>
                        <div>
                            <h4>Idées de posts prêtes à adapter</h4>
                            <p>+52 posts : un par semaine</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">📊</span>
                        <div>
                            <h4>Mesurez vos résultats</h4>
                            <p>Suivez les clics et les appels</p>
                        </div>
                    </div>
                </div>
                
                <div class="ideal-box">
                    <h4>🎯 Idéal pour :</h4>
                    <ul>
                        <li>Publier régulièrement sans stress</li>
                        <li>Rester visible dans Google</li>
                        <li>Gagner des appels directs</li>
                        <li>Automatiser votre communication</li>
                    </ul>
                </div>
                
                <div class="testimonial-mini">
                    <p>"Le journal GMB m'a sauvé la vie. Maintenant je publie sans improviser et les appels augmentent."</p>
                    <span>— Agent partenaire, Bordeaux</span>
                </div>
            </div>
            
            <div class="capture-form-wrapper">
                <div class="capture-form-box">
                    <h3>📖 Journal gratuit</h3>
                    <p>Planning annuel • À adapter</p>
                    
                    <form id="form-capture" class="lead-form" data-resource-form="journal-gmb">
                        <div class="form-group">
                            <label for="firstname">Prénom *</label>
                            <input type="text" id="firstname" name="firstname" class="form-input" placeholder="Votre prénom" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email professionnel *</label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="vous@exemple.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="city">Votre ville *</label>
                            <input type="text" id="city" name="city" class="form-input" placeholder="Ex: Lyon, Bordeaux..." required>
                        </div>
                        
                        <div class="form-checkbox">
                            <input type="checkbox" id="gdpr" name="gdpr" required>
                            <label for="gdpr">J'accepte de recevoir le journal GMB et des conseils en communication.</label>
                        </div>
                        
                        <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                            📥 Télécharger le Journal
                        </button>
                        
                        <p class="form-note">
                            🔒 Vos données restent confidentielles. Désabonnement en 1 clic.
                        </p>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="other-resources-section">
    <div class="container">
        <h3>📚 Complétez votre stratégie</h3>
        <div class="other-resources-grid">
            <a href="/front/ressources/ressource-seo.php" class="other-resource-card">
                <span>🔍</span>
                <div>
                    <h4>Guide SEO Local</h4>
                    <p>Être trouvé sur Google</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-neuropersona.php" class="other-resource-card">
                <span>🧠</span>
                <div>
                    <h4>Guide NeuroPersona</h4>
                    <p>Comprendre vos clients</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-audit.php" class="other-resource-card">
                <span>📊</span>
                <div>
                    <h4>Audit Visibilité</h4>
                    <p>Évaluer votre position</p>
                </div>
            </a>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>