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
    logger("fields are set , email ".$_POST['email']." mdp ".$_POST['mdp']);
    if(($_POST['email'] == ADMIN_ID) && ($_POST['mdp']==ADMIN_MDP)){
       // admin entrer - set cookie to admin
        setcookie("admin",'true',time()+(60*5), '/');
       // header('Location: http://localhost:8080/files/admin.php');
        logger("IN WE ARE : redirecting to admin");
        $res = 3;
        exit();
    }else {
        $res = connect($_POST['email'], $_POST['mdp']);
        logger("result de la connection " . $res);

    }

    echo $res;
}