<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Currency\CurrencyTable;

Loader::includeModule('currency');

$arrCurrency = CurrencyTable::getList([
    'select' => ['CURRENCY', 'NUMCODE'],
    'order' => ['SORT' => 'ASC']
]);

$currency = [];
while($row = $arrCurrency->fetch())
{
    $currency[$row["NUMCODE"]] = $row['CURRENCY'];
}

$arComponentParameters = [
    "GROUPS" => [
        "CUR_PARAM" => [
            "NAME" => "Тестовая группа",
            "SORT" => "300"
        ]
    ],
    "PARAMETERS" => [
        "CURRENCY"  => [
            "PARENT" => "CUR_PARAM",
            "NAME" => "Выбрать валюту",
            "TYPE" => "LIST",
            "VALUES" => $currency,
            "REFRESH" => "Y"
        ],
    ]
];