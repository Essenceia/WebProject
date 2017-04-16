<?php
/**
 * Created by PhpStorm.
 * User: essen
 * Date: 4/15/17
 * Time: 11:48 AM
 */
function connect_db() {
    $server = 'localhost'; // this may be an ip address instead
    $user = 'julia';
    $pass = 'julia';
    $database = 'webapp';
    $connection = new mysqli($server, $user, $pass,$database);
    // Check connection
    return $connection;
}

function get_email($prefix){
    $ret = $prefix . "@edu.ece.fr";
    return $ret;
}
function get_friend_status($row){
    if($row["status"]==1){
        return "L'utilisateur ".get_email($row["user1"])." et ".get_email($row["user2"])." sont ami depuis le ".$row["date"]." <br>";
    }
    else return "L'utilisateur ".get_email($row["user1"])." a demander en amis ".get_email($row["user2"])." le ".$row["date"]." <br>";
}
/*
 * Permet de recuperer les emails des amies du l'utilisateur dont l'id est passer en argument
 */
function friend_list($userid,$db){
    echo "<br> <h6> Acriviter de la liste d'ami </h6> <h5><ul>";
    $sqlquery = "SELECT * FROM webapp.amis  WHERE user1='$userid'  OR user2='$userid' ";
    $res = mysqli_query($db,$sqlquery);
    if (mysqli_num_rows($res) > 0) {
        // output data of each row

        while($row = mysqli_fetch_assoc($res)) {
            echo "<li>".get_friend_status($row)."</li>";
              }
    } else {
        echo "<li>0 results</li>";
    }
    echo "</h5> </ul>";
}
