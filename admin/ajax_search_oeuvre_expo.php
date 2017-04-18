<?php
				/////////////////////////////////////////
				// AJAX OEUVRE EXPOSITION (24.03.17)/////
				/////////////////////////////////////////


//Connexion à la base de donnée sql
require_once('../includes/config/config.php');
require_once('../includes/config/functions.php');

// On appel seulement la classe oeuvre et artist pour login.php
require_once('../includes/classes/oeuvre.php');
require_once('../includes/classes/artist.php');
require_once('../includes/classes/exposition.php');


if(isset($_POST['id_check']) && $_POST['id_check'] != '' && isset($_POST['statut'])) {
	$id_check = $_POST['id_check'];
	$statut = $_POST['statut'];
	$check_expo = new Exposition($id_check);
	$check_expo->setStatut($statut);
}


// On retire une oeuvre de la liste d'une exposition
if(isset($_POST['id_delete']) && $_POST['id_delete'] !='') {

	$oeuvre_delete = $_POST['id_delete'];

	if(isset($_POST['id_expo']) && $_POST['id_expo'] != '') {
		$delete = new Exposition($_POST['id_expo']);
		$delete->delete_oeuvre_expo($oeuvre_delete);
	}
}

// Liste des oeuvres qu'une exposition possède
if(isset($_POST['id_expo']) && $_POST['id_expo'] != '') {

	$expo = new Exposition($_POST['id_expo']); 
	$list = $expo->list_expo_oeuvres();

	if($list == TRUE && $list != '') {
		?>
		<ul class="list-group oeuvre_fixed col-xs-2">
			<li class="list-group-item">
				<h4>Oeuvres de l'exposition</h4>
			</li>
			<?php
		    foreach($list as $o) {
				$oeuvre = new Oeuvre($o['oeuvre_id']);
				echo
				' 
				<li class="list-group-item clearfix list_padding">'.$oeuvre->getNom().'
						<span class="pull-right button-group btn btn-link" title="Supprimer l\'Oeuvre de l\'exposition" >
			        		<span class="glyphicon glyphicon-remove" value="'.$oeuvre->getId().'" id="delete"></span>
			        	</span>
				</li>
				';    
		  	}
		  	?>
	  	</ul>
	  	<?php
	}
}

$list_check = Exposition::list_check();
echo $list_check;




