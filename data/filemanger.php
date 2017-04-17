<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/16/17
 * Time: 4:04 PM
 *
 * Fichier qui gere le les fichier photos et video , ect...
 *
*TODO : ATTENTION : je tourne sous un systeme UNIX mes path utilise des '/'
 * TODO :alors que sur vos odi il ce peut que sa soit des '\'
 */
require __DIR__."/../log/phperrorlog.log";

//cree le dossier dans lequel seront regrouper toutes les donnes d'un utilisateur ainsi que
//fait l'inisialisation des parametres par default
function creat_new_user_directory($email){
   if(!file_exists('userdata/'.$email)){
        mkdir('userdata/'.$email, 0755, true);
        if(!copy('userdata/default/fond.jpg','userdata/'.$email.'/fond.jpg')){
            logger("erreur de copie userdata/default/fond.jpg");
        }
       if(!copy('userdata/default/icon.png','userdata/'.$email.'/icon.png')){
           logger("erreur de copie userdata/default/icon.png.jpg");
       }
    }else{
       logger('Erreur creation de dossier :userdata/'.$email);
   }
}
function creat_new_user_album($email,$albumname){

}