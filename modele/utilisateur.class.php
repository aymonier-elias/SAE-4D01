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

}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement