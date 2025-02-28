<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");


















//test_list
//

$iblockId = \Bitrix\Main\Config\Option::get('otus.homework', 'test_iblock_id');

pr($iblockId);



//$fff = getColumn();
//
//pr($fff);


//$arr = $b::getList([
//    'select' => [
//        'NAME'
//    ],
//    'filter' => [
//    ]
//])->fetch();
//
//pr($arr);

//$arr = \Bitrix\Iblock\IblockTable::getList([
//    'select' => [
//    ],
//    'filter' => [
//        'ID' => 24
//    ]
//])->getMap();
//
//pr($arr);








require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");




