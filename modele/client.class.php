<?php
require_once "modele/database.class.php";

/***************************************************************
Classe chargée de la gestion des clients dans la base de données
***************************************************************/
class Client extends Database {

  /*******************************************************
  Retourne la liste des clients 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des clients
  *******************************************************/
  public function getClients() {
      $req = 'SELECT id_client AS "N° Client", nom AS "NOM", prenom AS "Prénom", adresse AS "Adresse", ville AS "Ville", mail AS "Adresse email", age AS "Age" FROM client ORDER BY nom, prenom;';
    // $req = 'SELECT id_client AS "N° Client", nom AS "NOM", prenom AS "Prénom" FROM client ORDER BY nom, prenom;';
    $clients = $this->execReq($req);
    return $clients;
  }


  /*******************************************************
  Retourne les informations d'un client 
    Entrée : 
      idClient [int] : Identifiant du client

    Retour : 
      [array] : Tableau associatif contenant les information du client ou FALSE en cas d'erreur
  *******************************************************/
  public function getClient($idClient) {
    $req = 'SELECT * FROM client WHERE id_client=?';
    $resultat = $this->execReqPrep($req, array($idClient));

    if(isset($resultat[0]))   // Le client se trouve dans la 1ère ligne de $resultat
      return $resultat[0];
    else
      return FALSE;           // Retourne FALSE si le client n'existe pas
    
    // Ou :
    //return isset($resultat[0]) ? $resultat[0] : FALSE;    // Retourne FALSE si le client n'existe pas
  }







  /*******************************************************
  Enregistre un nouveau client
  *******************************************************/
  

  public function insertClient($nom, $prenom, $age, $adresse, $ville, $mail){
    $req ='INSERT INTO client(id_client, nom, prenom, age, adresse, ville, mail) VALUES (?, ?, ?, ?, ?, ?, ?);';
    $resultat = $this->execReqPrep($req, array(null, $nom, $prenom, $age, $adresse, $ville, $mail));

    if($resultat == 1)
      return TRUE;
    return FALSE;
  }









}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement