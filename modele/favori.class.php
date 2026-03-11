<?php
require_once "modele/database.class.php";

/****************************************************************
Classe chargée de la gestion des favoris (table mettre_favoris_version).
Un escape est "en favori" si au moins une de ses versions est en favori.
****************************************************************/
class Favori extends Database {

  /*******************************************************
  Retourne la liste des escapes en favoris pour un client
  (via les versions en favoris dans mettre_favoris_version)
  *******************************************************/
  public function getEscapesFavoris($id_client) {
    $req = 'SELECT DISTINCT e.id_escape AS "Code", e.nom AS "Nom", e.description AS "Description", e.longitude AS "Longitude", e.latitude AS "Latitude", '
         . 'e.nb_participants_max AS "Nombre de participants maximum", e.age_minimum AS "Age minimum", e.ville AS "Ville", e.tags AS "Tags", e.difficultés AS "Difficultés" '
         . 'FROM escape_game e '
         . 'INNER JOIN version v ON e.id_escape = v.id_escape '
         . 'INNER JOIN mettre_favoris_version f ON v.id_version = f.id_version '
         . 'WHERE f.id_client = ? ORDER BY e.nom;';
    $resultat = $this->execReqPrep($req, array($id_client));
    return is_array($resultat) ? $resultat : array();
  }

  /*******************************************************
  Retourne un id_version pour cet escape (existant ou créé par défaut).
  Si l'escape n'a aucune version en BDD, on en crée une pour que les favoris fonctionnent.
  *******************************************************/
  private function getOrCreateVersionId($id_escape) {
    $req = 'SELECT id_version FROM version WHERE id_escape = ? LIMIT 1;';
    $resultat = $this->execReqPrep($req, array($id_escape));
    if (is_array($resultat) && isset($resultat[0]['id_version'])) {
      return (int) $resultat[0]['id_version'];
    }
    $reqInsert = 'INSERT INTO version (durée, prix, id_escape) VALUES (\'1h\', 0, ?);';
    $this->execReqPrep($reqInsert, array($id_escape));
    return (int) $this->lastInsertId();
  }

  /*******************************************************
  Ajoute un escape aux favoris : on ajoute une version de cet escape
  (existante ou créée par défaut) dans mettre_favoris_version.
  *******************************************************/
  public function ajouter($id_client, $id_escape) {
    if ($this->estFavori($id_client, $id_escape)) {
      return true;
    }
    $id_version = $this->getOrCreateVersionId($id_escape);
    if (!$id_version) {
      return false;
    }
    $req = 'INSERT IGNORE INTO mettre_favoris_version (id_client, id_version) VALUES (?, ?);';
    $this->execReqPrep($req, array($id_client, $id_version));
    return true;
  }

  /*******************************************************
  Retire un escape des favoris : on retire toutes les versions
  de cet escape du client.
  *******************************************************/
  public function retirer($id_client, $id_escape) {
    $req = 'DELETE f FROM mettre_favoris_version f '
         . 'INNER JOIN version v ON f.id_version = v.id_version '
         . 'WHERE f.id_client = ? AND v.id_escape = ?;';
    $this->execReqPrep($req, array($id_client, $id_escape));
    return true;
  }

  /*******************************************************
  Indique si un escape est en favori (au moins une version)
  *******************************************************/
  public function estFavori($id_client, $id_escape) {
    $req = 'SELECT 1 FROM mettre_favoris_version f '
         . 'INNER JOIN version v ON f.id_version = v.id_version '
         . 'WHERE f.id_client = ? AND v.id_escape = ? LIMIT 1;';
    $resultat = $this->execReqPrep($req, array($id_client, $id_escape));
    return !empty($resultat) && is_array($resultat);
  }

  /*******************************************************
  Retourne les id_escape en favoris pour un client
  *******************************************************/
  public function getIdsFavoris($id_client) {
    $req = 'SELECT DISTINCT v.id_escape FROM mettre_favoris_version f '
         . 'INNER JOIN version v ON f.id_version = v.id_version WHERE f.id_client = ?;';
    $resultat = $this->execReqPrep($req, array($id_client));
    if (!is_array($resultat)) {
      return array();
    }
    $ids = array();
    foreach ($resultat as $row) {
      $ids[] = (int) $row['id_escape'];
    }
    return $ids;
  }
}
