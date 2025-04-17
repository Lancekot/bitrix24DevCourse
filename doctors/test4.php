<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

//use OTUSPROJECT\Handlers\ManagerRemainProducts;
//
//
//
//ManagerRemainProducts::updateProductRemain();



use OTUSPROJECT\Handlers\ManagerCrmEntyty;

$contactId = 2;
$deals = ManagerCrmEntyty::checkAllDealByContact($contactId);

pr($deals);



//
//



