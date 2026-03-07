<?php
require_once "modele/database.class.php";

/*****************************************************************
Classe chargée de la gestion des achats (table acheter) dans la base de données lockout
*****************************************************************/
class Reservation extends Database {

  /*******************************************************
  Retourne la liste des achats (réservations)
  Tables : acheter, version, escape_game
  *******************************************************/
  public function getReservations() {
    $req = 'SELECT a.id_client AS "id_client", a.id_version AS "id_version", a.date AS "Date", a.heure AS "Heure", a.nb_participant AS "Nombre de participants", a.reserver AS "reserver", e.nom AS "Escape", e.id_escape AS "id_escape" ' .
           'FROM acheter a ' .
           'INNER JOIN version v ON a.id_version = v.id_version ' .
           'INNER JOIN escape_game e ON v.id_escape = e.id_escape ' .
           'ORDER BY a.date, a.heure;';
    $reservations = $this->execReq($req);
    return $reservations;
  }

  /*******************************************************
  Retourne la liste des escapes d'un achat (id_client, id_version, date, heure)
  *******************************************************/
  public function getEscapesReservation($id_client, $id_version, $date, $heure) {
    $req = 'SELECT e.id_escape AS "Escape", e.nom AS "Nom", e.description AS "Description", e.longitude AS "Longitude", e.latitude AS "Latitude", e.nb_participants_max AS "Nombre de participants maximum", e.age_minimum AS "Age minimum", e.ville AS "Ville", e.tags AS "Tags", e.difficultés AS "Difficultés" ' .
           'FROM escape_game e ' .
           'INNER JOIN version v ON v.id_escape = e.id_escape ' .
           'INNER JOIN acheter a ON a.id_version = v.id_version ' .
           'WHERE a.id_client=? AND a.id_version=? AND a.date=? AND a.heure=?;';
    $escapes = $this->execReqPrep($req, array($id_client, $id_version, $date, $heure));
    return $escapes;
  }

  /*******************************************************
  Retourne les "articles" (version + escape) d'un achat
  *******************************************************/
  public function getArticlesReservation($id_client, $id_version, $date, $heure) {
    $req = 'SELECT e.id_escape, e.nom, e.description, v.id_version, v.durée, v.prix, a.nb_participant ' .
           'FROM acheter a ' .
           'INNER JOIN version v ON a.id_version = v.id_version ' .
           'INNER JOIN escape_game e ON v.id_escape = e.id_escape ' .
           'WHERE a.id_client=? AND a.id_version=? AND a.date=? AND a.heure=?;';
    $resultat = $this->execReqPrep($req, array($id_client, $id_version, $date, $heure));
    return $resultat;
  }

  /*******************************************************
  Retourne le montant total d'un achat (nb_participant * prix de la version)
  *******************************************************/
  public function getTotalReservation($id_client, $id_version, $date, $heure) {
    $req = 'SELECT (a.nb_participant * v.prix) AS "total" ' .
           'FROM acheter a ' .
           'INNER JOIN version v ON a.id_version = v.id_version ' .
           'WHERE a.id_client=? AND a.id_version=? AND a.date=? AND a.heure=?;';
    $resultat = $this->execReqPrep($req, array($id_client, $id_version, $date, $heure));
    return isset($resultat[0]['total']) ? $resultat[0]['total'] : 0;
  }

  /*******************************************************
  Retourne l'id_client d'un achat (clé composite)
  *******************************************************/
  public function getIdClientReservation($id_client, $id_version, $date, $heure) {
    return $id_client;
  }

  /** Alias pour compatibilité : id_reservation n'existe plus, utilise la clé composite */
  public function getIdUtilisateurReservation($id_reservation) {
    return FALSE;
  }
}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement
