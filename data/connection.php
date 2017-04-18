<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/18/17
 * Time: 12:32 PM
 */
function connect_db() {
    $server = 'localhost'; // this may be an ip address instead
    $user = 'julia';
    $pass = 'julia';
    $database = 'webapp';
    $connection = new mysqli($server, $user, $pass,$database);
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