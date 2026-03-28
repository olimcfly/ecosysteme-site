<?php
$pageTitle = 'Merci ! Votre Guide SEO Local est prêt';
$pageDescription = 'Téléchargement du Guide SEO Local Immobilier - ÉCOSYSTÈME IMMO';
$currentPage = 'ressources';

include '../../includes/header.php';

$downloadPending = isset($_GET['download']) && $_GET['download'] === 'pending';
$userEmail = isset($_GET['email']) ? $_GET['email'] : '';
?>

<!-- === HERO SECTION === -->
<section class="resources-hero" style="background: linear-gradient(135deg, #10b981, #059669);">
    <div class="container">
        <span class="hero-badge" style="background: rgba(255,255,255,0.2); color: white;">✅ Téléchargement réussi</span>
        <h1>Merci <?php echo isset($_GET['firstname']) ? h($_GET['firstname']) : ''; ?> !</h1>
        <p style="max-width: 600px; margin: 20px auto 0; opacity: 0.95; font-size: 1.2rem;">
            Votre Guide SEO Local Immobilier est en route.
        </p>
    </div>
</section>

<!-- === CONFIRMATION === -->
<section class="bg-light">
    <div class="container">
        <div style="max-width: 700px; margin: 0 auto;">
            
            <?php if ($downloadPending): ?>
            <!-- Téléchargement en attente -->
            <div style="background: linear-gradient(135deg, rgba(245,158,11,0.1), rgba(217,119,6,0.1)); border: 2px solid #f59e0b; border-radius: 16px; padding: 30px; margin-bottom: 30px; text-align: center;">
                <span style="font-size: 2.5rem;">📧</span>
                <h2 style="color: #d97706; margin: 15px 0 10px 0; font-size: 1.4rem;">Vérifiez votre boîte mail</h2>
                <p style="color: #4a5568; margin: 0; line-height: 1.7;">
                    Le téléchargement n'a pas pu se lancer automatiquement.<br>
                    Un email avec le lien de téléchargement a été envoyé à <strong><?php echo h($userEmail); ?></strong>
                </p>
            </div>
            <?php else: ?>
            <!-- Téléchargement réussi -->
            <div style="background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(5,150,105,0.1)); border: 2px solid #10b981; border-radius: 16px; padding: 30px; margin-bottom: 30px; text-align: center;">
                <span style="font-size: 2.5rem;">🎉</span>
                <h2 style="color: #10b981; margin: 15px 0 10px 0; font-size: 1.4rem;">Téléchargement lancé !</h2>
                <p style="color: #4a5568; margin: 0; line-height: 1.7;">
                    Votre Guide SEO Local Immobilier (22 pages) devrait apparaître dans vos téléchargements.<br>
                    Si ce n'est pas le cas, vérifiez votre boîte mail.
                </p>
            </div>
            <?php endif; ?>
            
            <!-- Ce que contient le guide -->
            <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 30px;">
                <h3 style="color: #1a202c; margin: 0 0 20px 0; font-size: 1.2rem;">📖 Ce que vous avez entre les mains</h3>
                
                <div style="display: grid; gap: 15px;">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="color: #10b981; font-size: 1.2rem;">✓</span>
                        <div>
                            <strong style="color: #1a202c;">Stratégie de mots-clés locaux</strong>
                            <p style="margin: 5px 0 0 0; color: #718096; font-size: 0.95rem;">La formule pour cibler des mots-clés de longue traîne à faible concurrence</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="color: #10b981; font-size: 1.2rem;">✓</span>
                        <div>
                            <strong style="color: #1a202c;">Architecture en silos</strong>
                            <p style="margin: 5px 0 0 0; color: #718096; font-size: 0.95rem;">Comment organiser vos contenus pour booster votre autorité Google</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="color: #10b981; font-size: 1.2rem;">✓</span>
                        <div>
                            <strong style="color: #1a202c;">12 éléments techniques à optimiser</strong>
                            <p style="margin: 5px 0 0 0; color: #718096; font-size: 0.95rem;">SEO title, meta, URL, H1-H4, images, maillage, FAQ...</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="color: #10b981; font-size: 1.2rem;">✓</span>
                        <div>
                            <strong style="color: #1a202c;">50 articles piliers par persona</strong>
                            <p style="margin: 5px 0 0 0; color: #718096; font-size: 0.95rem;">La liste complète avec les mots-clés principaux</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="color: #8b5cf6; font-size: 1.2rem;">✓</span>
                        <div>
                            <strong style="color: #1a202c;">SEO & Intelligence Artificielle</strong>
                            <span style="background: #8b5cf6; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 8px;">NOUVEAU</span>
                            <p style="margin: 5px 0 0 0; color: #718096; font-size: 0.95rem;">Préparez-vous à l'ère des AI Overviews avec les données 2025</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- === PROCHAINE ÉTAPE === -->
<section>
    <div class="container">
        <div class="section-header">
            <span class="section-badge">🚀 Prochaine étape</span>
            <h2 class="section-title">Appliquez la méthode complète</h2>
            <p class="section-subtitle">Vous avez le pilier SEO — continuez le parcours</p>
        </div>
        
        <div style="max-width: 900px; margin: 0 auto;">
            
            <!-- Parcours -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
                
                <!-- Étape 1 : Persona (fait ou à faire) -->
                <div style="padding: 25px; background: #f7fafc; border-radius: 14px; border: 2px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        <span style="background: #f97316; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 600;">1</span>
                        <span style="font-size: 0.85rem; color: #f97316; font-weight: 600;">PILIER PERSONA</span>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 1.1rem; color: #1a202c;">Guide NeuroPersona</h3>
                    <p style="margin: 0 0 15px 0; color: #718096; font-size: 0.9rem; line-height: 1.5;">Comprenez les motivations profondes de vos clients selon les neurosciences.</p>
                    <a href="/front/ressources/ressource-neuropersona.php" style="color: #f97316; font-weight: 500; text-decoration: none; font-size: 0.9rem;">Télécharger →</a>
                </div>
                
                <!-- Étape 2 : Contenu -->
                <div style="padding: 25px; background: #f7fafc; border-radius: 14px; border: 2px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        <span style="background: #8b5cf6; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 600;">2</span>
                        <span style="font-size: 0.85rem; color: #8b5cf6; font-weight: 600;">PILIER CONTENU</span>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 1.1rem; color: #1a202c;">Guide Structure MERE</h3>
                    <p style="margin: 0 0 15px 0; color: #718096; font-size: 0.9rem; line-height: 1.5;">La méthode pour écrire des articles qui convertissent vos visiteurs en leads.</p>
                    <a href="/front/ressources/ressource-mere.php" style="color: #8b5cf6; font-weight: 500; text-decoration: none; font-size: 0.9rem;">Télécharger →</a>
                </div>
                
                <!-- Étape 3 : SEO (FAIT) -->
                <div style="padding: 25px; background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(5,150,105,0.1)); border-radius: 14px; border: 2px solid #10b981;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        <span style="background: #10b981; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">✓</span>
                        <span style="font-size: 0.85rem; color: #10b981; font-weight: 600;">PILIER SEO</span>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 1.1rem; color: #1a202c;">Guide SEO Local</h3>
                    <p style="margin: 0 0 15px 0; color: #718096; font-size: 0.9rem; line-height: 1.5;">Vous venez de le télécharger ! Appliquez les 12 éléments techniques.</p>
                    <span style="color: #10b981; font-weight: 600; font-size: 0.9rem;">✅ Téléchargé</span>
                </div>
                
            </div>
            
            <!-- Conseil d'application -->
            <div style="background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(5,150,105,0.08)); border-radius: 14px; padding: 25px; text-align: center;">
                <p style="color: #1a202c; margin: 0; font-size: 1.05rem; line-height: 1.7;">
                    💡 <strong>Conseil :</strong> Commencez par créer <strong>1 article pilier</strong> en appliquant les 12 éléments techniques.<br>
                    Puis créez 5-6 articles satellites autour. Rythme idéal : <strong>2-3 articles par semaine</strong>.
                </p>
            </div>
            
        </div>
    </div>
</section>

<!-- === RÉSULTATS ATTENDUS === -->
<section class="bg-light">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <h2 style="color: #1a202c; margin-bottom: 30px;">🚀 Résultats attendus après 12 mois</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                
                <div style="background: white; padding: 25px; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <span style="font-size: 2rem; color: #10b981; font-weight: 700;">20-30</span>
                    <p style="margin: 10px 0 0 0; color: #718096;">mots-clés en<br>première page Google</p>
                </div>
                
                <div style="background: white; padding: 25px; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <span style="font-size: 2rem; color: #10b981; font-weight: 700;">500-1000</span>
                    <p style="margin: 10px 0 0 0; color: #718096;">visiteurs organiques<br>par mois</p>
                </div>
                
                <div style="background: white; padding: 25px; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <span style="font-size: 2rem; color: #10b981; font-weight: 700;">10-20</span>
                    <p style="margin: 10px 0 0 0; color: #718096;">leads qualifiés<br>par mois</p>
                </div>
                
            </div>
        </div>
    </div>
</section>

<!-- === CTA FINAL === -->
<section class="bg-gradient">
    <div class="container" style="text-align: center;">
        <h2 style="color: white;">Envie d'automatiser votre création de contenu ?</h2>
        <p style="opacity: 0.95; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
            L'Assistant IA d'ÉCOSYSTÈME IMMO génère automatiquement vos articles SEO<br>
            optimisés pour votre zone — avec l'exclusivité territoriale.
        </p>
        <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
            <a href="/front/pages/demo.php" class="btn btn-lg" style="background: white; color: #667eea;">🎬 Voir la Visite Guidée</a>
            <a href="/front/pages/verification-zone.php" class="btn btn-lg btn-secondary" style="border-color: white; color: white;">📍 Vérifier ma Ville</a>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>