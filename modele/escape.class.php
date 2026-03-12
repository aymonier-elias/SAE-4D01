<?php
require_once "modele/database.class.php";
require_once "config/config.class.php";

/****************************************************************
Classe chargée de la gestion des escapes dans la base de données
****************************************************************/
class Escape extends Database {

  /** Affichage difficulté : 1 à 5 étoiles (entier en BDD) */
  public static $LIBELLES_DIFFICULTE = array(1 => '★', 2 => '★★', 3 => '★★★', 4 => '★★★★', 5 => '★★★★★');
  /** Libellés pour le formulaire (select) */
  public static $LIBELLES_DIFFICULTE_FORM = array(1 => '1 étoile', 2 => '2 étoiles', 3 => '3 étoiles', 4 => '4 étoiles', 5 => '5 étoiles');

  /*******************************************************
  Retourne la liste des escapes 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des escapes
  *******************************************************/
  public function getEscapes() {
    $req = 'SELECT id_escape AS "Code", nom AS "Nom", description AS "Description", longitude AS "Longitude", latitude AS "Latitude", nb_participants_max AS "Nombre de participants maximum", age_minimum AS "Age minimum", ville AS "Ville", tags AS "Tags", difficultés AS "Difficultés" FROM escape_game ORDER BY nom;';
    $escapes = $this->execReq($req);
    return $escapes;
  }

  /*******************************************************
  Retourne les n derniers escapes (les plus récemment ajoutés)
    Entrée :
      $limit [int] : nombre d'escapes à retourner (défaut 3)
    Retour :
      [array] : Tableau associatif contenant les escapes
  *******************************************************/
  public function getDerniersEscapes($limit = 3) {
    $limit = max(1, (int) $limit);
    $req = 'SELECT id_escape AS "Code", nom AS "Nom", description AS "Description", longitude AS "Longitude", latitude AS "Latitude", nb_participants_max AS "Nombre de participants maximum", age_minimum AS "Age minimum", ville AS "Ville", tags AS "Tags", difficultés AS "Difficultés" FROM escape_game ORDER BY id_escape DESC LIMIT ' . $limit . ';';
    $escapes = $this->execReq($req);
    return is_array($escapes) ? $escapes : array();
  }

  /*******************************************************
      Retourne la description d'un escape
    Entrée : 
      idEscape [string] : Identifiant de l'escape
  
    Retour : 
      [array] : Tableau associatif contenant les attributs de l'escape
  *******************************************************/
  public function getEscape($idEscape) {
    $req = 'SELECT id_escape AS "Code", nom AS "Nom", description AS "Description", longitude AS "Longitude", latitude AS "Latitude", nb_participants_max AS "Nombre de participants maximum", age_minimum AS "Age minimum", ville AS "Ville", tags AS "Tags", difficultés AS "Difficultés" FROM escape_game WHERE id_escape=?;';
    $resultat = $this->execReqPrep($req, array($idEscape));
    return (is_array($resultat) && isset($resultat[0])) ? $resultat[0] : array();
  }

  /*******************************************************
  Retourne les versions (durée, prix) disponibles pour un escape
  *******************************************************/
  public function getVersions($id_escape) {
    $req = 'SELECT id_version AS "id_version", nom AS "nom", description AS "description", durée AS "duree", prix AS "prix" FROM version WHERE id_escape = ? ORDER BY prix;';
    $resultat = $this->execReqPrep($req, array($id_escape));
    return is_array($resultat) ? $resultat : array();
  }

  /*******************************************************
  Ajoute un escape dans la base de données
  Retour : [string] id de l'escape créé
  *******************************************************/
  public function addEscape($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés) {
    $difficultés = (int) $difficultés;
    $req = 'INSERT INTO escape_game (nom, description, longitude, latitude, nb_participants_max, age_minimum, ville, tags, difficultés) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);';
    $this->execReqPrep($req, array($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés));
    $id_escape = $this->lastInsertId();
    $this->creerVersionsParDefaut($id_escape);
    return $id_escape;
  }

  /*******************************************************
  Crée les 3 packs par défaut pour un escape (Télégraphe, Archive, Immersion)
  *******************************************************/
  public function creerVersionsParDefaut($id_escape) {
    $packs = array(
      array('Pack Télégraphe', 'Immersion Digitale : Votre smartphone est votre seul outil de décryptage.', '1h', 10),
      array('Pack Archive', 'Vous imprimez vous-même vos documents pour une expérience personnalisée.', '1h', 15),
      array('Pack Immersion', 'Mis en place par l\'équipe avec de vrais objets pour une immersion totale.', '1h', 25)
    );
    $req = 'INSERT INTO version (nom, description, durée, prix, id_escape) VALUES (?, ?, ?, ?, ?);';
    foreach ($packs as $p) {
      $this->execReqPrep($req, array($p[0], $p[1], $p[2], $p[3], $id_escape));
    }
  }


  /*******************************************************
  Garantit que l'escape a bien 3 packs (Pas cher, Moyen, Cher).
  Ajoute les packs manquants si besoin (ex. escape créé à la main ou ancienne BDD).
  *******************************************************/
  public function ensureTroisPacks($id_escape) {
    $versions = $this->getVersions($id_escape);
    if (count($versions) >= 3) {
      return;
    }
    $prixExistants = array();
    foreach ($versions as $v) {
      $prixExistants[(int) ($v['prix'] ?? 0)] = true;
    }
    $packs = array(
      array('Pack Télégraphe', 'Immersion Digitale : Votre smartphone est votre seul outil de décryptage.', '1h', 10),
      array('Pack Archive', 'Vous imprimez vous-même vos documents pour une expérience personnalisée.', '1h', 15),
      array('Pack Immersion', 'Mis en place par l\'équipe avec de vrais objets pour une immersion totale.', '1h', 25)
    );
    $req = 'INSERT INTO version (nom, description, durée, prix, id_escape) VALUES (?, ?, ?, ?, ?);';
    foreach ($packs as $p) {
      $prix = (int) $p[3];
      if (empty($prixExistants[$prix])) {
        $this->execReqPrep($req, array($p[0], $p[1], $p[2], $p[3], $id_escape));
        $prixExistants[$prix] = true;
      }
    }
  }

  /*******************************************************
  Met à jour la photo de couverture d'un escape
  Entrée : id_escape [int] identifiant de l'escape
  Utilise $_FILES['photoCouverture']
  *******************************************************/
  public function updatePhotoCouverture($id_escape) {
    if (!isset($_FILES['photoCouverture']) || $_FILES['photoCouverture']['error'] != UPLOAD_ERR_OK) {
      $code = isset($_FILES['photoCouverture']['error']) ? $_FILES['photoCouverture']['error'] : -1;
      throw new Exception("Photo de couverture : échec du transfert (code erreur : " . $code . ")");
    }
    if ($_FILES['photoCouverture']['size'] > 1500000) {
      throw new Exception("Photo de couverture : fichier trop volumineux (max 1.5 Mo)");
    }
    $infosFichier = new SplFileInfo($_FILES['photoCouverture']['name']);
    $extension_upload = strtolower($infosFichier->getExtension());
    $extensions_autorisees = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp');
    if (!in_array($extension_upload, $extensions_autorisees)) {
      throw new Exception("Photo de couverture : type non autorisé. Formats acceptés : JPG, PNG, GIF, WEBP, BMP");
    }
    $dir = dirname(__DIR__) . '/' . Config::PHOTOESCAPEDIR;
    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
    }
    $formats = array('png', 'jpg', 'jpeg', 'gif', 'webp', 'bmp');
    foreach ($formats as $format) {
      $ancienFichier = $dir . '/' . $id_escape . '.' . $format;
      if (is_file($ancienFichier)) {
        unlink($ancienFichier);
      }
    }
    move_uploaded_file($_FILES['photoCouverture']['tmp_name'], $dir . '/' . $id_escape . '.' . $extension_upload);
  }

  /*******************************************************
  Met à jour un escape dans la base de données
  *******************************************************/
  public function updateEscape($idEscape, $nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés) {
    $difficultés = (int) $difficultés;
    $req = 'UPDATE escape_game SET nom=?, description=?, longitude=?, latitude=?, nb_participants_max=?, age_minimum=?, ville=?, tags=?, difficultés=? WHERE id_escape=?;';
    $this->execReqPrep($req, array($nom, $description, $longitude, $latitude, $nb_participants_max, $age_minimum, $ville, $tags, $difficultés, $idEscape));
  }

  /*******************************************************
  Supprime un escape dans la base de données et sa photo de couverture
  *******************************************************/
  public function deleteEscape($idEscape) {
    $dir = dirname(__DIR__) . '/' . Config::PHOTOESCAPEDIR;
    $formats = array('png', 'jpg', 'jpeg', 'gif', 'webp', 'bmp');
    foreach ($formats as $format) {
      $fichier = $dir . '/' . $idEscape . '.' . $format;
      if (is_file($fichier)) {
        unlink($fichier);
      }
    }
    $req = 'DELETE FROM escape_game WHERE id_escape=?;';
    $this->execReqPrep($req, array($idEscape));
  }

  /*******************************************************
  Retourne le chemin relatif de la photo de couverture si elle existe
  *******************************************************/
  public static function getCheminPhotoCouverture($id_escape) {
    $dir = dirname(__DIR__) . '/' . Config::PHOTOESCAPEDIR;
    $formats = array('png', 'jpg', 'jpeg', 'gif', 'webp', 'bmp');
    foreach ($formats as $format) {
      $fichier = $dir . '/' . $id_escape . '.' . $format;
      if (is_file($fichier)) {
        return Config::PHOTOESCAPEDIR . '/' . $id_escape . '.' . $format;
      }
    }
    return null;
  }

}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement