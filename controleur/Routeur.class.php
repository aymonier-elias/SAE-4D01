<?php
require_once "controleur/CtlArticle.class.php";
require_once "controleur/CtlClient.class.php";
require_once "controleur/CtlCommande.class.php";
require_once "controleur/CtlPage.class.php";

// Classe chargée de la gestion des articles


class Routeur {

    private $CtlClient;
    private $CtlArticle;
    private $ctlCommande;
    private $CtlPage;

    public function __construct() {
        $this->CtlClient = new CtlClient();
        $this->CtlArticle = new CtlArticle();
        $this->ctlCommande = new ctlCommande();
        $this->CtlPage = new CtlPage();
    }

    public function routerRequete()
    {
        try {

        if(isset($_GET["action"])) {

            switch($_GET["action"]){

            case "clients":
                $this->CtlClient->clients();
                break;
            
            case "ajoutClient":
                $this->CtlClient->ajoutClient();
                break;
            
            case "enregClient":
                $this->CtlClient->enregClient($_POST['nom'], $_POST['prenom'], $_POST['age'], $_POST['adresse'], $_POST['ville'], $_POST['email']);
                break;
                
            case "articles":
                $this->CtlArticle->articles();
                break;

            case "commandes":
                $this->ctlCommande->commandes();
                break;
            
            case "commande":
                if(isset($_GET["idComm"])) {
                $idComm = (int)$_GET["idComm"];
                if($idComm > 0)
                     $this->ctlCommande->commande($idComm);                                                // Affichage d'une commande
                else
                    throw new Exception("Identifiant de commande invalide");
                }
            else
                throw new Exception("Aucun identifiant de commande");
            break;
            
            default:
            throw new Exception("Action non valide");

            }
        }
        else                                                                    // Page d'accueil
            $this->CtlPage->accueil(); 

        }


    catch (Exception $e) {                                                      // Page d'erreur
    $this->CtlPage->erreur($e->getMessage());
    }  
    
    }
}

    
    
    
// Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement
