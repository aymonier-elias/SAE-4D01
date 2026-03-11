<?php

require_once "modele/reservation.class.php";
require_once "modele/utilisateur.class.php";
require_once "vue/vue.class.php";

class CtlReservation {

    private $reservation;
    private $utilisateur;

    public function __construct() {
        $this->reservation = new Reservation();
        $this->utilisateur = new Utilisateur();
    }


    /*******************************************************
Affichage de la liste des Reservations dans la vue concernée
  Entrée : 

  Retour : 
    
*******************************************************/
    public function reservations($contexte = 'reservations') {
        $reservations = $this->reservation->getReservations();
        $vue = new Vue("Reservations");
        $vue->afficher(array("reservations" => $reservations, "contexte" => $contexte));
    }

    /*******************************************************
Affichage des détails d'une Reservation et du client dans la vue concernée
  Entrée :
    idComm [int] : n° de la Reservation

  Retour : 
    
*******************************************************/
    public function reservation($id_client, $id_version, $date, $heure) {
        $articles = $this->reservation->getArticlesReservation($id_client, $id_version, $date, $heure);
        if (!empty($articles)) {
            $id_client_res = $this->reservation->getIdClientReservation($id_client, $id_version, $date, $heure);
            $client = $this->utilisateur->getUtilisateur($id_client_res);
            $total = $this->reservation->getTotalReservation($id_client, $id_version, $date, $heure);
            $vue = new Vue("Reservation");
            $vue->afficher(array(
                "articles" => $articles,
                "id_Res" => $id_client . '-' . $id_version . '-' . $date . '-' . $heure,
                "idComm" => $id_client . '-' . $id_version . '-' . $date . '-' . $heure,
                "total" => $total,
                "client" => $client,
                "utilisateur" => $client
            ));
        } else {
            throw new Exception("Echec de l'affichage de la réservation.");
        }
    }
}
