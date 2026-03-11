<?php
require_once "modele/escape.class.php";
require_once "modele/favori.class.php";
require_once "vue/vue.class.php";


// Classe chargée de la gestion des escapes
class CtlEscape{

    private $escape;
    private $favori;

    public function __construct() {
        $this->escape = new Escape();
        $this->favori = new Favori();
    }
    

    /*******************************************************
    Affichage de la liste des escapes
    *******************************************************/
    public function escapes() {
        $escapes = $this->escape->getEscapes();
        $ids_favoris = array();
        if (isset($_SESSION['id_utilisateur'])) {
            $ids_favoris = $this->favori->getIdsFavoris((int) $_SESSION['id_utilisateur']);
        }
        $vue = new Vue("Escapes");
        $vue->afficher(array("escapes" => $escapes, "ids_favoris" => $ids_favoris));
    }


    /*******************************************************
    Affichage de la page d'un escape
    *******************************************************/
    public function escape($id_escape) {
        $id_escape = (int) $id_escape;
        $escape = $this->escape->getEscape($id_escape);
        $versions = $this->escape->getVersions($id_escape);
        $est_favori = false;
        if (isset($_SESSION['id_utilisateur']) && !empty($escape)) {
            $est_favori = $this->favori->estFavori((int) $_SESSION['id_utilisateur'], $id_escape);
        }
        $vue = new Vue("Escape");
        $vue->afficher(array("escape" => $escape ?: array(), "versions" => $versions, "est_favori" => $est_favori, "id_escape" => $id_escape));
    }

    /*******************************************************
    Affichage de la page de gestion des escapes (admin)
    *******************************************************/
    public function gestionEscapes() {
        $escapes = $this->escape->getEscapes();
        $vue = new Vue("GestionEscapes");
        $vue->afficher(array("escapes" => $escapes));
    }

    /*******************************************************
    Affiche le formulaire d'ajout d'un escape
    *******************************************************/
    public function formulaireAjoutEscape() {
        $vue = new Vue("FormulaireAjoutEscape");
        $vue->afficher(array());
    }

    /*******************************************************
    Affiche le formulaire de modification d'un escape
    *******************************************************/
    public function formulaireModifierEscape($id_escape) {
        $escape = $this->escape->getEscape($id_escape);
        $vue = new Vue("FormulaireModifierEscape");
        $vue->afficher(array("escape" => $escape));
    }

    /*******************************************************
Ajout d'un escape
  Entrée : 
    nom [string] : nom de l'escape
    description [string] : description de l'escape
    longitude [float] : longitude de l'escape
    latitude [float] : latitude de l'escape
    nb_participants_max [int] : nombre de participants maximum
    age_minimum [int] : age minimum
    ville [string] : ville de l'escape
    tags [string] : tags de l'escape
    difficultés [string] : difficultés de l'escape
  Retour : 
*******************************************************/

    public function ajouterEscape($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés) {
        $id_escape = $this->escape->addEscape($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés);
        if (isset($_FILES['photoCouverture']) && $_FILES['photoCouverture']['error'] === UPLOAD_ERR_OK) {
            try {
                $this->escape->updatePhotoCouverture($id_escape);
            } catch (Exception $e) {
                $_SESSION['flash_escape_err'] = $e->getMessage();
            }
        }
        header('Location: index.php?action=gestion_escapegame');
        exit;
    }

    /*******************************************************    
    Modification d'un escape
  Entrée : 
    id_escape [int] : id de l'escape
    nom [string] : nom de l'escape
    description [string] : description de l'escape
    longitude [float] : longitude de l'escape
    latitude [float] : latitude de l'escape
    nb_participants_max [int] : nombre de participants maximum
    age_minimum [int] : age minimum
    ville [string] : ville de l'escape
    tags [string] : tags de l'escape
    difficultés [string] : difficultés de l'escape
  Retour : 
*******************************************************/

    public function modifierEscape($id_escape, $nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés) {
        $this->escape->updateEscape($id_escape, $nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés);
        if (isset($_FILES['photoCouverture']) && $_FILES['photoCouverture']['error'] === UPLOAD_ERR_OK) {
            try {
                $this->escape->updatePhotoCouverture($id_escape);
            } catch (Exception $e) {
                $_SESSION['flash_escape_err'] = $e->getMessage();
            }
        }
        header('Location: index.php?action=gestion_escapegame');
        exit;
    }

        /*******************************************************
    Suppression d'un escape
  Entrée : 
    id_escape [int] : id de l'escape
  Retour : 
*******************************************************/

    public function supprimerEscape($id_escape) {
        $this->escape->deleteEscape($id_escape);
        header('Location: index.php?action=gestion_escapegame');
        exit;
    }
}
