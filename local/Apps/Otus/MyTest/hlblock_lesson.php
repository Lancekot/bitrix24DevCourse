<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';


use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;


Loader::includeModule('highloadblock');;

//initialize
//Вариант 1
//$hlBlockId = 2;
//$objHlblock = HL\HighloadBlockTable::getById($hlBlockId)->fetch();
//


//Вариант 2
$objHlblock = HL\HighloadBlockTable::getList([

    'filter' => ['NAME' => 'TilesWidth']
])->fetch();


$entity = HL\HighloadBlockTable::compileEntity($objHlblock['ID']); //здесь идет создание специальной сущности для работы с объектом highloadblock

// генерация Виртуального класса
$strEntityDataClass = $entity->getDataClass(); //сделсь вернутся название класса HL  \TilesWidthTable


//Выбор елементов HL блока
$elements = $strEntityDataClass::getList([
    'select' => ['*'],
    'order' => ['ID' => 'ASC'],
    'count_total' => true,
])->fetchAll();

pr($elements);