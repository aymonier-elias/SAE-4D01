<?php

require_once "modele/Reservation.class.php";
require_once "vue/vue.class.php";

class CtlReservation{

    private $reservation;


    public function __construct() {
        $this->reservation = new Reservation();
    }


    /*******************************************************
Affichage de la liste des Reservations dans la vue concernée
  Entrée : 

  Retour : 
    
*******************************************************/
    public function reservations() {
        $Reservations = $this->reservation->getReservations();
        $vue = new Vue("Reservations"); // Instancie la vue appropriée
        $vue->afficher(array("reservations" => $reservations)); 
    }






    /*******************************************************
Affichage des détails d'une Reservation et du client dans la vue concernée
  Entrée :
    idComm [int] : n° de la Reservation

  Retour : 
    
*******************************************************/
    public function reservation($idComm) {

        $articles = $this->reservation->getArticlesReservation($idComm);
        if (!empty($articles)) {
            $objClient = new Client();
            $client = $objClient->getClient($this->reservation->getIdClientReservation($idComm));
            $total = $this->reservation->getTotalReservation($idComm);
            $vue = new Vue("Reservation"); // Instancie la vue appropriée
            $vue->afficher(array("escape" => $escape,
                                "id_Res" => $id_Res,
                                "total" => $total,
                                "utilisateur" => $utilisateur
                                )); 
        }
        else
            throw new Exception("Echec de l'affichage de la reservation N°$id_Res");
        }
           


}
