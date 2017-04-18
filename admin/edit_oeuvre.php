<?php
			/////////////////////////////////////
			// Espace EDIT_OEUVRE (24.03.17)/////
			/////////////////////////////////////

require_once('header.php');

include('../includes/classes/phpqrcode/qrlib.php');



// Ssi on a l'id en GET on la stocke dans un $_SESSION
if(isset($_GET['id']) && $_GET['id'] != '') {
	$_SESSION['artiste_id'] = $_GET['id'];
}

// Si on a 'oeuvre' et 'id' en GET alors on crée un new form avec les infos liées à l'id
if(isset($_GET['oeuvre']) && isset($_GET['id'])) {
	$oeuvre = new Oeuvre($_GET['oeuvre']);
	$oeuvre->form();
}

// A l'inverse new form vide
else {
	$oeuvre = new Oeuvre();
	$oeuvre->form();
}

// CREATE et UPDATE d'une oeuvre
if(isset($_POST['nom']) && $_POST['nom'] != '') {

	// CREATE
	if(empty($_POST['id'])) {

		$oeuvre = new Oeuvre();
		$oeuvre->setNom($_POST['nom']);
		$oeuvre->setNumero();
		$oeuvre->setDescription($_POST['description']);
		$oeuvre->setOeuvreIn($_POST['oeuvre_in']);
		$oeuvre->setOeuvreOut($_POST['oeuvre_out']);
		$oeuvre->setPhoto($_FILES);
		$oeuvre->setArtistId($_SESSION['artiste_id']);
		$oeuvre->setCategorieId($_POST['categorie_id']);
		$oeuvre->setDimension($_POST['dimension']);
		
		$res = $oeuvre->push();
		$lien = $oeuvre->setQrCode();

		if($res != FALSE) {
			echo "Vous avez bien enregistré votre oeuvre";			
		}

		else {
			echo "Erreur lors de l'enregistrement de votre nouvelle oeuvre";
		}

	}

	// UPDATE
	else {

		$oeuvre = new Oeuvre($_POST['id']);
		$oeuvre->setNom($_POST['nom']);
		$oeuvre->setDescription($_POST['description']);
		$oeuvre->setOeuvreIn($_POST['oeuvre_in']);
		$oeuvre->setOeuvreOut($_POST['oeuvre_out']);
		
		if($_FILES['imageNew']['name'] != FALSE) {
			$oeuvre->setPhoto($_FILES);
		}
		
		$oeuvre->setArtistId($_SESSION['artiste_id']);
		$oeuvre->setCategorieId($_POST['categorie_id']);
		$oeuvre->setDimension($_POST['dimension']);

		$res = $oeuvre->push();

		if($res != FALSE) {
			echo "Vous avez bien enregistré votre oeuvre";
		}

		else {
			echo "Echec lors de l'enregistrement de votre oeuvre";
		}
	}
}

?>

<!-- Lien pour retourner à la page précédente -->
<br><a href="oeuvre.php?id=<?php echo $_SESSION['artiste_id']; ?>">Retourner à la page précédente</a><br>

<?php

require_once('footer.php');
