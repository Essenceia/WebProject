<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/18/17
 * Time: 1:50 PM
 */

require_once "databaseutility.php";
function connect($email, $mdp){

   /* if(!$_COOKIE['user']){
        disconnect();
    }*/
  $state = connect_datavalide($email, $mdp);
  if ($state == 0){
      // creation d'un cookie avec le nom de l'utilisateur - valable 20 minuter
      setcookie("user",$email,time()+(60*20),'/');
      logger("Cookie activer au nom de ".$email);
  }
  return $state;
}
function disconnect(){
    if(isset($_COOKIE['user'])){
        $user = $_COOKIE['user'];
        setcookie("user", $user, time() - 3600,'/');
        logger("Cookie destoryed au nom de ".$user);
    }
    logger("Erreur - pas de cookie valide detecter");
}