<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'votre_utilisateur');
define('DB_PASS', 'votre_mot_de_passe');
define('DB_NAME', 'ecosystemeimmo');

// Configuration Stripe
define('STRIPE_SECRET_KEY', 'sk_test_votre_clé_secrète');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_votre_clé_publique');

// Configuration PayPal
define('PAYPAL_CLIENT_ID', 'votre_client_id');
define('PAYPAL_SECRET', 'votre_secret');

// Configuration email
define('SMTP_HOST', 'smtp.votredomaine.com');
define('SMTP_USER', 'contact@votredomaine.com');
define('SMTP_PASS', 'votre_mot_de_passe');
define('SMTP_PORT', 587);

// URL du site
define('SITE_URL', 'https://votresite.com');
?>
