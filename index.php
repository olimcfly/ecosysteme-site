<?php
require_once 'data/guides.php';

$page_title = 'Guides pratiques pour conseillers immobiliers indépendants';
$meta_description = 'Écosystème Immo : 12 guides pratiques à 47€ pour aider les conseillers immobiliers indépendants à clarifier leur positionnement, attirer des vendeurs et structurer leur acquisition locale.';

include 'includes/header.php';
?>

<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="hero-inner">
      <div class="hero-content">
        <div class="hero-badge">
          <span class="hero-badge-dot"></span>
          Collection complète — 12 guides pratiques
        </div>
        <h1 class="hero-title">
          Construisez votre acquisition immobilière avec<br>
          <span>12 guides concrets et directement applicables</span>
        </h1>
        <p class="hero-subtitle">
          Positionnement, personas vendeurs, message, contenus, SEO local, Google Business Profile, tunnel vendeur, emails, estimation, publicité Facebook et méthode FOTO : chaque guide vous aide à structurer un levier clé de votre développement.
        </p>
        <div class="hero-ctas">
          <a href="guides.php" class="btn btn-primary btn-lg">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            Découvrir les 12 guides
          </a>
          <a href="contact.php" class="btn btn-outline-white btn-lg">Demander un audit gratuit</a>
        </div>
        <div class="hero-stats">
          <div>
            <div class="hero-stat-number">12</div>
            <div class="hero-stat-label">Guides pratiques</div>
          </div>
          <div>
            <div class="hero-stat-number">47€</div>
            <div class="hero-stat-label">Par guide</div>
          </div>
          <div>
            <div class="hero-stat-number">1</div>
            <div class="hero-stat-label">Levier clé par guide</div>
          </div>
          <div>
            <div class="hero-stat-number">100%</div>
            <div class="hero-stat-label">Applicable immédiatement</div>
          </div>
        </div>
      </div>

      <div class="hero-visual">
        <div class="hero-card">
          <div class="hero-card-title">La collection Écosystème Immo</div>
          <div class="hero-guide-list">
            <?php foreach (array_slice($guides, 0, 5) as $g): ?>
            <a href="guide.php?slug=<?= $g['slug'] ?>" class="hero-guide-item">
              <div class="hero-guide-number"><?= $g['id'] ?></div>
              <span><?= htmlspecialchars($g['titre']) ?></span>
            </a>
            <?php endforeach; ?>
            <a href="guides.php" class="hero-guide-item" style="border: 1px dashed rgba(255,255,255,.2); justify-content: center;">
              <span style="color: rgba(255,255,255,.6); font-size: .875rem;">+ 7 autres guides →</span>
            </a>
          </div>
          <div class="hero-card-footer">
            <div>
              <div class="hero-price-tag">47€ <span>/ guide</span></div>
              <div style="font-size: .75rem; color: rgba(255,255,255,.5); margin-top: 2px;">Accès immédiat · PDF</div>
            </div>
            <a href="guides.php" class="btn btn-primary btn-sm">Voir la collection</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TRUST BAR -->
<div class="trust-bar">
  <div class="container">
    <div class="trust-items">
      <div class="trust-item"><span class="trust-icon">✓</span> Téléchargement immédiat</div>
      <div class="trust-item"><span class="trust-icon">✓</span> Format PDF accessible</div>
      <div class="trust-item"><span class="trust-icon">✓</span> Méthodes terrain éprouvées</div>
      <div class="trust-item"><span class="trust-icon">✓</span> Sans jargon technique</div>
      <div class="trust-item"><span class="trust-icon">✓</span> Applicable dès aujourd'hui</div>
      <div class="trust-item"><span class="trust-icon">✓</span> Paiement sécurisé</div>
    </div>
  </div>
</div>

<!-- PROBLEM SECTION -->
<section class="section problem-section">
  <div class="container">
    <div class="section-header center">
      <span class="section-tag">Le constat</span>
      <h2 class="section-title">Pourquoi ces 12 guides existent</h2>
      <p class="section-subtitle">Ils répondent aux blocages les plus fréquents des conseillers immobiliers indépendants qui veulent attirer plus de vendeurs sans s’éparpiller.</p>
    </div>
    <div class="problem-grid">
      <div class="problem-card">
        <div class="problem-icon">🚫</div>
        <div class="problem-text">
          <h4>Vous manquez de clarté sur votre positionnement</h4>
          <p>Sans cible claire, sans promesse forte et sans message différenciant, vous restez interchangeable face à la concurrence locale.</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="problem-icon">📉</div>
        <div class="problem-text">
          <h4>Vous êtes peu visible quand un vendeur vous cherche</h4>
          <p>Google, Google Business Profile, contenus locaux, réseaux sociaux : vous savez que c’est important, mais vous ne savez pas comment les utiliser efficacement.</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="problem-icon">❓</div>
        <div class="problem-text">
          <h4>Vous ne savez pas quoi dire ni quoi publier</h4>
          <p>Entre personas, contenus, emails, tunnels et posts, vous manquez d’une méthode simple pour parler aux bons vendeurs avec les bons angles.</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="problem-icon">⏱️</div>
        <div class="problem-text">
          <h4>Vous manquez de temps pour tout structurer</h4>
          <p>Vous gérez déjà les visites, les relances, les compromis et les rendez-vous. Il devient difficile de construire une acquisition locale cohérente seul.</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="problem-icon">💬</div>
        <div class="problem-text">
          <h4>Vous avez du mal à convaincre et convertir</h4>
          <p>Obtenir de l’attention ne suffit pas. Il faut ensuite rassurer, relancer, faire avancer et transformer un contact en rendez-vous vendeur qualifié.</p>
        </div>
      </div>
      <div class="problem-card">
        <div class="problem-icon">🔄</div>
        <div class="problem-text">
          <h4>Vos résultats restent irréguliers</h4>
          <p>Un mois ça rentre, le mois suivant plus rien. Sans système clair, votre activité dépend encore trop du hasard, du bouche-à-oreille ou de la prospection subie.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SOLUTION SECTION -->
<section class="section">
  <div class="container">
    <div class="solution-grid">
      <div class="solution-visual">
        <div class="solution-image-wrapper">
          <div class="solution-image-placeholder">
            <span class="icon-big">📚</span>
            <p style="font-size: 1.125rem; font-weight: 600; color: var(--primary-700);">Collection Écosystème Immo</p>
            <p style="font-size: .9375rem; color: var(--neutral-500); margin-top: 8px;">12 guides · Acquisition locale structurée</p>
          </div>
        </div>
        <div class="solution-badge">
          <div class="solution-badge-number">12</div>
          <div class="solution-badge-label">guides pratiques</div>
        </div>
      </div>
      <div>
        <span class="section-tag">La solution</span>
        <h2 class="section-title" style="margin-top: 12px;">Une collection pensée pour construire un vrai système</h2>
        <p style="font-size: 1.0625rem; color: var(--neutral-600); line-height: 1.7; margin-bottom: 32px;">
          Ces 12 guides couvrent les fondations, le contenu, la visibilité, la conversion, le trafic et la logique système. Chaque guide traite un levier précis, avec une promesse claire et des actions directement applicables.
        </p>
        <div class="solution-points">
          <div class="solution-point">
            <div class="solution-point-icon">✓</div>
            <div>
              <h4>Des guides spécialisés, pas du contenu fourre-tout</h4>
              <p>Chaque guide répond à un besoin concret : positionnement, personas vendeurs, SEO local, Google Business Profile, emails, estimation, Facebook Ads ou tunnel vendeur.</p>
            </div>
          </div>
          <div class="solution-point">
            <div class="solution-point-icon">✓</div>
            <div>
              <h4>Du concret, pas du blabla</h4>
              <p>Vous avancez avec des méthodes simples, des angles actionnables et une logique métier pensée pour les conseillers immobiliers indépendants.</p>
            </div>
          </div>
          <div class="solution-point">
            <div class="solution-point-icon">✓</div>
            <div>
              <h4>Une progression logique</h4>
              <p>Les guides se complètent pour former un ensemble cohérent : être visible, attirer les bons vendeurs, convertir davantage et structurer votre acquisition locale sur la durée.</p>
            </div>
          </div>
        </div>
        <div style="margin-top: 36px; display: flex; gap: 16px; flex-wrap: wrap;">
          <a href="guides.php" class="btn btn-primary">Voir la collection complète</a>
          <a href="methode.php" class="btn btn-secondary">Découvrir la méthode</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- GUIDES SECTION -->
<section class="section bg-light">
  <div class="container">
    <div class="section-header center">
      <span class="section-tag">La collection</span>
      <h2 class="section-title">12 guides pour maîtriser chaque levier de votre acquisition</h2>
      <p class="section-subtitle">Commencez par le guide qui répond à votre blocage du moment, puis construisez progressivement votre système complet.</p>
    </div>
    <div class="guides-grid">
      <?php
      $guide_icons = ['🏠', '🔍', '🎯', '💬', '🎨', '💼', '📧', '⭐', '✍️', '📱', '🤝', '⚡'];
      foreach (array_slice($guides, 0, 6) as $index => $guide):
        $colors = ['#1A3C6E','#0E7490','#1A3C6E','#065F46','#7C3AED','#0369A1'];
        $bg = $colors[$index % count($colors)];
      ?>
      <div class="guide-card">
        <div class="guide-card-cover" style="background: linear-gradient(135deg, <?= $bg ?>, <?= $bg ?>cc);">
          <div class="guide-card-cover-inner">
            <div class="guide-card-number"><?= sprintf('%02d', $guide['id']) ?></div>
            <div class="guide-card-icon"><?= $guide_icons[$index] ?></div>
            <div class="guide-card-cover-title"><?= htmlspecialchars($guide['titre']) ?></div>
          </div>
          <span class="guide-card-tag"><?= htmlspecialchars($guide['tag']) ?></span>
        </div>
        <div class="guide-card-body">
          <h3 class="guide-card-title"><?= htmlspecialchars($guide['titre']) ?></h3>
          <p class="guide-card-desc"><?= htmlspecialchars($guide['promesse_courte']) ?></p>
          <div class="guide-card-footer">
            <div class="guide-card-price"><?= $guide['prix'] ?>€ <span>HT</span></div>
            <a href="guide.php?slug=<?= $guide['slug'] ?>" class="btn btn-dark btn-sm">Découvrir →</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align: center; margin-top: 48px;">
      <a href="guides.php" class="btn btn-primary btn-lg">Voir les 12 guides de la collection</a>
    </div>
  </div>
</section>

<!-- BENEFITS SECTION -->
<section class="section benefits-section">
  <div class="container">
    <div class="section-header center">
      <span class="section-tag" style="background: rgba(245,158,11,.15); color: var(--accent-400);">Ce que vous allez gagner</span>
      <h2 class="section-title" style="color: var(--white);">Des leviers concrets pour mieux vendre</h2>
      <p class="section-subtitle" style="color: rgba(255,255,255,.7);">Chaque guide vise un résultat précis : plus de clarté, plus de visibilité, plus de contacts et plus de mandats.</p>
    </div>
    <div class="benefits-grid">
      <div class="benefit-card">
        <div class="benefit-icon">📈</div>
        <div class="benefit-content">
          <h4>Un positionnement plus clair</h4>
          <p>Vous saurez enfin à qui vous vous adressez, quoi promettre et comment vous différencier localement.</p>
        </div>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">🗺️</div>
        <div class="benefit-content">
          <h4>Une visibilité locale plus forte</h4>
          <p>SEO local, Google Business Profile et contenus ciblés vous aident à exister là où les vendeurs vous cherchent réellement.</p>
        </div>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">⚙️</div>
        <div class="benefit-content">
          <h4>Un système plus cohérent</h4>
          <p>Vous arrêtez les actions isolées pour mettre en place des leviers qui se complètent au lieu de se disperser.</p>
        </div>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">🤝</div>
        <div class="benefit-content">
          <h4>Plus de rendez-vous et de mandats</h4>
          <p>Avec les bons angles, les bons messages et les bons tunnels, vous améliorez votre capacité à transformer un contact en mission signée.</p>
        </div>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">⏳</div>
        <div class="benefit-content">
          <h4>Moins de temps perdu</h4>
          <p>Vous allez plus vite parce que vous savez quoi faire, dans quel ordre, et sur quel levier concentrer vos efforts.</p>
        </div>
      </div>
      <div class="benefit-card">
        <div class="benefit-icon">🏆</div>
        <div class="benefit-content">
          <h4>Une posture plus professionnelle</h4>
          <p>Votre communication devient plus claire, plus rassurante et plus crédible, du premier contact jusqu’à la signature.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- METHOD OVERVIEW -->
<section class="section">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;">
      <div>
        <span class="section-tag">La méthode</span>
        <h2 class="section-title" style="margin-top: 12px;">Les guides suivent une logique de progression</h2>
        <p style="font-size: 1.0625rem; color: var(--neutral-600); line-height: 1.7; margin-bottom: 28px;">
          Beaucoup de conseillers testent des choses dans le désordre : un peu de contenu, un peu de pub, un peu de Google, puis plus rien. Résultat : pas de continuité, pas de système, peu de retour.
        </p>
        <p style="font-size: 1.0625rem; color: var(--neutral-600); line-height: 1.7; margin-bottom: 36px;">
          Cette collection vous aide à avancer dans le bon ordre : d’abord les fondations, ensuite la visibilité, puis la conversion et enfin la mise en système. C’est cette cohérence qui fait la différence.
        </p>
        <a href="methode.php" class="btn btn-primary">Comprendre la méthode complète</a>
      </div>
      <div class="method-steps">
        <div class="method-step">
          <div class="method-step-number">1</div>
          <div class="method-step-content">
            <h4>Clarifier les fondations</h4>
            <p>Positionnement local, personas vendeurs et message : savoir à qui vous parlez et comment vous rendre mémorable.</p>
          </div>
        </div>
        <div class="method-step">
          <div class="method-step-number">2</div>
          <div class="method-step-content">
            <h4>Devenir visible localement</h4>
            <p>SEO local, Google Business Profile, articles et contenus : être trouvé par les propriétaires de votre secteur.</p>
          </div>
        </div>
        <div class="method-step">
          <div class="method-step-number">3</div>
          <div class="method-step-content">
            <h4>Attirer et convertir</h4>
            <p>Tunnel vendeur, emails, estimation et contenus ciblés : transformer votre visibilité en rendez-vous concrets.</p>
          </div>
        </div>
        <div class="method-step">
          <div class="method-step-number">4</div>
          <div class="method-step-content">
            <h4>Passer en mode système</h4>
            <p>Facebook Ads et méthode FOTO : assembler les bons leviers pour structurer une acquisition plus régulière et plus rentable.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="section bg-light">
  <div class="container">
    <div class="section-header center">
      <span class="section-tag">Ils nous font confiance</span>
      <h2 class="section-title">Ce que disent les conseillers qui utilisent nos guides</h2>
    </div>
    <div class="testimonials-grid">
      <div class="testimonial-card">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">"J'ai appliqué la méthode Google My Business en une semaine. En moins d'un mois, j'ai reçu 4 demandes de contacts via ma fiche Google. C'est concret, simple et ça marche."</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">MM</div>
          <div>
            <div class="testimonial-name">Marie-Hélène M.</div>
            <div class="testimonial-role">Conseillère immobilière — Loire-Atlantique</div>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">"Les scripts de prise de mandats m'ont permis de mieux gérer les objections. J'ai signé 3 mandats exclusifs supplémentaires le mois suivant. Un investissement rentabilisé en quelques jours."</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">TP</div>
          <div>
            <div class="testimonial-name">Thierry P.</div>
            <div class="testimonial-role">Conseiller indépendant — Île-de-France</div>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">"Ce qui m'a conquis c'est le ton. Pas de jargon, pas de promesses folles. C'est écrit par quelqu'un qui connaît vraiment le terrain. J'ai tout lu d'une traite et j'ai commencé à appliquer le lendemain."</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">SL</div>
          <div>
            <div class="testimonial-name">Sophie L.</div>
            <div class="testimonial-role">Mandataire immobilière — Rhône-Alpes</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- EMAIL CAPTURE -->
<section class="section capture-section">
  <div class="container">
    <div class="capture-inner">
      <span class="section-tag">Ressources gratuites</span>
      <h2 class="section-title" style="margin-top: 12px;">Recevez nos conseils et ressources en avant-première</h2>
      <p style="font-size: 1.0625rem; color: var(--neutral-600); line-height: 1.7; margin-top: 16px;">
        Rejoignez les conseillers qui reçoivent nos idées, méthodes et contenus pratiques pour mieux structurer leur acquisition locale.
      </p>
      <form class="capture-form" id="capture-form">
        <input type="email" placeholder="Votre adresse email professionnelle" required>
        <button type="submit" class="btn btn-primary">Je m'abonne gratuitement</button>
      </form>
      <p class="capture-note">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        Zéro spam. Désinscription en un clic. Vos données restent privées.
      </p>
    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="section cta-section">
  <div class="container container-md">
    <div class="section-header center" style="margin-bottom: 0;">
      <span class="section-tag" style="background: rgba(245,158,11,.15); color: var(--accent-400);">Prêt à passer à l'action ?</span>
      <h2 class="section-title" style="color: var(--white); margin-top: 16px;">Choisissez le guide qui débloque votre prochain levier</h2>
      <p class="section-subtitle" style="color: rgba(255,255,255,.75); margin-top: 16px;">
        47€ par guide. Téléchargement immédiat. Lecture rapide. Application concrète. Pas d’abonnement, pas de jargon, pas de perte de temps.
      </p>
      <div class="cta-buttons">
        <a href="guides.php" class="btn btn-primary btn-lg">Voir les 12 guides →</a>
        <a href="contact.php" class="btn btn-outline-white btn-lg">Parler à un conseiller</a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>