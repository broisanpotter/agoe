<?php


      ///////////////////////////////////
      // OEUVRE_CATEGORIE (24.03.17)/////
      ///////////////////////////////////

require_once('header.php');


// SUPPRESSION D'UNE CATEGORIE SI $_GET DELETE
if(isset($_GET['action']) && $_GET['action'] == 'delete') {
	$delete = new OeuvreCategorie($_GET['id']);
	$delete->delete($_GET['id']);
}

// UPDATE OU INSERT D'UNE CATEGORIE
if(isset($_POST['name']) && $_POST['name'] != '') {

	// Formulaire n'ayant pas d'ID = INSERT
	if(empty($_POST['id'])) {
		$categorie = new OeuvreCategorie();
		$categorie->setNom($_POST['name']);
        $categorie->push();
        echo 'Vous avez bien créé un nouvelle catégorie';
    }

	// Formulaire ayant déjà un id = UPDATE
	else {
		$categorie = new OeuvreCategorie($_POST['id']);
		$categorie->setNom($_POST['name']);
        $categorie->push();
        echo 'Vous avez bien modifé la catégorie '.$categorie->getNom();
	}
}

?>
<!-- Gestion des catégories CRUD -->
<div class="container">

	<div class="row col-md-12">
		<h3 class="color_header">Catégories des oeuvres</h3>
	</div>

	<div class="row col-md-12">
		<h4>
			<a href="edit_categorie.php?action=edit" style="text-decoration:none;">
				<span class="glyphicon glyphicon-plus-sign"></span>
				Ajouter une nouvelle catégorie
			</a> 
		</h4>
	</div>

</div><br>

<?php

// Fonction statique qui liste toutes les catégories
$list = OeuvreCategorie::listOeuvreCategorie();

?>
<div class="container">

	<div class="row">

		<ul class="list-group col-md-8">

		<?php
		foreach ($list as $u) {
			?>
			<li class="list-group-item clearfix">
				<?= $u->getNom() ?>
		    	<span class="pull-right button-group">
		    	
			    	<a href="edit_categorie.php?action=edit&id=<?= $u->getId() ?>" class="btn btn-primary" data-toggle="tooltip" title="Modifier la catégorie">
			    		<span class="glyphicon glyphicon-pencil"></span>
			    	</a>
			        
			        <a href="edit_categorie.php?action=delete&id=<?= $u->getId() ?>" class="btn btn-warning" data-toggle="tooltip" title="Supprimer la catégorie"  onclick="return confirm('Êtes vous sur de vouloir supprimer cette Catégorie?');">
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
			
			// Si on a un ID alors on affiche le contenu existant dans le formulaire
			if(isset($_GET['id']) && $_GET['id'] !='') {
				$form = new OeuvreCategorie($_GET['id']);
				$form->form();
			}
			// Si on a pas d'ID on ouvre un formulaire vide
			else {
				$form = new OeuvreCategorie();
				$form->form();
			}
		}
		?>

	</div>
	
</div>

<?php
include('footer.php');
