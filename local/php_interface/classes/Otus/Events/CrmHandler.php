<?php

namespace Otus\Events;

use Bitrix\Main\Loader;
class CrmHandler
{

    public static function onDealAfterUpdate(&$arFields)
    {

        $path = $_SERVER["DOCUMENT_ROOT"]. '/local/php_interface/classes/Otus/Events/log.txt';
        addFileLog('Запустился обработчик в сделке', $path);

        if(!empty($arFields['OPPORTUNITY'])){

            $deal_id = $arFields['ID'];

            $arrPropert['SDELKA']  = $deal_id;


            $ibblockID = self::getIblockByDeal($deal_id);

            $arrPropert['SUMMA'] = $arFields['OPPORTUNITY'] . '|RUB';

        }

        if(!empty($arFields['ASSIGNED_BY_ID'])){

            if(empty($deal_id)){

                $deal_id = $arFields['ID'];
                $arrPropert['SDELKA']  = $deal_id;
            }

            if(empty($ibblockID)){

                $ibblockID = self::getIblockByDeal($deal_id);
            }

            $arrPropert['OTVETSTVENNYY'] = $arFields['ASSIGNED_BY_ID'];


            if(!empty($arrPropert) && !empty($ibblockID)){


                \CIBlockElement::SetPropertyValues($ibblockID, 33, $arrPropert);


            }

        }

    }



     public static function getIblockByDeal($deal_id)
     {
         Loader::includeModule('iblock');

         $arr = \Bitrix\Iblock\Elements\ElementbidTable::getList([
             'select' => [
                 'ID',
             ],
             'filter' => [
                 '=SDELKA.VALUE' => $deal_id
             ]
         ])->fetchObject();

         if($id = $arr->getId()){
             return $id;
         }

     }



}