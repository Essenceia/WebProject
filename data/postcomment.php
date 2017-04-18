<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/18/17
 * Time: 9:33 AM
 */
require_once "databaseutility.php";

if (isset($_POST['requete']))
{
    //on vas cree un post
    $type = 0;

    echo $_POST['requete'];
}
