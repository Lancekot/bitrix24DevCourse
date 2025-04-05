<?php

function testCurrent($event)
{

    $application = \Bitrix\Main\Application::getInstance();
    $parameters = $event->getParameters();
    $fields = $parameters['fields'];


    $path =$_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/classes/Otus/Handlers/log.txt';

    addFileLog(json_encode(json_encode($fields, JSON_UNESCAPED_UNICODE), $path);



}
