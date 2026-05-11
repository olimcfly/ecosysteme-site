<?php
/**
 * Script de traitement des captures de prospects
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = strip_tags($_POST['prenom'] ?? 'Inconnu');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $produit = strip_tags($_POST['produit'] ?? 'Inconnu');

    if ($email) {
        // 1. Enregistrement dans prospects.json
        $file = __DIR__ . '/data/prospects.json';
        $prospects = [];
        if (file_exists($file)) {
            $prospects = json_decode(file_get_contents($file), true) ?: [];
        }

        $new_prospect = [
            'id' => uniqid(),
            'nom' => $prenom,
            'email' => $email,
            'source' => "Landing Page: $produit",
            'date' => date('Y-m-d H:i:s'),
            'statut' => 'Nouveau'
        ];

        $prospects[] = $new_prospect;
        file_put_contents($file, json_encode($prospects, JSON_PRETTY_PRINT));

        // 2. Notification (Optionnel mais recommandé)
        // On pourrait utiliser ton mailer SMTP ici

        // 3. Redirection vers la page de merci
        header('Location: merci-guide.php');
        exit;
    }
}

// Erreur : retour à la landing
header('Location: landing-guide.php?error=invalid');
exit;
