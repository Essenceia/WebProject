<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/18/17
 * Time: 4:27 PM
 *
 * 0 - path linux /
 * 1 - path windows \
 */
if(!defined('PATH')) {
    define('PATH', 0);

    if (PATH == 0) {
        $slash = '/';
    } else {
        $slash = '\\';
    }
    define('SLASH', $slash);
}
