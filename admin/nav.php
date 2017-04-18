 <?php
$res = new User($_SESSION['id']);
 ?>

                    <!-- BARRE DE NAVIGATION(10.02.17) -->

<nav class="navbar navbar-default">

  <div class="container navbar-theme">

    <div class="navbar-header">

      <a class="navbar-brand" href="index.php"><strong><?php  echo $res->getNom(); ?></strong></a>

    </div>

    <ul class="nav navbar-nav">
    
        <li>
            <a href="exposition.php" ><strong>Expositions</strong></a>
        </li>

        <li>
            <a href="artist.php" ><strong>Artistes</strong></a>
        </li>

        <li>
            <a href="edit_categorie.php"><strong>Catégorie d'oeuvres</strong></a>
        </li>

        <?php
        // ADMIN
        if($_SESSION['id'] == 1) {
            ?>
            <li>
                <a href="utilisateurs.php" ><strong>Espace Utilisateurs</strong></a>
            </li>
            <?php
        }
        else {
            ?>
         <li>
             <!--UTILISATEUR-->
            <a href="utilisateurs.php"><strong>Espace personnel</strong></a>
        </li>
            <?php
        }
        ?>
        <li>
            <a href="logout.php" ><strong>Déconnexion</strong></a>
        </li>

        <li>
            <a href="#" class="glyphicon glyphicon-alert" id="alert_nav">
            </a>
        </li>

    </ul>

  </div>

</nav>