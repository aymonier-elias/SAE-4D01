<?php
/**
 * Classe de configuration du site et de la base de données.
 * Contient les constantes et paramètres utilisés par l'application (BDD, titre, répertoire des photos).
 */
abstract class Config
{
    /** Hôte MySQL (serveur de base de données) */
    public static $DB_host = "localhost";
    /** Nom de la base de données */
    public static $DB_name = "lockout";
    /** Utilisateur de connexion à la BDD */
    public static $DB_user = "root";
    /** Mot de passe de connexion à la BDD */
    public static $DB_pwd = "";

    /** Titre affiché dans l'onglet du navigateur */
    public const TITREONGLET = "Lock Out";
    /** Nom du site affiché dans l'en-tête */
    public const NOMSITE = "Lock Out";
    /** Répertoire relatif où sont stockées les photos de couverture des escape games */
    public const PHOTOESCAPEDIR = "img/mission";
}
