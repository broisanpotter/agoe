<?php
				/////////////////////////////////////////
				// AJAX MAP EXPOSITION (24.03.17)////////
				/////////////////////////////////////////


//Connexion à la base de donnée sql
require_once('../includes/config/config.php');
require_once('../includes/config/functions.php');

// On appel seulement la classe oeuvre et artist pour login.php
require_once('../includes/classes/oeuvre.php');
require_once('../includes/classes/artist.php');
require_once('../includes/classes/exposition.php');


if(isset($_POST['id_expo_map']) && $_POST['id_expo_map'] !='') {
	$expo = new Exposition($_POST['id_expo_map']);
	$expo->list_map_position();
}


if(isset($_POST['map_id']) && $_POST['map_id'] != '' && isset($_POST['oeuvre_id']) && $_POST['oeuvre_id'] != '' && isset($_POST['id_expo_map']) && $_POST['id_expo_map'] !=''){
	$map_id = $_POST['map_id'];
	$oeuvre_id = $_POST['oeuvre_id'];
	$id_expo = $_POST['id_expo_map'];
	$exposition = new Exposition($id_expo);
	$exposition->push_map_position($map_id, $oeuvre_id);

}

