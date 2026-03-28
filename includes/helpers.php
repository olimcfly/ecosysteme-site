<?php
/**
 * helpers.php — Fonctions utilitaires globales
 */

/**
 * Échappe une chaîne pour un affichage HTML sécurisé.
 */
function h(?string $string): string
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
