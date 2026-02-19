<?php
require_once "modele/database.class.php";
 
/*****************************************************************
Classe chargée de la gestion des commandes dans la base de données
*****************************************************************/
class Commande extends Database {

  /*******************************************************
  Retourne la liste des commandes 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des commandes
  *******************************************************/
  public function getCommandes() {
    $req = 'SELECT id_comm AS "N° Commande", nom AS "Nom", prenom AS "Prénom", DATE_FORMAT(date,"%d/%m/%Y") AS "Date" '.
           'FROM commande INNER JOIN client ON commande.id_client = client.id_Client '.
           'ORDER BY nom, prenom;';
    $commandes = $this->execReq($req);
    return $commandes;
  }

  /*******************************************************
  Retourne la liste des articles d'une commande 
    Entrée : 
      idComm [int] : Identifiant de la commande
  
    Retour : 
      [array] : Tableau associatif contenant la liste des articles de la commande
  *******************************************************/
  public function getArticlesCommande($idComm) {
    $req = 'SELECT quantite AS "Quantité", designation AS "Désignation", categorie AS "Catégorie", prix AS "Prix" '.
           'FROM commande '.
           'INNER JOIN ligne ON commande.id_comm = ligne.id_comm '.
           'INNER JOIN article ON ligne.id_article = article.id_article '.
           'WHERE commande.id_comm=?;';
    $articles = $this->execReqPrep($req, array($idComm));
    return $articles;
  }

  /*******************************************************
  Retourne le montant total d'une commande 
    Entrée : 
      idComm [int] : Identifiant de la commande
  
    Retour : 
      [string] : Montant de la commande
  *******************************************************/
  public function getTotalCommande($idComm) {
    $req = 'SELECT SUM(quantite * prix) AS "total" '.
           'FROM commande '.
           'INNER JOIN ligne ON commande.id_comm = ligne.id_comm '.
           'INNER JOIN article ON ligne.id_article = article.id_article '.
           'WHERE commande.id_comm=? ';
    $resultat = $this->execReqPrep($req, array($idComm));
    return $resultat[0]["total"];
  }

  /*******************************************************
  Retourne l'id_client d'une commande 
    Entrée : 
      idComm [int] : Identifiant de la commande
  
    Retour : 
      [mixed] : Identifiant du client ou FALSE si la commande n'existe pas
  *******************************************************/
  public function getIdClientCommande($idComm) {
    $req = 'SELECT id_client FROM commande WHERE id_comm=?;';
    $resultat = $this->execReqPrep($req, array($idComm));
    return isset($resultat[0]["id_client"]) ? $resultat[0]["id_client"] : FALSE;    // Retourne FALSE si l'idComm n'existe pas
  }
}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement