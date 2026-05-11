<?php
$pageTitle = "Guide GMB - Écosystème Immo";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@400;600;800&display=swap');

        body { 
            background: #0a192f; /* Bleu marine profond du site */
            font-family: 'Inter', sans-serif; 
            color: #ffffff; 
            background-image: radial-gradient(circle at 20% 30%, rgba(0, 97, 255, 0.05) 0%, transparent 50%), 
                              radial-gradient(circle at 80% 70%, rgba(224, 170, 62, 0.05) 0%, transparent 50%);
        }

        .lp-container { max-width: 800px; margin: 0 auto; padding: 60px 20px; text-align: center; }

        .lp-header { margin-bottom: 40px; }
        
        .lp-badge { 
            background: rgba(224, 170, 62, 0.1); 
            color: #e0aa3e; /* Doré du site */
            padding: 8px 20px; 
            border-radius: 30px; 
            font-size: 0.85rem; 
            font-weight: 700; 
            border: 1px solid rgba(224, 170, 62, 0.3);
            margin-bottom: 25px; 
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .lp-title { 
            font-family: 'Playfair Display', serif; 
            font-size: 3.2rem; 
            font-weight: 900; 
            line-height: 1.1; 
            margin-bottom: 25px;
            color: #ffffff;
        }

        .lp-title span { color: #e0aa3e; }

        .lp-subtitle { 
            font-size: 1.25rem; 
            color: rgba(255,255,255,0.7); 
            max-width: 650px; 
            margin: 0 auto 40px; 
            line-height: 1.6;
        }

        .lp-card { 
            background: rgba(255, 255, 255, 0.03); 
            padding: 45px 35px; 
            border-radius: 30px; 
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            text-align: left;
            margin-top: 20px;
        }

        .lp-price-tag {
            text-align: center;
            font-size: 1.1rem;
            font-weight: 800;
            color: #e0aa3e;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .lp-input { 
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            padding: 16px 20px; 
            border-radius: 12px; 
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .lp-input:focus {
            background: rgba(255,255,255,0.08);
            border-color: #e0aa3e;
            color: #fff;
            box-shadow: none;
        }

        .lp-btn { 
            background: #e0aa3e; 
            color: #0a192f; 
            padding: 18px; 
            border-radius: 12px; 
            font-weight: 800; 
            border: none; 
            width: 100%; 
            font-size: 1.1rem;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .lp-btn:hover { 
            background: #f1bd50; 
            transform: translateY(-3px); 
            box-shadow: 0 10px 20px rgba(224, 170, 62, 0.2);
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 0.95rem;
            color: rgba(255,255,255,0.8);
        }

        .benefit-item i { color: #e0aa3e; font-size: 1.2rem; }

        footer { margin-top: 60px; opacity: 0.4; font-size: 0.8rem; letter-spacing: 1px; }

        @media (max-width: 768px) {
            .lp-title { font-size: 2.2rem; }
            .lp-container { padding: 40px 15px; }
            .lp-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>

<div class="lp-container">
    <div class="lp-header">
        <span class="lp-badge">Guide Stratégique Immobilier</span>
        <h1 class="lp-title">Attirez plus de <span>vendeurs locaux</span> grâce à Google Maps.</h1>
        <p class="lp-subtitle">La méthode exacte pour transformer votre fiche établissement en machine à prospects sans dépenser 1€ de pub.</p>
    </div>

    <div class="lp-card shadow-lg">
        <div class="lp-price-tag">Valeur exceptionnelle : 47€ seulement</div>
        
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="benefit-item"><i class="bi bi-patch-check-fill"></i> Référencement local #1</div>
                <div class="benefit-item"><i class="bi bi-patch-check-fill"></i> Secret des avis 5 étoiles</div>
            </div>
            <div class="col-md-6">
                <div class="benefit-item"><i class="bi bi-patch-check-fill"></i> Boost de conversion</div>
                <div class="benefit-item"><i class="bi bi-patch-check-fill"></i> Automatisation GMB</div>
            </div>
        </div>

        <form action="traitement-capture.php" method="POST">
            <input type="text" name="prenom" class="form-control lp-input" placeholder="Votre Prénom" required>
            <input type="email" name="email" class="form-control lp-input" placeholder="Votre Adresse Email Professionnelle" required>
            <input type="hidden" name="produit" value="Guide GMB 47€">
            <button type="submit" class="lp-btn">Recevoir mon guide immédiat →</button>
        </form>
    </div>

    <footer>
        ÉCOSYSTÈME IMMO &copy; <?= date('Y') ?> — SYSTÈME DIGITAL IMMOBILIER
    </footer>
</div>

</body>
</html>
