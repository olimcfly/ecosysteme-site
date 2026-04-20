/* =============================================
   ECOSYSTEME IMMO — main.js
   ============================================= */

(function () {
  'use strict';

  /* ── Villes fermées ── */
  const CLOSED_CITIES = [
    'bordeaux',
    'nantes',
    'nandy',
    'aix-en-provence',
    'aix en provence',
    'lannion',
  ];

  /* ── Normalise une chaîne pour comparaison ── */
  function normalize(str) {
    return str
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .trim();
  }

  const TRACK_ENDPOINT = '/api/track.php';
  const TRACKED_EVENTS = new Set();

  function getVisitorId() {
    var key = 'ecosysteme_visitor_id';
    var existing = localStorage.getItem(key);
    if (existing) return existing;
    var created = 'v_' + Math.random().toString(16).slice(2) + Date.now().toString(16);
    localStorage.setItem(key, created);
    return created;
  }

  function trackEvent(eventKey, extra) {
    var payload = Object.assign({
      event_key: eventKey,
      visitor_id: getVisitorId(),
      page: window.location.pathname
    }, extra || {});

    return fetch(TRACK_ENDPOINT, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    }).catch(function () { return null; });
  }

  function trackOnce(eventKey, extra) {
    if (TRACKED_EVENTS.has(eventKey)) return;
    TRACKED_EVENTS.add(eventKey);
    trackEvent(eventKey, extra);
  }

  trackOnce('page_capture_vue');

  /* ──────────────────────────────────────────
     MOBILE MENU
  ────────────────────────────────────────── */
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileNav     = document.getElementById('mobile-nav');

  if (mobileMenuBtn && mobileNav) {
    mobileNav.style.display = 'block';

    mobileMenuBtn.addEventListener('click', function () {
      const isOpen = mobileNav.classList.contains('open');
      mobileNav.classList.toggle('open', !isOpen);
      mobileMenuBtn.setAttribute('aria-expanded', String(!isOpen));
      mobileNav.setAttribute('aria-hidden', String(isOpen));
    });

    // Ferme le menu au clic sur un lien
    mobileNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mobileNav.classList.remove('open');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileNav.setAttribute('aria-hidden', 'true');
      });
    });

    document.addEventListener('click', function (event) {
      const clickInsideMenu = mobileNav.contains(event.target);
      const clickOnButton = mobileMenuBtn.contains(event.target);
      if (!clickInsideMenu && !clickOnButton) {
        mobileNav.classList.remove('open');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileNav.setAttribute('aria-hidden', 'true');
      }
    });
  }

  /* ──────────────────────────────────────────
     CITY CHECKER (section inline)
  ────────────────────────────────────────── */
  const checkerForm   = document.getElementById('checker-form');
  const checkerInput  = document.getElementById('checker-input');
  const checkerResult = document.getElementById('checker-result');

  if (checkerForm) {
    checkerForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const city = normalize(checkerInput.value);

      if (!city) return;

      checkerResult.style.display = 'block';

      if (CLOSED_CITIES.includes(city)) {
        checkerResult.className = 'checker-result checker-result--unavailable';
        checkerResult.innerHTML =
          '<strong>' + checkerInput.value + ' est déjà réservée.</strong><br>' +
          'Cette ville fait partie du programme. Inscrivez-vous pour être alerté si elle se libère, ou choisissez une ville voisine.';
      } else {
        checkerResult.className = 'checker-result checker-result--available';
        checkerResult.innerHTML =
          '<strong>' + checkerInput.value + ' est disponible.</strong>' +
          '<span class="result-cta">' +
            '<a href="#contact" class="btn btn-primary btn-full open-modal" data-city="' + checkerInput.value + '">' +
              'Réserver ma ville maintenant' +
            '</a>' +
          '</span>';

        // Bind le nouveau bouton dans le résultat
        const newBtn = checkerResult.querySelector('.open-modal');
        if (newBtn) {
          newBtn.addEventListener('click', function (ev) {
            ev.preventDefault();
            openModal(newBtn.dataset.city || '');
          });
        }
      }

      // Scroll vers le résultat sur mobile
      checkerResult.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
  }

  /* ──────────────────────────────────────────
     MODAL
  ────────────────────────────────────────── */
  const modalOverlay = document.getElementById('modal-overlay');
  const modalClose   = document.getElementById('modal-close');
  const modalCity    = document.getElementById('modal-city');
  const modalForm    = document.getElementById('modal-form');

  function openModal(prefillCity) {
    if (!modalOverlay) return;
    if (prefillCity && modalCity) modalCity.value = prefillCity;
    modalOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    // Focus sur le champ nom (premier champ vide), pas sur la ville déjà pré-remplie
    var nomField = document.getElementById('modal-nom');
    if (nomField && !nomField.value) {
      setTimeout(function () { nomField.focus(); }, 50);
    } else if (modalCity) {
      setTimeout(function () { modalCity.focus(); }, 50);
    }
  }

  function closeModal() {
    if (!modalOverlay) return;
    modalOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  // Tous les boutons CTA principaux ouvrent le modal
  document.querySelectorAll('.open-modal').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const city = btn.dataset.city || '';
      trackEvent('clic_cta', { meta: { cta_text: (btn.textContent || '').trim(), city: city } });
      openModal(city);
    });
  });

  if (modalClose) modalClose.addEventListener('click', closeModal);

  if (modalOverlay) {
    modalOverlay.addEventListener('click', function (e) {
      if (e.target === modalOverlay) closeModal();
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });

  // Soumission du formulaire modal
  // Endpoint configurable — remplacer par l'URL de votre backend ou service tiers
  var FORM_ENDPOINT = '/api/contact.php';

  if (modalForm) {
    modalForm.addEventListener('submit', function (e) {
      e.preventDefault();

      var btn   = modalForm.querySelector('button[type="submit"]');
      var nom   = (document.getElementById('modal-nom')   || {}).value || '';
      var email = (document.getElementById('modal-email') || {}).value || '';
      var city  = (document.getElementById('modal-city')  || {}).value || '';
      var phone = (document.getElementById('modal-phone') || {}).value || '';

      if (!nom || !email || !city) return;

      if (btn) { btn.disabled = true; btn.textContent = 'Envoi en cours…'; }

      fetch(FORM_ENDPOINT, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          nom: nom,
          email: email,
          phone: phone,
          city: city,
          visitor_id: getVisitorId()
        })
      })
      .then(function (res) { return res.json(); })
      .catch(function () { return { ok: true }; }) // Afficher le succès même si réseau KO
      .then(function () {
        modalForm.innerHTML =
          '<div style="text-align:center;padding:24px 0">' +
            '<div style="width:48px;height:48px;border-radius:50%;background:rgba(26,107,69,0.12);' +
              'border:1.5px solid rgba(26,107,69,0.4);display:flex;align-items:center;justify-content:center;' +
              'margin:0 auto 16px;font-size:1.3rem;color:#1A6B45">&#10003;</div>' +
            '<h3 style="color:var(--navy);margin-bottom:8px;font-size:1.2rem">Demande reçue</h3>' +
            '<p style="color:var(--gray-600);font-size:0.9rem;line-height:1.65">' +
              'Nous vérifions la disponibilité de <strong>' + city + '</strong><br>' +
              'et revenons vers vous sous 24h.' +
            '</p>' +
          '</div>';
      });
    });
  }

  const offerSection = document.getElementById('offre');
  if (offerSection && 'IntersectionObserver' in window) {
    const offerObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          trackOnce('offre_vue');
          offerObserver.disconnect();
        }
      });
    }, { threshold: 0.35 });
    offerObserver.observe(offerSection);
  }

  document.querySelectorAll('video').forEach(function (videoEl) {
    videoEl.addEventListener('play', function () {
      trackOnce('video_vue');
    }, { once: true });
  });

  /* ──────────────────────────────────────────
     FAQ ACCORDION
  ────────────────────────────────────────── */
  document.querySelectorAll('.faq-question').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const item = btn.closest('.faq-item');
      const isOpen = item.classList.contains('open');

      // Ferme tous les items
      document.querySelectorAll('.faq-item.open').forEach(function (openItem) {
        openItem.classList.remove('open');
      });

      // Ouvre le cliqué si ce n'était pas ouvert
      if (!isOpen) item.classList.add('open');
    });
  });

  /* ──────────────────────────────────────────
     SCROLL REVEAL
  ────────────────────────────────────────── */
  const revealEls = document.querySelectorAll('.reveal');

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    revealEls.forEach(function (el) { observer.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('visible'); });
  }

  /* ──────────────────────────────────────────
     NAVBAR — scroll effect
  ────────────────────────────────────────── */
  const navbar = document.querySelector('.navbar, .site-header');
  let lastScroll = 0;

  window.addEventListener('scroll', function () {
    const current = window.scrollY;

    if (!navbar) return;

    if (current > 80) {
      navbar.style.boxShadow = '0 2px 24px rgba(0,0,0,0.25)';
    } else {
      navbar.style.boxShadow = 'none';
    }

    lastScroll = current;
  }, { passive: true });

})();
