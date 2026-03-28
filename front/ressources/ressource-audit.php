<?php
$pageTitle = 'Audit Visibilité Locale | ÉCOSYSTÈME IMMO LOCAL+';
$pageDescription = 'Découvrez si vous êtes visible ou invisible sur Google dans votre ville. Audit gratuit en 2 minutes.';
$currentPage = 'ressources';
include '../../includes/header.php';
?>
<script src="/js/form-handler.js"></script>

<section class="capture-hero" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
    <div class="container">
        <a href="/front/pages/ressources.php" class="back-link">← Retour aux ressources</a>
        <div class="capture-hero-content">
            <span class="capture-icon">🔍</span>
            <h1>Audit Visibilité Locale</h1>
            <p>Êtes-vous <strong>visible ou invisible</strong> sur Google ?</p>
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
                        <span class="feature-icon">📍</span>
                        <div>
                            <h4>Position réelle sur Google</h4>
                            <p>Où apparaissez-vous sur les recherches locales ?</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">🔑</span>
                        <div>
                            <h4>Mots-clés locaux</h4>
                            <p>Sur quels termes êtes-vous (ou pas) visible ?</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">📈</span>
                        <div>
                            <h4>Axes d'amélioration</h4>
                            <p>Priorités claires pour progresser rapidement</p>
                        </div>
                    </div>
                </div>
                
                <div class="ideal-box">
                    <h4>🎯 Idéal pour :</h4>
                    <ul>
                        <li>Prendre conscience de son <strong>retard ou avance</strong></li>
                        <li>Décider quoi faire en priorité</li>
                        <li>Comparer avec ses concurrents locaux</li>
                        <li>Justifier un investissement en visibilité</li>
                    </ul>
                </div>
                
                <div class="testimonial-mini">
                    <p>"Je pensais être bien placé... l'audit m'a montré que j'étais invisible sur 80% des recherches."</p>
                    <span>— Négociateur, Nantes</span>
                </div>
            </div>
            
            <div class="capture-form-wrapper">
                <div class="capture-form-box">
                    <h3>🔍 Audit gratuit</h3>
                    <p>Résultats envoyés sous 24h</p>
                    
                    <form id="form-capture" class="lead-form" data-resource-form="audit-visibilite">
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
                            <label for="gdpr">J'accepte de recevoir l'audit et des conseils pour améliorer ma visibilité.</label>
                        </div>
                        
                        <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            🔍 Lancer l'Audit
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
        <h3>📚 Préparez votre stratégie</h3>
        <div class="other-resources-grid">
            <a href="/front/ressources/ressource-gmb.php" class="other-resource-card">
                <span>📍</span>
                <div>
                    <h4>Journal GMB</h4>
                    <p>Planning de posts</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-estimateur.php" class="other-resource-card">
                <span>🧮</span>
                <div>
                    <h4>Estimateur Immo</h4>
                    <p>Captez des leads</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-roi.php" class="other-resource-card">
                <span>🚀</span>
                <div>
                    <h4>Calculateur ROI</h4>
                    <p>Mesurez la rentabilité</p>
                </div>
            </a>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>