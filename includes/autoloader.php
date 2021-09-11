<?php
spl_autoload_register('autoloader');

function autoloader($class){
    $dir = ['classes/controllers/', 'classes/models/', 'classes/database/'];
    $ext = '.class.php';

    foreach($dir as $dir){
        $path = './'.$dir.$class.$ext;
        if(file_exists($path)){
            include $path;
        }
    }
}