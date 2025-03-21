<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");


use Bitrix\Iblock\Iblock;


$arr = \Bitrix\Iblock\Elements\ElementbidTable::getList([
    'select' => [
        'ID',
        'NAME',
        'SDELKA',
        'OTVETSTVENNYY',
        'SUMMA'
    ],
    'filter' => [
        'ID' => 119
    ]
])->fetchObject();

pr($arr->getId());

pr($arr->getName());

pr($arr->getSdelka()->getValue());


pr($arr->getSumma()->getValue());

pr($arr->get('OTVETSTVENNYY')->getValue());
//
//
//


$arr = \Bitrix\Iblock\Elements\ElementbidTable::getList([
    'select' => [
        'ID',
    ],
    'filter' => [
        '=SDELKA.VALUE' => 14
    ]
])->fetchObject();

$id = $arr->getId();

pr($id);















//
//pr($arr->get('OTVETSTVENNYY')->setValue(1));


//$factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory(2);
//$item = $factory->getItem(14);
//$deal_arr = $item->getCompatibleData();
//
//pr($deal_arr['UF_CRM_1742544185']);
//
//
$arr = [
    'SUMMA' => '5000|RUB',
    'OTVETSTVENNYY' => 3,
    'SDELKA' => 14
];
\CIBlockElement::SetPropertyValues(119, 33, $arr);




//
//$params = [
//    'PROPERTY_VALUES' => $arr,
//];
//
//$el_ogj = new CIBlockElement();
//
//$el_ogj->Update(119, $params);
//








//pr($arr->getSdelka()->getValue());



//$arr2 = CIBlockElement::GetProperty(33, 119);
//
//while($prop = $arr2->fetch()){
//    pr($prop);
//}


//$path = $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/classes/Otus/Events/log.txt";
//$arr = json_decode(file_get_contents($path), true);
//
//
//
////pr($arr);
//
//pr($arr['PROPERTY_VALUES'][108][174]['VALUE']); //Сумма
//
//pr($arr['PROPERTY_VALUES'][109][176]['VALUE']); //ID сделки
//
//pr($arr['PROPERTY_VALUES'][110]); //Ответственный
//
//
//
//UpdateDealByIblock($arr);











//$factory = Bitrix\Crm\Service\Container::getInstance()->getFactory(2);
//$item = $factory->getItem(14);
//
//pr($item->getCompatibleData());








?>