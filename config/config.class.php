<?php

abstract class Config
{
    //Définition des paramètres de la BDD
    public static $DB_host = "localhost";
    public static $DB_name = "lockout";
    public static $DB_user = "root";
    public static $DB_pwd = "";

    //Définition des paramètres du site
    public const TITREONGLET = "Lock Out";
    public const NOMSITE = "Lock Out";
    public const PHOTOESCAPEDIR = "PhotoEscape";

}
