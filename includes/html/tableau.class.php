<?php

class Tableau{

    public static function row($data, $tag='td'){
        $reponse ="";

        foreach($data as $value){
            $reponse .= "<$tag>$value</$tag>";
        }

        return '<tr>'. $reponse .'</tr>';
    }


    public static function head($data = [], $tableClass = '') {
        $attr = $tableClass !== '' ? ' class="' . htmlspecialchars($tableClass) . '"' : '';
        if ($data) {
            return '<table' . $attr . '><thead>' . self::row($data, 'th') . '</thead>';
        }
        return '<table' . $attr . '>';
    }


    public static function body($data){
        $reponse = "";
        foreach($data as $ligne){
            $reponse .= self::row($ligne);
        }
        return '<tbody>'. $reponse .'</tbody>';
    }

    public static function foot($data=[]){
        if($data){
            return "<tfoot>". self::row($data, 'th') ."</tfoot></table>";
        }
        else
            return '</table>'  ;   
    }
}

