<?php

      /////////////////////////////////
      // EDIT_CATEGORIE (24.03.17)/////
      /////////////////////////////////

include('header.php');


if(isset($_POST['titre'])) {
    if(empty($_POST['id'])) {
        $expo = new Exposition();
    }
    else {
        $expo = new Exposition($_POST['id']);
    }
    $expo->setTitre($_POST['titre']);
    $expo->setDescription($_POST['description']);
    $expo->setDebutExpo($_POST['debut_expo']);
    $expo->setFinExpo($_POST['fin_expo']);
    $expo->push();

    $newId = $expo->getId();
}?>
<div class="container">

    <div class="row">

        <!-- Page précédente -->
        <a href="exposition.php">Revenir à la liste des expositions</a>

    </div><br>

    <div class="row">
        <?php
        if(isset($_GET['id'])) {
            $expo = new Exposition($_GET['id']);
            $expo->form('edit_exposition.php');
        }
        elseif(isset($newId)) {
            $expo = new Exposition($newId);
            $expo->form('edit_exposition.php');
        }
        else {
            $expo = new Exposition();
            $expo->form('edit_exposition.php');
        }

        if(isset($_GET['action']) && $_GET['action'] == 'delete') {
            $expo = new Exposition($_GET['id']);
            $expo->delete_all_oeuvre_expo();
            $expo->delExpo($_GET['id']);
        }?>
    </div>

</div>



