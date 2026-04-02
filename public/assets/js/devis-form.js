(function () {
  'use strict';

  const form = document.getElementById('devis-form');
  const successBox = document.getElementById('success-box');
  const feedback = document.getElementById('form-feedback');
  const submitBtn = document.getElementById('submit-btn');
  const langField = document.getElementById('langue');
  const progressFill = document.getElementById('progress-fill');
  const stepLabels = document.querySelectorAll('.progress-steps span');

  const I18N = {
    fr: {
      labelLanguage: 'Langue / Language',
      heroTitle: 'Créer un site web professionnel qui génère des clients',
      heroSubtitle: 'Répondez à quelques questions pour recevoir une première recommandation adaptée à votre activité',
      credTitle: 'Nos sites sont conçus pour :',
      cred1: 'améliorer votre visibilité locale',
      cred2: 'générer des contacts qualifiés',
      cred3: 'structurer votre présence digitale',
      priceTitle: 'Investissement',
      priceCreation: 'Création : 1 997 € (paiement en 2 fois)',
      priceMaintenance: 'Maintenance : 147 €/mois',
      step1: 'Étape 1 → Votre activité',
      step2: 'Étape 2 → Votre besoin',
      step3: 'Étape 3 → Votre projet',
      fullName: 'Nom / Full name',
      business: 'Votre activité / Your business',
      chooseOption: 'Choisissez une option',
      other: 'Autre',
      city: "Ville ou zone d'activité / City or service area",
      placesHint: 'Google Places peut être activé en ajoutant votre clé API Maps JavaScript.',
      siteType: 'Type de site souhaité / Type of website',
      typeShowcase: 'Site vitrine',
      typeRealEstate: 'Site immobilier',
      typeLeads: 'Site avec génération de leads',
      typeSeo: 'Site SEO / blog',
      dontKnow: 'Je ne sais pas',
      mainGoal: 'Votre objectif principal / Main goal',
      goalLeads: 'Avoir plus de prospects',
      goalLocal: 'Être visible localement',
      goalLaunch: 'Lancer mon activité',
      goalModernize: 'Moderniser mon site',
      goalAutomate: 'Automatiser mes demandes',
      currentSite: 'Avez-vous déjà un site ? / Do you have a website?',
      yes: 'Oui',
      no: 'Non',
      inProgress: 'En cours',
      projectDesc: 'Décrivez votre besoin / Describe your project',
      timeline: 'Délai souhaité / Timeline',
      urgent: 'Urgent',
      thisMonth: 'Ce mois-ci',
      oneToThree: '1–3 mois',
      later: 'Plus tard',
      cta: 'Recevoir ma recommandation',
      microcopy: 'Réponse rapide et adaptée à votre activité. Sans engagement.',
      sending: 'Envoi...',
      validation: 'Merci de remplir tous les champs obligatoires.',
      error: 'Une erreur est survenue. Merci de réessayer.',
      successTitle: 'Merci, votre demande a bien été envoyée.',
      successText: 'Nous analysons votre besoin et revenons vers vous avec une première recommandation.',
      successWhatsApp: '👉 Vous pouvez aussi nous contacter directement sur WhatsApp pour aller plus vite.',
      leadScore: 'Score lead estimé',
      leadTemp: 'tempéré',
      leadHot: 'chaud'
    },
    en: {
      labelLanguage: 'Language / Langue',
      heroTitle: 'Build a professional website that generates clients',
      heroSubtitle: 'Answer a few questions to receive a first recommendation tailored to your business',
      credTitle: 'Our websites are designed to:',
      cred1: 'improve your local visibility',
      cred2: 'generate qualified leads',
      cred3: 'structure your digital presence',
      priceTitle: 'Investment',
      priceCreation: 'Creation: €1,997 (2 payments)',
      priceMaintenance: 'Maintenance: €147/month',
      step1: 'Step 1 → Your business',
      step2: 'Step 2 → Your needs',
      step3: 'Step 3 → Your project',
      fullName: 'Full name / Nom',
      business: 'Your business / Votre activité',
      chooseOption: 'Choose an option',
      other: 'Other',
      city: 'City or service area / Ville ou zone d’activité',
      placesHint: 'Google Places can be enabled by adding your Maps JavaScript API key.',
      siteType: 'Type of website / Type de site souhaité',
      typeShowcase: 'Showcase website',
      typeRealEstate: 'Real estate website',
      typeLeads: 'Lead generation website',
      typeSeo: 'SEO / blog website',
      dontKnow: "I don't know",
      mainGoal: 'Main goal / Objectif principal',
      goalLeads: 'Get more leads',
      goalLocal: 'Be visible locally',
      goalLaunch: 'Launch my business',
      goalModernize: 'Modernize my website',
      goalAutomate: 'Automate inbound requests',
      currentSite: 'Do you already have a website? / Avez-vous déjà un site ?',
      yes: 'Yes',
      no: 'No',
      inProgress: 'In progress',
      projectDesc: 'Describe your project / Décrivez votre besoin',
      timeline: 'Timeline / Délai souhaité',
      urgent: 'Urgent',
      thisMonth: 'This month',
      oneToThree: '1–3 months',
      later: 'Later',
      cta: 'Get my recommendation',
      microcopy: 'Fast response tailored to your business. No obligation.',
      sending: 'Sending...',
      validation: 'Please fill in all required fields.',
      error: 'An error occurred. Please try again.',
      successTitle: 'Thank you, your request has been sent.',
      successText: 'We are reviewing your needs and will get back to you with a first recommendation.',
      successWhatsApp: '👉 You can also contact us directly on WhatsApp for a faster reply.',
      leadScore: 'Estimated lead score',
      leadTemp: 'warm',
      leadHot: 'hot'
    }
  };

  function applyTranslations(lang) {
    const dictionary = I18N[lang] || I18N.fr;
    document.documentElement.lang = lang;

    document.querySelectorAll('[data-i18n]').forEach((el) => {
      const key = el.dataset.i18n;
      if (dictionary[key]) {
        el.textContent = dictionary[key];
      }
    });

    document.querySelectorAll('.lang-btn').forEach((btn) => {
      btn.classList.toggle('active', btn.dataset.lang === lang);
    });

    if (langField) {
      langField.value = lang;
    }
  }

  function updateProgress() {
    if (!form || !progressFill) {
      return;
    }

    const step1Fields = ['nom', 'activite', 'ville'];
    const step2Fields = ['type_site', 'objectif', 'site_actuel'];
    const step3Fields = ['message', 'delai'];

    const getValue = (name) => {
      const element = form.elements[name];
      if (!element) return '';

      if (element instanceof RadioNodeList) {
        return element.value;
      }

      return element.value;
    };

    const isComplete = (fields) => fields.every((name) => String(getValue(name) || '').trim() !== '');

    let completed = 0;
    if (isComplete(step1Fields)) completed += 1;
    if (isComplete(step2Fields)) completed += 1;
    if (isComplete(step3Fields)) completed += 1;

    progressFill.style.width = `${(completed / 3) * 100}%`;
    stepLabels.forEach((label) => {
      const step = Number(label.dataset.step);
      label.classList.toggle('active', step <= Math.max(1, completed));
      label.classList.toggle('done', step <= completed);
    });
  }

  if (form) {
    form.addEventListener('input', updateProgress);
    form.addEventListener('change', updateProgress);

    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      if (!form.checkValidity()) {
        feedback.textContent = I18N[langField.value].validation;
        form.reportValidity();
        return;
      }

      const formData = new FormData(form);
      const payload = Object.fromEntries(formData.entries());

      submitBtn.disabled = true;
      submitBtn.textContent = I18N[langField.value].sending;
      feedback.textContent = '';

      try {
        const response = await fetch('/api/devis-site-web.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (!response.ok || !data.ok) {
          throw new Error('API_ERROR');
        }

        form.hidden = true;
        successBox.hidden = false;

        const scoreLabel = data.score >= 60 ? I18N[langField.value].leadHot : I18N[langField.value].leadTemp;
        document.getElementById('lead-score').textContent = `${I18N[langField.value].leadScore}: ${data.score}/100 (${scoreLabel})`;
      } catch (error) {
        feedback.textContent = I18N[langField.value].error;
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = I18N[langField.value].cta;
      }
    });
  }

  document.querySelectorAll('.lang-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      const lang = btn.dataset.lang;
      applyTranslations(lang);
      updateProgress();
    });
  });

  window.initDevisPlaces = function () {
    const cityInput = document.getElementById('ville');
    if (!cityInput || !window.google || !window.google.maps || !window.google.maps.places) {
      return;
    }

    const autocomplete = new window.google.maps.places.Autocomplete(cityInput, {
      types: ['(cities)'],
      fields: ['formatted_address', 'name']
    });

    autocomplete.addListener('place_changed', function () {
      const place = autocomplete.getPlace();
      cityInput.value = place.name || place.formatted_address || cityInput.value;
    });
  };

  applyTranslations('fr');
  updateProgress();
})();
