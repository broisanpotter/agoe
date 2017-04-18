<?php
				///////////////////////////////
				// LISTE_OEUVRE (24.03.17)/////
				///////////////////////////////



include('header.php');

?>

<div class="row">

        <!-- Page précédente -->
        <a href="exposition.php">Revenir à la liste des expositions</a>

</div><br>


<!-- Selection d'oeuvre pour une exposition -->
<br><div class="container">

		<div class="row ">

			<!-- Titre de l'exposition -->
			<div class="col-md-11 col-md-offset-1 color_header">
				<?php 
				if(isset($_GET['id_expo']) && $_GET['id_expo'] != '') {
					$titre_expo = new Exposition($_GET['id_expo']);
					echo '<strong class="title_exposition">'.$titre_expo->getTitre().'</strong>'; 
				}
				?>
			</div><br><br>

		</div>

		<div class="row ">
				<strong class="col-md-11 col-md-offset-1 color_header">
					Sélectionner les oeuvres que vous souhaitez ajouter à l'exposition <?= $titre_expo->getTitre() ?>
				</strong>
		</div>

		<div class="row">

			<!-- Zone d'écriture des retour de sauvegarde ou d'erreur -->
			<div class="col-md-3 col-md-offset-1" id="error_succes"></div>
			
			<!-- Bouton pour valider une exposition -->
			<button type="button" class="btn btn-info col-md-2 col-md-offset-6 btn_shadow" id="valider_liste">Valider la séléction</button>
		
		</div>

</div><br>
  
<!-- Div ou arrive la requete Ajax => Liste de toutes les oeuvres de tous les artistes -->
<div class="container">

	<div class="row">
		<!-- Div ou arrive la requete ajax -->
		<div class="liste_oeuvre col-xs-11 col-md-offset-1" id="liste_oeuvre"></div>
	</div>

</div>

<!-- Div ou arrive la liste des oeuvres qui sont déjà ajoutées à l'utilisateur -->
<div class="container" id="oeuvre_expo">

	<div class="row">
		<div class="" id="title_expo"></div>
	</div>
	
</div>


<?php
require_once('footer.php');