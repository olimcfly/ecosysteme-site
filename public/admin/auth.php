<?php
declare(strict_types=1);

require_once __DIR__ . '/../../lib/crm.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth
{
    public static function login(string $email, string $password): bool
    {
        $adminEmail = $_ENV['ADMIN_EMAIL'] ?? getenv('ADMIN_EMAIL') ?: 'admin@ecosystemeimmo.com';
        $adminHash = $_ENV['ADMIN_PASSWORD'] ?? getenv('ADMIN_PASSWORD') ?: '';

        if ($email !== $adminEmail || $adminHash === '') {
            return false;
        }

        return password_verify($password, $adminHash);
    }

    public static function check(): bool
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public static function logout(): void
    {
        session_unset();
        session_destroy();
    }
}

// Traitement du login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailInput = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = is_string($emailInput) ? $emailInput : '';
    $password = $_POST['password'] ?? '';

    if (Auth::login($email, (string) $password)) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        header('Location: /admin/');
        exit;
    }

    $error = 'Email ou mot de passe incorrect';
}
