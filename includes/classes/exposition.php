<?php
      ////////////////////////////////////
      // Classe EXPOSITION (30.03.17)/////
      ////////////////////////////////////

Class Exposition {
    
    private $id;
    private $titre;
    private $description;
    private $debut_expo;
    private $fin_expo;
    private $statut;
    private $publier;
    
    function __construct($id=0) {
        if($id != 0) {
            $res = sql("SELECT * FROM exposition WHERE id='".addslashes($id)."'");
            $e = $res[0];
            $this->id = $e['id'];
            $this->titre = $e['titre'];
            $this->description = $e['description'];
            $this->debut_expo = $e['debut_expo'];
            $this->fin_expo = $e['fin_expo'];
            $this->statut = $e['statut'];
            $this->publier = $e['publier'];
        }
    }

    function getId() {
        return $this->id;
    }

    function getTitre() {
        return $this->titre;
    }

    function setTitre($titre) {
        $this->titre = $titre;
    }

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }   

    function getDebutExpo() {
        return $this->debut_expo;
    }

    function setDebutExpo($debut_expo) {
        $this->debut_expo = $debut_expo;
    }

    function getFinExpo() {
        return $this->fin_expo;
    }

    function setFinExpo($fin_expo) {
        $this->fin_expo = $fin_expo;
    }

    function getStatut() {
        return $this->statut;
    }

    function setStatut($statut) {
        $this->statut = $statut;
        $res = sql("
            UPDATE exposition SET 
            statut='".addslashes($this->statut)."'
            WHERE id='".addslashes($this->id)."'
            ");
        if(!$res) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function getPublier() {
        return $this->publier;
    }

    function setPublier($publier) {
        $this->publier = $publier;
        $res = sql("
            UPDATE exposition SET
            publier ='".addslashes($this->publier)."'
            WHERE id='".addslashes($this->id)."'
            ");
        if(!$res) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }



//CU du CRUD, on update les données dans la table exposition ou on les crée
    function push() {
        if(is_numeric($this->id)){
            $res = sql("UPDATE exposition SET
            titre = '".addslashes($this->titre)."',
            description = '".addslashes($this->description)."',
            debut_expo = '".addslashes($this->debut_expo)."',
            fin_expo = '".addslashes($this->fin_expo)."' 
            WHERE id='".addslashes($this->id)."'
            ");
            if(!$res) {
                return FALSE;
            }
            else {
                header ("Location: exposition.php");
                return $res;
            }
            
        }
        else {
            $res = sql("
                INSERT INTO
                exposition(titre,description,debut_expo,fin_expo) VALUES(
                    '".addslashes($this->titre)."',
                    '".addslashes($this->description)."',
                    '".addslashes($this->debut_expo)."',
                    '".addslashes($this->fin_expo)."'
                    )");
            if(!$res) {
                return FALSE;
                echo 'erreur';
            }
            else {
                $this->id = $res;
                header ("Location: exposition.php");
                return TRUE;
            }
            
        }
    }

    //R du CRUD, on liste les expositions de la table exposition
    static function listExpo() {
        $list = sql("SELECT id FROM exposition ORDER BY debut_expo DESC");

        if($list !='') {
            $res = array();
            foreach($e = $list as $e) {
                array_push($res, new Exposition($e['id']));        
            }
            return $res;
        }
        else {
            return FALSE;
        }
    }

    //D du CRUD, on efface la sélection de la table
    function delExpo() {
        $resDelete = sql("DELETE FROM exposition WHERE id= '".addslashes($this->id)."'");
        if($resDelete == TRUE) {
            header("Location: exposition.php");
            return TRUE;
        }
        else{
            header ("Location: exposition.php",TRUE,301);
            echo 'Une erreur est survenue lors de la suppression de l\' exposition';
            return FALSE;
        }
            
    }
    
    // Formulaire
    function form($target) 
    {
        echo '<form action="'.$target.'" method="post" class="col-md-10 col-mod-offset-1">

        <div class="form-group">
            <label class="control-label">Titre</label> 
            <input class="form-control" type="text" name="titre" value="'.$this->titre.'" required>
        </div>

        <div class="form-group">
            <label class="control-label">Description</label>
            <textarea class="form-control" placeholder="Entrez la description" name="description" rows="10" cols="50" required>'.$this->description.'</textarea>
        </div>

        <div class=form-group">
            <label class="control-label">Debut</label>
            <input type="date" name="debut_expo" class="form-control" value="'.$this->debut_expo.'" required>
        </div>
        
        <div class="form-group">
            <label class="control-label">Fin</label>
            <input type="date" name="fin_expo" class="form-control" value="'.$this->fin_expo.'" required>
        </div>
            <input type="hidden" name="id" value="'.$this->id.'">
        
            <button type="submit" class="btn btn-primary" value="Valider">Valider</button>        
        
        </form>';
    }

    //fonction pour associer des oeuvres à une exposition
    function push_oeuvre($id_oeuvre, $id_expo) {

        if(is_int($id_oeuvre) && is_int($id_expo) && $id_oeuvre !=0) {
            $res = sql("INSERT INTO
                expo_oeuvre(oeuvre_id,expo_id) VALUES(
                    '".addslashes($id_oeuvre)."',
                    '".addslashes($id_expo)."'
                )");

            if(!$res) {
                return FALSE;
            }
            else {
                return TRUE;
            }
        }

        else {
            return FALSE;
        }

    }

     //fonction pour enregistrer les oeuvres d'une exposition sur une map
    function push_map_position($map_id, $oeuvre_id) {
        $res = sql("UPDATE
            expo_oeuvre SET
            map_position='".addslashes($map_id)."'
            WHERE oeuvre_id ='".addslashes($oeuvre_id)."'
            AND expo_id = '".addslashes($this->id)."'
        ");

        if(!$res) {
            return FALSE;
        }
        else {
            return TRUE;
        }

    }

    //fonction pour lister les oeuvre qui ont une map_postion ("pour reponse ajax") (!= bottom)
    function list_map_position() {
        $res = sql("
            SELECT oeuvre_id, map_position FROM expo_oeuvre
            WHERE expo_id='".addslashes($this->id)."'
            AND map_position IS NOT NULL
            ");

        if(!$res) {
            return FALSE;
        }
        else {
            foreach ($res as $id_map) {
                $id_map = implode(',', $id_map);
                echo $id_map.'-';
            }
        }
    }

    //  Fonction pour lister les oeuvre qui ont une map_postion ("pour reponse php") (!= top)
     function list_map_position_php() {
        $res = sql("
            SELECT oeuvre_id, map_position FROM expo_oeuvre
            WHERE expo_id='".addslashes($this->id)."'
            AND map_position IS NOT NULL
            ");

        if(!$res) {
            return FALSE;
        }
        else {
            foreach ($res as $id_map) {
                $oeuvre = new Oeuvre($id_map['oeuvre_id']);
                $oeuvre = $oeuvre->getPhoto();
                echo '
                <div class="fixed_map ui-widget-content " value="'.$id_map['map_position'].'">
                        <img src="'.$oeuvre.'" style="width: 100px; height: 100px; border-radius: 5px;">
                </div>';
            }
        }
    }


    //fonction pour lister les oeuvres qui n'ont pas de map_position
    function list_expo_oeuvre_no_map() {
          $res = sql("
            SELECT oeuvre_id FROM expo_oeuvre
            LEFT JOIN exposition
            ON exposition.id = expo_oeuvre.expo_id
            WHERE exposition.id ='".addslashes($this->id)."'
            AND map_position IS NULL
            ");

        if($res == TRUE) {
            $list = array();
            foreach($res as $oeuvre) {
                array_push($list, $oeuvre);
            }

            return $list;
        }
        else {
            return FALSE;
        }
    }


    //fonction pour lister les oeuvres associées à une exposition
    function list_expo_oeuvres() {
        $res = sql("
                SELECT oeuvre_id FROM expo_oeuvre
                LEFT JOIN exposition
                ON exposition.id = expo_oeuvre.expo_id
                WHERE exposition.id ='".addslashes($this->id)."'
            ");

        if($res == TRUE) {
            $list = array();
      
            foreach($res as $oeuvre) {
                array_push($list, $oeuvre);
            }
            return $list;
        }
        else {
            return FALSE;
        }
    }


    //fonction pour supprimer une oeuvre reliée à une exposition
    function delete_oeuvre_expo($oeuvre_id) {
        $res = sql("
            DELETE FROM expo_oeuvre
            WHERE oeuvre_id ='".addslashes($oeuvre_id)."' 
            AND expo_oeuvre.expo_id ='".addslashes($this->id)."';
            ;");
        
        if($res == TRUE) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    } 

    //fonction pour delete toutes les oeuvres associées à une exposition
    function delete_all_oeuvre_expo() {
        $res = sql("
            DELETE FROM expo_oeuvre
            WHERE expo_id ='".addslashes($this->id)."' 
            ;");
        
        if($res == TRUE) {
            return TRUE;
        }

        else{
            return FALSE;
        }
    }

    //fonction pour lister les expo avec statut 1
    static function list_check() {
        $res = sql("SELECT id FROM exposition WHERE statut = 1");

        if($res == TRUE && $res != '') {
            foreach ($res as $id) {
                $res = implode(',', $id);
                echo $res.' ';
            }
        }
        else {
            return FALSE;
        }
    }
    

    //fonction pour trouver l'expostion en cours
    static function expo_now() {
        $res = sql("SELECT * FROM exposition WHERE NOW() BETWEEN debut_expo AND fin_expo");

        if($res == TRUE && $res != '') {
            foreach ($res as $expo) {
                return $res;
            }
        }
        else {
            return FALSE;
        }
    }

    //fonction pour lister en Front les oeuvres publiées
    static function list_exposition_front() {
        $res = sql("
            SELECT * FROM exposition WHERE publier = 1;
            ");
        if($res != null) {
            return $res;            
        }
        else {
            return FALSE;
        }
    }

    function list_oeuvre_front() {
        $res = sql("
            SELECT oeuvre.id,oeuvre.nom,oeuvre.description,oeuvre.photo FROM oeuvre
            LEFT JOIN expo_oeuvre
            On expo_oeuvre.oeuvre_id = oeuvre.id
            LEFT JOIN exposition
            On exposition.id = expo_oeuvre.expo_id
            WHERE exposition.id ='".addslashes($this->id)."';
            ");
        if($res != null) {
            return $res;            
        }
        else {
            return FALSE;
        }
    }


    // Fonction d'alerte pour les expositions non validées
    static function alert_exposition() {
        $semaine = 604800;
        $now = time();
        $res = sql("SELECT id,titre,debut_expo,fin_expo FROM exposition WHERE statut=0");
    
        if($res != '') {
            foreach ($res as $key => $exposition) {
                $debut_expo = strtotime($exposition['debut_expo']);
                $diff = $debut_expo - $now;
                
                if($debut_expo > $now && $diff < $semaine) {
                        echo ' <strong><em> - Exposition '.$exposition['titre'].' non validée</em><strong><br>';
                }
            }
        }
        else {
            return FALSE;
        }
    }


}

