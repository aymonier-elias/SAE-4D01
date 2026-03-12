<?php

require_once "vue/vue.class.php";
require_once "modele/escape.class.php";

class CtlPage {


    /*******************************************************
Affichage de la page d'accueil du site
  Entrée : 

  Retour : 
    
*******************************************************/

    public function accueil() {
        $modeleEscape = new Escape();
        $derniers = $modeleEscape->getDerniersEscapes(3);
        $derniers_escapes = array();
        foreach ($derniers as $e) {
            $code = (int) ($e['Code'] ?? $e['code'] ?? 0);
            $versions = $modeleEscape->getVersions($code);
            $duree_affichage = '—';
            if (!empty($versions)) {
                $v = $versions[0];
                $duree_affichage = $v['duree'] ?? $v['durée'] ?? '—';
            }
            $derniers_escapes[] = array(
                'code' => $code,
                'nom' => $e['Nom'] ?? $e['nom'] ?? '',
                'description' => $e['Description'] ?? $e['description'] ?? '',
                'difficultes' => (int) ($e['Difficultés'] ?? $e['difficultés'] ?? 0),
                'photo' => Escape::getCheminPhotoCouverture($code),
                'duree_affichage' => $duree_affichage
            );
        }
        $vue = new Vue("Accueil");
        $vue->afficher(array('derniers_escapes' => $derniers_escapes));
    }
   
    /*******************************************************
Affichage de la page de concept du site
  Entrée : 

  Retour : 
    
*******************************************************/

    public function concept() {
        $vue = new Vue("Concept"); // Instancie la vue appropriée
        $vue->afficher(array());
    }

    /*******************************************************
Affichage de la page de contact du site
  Entrée : 

  Retour : 
    
*******************************************************/

    public function contact() {
        $vue = new Vue("Contact"); // Instancie la vue appropriée
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
