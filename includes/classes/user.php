<?php

      //////////////////////////////
      // Classe USER (24.03.17)/////
      //////////////////////////////

Class User {

  private $id;
  private $nom;
  private $fonction;
  private $email;

  function __construct($id = 0) {
    if($id != 0) {
      $user = sql("SELECT id,nom,fonction,email FROM user WHERE id = '".addslashes($id)."'");
      $u = $user[0];
      $this->id = $u['id'];
      $this->nom = $u['nom'];
      $this->fonction = $u['fonction'];
      $this->email = $u['email'];
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

  function getFonction() {
    return $this->fonction;
  }

  function setFonction($fonction) {
    $this->fonction = $fonction;
  }

  function getEmail() {
    return $this->email;
  }

  function setEmail($email) {
    $this->email = $email;
  }


  // Fonction pour enregistrer un nouveau user ou pour le modifier
  function push($password) {

    if(empty($this->id)) {
      $InsertUser = sql("
        INSERT INTO user VALUES (
        NULL,
        '".addslashes(trim($this->nom))."',
        '".addslashes($this->fonction)."',
        '".addslashes(md5($password))."',
        '".addslashes(trim($this->email))."'
        )");
      
      if($InsertUser !== FALSE) {
        $this->id = $InsertUser;
        return TRUE;
      }
      else {
        return FALSE;
      }

    }

    else {
      if(is_numeric($this->id)) {
        $UpdateUser = sql("
          UPDATE user SET 
          nom = '".addslashes(trim($this->nom))."',
          fonction = '".addslashes($this->fonction)."',
          mdp = '".addslashes(md5($password))."',
          email = '".addslashes(trim($this->email))."'
          WHERE id = '".addslashes($this->id)."'
          ");

        return $UpdateUser;
      }
      else {
        return FALSE;
      }
    }
  }
   

  // Fonction qui supprime un utilisateur
  function delete() {
    $res = sql("DELETE FROM user WHERE id='".addslashes($this->id)."'");
    
    if($res) {
      if($this->id != $_SESSION['id']) {
        header('utilisateurs.php');
        return TRUE;
      }
      else{
        // 301 Moved Permanently
        header("Location: login.php",TRUE,301);
        return TRUE;
      }
    }
    else {
      return FALSE;
    }
  }


  // Fonction qui permet de voir si un utilisateur possede le même nom ou adresse mail dans la bdd
  // INSERT et UPDATE
  function checkUserBdd($nom, $email, $oldName, $oldEmail) {

    // On applique la fonction "trim" pour supprimer les espaces début + fin
    $name = sql("SELECT nom FROM user WHERE nom='".addslashes(trim($nom))."'");
    $mail = sql("SELECT email FROM user WHERE email ='".addslashes(trim($email))."'");
    $count_name = count($name);
    $count_mail = count($mail);

    // On vérifie la Bdd avec un INSERT
    if (empty($_POST['id'])) {

      if($count_name == 1) {
        echo 'Un utilisateur possède déjà ce nom';
        return FALSE;
      }

      elseif ($count_mail == 1) {
        echo 'Un utilisateur possède déjà la même adresse mail';
        return FALSE;
      }

      else {
        return TRUE;
      }
    } 

    // On vérifie la Bdd avec un UPDATE
    else {
      if($count_name == 1 || $count_mail == 1) {

        if($oldName == $nom && $oldEmail == $email) {
          return TRUE;
        }

        elseif($oldName == $nom && $count_mail == 0) {
          return TRUE;
        }

        elseif ($count_name == 0 && $oldEmail == $email) {
          return TRUE;
        }

        else {
          echo "Un utilisateur possède déjà ce nom et-ou cette adresse mail ";
          return FALSE;
        }
      }
      else {
        return TRUE;
      }
    }  
  }


  //  Fonction qui permet de vérfier la sécurtié du mot de passe
  function secureMdp($mdp) {

    // Condition pour que le mot de passe comporte des lettres et des chiffres
    if(!preg_match("/(([a-z][0-9])|([0-9][a-z])|[A-Z][0-9]|([0-9][A-Z]))/", $mdp)) {
      return FALSE;
    }
    
    // Condition pour que le mot de passe comporte plus de 8 charactères
    elseif(strlen($mdp) < 8) {
      return FALSE;
    }

    else {
      return TRUE;
    }
  }


  // Fonction qui affiche le formulaire d'inscription ou de modification de compte utilisateur
  function form($target = 'utilisateurs.php') {
      
     echo 
      '<form method="post" action="'.$target.'" class="col-md-4 col-md-offset-1 form-background">
      
        <div class="form-group">
          <label class="control-label">Nom</label>
          <input type="text" name="name" class="form-control" placeholder="Nom" value="'.$this->getNom().'" required>
        </div>

        <div class="form-group">
            <label class="control-label">Fonction</label>
            <select name="fonction" class="form-control" required>
            ';

            $res = sql("SELECT fonction FROM user WHERE id='".addslashes($this->getId())."'"); 
            $test = implode(',', $res[0]); 

            if($_SESSION['id'] == 1) {

              switch ($test) {
                case 'Administrateur':
                  echo '
                  <option value="Administrateur" selected="selected">Administrateur</option>
                  <option value="Responsable Communication">Responsable Communication</option>
                  <option value="Responsable Technique">Responsable Technique</option>
                  <option value="Assistant(e)">Assistant(e)</option>
                  <option value="Technicien(ne)">Technicien(ne)</option>
                  <option value="Chargé(e) de Communication">Chargé(e) de Communication</option>
                  <option value="Traducteur">Traducteur</option>
                  ';
                  break;

                case 'Responsable Communication':
                  echo'
                  <option value="Responsable Communication" selected="selected">Responsable Communication</option>
                  <option value="Responsable Technique">Responsable Technique</option>
                  <option value="Assistant(e)">Assistant(e)</option>
                  <option value="Technicien(ne)">Technicien(ne)</option>
                  <option value="Chargé(e) de Communication">Chargé(e) de Communication</option>
                  <option value="Traducteur">Traducteur</option>
                  ';
                  break;

                case 'Responsable Technique':
                  echo'
                  <option value="Responsable Communication">Responsable Communication</option>
                  <option value="Responsable Technique" selected="selected">Responsable Technique</option>
                  <option value="Assistant(e)">Assistant(e)</option>
                  <option value="Technicien(ne)">Technicien(ne)</option>
                  <option value="Chargé(e) de Communication">Chargé(e) de Communication</option>
                  <option value="Traducteur">Traducteur</option>
                  ';
                  break;

                case 'Assistant(e)':
                  echo'
                  <option value="Responsable Communication">Responsable Communication</option>
                  <option value="Responsable Technique">Responsable Technique</option>
                  <option value="Assistant(e)" selected="selected">Assistant(e)</option>
                  <option value="Technicien(ne)">Technicien(ne)</option>
                  <option value="Chargé(e) de Communication">Chargé(e) de Communication</option>
                  <option value="Traducteur">Traducteur</option>
                  ';
                  break;

                case 'Technicien(ne)':
                  echo'
                  <option value="Responsable Communication">Responsable Communication</option>
                  <option value="Responsable Technique">Responsable Technique</option>
                  <option value="Assistant(e)">Assistant(e)</option>
                  <option value="Technicien(ne)" selected="selected">Technicien(ne)</option>
                  <option value="Chargé(e) de Communication">Chargé(e) de Communication</option>
                  <option value="Traducteur">Traducteur</option>
                  ';
                  break;

                case 'Chargé(e) de Communication':
                  echo'
                  <option value="Responsable Communication">Responsable Communication</option>
                  <option value="Responsable Technique">Responsable Technique</option>
                  <option value="Assistant(e)">Assistant(e)</option>
                  <option value="Technicien(ne)">Technicien(ne)</option>
                  <option value="Chargé(e) de Communication" selected="selected">Chargé(e) de Communication</option>
                  <option value="Traducteur">Traducteur</option>
                  ';
                  break;
                
                default:
                  echo'
                  <option value="Responsable Communication">Responsable Communication</option>
                  <option value="Responsable Technique">Responsable Technique</option>
                  <option value="Assistant(e)">Assistant(e)</option>
                  <option value="Technicien(ne)">Technicien(ne)</option>
                  <option value="Chargé(e) de Communication">Chargé(e) de Communication</option>
                  <option value="Traducteur" selected="selected">Traducteur</option>
                  ';
                  break;
              }

            }

            else {
              echo 
              '
              <option value="'.$this->getFonction().'">'.$this->getFonction().'</option>
              ';
            }

            echo '</select>
          </div>


          <div class="form-group">
            <label class="control-label">Mot de passe</label><br>
            <span><em>Votre mot de passe doit comporter des chiffres et des lettres et doit faire plus de 8 charactères<em></span>
            <input type="password" name="mot_de_passe1" class="form-control" placeholder="Mot de passe" required>
          </div>

          <div class="form-group">
            <label class="control-label">Confirmer votre mot de passe</label>
            <input type="password" name="mot_de_passe2" class="form-control" placeholder="Retaper son mot de passe" required>
          </div>

          <div class="form-group">
            <label class="control-label">Adresse Mail</label>
            <input type="email" name="email" class="form-control" placeholder="Adresse mail" value="'.$this->getEmail().'" required> 
          </div>

          <input type="hidden" name="id" value ="'.$this->getId().'">

          <button type="submit" class="btn btn-primary" value="Valider">Valider</button>
      </form>';
      }


  // Fonction pour vérifier la connexion: login et mdp
  static function checkUser($nom,$password) {
    $res = sql("
        SELECT id
        FROM user
        WHERE nom = '".addslashes($nom)."'
        AND mdp = '".addslashes($password)."' LIMIT 1");
    if($res === FALSE) {
        return FALSE;
    }
    else{
        $total = count($res);
        if($total != 1) {
            return FALSE;
        }
        else {
            return new User($res[0]['id']);
        }
    }
  }


  // Fonction qui liste tous les utilisateurs
  static function listUser() {
    $res = sql("
      SELECT id FROM user"
    );

    if($res != '') {
      $list = array();
      foreach($res as $user) {
        array_push($list, new User($user['id']));
      }
      return $list;
    }
    else {
      return FALSE;
    }

  }

}   






































