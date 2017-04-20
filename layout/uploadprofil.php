<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/20/17
 * Time: 11:15 PM
 */
require_once "settingspath.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."databaseutility.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."settingspath.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."filemanger.php";
require_once __DIR__ . SLASH."..".SLASH."log".SLASH."looger.php";
require_once __DIR__.SLASH."..".SLASH."data".SLASH."connection.php";

    $file = $_FILES["file"];
    $name = $_POST["nomfic"];
    if(is_file_valide($file)){
        upload_icon($file,$name);
    }

