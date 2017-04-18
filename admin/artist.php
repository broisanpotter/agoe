<?php
				////////////////////////////////
				// Espace ARTIST (24.03.17)/////
				////////////////////////////////



require_once("header.php");

// SUPPRESSION D'UN COMPTE SI $_GET DELETE
if(isset($_GET['action']) && $_GET['action'] == 'delete') {
	$delete = new Artist($_GET['id']);
	$delete->delete($_GET['id']);
}

// UPDATE OU INSERT D'UN ARTISTE
if(isset($_POST['name']) && $_POST['name'] != '') {

	// Formulaire n'ayant pas d'ID = INSERT
	if(empty($_POST['id'])) {
		$artist = new Artist();

		$artist->setNom($_POST['name']);
        $artist->setDescription($_POST['description']);
        $artist->setEmail($_POST['email']);
        $artist->setTel($_POST['tel']);
        $artist->push();
        echo '<strong>Vous avez bien créé un nouvel Artiste dans la Base de Donnée</strong>';
    }    
	// Formulaire ayant déjà un id = UPDATE
	else {
		$artist = new Artist($_POST['id']);
		$artist->setNom($_POST['name']);
        $artist->setDescription($_POST['description']);
        $artist->setEmail($_POST['email']);
        $artist->setTel($_POST['tel']);
        $artist->push();
        echo '<strong>Vous avez bien modifé l\'Artiste '.$artist->getNom().'</strong>';
	}
}

?>
<!-- Gestion des Artistes (CRUD + Formulaire de recherche) -->
<div class="container">

	<div class="row col-md-12">
		<h3 class="color_header">Artistes exposant</h3><br>
	</div>

	<div class="row ">
	
		<!-- Formulaire de recherche d'Artiste -->
		<form class="ajax col-md-5" action="artist.php" method="post">
			<p>
				<label for="q">Rechercher un artiste</label>
				<input type="text" name="q" id="q" />
			</p>
		</form>

		<!-- Lien pour créer un nouvel Artiste -->
		<div class="col-md-3 col-md-offset-2">
			<button type="button" class="btn btn-info" >
				<a style="color: white; text-decoration: none;" href="artist.php?action=edit">Ajouter un artiste</a>
			</button>
		</div>

	</div>
	
</div><br>

	<!-- Div ou arrive la recherche la response suite à la demande Ajax-->
	<span id="results"></span>

<?php
// Fonction statique qui liste tout les utilisateurs
$list = Artist::listArtist();
?>

<div class="container" id="ask_ajax">

	<div class="row">

		<ul class="list-group col-md-6">
		<?php
		foreach ($list as $a) {
			?>
				<li class="list-group-item clearfix">

					<strong><?= $a->getNom() ?></strong><br>
					<?= $a->getTel() ?><br>
					<?= $a->getEmail() ?><br>
					<?= substr($a->getDescription(), 0, 125) ?><br>

					<span class="pull-right button-group">

			        	<a href="oeuvre.php?id=<?= $a->getId() ?>" class="btn btn-info" data-toggle="tooltip" title="Ajouter une oeuvre à l'Artiste">
			        		<span class="glyphicon glyphicon-folder-open"></span>
			        	</a>
				    	
				    	<a href="artist.php?action=edit&id=<?= $a->getId() ?>" class="btn btn-primary" data-toggle="tooltip" title="Modifier l'Artiste">
				    		<span class="glyphicon glyphicon-pencil" ></span>
				    	</a>
				    	
			        	<a href="artist.php?action=delete&id=<?= $a->getId() ?>" class="btn btn-warning" data-toggle="tooltip" title="Supprimer l'Artiste" onclick="return confirm('Êtes vous sur de vouloir supprimer cet Artiste?');">
			        		<span class="glyphicon glyphicon-trash"></span>
			        	</a>

			        </span>
			        
				</li>
				<?php
		}
		?>
		</ul>
		<?php
		// AFFICHER LE FORMULAIRE SI $_GET EDIT
		if(isset($_GET['action']) && $_GET['action'] == 'edit') {
			
			if(isset($_GET['id']) && $_GET['id'] !='') {
				$form = new Artist($_GET['id']);
				$form->form();
			}
			// Si on a pas d'ID on ouvre un formulaire vide
			else {
				$form = new Artist();
				$form->form();
			}
		}
		?>
	</div>

</div>

<?php

require_once('footer.php');




