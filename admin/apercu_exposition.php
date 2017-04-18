<?php

      ////////////////////////////////////
      // APERCU_EXPOSITION (30.03.17)/////
      ////////////////////////////////////

require_once('header.php');
?>

<div class="row">

        <!-- Page précédente -->
        <a href="exposition.php">Revenir à la liste des expositions</a>

</div><br>

<?php
if(isset($_GET['id_expo']) && $_GET['id_expo'] != '') {
	$expo = new Exposition($_GET['id_expo']);
	?>
	<div class="row color_header apercu_expo">
		
		<div class="text-center"><h2>Exposition "<?= $expo->getTitre() ?>"</h2></div><br>
		<div><strong>Description : </strong><br><br><?= $expo->getDescription() ?></div><br>
		<div><strong>Début de l'exposition : </strong><?= format_date($expo->getDebutExpo()) ?></div><br>
		<div><strong>Fin de l'exposition : </strong><?= format_date($expo->getFinExpo()) ?></div><br>
		
	</div>

	<div class="row">
		<?php

		$list_oeuvre = new Exposition($_GET['id_expo']);
		$list_oeuvre->list_map_position_php();

		?>
	</div>

	<div class="row">
		<div class="map">

			<div class="droppable ui-widget-header map1 text-center" value="1">
			  <p>Emplacement 1</p>
			</div>


			<div class="droppable ui-widget-header map2 text-center" value="2">
			  <p>Emplacement 2</p>
			</div>


			<div class="droppable ui-widget-header map3 text-center" value="3">
			  <p>Emplacement 3</p>
			</div>

			<div class="droppable ui-widget-header map4 text-center" value="4">
			  <p>Emplacement 5</p>
			</div>

			<div class="droppable ui-widget-header map5 text-center" value="5">
			  <p>Emplacement 4</p>
			</div>

			<div class="droppable ui-widget-header map6 text-center" value="6">
			  <p>Emplacement 6</p>
			</div>

			<div class="droppable ui-widget-header map7 text-center" value="7">
			  <p>Emplacement 7</p>
			</div>

			<div class="droppable ui-widget-header map8 text-center" value="8">
			  <p>Emplacement 8</p>
			</div>

			<div class="droppable ui-widget-header map9 text-center" value="9">
			  <p>Emplacement 9</p>
			</div>

			<div class="droppable ui-widget-header map10 text-center" value="10">
			  <p>Emplacement 10</p>
			</div>

			<div class="droppable ui-widget-header map11 text-center" value="11">
			  <p>Emplacement 11</p>
			</div>

			<div class="droppable ui-widget-header map12 text-center" value="12">
			  <p>Emplacement 12</p>
			</div>

			<div class="droppable ui-widget-header map13 text-center" value="13">
			  <p>Emplacement 13</p>
			</div>

			<div class="droppable ui-widget-header map14 text-center" value="14">
			  <p>Emplacement 14</p>
			</div>

			<div class="droppable ui-widget-header map15 text-center" value="15">
			  <p>Emplacement 15</p>
			</div>

		</div>
	</div>

	<a href="javascript:if(window.print)window.print()">Imprimer cette page</a>

<style>
.droppable { width: 105px; height: 105px; float: left; margin: 10px; border-radius: 10px; }
</style>

	<?php
}





require_once('footer.php');