<?php

define('DEBUG_FILE_NAME', $_SERVER['DOCUMENT_ROOT'].'/logs/' . date("Y-m-d") . '.log');

include_once __DIR__ . '/../Apps/Otus/autoload.php';


//if(file_exists(__DIR__."/config.php". '/classes/autoload.php')){
//    require_once __DIR__. '/classes/autoload.php';
//}


function pr($var, $type = false){
    echo '<pre style="font-size:10px; border:1px solid #000; text-align: left">';
    if($type){
        var_dump($var);
    }else{
        print_r($var);
    }
    echo '</pre>';
}



