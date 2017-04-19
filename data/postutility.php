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
    $num = NUMBER_PER_PAGE;
    $offset = NUMBER_PER_PAGE*$pagenum;
    if($db->ping()){
        if($email){
            //TODO a trouver pourquoi la recherche a partir d'une limite ne fonctionne pas
            //$sql = "SELECT * FROM webapp.post WHERE user='$email' ORDER BY date DESC LIMIT '$num' OFFSET '$offset'";
            $sql = "SELECT * FROM webapp.post WHERE user='$email' ORDER BY date DESC ";

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
