<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");




$hoook = 'https://ct70506.tw1.ru/rest/1/pjackuwka2nnven3';

$method1 = 'otus.clientsdata.add';
$method2 = 'otus.clientsdata.list';
$method3 = 'otus.clientsdata.update';
$method4 = 'otus.clientsdata.delete';


$fields = [
 'ID' => 3,
'fields' => [
    'UF_LASTNAME' => 'Тестиик'
]
];

$url = $hoook ."/". $method3;


$res = sendB24($url, $fields);

pr($res);







//$activityId = 16;
//$activity = \CCrmActivity::GetByID($activityId);
//
//
//pr($activity);
//


//\Bitrix\Crm\Timeline\CommentEntry::create(
//    array(
//        'TEXT' => 'текст который отобразится в Timeline',
//        'SETTINGS' => array('HAS_FILES' => 'N'), //cодержит ли файл комментарий
//        'AUTHOR_ID' => $USER->GetID(), //ID пользователя, от которого будет добавлен комментарий
//        'BINDINGS' => array(array('ENTITY_TYPE_ID' => 2, 'ENTITY_ID' => 16)) // привязка к сущности CRM: ENTITY_TYPE_ID - тип сущности CRM (2 - Сделка), 'ENTITY_ID' - ID сделки в системе.
//    ));



//$params = [
//    'TYPE_ID' => 25,
//    'TYPE_CATEGORY_ID' => 6,
//    'CREATED' => 1,
//    'AUTHOR_ID' => 1,
//    'ENTITY_TYPE_ID' => 2,
//    'ENTITY_ID' => 17,
//    'SETTINGS' => '',
//    'SOURCE_ID' => 1,
//    'BINDINGS' => array(array('ENTITY_TYPE_ID' => 2, 'ENTITY_ID' => 17))
//
//];
//
//
//$res = \Bitrix\Crm\Timeline\CallTrackerEntry::create($params);
//
//
//pr($res);

//$params = [
//    'CREATED' => 1,
//    'AUTHOR_ID' => 1,
//    'ENTITY_TYPE_ID' => 2,
//    'ENTITY_ID' => 17,
//    'SETTINGS' => '',
//    'BINDINGS' => array(array('ENTITY_TYPE_ID' => 2, 'ENTITY_ID' => 17))
//
//];
//
//
//$res = \Bitrix\Crm\Timeline\CallTrackerEntry::create($params);
//
//
//pr($res);


echo __FILE__;


?>