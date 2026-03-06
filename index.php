<?php

require "includes/default_config.php";
require "controleur/Routeur.class.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$routeur = new Routeur();
$routeur->routerRequete(); 
