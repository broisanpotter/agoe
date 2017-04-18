<?php

                //////////////////////////////
                // HEADER (24.03.17)//////////
                //////////////////////////////




//Connexion à la base de donnée sql
require_once('../includes/config/config.php');
require_once('../includes/config/functions.php');


// Algo qui récupère tout le contenu du dossier includes/classes/.
$folder = scandir('../includes/classes');
foreach($folder as $file) {
    if(is_file('../includes/classes/'.$file)) {
        require_once('../includes/classes/'.$file);
    }
}

// Démarre une nouvelle session ou reprend une session existante
session_start();

// Si pas de session existante alors on redirige vers login.php pour le log
if(!isset($_SESSION['id'])) {
    header('Location: login.php');
}


?><!DOCTYPE html>
<html lang="fr">
<head>

	<meta charset="utf-8">
	<title>Art_project</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
    <link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="style/admin.css">
    
    
</head>

<body>

<?php
// Barre de naviagation principale
include('nav.php');

?>

<div class="container">
    <div class="row">
         <p id="alert_retour" class="col-xs-3 col-xs-offset-9 alert_css"></p>
    </div>
