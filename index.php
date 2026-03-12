<?php
/**
 * Point d'entrée unique de l'application.
 * Démarre la session, charge la configuration et délègue au routeur le traitement de la requête (?action=...).
 */
require "includes/default_config.php";
require "controleur/Routeur.class.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$routeur = new Routeur();
$routeur->routerRequete(); 
