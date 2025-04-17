<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Diag\Debug;


$date = date("d.m.Y");
Debug::writeToFile($date, 'Дата запроса');


