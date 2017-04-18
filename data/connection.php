<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/18/17
 * Time: 12:32 PM
 */
function connect_db() {
    $server = 'localhost'; // this may be an ip address instead
    $user = 'root';
    $pass = '';
    $database = 'webapp';
    
    $db_handle =  mysqli_connect($server, $user, $pass);
    $connection = mysqli_select_db($db_handle, $database );
    
    // Check connection
    if(!$connection){
        //logger("erreur de connection a la base de donne");
        die("Connection failed: " . $connection->connect_error);
    }
    else {
        //logger("Connection sucessfull");
        return $connection;
    }
}