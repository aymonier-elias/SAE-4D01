<?php
require_once "modele/escape.class.php";
require_once "vue/vue.class.php";


// Classe chargée de la gestion des escapes
class CtlEscape{

    private $escape;

    public function __construct() {
        $this->escape = new Escape();
    }
    

    /*******************************************************
Affichage de la liste des escapes dans la vue concernée
  Entrée : 

  Retour : 
    
*******************************************************/
    public function escapes() {
        $escapes = $this->escape->getEscapes();
        $vue = new Vue("Escapes"); // Instancie la vue appropriée
        $vue->afficher(array("escapes" => $escapes)); 
    }


    /*******************************************************
Affichage de la page d'un escape
  Entrée : 
    id_escape [int] : id de l'escape
  Retour : 
    
*******************************************************/

    public function escape($id_escape) {
        $escape = $this->escape->getEscape($id_escape);
        $vue = new Vue("Escape"); // Instancie la vue appropriée
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
        $this->escape->addEscape($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés);
        header('Location: index.php?action=escapes');
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
        header('Location: index.php?action=escapes');
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
    header('Location: index.php?action=escapes');
    exit;
}
}
