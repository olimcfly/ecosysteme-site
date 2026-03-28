<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Visite guidée ÉCOSYSTÈME IMMO — Découvrez la méthode Persona/Contenu/Trafic">
    
    <title>🎬 Votre Visite Guidée | ÉCOSYSTÈME IMMO</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        .video-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
        }
        
        .video-header {
            padding: 20px 0;
            background: rgba(0,0,0,0.1);
        }
        
        .video-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .video-logo {
            color: white;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.3rem;
            text-decoration: none;
        }
        
        .video-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .video-container {
            max-width: 900px;
            width: 100%;
        }
        
        .video-welcome {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        
        .video-welcome h1 {
            color: white;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .video-welcome p {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .video-wrapper {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .video-player {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            background: #1a1a2e;
        }
        
        .video-player iframe,
        .video-player video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .video-coming-soon {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a1a2e 0%, #2d2d44 100%);
            color: white;
            text-align: center;
            padding: 40px;
        }
        
        .coming-soon-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .coming-soon-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: white;
        }
        
        .coming-soon-text {
            font-size: 1.1rem;
            opacity: 0.85;
            max-width: 500px;
            line-height: 1.7;
            margin-bottom: 25px;
        }
        
        .coming-soon-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.1);
            padding: 12px 25px;
            border-radius: var(--radius-full);
            font-size: 0.95rem;
            backdrop-filter: blur(10px);
        }
        
        .coming-soon-badge .dot {
            width: 10px;
            height: 10px;
            background: #27ae60;
            border-radius: 50%;
            animation: blink 1.5s ease-in-out infinite;
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
        
        .video-info {
            padding: 25px 30px;
            background: var(--light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .video-info-left h3 {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        
        .video-info-left p {
            color: var(--text-light);
            font-size: 0.9rem;
            margin: 0;
        }
        
        .video-cta {
            text-align: center;
            margin-top: 30px;
        }
        
        .video-cta p {
            color: white;
            opacity: 0.9;
            margin-bottom: 15px;
        }
        
        .features-reminder {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 40px;
        }
        
        .feature-item {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: var(--radius-md);
            text-align: center;
            color: white;
        }
        
        .feature-item .icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .feature-item h4 {
            font-size: 1rem;
            color: white;
            margin-bottom: 5px;
        }
        
        .feature-item p {
            font-size: 0.85rem;
            opacity: 0.8;
            margin: 0;
        }
        
        .pdf-download {
            margin-top: 25px;
            padding: 20px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: var(--radius-md);
            text-align: center;
        }
        
        .pdf-download p {
            color: white;
            margin-bottom: 12px;
            font-size: 0.95rem;
        }
        
        .pdf-download a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: #667eea;
            padding: 12px 20px;
            border-radius: var(--radius-md);
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s;
        }
        
        .pdf-download a:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="video-page">
        <!-- Header -->
        <header class="video-header">
            <div class="container">
                <a href="/" class="video-logo">ÉCOSYSTÈME IMMO</a>
                <a href="/front/pages/rdv.php" class="btn btn-sm" style="background: white; color: var(--primary);">
                    📞 Réserver un Appel
                </a>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="video-main">
            <div class="video-container">
                <!-- Welcome Message -->
                <div class="video-welcome">
                    <h1>🎉 Merci pour votre inscription !</h1>
                    <p>Découvrez la méthode Persona / Contenu / Trafic en 15 minutes</p>
                </div>
                
                <!-- Video Player -->
                <div class="video-wrapper">
                    <div class="video-player">
                        <!-- 
                        =============================================
                        🎬 REMPLACEZ CE BLOC PAR VOTRE VIDÉO :
                        
                        Option 1 - YouTube :
                        <iframe src="https://www.youtube.com/embed/VOTRE_ID" frameborder="0" allowfullscreen></iframe>
                        
                        Option 2 - Vimeo :
                        <iframe src="https://player.vimeo.com/video/VOTRE_ID" frameborder="0" allowfullscreen></iframe>
                        
                        Option 3 - Vidéo hébergée :
                        <video controls>
                            <source src="votre-video.mp4" type="video/mp4">
                        </video>
                        =============================================
                        -->
                        
                        <!-- Message en attendant la vidéo -->
                        <div class="video-coming-soon">
                            <div class="coming-soon-icon">🎬</div>
                            <h2 class="coming-soon-title">Vidéo en cours de préparation</h2>
                            <p class="coming-soon-text">
                                La visite guidée complète arrive bientôt.<br>
                                En attendant, téléchargez le Plan Pilote 90 jours<br>
                                ou réservez un appel pour une présentation personnalisée.
                            </p>
                            <div class="coming-soon-badge">
                                <span class="dot"></span>
                                <span>Disponible très prochainement</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="video-info">
                        <div class="video-info-left">
                            <h3>Visite Guidée ÉCOSYSTÈME IMMO</h3>
                            <p>Durée : 15 minutes • Méthode + Outils + Exclusivité</p>
                        </div>
                        <a href="/front/pages/rdv.php" class="btn btn-primary btn-sm">
                            📅 Préférez une Démo Live ?
                        </a>
                    </div>
                </div>
                
                <!-- PDF Download -->
                <div class="pdf-download">
                    <p>📄 Votre Plan Pilote 90 jours est prêt :</p>
                    <a href="/ressources/plan-pilote-90-jours.pdf" download>
                        📥 Télécharger le PDF
                    </a>
                </div>
                
                <!-- CTA -->
                <div class="video-cta">
                    <p>Vous voulez voir le système en direct et vérifier si votre ville est disponible ?</p>
                    <a href="/front/pages/rdv.php" class="btn btn-lg" style="background: white; color: var(--primary);">
                        📞 Réserver Mon Appel (30 min)
                    </a>
                </div>
                
                <!-- Features Reminder - Aligné sur l'offre réelle -->
                <div class="features-reminder">
                    <div class="feature-item">
                        <div class="icon">👤</div>
                        <h4>PERSONA</h4>
                        <p>Identifier vos vendeurs idéaux</p>
                    </div>
                    <div class="feature-item">
                        <div class="icon">✍️</div>
                        <h4>CONTENU</h4>
                        <p>Savoir quoi leur dire</p>
                    </div>
                    <div class="feature-item">
                        <div class="icon">📡</div>
                        <h4>TRAFIC</h4>
                        <p>Les atteindre au bon endroit</p>
                    </div>
                    <div class="feature-item">
                        <div class="icon">🏆</div>
                        <h4>EXCLUSIVITÉ</h4>
                        <p>Une ville = un partenaire</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="js/main.js"></script>
</body>
</html>