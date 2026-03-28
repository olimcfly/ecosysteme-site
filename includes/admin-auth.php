<?php
/**
 * Middleware d'authentification Admin
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAdminAuth() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdminAuth() {
    if (!checkAdminAuth()) {
        header('Location: admin-login');
        exit;
    }
}

function adminLogout() {
    session_destroy();
    header('Location: admin-login');
    exit;
}