<?php
declare(strict_types=1);
$closed_cities = ['Bordeaux', 'Nantes', 'Nandy', 'Aix-en-Provence', 'Lannion'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Votre ville a une seule place disponible. Écosystème Immo installe votre système d'acquisition local : site, SEO, CRM, automatisations IA. Exclusif à votre territoire.">
  <title>Écosystème Immo — Système d'acquisition local pour conseillers immobiliers</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<!-- SCARCITY BAR -->
<div id="scarcity-bar" role="note">
  Territoires complets&nbsp;: <?php echo implode(' &middot; ', $closed_cities); ?>
  &nbsp;&mdash;&nbsp;
  <a href="#verifier">Vérifiez votre ville &rarr;</a>
</div>

<!-- NAVIGATION -->
<nav class="nav" aria-label="Navigation principale">
  <div class="container nav__inner">
    <a href="/" class="nav__logo">Écosystème<span>Immo</span></a>
    <ul class="nav__links" role="list">
      <li><a href="#process">Comment ça marche</a></li>
      <li><a href="offre.php">Offres</a></li>
      <li><a href="#realisations">Réalisations</a></li>
      <li><a href="blog/">Blog</a></li>
    </ul>
    <a href="#verifier" class="btn btn-primary nav__cta">Vérifier ma ville</a>
    <button class="nav__hamburger" aria-label="Menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<main>

<!-- HERO -->
<section class="hero" aria-labelledby="hero-h1">
  <div class="container container--narrow" style="text-align:center;">
    <p class="hero__eyebrow">Un seul conseiller par ville</p>
    <h1 id="hero-h1">Votre ville a une seule place disponible.</h1>
    <p class="hero__sub">
      Écosystème Immo installe votre système d'acquisition local — site professionnel,
      SEO, Google Business, pages secteurs, CRM et automatisations IA.
      Exclusif à votre territoire.
    </p>
    <div class="hero__actions">
      <a href="#verifier" class="btn btn-primary btn-xl">Vérifier si ma ville est disponible</a>
      <a href="#process" class="btn btn-outline btn-xl">Comment ça marche</a>
    </div>
    <div class="hero__reassurance">
      <span>Sans engagement</span>
      <span>Réponse sous 24h</span>
      <span>1 seul conseiller par ville</span>
    </div>
  </div>
</section>

<!-- COMMENT ÇA MARCHE -->
<section class="section" id="process" aria-labelledby="process-h2">
  <div class="container">
    <div class="section__eyebrow text-center">Le processus</div>
    <h2 class="text-center" id="process-h2">Comment ça marche</h2>
    <div class="process-grid">
      <div class="process-step">
        <span class="process-step__number">01</span>
        <h3>Vous vérifiez votre ville</h3>
        <p>Renseignez votre commune. Si elle est disponible, vous recevez une confirmation et un brief personnalisé sous 24h.</p>
      </div>
      <div class="process-step">
        <span class="process-step__number">02</span>
        <h3>On installe votre système (en 21 jours)</h3>
        <p>Site, SEO local, Google Business, pages secteurs, CRM et automatisations. Vous validez chaque étape. On livre clé en main.</p>
      </div>
      <div class="process-step">
        <span class="process-step__number">03</span>
        <h3>Votre territoire travaille pour vous</h3>
        <p>Les vendeurs de votre ville vous trouvent sur Google. Les demandes arrivent directement dans votre CRM.</p>
      </div>
    </div>
    <div style="text-align:center;margin-top:40px;">
      <a href="#verifier" class="btn btn-primary btn-lg">Vérifier si ma ville est disponible</a>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="section section--alt" aria-labelledby="features-h2">
  <div class="container">
    <div class="section__eyebrow">Ce que vous obtenez</div>
    <h2 id="features-h2">Un système d'acquisition local, pas un outil de plus.</h2>
    <p class="section__intro">
      Visibilité locale, contenus SEO, capture vendeurs, suivi CRM et automatisations IA — activé sur votre territoire exclusif.
    </p>
    <div class="features-grid">
      <div class="feature-card">
        <span class="feature-card__number">01</span>
        <h3>Site immobilier local</h3>
        <p>Professionnel, mobile-first, brandé à votre nom. Pensé pour capter les propriétaires vendeurs de votre secteur.</p>
      </div>
      <div class="feature-card">
        <span class="feature-card__number">02</span>
        <h3>Pages secteurs et quartiers</h3>
        <p>Des pages dédiées à vos communes et zones d'influence, optimisées pour apparaître sur Google quand un vendeur cherche dans votre ville.</p>
      </div>
      <div class="feature-card">
        <span class="feature-card__number">03</span>
        <h3>Google Business Profile</h3>
        <p>Une fiche locale cohérente avec votre site. Indispensable pour apparaître sur Google Maps et dans les résultats locaux.</p>
      </div>
      <div class="feature-card">
        <span class="feature-card__number">04</span>
        <h3>Formulaire vendeur</h3>
        <p>Un point d'entrée clair pour capter les demandes d'estimation et les contacts vendeurs directement depuis votre site.</p>
      </div>
      <div class="feature-card">
        <span class="feature-card__number">05</span>
        <h3>CRM et suivi prospects</h3>
        <p>Suivi centralisé de vos contacts, statuts et prochaines actions. Tout au même endroit, sans outils dispersés.</p>
      </div>
      <div class="feature-card">
        <span class="feature-card__number">06</span>
        <h3>Automatisations et IA</h3>
        <p>Rappels automatiques, relances intelligentes, scoring prospects. Le système travaille quand vous prospectez.</p>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="section" id="offre" aria-labelledby="pricing-h2">
  <div class="container">
    <div class="section__eyebrow">Les formules</div>
    <h2 id="pricing-h2">Sécurisez votre territoire</h2>
    <p class="section__intro">Un système. Un territoire. Un conseiller. Chaque formule inclut l'exclusivité sur votre secteur.</p>

    <div class="pricing-grid">

      <!-- Estimateur -->
      <div class="pricing-card">
        <div class="pricing-card__name">Estimateur</div>
        <div class="pricing-card__price">27 <sub>€/mois</sub></div>
        <div class="pricing-card__setup">+ 197 € setup unique</div>
        <hr class="pricing-card__divider">
        <ul class="pricing-features">
          <li>Estimateur immobilier intégré</li>
          <li>Formulaire de capture vendeurs</li>
          <li>Hébergement et maintenance</li>
        </ul>
        <p class="pricing-card__for">Pour les conseillers qui veulent démarrer par la capture d'estimations.</p>
        <a href="formulaire.php?formule=estimateur" class="btn btn-outline-dark btn-full">Choisir cette formule</a>
      </div>

      <!-- Mensuelle RECOMMANDÉE -->
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
        <a href="#verifier" class="btn btn-primary btn-full">Vérifier si ma ville est disponible</a>
      </div>

      <!-- Annuelle MEILLEURE VALEUR -->
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

      <!-- Exclusivité Verrouillée -->
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

    <!-- Programme Fondateur fermé -->
    <div class="pricing-fondateur">
      <div class="pricing-fondateur__title">Programme Fondateur — Places épuisées</div>
      <p>Les 5 premiers conseillers ont rejoint le programme à 47 €/mois à vie. Ces places sont fermées. Ce sont eux qui apparaissent dans les réalisations ci-dessous.</p>
    </div>

    <p class="pricing-reassurance">
      Vos données, votre domaine, votre site — vous repartez avec tout si vous partez.<br>
      Un seul conseiller par territoire. La disponibilité dépend de votre ville.
    </p>
  </div>
</section>

<!-- REALISATIONS -->
<section class="section section--alt" id="realisations" aria-labelledby="realisations-h2">
  <div class="container">
    <div class="section__eyebrow">Territoires installés</div>
    <h2 id="realisations-h2">Les territoires déjà installés</h2>
    <p class="section__intro">Cinq bases locales construites pour des conseillers indépendants. Ces territoires sont désormais fermés.</p>

    <div class="realisations-grid">

      <div class="realisation-card">
        <span class="realisation-badge">Territoire complet</span>
        <div class="realisation-card__name">Eduardo De Sul</div>
        <div class="realisation-card__location">Bordeaux Métropole</div>
        <p>Livré en 18 jours : site local, 6 pages secteurs, estimateur intégré, 3 articles SEO de démarrage, séquence email vendeurs. Présence propriétaire sur Bordeaux, indépendante de son réseau.</p>
      </div>

      <div class="realisation-card">
        <span class="realisation-badge">Territoire complet</span>
        <div class="realisation-card__name">Pascal Hamm</div>
        <div class="realisation-card__location">Aix-en-Provence</div>
        <p>Site brandé, pages services, estimateur, structure SEO locale. Fondation digitale posée sur un marché à forte concurrence.</p>
      </div>

      <div class="realisation-card">
        <span class="realisation-badge">Territoire complet</span>
        <div class="realisation-card__name">Fatima Rabia</div>
        <div class="realisation-card__location">Nandy / Sénart</div>
        <p>Site local humanisé, formulaire vendeur, pages secteurs. Présence propriétaire sur son territoire d'origine.</p>
      </div>

      <div class="realisation-card">
        <span class="realisation-badge">Territoire complet</span>
        <div class="realisation-card__name">Stéphanie Hulen</div>
        <div class="realisation-card__location">Lannion / Trégor</div>
        <p>Site local, pages géographiques, contenus et formulaires. Présence digitale ancrée dans l'identité bretonne de son territoire.</p>
      </div>

      <div class="realisation-card">
        <span class="realisation-badge">Territoire complet</span>
        <div class="realisation-card__name">Brice Chupin</div>
        <div class="realisation-card__location">Nantes</div>
        <p>Positionnement "coach immobilier" rendu visible localement. Présence différenciante sur Nantes.</p>
      </div>

    </div>

    <div class="realisations-cta">
      <p>Ces territoires sont fermés. Le vôtre est peut-être encore disponible.</p>
      <a href="#verifier" class="btn btn-primary btn-lg">Vérifier ma ville</a>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section" aria-labelledby="faq-h2">
  <div class="container container--narrow">
    <div class="section__eyebrow text-center">Questions fréquentes</div>
    <h2 class="text-center" id="faq-h2">Questions fréquentes</h2>

    <div class="faq-list" role="list">

      <div class="faq-item" role="listitem">
        <button class="faq-question" aria-expanded="false">
          Est-ce que je dois gérer le site moi-même ?
          <span class="faq-icon" aria-hidden="true">+</span>
        </button>
        <div class="faq-answer">
          Non. On gère tout — maintenance, mises à jour, contenus SEO, Google Business Profile.
          Vous recevez les demandes, on gère le système.
        </div>
      </div>

      <div class="faq-item" role="listitem">
        <button class="faq-question" aria-expanded="false">
          En combien de temps je vois des résultats ?
          <span class="faq-icon" aria-hidden="true">+</span>
        </button>
        <div class="faq-answer">
          Les premiers contacts vendeurs arrivent généralement sous 60 à 90 jours.
          Le référencement local se renforce sur 3 à 6 mois.
          Le système travaille en continu, pas ponctuellement.
        </div>
      </div>

      <div class="faq-item" role="listitem">
        <button class="faq-question" aria-expanded="false">
          Et si je change de réseau ou de secteur ?
          <span class="faq-icon" aria-hidden="true">+</span>
        </button>
        <div class="faq-answer">
          Le domaine, le site et toutes vos données vous appartiennent.
          Vous pouvez continuer à utiliser le système indépendamment de votre réseau.
        </div>
      </div>

    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="cta-final" id="verifier" aria-labelledby="cta-h2">
  <div class="container container--narrow">
    <h2 id="cta-h2">Votre territoire est encore disponible ?</h2>
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

<!-- FOOTER -->
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
      <a href="#realisations">Réalisations</a>
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
