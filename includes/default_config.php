<?php

require_once "config/config.class.php";


$conf = new stdClass(); // Objet vide 

$conf->DBHost = Config::$DB_host ?? "localhost";
$conf->DBName = Config::$DB_name ?? "mydatabse";
$conf->DBUser = Config::$DB_user ?? "root";
$conf->DBPwd = Config::$DB_pwd ?? "";


$conf->titreOnglet = Config::TITREONGLET;
$conf->nomSite = Config::NOMSITE;

$conf->menu = "
        <a class='lien' href='index.php'>Accueil</a>
        <a class='lien' href='index.php?action=escapes'>Les missions</a>
        <a class='lien' href='index.php?action=concept'>Le concept</a>
        <a class='lien' href='index.php?action=contact'>Contact</a>
        <a class='lien' href='index.php?action=panier'>Icone Panier</a>
        <a class='lien' href='index.php?action=favoris'>Icone Coeur</a>
    ";