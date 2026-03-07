<?php
require_once "controleur/CtlEscape.class.php";
require_once "controleur/CtlReservation.class.php";
require_once "controleur/CtlUtilisateur.class.php";
require_once "controleur/CtlPage.class.php";
require_once "vue/vue.class.php";

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

    public function routerRequete() {
        try {
            if (isset($_GET["action"])) {
                switch ($_GET["action"]) {

                    case "escapes":
                        $this->CtlEscape->escapes();
                        break;

                    case "concept":
                        $this->CtlPage->concept();
                        break;

                    case "contact":
                        $this->CtlPage->contact();
                        break;

                    case "connexion": // page de connexion
                        $this->CtlUtilisateur->connexion($_GET["erreur"] ?? "");
                        break;

                    case "inscription": // envoie des données de l'utilisateur à la base de données
                        $this->CtlUtilisateur->inscription($_POST["prenom"] ?? "",$_POST["nom"] ?? "",
                        $_POST["email"] ?? "",$_POST["mdp"] ?? "");
                        break;
                    
                    case "login": // vérifie les données de l'utilisateur dans la base de données
                        $this->CtlUtilisateur->login($_POST['nom'] ?? "", $_POST['mdp'] ?? "");
                        break;







                    case "deconnexion":
                        $this->CtlUtilisateur->quitter();
                        break;

                    case "profil":
                        $this->CtlUtilisateur->profil($_GET["erreur"] ?? "");
                        break;

                    case "modifierProfil":
                        $this->CtlUtilisateur->modifierProfil(
                            $_POST["id_utilisateur"] ?? 0,
                            $_POST["prenom"] ?? "",
                            $_POST["nom"] ?? "",
                            $_POST["email"] ?? "",
                            $_POST["mdp_nouveau"] ?? "",
                            $_POST["mdp_actuel"] ?? ""
                        );
                        break;

                    case "enregPhotoProfil":
                        $this->CtlUtilisateur->enregPhotoProfil($_POST["id_utilisateur"] ?? 0);
                        break;

                    case "supprimerCompte":
                        $this->CtlUtilisateur->supprimerCompte($_POST["id_utilisateur"] ?? 0);
                        break;

                    case "gestion_utilisateurs":
                    case "utilisateurs":
                        $this->CtlUtilisateur->utilisateurs();
                        break;

                    case "supprimerUtilisateur":
                        $this->CtlUtilisateur->supprimerUtilisateur($_GET["id_utilisateur"] ?? 0);
                        break;

                    case "panier":
                        $this->CtlReservation->reservations();
                        break;

                    case "favoris":
                        $this->CtlReservation->reservations();
                        break;

                    case "commande":
                        $id_client = (int) ($_GET["id_client"] ?? 0);
                        $id_version = (int) ($_GET["id_version"] ?? 0);
                        $date = $_GET["date"] ?? '';
                        $heure = $_GET["heure"] ?? '';
                        if ($id_client > 0 && $id_version > 0 && $date !== '' && $heure !== '') {
                            $this->CtlReservation->reservation($id_client, $id_version, $date, $heure);
                        } else {
                            throw new Exception("Identifiants de commande invalides (id_client, id_version, date, heure requis)");
                        }
                        break;

                    default:
                        throw new Exception("Action non valide");
                }
            } else {
                $this->CtlPage->accueil();
            }
        } catch (Exception $e) {
            $this->CtlPage->erreur($e->getMessage());
        }
    }
}
