<?php
require_once "modele/database.class.php";
 
/*****************************************************************
Classe chargée de la gestion des réservations dans la base de données
*****************************************************************/
class Reservation extends Database {

  /*******************************************************
  Retourne la liste des réservations 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des réservations
  *******************************************************/
  public function getReservations() {
    $req = 'SELECT id_reservation AS "N° Réservation", date AS "Date", heure AS "Heure", nb_participants AS "Nombre de participants", id_escape AS "Escape" '.
           'FROM reservation INNER JOIN escape ON reservation.id_escape = escape.id_escape '.
           'ORDER BY date, heure;';
    $reservations = $this->execReq($req);
    return $reservations;
  }

  /*******************************************************
  Retourne la liste des escapes d'une réservation 
    Entrée : 
      idReservation [int] : Identifiant de la réservation
  
    Retour : 
      [array] : Tableau associatif contenant la liste des escapes de la réservation
  *******************************************************/
  public function getEscapesReservation($idReservation) {
    $req = 'SELECT id_escape AS "Escape", nom AS "Nom", description AS "Description", longitude AS "Longitude", latitude AS "Latitude", nb_participants_max AS "Nombre de participants maximum", age_minimum AS "Age minimum", ville AS "Ville", tags AS "Tags", difficultés AS "Difficultés" '.
           'FROM escape '.
           'INNER JOIN reservation ON escape.id_escape = reservation.id_escape '.
           'WHERE reservation.id_reservation=?;';
    $escapes = $this->execReqPrep($req, array($idReservation));
    return $escapes;
  }

  /*******************************************************
        Retourne le montant total d'une réservation 
    Entrée : 
      idReservation [int] : Identifiant de la réservation
  
    Retour : 
        [string] : Montant de la réservation
  *******************************************************/
  public function getTotalReservation($idReservation) {
    $req = 'SELECT SUM(nb_participants * prix) AS "total" '.
           'FROM reservation '.
           'INNER JOIN escape ON reservation.id_escape = escape.id_escape '.
           'WHERE reservation.id_reservation=? ';
    $resultat = $this->execReqPrep($req, array($idReservation));
    return $resultat[0]["total"];
  }

  /*******************************************************
  Retourne l'id_utilisateur d'une réservation 
    Entrée : 
      idReservation [int] : Identifiant de la réservation
  
    Retour : 
      [mixed] : Identifiant du utilisateur ou FALSE si la réservation n'existe pas
      *******************************************************/
  public function getIdUtilisateurReservation($idReservation) {
    $req = 'SELECT id_utilisateur FROM reservation WHERE id_reservation=?;';
    $resultat = $this->execReqPrep($req, array($idReservation));
    return isset($resultat[0]["id_utilisateur"]) ? $resultat[0]["id_utilisateur"] : FALSE;    // Retourne FALSE si l'idUtilisateur n'existe pas
  }
}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement