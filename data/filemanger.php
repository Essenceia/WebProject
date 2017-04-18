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
       mkdir('userdata/'.$email."/0", 0755, true);
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
/*
 * La photo ou video prendra pour nom la valheur de idpost
 */
function save_post($idpost,$idalbum,$pathtodata)
{
    $extension = strrchr($pathtodata, '.');
    if (move_uploaded_file($pathtodata, "userdata/" . $idalbum . $idpost . $extension)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
    {
        echo 'Upload effectué avec succès !';
        return 1;
    } else //Sinon (la fonction renvoie FALSE).
    {
        echo 'Echec de l\'upload !';
        return 0;
    }
}
/*
 * Fonction de remove recursive d'un dossier
 */
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir."/".$object))
                    rrmdir($dir."/".$object);
                else
                    unlink($dir."/".$object);
            }
        }
        rmdir($dir);
        logger("Sucees de la supression du dossier ".$dir);
    }else{
        logger("Erreur dans la supression du dossier".$dir);
    }
}