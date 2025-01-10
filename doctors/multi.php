<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle('Врачи');
//$APPLICATION->SetAdditionalCSS('/doctors/style.css');

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
use Models\Lists\DoctorsPropertyValuesTable as DoctorsTable;

//// Пример варианта, как сделать выборку используя кастомный класс
//$doctor_obj = DoctorsTable::query()
//    ->addSelect('NAME')
//    ->addSelect('LAST_NAME')
//    ->addSelect('FIRST_NAME')
//    ->setFilter(['=ID' => 66 ])
//    ->fetchObject();
//
//pr($doctor_obj->getName());
//
//
//
/////Не работает DoctorsTable!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//$doctor_obj = DoctorsTable::getList([
//    'select' => [
//        '*',
//        'LAST_NAME',
//        'FIRST_NAME',
//        'SECOND_NAME',
//        'PROCEDURES_INFO'
//        //'PROC_IDS_MULTI.ELEMENT'
//    ],
//    'filter' => [
//        'ID' => $doctor_id
//    ]
//])->fetchObject();
//
//pr($doctor_obj->getName());
//pr($doctor_obj->getId());
//pr($doctor_obj->getLastName()->getValue());
//pr($doctor_obj->getFirstName()->getValue());
//pr($doctor_obj->getSecondName()->getValue());
//
//foreach($doctor_obj->getProcIdsMulti()->getAll() as $prItem){
//
//    pr($prItem->getElement()->getId(). ' - ' .$prItem->getElement()->getName());
//
//}


//$doctor_obj = \Bitrix\Iblock\Elements\ElementdoctorsTable::getList([
//    'select' => [
//        'FIRST_NAME',
//        'LAST_NAME',
//        'SECOND_NAME',
//        'PROC_IDS_MULTI.ELEMENT'
//    ],
//    'filter' => [
//       'ID' => $doctor_id
//    ]
//])->fetchCollection();
////
//foreach($doctor_obj as $doctor){
//
//    pr($doctor->getId());
//    pr($doctor->getFirstName()->getValue());
//    pr($doctor->getSecondName()->getValue());
//
//    foreach($doctor->getProcIdsMulti()->getAll() as $prItem){
//
//        //pr($prItem);
//
//        pr($prItem->getElement()->getId(). ' - ' .$prItem->getElement()->getName());
//    }
//}

//$doctor_obj = \Bitrix\Iblock\Elements\ElementdoctorsTable::getList([
//    'select' => [
//        'FIRST_NAME',
//        'LAST_NAME',
//        'SECOND_NAME',
////        'PROC_IDS_MULTI.ELEMENT',
//        'PREVIEW_PICTURE' // типовое поле Изображение для анонса
//    ],
//    'filter' => [
//        'NAME' => 'ivanov'
//    ]
//])->fetchObject();
//
//
//
//pr($doctor_obj->get('PREVIEW_PICTURE'));
//
//$previewPicturePath = \CFile::GetPath($doctor_obj->get('PREVIEW_PICTURE'));
//
//pr($previewPicturePath);
//
//
//

//
//foreach($doctor_obj as $doctor) {
//    pr($doctor->getName());
////    pr($doctor->getId());
////    pr($doctor->getLastName()->getValue());
////    pr($doctor->getFirstName()->getValue());
////    pr($doctor->getSecondName()->getValue());
//
//}



//$res = \Bitrix\Iblock\Elements\ElementproceduresTable::getList([
//    'select' => ['ID', 'NAME'],
//    'order' => ['ID' => 'ASC'],
//]);
//
//$procedurs = [];
//
//while ($ar = $res->fetch()) {
//    $procedurs[$ar['ID']] = $ar['NAME'];
//}
//
//
//pr($procedurs);
//
//
//foreach ($procedurs as $id => $name) {
//
//    echo $name."<br>";
//
//}


//$_POST = [
//    'NAME' => 'Kolobkov',
////    'ACTIVE' => 'Y', // Элемент будет активен
////    'LAST_NAME' => 'Колобков',
////    'FIRST_NAME' => 'Валерий',
////    'SECOND_NAME' => 'Степанович',
////    'PROC_IDS_MULTI' => [39, 50],
//];
//
//$result = \Bitrix\Iblock\Elements\ElementdoctorsTable::add($_POST);
//
//




//Loader::includeModule('iblock');
//
//$elementData = [
//    'IBLOCK_ID' => 16,
//    'NAME' => 'Kolobkov',
//    'ACTIVE' => 'Y', // Элемент будет активен
//    'PROPERTY_VALUES' => [
//        'LAST_NAME' => 'Колобков',
//        'FIRST_NAME' => 'Валерий',
//        'SECOND_NAME' => 'Степанович',
//        'PROC_IDS_MULTI' => [39, 50],
//        // Добавьте другие свойства, если необходимо
//    ],
//];
//$el = new CIBlockElement;
//
//$result = $el->Add($elementData);






