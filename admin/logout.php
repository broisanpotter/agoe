<?php

                //////////////////////////////
                // DECONNEXION (15.01.17)/////
                //////////////////////////////


// Deconnexion de l'utilisateur avec suppression des cookies 
session_start();
session_destroy();

header('Location: login.php');