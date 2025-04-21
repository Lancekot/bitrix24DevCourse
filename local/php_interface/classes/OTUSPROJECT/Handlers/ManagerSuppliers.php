<?php
namespace OTUSPROJECT\Handlers;

use OTUSPROJECT\Handlers\ManagerRemainProducts;


class ManagerSuppliers
{

    //Создаю элемент смарт процесса
    /**
     * @param $entityTypeId - ID смарт процесса
     * @param $fields - Поля элемента смарт-процесса
     * @return void
     * @throws \Bitrix\Main\LoaderException
     */
    public static function createSmartProcessElement($entityTypeId, $fields)
    {
        if(\Bitrix\Main\Loader::includeModule('crm'))
        {
            // Получаем сервис для работы с сущностями CRM
            $factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory($entityTypeId);

            if (!$factory) {
                echo "Не удалось получить фабрику для указанного типа сущности.";
                return;
            }

            // Создаем новый элемент
            $item = $factory->createItem();

            // Устанавливаем поля элемента
            foreach ($fields as $fieldName => $fieldValue) {
                $item->set($fieldName, $fieldValue);
            }

            // Сохраняем элемент
            $context = new \Bitrix\Crm\Service\Context();
            $context->setUserId(1);
            // операция производится от пользователя $userId с выполнением всех проверок
            $operation = $factory->getAddOperation($item, $context);
            $result = $operation->launch();

            $elementId = $item->getId();
            return $elementId;

        }
    }

    //Получаю данные полей элемента смарт проецсса по его $entityTypeId и $entityId
    /**
     * @param $entityId - ID элемента смарт-процесса
     * @param $entityTypeId - ID смарт процесса
     * @return void
     */
    public static function getDataFieldsSmartById($entityId, $entityTypeId)
    {
        if(Bitrix\Main\Loader::includeModule('crm')) {
            $entityTypeId = $entityTypeId;
            $factory = Bitrix\Crm\Service\Container::getInstance()->getFactory($entityTypeId);
            $item = $factory->getItem($entityId);
            return $item->getCompatibleData();
        }
    }

    //Добавляю в элемент смарт процесса товарные позиции
    /**
     * @param $entityTypeId - ID  смарт-процесса
     * @param $elementId - ID элемента смарт-процесса
     * @param $productRows - Массив товаров необходимых для добавления
     * @param $smartTypeProductId - ID смарт-прцоесса для связи товарных позиций с элементом смарт-процесса
     * @return void
     */
    public static function addProductRowsToSmartProcess($entityTypeId, $elementId, $productRows, $smartTypeProductId = 'T40c') //'T40c' - Товарные позиции привязываются к заявке на закуп
    {
        // Добавляем новые товарные позиции
        foreach ($productRows as $productRow) {
            $productRow['OWNER_ID'] = $elementId;
            $productRow['OWNER_TYPE'] = $smartTypeProductId;

            $result = \Bitrix\Crm\ProductRowTable::add($productRow);
            $factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory($entityTypeId);
            $item = $factory->getItem($elementId);
            $operation = $factory->getUpdateOperation($item); // вызывает операцию обновления
            $result = $operation->launch(); // запускает ее

            if (!$result->isSuccess()) {
                $errors = $result->getErrorMessages();
                //echo "Ошибка при добавлении товарной позиции: " . implode(', ', $errors);
            }
        }

        //echo "Товарные позиции успешно добавлены к элементу с ID: " . $elementId;
    }



}