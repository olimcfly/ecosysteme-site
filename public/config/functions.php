<?php
// Sécurise les entrées utilisateur
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Génère un token CSRF
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Vérifie un token CSRF
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Redirige avec un message d'erreur
function redirectWithError($url, $error) {
    $_SESSION['error'] = $error;
    header("Location: $url");
    exit();
}

// Redirige avec un message de succès
function redirectWithSuccess($url, $success) {
    $_SESSION['success'] = $success;
    header("Location: $url");
    exit();
}

// Vérifie si une ville est réservée
function isVilleReserved($ville) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM territoires WHERE ville = ? AND statut = 'reserve'");
    $stmt->execute([$ville]);
    return $stmt->rowCount() > 0;
}
?>
