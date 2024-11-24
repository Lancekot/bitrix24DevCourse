<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */
$APPLICATION->setTitle('Отладка пример');

\Bitrix\Main\Diag\Debug::dump([
    1,
    2,
    3,
    4,
    6,
    -4,
    -2,
    -11,
    111,
    -11
]);




require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
