<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle('Вывод связанных полей');

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
use Models\Lists\CarsPropertyValuesTable as CarsTable;

//Loader::includeModule('iblock');
//
//
//$iblockId = 18;
//$iblockElement = 35;

// Варинант 1
//Old API

//$arFilter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'];
//$arSelect = ['ID', 'NAME', 'CODE', 'PROPERTY_MODEL'];
//$res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
//while($arFields = $res->fetch())
//{
//    pr($arFields); // Вместь print_r найту нужный метод вывода у Бирикса (в уроке 4)
//}


////Для получения Разделов списка
//$arFilter = ['IBLOCK_ID' => $iblockId];
//$arSelect = ['NAME'];
//$rsSect = CIBlockSection::GetList(['left_margin' => 'asc'], $arFilter, false, $arSelect, false);
//while($arSect = $rsSect->fetch())
//{
//    print_r($arSect);
//}


// Варинант 2 (лучше использовать этот вариант)
//Использую ORM
//Для этого требуется переместить хранение инфоблока в отдельную таблицу
//get_by_id
//$iblock = Iblock::wakeUp($iblockId);
//$element = $iblock->getEntityDataClass()::getByPrimary($iblockElement)->fetchObject();
//
//$name = $element->get('NAME');
//echo 'NAME: ';
//pr($name);
//
//
////get_props
//$element = $iblock->getEntityDataClass()::getByPrimary($iblockElement, ['select' => ['NAME', 'MODEL']])->fetchObject();
//
//$model = $element->get('MODEL')->getValue();
//echo 'MODEL: ';
//pr($model);


//// Вариант 3
//$elements = \Bitrix\Iblock\Elements\ElementCarTable::getList([
//    'select' => ['MODEL'],
//])->fetchCollection();
//
//foreach($elements as $element){
//    pr('MODEL - '.$element->getModel()->getValue());
//}


//// Вариант 4
//$elements = \Bitrix\Iblock\Elements\ElementCarTable::query()
//    ->addSelect("NAME")
//    ->addSelect("MODEL")
//    ->addSelect("ID")
//    ->fetchCollection();
//
//foreach ($elements as $key => $element) {
//    pr($element->getName(). ' ' .$element->getModel()->getValue());
////    $value = $element->getModel()->getValue();
////    //Если хочу изменить элемент
////    if($value == "Q7"){
////        $element->setModel("Q7 Test");
////        $element->save();
////    }
//}



// // Пример варианта, как сделать выборку используя кастомный класс
//$cars = CarsTable::query()
//    ->setSelect([
//        '*',
//        'NAME' => 'ELEMENT.NAME',
//        'CITY_NAME' => 'CITY.ELEMENT.NAME',
//        'MANUFACTORER_NAME' => 'MANUFACTORER.ELEMENT.NAME',
//        'COUNTRY' => 'MANUFACTORER.COUNTRY',
//    ])
//    ->setOrder(['COUNTRY' => 'desc'])
//    ->registerRuntimeField(
//        null,
//        new \Bitrix\Main\Entity\ReferenceField(
//            'MANUFACTORER',
//            \Models\Lists\CarManufacturerPropertyValuesTable::getEntity(),
//            ['=this.MANUFACTORY_ID' => 'ref.IBLOCK_ELEMENT_ID']
//        )
//    )
//    ->fetchAll();
//    pr($cars);



/////////////////// Обночление инфоблока //////////////////////////
////Вариант 1
//$res = \Bitrix\Iblock\Elements\ElementcarTable::update(36, ['NAME' => 'AUDI Q7']);


////Вариант 2
//$cars = \Bitrix\Iblock\Elements\ElementcarTable::query()
//    ->addSelect('NAME')
//    ->addSelect('MODEL')
//    ->addSelect('ID')
//    ->setFilter(['=ID' => 36])
//    ->fetchCollection();
//
//foreach($cars as $car){
//    $car->setModel('Q8 Test');
//    $car->save();
//}