<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @global CMain $APPLICATION */
//use Models\Lists\ClientsTable as Clients;

$APPLICATION->SetTitle('Тест');



$APPLICATION->IncludeComponent(
    "otus:table.views",
    'list',
    [
        "COMPONENT_TEMPLATE" => 'list',
        'SHOW_CHECKBOXES' => "Y",
        'NUM_PAGE'  => "1"
    ],
    false
);







?>







<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>

































