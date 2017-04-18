<?php
				//////////////////////////////
				// AJAX OEUVRE (24.03.17)/////
				//////////////////////////////


//Connexion à la base de donnée sql
require_once('../includes/config/config.php');
require_once('../includes/config/functions.php');

// On appel seulement la classe oeuvre et artist pour login.php
require_once('../includes/classes/oeuvre.php');
require_once('../includes/classes/artist.php');
require_once('../includes/classes/exposition.php');


// On test si la requete Ajax a bien envoyer en POST les var 'tab' et 'id_expo'
if(isset($_POST['tab']) && $_POST['tab'] != '' && isset($_POST['id_expo']) && $_POST['id_expo'] != '') {
	$tab = $_POST['tab'];
	$id_expo = $_POST['id_expo'];
	
	foreach ($tab as $key) {
		$push_oeuvre = new Exposition();
		$push_oeuvre->push_oeuvre(intval($key), intval($id_expo));
	}
}

else {
	// Appel de la fonction statique qui permet de lister toutes les oeuvres
	$list = Oeuvre::listOeuvre();

	if($list != '') {

		foreach ($list as $u) {

			$artist_id = new Artist($u['artist_id']);

			echo '
			
			<div class="thumbnail col-md-4" value="'.$u['id'].'" style="height:450px;">
			
				<p class="text-center">Nom de l\'oeuvre : '.$u['nom'].'</p>
				<p class="text-center">Nom de l\'artiste : '.$artist_id->getNom().'</p>
				<img  src="'.$u['photo'].'">

			</div>';
		}
	}	
}