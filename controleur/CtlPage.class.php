<?php
/**
 * Contrôleur des pages statiques : accueil, concept, contact, erreur.
 */

require_once "vue/vue.class.php";
require_once "modele/escape.class.php";


class CtlPage {


    /**
     * Page d'accueil : affiche les 3 derniers escapes avec durée.
     */
    public function accueil() {
        $modeleEscape = new Escape();
        $derniers = $modeleEscape->getDerniersEscapes(3);
        $derniers_escapes = array();

        foreach ($derniers as $e) {
            $code = ($e['Code'] ?? $e['code'] ?? 0);
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
                'difficultes' => ($e['Difficultés'] ?? $e['difficultés'] ?? 0),
                'photo' => Escape::getCheminPhotoCouverture($code),
                'duree_affichage' => $duree_affichage
            );
        }

        $vue = new Vue("Accueil");
        $vue->afficher(array('derniers_escapes' => $derniers_escapes));
    }


    /**
     * Page "Le concept".
     */
    public function concept() {
        $vue = new Vue("Concept");
        $vue->afficher(array());
    }


    /**
     * Page "Contact".
     */
    public function contact() {
        $vue = new Vue("Contact");
        $vue->afficher(array());
    }


    /**
     * Page d'erreur (message personnalisé).
     */
    public function erreur($message) {
        $vue = new Vue("Erreur");
        $vue->afficher(array("message" => $message));
    }
}
