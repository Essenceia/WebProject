<?php
    
    require_once "settingspath.php";
    require_once __DIR__.SLASH."..".SLASH."data".SLASH."databaseutility.php";
  //  require __DIR__.SLASH."..".SLASH."data".SLASH."cookiemonster.php";

  //  connect("m.champalier", "ooo");
//    echo ($_POST['password']);
//    echo ($_POST['ancienpwd']);

    if(isset($_POST['nom']) ){
        $res = change_name($_POST['nom']);
        if($res == 0) echo "Nom modifié avec succès";
        else if($res == 1) echo "Problème d'enregistrement de l'utilisateur";
        else if($res == 2) echo "Connexion impossible";
            
    }
    else if(isset($_POST['pseudo']) ){
        $res = change_pseudo($_POST['pseudo']);
        if($res == 0) echo "Pseudo modifié avec succès";
        else if($res == 1) echo "Problème d'enregistrement de l'utilisateur";
        else if($res == 2) echo "Connexion impossible";
    }
    else if(isset($_POST['password']) && isset($_POST['ancienpwd'])){
        if($_POST['password'] != $_POST['ancienpwd']){
            $res = change_pwd($_POST['ancienpwd'], $_POST['password']);
            if($res == 0) echo "Mot de passe modifié avec succès";
            else if($res == 1) echo "Problème d'enregistrement de l'utilisateur";
            else if($res == 2) echo "Connexion impossible";
            else if($res == 3) echo "Mauvais ancien mot de passe";
        }
        else echo "Vous avez entré les mêmes mots de passe";
        
    }
    else if(isset($_POST['photo']) ){
        /*
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        alert(pathinfo($target_file,PATHINFO_EXTENSION));
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        /*
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Fichier trop volumineux";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Veuillez choisir un fichier JPG, JPEG, PNG ou GIF";
            $uploadOk = 0;
        }*/
    }

?>