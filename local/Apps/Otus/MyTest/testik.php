<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");


use Otus\UserType;
use Models\Lists\DoctorsPropertyValuesTable as DoctorsTable;

//pr( __DIR__);



//UserType\CUserTypeColor::ppp();

//echo "GGGG";







//test_list
//
//
//$iblockId = \Bitrix\Main\Config\Option::get('otus.homework', 'test_iblock_id');
//
//pr($iblockId);



//$fff = getColumn();
//
//pr($fff);


//$arr = $b::getList([
//    'select' => [
//        'NAME'
//    ],
//    'filter' => [
//    ]
//])->fetch();
//
//pr($arr);


//$arr = \Bitrix\Iblock\ElementTable::getList([
//    'select' => [
//        '*',
//        'LAST_NAME',
//
//    ],
//    'filter' => [
//        'ID' => 82,
//        'IBLOCK_ID' => 16,
//    ],
//])->fetchObject();





//$iblockVirClass =  \Bitrix\Iblock\Iblock::wakeUp(16)->getEntityDataClass();
//
//$res = $iblockVirClass::getByPrimary(82, [
//    'select' => [
//        'ID',
//        'NAME',
//        'LAST_NAME',
//        'SECOND_NAME',
//        'PROC_IDS_MULTI.ELEMENT'
//    ],
//])->fetchObject();
//
//pr($res->getName());
//pr($res->getId());
//pr($res->getLastName()->getValue());
//
//foreach($res->getProcIdsMulti()->getAll() as $prItem){
//
//    pr($prItem->getElement()->getId(). ' - ' .$prItem->getElement()->getName());
//
//}


//pr($arr);


//$doctor_obj = Models\Lists\DoctorsPropertyValuesTable\DoctorsTable::getList([
//    'select' => [
//        '*',
//        'LAST_NAME',
//        'FIRST_NAME',
//        'SECOND_NAME',
//        //'PROCEDURES_INFO',
//        'PROC_IDS_MULTI.ELEMENT'
//    ],
//    'filter' => [
//        'ELEMENT.ID' => 82
//    ]
//])->fetchObject();

//PROC_IDS_MULTI

//pr($doctor_obj->getName()->getValue());
//pr($doctor_obj->getElementId());
//pr($doctor_obj->getLastName());
//pr($doctor_obj->getLastName()->getValue());
//pr($doctor_obj->getFirstName());
//pr($doctor_obj->getSecondName()->getValue());

//pr($doctor_obj->getProcIdsMulti());

//
//foreach($doctor_obj->getProcIdsMulti()->getAll() as $prItem){
//
//    pr($prItem->getElement()->getId(). ' - ' .$prItem->getElement()->getName());
//
//}






require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");




