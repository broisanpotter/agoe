<?php

                //////////////////////////////
                // CONNEXION (30.03.17)///////
                //////////////////////////////



//Connexion à la base de donnée sql
require_once('../includes/config/config.php');
require_once('../includes/config/functions.php');

// On appel seulement la classe user pour login.php
require_once('../includes/classes/user.php');

// Démarre une nouvelle session
session_start();

if(isset($_SESSION['id'])) {
    header('Location: index.php');
}

// On entre dans la condition ssi on a reçu le formulaire(POST)
if(isset($_POST['nom']) && $_POST['nom'] !='')
{
    // Fonction statique qui vérifié le nom et le mdp pour se co
    $res= User::checkUser($_POST['nom'],md5($_POST['password']));
    if($res === FALSE) {
        $msg = 'Nom et mot de passe entrés sont invalides';
    }
    else {
        $_SESSION['id'] = $res->getId();
        // Si la connexion est faite on se dirige vers index.php
        header('Location: index.php');
    }
}
else{
    $msg = 'Bienvenue chez "Grand Angle"';
}


// Formulaire de connexion au Back-end
?><!DOCTYPE html>
<html>
    <head>
        <title>agoe_login</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css">
        <link rel="stylesheet" type="text/css" href="style/admin.css">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    </head>
    <body>

    <div class="container push-top-login">


            <div class="row">

                <form action="login.php" method="post" class="form-signin">
                    <!-- Message d'erreur ssi erreur de login ou message de bienvenue -->
                    <h4 class="form-signin-heading text-center"><?php echo $msg; ?></h4>
                    <label class="sr-only">Nom</label>
                    <input type="text" name="nom" placeholder="Nom" class="form-control" required/>
                    <label class="sr-only">Password</label>
                    <input type="password" name="password" placeholder="Mot de passe" class="form-control" required/>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
                </form>

            </div>

    </div>
        
    </body>
</html>


