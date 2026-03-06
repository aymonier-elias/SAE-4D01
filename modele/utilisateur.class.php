<?php
require_once "modele/database.class.php";

/****************************************************************
Classe chargée de la gestion des utilisateurs dans la base de données
****************************************************************/

class Utilisateur extends Database {

  /*******************************************************
  Retourne la liste des utilisateurs 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des utilisateurs
  *******************************************************/
  public function getUtilisateurs() {
      $req = 'SELECT id_utilisateur AS "N° Utilisateur", nom AS "NOM", prenom AS "Prénom", adresse AS "Adresse", ville AS "Ville", mail AS "Adresse email", age AS "Age" FROM utilisateur ORDER BY nom, prenom;';
    // $req = 'SELECT id_utilisateur AS "N° Utilisateur", nom AS "NOM", prenom AS "Prénom" FROM utilisateur ORDER BY nom, prenom;';
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
    $req = 'SELECT * FROM utilisateur WHERE id_utilisateur=?';
    $resultat = $this->execReqPrep($req, array($idUtilisateur));

    if(isset($resultat[0]))   // Le utilisateur se trouve dans la 1ère ligne de $resultat
      return $resultat[0];
    else
      return FALSE;           // Retourne FALSE si le utilisateur n'existe pas
    
    // Ou :
    //return isset($resultat[0]) ? $resultat[0] : FALSE;    // Retourne FALSE si le utilisateur n'existe pas
  }







  /*******************************************************
  Enregistre un nouveau utilisateur
  *******************************************************/
  

  public function insertUtilisateur($nom, $prenom, $age, $adresse, $ville, $mail){
    $req ='INSERT INTO utilisateur(id_utilisateur, nom, prenom, age, adresse, ville, mail) VALUES (?, ?, ?, ?, ?, ?, ?);';
    $resultat = $this->execReqPrep($req, array(null, $nom, $prenom, $age, $adresse, $ville, $mail));

    if($resultat == 1)
      return TRUE;
    return FALSE;
  }

  /*******************************************************
  Retourne un utilisateur par son email (connexion / inscription)
  *******************************************************/
  public function getUtilisateurByEmail($email) {
    $req = 'SELECT * FROM utilisateur WHERE mail=?';
    $resultat = $this->execReqPrep($req, array($email));
    if (is_array($resultat) && isset($resultat[0]))
      return $resultat[0];
    return array();
  }

  /*******************************************************
  Inscription : enregistre un nouvel utilisateur (avec mdp hashé, statut 1)
  *******************************************************/
  public function inscrire($prenom, $nom, $email, $mdphash) {
    $req = 'INSERT INTO utilisateur(nom, prenom, mail, mdp, statut) VALUES (?, ?, ?, ?, 1)';
    $resultat = $this->execReqPrep($req, array($nom, $prenom, $email, $mdphash));
    return $resultat === 1 || $resultat === true;
  }

  /*******************************************************
  Modifier le profil (mdp optionnel, hashé si fourni)
  *******************************************************/
  public function modifierProfil($id_utilisateur, $prenom, $nom, $email, $mdp_hash = null) {
    if ($mdp_hash !== null) {
      $req = 'UPDATE utilisateur SET prenom=?, nom=?, mail=?, mdp=? WHERE id_utilisateur=?';
      return $this->execReqPrep($req, array($prenom, $nom, $email, $mdp_hash, $id_utilisateur));
    }
    $req = 'UPDATE utilisateur SET prenom=?, nom=?, mail=? WHERE id_utilisateur=?';
    return $this->execReqPrep($req, array($prenom, $nom, $email, $id_utilisateur));
  }

  /*******************************************************
  Supprimer le compte utilisateur
  *******************************************************/
  public function supprimerCompte($id_utilisateur) {
    $req = 'DELETE FROM utilisateur WHERE id_utilisateur=?';
    return $this->execReqPrep($req, array($id_utilisateur));
  }

  /*******************************************************
  Mise à jour de la photo de profil
  *******************************************************/
  public function updatePhotoProfil($id_utilisateur) {
    // À adapter selon le champ et l'upload (ex: nom fichier en BDD)
    $req = 'UPDATE utilisateur SET photo_profil=? WHERE id_utilisateur=?';
    return $this->execReqPrep($req, array($_FILES['photo_profil']['name'] ?? '', $id_utilisateur));
  }

  /*******************************************************
  Suppression complète d'un utilisateur (admin)
  *******************************************************/
  public function supprimerUtilisateurComplet($id_utilisateur) {
    $req = 'DELETE FROM utilisateur WHERE id_utilisateur=?';
    return $this->execReqPrep($req, array($id_utilisateur));
  }

}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement