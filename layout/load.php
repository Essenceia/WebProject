<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/19/17
 * Time: 4:15 PM
 */
require 'settingspath.php';
require __DIR__.SLASH."..".SLASH."log".SLASH."looger.php";
require __DIR__.SLASH."..".SLASH."data".SLASH."cookiemonster.php";
//require "data".SLASH."cookiemonster.php";
logger("calles into load.php");
if(isset($_POST['email']) && isset($_POST['mdp'])){
    logger("fields are set");
    $str = '';
    $res = connect($_POST['email'],$_POST['mdp']);
    logger("result de la connection ".$res);
    switch ($res){
        case 0: $str='';
        //logger("Connection reussi");
        break;
        case 1: $str="Erreur - auqun utilisateur a ce nom";break;
        case 2: $str="Erreur - mauvais mot de passe";break;
        default: $str ='Erreur valheur de etat inconnu'; break;
    }

    echo $str;
}