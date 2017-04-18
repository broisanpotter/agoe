<?php

      ////////////////////////////////
      // Classe ARTIST (24.03.17)/////
      ////////////////////////////////


Class Artist {

	private $id;
	private $nom;
	private $description;
	private $email;
	private $tel;

	function __construct($id = 0) 
	{
		if($id != 0) {
			$artist = sql("SELECT * FROM artist WHERE id ='".addslashes($id)."'");
			$a = $artist[0];
			$this->id = $a['id'];
			$this->nom = $a['nom'];
			$this->description = $a['description'];
			$this->email = $a['email'];
			$this->tel = $a['tel'];
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

	function getDescription() {
		return $this->description;
	}

	function setDescription($description) {
		$this->description = $description;
	}

	function getEmail() {
		return $this->email;
	}

	function setEmail($email) {
		$this->email = $email;
	}

	function getTel() {
		return $this->tel;
	}

	function setTel($tel) {
		$this->tel = $tel;
	}

	// Fonction qui affiche le formulaire d'inscription ou de modification d'un artiste
	function form($target ='artist.php') {

		echo '

		<form name="form" method="post" action="'.$target.'" class="col-md-5 col-md-offset-1 form-background">
		    
		    <div class="form-group">
		    		<label class="control-label">Nom</label>
		      		<input type="text" name="name" class="form-control" value="'.$this->getNom().'" placeholder="Nom de l\'artiste" required>
		    </div>

		    <div class="form-group">
		      		<label class="control-label">Description</label>
					<textarea name="description" class="form-control" rows="4" cols="50" placeholder="Description de l\'artiste">'.$this->getDescription().'</textarea>
			</div>

			<div class="form-group">
					<label class="control-label">Adresse Mail</label>
					<input type="email" name="email" class="form-control" value="'.$this->getEmail().'" placeholder="L\'adresse mail de l\'artiste">
			</div>

			<div class="form-group">
					<label class="control-label">Téléphone</label>
		    		<input type="text" name="tel" class="form-control" placeholder="Téléphone de l\'artiste" value="'.$this->getTel().'">
		    </div>

		    <input type="hidden" name="id" value="'.$this->getId().'">
		  
		    <button type="submit" class="btn btn-primary" value="Valider">Valider</button>

		</form>';
	}



	// Fonction pour enregistrer ou modifier un artiste
	function push() {
		
		if(empty($this->id)) {
			$insertArtist = sql("
				INSERT INTO artist VALUES (
				NULL,
				'".addslashes($this->nom)."',
				'".addslashes($this->description)."',
				'".addslashes($this->email)."',
				'".addslashes($this->tel)."'
				)");
			if($insertArtist !== FALSE) {
				$this->id = $insertArtist;
				return TRUE;
			}
			else {
				return FALSE;
			}
		}

		else {
			if(is_numeric($this->id)) {
				$updateArtist = sql("
					UPDATE artist SET
					nom = '".addslashes($this->nom)."',
					description = '".addslashes($this->description)."',
					email = '".addslashes($this->email)."',
					tel = '".addslashes($this->tel)."'
					WHERE id = '".addslashes($this->id)."'
					");

				return $updateArtist;
			}

			else {
				echo "Une erreur est survenue lors de la modification de cet artiste";
				return FALSE;
			}
		}
	}


	// Fonction qui supprime un artiste et ses oeuvres associées
 	function delete() {
 		
 		// On supprime les fichiers liées aux oeuvres  de l'artiste que l'on va supprimer
 		$OeuvreArtiste = sql("SELECT * FROM oeuvre WHERE artist_id='".addslashes($this->id)."'");
 		
 		if($OeuvreArtiste == TRUE) {
	 		foreach ($OeuvreArtiste as $oeuvre) {
	 			unlink($oeuvre['photo']);
	 			unlink($oeuvre['qr_code']);
	 		}
 		}

 		// On supprime les oeuvres de l'artiste qui ont étés liées à une exposition
	    $delExpoOeuvre = sql("
		    SELECT oeuvre_id FROM expo_oeuvre
	    	LEFT JOIN oeuvre
	    	ON expo_oeuvre.oeuvre_id = oeuvre.id
	    	WHERE oeuvre.artist_id ='".addslashes($this->id)."'
	    	");

	    foreach ($delExpoOeuvre as $del) {
	    	$del = implode(',', $del);
	    	sql("DELETE FROM expo_oeuvre WHERE oeuvre_id ='".$del."'");
	    }

 		// On supprime dans la base de donnée les oeuvres qui sont liées à l'artiste que l'on supprime
	    $delOeuvre = sql("DELETE FROM oeuvre WHERE artist_id='".addslashes($this->id)."'");
	    // test

	    

	    // On supprime l'artiste dans la base de donnée
	    $res = sql("DELETE FROM artist WHERE id='".addslashes($this->id)."'");
	    
		    if($res == TRUE && $delOeuvre == TRUE) {
		        header('artist.php');
		        return TRUE;
		    }
		    else{
		        // 301 Moved Permanently
		        header("Location: artist.php",TRUE,301);
		        echo 'Une erreure est survenue lors de la suppression de l\'artiste';
		        return FALSE;
		    }
			
	}

	// Fonction qui liste tous les utilisateurs
	static function listArtist() {
		$res = sql("SELECT id FROM artist ORDER BY nom");

			if($res != '') {

			    $list = array();
				
			    foreach($res as $user) {
			    	array_push($list, new Artist($user['id']));
			    }
			    
			    return $list;
			}

			else {
				return FALSE;
			}
	}

}