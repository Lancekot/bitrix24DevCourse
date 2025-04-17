<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

use Bitrix\Main\Loader;
use OTUSPROJECT\Handlers\ManagerCrmEntyty;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

// Проверка, является ли запрос POST
if ($request->isPost()) {
    // Получение данных из POST-запроса
    $postData = $request->getPostList()->toArray();

    $path = $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/classes/Otus/Handlers/log.txt';

    addFileLog(json_encode($postData, JSON_UNESCAPED_UNICODE), $path);

    addFileLog('Начала получения deals', $path);
    $deals = ManagerCrmEntyty::checkAllDealByContact($postData['CONTACT_ID']);
    addFileLog('Конец получения deals', $path);
    addFileLog(json_encode($deals, JSON_UNESCAPED_UNICODE), $path);





// Ваш код обработки данных
    $response = [
        'status' => 'success',
        'message' => 'Данные успешно обработаны',
        'fields' => $deals
    ];
    header('Content-Type: application/json');
// Возвращаем ответ в формате JSON
    echo json_encode($response);

}





















;