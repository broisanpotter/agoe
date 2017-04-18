<?php

                //////////////////////////////
                // HEADER (01.04.17)//////////
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



?><!DOCTYPE html>
<html lang="fr">
<head>

	<meta charset="utf-8">
	<title>Art_project</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
	<link rel="stylesheet" type="text/css" href="style/style_front.css">
    
    
</head>

<body>
<?php
include('nav_bar_front.php');
?>
<div class="container">
