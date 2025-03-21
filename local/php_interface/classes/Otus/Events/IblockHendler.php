<?php

namespace Otus\Events;

use Bitrix\Main\Loader;



class IblockHendler
{
    public static function onElementAfterUpdate(&$arFields){

        if ($arFields["IBLOCK_ID"] != 33)
            return $arFields;


        $path = $_SERVER["DOCUMENT_ROOT"]. '/local/php_interface/classes/Otus/Events/log.txt';
        addFileLog('Запустился обработчик в блоке', $path);
        addFileLog(json_encode($arFields), $path);


        self::UpdateDealByIblock($arFields);
    }

    public static function UpdateDealByIblock($arFields){

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

        $factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory(2);
        $item = $factory->getItem($arr->getSdelka()->getValue()); //сумма

        $fields['OPPORTUNITY'] = $arr->getSumma()->getValue(); //ID сделки
        $fields['ASSIGNED_BY_ID'] = $arr->get('OTVETSTVENNYY')->getValue(); //ответсвенный


        $item->setFromCompatibleData($fields);
        $operation = $factory->getUpdateOperation($item);
        $operation->disableAllChecks();
        $result = $operation->launch();

    }

}
