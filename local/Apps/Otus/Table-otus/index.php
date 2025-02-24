<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Компонент списка таблицы базы данных");

use Bitrix\Main\Type;
use Models\Lists\ClientsTable as Clients;

//// получаем список клиентов
//$collection = Clients::getList([
//    'select' => [
//        'ID',
//        'UF_NAME',
//        'UF_LASTNAME',
//        'UF_PHONE',
//        'UF_JOBPOSITION',
//        'UF_SCORE'
//    ]
//])->fetchCollection();
//
//foreach ($collection as $key => $item) {
//    echo $item->getUfName().' '.$item->getUfLastname().' '.$item->getUfPhone().' '.$item->getUfJobposition().' '.$item->getUfScore().'<br />';
//}
//


?>


<?
 $APPLICATION->IncludeComponent(
 	"otus:table.views",
 	"list",
 	array(
 		"COMPONENT_TEMPLATE" => "list",
 		"SHOW_CHECKBOXES" => "Y"
 	),
 	false
 );

?>



<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>