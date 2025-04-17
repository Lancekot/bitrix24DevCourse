<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");




//$hoook = 'https://ct70506.tw1.ru/rest/1/pjackuwka2nnven3';
//
//$method1 = 'otus.clientsdata.add';
//$method2 = 'otus.clientsdata.list';
//$method3 = 'otus.clientsdata.update';
//$method4 = 'otus.clientsdata.delete';
//
//
//$fields = [
// 'ID' => 3,
//'fields' => [
//    'UF_LASTNAME' => 'Тестиик'
//]
//];
//
//$url = $hoook ."/". $method3;
//
//
//$res = sendB24($url, $fields);
//
//pr($res);

//
//$res = new Otus\Diagnostic\OtusFileExceptionHandlerLog();
//$res->ttttt('ffff');


//$activityId = 16;
//$activity = \CCrmActivity::GetByID($activityId);
//
//
//pr($activity);
//


//Метод добавляет технический комментарйи о звонке
//function addCommentLogCallTimeline($entityId, $entityTypeId)
//{
//    \Bitrix\Main\Loader::includeModule('crm');
//
//    $settings = [
//        'TITLE' => 'Test title 22334343423234',
//        'TEXT' => 'sljgnlsfjlj lsj ljsl jlsj ',
//        'ICON_CODE' => 'call', //info - если нужно значок i
//        'CLIENT_ID' => 'N',
//    ];
//
//    $result = Bitrix\Crm\Timeline\Entity\TimelineTable::add([
//        'TYPE_ID' => Bitrix\Crm\Timeline\TimelineType::LOG_MESSAGE,
//        'TYPE_CATEGORY_ID' => Bitrix\Crm\Timeline\LogMessageType::REST,
//        'CREATED' => new Bitrix\Main\Type\DateTime(),
//        'AUTHOR_ID' => 1,
//        'SETTINGS' => $settings,
//        'ASSOCIATED_ENTITY_TYPE_ID' => $entityTypeId,
//        'ASSOCIATED_ENTITY_ID' => $entityId,
//        'ASSOCIATED_ENTITY_CLASS_NAME' => null,
//    ]);
//    if ($result->isSuccess())
//    {
//        $id = $result->getId();
//
//        pr($id);
//
//        $bindings = [
//            [
//                'ENTITY_TYPE_ID' => $entityTypeId,
//                'ENTITY_ID' => $entityId,
//            ]
//        ];
//
//        Bitrix\Crm\Timeline\TimelineEntry::registerBindings($id, $bindings);
//    }
//    foreach ($result->getErrors() as $error)
//    {
//        pr($error);
//    }
//}
//
//
//
//
//
//
//$entityId = 20;
//
//addCommentLogCallTimeline($entityId, 2);



//получаю все записи таймлайн, по типу звонок
//use Bitrix\Crm\Timeline\Entity\TimelineTable;
//\Bitrix\Main\Loader::includeModule('crm');
//
//$filter = [
//    'TYPE_ID' => Bitrix\Crm\Timeline\TimelineType::LOG_MESSAGE,
//    'TYPE_CATEGORY_ID' => Bitrix\Crm\Timeline\LogMessageType::REST,
//    'AUTHOR_ID' => 1,
//    'ASSOCIATED_ENTITY_TYPE_ID' => $entityTypeId,
//    'ASSOCIATED_ENTITY_ID' => $entityId,
//
//];
//
//$result = TimelineTable::getList([
//    'filter' => $filter
//]);
//
//while ($row = $result->fetch()) {
//    logggg($row);
//}


//use Bitrix\Main\Loader;
//use Bitrix\Currency\CurrencyTable;
//
//Loader::includeModule('currency');
//
//function getCurrencyList($currence)
//{
//
//
//    $result = CurrencyTable::getList([
//        'select' => ['AMOUNT'],
//        'filter' => ['CURRENCY' => $currence],
//        'order' => ['SORT' => 'ASC']
//    ])->fetch();
//
//    return $result['AMOUNT'];
//
//}
////$currence = 'RUB';
//$currence = 'USD';
////$currence = 'EUR';
////$currence = 'UAH';
////$currence = 'BYN';
//
//
//
//pr(getCurrencyList($currence));



use Bitrix\Currency\CurrencyTable;

//Loader::includeModule('currency');

$arrCurrency = CurrencyTable::getList([
    'select' => ['CURRENCY', 'AMOUNT', 'NUMCODE' ],
    'order' => ['SORT' => 'ASC']
]);

$currency = [];
while($row = $arrCurrency->fetch())
{
    $currency[$row["NUMCODE"]] = $row['CURRENCY'];
}

pr($currency);







?>