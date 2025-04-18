<?php
namespace OTUSPROJECT\Handlers;

class ManagerCrmEntyty
{
    //Проверка на дубль по автомобилю и клиенту
    public static function checkActiveDeal(&$arr)
    {

        // Получаем все сделки, связанные с контактом
        $deals = \Bitrix\Crm\DealTable::getList([
            'filter' => [
                '=CONTACT_ID' => $arr['CONTACT_ID'],
                'UF_CRM_1744910392' => $arr['UF_CRM_1744910392'],
                'CLOSED' => 'N'
            ],
            'select' => ['ID']
        ])->fetchAll();


        if (empty($deals)) {

            return true; //Разрешаю создать сделку, по контакту
        }

        $arr['RESULT_MESSAGE'] = 'У данного контакта уже есть активные сделки. Пожалуйста, закройте их перед созданием новой.';
        return false; // Отменяем создание сделки

    }


    //Получения списка сделок по автомобилю и контакту
    public static function checkAllDealByContact($contactId)
    {
        if(\Bitrix\Main\Loader::includeModule('crm'))
        {
            // Получаем все сделки, связанные с контактом
            $deals = \Bitrix\Crm\DealTable::getList([
                'filter' => [
                    'CONTACT_ID' => $contactId,
                ],
                'select' => ['ID', 'STAGE_ID', 'TITLE', 'CLOSEDATE', 'ASSIGNED_BY_ID', 'DATE_CREATE'],
                'order' => ['ID' => 'ASC']
            ])->fetchAll();

            return $deals;
        }
    }


}