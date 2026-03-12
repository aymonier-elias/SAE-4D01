<?php
/**
 * Charge une vue (fichier vue/vueXXX.php) et l'affiche dans le gabarit.
 * Le nom de la vue est passé au constructeur (ex. "Escape" -> vue/vueEscape.php).
 */

class Vue {

    private $fichierVue;


    /**
     * @param string $action Nom de la vue (sans "vue" ni .php) ex. "Escape", "Reservations"
     */
    public function __construct($action) {
        $this->fichierVue = "vue/vue" . $action . ".php";
    }


    /**
     * Affiche la vue avec les données passées dans $data (extract), dans le gabarit.
     */
    public function afficher($data) {
        global $conf;

        $title = $conf->titreOnglet;
        $header = $conf->nomSite;

        if (isset($_SESSION['acces'])) {
            $menu = (isset($_SESSION['statut']) && $_SESSION['statut'] == 2) ? $conf->menu_admin : $conf->menu_connecte;
        } else {
            $menu = $conf->menu;
        }

        extract($data);

        ob_start();
        require $this->fichierVue;
        $contenu = ob_get_clean();

        $footer = $conf->footer;

        require "gabarit.php";
    }
}
