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
    if (modalCity) modalCity.focus();
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
  if (modalForm) {
    modalForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const btn = modalForm.querySelector('button[type="submit"]');
      const nom     = document.getElementById('modal-nom')?.value || '';
      const email   = document.getElementById('modal-email')?.value || '';
      const city    = document.getElementById('modal-city')?.value || '';
      const phone   = document.getElementById('modal-phone')?.value || '';

      // Désactive le bouton le temps du traitement
      if (btn) { btn.disabled = true; btn.textContent = 'Envoi en cours...'; }

      // Simulation envoi (à remplacer par fetch() vers votre backend)
      setTimeout(function () {
        modalForm.innerHTML =
          '<div style="text-align:center;padding:16px 0">' +
            '<div style="font-size:2rem;margin-bottom:16px">&#10003;</div>' +
            '<h3 style="color:var(--navy);margin-bottom:8px">Demande reçue !</h3>' +
            '<p style="color:var(--gray-600);font-size:0.9rem;line-height:1.6">' +
              'Nous vérifions la disponibilité de <strong>' + city + '</strong> et revenons vers vous sous 24h.' +
            '</p>' +
          '</div>';
      }, 800);
    });
  }

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
  const navbar = document.querySelector('.navbar');
  let lastScroll = 0;

  window.addEventListener('scroll', function () {
    const current = window.scrollY;

    if (current > 80) {
      navbar.style.boxShadow = '0 2px 24px rgba(0,0,0,0.25)';
    } else {
      navbar.style.boxShadow = 'none';
    }

    lastScroll = current;
  }, { passive: true });

})();
