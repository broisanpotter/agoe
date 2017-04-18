<?php

      //////////////////////////////////////////
      // Classe OEUVRE_CATEGORIE (10.02.17)/////
      //////////////////////////////////////////

Class OeuvreCategorie {

	private $id;
	private $nom;

	function __construct($id = 0)
	{
		if($id != 0) {
			$categorie = sql("SELECT * FROM oeuvre_categorie WHERE id ='".addslashes($id)."'");
			$c = $categorie[0];
			$this->id = $c['id'];
			$this->nom = $c['nom'];
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

	function form($target ='edit_categorie.php') {
		echo 
		'<form name="form" method="post" action="'.$target.'" class="col-md-4">
		    <div class="form-group">
		      <input type="text" name="name" placeholder="Catégorie d\'oeuvre" value="'.$this->getNom().'" required>
				<input type="hidden" name=id value="'.$this->getId().'">
		    </div>
		    <button type="submit" class="btn btn-primary" value="Valider">Submit</button>
		</form>';
	}




	// Fonction pour enregistrer un nouvel artiste
	function push() {
		if(empty($this->id)) {
			$insertCategorie = sql("
				INSERT INTO oeuvre_categorie VALUES (
				NULL,
				'".addslashes($this->nom)."'
				)");

			if($insertCategorie !== FALSE) {
				$this->id = $insertCategorie;
				return TRUE;
			}
			
			else {
				return FALSE;
			}
		}

		else {

			if(is_numeric($this->id)) {
				$updateCategorie = sql("
					UPDATE oeuvre_categorie SET
					nom = '".addslashes($this->nom)."'
					WHERE id = '".addslashes($this->id)."'
					");

				return $updateCategorie;
			}

			else {
				echo "Une erreur est survenue lors de la modification de cette catégorie";
				return FALSE;
			}
		}
	}


	// Fonction qui supprime un artiste
 	function delete() {
    $res = sql("DELETE FROM oeuvre_categorie WHERE id='".addslashes($this->id)."'");
    
	    if($res == TRUE) {
	        header('edit_categorie.php');
	        return TRUE;
	    }

	    else{
	        // 301 Moved Permanently
	        header("Location: edit_categorie.php",TRUE,301);
	        echo 'Une erreure est survenue lors de la suppression de la catégorie';
	        return FALSE;
	    }
	}


	// Fonction qui liste tous les utilisateurs
	static function listOeuvreCategorie() {
		$res = sql("SELECT id FROM oeuvre_categorie ORDER BY nom");

		if($res !='') {
			$list = array();
				
		    foreach($res as $cat) {
		    	array_push($list, new OeuvreCategorie($cat['id']));
		    }
		    
		    return $list;
		}
		else {
			return FALSE;
		}
	}

}