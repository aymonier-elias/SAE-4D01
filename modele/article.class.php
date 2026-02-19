<?php
require_once "modele/database.class.php";

/****************************************************************
Classe chargée de la gestion des articles dans la base de données
****************************************************************/
class Article extends Database {

  /*******************************************************
  Retourne la liste des articles 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des articles
  *******************************************************/
  public function getArticles() {
    $req = 'SELECT id_article AS "Code", designation AS "Designation", categorie AS "Catégorie", prix AS "Prix" FROM article ORDER BY categorie;';
    $articles = $this->execReq($req);
    return $articles;
  }

  /*******************************************************
  Retourne la description d'un article
    Entrée : 
      idArt [string] : Identifiant de l'article
  
    Retour : 
      [array] : Tableau associatif contenant les attributs de l'article
  *******************************************************/
  public function getArticle($idArt) {
    $req = 'SELECT id_article AS "Code", designation AS "Désignation", categorie AS "Catégorie", prix AS "Prix" FROM article WHERE id_article=?;';
    $resultat = $this->execReqPrep($req, array($idArt));
    return $resultat[0];
  }
}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement