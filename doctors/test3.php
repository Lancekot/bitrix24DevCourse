<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");


Bitrix\Main\Loader::includeModule('catalog');


//Увеличить остаток товарной позиции на $quantityToAdd (кол-во)
function increaseProductQuantity($productId, $quantityToAdd)
{
    // Получаем текущий остаток товара
    $productData = CCatalogProduct::GetByID($productId);

    if ($productData) {
        $newQuantity = $productData['QUANTITY'] + $quantityToAdd;

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

//Уменьшить остаток товарной позиции на $quantityToAdd (кол-во)
function reduceProductQuantity($productId, $quantityToAdd)
{
    // Получаем текущий остаток товара
    $productData = CCatalogProduct::GetByID($productId);

    if ($productData) {

        $newQuantity = $productData['QUANTITY'] - $quantityToAdd;

        if($newQuantity < 0)
        {
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


//Получаем список товарных позиций привязанных к сделкам
function getProductRowsByDealId($entyty_id, $entyty_type ='D')
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
} //Проверить будет ли работать со смартами



//Получаем остатков товаров по товарным позициям привязанных к сделкам
function getProdectQuantityBrProductRawDeal($arPrRaw){
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
        $raw['SUPPLIER'] = getSupplierId($raw['ID']);
        $arr[$raw['ID']] = $raw;
    }

    return $arr;
}


//Получаю ID поставщика товара
function getSupplierId($pr_id)
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


//Формируем массив товаров с недостаточным кол-вом и кол-во для дозаказа
function getProductQuantytyForSupplierOrder($arrPrQuantyty, $arPrRaw){
    $arr = [];

    foreach ($arrPrQuantyty as $key => $prQuantyty) {

        $res = $prQuantyty['QUANTITY'] - intval($arPrRaw[$key]['QUANTITY']);
        if($res < 0){
            $arr[$key] = [
                'ID' => $key,
                'QUATITY_ORDER' => abs($res),
                'SUPPLIER' => $prQuantyty['SUPPLIER'],
            ];
        }
    }

    return $arr;
}


//Группирую отсутсвующие позиции для заказа по поставщикам
function genArrPrBySupplier($productForSupOrder)
{

    foreach ($productForSupOrder as $el){
        $supplierId = $el['SUPPLIER'];
        if (!isset($groupedArray[$supplierId])) {
            $groupedArray[$supplierId] = [];
        }
        $groupedArray[$supplierId][] = $el;
    }

    return $groupedArray;
}


//Создаю элемент смарт процесса
function createSmartProcessElement($entityTypeId, $fields)
{
    if(Bitrix\Main\Loader::includeModule('crm'))
    {
        // Получаем сервис для работы с сущностями CRM
        $factory = Bitrix\Crm\Service\Container::getInstance()->getFactory($entityTypeId);

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
        $result = $item->save();

        if ($result->isSuccess()) {
            $elementId = $item->getId();
            return $elementId;

        } else {
            $errors = $result->getErrorMessages();
            return  "Ошибка при создании элемента: " . implode(', ', $errors);
        }
    }
}


//Получаю данные полей элемента смарт проецсса по его $entityTypeId и $entityId
function getDataFieldsSmartById($entityId, $entityTypeId)
{
    if(Bitrix\Main\Loader::includeModule('crm')) {
        $entityTypeId = $entityTypeId;
        $factory = Bitrix\Crm\Service\Container::getInstance()->getFactory($entityTypeId);
        $item = $factory->getItem($entityId);
        return $item->getCompatibleData();
    }
}


//Добавляю в элемент смарт процесса товарные позиции
function addProductRowsToSmartProcess($entityTypeId, $elementId, $productRows)
{
    // Удаляем существующие товарные позиции для элемента
//    Bitrix\Crm\ProductRowTable::deleteByOwner($entityTypeId, $elementId);

    // Добавляем новые товарные позиции
    foreach ($productRows as $productRow) {
        $productRow['OWNER_ID'] = $elementId;
        $productRow['OWNER_TYPE'] = 'T40c';

        $result = \Bitrix\Crm\ProductRowTable::add($productRow);
        $factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory($entityTypeId);
        $item = $factory->getItem($elementId);
        $operation = $factory->getUpdateOperation($item); // вызывает операцию обновления
        $result = $operation->launch(); // запускает ее

        if (!$result->isSuccess()) {
            $errors = $result->getErrorMessages();
            echo "Ошибка при добавлении товарной позиции: " . implode(', ', $errors);
        }
    }

    echo "Товарные позиции успешно добавлены к элементу с ID: " . $elementId;
}




//Проверка активных сделок по клиенту и вывод сообщение об ошибке для обработчика
function areAllDealsInProgressForContact($contactId)
{
    // Определяем статус, который считается "в работе"
    $inProgressStatuses = ['NEW', 'IN_PROGRESS']; // Замените на актуальные статусы для вашей системы

    // Получаем все сделки, связанные с контактом
    $deals = Bitrix\Crm\DealTable::getList([
        'filter' => ['=CONTACT_ID' => $contactId],
        'select' => ['ID', 'STAGE_ID']
    ])->fetchAll();

    if (empty($deals)) {
        echo "У контакта с ID $contactId нет сделок.";
        return false;
    }

    // Проверяем, все ли сделки находятся в статусе "в работе"
    foreach ($deals as $deal) {
        if (!in_array($deal['STAGE_ID'], $inProgressStatuses)) {
            echo "Не все сделки контакта с ID $contactId находятся в работе.";
            return false;
        }
    }

    echo "Все сделки контакта с ID $contactId находятся в работе.";
    return true;
}



//Получить ID элемента смартпроцесса поставщик

//$dealId = 21;
////Получаю список товарных позиций привязанных к сделке
//$arPrRaw =  getProductRowsByDealId($dealId);
//pr($arPrRaw);
//
////Получаем остатки по каждой товарной позиции
//$arrPrQuantyty = getProdectQuantityBrProductRawDeal($arPrRaw);
//pr($arrPrQuantyty);
//
////Формируем массив товаров с недостаточным кол-вом и кол-во для дозаказа
//$productForSupOrder = getProductQuantytyForSupplierOrder($arrPrQuantyty, $arPrRaw);
//pr($productForSupOrder);
//
//$ff = genArrPrBySupplier($productForSupOrder);
//pr($ff);







// Пример использования
//$entityTypeId = 1036; // Укажите ID типа сущности смарт-процесса
//$fields = [
//    'TITLE' => 'Название элемента',
//    'ASSIGNED_BY_ID' => 1,
//    'PARENT_ID_2' => 21,
//     'PARENT_ID_1052' => 2,
//    // Добавьте другие поля, которые необходимо заполнить
//];
//
//createSmartProcessElement($entityTypeId, $fields);




//
//$res = getDataFieldsSmartById(4, 1036);
//pr($res);




//$entityTypeId = 1036; // Укажите ID типа сущности смарт-процесса
//$elementId = 6; // Укажите ID элемента смарт-процесса
//$productRows = [
//    [
//        'PRODUCT_ID' => 140, // ID товара
//        'PRICE' => 100.00, // Цена товара
//        'QUANTITY' => 2, // Количество товара
//    ],
//    [
//        'PRODUCT_ID' => 144,
//        'PRICE' => 200.00,
//        'QUANTITY' => 1,
//    ]
//];
//addProductRowsToSmartProcess($entityTypeId, $elementId, $productRows);



//$smartId = 6;
//$smartTypeId = 'T40c'; //Тип для товарных позиций "Заявка на закуп"
//
//$result = getProductRawBySmartId($smartId, $smartTypeId);
//pr($result);





//Формирую заявку на закуп (смарт-процесс), куда переношу товарные позиции из массива






//Формирую, массив товаров для заказа по поставщикам













//Обработчик получения остатков для товаров
















// Пример использования
//$productId = 140; // Укажите ID товара
//$quantityToAdd = 15; // Укажите количество, на которое нужно увеличить остаток
//reduceProductQuantity($productId, $quantityToAdd);



////Выборка всех активных складов:
//$rsStore = \Bitrix\Catalog\StoreTable::getList(array(
//    'filter' => array('ACTIVE'>='Y'),
//));
//
//while($arStore=$rsStore->fetch()){
//    $arIBlockListID['STORES'][$arStore['ID']] = $arStore;
//}
//
//pr($arIBlockListID);