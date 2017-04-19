<?php
    
    require "settingspath.php";
    require __DIR__.SLASH."..".SLASH."data".SLASH."databaseutility.php";



    if(isset($_POST['nom']) ){
        change_name($_POST['nom']));
    }
    else if(isset($_POST['email']) ){
    
    }
    else if(isset($_POST['pseudo']) ){

    }
    else if(isset($_POST['password']) && isset($_POST['ancienpwd'])){

    }
    else if(isset($_POST['password']) ){
        
    }
?>