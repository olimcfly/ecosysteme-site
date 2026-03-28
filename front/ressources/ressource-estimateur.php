<?php
$pageTitle = 'Estimateur Immobilier | ÉCOSYSTÈME IMMO LOCAL+';
$pageDescription = 'Utilisez notre Estimateur Immobilier pour capturer des leads : vos prospects veulent connaître la valeur de leur bien.';
$currentPage = 'ressources';
include '../../includes/header.php';
?>
<script src="/js/form-handler.js"></script>

<section class="capture-hero" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
    <div class="container">
        <a href="/front/pages/ressources.php" class="back-link">← Retour aux ressources</a>
        <div class="capture-hero-content">
            <span class="capture-icon">🏠</span>
            <h1>Estimateur Immobilier</h1>
            <p>Captez des leads <strong>qualifiés</strong> automatiquement</p>
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
                        <span class="feature-icon">🧮</span>
                        <div>
                            <h4>Comment estimer un bien</h4>
                            <p>Les critères qui influencent la valeur</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">👥</span>
                        <div>
                            <h4>Capturer des prospects</h4>
                            <p>Les gens veulent connaître la valeur</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">💰</span>
                        <div>
                            <h4>Valoriser votre expertise</h4>
                            <p>Montrez votre professionnalisme</p>
                        </div>
                    </div>
                </div>
                
                <div class="ideal-box">
                    <h4>🎯 Idéal pour :</h4>
                    <ul>
                        <li>Générer des leads de propriétaires</li>
                        <li>Créer des conversations naturelles</li>
                        <li>Démontrer votre compétence</li>
                        <li>Capturer des ventes de vendeurs</li>
                    </ul>
                </div>
                
                <div class="testimonial-mini">
                    <p>"L'estimateur m'a apporté 3-4 vendeurs par semaine intéressés par mon expertise. C'est incroyable."</p>
                    <span>— Agent partenaire, Nantes</span>
                </div>
            </div>
            
            <div class="capture-form-wrapper">
                <div class="capture-form-box">
                    <h3>🏠 Outil gratuit</h3>
                    <p>Implémenter en 5 minutes</p>
                    
                    <form id="form-capture" class="lead-form" data-resource-form="estimateur">
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
                            <label for="gdpr">J'accepte de recevoir l'estimateur et des conseils pour capturer des leads.</label>
                        </div>
                        
                        <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            📥 Accéder à l'Estimateur
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
        <h3>📚 Maximisez vos opportunités</h3>
        <div class="other-resources-grid">
            <a href="/front/ressources/ressource-neuropersona.php" class="other-resource-card">
                <span>🧠</span>
                <div>
                    <h4>Guide NeuroPersona</h4>
                    <p>Comprendre vos leads</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-roi.php" class="other-resource-card">
                <span>💰</span>
                <div>
                    <h4>Calculateur ROI</h4>
                    <p>Mesurer la rentabilité</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-audit.php" class="other-resource-card">
                <span>📊</span>
                <div>
                    <h4>Audit Visibilité</h4>
                    <p>Élargir votre audience</p>
                </div>
            </a>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>