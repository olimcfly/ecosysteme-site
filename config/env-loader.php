<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Chargeur de variables d'environnement
 * Charge le fichier .env à la racine du projet (parsing manuel robuste)
 *
 * Usage : require_once __DIR__ . '/env-loader.php';
 */

// Éviter le double chargement
if (defined('ENV_LOADED')) {
    return;
}
define('ENV_LOADED', true);

// Chercher le .env à la racine du projet
$envPath = dirname(__DIR__) . '/.env';

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorer les commentaires
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }

        // Séparer clé=valeur (uniquement au premier =)
        $pos = strpos($line, '=');
        if ($pos === false) {
            continue;
        }

        $key = trim(substr($line, 0, $pos));
        $value = trim(substr($line, $pos + 1));

        // Retirer les guillemets entourants
        if (strlen($value) >= 2 && (($value[0] === '"' && $value[-1] === '"') || ($value[0] === "'" && $value[-1] === "'"))) {
            $value = substr($value, 1, -1);
        }

        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}
