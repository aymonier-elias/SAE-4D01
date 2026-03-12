<?php
require_once "modele/database.class.php";

/****************************************************************
Classe chargée des avis (notation + commentaire) sur les escape games.
Table : avis_escape (id_avis, id_escape, id_client, note, commentaire, date_avis)
****************************************************************/
class Avis extends Database {

  /*******************************************************
  Retourne tous les avis d'un escape (avec prénom du client)
  *******************************************************/
  public function getAvisByEscape($id_escape) {
    $req = 'SELECT a.id_avis, a.id_escape, a.id_client, a.note, a.commentaire, a.date_avis, c.prénom AS prenom, c.nom AS nom '
         . 'FROM avis_escape a INNER JOIN client c ON a.id_client = c.id_client '
         . 'WHERE a.id_escape = ? ORDER BY a.date_avis DESC';
    $resultat = $this->execReqPrep($req, array((int) $id_escape));
    return is_array($resultat) ? $resultat : array();
  }

  /*******************************************************
  Retourne l'avis d'un utilisateur pour un escape (s'il existe)
  *******************************************************/
  public function getAvisUtilisateur($id_escape, $id_client) {
    $req = 'SELECT id_avis, note, commentaire FROM avis_escape WHERE id_escape = ? AND id_client = ? LIMIT 1';
    $resultat = $this->execReqPrep($req, array((int) $id_escape, (int) $id_client));
    return (is_array($resultat) && isset($resultat[0])) ? $resultat[0] : null;
  }

  /*******************************************************
  Calcule la note moyenne d'un escape
  *******************************************************/
  public function getNoteMoyenne($id_escape) {
    $req = 'SELECT AVG(note) AS moyenne FROM avis_escape WHERE id_escape = ?';
    $resultat = $this->execReqPrep($req, array((int) $id_escape));
    if (is_array($resultat) && isset($resultat[0]) && $resultat[0]['moyenne'] !== null) {
      return round((float) $resultat[0]['moyenne'], 1);
    }
    return null;
  }

  /*******************************************************
  Ajoute ou met à jour l'avis d'un utilisateur pour un escape.
  Un seul avis par utilisateur par escape (note 1-5, commentaire optionnel).
  *******************************************************/
  public function enregistrerAvis($id_escape, $id_client, $note, $commentaire = '') {
    $id_escape = (int) $id_escape;
    $id_client = (int) $id_client;
    $note = max(1, min(5, (int) $note));
    $commentaire = trim($commentaire ?? '');
    $existant = $this->getAvisUtilisateur($id_escape, $id_client);
    if ($existant) {
      $req = 'UPDATE avis_escape SET note = ?, commentaire = ?, date_avis = NOW() WHERE id_escape = ? AND id_client = ?';
      $this->execReqPrep($req, array($note, $commentaire, $id_escape, $id_client));
    } else {
      $req = 'INSERT INTO avis_escape (id_escape, id_client, note, commentaire, date_avis) VALUES (?, ?, ?, ?, NOW())';
      $this->execReqPrep($req, array($id_escape, $id_client, $note, $commentaire));
    }
  }
}
