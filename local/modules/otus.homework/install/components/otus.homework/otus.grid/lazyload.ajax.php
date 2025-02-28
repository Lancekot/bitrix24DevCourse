<?php

declare(strict_types=1);

use Bitrix\Crm\Service\Container;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;


define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define('NO_AGENT_CHECK', true);
define('PUBLIC_AJAX_MODE', true);
define("DisableEventsCheck", true);


$siteId = isset($_REQUEST['site']) ? mb_substr(preg_replace("/[^a-z0-9_]/", "", $_REQUEST['site']), 0, 2) : '';
if($siteId !== ''){
    define('SITE_ID', $siteId);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
    die();
}


if(!CModule::IncludeModule('crm') || !CCrmSecurityHelper::IsAuthorized() || !check_bitrix_sessid()){
    die();
}

$dealId = (int)Application::getInstance()->getContext()->getRequest()->get('dealId');

$APPLICATION->IncludeComponent(
    'otus.homework:otus.grid',
    '',
    [
        'dealId' => $dealId,
    ]
);

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
die();


