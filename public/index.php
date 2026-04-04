<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="ECOSYSTEMEIMMO : système pour devenir visible localement, capter des leads vendeurs, les suivre dans un CRM et automatiser vos séquences email.">
  <title>ECOSYSTEMEIMMO — Tunnel de vente conseillers immobiliers</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="navbar">
  <div class="navbar__inner">
    <a href="/" class="navbar__logo">Ecosystème<span>Immo</span></a>
    <nav class="navbar__links">
      <a href="#probleme">Problème</a>
      <a href="#solution">Solution</a>
      <a href="#offre">Offre</a>
      <a href="#cta-final">Rendez-vous</a>
      <a href="/admin/">Admin CRM</a>
    </nav>
    <a href="#cta-final" class="btn btn-primary open-modal">Réserver un appel</a>
  </div>
</header>

<main>
  <section class="hero">
    <div class="container container--mid hero__content">
      <p class="hero__eyebrow">Objectif : convaincre + préqualifier + augmenter le closing</p>
      <h1>Pourquoi certains conseillers immobiliers reçoivent des vendeurs…<br>et d'autres passent des semaines sans aucun appel ?</h1>
      <p class="hero__sub">👉 La différence n'est pas leur niveau. <strong>👉 C'est leur visibilité.</strong></p>
      <div class="hero__actions">
        <a href="#cta-final" class="btn btn-primary btn-lg open-modal">Réserver un rendez-vous</a>
        <a href="#solution" class="btn btn-outline btn-lg">Voir le système</a>
      </div>
    </div>
  </section>

  <section id="probleme" class="section-problem">
    <div class="container container--mid">
      <h2 class="section-title">Aujourd'hui, le marché est saturé.</h2>
      <p class="section-sub">Des milliers de conseillers utilisent les mêmes outils, publient les mêmes contenus et travaillent dans les mêmes réseaux.</p>
      <div class="problem-grid mt-8">
        <div class="problem-item"><div class="problem-item__text"><h4>Peu de visibilité</h4></div></div>
        <div class="problem-item"><div class="problem-item__text"><h4>Peu d'appels</h4></div></div>
        <div class="problem-item"><div class="problem-item__text"><h4>Dépendance totale</h4></div></div>
        <div class="problem-item"><div class="problem-item__text"><h4>Sans preuve sociale, personne ne vous appelle.</h4></div></div>
      </div>
    </div>
  </section>

  <section class="section-solution" id="solution">
    <div class="container container--mid solution-card">
      <h2 class="solution-card__headline">Le problème, ce n'est ni votre compétence, ni votre motivation, ni votre réseau.</h2>
      <p class="solution-card__sub">👉 Le problème, c'est que vous n'avez pas de système.</p>
      <p class="solution-card__sub">ECOSYSTEMEIMMO vous permet de construire votre propre écosystème immobilier local.</p>
      <ul class="pricing-features">
        <li class="pricing-feature">vous rend visible sur votre secteur</li>
        <li class="pricing-feature">attire vendeurs et acheteurs</li>
        <li class="pricing-feature">centralise vos contacts</li>
        <li class="pricing-feature">automatise votre communication</li>
      </ul>
    </div>
  </section>

  <section class="section-features" id="fonctionnalites">
    <div class="container container--mid">
      <h2 class="section-title">⚙️ Ce que vous obtenez</h2>
      <ul class="pricing-features">
        <li class="pricing-feature">stratégie de contenu local (SEO + silo)</li>
        <li class="pricing-feature">contenu basé sur 8 personas</li>
        <li class="pricing-feature">pages de capture + tunnel simple</li>
        <li class="pricing-feature">CRM avec suivi des contacts</li>
        <li class="pricing-feature">automatisation email</li>
        <li class="pricing-feature">présence régulière sans effort</li>
      </ul>

      <h3 style="margin-top:30px;">🧨 Différenciation forte</h3>
      <p>Les réseaux vous donnent des outils, vous mettent en concurrence et ne garantissent aucun résultat.</p>
      <p><strong>ECOSYSTEMEIMMO</strong> vous donne votre propre système, vous rend indépendant et vous positionne localement. 👉 Vous construisez un actif.</p>
    </div>
  </section>

  <section id="offre" class="section-pricing">
    <div class="container container--mid text-center">
      <h2 class="section-title">💰 Offre de lancement : 997€</h2>
      <p class="section-sub">Je lance actuellement ECOSYSTEMEIMMO avec un nombre limité de conseillers pour valider et optimiser le système.</p>
      <p><strong>⚠️ Ce tarif ne sera plus disponible ensuite.</strong></p>
      <p>🔥 <strong>1 seul conseiller par zone.</strong> Une fois la zone prise → fermé.</p>
      <a href="#cta-final" class="btn btn-primary btn-lg open-modal">Vérifier la disponibilité de ma zone</a>
    </div>
  </section>

  <section id="cta-final" class="section-final-cta">
    <div class="container">
      <div class="final-cta-box">
        <h2>👉 Réservez un rendez-vous pour voir si votre zone est disponible</h2>
        <p>Pendant cet appel : on analyse votre situation, on valide votre zone et on voit si le système est adapté pour vous.</p>
        <a href="#" class="btn btn-primary btn-lg open-modal">Réserver mon rendez-vous</a>
      </div>
    </div>
  </section>
</main>

<footer class="footer">
  <div class="container footer__inner">
    <div class="footer__logo">Ecosystème<span>Immo</span></div>
    <p class="footer__copy">&copy; <?php echo date('Y'); ?> ECOSYSTEMEIMMO — Funnel + CRM.</p>
  </div>
</footer>

<div class="modal-overlay" id="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modal-title">
  <div class="modal">
    <button class="modal__close" id="modal-close" aria-label="Fermer">&times;</button>
    <h3 id="modal-title">Réserver ma zone & mon appel</h3>
    <p>Complétez ce formulaire pour être rappelé et entrer dans la séquence d'accompagnement.</p>
    <form id="modal-form" novalidate>
      <div class="form-group"><label class="form-label" for="modal-nom">Nom complet *</label><input class="form-input" type="text" id="modal-nom" name="nom" required></div>
      <div class="form-group"><label class="form-label" for="modal-email">Adresse email *</label><input class="form-input" type="email" id="modal-email" name="email" required></div>
      <div class="form-group"><label class="form-label" for="modal-phone">Téléphone</label><input class="form-input" type="tel" id="modal-phone" name="phone"></div>
      <div class="form-group"><label class="form-label" for="modal-city">Votre zone / ville *</label><input class="form-input" type="text" id="modal-city" name="city" required></div>
      <button type="submit" class="btn btn-primary btn-full">Envoyer ma demande</button>
    </form>
  </div>
</div>

<script src="/assets/js/main.js"></script>
</body>
</html>
