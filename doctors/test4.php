<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

//use OTUSPROJECT\Handlers\ManagerRemainProducts;
//
//
//
//ManagerRemainProducts::updateProductRemain();



//use OTUSPROJECT\Handlers\ManagerCrmEntyty;
//
//$contactId = 2;
//$deals = ManagerCrmEntyty::checkAllDealByContact($contactId);
//
//pr($deals);
//
//


//$deal_id = 26;
//
//$deals = \Bitrix\Crm\DealTable::getList([
//    'filter' => [
//        'ID' => $deal_id
//    ],
//    'select' => ['ID', 'STAGE_ID', 'TITLE', 'UF_CRM_1744910392', 'CONTACT_ID', 'ASSIGNED_BY_ID', 'DATE_CREATE' , 'CLOSEDATE', ],
//    //'select' => ['*'],
//    'order' => ['ID' => 'ASC']
//])->fetch();
////
//pr($deals);
////




$deals = \Bitrix\Crm\DealTable::getList([
    'filter' => [
        '=CONTACT_ID' => 2,
        'UF_CRM_1744910392' => 35,
        'CLOSED' => 'N'
    ],
    'select' => ['ID']
])->fetchAll();

pr($deals);