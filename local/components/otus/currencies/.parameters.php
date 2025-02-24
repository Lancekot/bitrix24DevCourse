<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if(!CModule::IncludeModule("iblock"))
    return;

$arCompponentParameters = [
    "GROUPS" => [
        "CUR_PARAM" => [
            "NAME" => "Тестовая группа",
            "SORT" => "300"
        ]
    ],
    "PARAMETERS" => [
        "STING"  => [
            "PARENT" => "CUR_PARAM",
            "NAME" => "Тестовая строка",
            "TYPE" => "STRING",
            "DEFAULT" => "10000",
        ],
        "NUMP"  => [
            "PARENT" => "CUR_PARAM",
            "NAME" => "Тестовая цифра",
            "TYPE" => "STRING",
            "DEFAULT" => "100000",
        ],
    ]
];