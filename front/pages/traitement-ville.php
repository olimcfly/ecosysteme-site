<?php
/**
 * traitement-ville.php
 * Traite le formulaire "V&eacute;rifier ma ville"
 */

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/security-headers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/csrf.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/LeadService.php';

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
$prenom = trim(strip_tags($_POST['prenom'] ?? ''));
$email = trim(strip_tags($_POST['email'] ?? ''));
$telephone = trim(strip_tags($_POST['telephone'] ?? ''));
$ville = trim(strip_tags($_POST['ville'] ?? ''));
$reseau = trim(strip_tags($_POST['reseau'] ?? ''));
$besoin = trim(strip_tags($_POST['besoin'] ?? ''));

// ── 3. Validation ────────────────────────────────────────────
$errors = [];
if (empty($prenom)) $errors[] = 'Le pr&eacute;nom est requis.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide.';
if (empty($ville)) $errors[] = 'La ville est requise.';

if (!empty($errors)) {
 $_SESSION['form_errors'] = $errors;
 $_SESSION['form_data'] = compact('prenom', 'email', 'telephone', 'ville', 'reseau', 'besoin');
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
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nom VARCHAR(150) NOT NULL,
 email VARCHAR(200) NOT NULL,
 telephone VARCHAR(30) DEFAULT NULL,
 ville VARCHAR(150) NOT NULL,
 reseau VARCHAR(150) DEFAULT NULL,
 besoin VARCHAR(255) DEFAULT NULL,
 statut ENUM('nouveau','en_discussion','reserve','refuse') NOT NULL DEFAULT 'nouveau',
 ip VARCHAR(45) DEFAULT NULL,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Migration douce si table existante sans colonnes additionnelles
try { $pdo->exec("ALTER TABLE demandes_villes ADD COLUMN reseau VARCHAR(150) DEFAULT NULL"); } catch (Throwable $e) {}
try { $pdo->exec("ALTER TABLE demandes_villes ADD COLUMN besoin VARCHAR(255) DEFAULT NULL"); } catch (Throwable $e) {}

// ── 6. Insertion ─────────────────────────────────────────────
try {
 $stmt = $pdo->prepare("
 INSERT INTO demandes_villes (nom, email, telephone, ville, reseau, besoin, ip)
 VALUES (:nom, :email, :telephone, :ville, :reseau, :besoin, :ip)
 ");
 $stmt->execute([
 ':nom' => $prenom,
 ':email' => $email,
 ':telephone' => $telephone !== '' ? $telephone : null,
 ':ville' => $ville,
 ':reseau' => $reseau !== '' ? $reseau : null,
 ':besoin' => $besoin !== '' ? $besoin : null,
 ':ip' => $_SERVER['REMOTE_ADDR'] ?? null,
 ]);
 $insertId = $pdo->lastInsertId();
} catch (PDOException $e) {
 error_log('[traitement-ville] Insert error: ' . $e->getMessage());
 header('Location: /verifier-ma-ville?status=error');
 exit;
}

// ── 6b. Synchronisation CRM central (leads) ─────────────────────
try {
 $leadService = new LeadService($pdo);
 $leadService->createLead([
 'firstname' => $prenom,
 'lastname' => null,
 'email' => $email,
 'phone' => $telephone,
 'city' => $ville,
 'type' => 'diagnostic',
 'source' => 'verifier-ville',
 'resource' => 'zone-check',
 'message' => trim("Réseau: {$reseau}\nBesoin: {$besoin}"),
 'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
 'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
 'referrer' => $_SERVER['HTTP_REFERER'] ?? null,
 ], false);
} catch (Throwable $e) {
 error_log('[traitement-ville] lead sync error: ' . $e->getMessage());
}

// ── 7. Email admin ───────────────────────────────────────────
$adminEmail = defined('ADMIN_EMAIL') ? ADMIN_EMAIL : 'contact@ecosystemeimmo.fr';
$sujetAdmin = '[Nouvelle demande] ' . h($ville) . ' - ' . h($prenom);
$corpsAdmin = "Nouvelle demande de verification de ville.\n\n"
 . "Prenom : {$prenom}\n"
 . "Email : {$email}\n"
 . "Telephone : " . ($telephone !== '' ? $telephone : 'Non renseigne') . "\n"
 . "Ville : {$ville}\n"
 . "Reseau : " . ($reseau !== '' ? $reseau : 'Non renseigne') . "\n"
 . "Besoin : " . ($besoin !== '' ? $besoin : 'Non renseigne') . "\n"
 . "ID : #{$insertId}\n"
 . "Date : " . date('d/m/Y H:i') . "\n\n"
 . "Acces admin : https://ecosystemeimmo.fr/admin";

$headersAdmin = "From: noreply@ecosystemeimmo.fr\r\n"
 . "Reply-To: {$email}\r\n"
 . "Content-Type: text/plain; charset=utf-8\r\n";

@mail($adminEmail, $sujetAdmin, $corpsAdmin, $headersAdmin);

// ── 8. Email confirmation prospect ───────────────────────────
$sujetPro = 'Votre demande a bien ete recue - Ecosysteme Immo Local+ Local+';
$corpsPro = "Bonjour {$prenom},\n\n"
 . "Nous avons bien recu votre demande pour la ville de {$ville}.\n\n"
 . "Voici la suite :\n"
 . "1. Nous qualifions votre demande et la disponibilite de votre zone\n"
 . "2. Vous reservez un appel decouverte pour cadrer votre plan local\n"
 . "3. Nous validons la meilleure option de demarrage\n\n"
 . "Sans engagement de votre part.\n\n"
 . "Questions ? Repondez a cet email ou appelez le 07 85 61 17 00\n\n"
 . "---\n"
 . "ECOSYSTEME IMMO LOCAL+\n"
 . "https://ecosystemeimmo.fr";

$headersPro = "From: Ecosysteme Immo Local+ Local+ <noreply@ecosystemeimmo.fr>\r\n"
 . "Reply-To: contact@ecosystemeimmo.fr\r\n"
 . "Content-Type: text/plain; charset=utf-8\r\n";

@mail($email, $sujetPro, $corpsPro, $headersPro);

// ── 9. Redirection vers URL propre ───────────────────────────
$_SESSION['demande_ville'] = [
 'prenom' => $prenom,
 'ville' => $ville,
 'email' => $email,
];

header('Location: /merci-ville');
exit;
