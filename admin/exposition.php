<?php
			/////////////////////////////////
			// exposition.php (24.03.17)/////
			/////////////////////////////////

require_once ("header.php");


// Condition pour mettre en ligne une exposition (l'expo doit être validée avant d'être publiée)
if(isset($_GET['id_publier']) && $_GET['id_publier'] != '') {
	$expo_publier = new Exposition($_GET['id_publier']);
	$statut = $expo_publier->getStatut();
	if($statut == 0) {
		echo "<strong>Votre exposition ".$expo_publier->getTitre()." ne peut être publiée. Vous devez d'abord signaler qu'elle est complète</strong>";
	}

	else {
		$publier = 1;
		$expo_publier->setPublier($publier);
		echo "<strong>Votre exposition ".$expo_publier->getTitre()." vient d'être mise en ligne ainsi que toutes les oeuvres associées</strong>";
	}

}

if(isset($_GET['id_publier_delete']) && $_GET['id_publier_delete'] != '') {
	$expo_publier = new Exposition($_GET['id_publier_delete']);
	$publier = $expo_publier->getPublier();

	if($publier == 1) {
		$publier = 0;
		$expo_publier->setPublier($publier);
		echo "<strong>Votre exposition ".$expo_publier->getTitre()." viens d'être retiré de votre plateforme de diffusion</strong>";
	}
	else {
		echo "<strong>Votre exposition ".$expo_publier->getTitre()." n'est pas encore en ligne</strong>";
	}
}


$list = Exposition::listExpo();
?>

<div class="container">

	<div class="row col-md12">

		<h3 class="color_header">Liste des Expositions</h3>

	</div>

	<h4><a href="edit_exposition.php?action=edit" style="text-decoration: none;">
			<span class="glyphicon glyphicon-plus-sign"></span>
			Ajouter une Exposition
		</a> 
		
	</h4><br>

	<div class="row">

		<ul class="list-group col-md-9">
				<?php 
				foreach($list as $e) {
				?>
					<li class="list-group-item clearfix">
						<div class="row">
							<strong class="col-md-4 border">Exposition <?= $e->getTitre() ?></strong>
							
							<label class="switch col-md-2 col-md-offset-7" data-toggle="tooltip" title="Signaler que l'exposition est complète">
									
								<form action="exposition.php" action="get">	
									<input type="checkbox" name="check" value="<?= $e->getId() ?>" >
									<div class="slider round" ></div>
								</form>
									
							</label>

						</div><br>
						
						<span>Date de début : </span><strong><?= format_date($e->getDebutExpo()) ?></strong><br>
						<span>Date de fin : </span><strong><?= format_date($e->getFinExpo()) ?></strong><br>
						
						<br><?= substr($e->getDescription(),0,250) ?><br><br>

						<div class="row">

						<span class="pull-left button-group col-md-4 ">

							<a href="apercu_exposition.php?id_expo=<?= $e->getId()?>" class="btn btn-info" data-toggle="tooltip" title="Aperçu de l'exposition">
							<span class="glyphicon glyphicon-search"></span>	
							</a>

							
							<a href="liste_oeuvre.php?id_expo=<?= $e->getId()?>" class="btn btn-primary" data-toggle="tooltip" title="Ajouter des oeuvres à l'exposition">
								<span class="glyphicon glyphicon-folder-open"></span>	
							</a>

							<a href="gallery.php?id_map=<?= $e->getId() ?>" class="btn btn-primary" data-toggle="tooltip" title="Positionner les oeuvres">
								<span class="glyphicon glyphicon-map-marker"></span>
							</a>
							
							<a href="edit_exposition.php?action=edit&id=<?= $e->getId() ?>" class="btn btn-primary" data-toggle="tooltip" title="Modifier l'exposition">
								<span class="glyphicon glyphicon-pencil"></span>
							</a>

					
							<a href="edit_exposition.php?action=delete&id=<?= $e->getId() ?>" class="btn btn-warning" data-toggle="tooltip" title="Supprimer l'exposition"  onclick="return confirm('Êtes vous sur de vouloir supprimer cette exposition?');">
								<span class="glyphicon glyphicon-trash"></span>
							</a>

						</span>

						

						<a href="exposition.php?id_publier=<?= $e->getId() ?>">
						<button type="button" class="col-md-2 col-md-offset-4 btn btn-primary" data-toggle="tooltip" title="Mettre l'exposition en ligne sur votre plateforme de diffusion" onclick="return confirm('Êtes vous sur de vouloir mettre cette exposition en ligne');">Publier l'exposition</button>
						</a>

						<a href="exposition.php?id_publier_delete=<?= $e->getId() ?>">
						<button type="button" class="col-md-2 btn btn-warning" data-toggle="tooltip" title="Retirer l'exposition de votre plateforme de diffusion" onclick="return confirm('Êtes vous sur de vouloir retirer l\'exposition de votre plateforme de diffusion?');">Retirer l'exposition</button>
						</a>

						

						</div>

					</li>
					
				<?php
				}
				?>
			
		</ul>

	</div>	
	
</div>		

<?php

include('footer.php');
			
			
