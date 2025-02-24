<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;




class GridcontrollerComponent extends CBitrixComponent implements Controllerable
{
    /**
     * @return array
     */

    public function configereActions()
    {
        return [];
    }

    function executeCompinent()
    {
//        $this->includeComponentTemplate();
    }


}