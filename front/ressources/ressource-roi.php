<?php
$pageTitle = 'Calculateur ROI Marketing | ÉCOSYSTÈME IMMO LOCAL+';
$pageDescription = 'Calculez votre ROI marketing en temps réel : mesurez la rentabilité de vos investissements en acquisition de leads.';
$currentPage = 'ressources';
include '../../includes/header.php';
?>
<script src="/js/form-handler.js"></script>

<section class="capture-hero" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
    <div class="container">
        <a href="/front/pages/ressources.php" class="back-link">← Retour aux ressources</a>
        <div class="capture-hero-content">
            <span class="capture-icon">💰</span>
            <h1>Calculateur ROI Marketing</h1>
            <p>Mesurez <strong>exactement</strong> votre retour sur investissement</p>
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
                        <span class="feature-icon">💵</span>
                        <div>
                            <h4>Tracez vos investissements</h4>
                            <p>Site, contenu, outils, publicités...</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">📊</span>
                        <div>
                            <h4>Mesurez vos résultats</h4>
                            <p>Leads, ventes, commissions générées</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">📈</span>
                        <div>
                            <h4>Calculez votre ROI</h4>
                            <p>Rentabilité exacte de vos dépenses</p>
                        </div>
                    </div>
                </div>
                
                <div class="ideal-box">
                    <h4>🎯 Idéal pour :</h4>
                    <ul>
                        <li>Savoir si vos investissements marchent</li>
                        <li>Optimiser vos dépenses marketing</li>
                        <li>Justifier vos investissements</li>
                        <li>Augmenter votre profitabilité</li>
                    </ul>
                </div>
                
                <div class="testimonial-mini">
                    <p>"Le calculateur m'a montré où j'étais en train de gaspiller de l'argent. J'ai revu ma stratégie et doublé mon profit."</p>
                    <span>— Agent partenaire, Toulouse</span>
                </div>
            </div>
            
            <div class="capture-form-wrapper">
                <div class="capture-form-box">
                    <h3>💰 Outil gratuit</h3>
                    <p>Accès immédiat • Utilisable immédiatement</p>
                    
                    <form id="form-capture" class="lead-form" data-resource-form="calculateur-roi">
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
                            <label for="gdpr">J'accepte de recevoir le calculateur ROI et des conseils pour optimiser mon marketing.</label>
                        </div>
                        
                        <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                            📥 Accéder au Calculateur
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
        <h3>📚 Optimisez votre stratégie</h3>
        <div class="other-resources-grid">
            <a href="/front/ressources/ressource-neuropersona.php" class="other-resource-card">
                <span>🧠</span>
                <div>
                    <h4>Guide NeuroPersona</h4>
                    <p>Cibler les bons prospects</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-mere.php" class="other-resource-card">
                <span>✍️</span>
                <div>
                    <h4>Guide MERE</h4>
                    <p>Créer du contenu qui convertit</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-seo.php" class="other-resource-card">
                <span>🔍</span>
                <div>
                    <h4>Guide SEO Local</h4>
                    <p>Générer du trafic gratuit</p>
                </div>
            </a>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>