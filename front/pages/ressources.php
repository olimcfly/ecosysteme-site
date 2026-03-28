<?php
$pageTitle = 'Ressources Gratuites — Méthode Persona / Contenu / Trafic';
$pageDescription = 'Ressources gratuites ÉCOSYSTÈME IMMO — Guides et outils pour maîtriser la méthode Persona, Contenu, Trafic et devenir le leader immobilier de votre zone.';
$currentPage = 'ressources';

include '../../includes/header.php';
?>

<style>
.resources-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 80px 20px;
  text-align: center;
}

.resources-hero h1 {
  font-size: 2.5rem;
  font-weight: 800;
  margin: 20px 0;
  line-height: 1.2;
}

.hero-badge {
  display: inline-block;
  background: rgba(255,255,255,0.2);
  color: white;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
}

.bg-light {
  background: #f7fafc;
}

.resources-section {
  padding: 60px 20px;
}

.section-header {
  text-align: center;
  margin-bottom: 50px;
}

.section-badge {
  display: inline-block;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 16px;
}

.section-title {
  font-size: 2rem;
  font-weight: 800;
  color: #1a202c;
  margin: 15px 0;
}

.section-subtitle {
  font-size: 1.1rem;
  color: #718096;
  margin: 0;
}

.resources-grid-large {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
}

.resource-card-preview {
  background: white;
  border-radius: 14px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  overflow: hidden;
  transition: transform 0.3s, box-shadow 0.3s;
}

.resource-card-preview:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.resource-card-icon {
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
}

.resource-card-body {
  padding: 25px;
}

.resource-badge {
  display: inline-block;
  padding: 5px 12px;
  border-radius: 6px;
  font-size: 0.8rem;
  font-weight: 600;
  margin-bottom: 12px;
}

.resource-card-body h3 {
  font-size: 1.3rem;
  font-weight: 700;
  color: #1a202c;
  margin: 12px 0;
}

.resource-card-body p {
  font-size: 0.95rem;
  color: #718096;
  margin: 12px 0;
  line-height: 1.6;
}

.resource-features {
  list-style: none;
  padding: 0;
  margin: 15px 0;
}

.resource-features li {
  padding: 8px 0;
  padding-left: 24px;
  position: relative;
  color: #4a5568;
  font-size: 0.9rem;
}

.resource-features li:before {
  content: "✓";
  position: absolute;
  left: 0;
  color: #10b981;
  font-weight: bold;
}

.resource-ideal {
  padding: 12px;
  background: #f0f9ff;
  border-radius: 8px;
  font-size: 0.9rem;
  color: #1e40af;
  margin: 15px 0;
}

.btn {
  display: inline-block;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s;
  border: none;
  cursor: pointer;
  font-size: 0.95rem;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea, #764ba2);
  color: white;
}

.btn-primary:hover {
  opacity: 0.9;
  transform: translateY(-2px);
}

.btn-block {
  display: block;
  width: 100%;
  margin-top: 20px;
}

.bg-gradient {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 60px 20px;
  text-align: center;
}

.bg-gradient h2 {
  font-size: 2rem;
  font-weight: 800;
  margin: 0 0 15px 0;
}

.bg-gradient p {
  font-size: 1.05rem;
  opacity: 0.95;
  max-width: 600px;
  margin: 0 auto 30px;
}

.btn-lg {
  padding: 14px 32px;
  font-size: 1rem;
}

.btn-secondary {
  background: transparent;
  border: 2px solid white;
  color: white;
}

.btn-secondary:hover {
  background: white;
  color: #667eea;
}

@media (max-width: 768px) {
  .resources-hero h1 {
    font-size: 1.8rem;
  }
  .section-title {
    font-size: 1.5rem;
  }
  .resources-grid-large {
    grid-template-columns: 1fr;
  }
}
</style>

<!-- HERO -->
<section class="resources-hero">
  <div class="container">
    <span class="hero-badge">🎁 Ressources Gratuites</span>
    <h1>Maîtrisez la Méthode<br>Persona / Contenu / Trafic</h1>
    <p style="max-width: 600px; margin: 20px auto 0; opacity: 0.95; font-size: 1.1rem;">
      Des guides concrets pour attirer vos vendeurs idéaux, créer du contenu qui convertit, et devenir visible sur Google — sans pub, sans portails.
    </p>
  </div>
</section>

<!-- INTRO MÉTHODE -->
<section class="bg-light">
  <div class="container">
    <div style="max-width: 800px; margin: 0 auto; text-align: center;">
      <p style="font-size: 1.1rem; color: #4a5568; line-height: 1.8; margin-bottom: 40px;">
        Ces ressources suivent la même méthode que notre plateforme :<br>
        <strong>Persona → Contenu → Trafic</strong>
      </p>
      
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px;">
        <div style="padding: 25px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
          <span style="font-size: 2.5rem;">👤</span>
          <h3 style="font-size: 1.05rem; margin: 15px 0 8px 0; color: #1a202c; font-weight: 700;">PERSONA</h3>
          <p style="font-size: 0.9rem; color: #718096; margin: 0;">Comprendre vos vendeurs idéaux</p>
        </div>
        <div style="padding: 25px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
          <span style="font-size: 2.5rem;">✍️</span>
          <h3 style="font-size: 1.05rem; margin: 15px 0 8px 0; color: #1a202c; font-weight: 700;">CONTENU</h3>
          <p style="font-size: 0.9rem; color: #718096; margin: 0;">Savoir quoi leur dire</p>
        </div>
        <div style="padding: 25px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
          <span style="font-size: 2.5rem;">📡</span>
          <h3 style="font-size: 1.05rem; margin: 15px 0 8px 0; color: #1a202c; font-weight: 700;">TRAFIC</h3>
          <p style="font-size: 0.9rem; color: #718096; margin: 0;">Les atteindre au bon endroit</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PILIER 1: PERSONA -->
<section class="resources-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge" style="background: linear-gradient(135deg, #f97316, #ea580c); color: white;">👤 Pilier PERSONA</span>
      <h2 class="section-title">Comprendre vos vendeurs idéaux</h2>
      <p class="section-subtitle">Avant de communiquer, il faut savoir à qui vous parlez</p>
    </div>
    
    <div class="resources-grid-large" style="max-width: 500px; margin: 0 auto;">
      <div class="resource-card-preview">
        <div class="resource-card-icon" style="background: linear-gradient(135deg, #f97316, #ea580c);">🧠</div>
        <div class="resource-card-body">
          <span class="resource-badge" style="background: #fff7ed; color: #c2410c;">Guide Complet</span>
          <h3>Guide NeuroPersona</h3>
          <p>La cartographie complète de vos clients selon les <strong>neurosciences</strong>. Comprenez les motivations profondes de vos vendeurs.</p>
          <ul class="resource-features">
            <li>Les 4 motivations profondes (Sécurité, Liberté, Reconnaissance, Contrôle)</li>
            <li>Les 5 personas immobiliers détaillés</li>
            <li>Comment identifier votre persona prioritaire</li>
            <li>Messages clés adaptés à chaque profil</li>
          </ul>
          <div class="resource-ideal">🎯 <strong>Idéal pour :</strong> Savoir exactement à qui vous vous adressez</div>
          <a href="/front/ressources/ressource-neuropersona.php" class="btn btn-primary btn-block">📥 Télécharger le Guide</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PILIER 2: CONTENU -->
<section class="resources-section bg-light">
  <div class="container">
    <div class="section-header">
      <span class="section-badge" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">✍️ Pilier CONTENU</span>
      <h2 class="section-title">Savoir quoi leur dire</h2>
      <p class="section-subtitle">Le bon message, à la bonne étape de leur réflexion</p>
    </div>
    
    <div class="resources-grid-large" style="max-width: 500px; margin: 0 auto;">
      <div class="resource-card-preview">
        <div class="resource-card-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">✍️</div>
        <div class="resource-card-body">
          <span class="resource-badge" style="background: #f5f3ff; color: #6d28d9;">Guide Complet</span>
          <h3>La Structure MERE</h3>
          <p>Comment écrire un article de blog qui <strong>convertit</strong>. La méthode approfondie pour créer du contenu qui attire et engage.</p>
          <ul class="resource-features">
            <li><strong>M</strong>iroir — Montrer que vous comprenez le problème</li>
            <li><strong>E</strong>xplication — Donner de la valeur concrète</li>
            <li><strong>R</strong>éponse — Proposer votre solution</li>
            <li><strong>E</strong>ngagement — Appeler à l'action</li>
          </ul>
          <div class="resource-ideal">🎯 <strong>Idéal pour :</strong> Écrire des articles qui génèrent des leads</div>
          <a href="/front/ressources/ressource-mere.php" class="btn btn-primary btn-block">📥 Télécharger le Guide</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PILIER 3: TRAFIC -->
<section class="resources-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">📡 Pilier TRAFIC</span>
      <h2 class="section-title">Les atteindre au bon endroit</h2>
      <p class="section-subtitle">Être visible là où vos vendeurs vous cherchent</p>
    </div>
    
    <div class="resources-grid-large">
      <div class="resource-card-preview">
        <div class="resource-card-icon" style="background: linear-gradient(135deg, #10b981, #059669);">🔍</div>
        <div class="resource-card-body">
          <span class="resource-badge" style="background: #ecfdf5; color: #047857;">Guide Complet</span>
          <h3>Guide SEO Local Immobilier</h3>
          <p>La structure technique complète pour <strong>dominer Google</strong> dans votre zone géographique.</p>
          <ul class="resource-features">
            <li>Les fondamentaux du SEO local immobilier</li>
            <li>Optimisation de votre fiche Google Business</li>
            <li>Structure de site optimisée</li>
            <li>Mots-clés locaux à cibler</li>
          </ul>
          <div class="resource-ideal">🎯 <strong>Idéal pour :</strong> Apparaître en 1ère page Google sur votre ville</div>
          <a href="/front/ressources/ressource-seo.php" class="btn btn-primary btn-block" style="background: linear-gradient(135deg, #10b981, #059669);">📥 Télécharger le Guide</a>
        </div>
      </div>
      
      <div class="resource-card-preview">
        <div class="resource-card-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">📍</div>
        <div class="resource-card-body">
          <span class="resource-badge" style="background: #eff6ff; color: #1d4ed8;">Ressource</span>
          <h3>Journal de Communication GMB</h3>
          <p>Ne plus jamais se demander <strong>"je poste quoi sur Google ?"</strong></p>
          <ul class="resource-features">
            <li>Planning simple (2 posts/semaine)</li>
            <li>5 types de posts efficaces</li>
            <li>Exemples rédigés prêts à adapter</li>
          </ul>
          <div class="resource-ideal">🎯 <strong>Idéal pour :</strong> Animer votre fiche Google régulièrement</div>
          <a href="/front/ressources/ressource-gmb.php" class="btn btn-primary btn-block" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">📥 Télécharger</a>
        </div>
      </div>
      
      <div class="resource-card-preview">
        <div class="resource-card-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">🔎</div>
        <div class="resource-card-body">
          <span class="resource-badge" style="background: #ecfeff; color: #0e7490;">Outil</span>
          <h3>Audit Visibilité Locale</h3>
          <p>Savoir si vous êtes <strong>visible ou invisible</strong> sur Google dans votre ville.</p>
          <ul class="resource-features">
            <li>Position réelle sur les recherches locales</li>
            <li>Mots-clés locaux principaux</li>
            <li>Axes d'amélioration prioritaires</li>
          </ul>
          <div class="resource-ideal">🎯 <strong>Idéal pour :</strong> Faire un état des lieux de votre présence digitale</div>
          <a href="/front/ressources/ressource-audit.php" class="btn btn-primary btn-block" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">🔎 Lancer l'Audit</a>
        </div>
      </div>
      
      <div class="resource-card-preview">
        <div class="resource-card-icon" style="background: linear-gradient(135deg, #ec4899, #db2777);">🧮</div>
        <div class="resource-card-body">
          <span class="resource-badge" style="background: #fdf2f8; color: #be185d;">Outil</span>
          <h3>Estimateur Immobilier</h3>
          <p>Testez un estimateur en ligne que vous pourrez ensuite <strong>personnaliser à votre image</strong>.</p>
          <ul class="resource-features">
            <li>Estimation indicative basée sur le marché</li>
            <li>Capture email automatique</li>
            <li>Message pédagogique intégré</li>
          </ul>
          <div class="resource-ideal">🎯 <strong>Idéal pour :</strong> Générer des leads propriétaires</div>
          <a href="/front/ressources/ressource-estimateur.php" class="btn btn-primary btn-block" style="background: linear-gradient(135deg, #ec4899, #db2777);">🧮 Tester l'Estimateur</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- AIDE À LA DÉCISION -->
<section class="resources-section bg-light">
  <div class="container">
    <div class="section-header">
      <span class="section-badge" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">🚀 Aide à la Décision</span>
      <h2 class="section-title">Prendre une décision éclairée</h2>
      <p class="section-subtitle">Visualiser le retour sur investissement</p>
    </div>
    
    <div class="resources-grid-large" style="max-width: 500px; margin: 0 auto;">
      <div class="resource-card-preview">
        <div class="resource-card-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">📊</div>
        <div class="resource-card-body">
          <span class="resource-badge" style="background: #f5f3ff; color: #6d28d9;">Outil</span>
          <h3>Calculateur ROI Immobilier</h3>
          <p>Montrer qu'<strong>une seule vente finance des années de visibilité</strong>.</p>
          <ul class="resource-features">
            <li>Commission moyenne de votre zone</li>
            <li>Budget portails actuel</li>
            <li>ROI clair et immédiat</li>
          </ul>
          <div class="resource-ideal">🎯 <strong>Idéal pour :</strong> Comparer le coût réel des différentes stratégies</div>
          <a href="/front/ressources/ressource-roi.php" class="btn btn-primary btn-block">📊 Calculer mon ROI</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PARCOURS RECOMMANDÉ -->
<section class="resources-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">🎯 Comment utiliser ces ressources</span>
      <h2 class="section-title">Le parcours recommandé</h2>
    </div>

    <div style="max-width: 700px; margin: 0 auto;">
      <div style="display: grid; gap: 20px;">
        <div style="display: flex; gap: 20px; align-items: flex-start;">
          <div style="background: linear-gradient(135deg, #f97316, #ea580c); color: white; padding: 12px 18px; border-radius: 8px; font-weight: 700; white-space: nowrap; min-width: 70px; text-align: center;">1</div>
          <div style="padding: 15px 20px; background: #f7fafc; border-radius: 10px; flex: 1;">
            <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Guide NeuroPersona</strong>
            <p style="color: #718096; margin: 0; font-size: 0.9rem;">Identifiez vos 1-2 personas prioritaires. Sans ça, tout le reste sera générique.</p>
          </div>
        </div>
        
        <div style="display: flex; gap: 20px; align-items: flex-start;">
          <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 12px 18px; border-radius: 8px; font-weight: 700; white-space: nowrap; min-width: 70px; text-align: center;">2</div>
          <div style="padding: 15px 20px; background: #f7fafc; border-radius: 10px; flex: 1;">
            <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Guide Structure MERE</strong>
            <p style="color: #718096; margin: 0; font-size: 0.9rem;">Apprenez à écrire du contenu qui parle à vos personas et les convertit.</p>
          </div>
        </div>
        
        <div style="display: flex; gap: 20px; align-items: flex-start;">
          <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 12px 18px; border-radius: 8px; font-weight: 700; white-space: nowrap; min-width: 70px; text-align: center;">3</div>
          <div style="padding: 15px 20px; background: #f7fafc; border-radius: 10px; flex: 1;">
            <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Guide SEO + Audit + GMB</strong>
            <p style="color: #718096; margin: 0; font-size: 0.9rem;">Rendez votre contenu visible sur Google dans votre zone.</p>
          </div>
        </div>
        
        <div style="display: flex; gap: 20px; align-items: flex-start;">
          <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 12px 18px; border-radius: 8px; font-weight: 700; white-space: nowrap; min-width: 70px; text-align: center;">4</div>
          <div style="padding: 15px 20px; background: #f7fafc; border-radius: 10px; flex: 1;">
            <strong style="color: #1a202c; display: block; margin-bottom: 5px;">Calculateur ROI</strong>
            <p style="color: #718096; margin: 0; font-size: 0.9rem;">Évaluez si un système complet vaut l'investissement pour vous.</p>
          </div>
        </div>
      </div>
      
      <div style="margin-top: 40px; padding: 25px; background: linear-gradient(135deg, rgba(102,126,234,0.1), rgba(118,75,162,0.1)); border-radius: 14px; text-align: center;">
        <p style="color: #1a202c; margin: 0; font-size: 1rem; line-height: 1.6;">
          💡 Ces ressources vous donnent la <strong>méthode</strong>.<br>
          ÉCOSYSTÈME IMMO vous donne <strong>l'outil pour l'exécuter</strong> + l'exclusivité territoriale.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="bg-gradient">
  <div class="container">
    <h2>Prêt à passer au système complet ?</h2>
    <p>
      Découvrez comment l'Assistant IA applique la méthode Persona/Contenu/Trafic<br>
      et vérifiez si votre ville est encore disponible.
    </p>
    <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
      <a href="/demo" class="btn btn-lg" style="background: white; color: #667eea;">🎬 Voir la Visite Guidée</a>
      <a href="/verifier-ma-ville" class="btn btn-lg btn-secondary">📍 Vérifier ma Ville</a>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>