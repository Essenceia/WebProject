<?php
    
    require "settingspath.php";
    require __DIR__.SLASH."..".SLASH."data".SLASH."databaseutility.php";



    if(isset($_POST['nom']) ){
        $res = change_name($_POST['nom']);
        if($res == 0) echo "Nom modifié avec succès";
        else if($res == 1) echo "Problème d'enregistrement de l'utilisateur";
        else if($res == 2) echo "Connexion impossible";
            
    }
    else if(isset($_POST['email']) ){
        $res = change_email($_POST['email']);
        if($res == 0) echo "Email modifié avec succès";
        else if($res == 1) echo "Problème d'enregistrement de l'utilisateur";
        else if($res == 2) echo "Connexion impossible";
    }
    else if(isset($_POST['pseudo']) ){

    }
    else if(isset($_POST['password']) && isset($_POST['ancienpwd'])){

    }
    else if(isset($_POST['password']) ){
        
    }
?>