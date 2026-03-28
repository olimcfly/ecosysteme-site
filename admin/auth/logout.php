<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Déconnexion Admin
 */

session_start();
session_destroy();
header('Location: //admin/login');
exit;
?>