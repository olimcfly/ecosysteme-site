<?php
$pageTitle = 'Guide NeuroPersona | ÉCOSYSTÈME IMMO LOCAL+';
$pageDescription = 'Identifiez vos clients selon les neurosciences et créez des messages qui convertissent.';
$currentPage = 'ressources';
include '../../includes/header.php';
?>

<section class="resource-hero" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); min-height: 320px; display: flex; align-items: center;">
  <div class="container" style="text-align: center;">
    <a href="/front/ressources" class="back-link" style="display: inline-block; color: rgba(255,255,255,0.8); text-decoration: none; margin-bottom: 20px; font-size: 14px;">← Retour</a>
    <div style="font-size: 4rem; margin-bottom: 20px;">👤</div>
    <h1 style="color: white; font-size: 2.5rem; margin-bottom: 15px; font-family: 'Poppins', sans-serif; font-weight: 800;">Guide NeuroPersona</h1>
    <p style="color: rgba(255,255,255,0.95); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Identifiez vos clients selon les <strong>neurosciences</strong> et créez des messages qui <strong>résonnent vraiment</strong></p>
  </div>
</section>

<section style="padding: 80px 20px;">
  <div class="container" style="max-width: 1100px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start;">
      
      <!-- Contenu gauche -->
      <div>
        <h2 style="font-size: 1.8rem; color: #1a202c; margin-bottom: 30px; font-family: 'Poppins', sans-serif; font-weight: 700;">Ce que vous découvrez</h2>
        
        <div style="display: grid; gap: 25px; margin-bottom: 40px;">
          <div style="padding: 20px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #f97316;">
            <div style="font-size: 1.5rem; margin-bottom: 10px;">🧠</div>
            <h3 style="color: #1a202c; margin: 0 0 8px 0; font-size: 1rem;">Les 4 motivations profondes</h3>
            <p style="color: #718096; margin: 0; font-size: 0.9rem;">Sécurité • Liberté • Reconnaissance • Contrôle</p>
          </div>

          <div style="padding: 20px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #f97316;">
            <div style="font-size: 1.5rem; margin-bottom: 10px;">👥</div>
            <h3 style="color: #1a202c; margin: 0 0 8px 0; font-size: 1rem;">Les 5 personas immobiliers</h3>
            <p style="color: #718096; margin: 0; font-size: 0.9rem;">Profils détaillés avec leurs besoins spécifiques</p>
          </div>

          <div style="padding: 20px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #f97316;">
            <div style="font-size: 1.5rem; margin-bottom: 10px;">💬</div>
            <h3 style="color: #1a202c; margin: 0 0 8px 0; font-size: 1rem;">Messages clés par profil</h3>
            <p style="color: #718096; margin: 0; font-size: 0.9rem;">Exactement ce qui les motive à agir</p>
          </div>
        </div>

        <div style="background: linear-gradient(135deg, rgba(249,115,22,0.08), rgba(234,88,12,0.08)); border: 1px solid rgba(249,115,22,0.2); border-radius: 12px; padding: 25px;">
          <h3 style="color: #1a202c; margin: 0 0 15px 0; font-size: 1rem;">🎯 Idéal pour :</h3>
          <ul style="margin: 0; padding-left: 20px; color: #4a5568; line-height: 1.8;">
            <li>Comprendre vraiment vos clients</li>
            <li>Créer des messages qui <strong>résonnent</strong></li>
            <li>Choisir la bonne stratégie marketing</li>
            <li>Augmenter votre taux de conversion</li>
          </ul>
        </div>
      </div>

      <!-- Formulaire droite -->
      <div>
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
          <h3 style="color: #1a202c; margin: 0 0 8px 0; font-size: 1.3rem; font-family: 'Poppins', sans-serif; font-weight: 700;">📖 Guide gratuit</h3>
          <p style="color: #718096; margin: 0 0 30px 0; font-size: 0.9rem;">9 pages • Téléchargement immédiat</p>

          <form id="form-neuropersona" class="lead-form" data-resource="neuropersona">
            <div style="margin-bottom: 20px;">
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #2d3748; margin-bottom: 8px;">Prénom *</label>
              <input type="text" name="firstname" placeholder="Votre prénom" required style="width: 100%; padding: 11px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s;" onfocus="this.style.borderColor='#667eea'" onblur="this.style.borderColor='#e2e8f0'">
            </div>

            <div style="margin-bottom: 20px;">
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #2d3748; margin-bottom: 8px;">Email professionnel *</label>
              <input type="email" name="email" placeholder="vous@exemple.com" required style="width: 100%; padding: 11px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s;" onfocus="this.style.borderColor='#667eea'" onblur="this.style.borderColor='#e2e8f0'">
            </div>

            <div style="margin-bottom: 20px;">
              <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #2d3748; margin-bottom: 8px;">Votre ville *</label>
              <input type="text" name="city" placeholder="Ex: Lyon, Bordeaux..." required style="width: 100%; padding: 11px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s;" onfocus="this.style.borderColor='#667eea'" onblur="this.style.borderColor='#e2e8f0'">
            </div>

            <div style="margin-bottom: 25px; display: flex; gap: 10px; align-items: flex-start;">
              <input type="checkbox" id="gdpr-np" name="gdpr" required style="margin-top: 4px; cursor: pointer;">
              <label for="gdpr-np" style="font-size: 0.85rem; color: #4a5568; cursor: pointer; margin: 0;">J'accepte de recevoir le guide et des conseils sur mes personas.</label>
            </div>

            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #f97316, #ea580c); color: white; padding: 13px 0; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 600; cursor: pointer; transition: opacity 0.2s, transform 0.2s;">
              📥 Télécharger le Guide
            </button>

            <p style="font-size: 0.8rem; color: #a0aec0; text-align: center; margin: 15px 0 0 0;">🔒 Vos données restent confidentielles</p>
          </form>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #f97316;">
          <p style="margin: 0; color: #4a5568; font-size: 0.9rem; font-style: italic;">
            <strong style="color: #1a202c;">"Comprendre les personas a changé ma façon de communiquer. Les résultats ont suivi immédiatement."</strong><br>
            <span style="color: #718096; display: block; margin-top: 8px;">— Agent partenaire, Nantes</span>
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Ressources complémentaires -->
<section style="background: #f7fafc; padding: 60px 20px;">
  <div class="container" style="max-width: 1100px;">
    <h2 style="text-align: center; color: #1a202c; margin-bottom: 40px; font-size: 1.5rem; font-family: 'Poppins', sans-serif; font-weight: 700;">📚 Continuez votre apprentissage</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px;">
      <a href="/front/ressources/mere" style="text-decoration: none;">
        <div style="padding: 30px; background: white; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s; cursor: pointer; height: 100%;" onmouseover="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 8px 20px rgba(139,92,246,0.15)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          <div style="font-size: 2rem; margin-bottom: 12px;">✍️</div>
          <h3 style="color: #1a202c; margin: 0 0 8px 0; font-size: 1rem;">Guide MERE</h3>
          <p style="color: #718096; font-size: 0.9rem; margin: 0; line-height: 1.6;">Écrire du contenu qui convertit vos visitors en leads qualifiés</p>
        </div>
      </a>

      <a href="/front/ressources/seo-local" style="text-decoration: none;">
        <div style="padding: 30px; background: white; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s; cursor: pointer; height: 100%;" onmouseover="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 8px 20px rgba(59,130,246,0.15)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          <div style="font-size: 2rem; margin-bottom: 12px;">🔍</div>
          <h3 style="color: #1a202c; margin: 0 0 8px 0; font-size: 1rem;">Guide SEO Local</h3>
          <p style="color: #718096; font-size: 0.9rem; margin: 0; line-height: 1.6;">Être trouvé en premier sur Google dans votre zone</p>
        </div>
      </a>

      <a href="/front/ressources/audit-visibilite" style="text-decoration: none;">
        <div style="padding: 30px; background: white; border: 2px solid #e2e8f0; border-radius: 12px; transition: all 0.3s; cursor: pointer; height: 100%;" onmouseover="this.style.borderColor='#10b981'; this.style.boxShadow='0 8px 20px rgba(16,185,129,0.15)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
          <div style="font-size: 2rem; margin-bottom: 12px;">📊</div>
          <h3 style="color: #1a202c; margin: 0 0 8px 0; font-size: 1rem;">Audit Visibilité</h3>
          <p style="color: #718096; font-size: 0.9rem; margin: 0; line-height: 1.6;">Évaluer votre position et identifier vos opportunités</p>
        </div>
      </a>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>