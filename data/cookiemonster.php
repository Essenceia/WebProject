<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/18/17
 * Time: 1:50 PM
 */
define("ADMIN_ID",'admin');
define("ADMIN_MDP",'admin');
require_once "databaseutility.php";
function connect($email, $mdp){
        disconnect();
  $state = connect_datavalide($email, $mdp);
  if ($state == 0) {
      // creation d'un cookie avec le nom de l'utilisateur - valable 20 minuter
      setcookie("user", $email, time() + (60 * 2000), '/');

      // logger("Cookie activer au nom de ".$email);

  }
  return $state;
}
function get_cookie_name(){
    if(isset($_COOKIE['admin'])){
        header('Location: http://localhost:8080/files/admin.php');
        exit();
    }else {
        if (!isset($_COOKIE['user'])) {
            header('Location: http://localhost:8080/');
            // logger("IN WE ARE : redirecting header");
            exit();
        } else {
            return $_COOKIE['user'];
        }
    }
}
function disconnect(){

        if(isset($_COOKIE['user'])) { $user = $_COOKIE['user'];
        setcookie("user", $user, time() - 60*200,'/');}
    if(isset($_COOKIE['admin'])){
        setcookie("admin", "true", time() - 60*200,'/');}
        //logger("Cookie destoryed au nom de ".$user);

    //logger("Erreur - pas de cookie valide detecter");
}