<?php
require_once "modele/article.class.php";
require_once "vue/vue.class.php";


// Classe chargée de la gestion des articles


class CtlArticle{

    private $article;

    public function __construct() {
        $this->article = new Article();
    }



    /*******************************************************
Affichage de la liste des articles dans la vue concernée
  Entrée : 

  Retour : 
    
*******************************************************/
    public function articles() {
        $articles = $this->article->getArticles();
        $vue = new Vue("Articles"); // Instancie la vue appropriée
        $vue->afficher(array("articles" => $articles)); 
    }


}
