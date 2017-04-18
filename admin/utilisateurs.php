<?php
			///////////////////////////////////////////////////////
			// Espace ADMIN & espace UTILISATEUR(S) (24.03.17)/////
			///////////////////////////////////////////////////////



require_once("header.php");
require_once('../includes/classes/phpmailer/class.phpmailer.php');
require_once('../includes/classes/phpmailer/class.smtp.php');



// Suppression d'un compte
if(isset($_GET['action']) && $_GET['action'] == 'delete') {
	$delete = new User($_GET['id']);
	if(isset($_GET['id']) && $_GET['id'] == $_SESSION['id']) {
			$delete->delete($_GET['id']);
			header('Location: logout.php');	
	}
	elseif(isset($_SESSION['id']) && $_SESSION['id'] == 1 && isset($_GET['id']) && $_GET['id'] != '') {
		$delete->delete($_GET['id']);
	}
}

// Insert Update d'un utilisateur
if(isset($_POST['name']) && $_POST['name'] != '') {

	// Formulaire n'ayant pas d'ID = INSERT
	if(empty($_POST['id'])) {
		$user = new User();
		$user->setNom($_POST['name']);
        $user->setFonction($_POST['fonction']);
        $user->setEmail($_POST['email']);

        // Fonction pour vérifier si nom+email déjà existants dans Base de donnée
		if($user->checkUserBdd($_POST['name'], $_POST['email'], null, null) == TRUE) {

			// Vérification que les deux mots de passe sont identiques et non vide
			if($_POST['mot_de_passe1'] == $_POST['mot_de_passe2'] && $_POST['mot_de_passe1'] != '') {
				
				// Fonction pour vérfier la sécurité du mdp
				if($user->secureMdp($_POST['mot_de_passe1']) == TRUE) {
					
					// Fonction pour enregistrer dans la Base de donnée
					$user->push($_POST['mot_de_passe1']);
			        echo 'Vous venez de créer un nouvel utilisateur';
			        //Appel à Phpmailer
			        $mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->CharSet="UTF-8";
					// modify
					$mail->SMTPSecure = $smtp;
					$mail->Host = $host;
					$mail->Port = $port;
					$mail->Username = 'agoesystem@gmail.com';
					//
					$mail->Password = $pass;
					$mail->SMTPAuth = true;

					$mail->From = 'agoesystem@gmail.com';
					$mail->FromName = 'Gérard Fioret';

					$mail->IsHTML(true);
					$mail->AddAddress($_POST['email']);
					$mail->Subject = "Compte créé";
					$mail->Body = "Bonjour ".$_POST['name'].
					" Votre compte chez GRAND ANGLE a bien été créé!<br/><br/> 
					Votre identifiant: ".$_POST['name']."<br/><br/>
					Votre mot de passe: ".$_POST['mot_de_passe1']."<br/><br/>
					<strong> MOT DE PASSE PROVISOIRE!<br/>
					Changez-le à la première connexion dans votre espace personnel!</strong>";

					if(!$mail->Send())
					{
					  echo "Une erreur est survenue: " . $mail->ErrorInfo;
					}
					else
					{
					  echo " - Un mail lui a été envoyé!";
					}
				}
				else {
					$user->form();
				}
			}
			else {
				echo "Les deux mots de passe ne sont pas identiques";
				$user->form();
			}
		}
		else {
			$user->form();
		}
	}
	// Formulaire ayant déjà un id = UPDATE
	else {
		$user = new User($_POST['id']);
		
		// Initialisation des "anciens" nom et adresse mail de l'user qui Update
		$old_name = $user->getNom();
		$old_email = $user->getEmail();

		$user->setNom($_POST['name']);
		$user->setFonction($_POST['fonction']);
		$user->setEmail($_POST['email']);

		// Fonction pour vérifier si nom+email déjà existants dans Base de donnée
		if($user->checkUserBdd($_POST['name'], $_POST['email'], $old_name, $old_email) == TRUE) {	

			// Vérification que les deux mots de passe sont identiques
			if($_POST['mot_de_passe1'] == $_POST['mot_de_passe2'] && $_POST['mot_de_passe1'] != '') {
				
				// Fonction pour vérfier la sécurité du mdp
				if($user->secureMdp($_POST['mot_de_passe1']) == TRUE) {
					
					// Fonction pour enregistrer dans la Base de donnée
					$user->push($_POST['mot_de_passe1']);
					
					echo 'Votre compte a bien été modifié<br>';
				}
				else {
					$user->form();
				}
			}
			else {
				echo 'Mots de passe différents';
				$user->form();
			}
		}
		else {
			$user->form();
		}
	}
}


// Recherche de la 'fonction' de $_SESSION
$fonction = sql("SELECT fonction FROM user WHERE id='".addslashes($_SESSION['id'])."'");
$fonction = implode($fonction[0]);


// Controleur de Droit d'accès

// Acces ADMIN ssi fonction == 'administrateur'
if($_SESSION['id'] == 1 && $fonction == 'Administrateur') {

	?>
	<div class="container">

		<div class="row col-md-12">
			<h3 class="color_header">Utilisateurs de l'association "Grand Angle"</h3>
		</div>

		<div class="row col-md-12">
			<h4><a href="utilisateurs.php?action=edit" style="text-decoration:none;"><span class="glyphicon glyphicon-plus-sign"></span> Créer un nouvel utilisateur</a></h4>
		</div>

	</div><br>
	<?php

	// Fonction statique qui liste tout les utilisateurs
	$list = User::listUser();
	
	?>
	<div class="container">
		<ul class="list-group col-md-7">
			<li class="list-group-item clearfix">
				<div class="row">
					<div class="col-xs-3"><strong>Nom</strong></div>
					<div class="col-xs-3"><strong>Fonction</strong></div>
					<div class="col-xs-3 col-xs-offset-3" style="padding-left: 60px;"><strong>Modification</strong></div>
				</div>
			</li>
		<?php
		foreach ($list as $u) {
			?>
			<li class="list-group-item clearfix">
					<div class="row">
							<div class="col-xs-3"><?= $u->getNom() ?></div>
							<div class="col-xs-3"><?= $u->getFonction() ?></div>
							<div class="col-xs-3 col-xs-offset-3">

								<span class="pull-right button-group">
							    	<a href="utilisateurs.php?action=edit&id=<?= $u->getId() ?>" class="btn btn-primary">
							    			<span class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Modifier l'Utilisateur"></span>
							    	</a>

							    	<!-- L'admin ne peut se supprimer -->
							    	<?php
						    	    if($u->getId() != 1) {
						            ?>
						            <a href="utilisateurs.php?action=delete&id=<?= $u->getId() ?>" class="btn btn-warning"  onclick="return confirm('Êtes vous sur de vouloir supprimer cet Utilisateur?');">
						            		<span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Supprimer"></span>
						            </a>
						            <?php
						        	}
						        	?>
								</span>

							</div>		
					</div>
			</li>
			<?php
		}
		?>
		</ul>

		<?php


		// AFFICHER LE FORMULAIRE SI $_GET EDIT
		if(isset($_GET['action']) && $_GET['action'] == 'edit') {
	
			// Si on a un ID alors on affiche le contenu existant dans le formulaire
			if(isset($_GET['id']) && $_GET['id'] !='') {
				$form = new User($_GET['id']);
				$form->form();
			}

			// Si on a pas d'ID on ouvre un formulaire vide
			else {
				$form = new User();
				$form->form();
			}
		}
	?>
	</div>
	<?php
}

// Accès USER ssi fonction != 'administrateur'
else {	
	if(isset($_GET['action']) && $_GET['action'] == 'edit') {
	
			// Si on a un ID alors on affiche le contenu existant dans le formulaire
			if(isset($_SESSION['id']) && $_SESSION['id'] !='') {
				$form = new User($_SESSION['id']);
				$form->form();
			}
	}

	$user = new User($_SESSION['id']);
	$nom = $user->getNom();
	echo '<br><br>'.$nom.' :';
				?>
				<br><br><a href="utilisateurs.php?action=edit">Modifier mon compte</a>
				<br><a href="utilisateurs.php?action=delete&id=<?= $user->getId() ?>" onclick="return confirm('Êtes vous sur de vouloir supprimer votre compte?');">Supprimer mon compte</a>
				 <?php
}

require_once('footer.php');