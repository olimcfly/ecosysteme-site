<?php

declare(strict_types=1);

require_once __DIR__ . '/tracking.php';

if (($_GET['src'] ?? '') === 'capture_cta') {
    track_event('capture_to_video_click', ['from' => 'capture.php']);
}

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Présentation Ecosystème Immo et formulaire d'analyse personnalisée.">
  <title>Présentation — Ecosystème Immo</title>
  <link rel="stylesheet" href="/style.css">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #0f1115; color: #fff; overflow-x: hidden; }
    .presentation-container { position: relative; width: 100vw; min-height: 100vh; }
    .slide-section { position: relative; width: 100%; min-height: 100vh; }
    .slide {
      position: absolute; inset: 0; display: none; padding: 8vw;
      align-items: center; justify-content: center; text-align: center;
      flex-direction: column; background: linear-gradient(180deg, #111827, #0b1220);
    }
    .slide.active { display: flex; animation: fade 0.5s ease; }
    @keyframes fade { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    .slide-number { position: absolute; top: 24px; left: 24px; font-size: 14px; opacity: 0.7; }
    h1, h2 { font-size: clamp(2rem, 4vw, 4rem); line-height: 1.15; margin-bottom: 24px; max-width: 1000px; }
    p { font-size: clamp(1rem, 1.5vw, 1.4rem); line-height: 1.6; max-width: 900px; opacity: 0.95; }
    ul { margin-top: 24px; list-style: none; max-width: 900px; }
    ul li { font-size: clamp(1rem, 1.5vw, 1.3rem); margin: 12px 0; line-height: 1.5; }
    .controls {
      position: absolute; bottom: 30px; left: 0; width: 100%; display: flex;
      justify-content: center; gap: 12px; padding: 0 20px; z-index: 20;
    }
    button {
      background: #ffffff; color: #111827; border: none; border-radius: 12px;
      padding: 14px 22px; font-size: 16px; font-weight: bold; cursor: pointer;
      transition: all 0.3s ease;
    }
    button:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
    button.secondary { background: rgba(255,255,255,0.12); color: #fff; }
    button.secondary:hover { background: rgba(255,255,255,0.2); }
    .progress-wrap {
      position: absolute; bottom: 0; left: 0; width: 100%; height: 6px;
      background: rgba(255,255,255,0.08); z-index: 30;
    }
    .progress-bar { height: 100%; width: 0%; background: #ffffff; transition: width 0.3s ease; }
    .highlight { color: #93c5fd; }

    .form-section { background: #1a1f2e; padding: 80px 20px; text-align: center; }
    .form-container {
      max-width: 600px; margin: 0 auto; background: #2a2f3e;
      padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .form-title { font-size: 2rem; margin-bottom: 30px; color: #fff; }
    .form-group { margin-bottom: 20px; text-align: left; }
    .form-group label { display: block; margin-bottom: 8px; font-size: 14px; color: #cbd5e0; }
    .form-group input, .form-group textarea {
      width: 100%; padding: 12px 16px; border: 1px solid #4a5568;
      border-radius: 8px; background: #1a202c; color: #fff; font-size: 16px;
      transition: border-color 0.3s;
    }
    .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #4a90e2; }
    .form-group textarea { min-height: 120px; resize: vertical; }
    .submit-btn { width: 100%; padding: 16px; font-size: 16px; font-weight: bold; margin-top: 10px; background: #4a90e2; color: white; }
    .submit-btn:hover { background: #357abd; }
    .privacy-link { display: block; margin-top: 20px; font-size: 12px; color: #a0aec0; text-decoration: none; }
    .privacy-link:hover { color: #cbd5e0; }
    .error-message { color: #f56565; font-size: 14px; margin-top: 5px; display: none; }
    .info-message { margin-bottom: 16px; font-size: 14px; color: #bfdbfe; }
    @media (max-width: 768px) {
      .slide { padding: 16vw 8vw; }
      .controls { flex-wrap: wrap; bottom: 20px; }
      .form-container { padding: 30px 20px; }
      .form-title { font-size: 1.5rem; }
    }
  </style>
</head>
<body>
<div class="presentation-container">
  <div class="slide-section">
    <div class="slide active"><div class="slide-number">Slide 1 / 12</div><h1>Vous faites peut-être <span class="highlight">ces 7 erreurs</span> sans le savoir.</h1><p>La plupart des conseillers immobiliers expérimentés perdent des vendeurs qualifiés chaque mois à cause d'erreurs invisibles dans leur présence en ligne.</p></div>
    <div class="slide"><div class="slide-number">Slide 2 / 12</div><h2>Le problème ne vient pas de vous.</h2><ul><li>Vous avez de l'expérience</li><li>Vous connaissez votre marché</li><li>Vous savez accompagner vos clients</li></ul></div>
    <div class="slide"><div class="slide-number">Slide 3 / 12</div><h2>Et pourtant...</h2><ul><li>Peu d'appels vendeurs</li><li>Dépendance aux réseaux et aux portails</li><li>Difficulté à vous différencier</li><li>Manque de visibilité locale</li></ul></div>
    <div class="slide"><div class="slide-number">Slide 4 / 12</div><h2>Le vrai problème</h2><p>Votre présence en ligne ne génère pas assez de <strong>contacts vendeurs qualifiés</strong> parce qu'elle n'est pas optimisée pour convertir.</p></div>
    <div class="slide"><div class="slide-number">Slide 5 / 12</div><h2>Vous avez déjà essayé.</h2><ul><li>Un site</li><li>Des réseaux</li><li>Un CRM</li><li>De la publicité</li></ul></div>
    <div class="slide"><div class="slide-number">Slide 6 / 12</div><h2>Le problème n'est pas les outils.</h2><p>Le problème, c'est l'absence de structure. L'absence de système. Sans système, rien ne tient dans le temps.</p></div>
    <div class="slide"><div class="slide-number">Slide 7 / 12</div><h2>Ce qu'il vous faut</h2><p>Un écosystème immobilier local basé sur 4 piliers : <strong>Fondations, Offre, Trafic, Optimisation.</strong></p></div>
    <div class="slide"><div class="slide-number">Slide 8 / 12</div><h2>Avec un système</h2><ul><li>Vous devenez visible localement</li><li>Vous captez des contacts vendeurs</li><li>Vous structurez votre activité</li></ul></div>
    <div class="slide"><div class="slide-number">Slide 9 / 12</div><h2>Ce n'est pas un outil.</h2><p>C'est un système qui relie votre message, votre contenu, votre trafic et vos contacts.</p></div>
    <div class="slide"><div class="slide-number">Slide 10 / 12</div><h2>Vous gardez votre indépendance</h2><ul><li>Vos contacts</li><li>Vos données</li><li>Votre visibilité locale</li></ul></div>
    <div class="slide"><div class="slide-number">Slide 11 / 12</div><h2>Ce n'est pas une question de capacité.</h2><p>C'est une question de structure.</p></div>
    <div class="slide"><div class="slide-number">Slide 12 / 12</div><h2>Découvrez comment obtenir plus de contacts vendeurs qualifiés</h2><p>Remplissez le formulaire ci-dessous pour recevoir votre analyse personnalisée.</p></div>

    <div class="controls">
      <button class="secondary" id="prevBtn" type="button">← Précédent</button>
      <button id="nextBtn" type="button">Suivant →</button>
    </div>

    <div class="progress-wrap"><div class="progress-bar" id="progressBar"></div></div>
  </div>

  <div class="form-section" id="formSection">
    <div class="form-container">
      <h2 class="form-title">Recevez votre analyse gratuite</h2>
      <p class="info-message">Merci de compléter vos informations pour recevoir votre analyse personnalisée.</p>
      <form id="leadForm" action="/traitement-video.php" method="POST" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

        <div class="form-group">
          <label for="name">Votre nom*</label>
          <input type="text" id="name" name="name" required>
          <div class="error-message" id="name-error">Veuillez entrer votre nom</div>
        </div>

        <div class="form-group">
          <label for="email">Votre email*</label>
          <input type="email" id="email" name="email" required>
          <div class="error-message" id="email-error">Veuillez entrer un email valide</div>
        </div>

        <div class="form-group">
          <label for="city">Votre zone/ville*</label>
          <input type="text" id="city" name="city" required>
          <div class="error-message" id="city-error">Veuillez indiquer votre ville ou secteur</div>
        </div>

        <div class="form-group"><label for="phone">Votre téléphone</label><input type="tel" id="phone" name="phone"></div>
        <div class="form-group"><label for="website">Votre site web (si vous en avez un)</label><input type="url" id="website" name="website"></div>
        <div class="form-group"><label for="message">Votre message</label><textarea id="message" name="message" placeholder="Dites-nous en plus sur vos besoins..."></textarea></div>

        <button type="submit" class="submit-btn">Recevoir mon analyse gratuite</button>

        <a href="/formulaire.php" class="privacy-link">En soumettant ce formulaire, j'accepte la politique de confidentialité</a>
      </form>
    </div>
  </div>
</div>

<script>
  const slides = document.querySelectorAll('.slide');
  const progressBar = document.getElementById('progressBar');
  const nextBtn = document.getElementById('nextBtn');
  const prevBtn = document.getElementById('prevBtn');
  const formSection = document.getElementById('formSection');
  const form = document.getElementById('leadForm');

  let current = 0;

  function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('active'));
    slides[index].classList.add('active');
    const progress = ((index + 1) / slides.length) * 100;
    progressBar.style.width = progress + '%';

    if (index === slides.length - 1) {
      setTimeout(() => {
        formSection.scrollIntoView({ behavior: 'smooth' });
      }, 500);
    }
  }

  nextBtn.addEventListener('click', () => {
    if (current < slides.length - 1) {
      current++;
      showSlide(current);
    }
  });

  prevBtn.addEventListener('click', () => {
    if (current > 0) {
      current--;
      showSlide(current);
    }
  });

  showSlide(current);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight' && current < slides.length - 1) {
      current++;
      showSlide(current);
    }
    if (e.key === 'ArrowLeft' && current > 0) {
      current--;
      showSlide(current);
    }
  });

  form.addEventListener('submit', function(e) {
    let isValid = true;

    const name = document.getElementById('name');
    const nameError = document.getElementById('name-error');
    if (name.value.trim() === '') {
      nameError.style.display = 'block';
      isValid = false;
    } else {
      nameError.style.display = 'none';
    }

    const email = document.getElementById('email');
    const emailError = document.getElementById('email-error');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
      emailError.style.display = 'block';
      isValid = false;
    } else {
      emailError.style.display = 'none';
    }

    const city = document.getElementById('city');
    const cityError = document.getElementById('city-error');
    if (city.value.trim() === '') {
      cityError.style.display = 'block';
      isValid = false;
    } else {
      cityError.style.display = 'none';
    }

    if (!isValid) {
      e.preventDefault();
    }
  });
</script>
</body>
</html>
