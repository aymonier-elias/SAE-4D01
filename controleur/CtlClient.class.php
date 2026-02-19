<?php
require_once "modele/client.class.php";
require_once "vue/vue.class.php";

class CtlClient{


    private $client;

    public function __construct() {
        $this->client = new Client();
    }





    /*******************************************************
Affichage de la liste des clients dans la vue concernée
  Entrée : 

  Retour : 
    
*******************************************************/
    public function clients() {
        $clients = $this->client->getClients();
        $vue = new Vue("Clients"); // Instancie la vue appropriée
        $vue->afficher(array("clients" => $clients)); // Affiche la liste des clients
    }

    public function ajoutClient(){
        $vue = new Vue("ajoutClient"); // Instancie la vue appropriée
        $vue->afficher(array()); 
    }




    public function enregClient($nom, $prenom, $age, $adresse, $ville, $mail){

        $message = "";

        if(empty($nom)){$message .= "<p> Veuillez indiquer un nom </p>";}
        if(empty($prenom)){$message .= "<p>Veuillez indiquer un prenom</p>";}
        if(empty($age)){$message .= '<p>Veuillez indiquer votre age</p>';}
        if(empty($adresse)){$message .= '<p>Veuillez indiquer une adresse</p>';}
        if(empty($ville)){$message .= '<p>Veuillez indiquer une ville</p>';}
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){$message .= '<p>Veuillez indiquer un mail valide</p>';}


        if(empty($message)){
            if($this->client->insertClient($nom, $prenom, $age, $adresse, $ville, $mail))
                $this->clients();
            else
                throw new Exception("Echec lors de l'enregistrement du client");

        }
        else{
            // throw new Exception($message);
            $vue = new Vue("ajoutClient"); // Instancie la vue appropriée
            $vue->afficher(array("message" => $message)); 
        }
    }
}
