<?php
namespace OTUSPROJECT\Handlers;

use OTUSPROJECT\Handlers\ManagerSuppliers;

class ManagerRemainProducts
{

    //Получаю массив товарных позиций, по которым нужно сформировать "Заявку на закуп" по сделке (Работает)
    /**
     * @param $dealId - ID сделки
     * @return void
     */
    public static function checkRemainByDeal($dealId)
    {

        //Провекра что это сделка
//        $factory = Bitrix\Crm\Service\Container::getInstance()->getFactory(2);
//        $item = $factory->getItem($dealId);
//        $entytyTypeDeal = $item->getField('ENTITY_TYPE');
//



        //Получаем список товарных позиций привязанных к сделкам
        $arPrRaw = self::getProductRowsByEntytiId($dealId);
        //pr($arPrRaw);

        //Получаем остатков товаров по товарным позициям привязанных к сделкам
        $arrPrQuantyty = self::getProdectQuantityBrProductRawDeal($arPrRaw);
        //pr($arrPrQuantyty);

        //Формируем массив товаров с недостаточным кол-вом и кол-во для дозаказа
        $productForSupOrder = self::getProductQuantytyForSupplierOrder($arrPrQuantyty, $arPrRaw);
        //pr($productForSupOrder);

        //Проверяем заполнен ли массив, если да, то создаем смарт процесс заявки на закуп
        if(!empty($productForSupOrder)){

            $entityTypeId = 1036;
            $fields = [
                //'TITLE' => 'Название элемента',
                'ASSIGNED_BY_ID' => 1,
                'PARENT_ID_2' => $dealId,
                'UF_CRM_3_1744881973' => 1
            ];

            $elementId = ManagerSuppliers::createSmartProcessElement($entityTypeId, $fields);

            //Добавляем товарные позиции из массива
            if($elementId){

                ManagerSuppliers::addProductRowsToSmartProcess($entityTypeId, $elementId, $productForSupOrder, 'T40c');

            }
        }
    }


    //Формирую заявку на закуп, при 0 остатке в каталоге
    /**
     * @param $productId - ID товара из каталога
     * @return void
     */
    public static function checkRemainByCatalog($productId)
    {

        $supplier = self::getSupplierId($productId);

        $productForSupOrder = [[
            'PRODUCT_ID' => $productId,
            'QUANTITY' => 5,
            'SUPPLIER' => $supplier,
        ]];

        //Проверяем заполнен ли массив, если да, то создаем смарт процесс заявки на закуп
        if(!empty($productForSupOrder)){

            $entityTypeId = 1036;
            $fields = [
                //'TITLE' => 'Название элемента',
                'ASSIGNED_BY_ID' => 1,
                'UF_CRM_3_1744881973' => 1
            ];

            $elementId = ManagerSuppliers::createSmartProcessElement($entityTypeId, $fields);

            //Добавляем товарные позиции из массива
            if($elementId){

                ManagerSuppliers::addProductRowsToSmartProcess($entityTypeId, $elementId, $productForSupOrder, 'T40c');

            }
        }
    }

    //Получаю массив товарных позиций, по которым нужно сформировать "Заказ поставщику" по "Заявке на закуп"
    /**
     * @param $smartId - ID элемента смарт процесса
     * @param $smartTypeId - ID смарт-процесса
     * @return void
     */
    public static function checkRemainBySmartGroupSuplier($smartId, $smartTypeId)
    {

        //Получаем список товарных позиций привязанных к смартпро Заявка
        $arPrRaw = self::getProductRowsByEntytiId($smartId, $smartTypeId);
        //pr($arPrRaw);
        //Получаем остатков товаров по товарным позициям привязанных к сделкам
        $arrPrQuantyty = self::getProdectQuantityBrProductRawDeal($arPrRaw);
        //pr($arrPrQuantyty);
        //Группируем товарные позиции по поставщикам
        $arrProductGropedSupplied = self::getArrPrBySupplier($arrPrQuantyty, $arPrRaw);
        //pr($arrProductGropedSupplied);
        if(!empty($arrProductGropedSupplied)) {
            foreach ($arrProductGropedSupplied as $key => $productSupl) {

                //Проверяем заполнен ли массив, если да, то создаем смарт процесс Заказ поставщику
                $entityTypeId = 1052;
                $fields = [
                    //'TITLE' => 'Название элемента',
                    'ASSIGNED_BY_ID' => 1,
                    'PARENT_ID_1036' => $smartId,
                    'PARENT_ID_1048' => $key,
                ];

                $elementId = ManagerSuppliers::createSmartProcessElement($entityTypeId, $fields);

                //Добавляем товарные позиции из массива
                if ($elementId) {

                    ManagerSuppliers::addProductRowsToSmartProcess($entityTypeId, $elementId, $productSupl, 'T41c');

                }
            }
        }
    }

    //Добавляю остаток в каталог
    /**
     * @param $smartId
     * @param $smartTypeId
     * @return void
     */
    public static function increaseProductQuantityBySmart($smartId, $smartTypeId)
    {
        $arPrRaw = self::getProductRowsByEntytiId($smartId, $smartTypeId);

        foreach ($arPrRaw as $prRow) {
            self::increaseProductQuantity($prRow['ID'], $prRow['QUANTITY']);
        }

    }


    //Обновляю товарный запас каталога
    /**
     * @return void
     * @throws \Exception
     */
    public static function updateProductRemain()
    {
        //Получаю все товары
        $catalog = self::getOfferCatalog();

        foreach ($catalog as $offer) {
            $recent = self::getRandomInteger();

            self::increaseProductQuantity($offer, $recent);
        }

    }

    //Получаем список товарных позиций привязанных к сущности
    /**
     * @param $entyty_id - ID сущности
     * @param $entyty_type - Тип сущности
     * @return array
     */
    public static function getProductRowsByEntytiId($entyty_id, $entyty_type ='D')
    {
        $productRows = [];

        $result = \Bitrix\Crm\ProductRowTable::getList([
            'filter' => [
                'OWNER_ID' => $entyty_id,
                'OWNER_TYPE' => $entyty_type, // Указываем, что владелец - это сделка
            ],
            'select' => ['ID', 'PRODUCT_ID', 'PRODUCT_NAME',  'PRICE', 'QUANTITY'],
            'order' => ['ID' => 'ASC'],
        ]);

        $arr = [];
        while($row = $result->fetch())
        {
            $arr[$row['PRODUCT_ID']] = $row;
        }

        return $arr;
    }

    //Получаю ID поставщика товара
    /**
     * @param $pr_id - ID товара
     * @return mixed
     */
    public static function getSupplierId($pr_id)
    {
        $res = \Bitrix\Iblock\Elements\ElementcatalogcrmTable::getList([
            'select' => [
                '*',
                'SUPPLIER'
            ],
            'filter' => [
                'ID' => ($pr_id - 1),
                'IBLOCK_ID' => 14,
            ],
            'order' => [
                'ID' => 'ASC',
            ]
        ])->fetch();

        $supplierId = $res['IBLOCK_ELEMENTS_ELEMENT_CATALOGCRM_SUPPLIER_VALUE'];

        return $supplierId;
    }

    //Получаем остатков товаров по товарным позициям привязанных к сделкам
    /**
     * @param $arPrRaw - массив содержащий товарные позиции по сделке
     * @return array
     */
    public static function getProdectQuantityBrProductRawDeal($arPrRaw)
    {
        $productData = \Bitrix\Catalog\ProductTable::getList([
            'filter'=> ['ID' => array_keys($arPrRaw)],
            'select' => ['ID', 'QUANTITY'],
            //'select' => ['*'],
            'order' => ['ID' => 'ASC'],
        ]);

        $arr = [];
        while($raw = $productData->fetch())
        {
            //$arr[$raw['ID']] = $raw['QUANTITY'];
            $raw['SUPPLIER'] = self::getSupplierId($raw['ID']);
            $arr[$raw['ID']] = $raw;
        }

        return $arr;
    }

    //Формируем массив товаров с недостаточным кол-вом и кол-во для дозаказа
    /**
     * @param $arrPrQuantyty - массив содержащий товары по товарным позициям с остатками
     * @param $arPrRaw - массив содержащий товарные позиции по сделке
     * @return array
     */
    public static function getProductQuantytyForSupplierOrder($arrPrQuantyty, $arPrRaw){
        $arr = [];

        foreach ($arrPrQuantyty as $key => $prQuantyty) {

            $res = $prQuantyty['QUANTITY'] - intval($arPrRaw[$key]['QUANTITY']);
            if($res < 0){
                $arr[$key] = [
                    'PRODUCT_ID' => $key,
                    'QUANTITY' => abs($res),
                    'SUPPLIER' => $prQuantyty['SUPPLIER'],
                ];
            }
        }

        return $arr;
    }

    //Группирую отсутсвующие позиции для заказа по поставщикам
    /**
     * @param $productForSupOrder - массив содержащий товарные позиции по сделке и ID поставщика
     * @param $arPrRaw - массив содержащий товарные позиции по сделке
     * @return array
     */
    public static function getArrPrBySupplier($productForSupOrder, $arPrRaw)
    {

        foreach ($productForSupOrder as $el){
            $supplierId = $el['SUPPLIER'];
            if (!isset($groupedArray[$supplierId])) {
                $groupedArray[$supplierId] = [];
            }
            $el['QUANTITY'] = $arPrRaw[$el['ID']]['QUANTITY'];
            $el['PRODUCT_ID'] = $el['ID'];
            $groupedArray[$supplierId][] = $el;
        }

        return $groupedArray;
    }

    //Увеличиваю остаток у товарной позиции

    /**
     * @param $productId - ID товара из каталога
     * @param $quantityToAdd - кол-во которое необходимо добавить
     * @return void
     * @throws \Bitrix\Main\LoaderException
     */
    public static function increaseProductQuantity($productId, $quantityToAdd)
    {
        if(\Bitrix\Main\Loader::includeModule('catalog'))
        {
            // Получаем текущий остаток товара
            $productData = \CCatalogProduct::GetByID($productId);

            if ($productData) {
                $newQuantity = $productData['QUANTITY'] + $quantityToAdd;

                // Обновляем остаток товара
                $result = \CCatalogProduct::Update($productId, ['QUANTITY' => $newQuantity]);

//                if ($result) {
//                    echo "Остаток товара с ID $productId успешно обновлен. Новый остаток: $newQuantity.";
//                }
//                else {
//                    echo "Ошибка при обновлении остатка товара.";
//                }
            }
//            else {
//                echo "Товар с ID $productId не найден.";
//            }
        }
    }

    //Уменьшаю остаток у товарной позиции
    /**
     * @param $productId - ID товара из каталога
     * * @param $quantityToAdd - кол-во которое необходимо убрать
     * @return void
     * @throws \Bitrix\Main\LoaderException
     */
    public static function reduceProductQuantity($productId, $quantityToAdd)
    {
        if (\Bitrix\Main\Loader::includeModule('catalog'))
        {
            // Получаем текущий остаток товара
            $productData = CCatalogProduct::GetByID($productId);

            if ($productData) {

                $newQuantity = $productData['QUANTITY'] - $quantityToAdd;

                if ($newQuantity < 0) {
                    $newQuantity = 0;
                }

                // Обновляем остаток товара
                $result = CCatalogProduct::Update($productId, ['QUANTITY' => $newQuantity]);

                if ($result) {
                    echo "Остаток товара с ID $productId успешно обновлен. Новый остаток: $newQuantity.";
                } else {
                    echo "Ошибка при обновлении остатка товара.";
                }
            } else {
                echo "Товар с ID $productId не найден.";
            }
        }
    }

    //Получаю все ID каталога торговых предложений

    /**
     * @return array - получаем массив торговых предложений
     */
    public static function getOfferCatalog()
    {
        $arrPrOffers = \Bitrix\Iblock\Elements\ElementofferproductTable::getList([
            'select' => [
                'ID'
            ],
        ]);

        $catalog = [];
        while($arrPrOffer = $arrPrOffers->fetch())
        {
            $catalog[] = $arrPrOffer['ID'];
        }

        return $catalog;
    }

    //Делаю запрос на сервис для получения остатков

    /**
     * @return string
     * @throws \Exception
     */
    public static function getRandomInteger()
    {
        $httpClient = new \Bitrix\Main\Web\HttpClient();
        $url = 'https://www.random.org/integers/?num=1&min=0&max=10&col=1&base=10&format=plain&rnd=new';

        // Выполняем GET-запрос
        $response = $httpClient->get($url);

        if ($response !== false) {
            // Успешный запрос, возвращаем ответ
            return trim($response); // Используем trim, чтобы убрать лишние пробелы и символы новой строки
        } else {
            // Обработка ошибки
            $error = $httpClient->getError();
            throw new \Exception('Ошибка при выполнении запроса: ' . implode(', ', $error));
        }
    }


    //Метод для обработки события изменения остатков
    /**
     * @param \Bitrix\Main\ORM\Event $event
     * @return void
     */
    public static function hendlerCheckRemainByCatalog(\Bitrix\Main\ORM\Event $event)
    {
        $id = $event->getParameter("id");
        $parameters = $event->getParameters();
        if(!array_key_exists('TYPE', $parameters['fields'] ) && $parameters['fields']['QUANTITY'] == 0)
        {

            //Запускаем метод создания заявки на закуп
            $path = $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/classes/Otus/Handlers/log.txt';
            addFileLog("Что пришло в событие", $path);
            addFileLog("ID: " . $id['ID'], $path);
            addFileLog(json_encode($parameters, JSON_UNESCAPED_UNICODE), $path);
            self::checkRemainByCatalog($id['ID']);

        }
    }


}