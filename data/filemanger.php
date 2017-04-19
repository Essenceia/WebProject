<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/16/17
 * Time: 4:04 PM
 *
 * Fichier qui gere le les fichier photos et video , ect...
 *
*TODO : ATTENTION : faire attention de bien modifer le define de settingpath correctement
 */
require "settingspath.php";
require __DIR__.SLASH."..".SLASH."log".SLASH."phperrorlog.log";

//cree le dossier dans lequel seront regrouper toutes les donnes d'un utilisateur ainsi que
//fait l'inisialisation des parametres par default
function creat_new_user_directory($email){
    logger("**************Creation du'un directorty for user :".$email."*********************");
    logger("value of root path ".__DIR__.SLASH."..".SLASH."userdata".SLASH.$email. "        ");
   if(is_dir(SLASH."..".SLASH."userdata".SLASH.$email) == false) {
       mkdir(__DIR__.SLASH."..".SLASH."userdata".SLASH. $email, 0755, true);
       mkdir(__DIR__.SLASH."..".SLASH."userdata".SLASH. $email .SLASH."0", 0755, true);
       if (is_dir(__DIR__.SLASH."..".SLASH."userdata".SLASH. $email) and is_dir(__DIR__.SLASH."..".SLASH."userdata".SLASH. $email .SLASH."0")) {
           if (!copy(__DIR__.SLASH."..".SLASH."userdata".SLASH."default".SLASH."fond.jpg", __DIR__.SLASH."..".SLASH."userdata".SLASH. $email . SLASH."fond.jpg")) {
               logger("erreur de copie userdata".SLASH."default".SLASH."fond.jpg");
           }
           if (!copy(__DIR__.SLASH."..".SLASH."userdata".SLASH."default".SLASH."icon.png", __DIR__.SLASH."..".SLASH."userdata".SLASH. $email . SLASH."icon.png")) {
               logger("erreur de copie userdata".SLASH."default".SLASH."icon.png");
           }
       } else {
           logger('Erreur creation de dossier :userdata'.SLASH . $email);
       }
   }logger("Erreur - Cannot find file userdata , check path");
}
function creat_new_user_album($email,$albumname){
    if(!file_exists(__DIR__.SLASH."..".SLASH.'userdata'.SLASH.$email.SLASH.$albumname)) {
    mkdir(__DIR__.SLASH."..".SLASH.'userdata'.SLASH.$email.SLASH.$albumname);
    logger("Creation du dossier poour l'album reussi ".$albumname." user id".$email);
    }
}
/*
 * La photo ou video prendra pour nom la valheur de idpost
 */
function save_post($idpost,$idalbum,$pathtodata)
{
    $extension = strrchr($pathtodata, '.');
    if (move_uploaded_file($pathtodata, __DIR__.SLASH."..".SLASH."userdata".SLASH . $idalbum . $idpost . $extension)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
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
                if (is_dir($dir.SLASH.$object))
                    rrmdir($dir.SLASH.$object);
                else
                    unlink($dir.SLASH.$object);
            }
        }
        rmdir($dir);
        logger("Sucees de la supression du dossier ".$dir);
    }else{
        logger("Erreur dans la supression du dossier".$dir);
    }
}