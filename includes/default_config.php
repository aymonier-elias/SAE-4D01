<?php

require_once "config/config.class.php";


$conf = new stdClass(); // Objet vide 

$conf->DBHost = Config::$DB_host ?? "localhost";
$conf->DBName = Config::$DB_name ?? "mydatabse";
$conf->DBUser = Config::$DB_user ?? "root";
$conf->DBPwd = Config::$DB_pwd ?? "";


$conf->titreOnglet = Config::TITREONGLET;
$conf->nomSite = Config::NOMSITE;


//Menu par défaut de la page
$conf->menu = "
        <div class = 'menu'>
                <a href='index.php?action=escapes'>Les missions</a>
                <a href='index.php?action=concept'>Le concept</a>
                <a href='index.php?action=contact'>Contact</a>
                <button class='btn_langue'><img src='img/svg/fr.svg' aria-expended='false'></button>
            <div class = 'important'>
                <a href='index.php?action=connexion'>Se connecter</a>
            </div>
        </div>
    ";



//Menu connecté avec un compte utilisateur normal
$conf->menu_connecte = "
    <div class = 'menu'>
        <a href='index.php?action=escapes'>Les missions</a>
        <a href='index.php?action=concept'>Le concept</a>
        <a href='index.php?action=contact'>Contact</a>

        <div class = 'important'>
            <a href='index.php?action=panier'>Icone Panier</a>
            <a href='index.php?action=favoris'>Icone Coeur</a>
            <a href='index.php?action=profil'>Icone Profil</a>
            <a href='index.php?action=deconnexion'>Se déconnecter</a>
        </div>
    </div>
    ";

//Menu admin connecté 
$conf->menu_admin ="
        <div class = 'menu'>
            <a href='index.php?action=escapes'>Les missions</a>
            <a href='index.php?action=concept'>Le concept</a>
            <a href='index.php?action=contact'>Contact</a>
            <div class = 'admin-links'>
                <a href='index.php?action=gestion_utilisateurs'>Gestion Utilisateurs</a>
                <a href='index.php?action=gestion_commandes'>Gestion Commandes</a>
                <a href='index.php?action=gestion_escapegame'>Gestion EscapeGame</a>
            </div>

            <div class = 'important'>
                <a href='index.php?action=panier'>Icone Panier</a>
                <a href='index.php?action=favoris'>Icone Coeur</a>
                <a href='index.php?action=profil'>Icone Profil</a>
                <a href='index.php?action=deconnexion'>Se déconnecter</a>
            </div>
        </div>";