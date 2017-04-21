<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/21/17
 * Time: 1:30 AM
 */
require_once "settingspath.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."databaseutility.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."settingspath.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."filemanger.php";
require_once __DIR__ . SLASH."..".SLASH."log".SLASH."looger.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."connection.php";
require_once "publication.php";
if(isset($_POST['submit'])) {
    $id = $_POST['midpost'];
    logger("In add id to album ".$id);
    $db = connect_db();
    if($db->ping()) {
        $sql = "SELECT * FROM webapp.post WHERE idpost='$id'";
        $res = mysqli_query($db,$sql);
        if($res) {
            logger("FFF");
            $user = get_cookie_name();
            $row = mysqli_fetch_assoc($res);
            $typepost = $row['type'];
            $legende = $row['legende'];
            $idalbum = $_POST['idalbum'];
            $lieu= $row['lieu'];
            $emotion= $row['emotion'];
            $activite= $row['activiter'];
            $contenu= $row['contenu'];
            $pap= $row['privacy'];
            logger($user. " - ".$typepost. " - ".$idalbum. " - ".$contenu. " - ".$pap);
            $sql2 = "INSERT INTO webapp.post (user, type,idalbum, contenu, privacy) 
                   VALUES ('$user','$typepost','$idalbum','$contenu','$pap')";
            $req = mysqli_query($db,$sql2);
            if(mysqli_query($db,$sql2)){
                $res = mysqli_fetch_assoc($req);
                $rrr =$res["idpost"];
                logger("id album 2".$res['idalbum']);
                logger("id album 1".$idalbum);
                logger("id post 1".$id);
                logger("id post 2".$rrr);
                move_file($idalbum,$res['idalbum'],$id,$rrr);
                logger("Moving");
            }else {
                logger("Meeer oving");
            }

            }
    }  header('Location: http://localhost:8080/Chronologie/');
    exit();
}else{
    header('Location: http://localhost:8080/Chronologie/');
    exit();
}