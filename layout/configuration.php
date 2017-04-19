<?php
    
    require "settingspath.php";
    require __DIR__.SLASH."..".SLASH."data".SLASH."databaseutility.php";
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
        
    }
?>