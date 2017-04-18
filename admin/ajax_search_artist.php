<?php
				////////////////////////////////
				// AJAX ARTIST (24.03.17)/////
				////////////////////////////////


//Connexion à la base de donnée sql
require_once('../includes/config/config.php');
require_once('../includes/config/functions.php');

// On appel seulement la classe user pour login.php
require_once('../includes/classes/artist.php');

// Appel de la config bootstrap
?>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="style/admin.css">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
<?php

if(isset($_POST['q'])) {

	$post = addslashes($_POST['q']);

	$res = sql("SELECT * FROM artist WHERE nom LIKE '$post%' ");

	?>
	<div class="container" id="res_ajax">
		<ul class="list-group col-md-6">
		<?php

		foreach ($res as $artist) {
			
			echo '
				<li class="list-group-item clearfix">
					<strong>'.$artist['nom'].'</strong><br>
					'.$artist['tel'].'<br>
					'.$artist['email'].'<br>
					'.substr($artist['description'],0,125).'<br>
					
					<span class="pull-right button-group">
						
					    <a href="oeuvre.php?id='.$artist['id'].'" class="btn btn-info" data-toggle="tooltip" title="Ajouter une oeuvre à l\'Artiste">
					    	<span class="glyphicon glyphicon-folder-open"></span>
					    </a>

						<a href="artist.php?action=edit&id='.$artist['id'].'" class="btn btn-primary" data-toggle="tooltip" title="Modifier l\'Artiste">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>

					    <a href="artist.php?action=delete&id='.$artist['id'].'" class="btn btn-warning" data-toggle="tooltip" title="Supprimer l\'Artiste">
					    	<span class="glyphicon glyphicon-trash"></span>
					    </a>

				    </span>
				</li>';
		}
		?>
		</ul>
	</div>
	<?php
	
}

include('footer.php');






