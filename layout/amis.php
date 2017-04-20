<?php

    require_once "settingspath.php";
    require_once __DIR__.SLASH."..".SLASH."data".SLASH."databaseutility.php";

    
    function addfriend(){
        $email=$_POST['email'];
        $res = friend_request($email);
        if($res==1){
            echo "Demande envoyée !";
        }
        else if($res==0){
            echo "Vous êtes déjà ami avec cette personne";
        }
         else if($res==2){
            echo "Demande d'amis impossible";
        }
         else if($res==3){
            echo "Vous ne pouvez pas vous demander vous-même en ami idiot";
        }
        else if($res==4){
            echo "Vous n'êtes pas connecté";
        }
        else echo "test";
    }

     function supprami(){
        $email=$_POST['emailsuppr'];
        $res = delet_friend($email);
        if($res==1){
            echo "Ami supprimé !";
        }
        else if($res==0){
            echo "Suppression impossible";
        }
        else if($res==2){
            echo "Vous n'êtes pas connecté";
        }
        else if($res==3){
            echo "Connexion impossible";
        }
        else echo "test";
    }

    if(isset($_POST['email'])) {
        addfriend();
    }
    else if (isset($_POST['emailsuppr'])) {
        supprami();
    }
?>