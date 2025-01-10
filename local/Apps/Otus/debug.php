<?php
require $_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php';


//function writeToLog($data, $title = ''){
//    if (!DEBUG_FILE_NAME)
//        return false;
//    $log = "\n------------------------\n";
//    $log .= date("Y.m.d G:i:s")."\n";
//    $log .= (strlen($title) > 0 ? $title : 'DEBUG')."\n";
//    $log .= print_r($data, 1);
//    $log .= "\n------------------------\n";
//    file_put_contents(DEBUG_FILE_NAME, $log, FILE_APPEND);
//    return true;
//}




$dealarr = \Bitrix\DealTable::getList([
    'filter' => [
        'ID' => 9,
    ],
    'select' => [
        'ID',
    ]
]);



print_r($dealarr);


require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php';