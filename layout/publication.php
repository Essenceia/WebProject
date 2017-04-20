<?php

require_once "settingspath.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."databaseutility.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."settingspath.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."filemanger.php";
require_once __DIR__ . SLASH."..".SLASH."log".SLASH."looger.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."connection.php";

function create_post($typepost, $legende,$idalbum,$lieu, $emotion, $activite, $contenu, $pap){
    logger("Have entered into publication");
    $email = get_cookie_name();
    //$datepost=date();
    //$date=DATE_FORMAT($datepost,timestamp);
    //$date=strtotime($datepost);
    $emo= intval ($emotion);
    $type=intval($typepost);
    $pip=intval($pap);
    $alb=intval($idalbum);
    echo $alb;

    if(isset($_COOKIE['user'])){
        //blindage
        $username = get_cookie_name();
        $sql = "";
        $sql2="";
        $db = connect_db();
        if ($db->ping()) {
            if ($typepost >= 0 and $typepost < 3) {
                switch ($typepost) {
                    case 0:
                        $sql = "INSERT INTO webapp.post (user, type, legende, lieu,emotion, activiter, privacy)  VALUES ('$email',$type,'$legende','$lieu','$emo','$activite','$pip')";
                        $sql2 = "SELECT * FROM webapp.post WHERE user='$email' AND legende='$legende' AND type=$type AND lieu='$lieu' AND emotion='$emo' AND activiter='$activite' AND privacy='$pip'";
                        $res = mysqli_query($db, $sql);
                        $res2 = mysqli_query($db, $sql2);
                        break;
                    case 1 || 2:
                        //recuperer le fichier
                        if(is_file_valide($_FILES["file"])) {
                            $sql = "INSERT INTO webapp.post (user, type, legende, idalbum, lieu, emotion, activiter, contenu, privacy)  VALUES ('$email',$type,'$legende',$alb,'$lieu', '$emo','$activite', '$contenu', '$pip')";
                            $sql2 = "SELECT * FROM webapp.post WHERE user='$email' AND contenu='$contenu'";
                            $res = mysqli_query($db, $sql);
                            $res2 = mysqli_query($db, $sql2);
                            if ($res2) {
                                if(mysqli_fetch_assoc($res2)) {
                                    $row = mysqli_fetch_assoc($res2);
                                    $idpost = $row["idpost"];
                                    upload_file($_FILES['file'],$alb,$idpost);
                                }

                        }  else{
                    $res = false;
                    $res2 = false;
                }}  else{
                                $res = false;
                                $res2 = false;
                            }
                        /*
                        $allowedExts = array("gif", "jpeg", "jpg", "png");
                        $temp = explode(".", $_FILES["file"]["name"]);
                        $extension = end($temp);
                        $label = "WEBUPLOAD";
                        $uploadfile = __DIR__.SLASH."..".SLASH."userdata".SLASH.$username.SLASH.$idalbum;
                        if ((($_FILES["file"]["type"] == "image/gif")
                                || ($_FILES["file"]["type"] == "image/jpeg")
                                || ($_FILES["file"]["type"] == "image/jpg")
                                || ($_FILES["file"]["type"] == "image/pjpeg")
                                || ($_FILES["file"]["type"] == "image/x-png")
                                || ($_FILES["file"]["type"] == "image/png"))
                            && ($_FILES["file"]["size"] < 200000)
                            && in_array($extension, $allowedExts)) {
                            if ($_FILES["file"]["error"] > 0) {
                                logger("Return Code: " . $_FILES["file"]["error"]);
                            } else {
                                $filename = $label . $_FILES["file"]["name"];
                                logger("Upload: " . $_FILES["file"]["name"]);
                                logger("Type: " . $_FILES["file"]["type"]);
                                logger("Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>");
                                logger("Temp file: " . $_FILES["file"]["tmp_name"]);
                                if (is_dir($uploadfile)) {
                                    move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfile . SLASH . $filename);
                                    logger("Stored in: " . $uploadfile . SLASH . $filename);
                                }else{
                                    logger("Directory does not existe ".$uploadfile);
                                }
                            }
                            if ($idalbum > 0) {
                                $sql = "INSERT INTO webapp.post (user, type, legende, idalbum, lieu, emotion, activiter, contenu, privacy)  VALUES ('$email',$type,'$legende',$alb,'$lieu', '$emo','$activite', '$contenu', '$pip')";
                                echo "je suis dans les medias";
                            } else $sql = "INSERT INTO webapp.post (user, type, legende, lieu, emotion, activiter, contenu, privacy)  VALUES ('$email',$type,'$legende','$lieu', '$emo','$activite','$contenu', '$pip')";
                            $sql2 = "SELECT * FROM webapp.post WHERE user='$email' AND contenu='$contenu'";
                        }else{logger("fichier invalide");}
                        */
                        break;
                }

                $res = mysqli_query($db, $sql);
                $res2 = mysqli_query($db, $sql2);
                if ($res2) {
                   /* //creation reussi
                    if(mysqli_fetch_assoc($res2))
                    {
                        $row=mysqli_fetch_assoc($res2);
                        $idpost = $row["idpost"];
                        echo "Ajout Réussi !";
                        if ($typepost > 0) {
                            //TODO sauvgarde de la photo ou video poster dans le dossier adequa
                            if (save_post($idpost, $idalbum, $contenu)) {
                                logger("sucees - creation d'un post pour l'utilisateur " . $email);
                            } else logger("erreur - creation d'un post pour l'utilisateur " . $email);
                        }
                    }*/


                } else { echo "Ajout Fail";

                    logger("erreur - creation d'un post pour l'utilisateur " . $email);
                }
            } else {
                echo " Fail";
                logger("erreur dans le type du post, type donner :" . $typepost);
            }
        }else{
            logger("Erreur de connection a la base de donner");
        }
    }else{
        echo "cookie";
        logger("erreur de cokkie de sesion");}
}
if($_POST['type']==0){
    $contenu = $_FILES["file"];
    logger("file detected");
}else{
    $contenu = $_POST['contenu'];
    logger("text detected");
}
create_post($_POST['type'],
    $_POST['legende'],
    $_POST['idalbum'],
    $_POST['lieu'],
    $_POST['emotion'],
    $_POST['activite'],
    $contenu,
    $_POST['pap']);

