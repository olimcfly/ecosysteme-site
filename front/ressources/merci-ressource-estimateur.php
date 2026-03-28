<?php
$pageTitle = 'Estimateur Immobilier — Merci !';
$pageDescription = 'Merci d\'avoir utilisé l\'Estimateur Immobilier. Comprenez la valeur des biens dans votre zone.';
$currentPage = 'ressources';

include '../../includes/header.php';
?>

<!-- === HERO REMERCIEMENT === -->
<section class="resources-hero" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); min-height: 300px; display: flex; align-items: center;">
    <div class="container" style="text-align: center;">
        <div style="font-size: 5rem; margin-bottom: 20px;">✅</div>
        <h1 style="color: white; margin-bottom: 15px;">Merci !</h1>
        <p style="color: rgba(255,255,255,0.95); font-size: 1.2rem; max-width: 600px; margin: 0 auto;">
            L'Estimateur Immobilier a calculé la valeur du bien.<br>
            Découvrez comment l'utiliser pour vos prospects.
        </p>
    </div>
</section>

<!-- === SECTION PRINCIPALE === -->
<section style="padding: 60px 20px;">
    <div class="container">
        <div style="max-width: 700px; margin: 0 auto;">
            
            <!-- Confirmation -->
            <div style="background: #f3f0ff; border-left: 4px solid #8b5cf6; padding: 25px; border-radius: 10px; margin-bottom: 40px;">
                <h2 style="color: #1a202c; margin-top: 0; margin-bottom: 15px;">🏠 Votre estimation est prête</h2>
                <p style="color: #4a5568; line-height: 1.8; margin: 0;">
                    L'Estimateur Immobilier calcule automatiquement la valeur marchande des biens basée sur les données locales. 
                    Cet outil est parfait pour impressionner vos prospects et gagner leur confiance.
                </p>
            </div>
            
            <!-- Prochaines étapes -->
            <div style="margin-bottom: 50px;">
                <h2 style="color: #1a202c; font-size: 1.5rem; margin-bottom: 25px;">📋 Comment l'utiliser efficacement</h2>
                
                <div style="display: grid; gap: 20px;">
                    
                    <div style="display: flex; gap: 20px; padding: 20px; background: #f7fafc; border-radius: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">1</div>
                        <div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Utilisez-le en premier rendez-vous</h3>
                            <p style="color: #4a5568; margin: 0; line-height: 1.6;">
                                Présentez une estimation précise et objective du bien lors de votre visite. Cela crée une relation de confiance immédiate.
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 20px; padding: 20px; background: #f7fafc; border-radius: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">2</div>
                        <div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Partagez-le avec vos prospects</h3>
                            <p style="color: #4a5568; margin: 0; line-height: 1.6;">
                                Envoyez par email l'estimation à vos prospects. C'est un excellent lead magnet pour maintenir le contact.
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 20px; padding: 20px; background: #f7fafc; border-radius: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f97316, #ea580c); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">3</div>
                        <div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Analysez la valeur ajoutée</h3>
                            <p style="color: #4a5568; margin: 0; line-height: 1.6;">
                                Montrez comment des améliorations pourraient augmenter la valeur. Cela ouvre des conversations précieuses.
                            </p>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <!-- Guides suivants -->
            <div style="margin-bottom: 50px;">
                <h2 style="color: #1a202c; font-size: 1.5rem; margin-bottom: 25px;">📚 Ressources complémentaires</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    
                    <a href="/front/ressources/ressource-neuropersona.php" style="text-decoration: none;">
                        <div style="padding: 25px; background: white; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s; cursor: pointer; height: 100%;"
                             onmouseover="this.style.borderColor='#f97316'; this.style.boxShadow='0 8px 20px rgba(249,115,22,0.15)'"
                             onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            <div style="font-size: 2rem; margin-bottom: 12px;">👤</div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Guide NeuroPersona</h3>
                            <p style="color: #718096; font-size: 0.9rem; margin: 0; line-height: 1.5;">
                                Comprendre votre prospect pour mieux vendre.
                            </p>
                        </div>
                    </a>
                    
                    <a href="/front/ressources/ressource-audit.php" style="text-decoration: none;">
                        <div style="padding: 25px; background: white; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s; cursor: pointer; height: 100%;"
                             onmouseover="this.style.borderColor='#10b981'; this.style.boxShadow='0 8px 20px rgba(16,185,129,0.15)'"
                             onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            <div style="font-size: 2rem; margin-bottom: 12px;">📊</div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Audit Visibilité</h3>
                            <p style="color: #718096; font-size: 0.9rem; margin: 0; line-height: 1.5;">
                                Analysez votre position et vos opportunités.
                            </p>
                        </div>
                    </a>
                    
                    <a href="/front/ressources/ressource-roi.php" style="text-decoration: none;">
                        <div style="padding: 25px; background: white; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s; cursor: pointer; height: 100%;"
                             onmouseover="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 8px 20px rgba(59,130,246,0.15)'"
                             onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            <div style="font-size: 2rem; margin-bottom: 12px;">💰</div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Calculateur ROI</h3>
                            <p style="color: #718096; font-size: 0.9rem; margin: 0; line-height: 1.5;">
                                Calculez votre retour sur investissement marketing.
                            </p>
                        </div>
                    </a>
                    
                </div>
            </div>
            
            <!-- CTA Principal -->
            <div style="background: linear-gradient(135deg, rgba(139,92,246,0.08), rgba(124,58,237,0.08)); border: 2px solid rgba(139,92,246,0.3); border-radius: 16px; padding: 40px; text-align: center;">
                <h2 style="color: #1a202c; margin-top: 0; margin-bottom: 15px;">🚀 Estimateurs automatisés pour vos prospects ?</h2>
                <p style="color: #4a5568; margin-bottom: 25px; line-height: 1.6;">
                    ÉCOSYSTÈME IMMO intègre des estimateurs immobiliers directement dans votre site<br>
                    pour capturer des leads qualifiés 24h/24.
                </p>
                <a href="/front/pages/demo.php" style="display: inline-block; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 14px 32px; border-radius: 10px; text-decoration: none; font-weight: 600; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.05)'"
                   onmouseout="this.style.transform='scale(1)'">
                    Voir la Visite Guidée →
                </a>
            </div>
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="/front/ressources/" style="color: #667eea; text-decoration: none; font-weight: 500;">
                    ← Retour aux ressources
                </a>
            </div>
            
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>