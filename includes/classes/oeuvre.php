<?php

      ////////////////////////////////
      // Classe OEUVRE (01.04.17)/////      
      ////////////////////////////////

Class Oeuvre {

	private $id;
	private $nom;
	private $numero;
	private $description;
	private $oeuvre_in;
	private $oeuvre_out;
	private $photo;
	private $map_position;
	private $artist_id;
	private $categorie_id;
	private $dimension;
	private $qr_code;

	function __construct($id = 0) {
		if($id != 0) 
		{
			$oeuvre = sql("SELECT * FROM oeuvre WHERE id='".addslashes($id)."'");
			$o = $oeuvre[0];
			$this->id = $o['id'];
			$this->nom = $o['nom'];
			$this->numero = $o['numero'];
			$this->description = $o['description'];
			$this->oeuvre_in = $o['oeuvre_in'];
			$this->oeuvre_out = $o['oeuvre_out'];
			$this->photo = $o['photo'];
			$this->map_position = $o['map_position'];
			$this->categorie_id = $o['categorie_id'];
			$this->artist_id = $o['artist_id'];
			$this->dimension = $o['dimension'];
			$this->qr_code = $o['qr_code'];
		}
	}

	function getId() {
		return $this->id;
	}

	function getNom() {
		return $this->nom;
	}

	function setNom($nom) {
		$this->nom = $nom;
	}

	function getNumero() {
		return $this->numero;
	}

	function setNumero() {

		$res = sql("SELECT MAX(numero) FROM oeuvre");

		$res = implode($res[0]);

		if($res == '') {
			$res = (int)$res + 1;
			
		}

		elseif($res >= 0) {
			$res = $res + 1;
		}

		$this->numero = $res;
	}

	function getDescription() {
		return $this->description;
	}

	function setDescription($description) {
		$this->description = $description;
	}

	function getOeuvreIn() {
		return $this->oeuvre_in;
	}

	function setOeuvreIn($oeuvre_in) {
		$this->oeuvre_in = $oeuvre_in;
	}

	function getOeuvreOut() {
		return $this->oeuvre_out;
	}

	function setOeuvreOut($oeuvre_out) {
		$this->oeuvre_out = $oeuvre_out;
	}

	function getPhoto() {
		return $this->photo;
	}


	function setPhoto($photo) {

		$listeExtension = array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg');

		$photo = $_FILES['imageNew'];

		if(!empty($_FILES['imageNew'])) { 
		  
		    if($_FILES['imageNew']['error'] <= 0) {

		        // L'image ne doit pas dépasser 2 097 152 octets
		        if($_FILES['imageNew']['size'] <= 2097152) {

		            $imageNew = $_FILES['imageNew']['name'];

		            // On cherche l'extension du fichier stocké dans la variable $imageNew(string) : explode renvoi un tableau de chaine
		            $extensionPresumee = explode('.', $imageNew);

		            // On converti l'extension en minuscule avec la fonction lower à l'index 1 de notre tableau
		            $extensionPresumee = strtolower($extensionPresumee[1]);

		            // On vérifie que l'extension correspond à l'un des formats accepté (jpg/jpeg/etc.)
		            if($extensionPresumee == 'jpg' || $extensionPresumee == 'jpeg') {

		                // On vérifie le type MIME
		                $imageNew = getimagesize($_FILES['imageNew']['tmp_name']);

		                if($imageNew['mime'] == $listeExtension[$extensionPresumee]) {

		                	if(!$extensionPresumee == 'jpg' || !$extensionPresumee == 'jpeg') {
	                            //On fait une copie de l'image redimensionné
	                            return FALSE;
		                	}
		                	else {
                            	$imageChoisie = imagecreatefromjpeg($_FILES['imageNew']['tmp_name']);
		                	// elseif ($extensionPresumee =='png') {
                   			//    return FALSE;
		                	// }
                        	}

                            //On récupère les dimensions de l'image de départ
                            $tailleImageChoisie = getimagesize($_FILES['imageNew']['tmp_name']);
                            // var_dump($tailleImageChoisie); 

                            // On redimensionne l'image selon nos critères en "dur"
                            $nouvelleLargeur = 250;

                            // On calcule le pourcentage de réduction
                            $reduction = ( ($nouvelleLargeur * 100) / $tailleImageChoisie[0] );

                            // On détermine la hauteur de la nouvelle image en fonction du pourcentage de réduction de l'ancienne hauteur
                            $nouvelleHauteur = (($tailleImageChoisie[1] * $reduction) /100 );

                            // On crée la miniature
                            $nouvelleImage = imagecreatetruecolor($nouvelleLargeur, $nouvelleHauteur) or die ("Erreur");

                            imagecopyresampled($nouvelleImage,  $imageChoisie, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $tailleImageChoisie[0], $tailleImageChoisie[1]);

                            imagedestroy($imageChoisie);

                            $nomImageChoisie = explode('.', $_FILES['imageNew']['name']);

                            // On modifie le nom pour sécuriser notre insertion
                            $nomImageExploitable = time();


                            // On stocke la nouvelle image dans $nouvelle image, on spécifie son dossier d'enregistrement, son nouveau nom ainsi que son extension(.png/.etc) et on on dit que la qualité de l'image sera de 100
                            $res = imagejpeg($nouvelleImage, '../img/'.$nomImageExploitable.'.'.$extensionPresumee, 100);

		                    if($res == TRUE) {
		                        $this->photo = '../img/'.$nomImageExploitable.'.'.$extensionPresumee;
			                    }

                           else {
                                    echo 'Le type MIME de l\'image n\'est pas bon';
                           }
		                }
                        else {
                                echo 'L\'extension choisie pour l\'image est incorrecte';
                        }
		            }
	                else {
	                        echo 'L\'image est trop lourde';
	                }
		        }
	            else {
	                    echo 'Erreur lors de l\'upload image';
	            }
		    }
	        else {
	                echo 'Au moins un des champs est vide - ';
	                return FALSE;
	        }
		}
	}	

	function getMapPosition() {
		return $this->map_position;
	}

	function setMapPosition($map_position) {
		$this->map_position = $map_position;
	}

	function getArtistId() {
		return $this->artist_id;
	}

	function setArtistId($artist_id) {
		$this->artist_id = $artist_id;
	}

	function getCategorieId() {
		return $this->categorie_id;
	}

	function setCategorieId($categorie_id) {
		$this->categorie_id = $categorie_id;
	}

	function getDimension() {
		return $this->dimension;
	}

	function setDimension($dimension) {
		$this->dimension = $dimension;
	}

	function getQrCode() {
		return $this->qr_code;
	}

	function setQrCode() {
		$lien = "http://localhost/agoe/front/oeuvre.php?id_oeuvre=".$this->id."";
		$file = "../qrCode/".addslashes($this->id).".png";
		$qr = QRcode::png($lien, $file);
		$res = sql("UPDATE oeuvre SET qr_code='".$file."' WHERE id='".addslashes($this->id)."'");
	}


	function form($target ='edit_oeuvre.php') {

		$res = sql("SELECT * FROM oeuvre_categorie");

		// Formulaire informations générales
		?>
		<form name="form" action="<?php $target ?>" method="post" enctype="multipart/form-data" class="col-md-8">

			<div class="form-group">
				<label class="control-label">Nom</label>
				<input type="text" class="form-control" name="nom" placeholder="indiquer le nom de l'oeuvre" value="<?php echo $this->nom; ?>" required>
			</div>

			<div class="form-group">
				<label class="control-label">Description</label>
				<textarea type="text" name="description" class="form-control" placeholder="description de l'oeuvre" rows="10" cols="50" required><?php echo $this->description; ?></textarea>
			</div>

			<div class="form-group">
				<span>Type d'oeuvre : </span>
				<?php
				// Liste des catégories d'oeuvres
				foreach ($res as $categorie) {
					echo '<input type="radio" name="categorie_id" value ="'.$categorie['id'].'"';
					if($this->categorie_id == $categorie['id']) {echo ' checked="checked"'; };
					echo '" required>'.$categorie['nom'].'
					';
				}
				?>
			</div>

			<input type="hidden" name="id" value="<?php echo $this->id; ?>">

			<div class="form-group">
				<label class="control-label">Image de l'oeuvre</label>
				<input type="file" name="imageNew" class="form-control" placeholder="photo de l\'oeuvre" value="<?php echo $this->photo; ?>"><br>
				<img src="<?php echo $this->photo; ?>">
			</div>

			<input type="hidden" name="MAX_FILE_SIZE" value="2097152" >

			<div class="form-group">
				<label class="control-label">Arrivée de l'oeuvre sur le site : </label>
				<input type="date" class="form-control" name="oeuvre_in" value="<?php echo $this->oeuvre_in; ?>" required>
			</div>

			<div class="form-group">
				<label class="control-label">Départ de l'oeuvre du site : </label>
				<input type="date" class="form-control" name="oeuvre_out" value="<?php echo $this->oeuvre_out; ?>" required>
			</div>

			<div class="form-group">
				<label class="control-label">Dimension de l'oeuvre : </label>
				<input type="text" class="form-control" name="dimension" value="<?php echo $this->dimension; ?>">
			</div>

			<button type="submit" class="btn btn-primary" value="Valider">Valider</button>
		</form>
		<?php

	}


	// Fonction pour enregistrer une nouvelle oeuvre
	function push() {
		if(empty($this->id)) {
			$insertOeuvre = sql("
				INSERT INTO oeuvre VALUES (
				NULL,
				'".addslashes($this->nom)."',
				'".addslashes($this->numero)."',
				'".addslashes($this->description)."',
				'".addslashes($this->oeuvre_in)."',
				'".addslashes($this->oeuvre_out)."',
				'".addslashes($this->photo)."',
				'".addslashes($this->map_position)."',
				'".addslashes($this->categorie_id)."',
				'".addslashes($this->artist_id)."',
				'".addslashes($this->dimension)."',
				'".addslashes($this->qr_code)."'
				
				)");

			if($insertOeuvre != FALSE) {
				$this->id = $insertOeuvre;
				return TRUE;
			}
			else {
				return FALSE;
			}
		}

		else {
			if(is_numeric($this->id)) {
				$updateOeuvre = sql("
					UPDATE oeuvre SET
					nom ='".addslashes($this->nom)."',
					description ='".addslashes($this->description)."',
					oeuvre_in ='".addslashes($this->oeuvre_in)."',
					oeuvre_out='".addslashes($this->oeuvre_out)."',
					photo ='".addslashes($this->photo)."',
					categorie_id ='".addslashes($this->categorie_id)."',
					artist_id ='".addslashes($this->artist_id)."',
					dimension = '".addslashes($this->dimension)."'
					WHERE id = '".addslashes($this->id)."'
					");

				if($updateOeuvre != FALSE) {
					return $updateOeuvre;
				}
				else {
					return FALSE;
				}
			}

		}
	}


	// Fonction pour supprimer une oeuvre
	function deleteOeuvre() {
		
		// Requete pour selectionner l'oeuvre à supprimer
		$resFichier = sql("SELECT * FROM oeuvre WHERE id='".addslashes($this->id)."'");

		// Si la requete est true alors on supprime le fichier enregistré dans img + dossier qr_code
		if($resFichier == TRUE) {
			if($resFichier[0]['photo'] != '') {
				unlink($resFichier[0]['photo']);
			}
			if($resFichier[0]['qr_code'] !='') {
				unlink($resFichier[0]['qr_code']);
			}
		}
		else {
			return FALSE;
		}

		// On supprime les oeuvres qui ont étés associées à une exposition
	    $delExpoOeuvre = sql("
		    SELECT oeuvre_id FROM expo_oeuvre
	    	LEFT JOIN oeuvre
	    	ON expo_oeuvre.oeuvre_id = oeuvre.id
	    	WHERE oeuvre.id ='".addslashes($this->id)."'
	    	");

	    foreach ($delExpoOeuvre as $del) {
	    	$del = implode(',', $del);
	    	sql("DELETE FROM expo_oeuvre WHERE oeuvre_id ='".$del."'");
	    }

		// On supprime l'oeuvre dans la base donnée et on vérifie que la requete a bien été executé
		$resDelete = sql("DELETE FROM oeuvre WHERE id= '".addslashes($this->id)."'");

        if($resDelete == FALSE) {
           	return FALSE;
        }

        else{
            return TRUE;
        }
    }


	// Fonction qui liste les oeuvres d'un artiste
	static function listOeuvreArtiste($id)	{
		$res = sql("SELECT id,nom,numero,dimension,oeuvre_in,oeuvre_out,photo,qr_code FROM oeuvre WHERE artist_id = '".addslashes($id)."'");

		if($res != FALSE) {
			return $res;
		 }

		 else {
		 	return FALSE;
		 }
	}

	// Fonction qui liste toutes les oeuvres de la base de donnée
	static function listOeuvre() {
		$res = sql("SELECT * FROM oeuvre");

		if($res != FALSE) {
			return $res;
		 }
		 else {
		 	return FALSE;
		 }
	}
}