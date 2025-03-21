<?php

use Bitrix\Main;

$eventManager = Main\EventManager::getInstance();

//Вешаем свой обработчик

//Пользователеькое поле "Выбор цвета" для модуля Main (CRM, TASK и т.д.)
//$eventManager->addEventHandler('main', 'OnUserTypeBuildList', ['Otus\UserType\CUserTypeColor', 'GetUserTypeDescription']);





// Урок 22
//Добавляю обработчик события на изменение инфоблока
$eventManager->addEventHandler('iblock', 'OnAfterIBlockElementUpdate', ['Otus\Events\IblockHendler', 'onElementAfterUpdate']);

$eventManager->addEventHandler('crm', 'OnAfterCrmDealUpdate', ['Otus\Events\CrmHandler', 'onDealAfterUpdate']);


//Тип свойства для инфоблоков (Расписание)
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['Otus\UserType\CUserTypeTimesheet', 'GetUserTypeDescription']);


//Тип свойства для инфоблоков (Ссылка href)
//$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['UserTypes\IBLink', 'GetUserTypeDescription']);

//Пользотвалеьское поле ссылка на телеграм
//$eventManager->AddEventHandler('main', 'OnUserTypeBuildList', ['UserTypes\FormatTelegramLink', 'getUserTypeDescription']);




//Тип свойства для инфоблоков (Ссылка href)
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['Otus\UserType\CUserTypeOnlineRecord', 'GetUserTypeDescription']);
