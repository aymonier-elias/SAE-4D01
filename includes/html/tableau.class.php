<?php

class Tableau{

    public static function row($data, $tag='td'){
        $reponse ="";

        foreach($data as $value){
            $reponse .= "<$tag>$value</$tag>";
        }

        return '<tr>'. $reponse .'</tr>';
    }


    public static function head($data=[]){
        
        if($data){
             return '<table><thead>'. self::row($data, 'th').'</thead>';
        }
        else
            return '<table>';
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

