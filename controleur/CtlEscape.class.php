<?php
/**
 * Contrôleur des escapes (missions) : liste, détail, gestion admin, avis.
 */

require_once "modele/escape.class.php";
require_once "modele/favori.class.php";
require_once "modele/avis.class.php";
require_once "modele/reservation.class.php";
require_once "vue/vue.class.php";


class CtlEscape {

    private $escape;
    private $favori;
    private $avis;
    private $reservation;


    public function __construct() {
        $this->escape = new Escape();
        $this->favori = new Favori();
        $this->avis = new Avis();
        $this->reservation = new Reservation();
    }


    /**
     * Affiche la liste de toutes les missions (escapes).
     */
    public function escapes() {
        $escapes = $this->escape->getEscapes();
        $ids_favoris = array();
        if (isset($_SESSION['id_utilisateur'])) {
            $ids_favoris = $this->favori->getIdsFavoris($_SESSION['id_utilisateur']);
        }
        $vue = new Vue("Escapes");
        $vue->afficher(array("escapes" => $escapes, "ids_favoris" => $ids_favoris));
    }


    /**
     * Affiche la page d'une mission : infos, versions (packs), calendrier, avis.
     */
    public function escape($id_escape) {
        $escape = $this->escape->getEscape($id_escape);
        $versions = $this->escape->getVersions($id_escape);

        $est_favori = false;
        $avis_utilisateur = null;

        if (isset($_SESSION['id_utilisateur']) && !empty($escape)) {
            $est_favori = $this->favori->estFavori($_SESSION['id_utilisateur'], $id_escape);
            $avis_utilisateur = $this->avis->getAvisUtilisateur($id_escape,$_SESSION['id_utilisateur']);
        }

        $liste_avis = $this->avis->getAvisByEscape($id_escape);
        $note_moyenne = $this->avis->getNoteMoyenne($id_escape);

        // Créneaux occupés par version (pour le calendrier : rouge = panier, gris = vendu)
        $creneauxParVersion = array();
        foreach ($versions as $v) {
            $id_version = ($v['id_version'] ?? 0);
            if ($id_version) {
                $creneauxParVersion[$id_version] = $this->reservation->getCreneauxOccupesParVersion($id_version);
            }
        }

        $vue = new Vue("Escape");
        $vue->afficher(array(
            "escape" => $escape ?: array(),
            "versions" => $versions,
            "est_favori" => $est_favori,
            "id_escape" => $id_escape,
            "liste_avis" => $liste_avis,
            "note_moyenne" => $note_moyenne,
            "avis_utilisateur" => $avis_utilisateur,
            "creneauxParVersion" => $creneauxParVersion
        ));
    }


    /**
     * Page admin : liste des escapes pour modification / suppression.
     */
    public function gestionEscapes() {
        $escapes = $this->escape->getEscapes();
        $vue = new Vue("GestionEscapes");
        $vue->afficher(array("escapes" => $escapes));
    }


    /**
     * Formulaire d'ajout d'un nouvel escape (admin).
     */
    public function formulaireAjoutEscape() {
        $vue = new Vue("FormulaireAjoutEscape");
        $vue->afficher(array());
    }


    /**
     * Formulaire de modification d'un escape (admin).
     */
    public function formulaireModifierEscape($id_escape) {
        $escape = $this->escape->getEscape($id_escape);
        $vue = new Vue("FormulaireModifierEscape");
        $vue->afficher(array("escape" => $escape));
    }


    /**
     * Enregistre un nouvel escape et fais aussi les 3 packs par défaut.
     */
    public function ajouterEscape($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés) {
        $id_escape = $this->escape->addEscape($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés);

        if (isset($_FILES['photoCouverture']) && $_FILES['photoCouverture']['error'] === UPLOAD_ERR_OK) {
            try {
                $this->escape->updatePhotoCouverture($id_escape);
            } catch (Exception $e) {
                $_SESSION['flash_escape_err'] = $e->getMessage();
            }
        }

        header('Location: index.php?action=gestion_escapegame');
        exit;
    }


    /**
     * Met à jour un escape existant (POST).
     */
    public function modifierEscape($id_escape, $nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés) {
        $this->escape->updateEscape($id_escape, $nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés);

        if (isset($_FILES['photoCouverture']) && $_FILES['photoCouverture']['error'] === UPLOAD_ERR_OK) {
            try {
                $this->escape->updatePhotoCouverture($id_escape);
            } catch (Exception $e) {
                $_SESSION['flash_escape_err'] = $e->getMessage();
            }
        }

        header('Location: index.php?action=gestion_escapegame');
        exit;
    }


    /**
     * Supprime un escape (admin).
     */
    public function supprimerEscape($id_escape) {
        $this->escape->deleteEscape($id_escape);
        header('Location: index.php?action=gestion_escapegame');
        exit;
    }


    /**
     * Dépose ou modifie un avis sur une mission (utilisateur connecté).
     */
    public function ajouterAvis($id_escape, $note, $commentaire = '') {
        $id_escape =  $id_escape;
        if (!isset($_SESSION['id_utilisateur'])) {
            header('Location: index.php?action=connexion');
            exit;
        }
        $this->avis->enregistrerAvis($id_escape,  $_SESSION['id_utilisateur'], $note, $commentaire);
        header('Location: index.php?action=escape&id_escape=' . $id_escape . '#avis');
        exit;
    }
}
