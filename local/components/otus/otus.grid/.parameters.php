<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if(!CModule::IncludeModule("iblock"))
    return;

$arComponentParameters = [
    "GROUPS" => [
            "LIST" => [
                "NAME" => 'TESTttt',
                "SORT" => "300"
            ]
    ],
    "PARAMETERS" => [
        "SHOW_CHECKBOXES"  => [
            "PARENT" => "LIST",
            "NAME" => "Чекбоксер",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ],
        "NUM_PAGE" => [
            "PARENT" => "LIST",
            "NAME" => 'Кол-во строк',
            "TYPE" => "STRING",
            "DEFAULT" => "20",
        ]
    ]
];