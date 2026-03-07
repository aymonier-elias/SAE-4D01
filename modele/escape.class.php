<?php
require_once "modele/database.class.php";

/****************************************************************
Classe chargée de la gestion des escapes dans la base de données
****************************************************************/
class Escape extends Database {

  /*******************************************************
  Retourne la liste des escapes 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des escapes
  *******************************************************/
  public function getEscapes() {
    $req = 'SELECT id_escape AS "Code", nom AS "Nom", description AS "Description", longitude AS "Longitude", latitude AS "Latitude", nb_participants_max AS "Nombre de participants maximum", age_minimum AS "Age minimum", ville AS "Ville", tags AS "Tags", difficultés AS "Difficultés" FROM escape_game ORDER BY nom;';
    $escapes = $this->execReq($req);
    return $escapes;
  }

  /*******************************************************
      Retourne la description d'un escape
    Entrée : 
      idEscape [string] : Identifiant de l'escape
  
    Retour : 
      [array] : Tableau associatif contenant les attributs de l'escape
  *******************************************************/
  public function getEscape($idEscape) {
    $req = 'SELECT id_escape AS "Code", nom AS "Nom", description AS "Description", longitude AS "Longitude", latitude AS "Latitude", nb_participants_max AS "Nombre de participants maximum", age_minimum AS "Age minimum", ville AS "Ville", tags AS "Tags", difficultés AS "Difficultés" FROM escape_game WHERE id_escape=?;';
    $resultat = $this->execReqPrep($req, array($idEscape));
    return $resultat[0];
  }

  /*******************************************************
  Ajoute un escape dans la base de données
  *******************************************************/
  public function addEscape($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés) {
    $req = 'INSERT INTO escape_game (nom, description, longitude, latitude, nb_participants_max, age_minimum, ville, tags, difficultés) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);';
    $this->execReqPrep($req, array($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés));
  }

  /*******************************************************
  Met à jour un escape dans la base de données
  *******************************************************/
  public function updateEscape($idEscape, $nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés) {
    $req = 'UPDATE escape_game SET nom=?, description=?, longitude=?, latitude=?, nb_participants_max=?, age_minimum=?, ville=?, tags=?, difficultés=? WHERE id_escape=?;';
    $this->execReqPrep($req, array($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés, $idEscape));
  }

  /*******************************************************
  Supprime un escape dans la base de données
  *******************************************************/
  public function deleteEscape($idEscape) {
    $req = 'DELETE FROM escape_game WHERE id_escape=?;';
    $this->execReqPrep($req, array($idEscape));
  }

}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement