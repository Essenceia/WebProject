<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/16/17
 * Time: 5:00 PM
 */
function logger($string){
    $str = $string.'\n';
    error_log($str);
    //error_log($str, 3, "log/phperrorlog.log");
}