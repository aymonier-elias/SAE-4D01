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
        $action = isset($_GET['action']) ? $_GET['action'] : null;

        try {
            if (isset($_SESSION['acces'])) {
                // Utilisateur connecté
                if ($action === null) {
                    $this->CtlPage->accueil();
                    return;
                }

                // Admin (statut == 2) : actions réservées à l'admin
                if (isset($_SESSION['statut']) && $_SESSION['statut'] == 2) {
                    switch ($action) {
                        case 'gestion_utilisateurs':
                        case 'utilisateurs':
                            $this->CtlUtilisateur->utilisateurs();
                            return;
                        case 'supprimerUtilisateur':
                            $this->CtlUtilisateur->supprimerUtilisateur($_GET['id_utilisateur'] ?? 0);
                            header('Location: index.php?action=gestion_utilisateurs');
                            exit;
                        case 'gestion_commandes':
                            $this->CtlReservation->reservations('gestion_commandes');
                            return;
                        case 'gestion_escapegame':
                            $this->CtlEscape->gestionEscapes();
                            return;
                        case 'formulaire_ajout_escape':
                            $this->CtlEscape->formulaireAjoutEscape();
                            return;
                        case 'formulaire_modifier_escape':
                            $this->CtlEscape->formulaireModifierEscape($_GET['id_escape'] ?? 0);
                            return;
                        case 'ajouterEscape':
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $this->CtlEscape->ajouterEscape(
                                    $_POST['nom'] ?? '',
                                    $_POST['description'] ?? '',
                                    $_POST['longitude'] ?? 0,
                                    $_POST['latitude'] ?? 0,
                                    (int)($_POST['nb_participants_max'] ?? 0),
                                    (int)($_POST['age_minimum'] ?? 0),
                                    $_POST['ville'] ?? '',
                                    $_POST['tags'] ?? '',
                                    (int)($_POST['difficultes'] ?? 0)
                                );
                            }
                            return;
                        case 'modifierEscape':
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $this->CtlEscape->modifierEscape(
                                    (int)($_POST['id_escape'] ?? 0),
                                    $_POST['nom'] ?? '',
                                    $_POST['description'] ?? '',
                                    $_POST['longitude'] ?? 0,
                                    $_POST['latitude'] ?? 0,
                                    (int)($_POST['nb_participants_max'] ?? 0),
                                    (int)($_POST['age_minimum'] ?? 0),
                                    $_POST['ville'] ?? '',
                                    $_POST['tags'] ?? '',
                                    (int)($_POST['difficultes'] ?? 0)
                                );
                            }
                            return;
                        case 'supprimerEscape':
                            $this->CtlEscape->supprimerEscape($_GET['id_escape'] ?? 0);
                            return; 
                    }
                }

                // Actions communes à tout utilisateur connecté (et pages publiques)
                switch ($action) {
                    case 'escapes':
                        $this->CtlEscape->escapes();
                        return;
                    case 'escape':
                        $this->CtlEscape->escape($_GET['id_escape'] ?? 0);
                        return;
                    case 'concept':
                        $this->CtlPage->concept();
                        return;
                    case 'contact':
                        $this->CtlPage->contact();
                        return;
                    case 'deconnexion':
                        $this->CtlUtilisateur->quitter();
                        return;
                    case 'profil':
                        $this->CtlUtilisateur->profil($_GET['erreur'] ?? '');
                        return;
                    case 'modifierProfil':
                        $this->CtlUtilisateur->modifierProfil(
                            $_POST['id_utilisateur'] ?? 0,
                            $_POST['prenom'] ?? '',
                            $_POST['nom'] ?? '',
                            $_POST['email'] ?? '',
                            $_POST['mdp_nouveau'] ?? '',
                            $_POST['mdp_actuel'] ?? ''
                        );
                        return;
                    case 'enregPhotoProfil':
                        $this->CtlUtilisateur->enregPhotoProfil($_POST['id_utilisateur'] ?? 0);
                        return;
                    case 'supprimerCompte':
                        $this->CtlUtilisateur->supprimerCompte($_POST['id_utilisateur'] ?? 0);
                        return;
                    case 'panier':
                        $this->CtlReservation->reservations('panier');
                        return;
                    case 'favoris':
                        $this->CtlReservation->reservations('favoris');
                        return;
                    case 'ajouterFavori':
                        $this->CtlReservation->ajouterFavori($_GET['id_escape'] ?? 0);
                        return;
                    case 'retirerFavori':
                        $this->CtlReservation->retirerFavori($_GET['id_escape'] ?? 0);
                        return;
                    case 'ajouterPanier':
                        $this->CtlReservation->ajouterPanier();
                        return;
                    case 'ajouterAvis':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $this->CtlEscape->ajouterAvis(
                                $_POST['id_escape'] ?? 0,
                                (int)($_POST['note'] ?? 0),
                                $_POST['commentaire'] ?? ''
                            );
                        }
                        return;
                    case 'commande':
                        $id_client = (int) ($_GET['id_client'] ?? 0);
                        $id_version = (int) ($_GET['id_version'] ?? 0);
                        $date = $_GET['date'] ?? '';
                        $heure = $_GET['heure'] ?? '';
                        if ($id_client > 0 && $id_version > 0 && $date !== '' && $heure !== '') {
                            $this->CtlReservation->reservation($id_client, $id_version, $date, $heure);
                        } else {
                            throw new Exception("Identifiants de commande invalides (id_client, id_version, date, heure requis)");
                        }
                        return;
                }

                throw new Exception("La page que vous cherchez est introuvable :(");
            }

            // Non connecté
            if ($action === null) {
                $this->CtlPage->accueil();
                return;
            }

            switch ($action) {
                case 'escapes':
                    $this->CtlEscape->escapes();
                    return;
                case 'escape':
                    $this->CtlEscape->escape($_GET['id_escape'] ?? 0);
                    return;
                case 'concept':
                    $this->CtlPage->concept();
                    return;
                case 'contact':
                    $this->CtlPage->contact();
                    return;
                case 'connexion':
                    $this->CtlUtilisateur->connexion($_GET['erreur'] ?? '');
                    return;
                case 'login':
                    $this->CtlUtilisateur->login($_POST['email'] ?? '', $_POST['mdp'] ?? '');
                    return;
                case 'inscription':
                    $this->CtlUtilisateur->inscription(
                        $_POST['prenom'] ?? '',
                        $_POST['nom'] ?? '',
                        $_POST['email'] ?? '',
                        $_POST['mdp'] ?? ''
                    );
                    return;
                case 'profil':
                case 'panier':
                case 'favoris':
                    header('Location: index.php?action=connexion');
                    exit;
            }

            throw new Exception("La page que vous cherchez est introuvable :(");
            
        } catch (Exception $e) {
            $this->CtlPage->erreur($e->getMessage());
            exit;
        }
    }
}
