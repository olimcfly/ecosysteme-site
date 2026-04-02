<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Devis site web | Ecosystème Immo</title>
  <meta name="description" content="Recevez une première recommandation pour votre site web professionnel via un formulaire bilingue optimisé conversion.">
  <link rel="canonical" href="https://ecosystemeimmo.fr/ecosysteme/devis-site-web">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="devis-page">
  <main class="devis-main">
    <section class="devis-hero">
      <div class="container container--mid">
        <div class="devis-lang-switch" role="group" aria-label="Language selector">
          <span class="devis-lang-label" data-i18n="labelLanguage">Langue / Language</span>
          <button class="lang-btn active" data-lang="fr" type="button">🇫🇷 Français</button>
          <button class="lang-btn" data-lang="en" type="button">🇬🇧 English</button>
        </div>

        <p class="devis-eyebrow">Ecosystème Immo</p>
        <h1 data-i18n="heroTitle">Créer un site web professionnel qui génère des clients</h1>
        <p class="devis-subtitle" data-i18n="heroSubtitle">Répondez à quelques questions pour recevoir une première recommandation adaptée à votre activité</p>
      </div>
    </section>

    <section class="devis-credibility">
      <div class="container container--mid">
        <h2 data-i18n="credTitle">Nos sites sont conçus pour :</h2>
        <ul>
          <li data-i18n="cred1">améliorer votre visibilité locale</li>
          <li data-i18n="cred2">générer des contacts qualifiés</li>
          <li data-i18n="cred3">structurer votre présence digitale</li>
        </ul>
      </div>
    </section>

    <section class="devis-pricing">
      <div class="container container--mid">
        <article class="pricing-card">
          <h3 data-i18n="priceTitle">Investissement</h3>
          <p><strong data-i18n="priceCreation">Création : 1 997 € (paiement en 2 fois)</strong></p>
          <p data-i18n="priceMaintenance">Maintenance : 147 €/mois</p>
        </article>
      </div>
    </section>

    <section class="devis-form-section">
      <div class="container container--mid">
        <div class="progress-wrap" aria-label="Progression du formulaire">
          <div class="progress-bar"><span id="progress-fill" style="width: 0%"></span></div>
          <div class="progress-steps">
            <span data-step="1" class="active" data-i18n="step1">Étape 1 → Votre activité</span>
            <span data-step="2" data-i18n="step2">Étape 2 → Votre besoin</span>
            <span data-step="3" data-i18n="step3">Étape 3 → Votre projet</span>
          </div>
        </div>

        <form id="devis-form" class="devis-form" novalidate>
          <input type="hidden" name="langue" id="langue" value="fr">

          <label for="nom" data-i18n="fullName">Nom / Full name</label>
          <input id="nom" name="nom" required>

          <label for="activite" data-i18n="business">Votre activité / Your business</label>
          <select id="activite" name="activite" required>
            <option value="" data-i18n="chooseOption">Choisissez une option</option>
            <option value="Conseiller immobilier">Conseiller immobilier</option>
            <option value="Agence">Agence</option>
            <option value="Artisan / Habitat">Artisan / Habitat</option>
            <option value="Autre" data-i18n="other">Autre</option>
          </select>

          <label for="ville" data-i18n="city">Ville ou zone d'activité / City or service area</label>
          <input id="ville" name="ville" required autocomplete="off" data-google-places="true">
          <small class="form-hint" data-i18n="placesHint">Google Places peut être activé en ajoutant votre clé API Maps JavaScript.</small>

          <label for="type_site" data-i18n="siteType">Type de site souhaité / Type of website</label>
          <select id="type_site" name="type_site" required>
            <option value="" data-i18n="chooseOption">Choisissez une option</option>
            <option value="Site vitrine" data-i18n="typeShowcase">Site vitrine</option>
            <option value="Site immobilier" data-i18n="typeRealEstate">Site immobilier</option>
            <option value="Site avec génération de leads" data-i18n="typeLeads">Site avec génération de leads</option>
            <option value="Site SEO / blog" data-i18n="typeSeo">Site SEO / blog</option>
            <option value="Je ne sais pas" data-i18n="dontKnow">Je ne sais pas</option>
          </select>

          <label for="objectif" data-i18n="mainGoal">Votre objectif principal / Main goal</label>
          <select id="objectif" name="objectif" required>
            <option value="" data-i18n="chooseOption">Choisissez une option</option>
            <option value="Avoir plus de prospects" data-i18n="goalLeads">Avoir plus de prospects</option>
            <option value="Être visible localement" data-i18n="goalLocal">Être visible localement</option>
            <option value="Lancer mon activité" data-i18n="goalLaunch">Lancer mon activité</option>
            <option value="Moderniser mon site" data-i18n="goalModernize">Moderniser mon site</option>
            <option value="Automatiser mes demandes" data-i18n="goalAutomate">Automatiser mes demandes</option>
          </select>

          <fieldset class="radio-group">
            <legend data-i18n="currentSite">Avez-vous déjà un site ? / Do you have a website?</legend>
            <label><input type="radio" name="site_actuel" value="Oui" required> <span data-i18n="yes">Oui</span></label>
            <label><input type="radio" name="site_actuel" value="Non"> <span data-i18n="no">Non</span></label>
            <label><input type="radio" name="site_actuel" value="En cours"> <span data-i18n="inProgress">En cours</span></label>
          </fieldset>

          <label for="message" data-i18n="projectDesc">Décrivez votre besoin / Describe your project</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <label for="delai" data-i18n="timeline">Délai souhaité / Timeline</label>
          <select id="delai" name="delai" required>
            <option value="" data-i18n="chooseOption">Choisissez une option</option>
            <option value="Urgent" data-i18n="urgent">Urgent</option>
            <option value="Ce mois-ci" data-i18n="thisMonth">Ce mois-ci</option>
            <option value="1-3 mois" data-i18n="oneToThree">1–3 mois</option>
            <option value="Plus tard" data-i18n="later">Plus tard</option>
          </select>

          <button type="submit" class="btn btn-primary btn-full" id="submit-btn" data-i18n="cta">Recevoir ma recommandation</button>
          <p class="devis-microcopy" data-i18n="microcopy">Réponse rapide et adaptée à votre activité. Sans engagement.</p>
          <p id="form-feedback" class="form-feedback" role="status" aria-live="polite"></p>
        </form>

        <section id="success-box" class="success-box" hidden>
          <h3 data-i18n="successTitle">Merci, votre demande a bien été envoyée.</h3>
          <p data-i18n="successText">Nous analysons votre besoin et revenons vers vous avec une première recommandation.</p>
          <p data-i18n="successWhatsApp">👉 Vous pouvez aussi nous contacter directement sur WhatsApp pour aller plus vite.</p>
          <div id="lead-score" class="lead-score"></div>
        </section>
      </div>
    </section>
  </main>

  <script src="/assets/js/devis-form.js"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places&callback=initDevisPlaces"></script>
</body>
</html>
