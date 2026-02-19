<?php

abstract class Config 
{
    //Définition des paramètres de la BDD
    public static $DB_host = "localhost";
    public static $DB_name = "Lockout";
    public static $DB_user = "root";
    public static $DB_pwd  = "";

    //Définition des paramètres du site
    public const TITREONGLET = "Lock Out";
    public const NOMSITE     = "Lock Out";
    public const PHOTOPROFILDIR = "PhotoProfil";

    //Menu par défaut 
    public $menu = "
    <div class = 'menu'>
        <div class = 'basic'>
            <a class='lien' href='index.php'>Accueil</a>
            <a class='lien' href='index.php?action=escapes'>Les missions</a>
            <a class='lien' href='index.php?action=concept'>Le concept</a>
            <a class='lien' href='index.php?action=contact'>Contact</a>
        </div>

        <div class = 'important'>
            <a class='lien' href='index.php?action=panier'>Icone Panier</a>
            <a class='lien' href='index.php?action=favoris'>Icone Coeur</a>
            <a class='lien' href='index.php?action=profil'>Icone Profil</a>
            <a href='index.php?action=deconnexion'>Se déconnecter</a>
        </div>
    </div>
    ";

    //Menu admin connecté 
    public $menu_admin ="
    <div class = 'menu'>
        <div class = 'basic'>
            <a class='lien' href='index.php'>Accueil</a>
            <a class='lien' href='index.php?action=escapes'>Les missions</a>
            <a class='lien' href='index.php?action=concept'>Le concept</a>
            <a class='lien' href='index.php?action=contact'>Contact</a>
        </div>

        <div class = 'admin-links'>
            <a class='lien' href='index.php?action=gestion_utilisateurs'>Gestion Utilisateurs</a>
            <a class='lien' href='index.php?action=gestion_commandes'>Gestion Commandes</a>
            <a class='lien' href='index.php?action=gestion_escapegame'>Gestion EscapeGame</a>
        </div>

        <div class = 'important'>
            <a class='lien' href='index.php?action=panier'>Icone Panier</a>
            <a class='lien' href='index.php?action=favoris'>Icone Coeur</a>
            <a class='lien' href='index.php?action=profil'>Icone Profil</a>
            <a href='index.php?action=deconnexion'>Se déconnecter</a>
        </div>
    </div>
    ";
}
