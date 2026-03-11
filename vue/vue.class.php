<?php


/*************************************
Classe chargée de l'affichage des vues
*************************************/
class Vue {

  private $fichierVue;    // Nom du fichier permettant de générer le contenu pour la vue en fonction de l'action demandée
                          // Exemple : "vue/vueAccueil.php", "vue/vueArticles.php", "vue/vueErreur.php", ...

  /*******************************************************
  Initialise le nom du fichier requis pour générer le contenu à afficher dans la vue correspondant à l'action
    Entrée : 
      action [string] : action demandée

    Sortie :
      $fichierVue [string] : nom du fichier requis pour générer le contenu à afficher dans la vue

    Retour :  
      
  *******************************************************/
  public function __construct($action) {
    $this->fichierVue = "vue/vue".$action.".php";
  }

  /*******************************************************
  Affiche dans le gabarit la vue correspondant à l'action demandée
    Entrée : 
      data [array] : tableau associatif contenant les données à afficher dans la vue
  
    Retour : 
      
  *******************************************************/
  public function afficher($data) {
    global $conf;

    $title = $conf->titreOnglet;
    $header = $conf->nomSite;
//    $titre = "";      // Le titre de la page est généré dans le fichierVue
    // Menu selon l'état de connexion (commun à toutes les pages)
    if (isset($_SESSION['acces'])) {
        $menu = (isset($_SESSION['statut']) && $_SESSION['statut'] == 2) ? $conf->menu_admin : $conf->menu_connecte;
    } else {
        $menu = $conf->menu;
    }

    extract($data);   // Extrait les valeurs du tableau associatif $data dans des variables

    ob_start();

    require $this->fichierVue;   // Génère le contenu de la page en fonction de l'action

    $contenu = ob_get_clean();
    
    $footer = $conf->footer;
  
    require "gabarit.php";
  }
}