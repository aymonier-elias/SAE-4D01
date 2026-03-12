<?php
/**
 * Génération de tableaux HTML (table, thead, tbody, tfoot, tr, th, td).
 * Méthodes statiques pour construire un tableau ligne par ligne ou en bloc.
 */
class Tableau{

    /**
     * Construit une ligne de tableau (<tr>) à partir d'un tableau de valeurs.
     * @param array $data Valeurs des cellules
     * @param string $tag Balise de cellule : 'td' (données) ou 'th' (en-tête)
     * @return string HTML d'une ligne <tr>...</tr>
     */
    public static function row($data, $tag='td'){
        $reponse ="";

        foreach($data as $value){
            $reponse .= "<$tag>$value</$tag>";
        }

        return '<tr>'. $reponse .'</tr>';
    }

    /**
     * Début du tableau avec en-tête optionnel.
     * @param array $data En-têtes de colonnes (utilise <th>), vide pour pas d'en-tête
     * @param string $tableClass Classe CSS optionnelle sur <table>
     * @return string Balise <table> et éventuellement <thead>
     */
    public static function head($data = [], $tableClass = '') {
        $attr = $tableClass !== '' ? ' class="' . htmlspecialchars($tableClass) . '"' : '';
        if ($data) {
            return '<table' . $attr . '><thead>' . self::row($data, 'th') . '</thead>';
        }
        return '<table' . $attr . '>';
    }

    /**
     * Corps du tableau : plusieurs lignes de données (<td>).
     * @param array $data Tableau de lignes (chaque ligne = tableau de cellules)
     * @return string HTML <tbody>...</tbody>
     */
    public static function body($data){
        $reponse = "";
        foreach($data as $ligne){
            $reponse .= self::row($ligne);
        }
        return '<tbody>'. $reponse .'</tbody>';
    }

    /**
     * Pied du tableau optionnel et fermeture de <table>.
     * @param array $data Ligne de pied (cellules en <th>), vide pour seulement fermer </table>
     * @return string <tfoot>...</tfoot></table> ou </table>
     */
    public static function foot($data=[]){
        if($data){
            return "<tfoot>". self::row($data, 'th') ."</tfoot></table>";
        }
        else
            return '</table>'  ;   
    }
}

