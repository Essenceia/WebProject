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
require_once "settingspath.php";
require_once "cookiemonster.php";
require_once __DIR__.SLASH."..".SLASH."log".SLASH."phperrorlog.log";

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
/*
function save_post($idpost,$idalbum,$pathtodata)
{
    $extension = strrchr($pathtodata, '.');
    if (move_uploaded_file($pathtodata, __DIR__.SLASH."..".SLASH."userdata".SLASH . $idalbum . SLASH.$idpost . $extension)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
    {
        echo 'Upload effectué avec succès !';
        if(rename("/tmp/tmp_file.txt", "/home/user/login/docs/my_file.txt");)
        return 1;
    } else //Sinon (la fonction renvoie FALSE).
    {
        echo 'Echec de l'upload !';
        return 0;
    }
}*/
/*
 * Fonction de remove recursive d'un dossier
 */
function rrmdir($dir) {
    //logger("Nous sommes dans le dossier ".__DIR__. " et avons recu comme parametre ".$dir);
    $dir = __DIR__.SLASH."..".SLASH.$dir;
    if (is_dir($dir)) {
       /* array_map('unlink', glob("$dir./*.*"));
        rmdir($dir);*/
        system("rm -rf ".escapeshellarg($dir));
        logger("Sucees de la supression du dossier ".$dir);
    }else{
        logger("Erreur dans la supression du dossier".$dir);
    }
}

function change_icon($path,$is_fond){
    if($is_fond){
        $name = "fond.png";
    }else{
        $name = "icon.png";
    }
    $email = get_cookie_name();
    if(is_dir(SLASH."..".SLASH."userdata".SLASH.$email) == true){
        if (!copy($path, __DIR__.SLASH."..".SLASH."userdata".SLASH. $email . SLASH.$name)) {
            logger("erreur de copie userdata de ".$path." vers ".__DIR__.SLASH."..".SLASH."userdata".SLASH. $email . SLASH.$name);
        }

    }else{
        logger("erreur le dossier n'existe pas ".SLASH."..".SLASH."userdata".SLASH.$email);
    }

}
function is_file_valide($file){
$allowedExts = array("png");
    $temp = explode(".", $file["name"]);
    $extension = end($temp);
    if ((($file["type"] == "image/png"))&& ($file["size"] < 200000)&& in_array($extension, $allowedExts)) {
        if ($file["error"] > 0) {
            echo("Erreur detected dans le fichier: " . $file["error"]);
        } else{return true;}
    }
    else{ echo "Fichier pas valable : nous acceptons que les .png de moi de 200k ";
    return false;
    }
}
function upload_file($file,$idalbum,$idpost){
    $username = get_cookie_name();

    $uploadfile = __DIR__.SLASH."..".SLASH."userdata".SLASH.$username.SLASH.$idalbum;

            $filename = $file["name"];
            $extension = strrchr($filename, '.');
            logger("Upload: " . $file["name"]);
            logger("Type: " . $file["type"]);
            logger("Size: " . ($file["size"] / 1024) . " kB<br>");
            logger("Temp file: " . $file["tmp_name"]);
            if (is_dir($uploadfile)) {
                move_uploaded_file($file["tmp_name"], $uploadfile . SLASH . $filename);
                rename($uploadfile . SLASH . $filename, $uploadfile . SLASH . $idpost.$extension);
                logger("Stored in: " . $uploadfile . SLASH . $idpost);
            }else{
                logger("Directory does not existe ".$uploadfile);
            }
        }
function upload_icon($file,$name){
    $username = get_cookie_name();
    $filename = $file["name"];
    $uploadfile = __DIR__.SLASH."..".SLASH."userdata".SLASH.$username;
    if (is_dir($uploadfile)) {
        move_uploaded_file($file["tmp_name"], $uploadfile . SLASH . $filename);
        rename($uploadfile . SLASH . $filename, $uploadfile . SLASH . $name);
        logger("Stored in: " . $uploadfile . SLASH . $name);
    }else{
        logger("Directory does not existe ".$uploadfile);
    }
}
