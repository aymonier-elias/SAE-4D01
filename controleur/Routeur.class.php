<?php
require_once "controleur/CtlEscape.class.php";
require_once "controleur/CtlReservation.class.php";
require_once "controleur/CtlUtilisateur.class.php";
require_once "controleur/CtlPage.class.php";

// Classe chargée de la gestion des articles


class Routeur {

    private $CtlEscape;
    private $CtlReservation;
    private $CtlUtilisateur;
    private $CtlPage;

    public function __construct() {
        $this->CtlEscape = new CtlEscape();
        $this->CtlReservation = new CtlReservation();
        $this->CtlUtilisateur = new CtlUtilisateur();
        $this->CtlPage = new CtlPage();
    }

    public function routerRequete()
    {
        try {

        if(isset($_GET["action"])) {

            switch($_GET["action"]){

            case "escapes":
                $this->CtlEscape->escapes();
                break;
            
            case "concept":
                $this->CtlEscape->escapes();
                break;
            
            case "contact":
                $this->CtlEscape->escapes();
                break;
                
            case "connexion":
                $this->CtlUtilisateur->utilisateurs();
                break;

            case "panier":
                $this->CtlReservation->reservations();
                break;

            case "favoris":
                $this->CtlReservation->reservations();
                break;

            case "profil":
                $this->CtlReservation->reservations();
                break;
            case "profil":
                $this->CtlReservation->reservations();
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

