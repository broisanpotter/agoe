<?php

                ///////////////////////////////
                // OEUVRE FRONT (04.04.17)/////
                ///////////////////////////////


require_once('header_front.php');


if(isset($_GET['id_oeuvre']) && $_GET['id_oeuvre'] !='') {
	$id = $_GET['id_oeuvre'];
	$oeuvre = new Oeuvre($id);
	?>
	<div class="container">
		<div class="row">
			<a href="index.php" class="col-xs-1 glyphicon glyphicon-chevron-left back_front" style="text-decoration: none;"></a>
			<h1 class="text-center artiste_title_front col-xs-11"><?= $oeuvre->getNom() ?></h1>
		</div>

		<div class="row">
			<img src="<?= $oeuvre->getPhoto() ?>" class="img-thumbnail col-xs-6" width="304" height="236">
			<div class="col-xs-5 col-xs-offset-1 artiste_front_right"><?= $oeuvre->getDescription() ?></div>
		</div>
		<?php
		$artiste_id = $oeuvre->getArtistId();
		$artiste = new Artist($artiste_id);
		?>
		<div class="row">
			<div class="artiste_front ">
				<div><h4><strong><?= $artiste->getNom() ?></strong></h4></div>
				<div><?= $artiste->getDescription() ?></div>
			</div>
		</div>
	</div>
	<?php
}