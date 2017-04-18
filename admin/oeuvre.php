<?php
			////////////////////////////////
			// Espace OEUVRE (01.04.17)/////
			////////////////////////////////



require_once("header.php");


// On stocke l'id de l'artiste
$artiste = new Artist($_GET['id']);
$artiste_id = $_GET['id'];

// Boucle pour supprimer une oeuvre
if(isset($_GET['action']) && $_GET['action'] == 'delete' && $_GET['id_oeuvre'] != '') {
	$oeuvre = new Oeuvre($_GET['id_oeuvre']);
	$oeuvre->deleteOeuvre();
}

?>
<!-- Page précédente -->
<a href="artist.php">Revenir à la liste des Artistes</a>

<!-- Présentation de l'artiste -->
<h3 class="color_header"><?= $artiste->getNom(); ?></h3>
<text>Description de l'artiste :</text><br><br>
<p><?php echo $artiste->getDescription(); ?></p><br>


<h4 class="color_header">Liste des oeuvres de l'artiste</h4><br>

<!-- Lien pour ajouter une oeuvre à l'artiste -->
<a href="edit_oeuvre.php?id=<?php echo $artiste->getId(); ?>">Ajouter une nouvelle oeuvre à l'artiste</a><br>

<!-- Si on a l'id de l'artiste dans le GET -->
<?php
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$list = Oeuvre::listOeuvreArtiste($id);

	// On vérifie si l'artiste possède une liste d'oeuvre
	if($list != '') {

		?><?php
			foreach ($list as $u) {
								
				echo '
				<div class="thumbnail col-md-4" style="height:650px;">
				
					<a href=oeuvre.php?action=delete&id='.$artiste->getId().'&id_oeuvre='.$u['id'] .'>
						<span class="glyphicon glyphicon-remove del_glyph" data-toggle="tooltip" title="Supprimer l\'Oeuvre"></span>
					</a>
					<p class="text-center"><strong>'.$u['nom'].'</strong></p>
					<p class="text-center">Oeuvre numéro '.$u['numero'].'</p>
					<p class="text-center">Dimension : '.$u['dimension'].'</p>
					<p class="text-center">Arrivée sur site le : '.format_date($u['oeuvre_in']).'</p>



					<a href="edit_oeuvre.php?id='.$artiste_id.'&oeuvre='.$u['id'].'"><img src="'.$u['photo'].'" data-toggle="tooltip" title="Modifier cette Oeuvre"></a>

					<a href="'.$u['qr_code'].'" data-toggle="tooltip" title="Imrpimer le Qr-Code de l\'oeuvre" download><img src="'.$u['qr_code'].'" ></a>


				</div>';

			}
	}
}



require_once('footer.php');

