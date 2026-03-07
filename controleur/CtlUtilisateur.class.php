<?php

require_once "modele/utilisateur.class.php";
require_once "vue/vue.class.php";

/*******************************************************
    Contrôleur chargé de la gestion des utilisateurs
    (connexion, inscription, profil, déconnexion, admin)
*******************************************************/

class CtlUtilisateur {

    private $utilisateur;

    public function __construct() {
        $this->utilisateur = new Utilisateur();
    }

    /*******************************************************
        PARTIE AFFICHAGE DES VUES
    *******************************************************/

    /** Affichage de la page de connexion */ 
    public function connexion($erreur = "") {
        setcookie('page', '?action=connexion', time() + 3600);
        $vue = new Vue("Connexion");
        $vue->afficher(array("erreur" => $erreur));
    }

    /** Affichage de la page profil */
    public function profil($erreur = "") {
        if (!isset($_SESSION['id_utilisateur'])) {
            header('Location: index.php?action=connexion');
            exit;
        }
        setcookie('page', '?action=profil', time() + 3600);
        $utilisateur = $this->utilisateur->getUtilisateurByEmail($_SESSION['email']);
        $vue = new Vue("Profil");
        $vue->afficher(array(
            "utilisateur" => $utilisateur,
            "erreur" => $erreur
        ));
    }

    /** Liste des utilisateurs (admin) */
    public function utilisateurs() {
        if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 2) {
            header('Location: index.php');
            exit;
        }
        $utilisateurs = $this->utilisateur->getUtilisateurs();
        $vue = new Vue("Utilisateurs");
        $vue->afficher(array("utilisateurs" => $utilisateurs));
    }

    /*******************************************************
        INSCRIPTION ET CONNEXION / DÉCONNEXION
    *******************************************************/

    /** Inscription sur le site */
    public function inscription($prenom, $nom, $email, $mdp) {
        $utilisateur = $this->utilisateur->getUtilisateurByEmail($email);

        if (empty($utilisateur)) {
            if (!empty($prenom) && !empty($nom) && !empty($email) && !empty($mdp)) {
                $mdphash = password_hash($mdp, PASSWORD_DEFAULT);
                $this->utilisateur->inscrire($prenom, $nom, $email, $mdphash);
                $utilisateur = $this->utilisateur->getUtilisateurByEmail($email);

                $_SESSION['acces'] = $utilisateur['prenom'];
                $_SESSION['email'] = $utilisateur['mail'];
                $_SESSION['id_utilisateur'] = $utilisateur['id_utilisateur'];
                $_SESSION['statut'] = $utilisateur['statut'];

                $this->accueil();
            }
        } else {
            $this->connexion('Cette adresse email est déjà utilisée');
        }
    }

    /** Authentification sur le site */
    public function login($email, $mdp) {
        $utilisateur = $this->utilisateur->getUtilisateurByEmail($email);

        if (!empty($utilisateur)) {
            if (password_verify($mdp, $utilisateur['mdp'])) {
                $_SESSION['acces'] = $utilisateur['prenom'];
                $_SESSION['email'] = $utilisateur['mail'];
                $_SESSION['id_utilisateur'] = $utilisateur['id_utilisateur'];
                $_SESSION['statut'] = $utilisateur['statut'];

                $this->accueilConnecte();
            } else {
                $this->connexion('Le mot de passe est incorrect');
            }
        } else {
            $this->connexion('<b>Identifiant introuvable</b>');
        }
    }

    /** Déconnexion du site */
    public function quitter() {
        session_unset();
        session_destroy();
        setcookie(session_name(), "", time() - 1, "/");
        header('Location: index.php');
        exit;
    }

    /*******************************************************
        MODIFICATION PROFIL
    *******************************************************/

    /** Enregistrement photo de profil */
    public function enregPhotoProfil($id_utilisateur) {
        try {
            $this->utilisateur->updatePhotoProfil($id_utilisateur);
            $this->profil("Photo de profil mise à jour avec succès");
        } catch (Exception $e) {
            $this->profil($e->getMessage());
        }
    }

    /** Modifier le profil */
    public function modifierProfil($id_utilisateur, $prenom, $nom, $email, $mdp_nouveau, $mdp_actuel) {
        $utilisateur = $this->utilisateur->getUtilisateur($id_utilisateur);

        if (empty($utilisateur)) {
            $this->profil("Utilisateur introuvable");
            return;
        }

        if (empty($prenom) || empty($nom) || empty($email)) {
            $this->profil("Veuillez remplir tous les champs obligatoires");
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->profil("L'adresse email n'est pas valide");
            return;
        }

        $autreUtilisateur = $this->utilisateur->getUtilisateurByEmail($email);
        if (!empty($autreUtilisateur) && $autreUtilisateur['id_utilisateur'] != $id_utilisateur) {
            $this->profil("Cette adresse email est déjà utilisée par un autre compte");
            return;
        }

        if (!empty($mdp_nouveau)) {
            if (empty($mdp_actuel)) {
                $this->profil("Veuillez entrer votre mot de passe actuel pour le changer");
                return;
            }
            if (!password_verify($mdp_actuel, $utilisateur['mdp'])) {
                $this->profil("Le mot de passe actuel est incorrect");
                return;
            }
            $this->utilisateur->modifierProfil($id_utilisateur, $prenom, $nom, $email, password_hash($mdp_nouveau, PASSWORD_DEFAULT));
            if ($email !== $utilisateur['mail']) {
                $_SESSION['email'] = $email;
            }
            $this->profil("Informations et mot de passe mis à jour avec succès");
        } else {
            $this->utilisateur->modifierProfil($id_utilisateur, $prenom, $nom, $email, null);
            if ($email !== $utilisateur['mail']) {
                $_SESSION['email'] = $email;
            }
            $this->profil("Informations mises à jour avec succès");
        }
    }

    /** Supprimer le compte */
    public function supprimerCompte($id_utilisateur) {
        $utilisateur = $this->utilisateur->getUtilisateur($id_utilisateur);
        if (empty($utilisateur)) {
            $this->profil("Utilisateur introuvable");
            return;
        }
        if (!password_verify($_POST['mdp'] ?? '', $utilisateur['mdp'])) {
            $this->profil("Mot de passe incorrect");
            return;
        }

        $this->utilisateur->supprimerCompte($id_utilisateur);
        session_destroy();
        header('Location: index.php');
        exit;
    }

    /** Suppression utilisateur (admin) */
    public function supprimerUtilisateur($id_utilisateur) {
        if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 2) {
            return;
        }
        if ($id_utilisateur == $_SESSION['id_utilisateur']) {
            return;
        }
        $this->utilisateur->supprimerUtilisateurComplet($id_utilisateur);
    }
}
