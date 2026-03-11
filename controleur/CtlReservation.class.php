<?php

require_once "modele/reservation.class.php";
require_once "modele/utilisateur.class.php";
require_once "modele/favori.class.php";
require_once "vue/vue.class.php";

class CtlReservation {

    private $reservation;
    private $utilisateur;
    private $favori;

    public function __construct() {
        $this->reservation = new Reservation();
        $this->utilisateur = new Utilisateur();
        $this->favori = new Favori();
    }


    /*******************************************************
Affichage de la liste des Reservations ou des Favoris (escapes)
*******************************************************/
    public function reservations($contexte = 'reservations') {
        if ($contexte === 'favoris') {
            $id_client = isset($_SESSION['id_utilisateur']) ? (int) $_SESSION['id_utilisateur'] : 0;
            $favoris = $id_client ? $this->favori->getEscapesFavoris($id_client) : array();
            $vue = new Vue("Reservations");
            $vue->afficher(array("reservations" => array(), "contexte" => "favoris", "favoris" => $favoris));
            return;
        }
        $id_client = isset($_SESSION['id_utilisateur']) ? (int) $_SESSION['id_utilisateur'] : null;
        $reservations = $this->reservation->getReservations($id_client);
        $vue = new Vue("Reservations");
        $vue->afficher(array("reservations" => $reservations, "contexte" => $contexte, "favoris" => array()));
    }

    /*******************************************************
Affichage des détails d'une Reservation et du client dans la vue concernée
  Entrée :
    idComm [int] : n° de la Reservation

  Retour : 
    
*******************************************************/
    public function reservation($id_client, $id_version, $date, $heure) {
        $articles = $this->reservation->getArticlesReservation($id_client, $id_version, $date, $heure);
        if (!empty($articles)) {
            $id_client_res = $this->reservation->getIdClientReservation($id_client, $id_version, $date, $heure);
            $client = $this->utilisateur->getUtilisateur($id_client_res);
            $total = $this->reservation->getTotalReservation($id_client, $id_version, $date, $heure);
            $vue = new Vue("Reservation");
            $vue->afficher(array(
                "articles" => $articles,
                "id_Res" => $id_client . '-' . $id_version . '-' . $date . '-' . $heure,
                "idComm" => $id_client . '-' . $id_version . '-' . $date . '-' . $heure,
                "total" => $total,
                "client" => $client,
                "utilisateur" => $client
            ));
        } else {
            throw new Exception("Echec de l'affichage de la réservation.");
        }
    }

    /*******************************************************
    Ajoute un escape aux favoris du client connecté
    *******************************************************/
    public function ajouterFavori($id_escape) {
        $id_client = isset($_SESSION['id_utilisateur']) ? (int) $_SESSION['id_utilisateur'] : 0;
        if (!$id_client) {
            header('Location: index.php?action=connexion');
            exit;
        }
        $this->favori->ajouter($id_client, (int) $id_escape);
        $retour = isset($_GET['retour']) ? $_GET['retour'] : 'index.php?action=favoris';
        header('Location: ' . htmlspecialchars($retour, ENT_QUOTES, 'UTF-8'));
        exit;
    }

    /*******************************************************
    Ajoute au panier : version + créneau + nombre de joueurs
    *******************************************************/
    public function ajouterPanier() {
        $id_client = isset($_SESSION['id_utilisateur']) ? (int) $_SESSION['id_utilisateur'] : 0;
        if (!$id_client) {
            header('Location: index.php?action=connexion');
            exit;
        }
        $id_version = (int) ($_POST['id_version'] ?? 0);
        $date = trim((string) ($_POST['date'] ?? ''));
        $heure = trim((string) ($_POST['heure'] ?? ''));
        $nb_participant = (int) ($_POST['nb_participant'] ?? 0);
        if ($id_version && $date !== '' && $heure !== '' && $nb_participant > 0) {
            $this->reservation->ajouterAuPanier($id_client, $id_version, $date, $heure, $nb_participant);
        }
        header('Location: index.php?action=panier');
        exit;
    }

    /*******************************************************
    Retire un escape des favoris du client connecté
    *******************************************************/
    public function retirerFavori($id_escape) {
        $id_client = isset($_SESSION['id_utilisateur']) ? (int) $_SESSION['id_utilisateur'] : 0;
        if ($id_client) {
            $this->favori->retirer($id_client, (int) $id_escape);
        }
        $retour = isset($_GET['retour']) ? $_GET['retour'] : 'index.php?action=favoris';
        header('Location: ' . htmlspecialchars($retour, ENT_QUOTES, 'UTF-8'));
        exit;
    }
}
