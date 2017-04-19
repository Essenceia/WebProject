<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/18/17
 * Time: 10:51 PM
 */
require_once  "databaseutility.php";
define('NUMBER_PER_PAGE',10);
function get_post_actualiter($pagenum,$email){
    $db = connect_db();
    //$email = $_COOKIE['user'];
    $data = [];
    $num = (int)NUMBER_PER_PAGE;
    $offset = (int)NUMBER_PER_PAGE*$pagenum;
    logger("valeheur de offset ".$offset." num per page ".$num);
    if($db->ping()){
        if($email){
            //TODO a trouver pourquoi la recherche a partir d'une limite ne fonctionne pas
            $sql = "SELECT * FROM webapp.post WHERE user='$email' ORDER BY date DESC LIMIT 10 OFFSET 0 ";
            //$sql = "SELECT * FROM webapp.post WHERE user='$email' ORDER BY date DESC ";

            $res = mysqli_query($db,$sql);
            for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                $data[$i] = mysqli_fetch_assoc($res);}
            logger("resutltat trouver , nombre de row : ".mysqli_num_rows($res) );

        }else{
            logger("erreur de cokkie de sesion");}
    }
    else{
        logger("erreur connection base de donner");}
        return $data;

}
function get_post_data($idpost){
    $data=[];
    $db = connect_db();
    if($db->ping()){
        $sql= "SELECT * from webapp.post WHERE idpost='$idpost' ";
        $res = mysqli_query($db,$sql);
        if ($res) {
            $data = mysqli_fetch_assoc($res);
            logger("sucees - post trouver avec id ".$idpost);
        }else{
            logger("erreur - post pas trouver ".$idpost);
        }
    }else{
        logger("erreur connection base de donner - post data ");}
    return $data;
}
function get_comment_from_post($idpost){
    $data=[];
    $db = connect_db();
    if($db->ping()){
        $sql= "SELECT * from webapp.reaction WHERE idpost='$idpost' ORDER BY date DESC ";
        $res = mysqli_query($db,$sql);
        for ($i = 0; $i < mysqli_num_rows($res); $i++) {
            $data[$i] = mysqli_fetch_assoc($res);
        logger("sucees - reaction au post ".$idpost." trouver avec id ".$data[$i]['id']);
        }
    }else{
        logger("erreur connection base de donner - get comment from post");}
    return $data;
}
function get_chronologie($pagenum){
    $db = connect_db();
    $email = $_COOKIE['user'];
    $data = [];
    $num = NUMBER_PER_PAGE;
    $offset = NUMBER_PER_PAGE*$pagenum;
    if($db->ping()){
        if($email){
            //recuperer ta liste d'amie
            $sql = "SELECT post.idpost from webapp.amis, webapp.post 
            WHERE ((amis.user1 = '$email' OR amis.user2='$email') AND amis.status=1 AND post.privacy=1)
            OR post.privacy = 2
             ORDER BY post.date LIMIT 10 OFFSET 0 ";
            $res = mysqli_query($db,$sql);
            for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                $id = mysqli_fetch_assoc($res);
                $data[$i]['post'] = get_post_data($id['idpost']);
                $data[$i]['comment'] = get_comment_from_post($id['idpost']);
            }logger("nous avons trouver ".mysqli_num_rows($res)." post pour l'utilisateur ".$email);

        }else{
            logger("erreur de cokkie de sesion");}
    }
    else{
        logger("erreur connection base de donner");}
    return $data;
}