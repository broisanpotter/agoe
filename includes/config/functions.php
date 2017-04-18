<?php

function sql($request) {
    $db = new mysqli(sql_server, sql_user, sql_password, sql_database);
    $resultat = $db->query($request);
    /*
    $resultat vaut : 
    - FALSE en cas d'échec
    - TRUE pour une requête INSERT, UPDATE ou DELETE
    - un objet de la classe mysqli_result pour une requête SELECT 
    - http://php.net/manual/fr/class.mysqli-result.php
    */
    
    
    if($resultat === FALSE) {
        return FALSE;
    }
    elseif($resultat === TRUE) {
        if(preg_match("/INSERT/", $request) && $resultat) {
            return $db->insert_id;
        }
        else {
            return TRUE;
        }
    }
    else {
        $array = array();
        while($res = $resultat->fetch_assoc()) {
            array_push($array, $res);
        }
        return $array;
    }
}

function format_date($str) {
    $mois = array('Janvier','Février','Mars','Avril','Mai','juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');

    $tableau = explode(' ', $str);
    $date = explode('-', $tableau[0]);
   
    return $date[2].' '.$mois[$date[1]-1].' '.$date[0];
   
}

