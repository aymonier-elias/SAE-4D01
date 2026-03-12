<?php
/**
 * Contrôleur des réservations : panier, commandes, favoris.
 */

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


    /**
     * Affiche la liste selon le contexte : panier, favoris, ou gestion des commandes (admin).
     */
    public function reservations($contexte = 'reservations') {
        if ($contexte === 'favoris') {
            $id_client = isset($_SESSION['id_utilisateur']) ?  $_SESSION['id_utilisateur'] : 0;
            $favoris = $id_client ? $this->favori->getEscapesFavoris($id_client) : array();
            $vue = new Vue("Reservations");
            $vue->afficher(array("reservations" => array(), "contexte" => "favoris", "favoris" => $favoris));
            return;
        }

        $id_client = isset($_SESSION['id_utilisateur']) ?  $_SESSION['id_utilisateur'] : null;
        if ($contexte === 'panier' && $id_client) {
            $reservations = $this->reservation->getPanier($id_client);
        } else {
            $reservations = $this->reservation->getReservations($id_client);
        }

        $vue = new Vue("Reservations");
        $vue->afficher(array("reservations" => $reservations, "contexte" => $contexte, "favoris" => array()));
    }


    /**
     * Affiche le détail d'une commande / réservation (client + articles + total).
     */
    public function reservation($id_client, $id_version, $date, $heure) {
        $articles = $this->reservation->getArticlesReservation($id_client, $id_version, $date, $heure);

        if (empty($articles)) {
            throw new Exception("Echec de l'affichage de la réservation.");
        }

        $client = $this->utilisateur->getUtilisateur($this->reservation->getIdClientReservation($id_client, $id_version, $date, $heure));
        $total = $this->reservation->getTotalReservation($id_client, $id_version, $date, $heure);
        $id_Res = $id_client . '-' . $id_version . '-' . $date . '-' . $heure;

        $vue = new Vue("Reservation");
        $vue->afficher(array(
            "articles" => $articles,
            "id_Res" => $id_Res,
            "idComm" => $id_Res,
            "total" => $total,
            "client" => $client,
            "utilisateur" => $client
        ));
    }


    /**
     * Ajoute un escape aux favoris du client connecté.
     */
    public function ajouterFavori($id_escape) {
        $id_client = isset($_SESSION['id_utilisateur']) ?  $_SESSION['id_utilisateur'] : 0;
        if (!$id_client) {
            header('Location: index.php?action=connexion');
            exit;
        }
        $id_escape = (int) ($id_escape ?? 0);
        if ($id_escape <= 0) {
            $_SESSION['flash_favori_erreur'] = 'Mission invalide.';
            header('Location: index.php?action=escapes');
            exit;
        }
        $this->favori->ajouter($id_client, $id_escape);
        $retour = isset($_GET['retour']) ? $_GET['retour'] : 'index.php?action=favoris';
        header('Location: ' . htmlspecialchars($retour, ENT_QUOTES, 'UTF-8'));
        exit;
    }


    /**
     * Retire un escape des favoris.
     */
    public function retirerFavori($id_escape) {
        $id_client = isset($_SESSION['id_utilisateur']) ?  $_SESSION['id_utilisateur'] : 0;
        $id_escape = (int) ($id_escape ?? 0);
        if ($id_client && $id_escape > 0) {
            $this->favori->retirer($id_client, $id_escape);
        }
        $retour = isset($_GET['retour']) ? $_GET['retour'] : 'index.php?action=favoris';
        header('Location: ' . htmlspecialchars($retour, ENT_QUOTES, 'UTF-8'));
        exit;
    }


    /**
     * Retire une ligne du panier (id_version, date, heure en GET). Redirige vers le panier.
     */
    public function retirerPanier() {
        $id_client = isset($_SESSION['id_utilisateur']) ? $_SESSION['id_utilisateur'] : 0;
        if (!$id_client) {
            header('Location: index.php?action=connexion');
            exit;
        }
        $id_version = (int) ($_GET['id_version'] ?? 0);
        $date = trim((string) ($_GET['date'] ?? ''));
        $heure = trim((string) ($_GET['heure'] ?? ''));
        if ($id_version > 0 && $date !== '' && $heure !== '') {
            if (strlen($heure) > 5) {
                $heure = substr($heure, 0, 5);
            }
            $this->reservation->retirerDuPanier($id_client, $id_version, $date, $heure);
        }
        header('Location: index.php?action=panier');
        exit;
    }


    /**
     * Ajoute au panier : version + date + heure + nombre de joueurs.
     * Ne traite que les requêtes POST (évite double soumission / GET).
     */
    public function ajouterPanier() {
        $id_client = isset($_SESSION['id_utilisateur']) ?  $_SESSION['id_utilisateur'] : 0;
        if (!$id_client) {
            header('Location: index.php?action=connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=panier');
            exit;
        }

        $id_version = (int) ($_POST['id_version'] ?? 0);
        $date = trim((string) ($_POST['date'] ?? ''));
        $heure = trim((string) ($_POST['heure'] ?? ''));
        $nb_participant = (int) ($_POST['nb_participant'] ?? 0);

        if ($id_version > 0 && $date !== '' && $heure !== '' && $nb_participant > 0) {
            if (strlen($heure) > 5) {
                $heure = substr($heure, 0, 5);
            }
            $ok = $this->reservation->ajouterAuPanier($id_client, $id_version, $date, $heure, $nb_participant);
            if (!$ok) {
                $_SESSION['flash_panier_erreur'] = 'Ce créneau n\'est plus disponible (réservé ou déjà dans un panier).';
            }
        } else {
            $_SESSION['flash_panier_erreur'] = 'Veuillez choisir une version, une date, une heure et le nombre de participants.';
        }

        header('Location: index.php?action=panier');
        exit;
    }


    /**
     * Retourne les créneaux occupés en JSON (pour le calendrier sur la page escape).
     */
    public function getCreneauxJson($id_version) {
        header('Content-Type: application/json; charset=utf-8');
        $creneaux = $this->reservation->getCreneauxOccupesParVersion( $id_version);
        echo json_encode($creneaux);
        exit;
    }


    /**
     * Récapitulatif du panier avant paiement (tunnel de vente).
     */
    public function recapCommande() {
        $id_client = isset($_SESSION['id_utilisateur']) ?  $_SESSION['id_utilisateur'] : 0;
        if (!$id_client) {
            header('Location: index.php?action=connexion');
            exit;
        }

        $panier = $this->reservation->getPanier($id_client);
        $total = $this->reservation->getTotalPanier($id_client);
        $client = $this->utilisateur->getUtilisateur($id_client);

        $vue = new Vue("RecapCommande");
        $vue->afficher(array("panier" => $panier, "total" => $total, "client" => $client ?: array()));
    }


    /**
     * Paiement fictif : passe toutes les lignes du panier en "acheté" (reserver = 1).
     */
    public function confirmerPaiement() {
        $id_client = isset($_SESSION['id_utilisateur']) ?  $_SESSION['id_utilisateur'] : 0;
        if (!$id_client) {
            header('Location: index.php?action=connexion');
            exit;
        }
        $nb = $this->reservation->confirmerAchatPanier($id_client);
        $_SESSION['flash_confirmation'] = $nb > 0 ? "Votre commande a bien été enregistrée. Merci !" : "Aucun article à confirmer.";
        header('Location: index.php?action=confirmation_commande');
        exit;
    }


    /**
     * Page de confirmation après paiement.
     */
    public function confirmationCommande() {
        $message = isset($_SESSION['flash_confirmation']) ? $_SESSION['flash_confirmation'] : 'Commande enregistrée.';
        unset($_SESSION['flash_confirmation']);
        $vue = new Vue("ConfirmationCommande");
        $vue->afficher(array("message" => $message));
    }
}
