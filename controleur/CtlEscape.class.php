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

}
