<?php
require_once "modele/database.class.php";

/**
 * Modèle utilisateur : table client (connexion, inscription, profil, liste pour admin).
 * Gère les requêtes CRUD sur les comptes utilisateurs.
 */
class Utilisateur extends Database {

  /*******************************************************
  Retourne la liste des utilisateurs 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des utilisateurs
  *******************************************************/
  public function getUtilisateurs() {
    $req = 'SELECT id_client AS "N° Utilisateur", nom AS "NOM", prénom AS "Prénom", adresse AS "Adresse", ville AS "Ville", mail AS "Adresse email" FROM client ORDER BY nom, prénom;';
    $utilisateurs = $this->execReq($req);
    return $utilisateurs;
  }


  /*******************************************************
  Retourne les informations d'un utilisateur 
    Entrée : 
      idUtilisateur [int] : Identifiant du utilisateur

    Retour : 
      [array] : Tableau associatif contenant les information du utilisateur ou FALSE en cas d'erreur
  *******************************************************/
  public function getUtilisateur($idUtilisateur) {
    $req = 'SELECT id_client AS id_utilisateur, nom, prénom AS prenom, mail, mdp, statut, adresse, code_postal, ville, téléphone AS telephone FROM client WHERE id_client=?';
    $resultat = $this->execReqPrep($req, array($idUtilisateur));

    if(isset($resultat[0]))
      return $resultat[0];
    else
      return FALSE;
  }







  /*******************************************************
  Enregistre un nouveau utilisateur
  *******************************************************/
  

  public function insertUtilisateur($nom, $prenom, $adresse, $code_postal, $ville, $mail, $telephone = 0){
    $req = 'INSERT INTO client(nom, prénom, adresse, code_postal, ville, mail, mdp, statut, téléphone) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?);';
    $resultat = $this->execReqPrep($req, array($nom, $prenom, $adresse, $code_postal, $ville, $mail, '', $telephone));

    if($resultat == 1)
      return TRUE;
    return FALSE;
  }

  /*******************************************************
  Retourne un utilisateur par son email (connexion / inscription)
  *******************************************************/
  public function getUtilisateurByEmail($email) {
    $req = 'SELECT id_client AS id_utilisateur, nom, prénom AS prenom, mail, mdp, statut, adresse, code_postal, ville, téléphone AS telephone FROM client WHERE mail=?';
    $resultat = $this->execReqPrep($req, array($email));
    if (is_array($resultat) && isset($resultat[0]))
      return $resultat[0];
    return array();
  }

  /*******************************************************
  Inscription : enregistre un nouvel utilisateur (avec mdp hashé, statut 1)
  *******************************************************/
  public function inscrire($prenom, $nom, $email, $mdphash, $adresse = '', $code_postal = 0, $ville = '', $telephone = 0) {
    $req = 'INSERT INTO client(nom, prénom, mail, mdp, statut, adresse, code_postal, ville, téléphone) VALUES (?, ?, ?, ?, 1, ?, ?, ?, ?)';
    $resultat = $this->execReqPrep($req, array($nom, $prenom, $email, $mdphash, $adresse, $code_postal, $ville, $telephone));
    return $resultat === 1 || $resultat === true;
  }

  /*******************************************************
  Modifier le profil (mdp optionnel, hashé si fourni)
  *******************************************************/
  public function modifierProfil($id_utilisateur, $prenom, $nom, $email, $mdp_hash = null) {
    if ($mdp_hash !== null) {
      $req = 'UPDATE client SET prénom=?, nom=?, mail=?, mdp=? WHERE id_client=?';
      return $this->execReqPrep($req, array($prenom, $nom, $email, $mdp_hash, $id_utilisateur));
    }
    $req = 'UPDATE client SET prénom=?, nom=?, mail=? WHERE id_client=?';
    return $this->execReqPrep($req, array($prenom, $nom, $email, $id_utilisateur));
  }

  /*******************************************************
  Supprimer le compte utilisateur
  *******************************************************/
  public function supprimerCompte($id_utilisateur) {
    $req = 'DELETE FROM client WHERE id_client=?';
    return $this->execReqPrep($req, array($id_utilisateur));
  }

  /*******************************************************
  Mise à jour de la photo de profil
  *******************************************************/
  public function updatePhotoProfil($id_utilisateur) {
    // Table client sans champ photo_profil : aucune mise à jour en BDD
    return true;
  }

  /*******************************************************
  Suppression complète d'un utilisateur (admin)
  *******************************************************/
  public function supprimerUtilisateurComplet($id_utilisateur) {
    $req = 'DELETE FROM client WHERE id_client=?';
    return $this->execReqPrep($req, array($id_utilisateur));
  }

}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement