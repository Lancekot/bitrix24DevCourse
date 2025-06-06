<?php
namespace OTUSPROJECT\Handlers;

/**
 *
 */
class ManagerCrmEntyty
{
    //Проверка на дубль по автомобилю и клиенту
    /**
     * @param $arr - массив получаемый при событии
     * @return bool
     */
    public static function checkActiveDeal(&$arr)
    {

        // Получаем все сделки, связанные с контактом
        $deals = \Bitrix\Crm\DealTable::getList([
            'filter' => [
                'UF_CRM_1744910392' => $arr['UF_CRM_1744910392'],
                'CLOSED' => 'N'
            ],
            'select' => ['ID']
        ]);

        $findDeals = [];
        while($deal = $deals->fetch()) {
            $findDeals[] = $deal['ID'];
        }

        if (empty($findDeals)) {
            return true; //Разрешаю создать сделку, по контакту
        }

        $arr['RESULT_MESSAGE'] = "По данному автомобилю уже есть активные сделки.".implode(',', $findDeals) ." <br>Пожалуйста, закройте их перед созданием новой.";
        return false; // Отменяем создание сделки

    }


    //Получения списка сделок по автомобилю и контакту

    /**
     * @param $contactId - ID контакта
     * @return void
     * @throws \Bitrix\Main\LoaderException
     */
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