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

$leadId = htmlspecialchars((string) ($_GET['lead_id'] ?? ''), ENT_QUOTES, 'UTF-8');
$csrfToken = htmlspecialchars((string) ($_SESSION['csrf_token'] ?? ''), ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Présentation — Ecosystème Immo</title>
  <link rel="stylesheet" href="/style.css">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background: #0f1115;
      color: #fff;
      overflow-x: hidden;
    }

    .presentation-container {
      position: relative;
      width: 100vw;
      min-height: 100vh;
    }

    .slide-section {
      position: relative;
      width: 100%;
      min-height: 100vh;
    }

    .slide {
      position: absolute;
      inset: 0;
      display: none;
      padding: 8vw;
      align-items: center;
      justify-content: center;
      text-align: center;
      flex-direction: column;
      background: linear-gradient(180deg, #111827, #0b1220);
    }

    .slide.active {
      display: flex;
      animation: fade 0.5s ease;
    }

    @keyframes fade {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .slide-number {
      position: absolute;
      top: 24px;
      left: 24px;
      font-size: 14px;
      opacity: 0.7;
    }

    h1, h2 {
      font-size: clamp(2rem, 4vw, 4rem);
      line-height: 1.15;
      margin-bottom: 24px;
      max-width: 1000px;
    }

    p {
      font-size: clamp(1rem, 1.5vw, 1.4rem);
      line-height: 1.6;
      max-width: 900px;
      opacity: 0.95;
    }

    ul {
      margin-top: 24px;
      list-style: none;
      max-width: 900px;
    }

    ul li {
      font-size: clamp(1rem, 1.5vw, 1.3rem);
      margin: 12px 0;
      line-height: 1.5;
    }

    .controls {
      position: absolute;
      bottom: 30px;
      left: 0;
      width: 100%;
      display: flex;
      justify-content: center;
      gap: 12px;
      padding: 0 20px;
      z-index: 20;
    }

    button, .cta-link {
      background: #ffffff;
      color: #111827;
      border: none;
      border-radius: 12px;
      padding: 14px 22px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    button:hover, .cta-link:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    button.secondary {
      background: rgba(255,255,255,0.12);
      color: #fff;
    }

    button.secondary:hover {
      background: rgba(255,255,255,0.2);
    }

    .progress-wrap {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 6px;
      background: rgba(255,255,255,0.08);
      z-index: 30;
    }

    .progress-bar {
      height: 100%;
      width: 0%;
      background: #ffffff;
      transition: width 0.3s ease;
    }

    .highlight {
      color: #93c5fd;
    }

    /* Section formulaire */
    .form-section {
      background: #1a1f2e;
      padding: 80px 20px;
      text-align: center;
    }

    .form-container {
      max-width: 600px;
      margin: 0 auto;
      background: #2a2f3e;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .form-title {
      font-size: 2rem;
      margin-bottom: 30px;
      color: #fff;
    }

    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-size: 14px;
      color: #cbd5e0;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid #4a5568;
      border-radius: 8px;
      background: #1a202c;
      color: #fff;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #4a90e2;
    }

    .form-group textarea {
      min-height: 120px;
      resize: vertical;
    }

    .submit-btn {
      width: 100%;
      padding: 16px;
      font-size: 16px;
      font-weight: bold;
      margin-top: 10px;
      background: #4a90e2;
      color: white;
    }

    .submit-btn:hover {
      background: #357abd;
    }

    .privacy-link {
      display: block;
      margin-top: 20px;
      font-size: 12px;
      color: #a0aec0;
      text-decoration: none;
    }

    .privacy-link:hover {
      color: #cbd5e0;
    }

    .error-message {
      color: #f56565;
      font-size: 14px;
      margin-top: 5px;
      display: none;
    }

    @media (max-width: 768px) {
      .slide {
        padding: 16vw 8vw;
      }

      .controls {
        flex-wrap: wrap;
        bottom: 20px;
      }

      .form-container {
        padding: 30px 20px;
      }

      .form-title {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
<main>
  <section class="container">
    <div class="card center">
      <span class="badge">Étape 2 — Démonstration</span>
      <h1>Comment un conseiller devient la référence locale sur sa zone</h1>
      <div class="video-shell" aria-label="Vidéo de présentation ECOSYSTEMEIMMO">
        <div class="placeholder">Insérez ici votre vidéo (YouTube, Vimeo ou lecteur interne)</div>
      </div>
      <p>Vous découvrez un système simple pour générer des contacts vendeurs, gagner du temps et rester propriétaire de vos données.</p>
      <p><strong>Rappel :</strong> un seul conseiller est sélectionné par zone géographique.</p>
      <a class="btn btn-primary" href="/traitement-video.php">Voir l’offre</a>
    </div>
  </section>
</main>
</body>
</html>
