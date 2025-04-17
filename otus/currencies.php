<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Список валют");






//
//$APPLICATION->IncludeComponent(
//    "bitrix:main.ui.grid",
//    "",
//    [
//        "GRID_ID" => "MY_GRID_ID",
//        "COLUMNS" => $arResult['COLUMNS'],
//        "ROWS" => $arResul  t['LISTS'],
//        "NAV_OBJECT" => $nav,
//        "AJAX_MODE" => "Y",
//        "AJAX_OPTION_JUMP" => "N",
//        "AJAX_OPTION_HISTORY" => "N",
//        "SHOW_ROW_CHECKBOXES" =>$arResult['SHOW_ROW_CHECKBOXES'],
//        "SHOW_SELECTED_COUNTER" => false,
//        "SHOW_PAGESIZE" => false,
//    ]
//);

?>

<?php

$APPLICATION->IncludeComponent(
    "otus:currencies",
    '.default',
    [
            "COMPONENT_TEMPLATE" => '.default',
            "TEXTTT222" => 'skfdjlskjflsjkfklsdf'
    ],
    false
);



?>









<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>