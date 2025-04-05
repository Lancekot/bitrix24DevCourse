<?php

use Bitrix\Main;

$eventManager = Main\EventManager::getInstance();

//Вешаем свой обработчик

//Пользователеькое поле "Выбор цвета" для модуля Main (CRM, TASK и т.д.)
//$eventManager->addEventHandler('main', 'OnUserTypeBuildList', ['Otus\UserType\CUserTypeColor', 'GetUserTypeDescription']);

//// APOK
////Добавляю обработчик события добавления дела в таймлайн
//AddEventHandler("crm", "\Bitrix\Crm\Timeline\Entity\Timeline::OnAfterAdd", "hendlerTimelineByDeal");
//
//function hendlerTimelineByDeal($timeline_el_id)
//{
//    $path =$_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/classes/Otus/Handlers/log.txt';
//
//    try{
//
//        $timelineRecord = \Bitrix\Crm\Timeline\Entity\TimelineTable::getById($timeline_el_id)->fetch();
//
//        addFileLog('Инфо по timeline', $path);
//        addFileLog(json_encode( $timelineRecord, JSON_UNESCAPED_UNICODE), $path);
//
//
//        addFileLog(json_encode( "ID Дела: " . $timelineRecord['ASSOCIATED_ENTITY_ID'], JSON_UNESCAPED_UNICODE), $path);
//
//
//        $activity = \CCrmActivity::GetByID($timelineRecord['ASSOCIATED_ENTITY_ID']);
//        addFileLog('Инфо по привязанному делуДелу', $path);
//        addFileLog(json_encode( $activity, JSON_UNESCAPED_UNICODE), $path);
//
//    }
//    catch(\Exception $e){
//        echo $e->getMessage();
//        addFileLog(json_encode( $e->getMessage(), JSON_UNESCAPED_UNICODE), $path);
//
//    }
//
//}
//



// Урок 22
//Добавляю обработчик события на изменение инфоблока
$eventManager->addEventHandler('iblock', 'OnAfterIBlockElementUpdate', ['Otus\Events\IblockHendler', 'onElementAfterUpdate']);

//$eventManager->addEventHandler('crm', 'OnAfterCrmDealUpdate', ['Otus\Events\CrmHandler', 'onDealAfterUpdate']);


//Тип свойства для инфоблоков (Расписание)
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['Otus\UserType\CUserTypeTimesheet', 'GetUserTypeDescription']);



//Тип свойства для инфоблоков (Ссылка href)
//$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['UserTypes\IBLink', 'GetUserTypeDescription']);

//Пользотвалеьское поле ссылка на телеграм
//$eventManager->AddEventHandler('main', 'OnUserTypeBuildList', ['UserTypes\FormatTelegramLink', 'getUserTypeDescription']);




//Тип свойства для инфоблоков (Ссылка href)
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['Otus\UserType\CUserTypeOnlineRecord', 'GetUserTypeDescription']);



//Добавляю свой rest-метод, урок 28
$eventManager->addEventHandlerCompatible('rest', 'OnRestServiceBuildDescription', ['Otus\Rest\Events', 'OnRestServiceBuildDescriptionHandler']);
//$eventManager->addEventHandler('rest', 'OnRestServiceBuildDescription', ['Otus\Rest\Events', 'OnRestServiceBuildDescriptionHandler']);
