<?php
namespace Otus\Rest;

use Bitrix\Rest\RestException;
use Models\Lists\ClientsTable;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);



class Events
{

    /**
     * @return array[]
     */

    public static function OnRestServiceBuildDescriptionHandler()
    {
        //Loc::loadMessages('REST_SCOPE_OTUS.CLIENTSDATA');
        Loc::getMessage('REST_SCOPE_OTUS.CLIENTSDATA');

        return [
            'otus.clientsdata' => [
                'otus.clientsdata.add' => [__CLASS__, 'add'],
                'otus.clientsdata.list' => [__CLASS__, 'list'],
                'otus.clientsdata.update' => [__CLASS__, 'update'],
                'otus.clientsdata.delete' => [__CLASS__, 'delete'],
//                \CRestUtil::EVENTS => [
//                    'onAfterODCDAdd' => [
//                        'main',
//                        'onAfterOtusClientsDataAdd',
//                        [__CLASS__, 'prepareEventDate']
//                    ]
//                ]
            ]
        ];
    }



    //Добавление нового элемента

    /**
     * @param $arParams
     * @param $navStart
     * @param \CRestServer $server
     * @return array|int
     * @throws RestException
     */
    public static function add($arParams, $navStart, \CRestServer $server)
    {

        $clientsData = ClientsTable::add($arParams);

        if($clientsData->isSuccess())
        {
            $id = $clientsData->getId();

            return $id;
        }
        else
        {
            throw new RestException(json_encode($clientsData->getErrorMessages(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }

    }

    //Получения списка

    /**
     * @param $arParams
     * @param $navStart
     * @param \CRestServer $server
     * @return array
     * @throws RestException
     */
    public static function list($arParams, $navStart, \CRestServer $server)
    {

        if (!empty($arParams)) {

            $arFilter = isset($arParams['filter']) ? $arParams['filter'] : [];
            $arSelect = isset($arParams['select']) ? $arParams['select'] : [];
            $arOrder = isset($arParams['order']) ? $arParams['order'] : [];
            $arLimit = isset($arParams['limit']) ? $arParams['limit'] : [];

            foreach ($arFilter as &$filter) {
                $filter = htmlspecialchars($filter);
                $filter = trim($filter);
            }

        } else {
            return [];
        }
        try {
            $result = ClientsTable::getList([
                'filter' => $arFilter,
                'select' => $arSelect,
                'order' => $arOrder,
                'limit' => $arLimit,
                'offset' => $navStart
            ])->fetchAll();
        } catch (\Exception $e) {
            throw new RestException(json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE), RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }


        return $result;


    }

    //Изменение

    /**
     * @param $arParams
     * @param $navStart
     * @param \CRestServer $server
     * @return true
     * @throws RestException
     */
    public static function update($arParams, $navStart, \CRestServer $server)
    {
        // Проверка наличия ID элемента для обновления
        if (empty($arParams['ID'])) {
            throw new RestException("Поле ID обязательно для обновления.", RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }

        // Извлечение ID и данных для обновления
        $id = $arParams['ID'];
        unset($arParams['ID']); // Удаляем ID из параметров, чтобы не пытаться обновить его

        // Обновление элемента в таблице
        $result = ClientsTable::update($id, $arParams);

        if ($result->isSuccess()) {
            return true; // Возвращаем true в случае успешного обновления
        } else {
            throw new RestException(
                json_encode($result->getErrorMessages(), JSON_UNESCAPED_UNICODE),
                RestException::ERROR_ARGUMENT,
                \CRestServer::STATUS_OK
            );
        }
    }



    //Удаление элемента

    /**
     * @param $arParams
     * @param $navStart
     * @param \CRestServer $server
     * @return true
     * @throws RestException
     */
    public static function delete($arParams, $navStart, \CRestServer $server)
    {
        // Проверка наличия ID элемента для удаления
        if (empty($arParams['ID'])) {
            throw new RestException("Поле ID обязательно для удаления.", RestException::ERROR_ARGUMENT, \CRestServer::STATUS_OK);
        }

        // Удаление элемента из таблицы
        $result = ClientsTable::delete($arParams['ID']);

        if ($result->isSuccess()) {
            return true; // Возвращаем true в случае успешного удаления
        } else {
            throw new RestException(
                json_encode($result->getErrorMessages(), JSON_UNESCAPED_UNICODE),
                RestException::ERROR_ARGUMENT,
                \CRestServer::STATUS_OK
            );
        }
    }




}