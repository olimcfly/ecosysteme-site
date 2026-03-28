<?php
/**
 * traitement-ville.php
 * Traite le formulaire "V&eacute;rifier ma ville"
 */

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/security-headers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/csrf.php';

// ── 1. M&eacute;thode ──────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /verifier-ma-ville');
    exit;
}

// ── 1b. CSRF ────────────────────────────────────────────────────
if (!validateCsrfToken()) {
    $_SESSION['form_errors'] = ['Token de sécurité invalide. Veuillez réessayer.'];
    header('Location: /verifier-ma-ville');
    exit;
}

// ── 2. Nettoyage ─────────────────────────────────────────────
$nom       = trim(strip_tags($_POST['nom']       ?? ''));
$email     = trim(strip_tags($_POST['email']     ?? ''));
$telephone = trim(strip_tags($_POST['telephone'] ?? ''));
$ville     = trim(strip_tags($_POST['ville']     ?? ''));

// ── 3. Validation ────────────────────────────────────────────
$errors = [];
if (empty($nom))                                                   $errors[] = 'Le nom est requis.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))   $errors[] = 'Email invalide.';
if (empty($telephone))                                             $errors[] = 'Le telephone est requis.';
if (empty($ville))                                                 $errors[] = 'La ville est requise.';

if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data']   = compact('nom', 'email', 'telephone', 'ville');
    header('Location: /verifier-ma-ville');
    exit;
}

// ── 4. Connexion DB ──────────────────────────────────────────
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    error_log('[traitement-ville] DB error: ' . $e->getMessage());
    header('Location: /verifier-ma-ville?status=error');
    exit;
}

// ── 5. Cr&eacute;ation table si absente ────────────────────────────────
$pdo->exec("
    CREATE TABLE IF NOT EXISTS demandes_villes (
        id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nom         VARCHAR(150)  NOT NULL,
        email       VARCHAR(200)  NOT NULL,
        telephone   VARCHAR(30)   NOT NULL,
        ville       VARCHAR(150)  NOT NULL,
        statut      ENUM('nouveau','en_discussion','reserve','refuse') NOT NULL DEFAULT 'nouveau',
        ip          VARCHAR(45)   DEFAULT NULL,
        created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ── 6. Insertion ─────────────────────────────────────────────
try {
    $stmt = $pdo->prepare("
        INSERT INTO demandes_villes (nom, email, telephone, ville, ip)
        VALUES (:nom, :email, :telephone, :ville, :ip)
    ");
    $stmt->execute([
        ':nom'       => $nom,
        ':email'     => $email,
        ':telephone' => $telephone,
        ':ville'     => $ville,
        ':ip'        => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
    $insertId = $pdo->lastInsertId();
} catch (PDOException $e) {
    error_log('[traitement-ville] Insert error: ' . $e->getMessage());
    header('Location: /verifier-ma-ville?status=error');
    exit;
}

// ── 7. Email admin ───────────────────────────────────────────
$adminEmail = defined('ADMIN_EMAIL') ? ADMIN_EMAIL : 'contact@ecosystemeimmo.fr';
$sujetAdmin = '[Nouvelle demande] ' . h($ville) . ' - ' . h($nom);
$corpsAdmin = "Nouvelle demande de verification de ville.\n\n"
            . "Nom       : {$nom}\n"
            . "Email     : {$email}\n"
            . "Telephone : {$telephone}\n"
            . "Ville     : {$ville}\n"
            . "ID        : #{$insertId}\n"
            . "Date      : " . date('d/m/Y H:i') . "\n\n"
            . "Acces admin : https://ecosystemeimmo.fr/admin";

$headersAdmin = "From: noreply@ecosystemeimmo.fr\r\n"
              . "Reply-To: {$email}\r\n"
              . "Content-Type: text/plain; charset=utf-8\r\n";

@mail($adminEmail, $sujetAdmin, $corpsAdmin, $headersAdmin);

// ── 8. Email confirmation prospect ───────────────────────────
$sujetPro = 'Votre demande a bien ete recue - Ecosysteme Immo';
$corpsPro  = "Bonjour {$nom},\n\n"
           . "Nous avons bien recu votre demande pour la ville de {$ville}.\n\n"
           . "Voici la suite :\n"
           . "1. Nous verifions la disponibilite de votre secteur\n"
           . "2. Nous vous contactons sous 24h pour une courte demonstration\n"
           . "3. Vous pouvez reserver votre licence territoriale\n\n"
           . "Sans engagement de votre part.\n\n"
           . "Questions ? Repondez a cet email ou appelez le 07 85 61 17 00\n\n"
           . "---\n"
           . "ECOSYSTEME IMMO LOCAL+\n"
           . "https://ecosystemeimmo.fr";

$headersPro = "From: Ecosysteme Immo <noreply@ecosystemeimmo.fr>\r\n"
            . "Reply-To: contact@ecosystemeimmo.fr\r\n"
            . "Content-Type: text/plain; charset=utf-8\r\n";

@mail($email, $sujetPro, $corpsPro, $headersPro);

// ── 9. Redirection vers URL propre ───────────────────────────
$_SESSION['demande_ville'] = [
    'nom'   => $nom,
    'ville' => $ville,
];

header('Location: /merci-ville');
exit;