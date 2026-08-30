<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Formules Écosystème Immo : Estimateur à 27€/mois, Mensuelle à 97€/mois, Annuelle à 897€/an. Un système d'acquisition local exclusif à votre territoire.">
  <title>Offres — Écosystème Immo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div id="scarcity-bar" role="note">
  Territoires complets&nbsp;: Bordeaux &middot; Nantes &middot; Nandy &middot; Aix-en-Provence &middot; Lannion
  &nbsp;&mdash;&nbsp;
  <a href="formulaire.php">Vérifiez votre ville &rarr;</a>
</div>

<nav class="nav" aria-label="Navigation principale">
  <div class="container nav__inner">
    <a href="/" class="nav__logo">Écosystème<span>Immo</span></a>
    <ul class="nav__links" role="list">
      <li><a href="/#process">Comment ça marche</a></li>
      <li><a href="offre.php" aria-current="page">Offres</a></li>
      <li><a href="/#realisations">Réalisations</a></li>
      <li><a href="blog/">Blog</a></li>
    </ul>
    <a href="formulaire.php" class="btn btn-primary nav__cta">Vérifier ma ville</a>
    <button class="nav__hamburger" aria-label="Menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<main>

<!-- HERO OFFRE -->
<section class="offre-hero">
  <div class="container">
    <h1>Un seul territoire. Un seul conseiller.<br>Un système qui travaille pour vous.</h1>
    <p>Chaque formule inclut l'exclusivité territoriale et l'installation complète de votre système d'acquisition local.</p>
    <a href="formulaire.php" class="btn btn-primary btn-xl">Vérifier si ma ville est disponible</a>
  </div>
</section>

<!-- PRICING COMPLET -->
<section class="section" aria-labelledby="pricing-h2">
  <div class="container">
    <h2 id="pricing-h2" class="sr-only">Formules et tarifs</h2>
    <div class="pricing-grid">

      <div class="pricing-card">
        <div class="pricing-card__name">Estimateur</div>
        <div class="pricing-card__price">27 <sub>€/mois</sub></div>
        <div class="pricing-card__setup">+ 197 € setup unique</div>
        <hr class="pricing-card__divider">
        <ul class="pricing-features">
          <li>Estimateur immobilier intégré à votre site</li>
          <li>Formulaire de capture vendeurs</li>
          <li>Hébergement et maintenance</li>
        </ul>
        <p class="pricing-card__for">Pour les conseillers qui veulent démarrer par la capture d'estimations.</p>
        <a href="formulaire.php?formule=estimateur" class="btn btn-outline-dark btn-full">Choisir cette formule</a>
      </div>

      <div class="pricing-card pricing-card--recommended">
        <div class="pricing-badge pricing-badge--rec">Recommandée</div>
        <div class="pricing-card__name">Mensuelle</div>
        <div class="pricing-card__price">97 <sub>€/mois</sub></div>
        <div class="pricing-card__setup">+ 497 € setup · 3 mois prépayés à l'activation</div>
        <hr class="pricing-card__divider">
        <ul class="pricing-features">
          <li>Site immobilier local à votre nom</li>
          <li>Pages secteurs et quartiers</li>
          <li>Google Business Profile</li>
          <li>Estimateur et formulaire vendeur</li>
          <li>CRM et suivi prospects</li>
          <li>Automatisations et relances IA</li>
          <li>Contenu SEO mensuel</li>
          <li>Exclusivité territoriale</li>
        </ul>
        <p class="pricing-card__for">Pour les conseillers qui veulent un système complet sans engagement annuel.</p>
        <a href="formulaire.php?formule=mensuelle" class="btn btn-primary btn-full">Vérifier si ma ville est disponible</a>
      </div>

      <div class="pricing-card pricing-card--best">
        <div class="pricing-badge pricing-badge--best">Meilleure valeur</div>
        <div class="pricing-card__name">Annuelle</div>
        <div class="pricing-card__price">897 <sub>€/an</sub></div>
        <div class="pricing-card__setup">Setup offert (497 € économisés)</div>
        <div class="pricing-card__equiv">≈ 74 €/mois · Économisez 267 € vs mensuel</div>
        <hr class="pricing-card__divider">
        <ul class="pricing-features">
          <li>Tout le contenu de la formule Mensuelle</li>
          <li>Setup offert</li>
          <li>Exclusivité territoriale renforcée</li>
          <li>Priorité sur les villes à forte demande</li>
        </ul>
        <p class="pricing-card__for">Pour les conseillers qui veulent sécuriser leur territoire durablement.</p>
        <a href="formulaire.php?formule=annuelle" class="btn btn-primary btn-full">Sécuriser mon territoire</a>
      </div>

      <div class="pricing-card pricing-card--lock">
        <div class="pricing-card__name">Exclusivité Verrouillée</div>
        <div class="pricing-card__price">900 <sub>€</sub></div>
        <div class="pricing-card__setup">Paiement unique — sans abonnement</div>
        <hr class="pricing-card__divider">
        <p style="font-size:14px;color:var(--navy-700);line-height:1.65;margin-bottom:20px;">
          Verrou territorial à vie sur votre ville. Sans abonnement. Sans renouvellement.
          Votre territoire reste bloqué pour les concurrents, quelle que soit votre formule active.
        </p>
        <a href="formulaire.php?formule=exclusivite" class="btn btn-outline-dark btn-full">Me renseigner sur cette option</a>
      </div>

    </div>

    <div class="pricing-fondateur">
      <div class="pricing-fondateur__title">Programme Fondateur — Places épuisées</div>
      <p>Les 5 premiers conseillers ont rejoint le programme à 47 €/mois à vie. Ces places sont fermées.</p>
    </div>

    <p class="pricing-reassurance">
      Vos données, votre domaine, votre site — vous repartez avec tout si vous partez.<br>
      Un seul conseiller par territoire. La disponibilité dépend de votre ville.<br>
      <strong>Premiers contacts vendeurs observés sous 60 à 90 jours selon le territoire.</strong>
    </p>
  </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final" aria-labelledby="cta-offre-h2">
  <div class="container container--narrow">
    <h2 id="cta-offre-h2">Votre territoire est encore disponible ?</h2>
    <p>La vérification est gratuite et sans engagement. Si votre ville est libre, vous recevez une confirmation sous 24h.</p>
    <a href="formulaire.php" class="btn btn-primary btn-xl">Vérifier si ma ville est disponible</a>
    <div class="cta-final__note">
      <span>Sans engagement</span>
      <span>Réponse sous 24h</span>
      <span>Un seul conseiller par ville</span>
    </div>
  </div>
</section>

</main>

<footer class="footer">
  <div class="container">
    <div class="footer__inner">
      <div>
        <div class="footer__logo">Écosystème<span>Immo</span></div>
        <p class="footer__tagline">Système d'acquisition local pour conseillers immobiliers indépendants.</p>
      </div>
      <div class="footer__contact">
        <p>Olivier Colas</p>
        <p><a href="tel:+33785611700">07 85 61 17 00</a></p>
        <p><a href="mailto:contact@ecosystemeimmo.fr">contact@ecosystemeimmo.fr</a></p>
      </div>
    </div>
    <nav class="footer__links" aria-label="Liens secondaires">
      <a href="offre.php">Offres</a>
      <a href="/#realisations">Réalisations</a>
      <a href="blog/">Blog</a>
      <a href="formulaire.php">Contact</a>
    </nav>
    <div class="footer__bottom">
      <p class="footer__copy">&copy; <?php echo date('Y'); ?> Écosystème Immo — OCDM Agency</p>
      <nav class="footer__legal" aria-label="Liens légaux">
        <a href="mentions-legales.php">Mentions légales</a>
        <a href="cgu.php">CGU</a>
        <a href="confidentialite.php">Confidentialité</a>
      </nav>
    </div>
  </div>
</footer>

<script src="/assets/js/main.js"></script>
</body>
</html>
