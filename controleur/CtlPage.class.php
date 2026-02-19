<?php

require_once "vue/vue.class.php";

class CtlPage {


    /*******************************************************
Affichage de la page d'accueil du site
  Entrée : 

  Retour : 
    
*******************************************************/

    public function accueil() {
        $vue = new Vue("Accueil"); // Instancie la vue appropriée
        $vue->afficher(array());
    }




    /*******************************************************
Affichage d'une page d'erreur
  Entrée : 
    message [string] : message d'erreur

  Retour : 
    
*******************************************************/
    public function erreur($message) {
        $vue = new Vue("Erreur"); // Instancie la vue appropriée
        $vue->afficher(array("message" => $message)); 
    }   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement




}
