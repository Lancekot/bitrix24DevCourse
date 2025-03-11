<?php

use Bitrix\Main;

$eventManager = Main\EventManager::getInstance();

//Вешаем свой обработчик

//Пользователеькое поле "Выбор цвета" для модуля Main (CRM, TASK и т.д.)
//$eventManager->addEventHandler('main', 'OnUserTypeBuildList', ['Otus\UserType\CUserTypeColor', 'GetUserTypeDescription']);






//Тип свойства для инфоблоков (Расписание)
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['Otus\UserType\CUserTypeTimesheet', 'GetUserTypeDescription']);


//Тип свойства для инфоблоков (Ссылка href)
//$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['UserTypes\IBLink', 'GetUserTypeDescription']);

//Пользотвалеьское поле ссылка на телеграм
//$eventManager->AddEventHandler('main', 'OnUserTypeBuildList', ['UserTypes\FormatTelegramLink', 'getUserTypeDescription']);




//Тип свойства для инфоблоков (Ссылка href)
$eventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList', ['Otus\UserType\CUserTypeOnlineRecord', 'GetUserTypeDescription']);
