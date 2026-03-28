<?php
$pageTitle = 'Guide NeuroPersona — Merci !';
$pageDescription = 'Merci d\'avoir téléchargé le Guide NeuroPersona. Découvrez comment identifier et cibler vos personas immobiliers.';
$currentPage = 'ressources';

include '../../includes/header.php';
?>

<!-- === HERO REMERCIEMENT === -->
<section class="resources-hero" style="background: linear-gradient(135deg, #10b981, #059669); min-height: 300px; display: flex; align-items: center;">
    <div class="container" style="text-align: center;">
        <div style="font-size: 5rem; margin-bottom: 20px;">✅</div>
        <h1 style="color: white; margin-bottom: 15px;">Merci !</h1>
        <p style="color: rgba(255,255,255,0.95); font-size: 1.2rem; max-width: 600px; margin: 0 auto;">
            Votre Guide NeuroPersona est prêt à être téléchargé.<br>
            Vérifiez votre boîte email (y compris les spams).
        </p>
    </div>
</section>

<!-- === SECTION PRINCIPALE === -->
<section style="padding: 60px 20px;">
    <div class="container">
        <div style="max-width: 700px; margin: 0 auto;">
            
            <!-- Confirmation -->
            <div style="background: #f0fdf4; border-left: 4px solid #10b981; padding: 25px; border-radius: 10px; margin-bottom: 40px;">
                <h2 style="color: #1a202c; margin-top: 0; margin-bottom: 15px;">📥 Votre téléchargement est prêt</h2>
                <p style="color: #4a5568; line-height: 1.8; margin: 0;">
                    Le Guide NeuroPersona (9 pages) vous a été envoyé par email. Si vous ne le voyez pas dans votre boîte de réception principale, 
                    vérifiez vos dossiers <strong>Spam</strong> ou <strong>Promotions</strong>.
                </p>
            </div>
            
            <!-- Prochaines étapes -->
            <div style="margin-bottom: 50px;">
                <h2 style="color: #1a202c; font-size: 1.5rem; margin-bottom: 25px;">📋 Vos prochaines étapes</h2>
                
                <div style="display: grid; gap: 20px;">
                    
                    <!-- Étape 1 -->
                    <div style="display: flex; gap: 20px; padding: 20px; background: #f7fafc; border-radius: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f97316, #ea580c); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">1</div>
                        <div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Lisez le guide</h3>
                            <p style="color: #4a5568; margin: 0; line-height: 1.6;">
                                Découvrez les 4 motivations profondes et les 5 personas immobiliers. Identifiez celui qui est le plus stratégique pour VOTRE zone.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Étape 2 -->
                    <div style="display: flex; gap: 20px; padding: 20px; background: #f7fafc; border-radius: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">2</div>
                        <div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Apprenez à créer du contenu adapté</h3>
                            <p style="color: #4a5568; margin: 0; line-height: 1.6;">
                                Maintenant que vous connaissez votre persona, le Guide MERE vous apprendra comment écrire des articles de blog qui le CONVERTISSENT en leads.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Étape 3 -->
                    <div style="display: flex; gap: 20px; padding: 20px; background: #f7fafc; border-radius: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">3</div>
                        <div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Optimisez votre visibilité locale</h3>
                            <p style="color: #4a5568; margin: 0; line-height: 1.6;">
                                Une fois votre contenu en place, utilisez le SEO Local et Google My Business pour attirer votre persona dans votre zone.
                            </p>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <!-- Guides suivants -->
            <div style="margin-bottom: 50px;">
                <h2 style="color: #1a202c; font-size: 1.5rem; margin-bottom: 25px;">📚 Guides complémentaires</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    
                    <!-- Guide MERE -->
                    <a href="/front/ressources/ressource-mere.php" style="text-decoration: none;">
                        <div style="padding: 25px; background: white; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s; cursor: pointer; height: 100%;"
                             onmouseover="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 8px 20px rgba(139,92,246,0.15)'"
                             onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            <div style="font-size: 2rem; margin-bottom: 12px;">✍️</div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Guide MERE</h3>
                            <p style="color: #718096; font-size: 0.9rem; margin: 0; line-height: 1.5;">
                                Apprenez la structure pour écrire des articles de blog qui convertissent vos personas en leads qualifiés.
                            </p>
                        </div>
                    </a>
                    
                    <!-- Guide SEO -->
                    <a href="/front/ressources/ressource-seo.php" style="text-decoration: none;">
                        <div style="padding: 25px; background: white; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s; cursor: pointer; height: 100%;"
                             onmouseover="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 8px 20px rgba(59,130,246,0.15)'"
                             onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            <div style="font-size: 2rem; margin-bottom: 12px;">🔍</div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Guide SEO Local</h3>
                            <p style="color: #718096; font-size: 0.9rem; margin: 0; line-height: 1.5;">
                                Optimisez votre présence en ligne pour être trouvé par vos prospects dans votre zone géographique.
                            </p>
                        </div>
                    </a>
                    
                    <!-- Audit Visibilité -->
                    <a href="/front/ressources/ressource-audit.php" style="text-decoration: none;">
                        <div style="padding: 25px; background: white; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s; cursor: pointer; height: 100%;"
                             onmouseover="this.style.borderColor='#f97316'; this.style.boxShadow='0 8px 20px rgba(249,115,22,0.15)'"
                             onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            <div style="font-size: 2rem; margin-bottom: 12px;">📊</div>
                            <h3 style="color: #1a202c; margin: 0 0 8px 0;">Audit Visibilité</h3>
                            <p style="color: #718096; font-size: 0.9rem; margin: 0; line-height: 1.5;">
                                Analysez votre visibilité actuelle et identifiez les opportunités pour attirer plus de clients.
                            </p>
                        </div>
                    </a>
                    
                </div>
            </div>
            
            <!-- CTA Principal -->
            <div style="background: linear-gradient(135deg, rgba(249,115,22,0.08), rgba(234,88,12,0.08)); border: 2px solid rgba(249,115,22,0.3); border-radius: 16px; padding: 40px; text-align: center;">
                <h2 style="color: #1a202c; margin-top: 0; margin-bottom: 15px;">🚀 Prêt à passer à l'action ?</h2>
                <p style="color: #4a5568; margin-bottom: 25px; line-height: 1.6;">
                    L'Assistant IA d'ÉCOSYSTÈME IMMO génère automatiquement votre contenu adapté à votre persona,<br>
                    avec l'exclusivité territoriale dans votre zone.
                </p>
                <a href="/front/pages/demo.php" style="display: inline-block; background: linear-gradient(135deg, #f97316, #ea580c); color: white; padding: 14px 32px; border-radius: 10px; text-decoration: none; font-weight: 600; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.05)'"
                   onmouseout="this.style.transform='scale(1)'">
                    Voir la Visite Guidée →
                </a>
            </div>
            
            <!-- Lien retour -->
            <div style="text-align: center; margin-top: 40px;">
                <a href="/front/ressources/" style="color: #667eea; text-decoration: none; font-weight: 500;">
                    ← Retour aux ressources
                </a>
            </div>
            
        </div>
    </div>
</section>

<!-- === SOCIAL PROOF === -->
<section class="bg-light">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto; text-align: center;">
            <h2 style="color: #1a202c; margin-bottom: 30px;">📈 Ils ont réussi grâce à NeuroPersona</h2>
            
            <div style="display: grid; gap: 20px;">
                
                <div style="padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <p style="color: #1a202c; margin: 0 0 10px 0; font-weight: 600;">⭐⭐⭐⭐⭐</p>
                    <p style="color: #4a5568; margin: 0; font-style: italic;">
                        "Comprendre mes personas m'a permis de tripler mes prises de contact qualifiées en 3 mois."
                    </p>
                    <p style="color: #718096; margin: 10px 0 0 0; font-size: 0.9rem;">— Agent partenaire, Nantes</p>
                </div>
                
                <div style="padding: 20px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <p style="color: #1a202c; margin: 0 0 10px 0; font-weight: 600;">⭐⭐⭐⭐⭐</p>
                    <p style="color: #4a5568; margin: 0; font-style: italic;">
                        "Je savais enfin à qui m'adresser et comment. Les résultats ont suivi rapidement."
                    </p>
                    <p style="color: #718096; margin: 10px 0 0 0; font-size: 0.9rem;">— Agent partenaire, Bordeaux</p>
                </div>
                
            </div>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>