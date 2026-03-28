<?php
/**
 * Headers de sécurité HTTP - ÉCOSYSTÈME IMMO LOCAL+
 * Inclure ce fichier au tout début de chaque page (avant tout output).
 */

if (!headers_sent()) {
    // Empêcher l'affichage dans un iframe (anti-clickjacking)
    header('X-Frame-Options: DENY');

    // Empêcher le sniffing MIME
    header('X-Content-Type-Options: nosniff');

    // Politique de référent
    header('Referrer-Policy: strict-origin-when-cross-origin');

    // Content Security Policy
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data:; connect-src 'self'; frame-ancestors 'none';");

    // Permissions Policy (désactiver les API non utilisées)
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');
}
