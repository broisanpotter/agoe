<?php

                /////////////////////////////////
                // PAGE D'ACCUEIL (24.03.17)/////
                /////////////////////////////////


require_once('header.php');

?>

<!-- Liste des derniers ajouts -->

<div class="container">

	<!-- Liste Artiste -->
	<div class="row">
		
		<!-- Liste des derniers ajouts d'artiste -->
		<ul class="list-group col-md-5">
			<h4 class="page-header"><strong>Liste des cinq derniers Artistes ajoutés</strong></h4>
			<?php
			$res = sql("SELECT nom FROM artist ORDER BY id DESC LIMIT 0, 5");

			if($res != '') {
				foreach ($res as $value) {
					$nom = implode(",",$value);
					echo '<li class="list-group-item">L\'Artiste "'.$nom.'" a été ajouté(e)</li>';
				}
			}


			?>
		</ul>

		<!-- Expostion en cours -->
		<div class="col-md-5 col-md-offset-1">
			<h4 class="page-header"><strong>Exposition(s) en cours</strong></h4>

				<ul class="list-group col-md-12">
					<?php 

					$expo_en_cours = Exposition::expo_now();

					if($expo_en_cours != FALSE) {
							foreach ($expo_en_cours as $expo) {
							?>
							<li class="list-group-item">
								<strong><?= $expo['titre']; ?></strong>
								<p>Fin de l'exposition prévue le <?= format_date($expo['fin_expo']) ?></p>
								
							</li>
							<?php
						}
					}

					?>
				</ul>
		</div>

	</div>

	<!-- Liste Exposition -->
	<div class="row">

		<div class="col-md-5">

			<?php
			// Derniers ajouts expos
			$list = Exposition::listExpo();
			
			?><br><h4 class="page-header"><strong>Liste des cinq dernières Expositions ajoutées</strong></h4>
			
			<!-- Liste des derniers ajouts d'exposition avec rappel de la date -->
			<ul class="list-group col-md-12">
				<?php
				foreach ($list as $e) {
				    echo '<li class="list-group-item">L\'Exposition '.$e->getTitre().' a été ajoutée<br> Du '.format_date($e->getDebutExpo()).' Au '.format_date($e->getFinExpo()).'</li>';
				}
				?>
			</ul>

		</div>
	</div>

</div>




<?php
require_once('footer.php');

