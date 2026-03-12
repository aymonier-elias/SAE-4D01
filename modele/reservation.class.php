<?php
/**
 * Modèle : table "acheter" (réservations / panier / commandes).
 * reserver = 0 : dans le panier | reserver = 1 : acheté (créneau indisponible).
 */

require_once "modele/database.class.php";


class Reservation extends Database {


    /**
     * Liste des réservations. Si $id_client = null (admin), joint le nom du client.
     */
    public function getReservations($id_client = null) {
        $req = 'SELECT a.id_client AS "id_client", a.id_version AS "id_version", a.date AS "Date", a.heure AS "Heure", a.nb_participant AS "Nombre de participants", a.reserver AS "reserver", e.nom AS "Escape", e.id_escape AS "id_escape" ';
        if ($id_client === null) {
            $req .= ', c.nom AS "Nom client", c.prénom AS "Prénom client", c.mail AS "Mail client" ';
        }
        $req .= 'FROM acheter a ' .
               'INNER JOIN version v ON a.id_version = v.id_version ' .
               'INNER JOIN escape_game e ON v.id_escape = e.id_escape ';
        if ($id_client === null) {
            $req .= 'LEFT JOIN client c ON a.id_client = c.id_client ';
        }
        if ($id_client !== null) {
            $req .= 'WHERE a.id_client = ? ';
        }
        $req .= 'ORDER BY a.date DESC, a.heure DESC;';

        if ($id_client !== null) {
            $reservations = $this->execReqPrep($req, array($id_client));
        } else {
            $reservations = $this->execReq($req);
        }
        return is_array($reservations) ? $reservations : array();
    }


    /**
     * Détail d'une commande : articles (escape + version + nb participants).
     */
    public function getArticlesReservation($id_client, $id_version, $date, $heure) {
        $req = 'SELECT e.id_escape, e.nom, e.description, v.id_version, v.nom AS "Pack", v.durée, v.prix, a.nb_participant ' .
               'FROM acheter a ' .
               'INNER JOIN version v ON a.id_version = v.id_version ' .
               'INNER JOIN escape_game e ON v.id_escape = e.id_escape ' .
               'WHERE a.id_client=? AND a.id_version=? AND a.date=? AND a.heure=?;';
        $resultat = $this->execReqPrep($req, array($id_client, $id_version, $date, $heure));
        return $resultat;
    }


    /**
     * Montant total d'une commande (nb_participant * prix).
     */
    public function getTotalReservation($id_client, $id_version, $date, $heure) {
        $req = 'SELECT (a.nb_participant * v.prix) AS "total" ' .
               'FROM acheter a INNER JOIN version v ON a.id_version = v.id_version ' .
               'WHERE a.id_client=? AND a.id_version=? AND a.date=? AND a.heure=?;';
        $resultat = $this->execReqPrep($req, array($id_client, $id_version, $date, $heure));
        return isset($resultat[0]['total']) ? $resultat[0]['total'] : 0;
    }


    public function getIdClientReservation($id_client, $id_version, $date, $heure) {
        return $id_client;
    }


    /**
     * Vérifie si un créneau est déjà pris (panier ou acheté).
     */
    public function creneauEstPris($id_version, $date, $heure) {
        $req = 'SELECT 1 FROM acheter WHERE id_version = ? AND date = ? AND heure = ? LIMIT 1;';
        $r = $this->execReqPrep($req, array($id_version, $date, $heure));
        return is_array($r) && count($r) > 0;
    }


    /**
     * Créneaux occupés par version : [ date => [ heure => 'panier'|'achete' ] ].
     * Utilisé par le calendrier (couleurs des jours et des heures).
     */
    public function getCreneauxOccupesParVersion($id_version) {
        $req = 'SELECT date, heure, reserver FROM acheter WHERE id_version = ? ORDER BY date, heure;';
        $rows = $this->execReqPrep($req, array($id_version));
        $out = array();
        if (is_array($rows)) {
            foreach ($rows as $row) {
                $d = $row['date'];
                $h = $row['heure'];
                if (strlen($h) > 5) {
                    $h = substr($h, 0, 5);
                }
                if (!isset($out[$d])) {
                    $out[$d] = array();
                }
                $out[$d][$h] = (int)($row['reserver']) === 1 ? 'achete' : 'panier';
            }
        }
        return $out;
    }


    /**
     * Retire une ligne du panier (reserver = 0) pour le client connecté.
     */
    public function retirerDuPanier($id_client, $id_version, $date, $heure) {
        $req = 'DELETE FROM acheter WHERE id_client = ? AND id_version = ? AND date = ? AND heure = ? AND reserver = 0;';
        $this->execReqPrep($req, array($id_client, (int) $id_version, $date, $heure));
    }


    /**
     * Ajoute une ligne au panier. Retourne false si le créneau est déjà pris.
     */
    public function ajouterAuPanier($id_client, $id_version, $date, $heure, $nb_participant) {
        if ($this->creneauEstPris($id_version, $date, $heure)) {
            return false;
        }
        $req = 'INSERT INTO acheter (id_client, id_version, date, heure, nb_participant, reserver) VALUES (?, ?, ?, ?, ?, 0);';
        $this->execReqPrep($req, array($id_client, $id_version, $date, $heure, (int) $nb_participant));
        return true;
    }


    /**
     * Passe toutes les lignes du panier du client en "acheté" (reserver = 1).
     */
    public function confirmerAchatPanier($id_client) {
        $req = 'UPDATE acheter SET reserver = 1 WHERE id_client = ? AND reserver = 0;';
        $n = $this->execReqPrep($req, array($id_client));
        return is_int($n) ? $n : 0;
    }


    /**
     * Lignes du panier (reserver = 0) pour un client.
     */
    public function getPanier($id_client) {
        $req = 'SELECT a.id_client, a.id_version, a.date AS "Date", a.heure AS "Heure", a.nb_participant AS "Nombre de participants", e.nom AS "Escape", v.nom AS "Pack", v.durée, v.prix, (a.nb_participant * v.prix) AS "total_ligne" ' .
               'FROM acheter a INNER JOIN version v ON a.id_version = v.id_version INNER JOIN escape_game e ON v.id_escape = e.id_escape ' .
               'WHERE a.id_client = ? AND a.reserver = 0 ORDER BY a.date, a.heure;';
        $r = $this->execReqPrep($req, array($id_client));
        return is_array($r) ? $r : array();
    }


    /**
     * Total du panier d'un client.
     */
    public function getTotalPanier($id_client) {
        $req = 'SELECT COALESCE(SUM(a.nb_participant * v.prix), 0) AS total FROM acheter a INNER JOIN version v ON a.id_version = v.id_version WHERE a.id_client = ? AND a.reserver = 0;';
        $r = $this->execReqPrep($req, array($id_client));
        return (is_array($r) && isset($r[0]['total'])) ? (int) $r[0]['total'] : 0;
    }
}
