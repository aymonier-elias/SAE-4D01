<?php

require_once "modele/commande.class.php";
require_once "vue/vue.class.php";

class CtlCommande{

    private $commande;


    public function __construct() {
        $this->commande = new Commande();
    }


    /*******************************************************
Affichage de la liste des commandes dans la vue concernée
  Entrée : 

  Retour : 
    
*******************************************************/
    public function commandes() {
        $commandes = $this->commande->getCommandes();
        $vue = new Vue("Commandes"); // Instancie la vue appropriée
        $vue->afficher(array("commandes" => $commandes)); 
    }






    /*******************************************************
Affichage des détails d'une commande et du client dans la vue concernée
  Entrée :
    idComm [int] : n° de la commande

  Retour : 
    
*******************************************************/
    public function commande($idComm) {

        $articles = $this->commande->getArticlesCommande($idComm);
        if (!empty($articles)) {
            $objClient = new Client();
            $client = $objClient->getClient($this->commande->getIdClientCommande($idComm));
            $total = $this->commande->getTotalCommande($idComm);
            $vue = new Vue("Commande"); // Instancie la vue appropriée
            $vue->afficher(array("articles" => $articles,
                                "idComm" => $idComm,
                                "total" => $total,
                                "client" => $client
                                )); 
        }
        else
            throw new Exception("Echec de l'affichage de la commande N°$idComm");
        }
           


}
