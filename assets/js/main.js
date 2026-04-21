document.addEventListener('DOMContentLoaded', function () {

  /* ============================================================
     1. HEADER — SCROLL EFFECT
  ============================================================ */
  const header = document.querySelector('.site-header');
  if (header) {
    const onScroll = () => {
      header.classList.toggle('scrolled', window.scrollY > 20);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }


  /* ============================================================
     2. MOBILE MENU
  ============================================================ */
  const mobileMenuBtn   = document.querySelector('.mobile-menu-btn');
  const mobileMenu      = document.querySelector('.mobile-menu');
  const mobileMenuClose = document.querySelector('.mobile-menu-close');

  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  }

  if (mobileMenuClose && mobileMenu) {
    mobileMenuClose.addEventListener('click', () => {
      mobileMenu.classList.remove('open');
      document.body.style.overflow = '';
    });
  }

  document.querySelectorAll('.mobile-nav-link').forEach(link => {
    link.addEventListener('click', () => {
      if (mobileMenu) mobileMenu.classList.remove('open');
      document.body.style.overflow = '';
    });
  });


  /* ============================================================
     3. FAQ ACCORDION
  ============================================================ */
  document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
      const answer = btn.nextElementSibling;
      const isOpen = answer.classList.contains('open');

      // Ferme tout
      document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
      document.querySelectorAll('.faq-question').forEach(b => b.classList.remove('active'));

      if (!isOpen) {
        answer.classList.add('open');
        btn.classList.add('active');
      }
    });
  });


  /* ============================================================
     4. CONTACT FORM
  ============================================================ */
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const successMsg  = document.getElementById('form-success');
      const submitBtn   = contactForm.querySelector('[type="submit"]');
      const originalText = submitBtn.textContent;

      submitBtn.disabled    = true;
      submitBtn.textContent = 'Envoi en cours...';

      setTimeout(() => {
        submitBtn.disabled    = false;
        submitBtn.textContent = originalText;
        if (successMsg) {
          successMsg.style.display = 'flex';
          contactForm.reset();
          successMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
      }, 1200);
    });
  }


  /* ============================================================
     5. EMAIL CAPTURE FORM
  ============================================================ */
  const captureForm = document.getElementById('capture-form');
  if (captureForm) {
    captureForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const btn      = captureForm.querySelector('button');
      const input    = captureForm.querySelector('input');
      const original = btn.textContent;

      btn.disabled    = true;
      btn.textContent = 'Envoi...';

      setTimeout(() => {
        btn.disabled    = false;
        btn.textContent = '✓ Reçu !';
        input.value     = '';
        setTimeout(() => { btn.textContent = original; }, 3000);
      }, 900);
    });
  }


  /* ============================================================
     6. GUIDE FILTER BUTTONS
  ============================================================ */
  const filterBtns  = document.querySelectorAll('.filter-btn');
  const guideCards  = document.querySelectorAll('.guide-card-wrapper');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const tag = btn.dataset.tag;
      guideCards.forEach(card => {
        card.style.display = (tag === 'all' || card.dataset.tag === tag) ? '' : 'none';
      });
    });
  });


  /* ============================================================
     7. SCROLL REVEAL
  ============================================================ */
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-fade-in-up');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    revealEls.forEach(el => observer.observe(el));
  }


  /* ============================================================
     8. ACTIVE NAV LINK
  ============================================================ */
  const currentPath = window.location.pathname.split('/').pop() || 'index.php';
  document.querySelectorAll('.nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && (href === currentPath || (currentPath === '' && href === 'index.php'))) {
      link.classList.add('active');
    }
  });


  /* ============================================================
     9. DEMO FORM — VALIDATION INLINE
  ============================================================ */
  const demoForm = document.getElementById('demo-form');
  if (!demoForm) return;

  const rules = {
    prenom:      { min: 2,    msg: 'Prénom trop court.'          },
    nom:         { min: 2,    msg: 'Nom trop court.'             },
    email:       { type: 'email', msg: 'Email invalide.'         },
    telephone:   { pattern: /^(\+33|0)[1-9](\s?\d{2}){4}$/,
                   msg: 'Format attendu : 06 12 34 56 78'        },
    reseau:      { required: true, msg: 'Choisissez votre réseau.'    },
    objectif:    { required: true, msg: 'Choisissez un objectif.'     },
    departement: { required: true, msg: 'Choisissez un département.'  },
    ville:       { min: 2,    msg: 'Entrez votre ville ciblée.'  },
  };

  /* --- Attache les listeners sur chaque champ --- */
  Object.keys(rules).forEach(field => {
    const input = document.getElementById(field);
    if (!input) return;
    input.addEventListener('blur',  () => validateField(field, input));
    input.addEventListener('input', () => {
      if (input.classList.contains('is-error')) validateField(field, input);
    });
  });

  /* --- Fonction de validation d'un champ --- */
  function validateField(field, input) {
    const rule  = rules[field];
    const val   = input.value.trim();
    const errEl = document.getElementById('error-' + field);
    let valid   = true;
    let msg     = '';

    if (rule.min     && val.length < rule.min)   { valid = false; msg = rule.msg; }
    if (rule.required && !val)                   { valid = false; msg = rule.msg; }
    if (rule.type === 'email' &&
        !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) { valid = false; msg = rule.msg; }
    if (rule.pattern && !rule.pattern.test(val)) { valid = false; msg = rule.msg; }

    input.classList.toggle('is-error', !valid);
    input.classList.toggle('is-valid', valid && val.length > 0);
    if (errEl) errEl.textContent = valid ? '' : msg;

    return valid;
  }

  /* --- Validation RGPD --- */
  function validateRgpd() {
    const rgpd    = document.getElementById('rgpd');
    const errRgpd = document.getElementById('error-rgpd');
    const checked = rgpd && rgpd.checked;
    if (errRgpd) errRgpd.textContent = checked ? '' : 'Vous devez accepter pour continuer.';
    return checked;
  }

  // Listener live sur la case RGPD
  const rgpdBox = document.getElementById('rgpd');
  if (rgpdBox) rgpdBox.addEventListener('change', validateRgpd);

  /* --- Submit --- */
  demoForm.addEventListener('submit', function (e) {
    let allValid = true;

    Object.keys(rules).forEach(field => {
      const input = document.getElementById(field);
      if (input && !validateField(field, input)) allValid = false;
    });

    if (!validateRgpd()) allValid = false;

    if (!allValid) {
      e.preventDefault();
      const firstErr = demoForm.querySelector('.is-error');
      if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    /* Loading state */
    const btn     = document.getElementById('submit-btn');
    const btnText = btn.querySelector('.btn-text');
    const btnLoad = btn.querySelector('.btn-loading');
    btn.disabled          = true;
    btnText.style.display = 'none';
    btnLoad.style.display = 'inline';
  });

}); // fin DOMContentLoaded
