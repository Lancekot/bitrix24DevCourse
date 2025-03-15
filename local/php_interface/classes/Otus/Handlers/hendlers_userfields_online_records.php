<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';


// Получение текущего запроса
$request = Bitrix\Main\Context::getCurrent()->getRequest();

// Проверка, является ли запрос POST
if ($request->isPost()) {
    // Получение данных из POST-запроса
    $postData = $request->getPostList()->toArray();


    $path =$_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/classes/Otus/Handlers/log.txt';

//    addFileLog(json_encode($postData, JSON_UNESCAPED_UNICODE), $path);
//
//    addFileLog(json_encode($_SERVER['HTTP_REFERER'], JSON_UNESCAPED_UNICODE), $path);


//    // Обработка данных
//    $this->processPostData($postData);


    \Bitrix\Main\Loader::includeModule('iblock');

    $el = new CIBlockElement();

    $newDate = str_replace('T', ' ', $postData['TIME']) . ":00";
    $prop = [
        'VREMYA_ZAPISI' => $newDate,
        'PRIVYAZKA_K_ELEMENTU' => $postData['PROC_ID'],
    ];

    $arLoadProductArray = [
        'IBLOCK_ID' => 29,
        'PROPERTY_VALUES' => $prop,
        'NAME' => $postData['NAME'],
        'ACTIVE' => 'Y', // активен
    ];


    addFileLog(json_encode($arLoadProductArray, JSON_UNESCAPED_UNICODE), $path);

    if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
        echo 'New IDs: '.$PRODUCT_ID;
    } else {
        echo 'Error: '.$el->LAST_ERROR;
    }











}







//$arr = $iblockId::getList([
//    'select' => [
//        '*',
//        'VREMYA_ZAPISI',
//        'PRIVYAZKA_K_ELEMENTU.ELEMENT'
//
//    ],
//    'filter' => [
//        'ID' => 102
//    ],
//])->fetchObject();
//
//pr($arr->getId());
//
//pr($arr->getVremyaZapisi()->getValue());
//
//pr($arr->get('PRIVYAZKA_K_ELEMENTU')->getElement()->getName());