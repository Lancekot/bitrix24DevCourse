<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use OTUSPROJECT\Handlers\ManagerRemainProducts;


$pr_id = 140;
$q = 1;
ManagerRemainProducts::increaseProductQuantity($pr_id , $q);
