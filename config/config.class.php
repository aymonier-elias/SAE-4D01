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

    //Menu par défaut 
    public $menu = "
        <a class='lien' href='index.php'>Accueil</a>
        <a class='lien' href='index.php?action=escapes'>Les missions</a>
        <a class='lien' href='index.php?action=concept'>Le concept</a>
        <a class='lien' href='index.php?action=contact'>Contact</a>
        <a class='lien' href='index.php?action=panier'>Icone Panier</a>
        <a class='lien' href='index.php?action=favoris'>Icone Coeur</a>
    ";
}
