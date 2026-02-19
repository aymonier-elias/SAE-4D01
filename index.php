<?php

require "controleur/Routeur.class.php";
require "includes/default_config.php";


$routeur = new Routeur();
$routeur->routerRequete(); 
