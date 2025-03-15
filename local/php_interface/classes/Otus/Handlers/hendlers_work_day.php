<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

// Получение текущего запроса
$request = Bitrix\Main\Context::getCurrent()->getRequest();

// Проверка, является ли запрос POST
if ($request->isPost()) {
    // Получение данных из POST-запроса
    $postData = $request->getPostList()->toArray();

    global $USER;

// Проверяем, авторизован ли пользователь
    if ($USER->IsAuthorized()) {
        $userId = $USER->GetID();
    } else {
        die();
    }

    if($postData['STATUS_DAY'] == 'CLOSE'){
        Otus\Timemannn\PopapWorkTimeman::openWorkDay($userId);
    }

    if($postData['STATUS_DAY'] == 'OPEN'){
        Otus\Timemannn\PopapWorkTimeman::closeWorkDay($userId);
    }
}







