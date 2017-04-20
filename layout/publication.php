<?php

require_once "settingspath.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."databaseutility.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."settingspath.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."filemanger.php";
require_once __DIR__ . SLASH."..".SLASH."log".SLASH."looger.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."connection.php";

function create_post($typepost, $legende,$idalbum,$lieu, $emotion, $activite, $contenu, $pap){
    $email = $_COOKIE['user'];
    $datepost=date("Y-m-d H:i:s");
    //$date=DATE_FORMAT($datepost,timestamp);
    //$date=strtotime($datepost);
    $emo= intval ($emotion);
    $type=intval($typepost);
    $pip=intval($pap);
    $alb=intval($idalbum);
    echo $alb;

    if($_COOKIE['user']) {
        //blindage
        $sql = "";
        $sql2="";
        $db = connect_db();
        if ($db->ping()) {
            if ($typepost >= 0 and $typepost < 3) {
                switch ($typepost) {
                    case 0:
                        $sql = "INSERT INTO webapp.post (user, type, legende, lieu,emotion, activiter, privacy)  VALUES ('$email',$type,'$legende','$lieu',$emo,'$activite',$pip)";
                        $sql2 = "SELECT * FROM webapp.post WHERE user='$email' AND legende='$legende' AND type=$type AND lieu='$lieu' AND emotion=$emo AND activiter='$activite' AND privacy=$pip";
                        break;
                    case 1 :
                        if ($idalbum >0) {
                            $sql = "INSERT INTO webapp.post (user, type, legende, idalbum, lieu, emotion, activiter, contenu, privacy)  VALUES ('$email',$type,'$legende',$alb,'$lieu', $emo,'$activite', '$contenu', $pip)";
                        echo "je suis dans les medias";}
                        else $sql = "INSERT INTO webapp.post (user, type, legende, lieu, emotion, activiter, contenu, privacy)  VALUES ('$email',$type,'$legende','$lieu', $emo,'$activite','$contenu', $pip)";
                        $sql2 = "SELECT * FROM webapp.post WHERE user='$email' AND contenu='$contenu'";
                        break;
                }

                $res = mysqli_query($db, $sql);
                echo $res;
                echo "c'eatttttit res";
                if($res)
                {
                    echo "ajouter okay... ?";
                }else echo "c'est soi ce bazare...";
                $res2 = mysqli_query($db, $sql2);
                if ($res2) {
                    //creation reussi
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
                    }


                } else { echo "Ajout Fail";

                    logger("erreur - creation d'un post pour l'utilisateur " . $email);
                }
            } else {
                echo " Fail";
                logger("erreur dans le type du post, type donner :" . $typepost);
            }
        }
    }else{
        echo "cookie";
        logger("erreur de cokkie de sesion");}
}

create_post($_POST['type'], $_POST['legende'],$_POST['idalbum'],$_POST['lieu'],$_POST['emotion'],$_POST['activite'],$_POST['contenu'],$_POST['pap']);

