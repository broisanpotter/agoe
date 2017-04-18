<?php

                ///////////////////////////////////////
                // PAGE D'ACCUEIL FRONT (02.04.17)/////
                ///////////////////////////////////////


require_once('header_front.php');



$res = Exposition::list_exposition_front();
$count_expo = count($res);

if($res != '') {

	// Conpteur de tour pour modifier l'id du Carousel
	$j = 0;

	foreach ($res as $exposition) {
		?>
		<div class="row">
			<?php
			$exposition = new Exposition($exposition['id']);
			$list_oeuvre = $exposition->list_oeuvre_front();

			if($list_oeuvre != '') {
				$count = count($list_oeuvre);
				?>
				<div class="row">
					<h1 class="text-center color_header col-xs-4 col-xs-offset-2">Exposition <?= $exposition->getTitre(); ?></h1>
				</div>

				<div class="row">
					<div class="text-center color_header col-xs-4 col-xs-offset-2"><em>Début de l'exposition le <?= format_date($exposition->getDebutExpo()) ?><br>Fin de l'exposition le <?= format_date($exposition->getFinExpo()) ?></em></div>
				</div><br>
					
				<div id="myCarousel<?=$j?>" class="carousel slide" data-ride="carousel">

					<ol class="carousel-indicators">
						<?php
						for($i = 0; $i <$count; $i++) {
							?>
							<li data-target="#myCarousel<?=$j?>" data-slide-to="<?= $i ?>"></li>
							<?php
						}
						?>
					</ol>

					<div class="carousel-inner" role="listbox">

						<?php
						foreach ($list_oeuvre as $key => $oeuvre) {
							$oeuvre = new Oeuvre($oeuvre['id']);
							$photo = $oeuvre->getPhoto();
							$titre = $oeuvre->getNom();
							$description = $oeuvre->getDescription();
							
							if($key == 0) {
								echo '
								<div class="item active">
									<a href="oeuvre.php?id_oeuvre='.$oeuvre->getId().'">
							      		<img src="'.$photo.'" alt="'.$titre.'" style="height: 450px; width:350px;">
							      		<div class="carousel-caption">
									       <h3 style="color: white;"><em>'.$titre.'</em></h3>
									       <p style="color: white;"><em>'.substr($description,0,30).'(...)</em></p>
			      						</div>
			      					</a>
						    	</div>
						    	';
							} 
							else {
								echo '
								<div class="item">
									<a href="oeuvre.php?id_oeuvre='.$oeuvre->getId().'">
							      		<img src="'.$photo.'" alt="'.$titre.'" style="height: 450px; width:350px;">
							      		<div class="carousel-caption">
									       <h3 style="color: white;"><em>'.$titre.'</em></h3>
									       <p style="color: white;"><em>'.substr($description,0,30).'(...)</em></p>
			      						</div>
						    		</a>
							    </div>
						    	';
							}
						}
						?>
					</div>

					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel<?=$j?>" role="button" data-slide="prev">
					    <span class="glyphicon glyphicon-chevron-left glyphicon-front" aria-hidden="true"></span>
					    <span class="sr-only">Previous</span>
					</a>

					<a class="right carousel-control" href="#myCarousel<?=$j?>" role="button" data-slide="next">
					    <span class="glyphicon glyphicon-chevron-right glyphicon-front" aria-hidden="true"></span>
					    <span class="sr-only">Next</span>
					</a>

				</div>
			<?php
			}
			?>
		</div><br>
		<?php
		$j = $j +1;
	}
}
else {
	echo "Aucune exposition n'est pour l'instant mise en ligne";
}

require_once('footer_front.php');