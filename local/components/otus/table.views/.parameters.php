<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if(!CModule::IncludeModule("iblock"))
    return;

$arComponentParameters = [
    "GROUPS" => [
            "LIST" => [
                "NAME" => GetMessage("GRID_PARAMETERS"),
                "SORT" => "300"
            ]
    ],
    "PARAMETERS" => [
        "SHOW_CHECKBOXES"  => [
            "PARENT" => "LIST",
            "NAME" => GetMessage("SHOW_ACTION_BTNS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ],
        "NUM_PAGE" => [
            "PARENT" => "LIST",
            "NAME" => GetMessage("NUM_PAGE"),
            "TYPE" => "STRING",
            "DEFAULT" => "20",
        ]
    ]
];