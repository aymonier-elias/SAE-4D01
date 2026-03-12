<?php
/**
 * Classe abstraite : connexion à la BDD et exécution de requêtes.
 * Tous les modèles (Escape, Reservation, etc.) en héritent.
 */

abstract class Database {

    private $bdd;


    /**
     * Exécute une requête SQL simple (sans paramètres).
     * @return array Résultat en tableau associatif
     */
    protected function execReq($req) {
        $reponse = $this->connexionBDD()->query($req);
        $resultat = $reponse->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }


    /**
     * Exécute une requête préparée (avec ? et tableau de paramètres).
     * Retourne les lignes pour un SELECT, ou le nombre de lignes pour INSERT/UPDATE/DELETE.
     */
    protected function execReqPrep($req, $data) {
        $reponse = $this->connexionBDD()->prepare($req);

        if ($reponse->execute($data)) {
            $resultat = $reponse->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($resultat)) {
                return $resultat;
            } else {
                return $reponse->rowCount();
            }
        }
        return false;
    }


    /**
     * Retourne l'id de la dernière ligne insérée (INSERT).
     */
    protected function lastInsertId() {
        return $this->connexionBDD()->lastInsertId();
    }


    /**
     * Connexion PDO (utilise $conf : DBHost, DBName, DBUser, DBPwd).
     */
    private function connexionBDD() {
        global $conf;

        if (!isset($this->bdd)) {
            try {
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
                $this->bdd = new PDO(
                    'mysql:host=' . $conf->DBHost . ';dbname=' . $conf->DBName,
                    $conf->DBUser,
                    $conf->DBPwd,
                    $options
                );
            } catch (Exception $err) {
                throw new Exception("Connexion à la BDD");
            }
        }
        return $this->bdd;
    }
}
