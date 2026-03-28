<?php
$pageTitle = 'Guide SEO Local Immobilier | ÉCOSYSTÈME IMMO LOCAL+';
$pageDescription = 'Téléchargez le Guide SEO Local : les techniques pour être trouvé en premier sur Google dans votre ville.';
$currentPage = 'ressources';
include '../../includes/header.php';
?>
<script src="/js/form-handler.js"></script>

<section class="capture-hero" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
    <div class="container">
        <a href="/front/pages/ressources.php" class="back-link">← Retour aux ressources</a>
        <div class="capture-hero-content">
            <span class="capture-icon">🔍</span>
            <h1>Guide SEO Local Immobilier</h1>
            <p>Soyez trouvé <strong>en premier</strong> sur Google dans votre zone</p>
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
                        <span class="feature-icon">🔑</span>
                        <div>
                            <h4>Les 7 piliers du SEO Local</h4>
                            <p>Ce que Google utilise pour classer les résultats</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">📍</span>
                        <div>
                            <h4>Google My Business maîtrisé</h4>
                            <p>Optimiser votre fiche pour dominer</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-icon">📝</span>
                        <div>
                            <h4>Contenu optimisé SEO</h4>
                            <p>Créer des pages qui classent bien</p>
                        </div>
                    </div>
                </div>
                
                <div class="ideal-box">
                    <h4>🎯 Idéal pour :</h4>
                    <ul>
                        <li>Être visible sur Google localement</li>
                        <li>Générer plus d'appels directs</li>
                        <li>Dominer votre zone d'activité</li>
                        <li>Augmenter votre trafic gratuit</li>
                    </ul>
                </div>
                
                <div class="testimonial-mini">
                    <p>"Après 4 mois, je suis premier sur les recherches principales de ma zone. Les mandats ont suivi."</p>
                    <span>— Agent partenaire, Toulouse</span>
                </div>
            </div>
            
            <div class="capture-form-wrapper">
                <div class="capture-form-box">
                    <h3>📖 Guide gratuit</h3>
                    <p>15 pages • Téléchargement immédiat</p>
                    
                    <form id="form-capture" class="lead-form" data-resource-form="seo">
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
                            <label for="gdpr">J'accepte de recevoir le guide SEO et des conseils pour améliorer mon classement.</label>
                        </div>
                        
                        <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                            📥 Télécharger le Guide
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
        <h3>📚 Combinez vos stratégies</h3>
        <div class="other-resources-grid">
            <a href="/front/ressources/ressource-neuropersona.php" class="other-resource-card">
                <span>🧠</span>
                <div>
                    <h4>Guide NeuroPersona</h4>
                    <p>Identifier vos clients</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-mere.php" class="other-resource-card">
                <span>✍️</span>
                <div>
                    <h4>Guide MERE</h4>
                    <p>Écrire du contenu ciblé</p>
                </div>
            </a>
            <a href="/front/ressources/ressource-audit.php" class="other-resource-card">
                <span>📊</span>
                <div>
                    <h4>Audit Visibilité</h4>
                    <p>Mesurer votre position</p>
                </div>
            </a>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>