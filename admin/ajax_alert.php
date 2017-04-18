<?php
				///////////////////////////////////////////
				// AJAX ALERT EXPOSITION (24.03.17)////////
				///////////////////////////////////////////


//Connexion à la base de donnée sql
require_once('../includes/config/config.php');
require_once('../includes/config/functions.php');

// On appel seulement la classe oeuvre et artist pour login.php
require_once('../includes/classes/oeuvre.php');
require_once('../includes/classes/artist.php');
require_once('../includes/classes/exposition.php');



 $res = Exposition::alert_exposition();
 
 if($res != '') {
 	echo $res;
 }
