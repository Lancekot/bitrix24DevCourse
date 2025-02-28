<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */

/** @global CIntranetToolbar $INTRANET_TOOLBAR */

use Bitrix\Main\Context,
    Bitrix\Main\Application,
    Bitrix\Main\Type\DateTime,
    Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Engine\Contract\Controllerable,
    Bitrix\Iblock;

use Bitrix\Main\Engine\Contract;
use Bitrix\Main\SystemException;


class OtusGridComponent extends \CBitrixComponent
{
    protected $request;

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return mixed
     */

    public function onPrepareComponentParams($arParams)
    {
        // тут пишем логику обработки параметров, дополнение к параметрам по умолчанию
        return $arParams;
    }


    /**
     * Проверка наличия модулей требуемых для работы компонента
     * @return bool
     * @throws Exepption
     */

    private function checkModules()
    {
        if (!Loader::includeModule('iblock') || !Loader::includeModule('crm')) {

            throw new \Exception("Не загружены модули необходимые для работы компонента");
        }
        return true;
    }

    private function getModulIblock()
    {
        $iblockId = \Bitrix\Main\Config\Option::get('otus.homework', 'test_iblock_id');
        $className = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();
        $classIblock = new $className;

        return $classIblock;

    }

    private function getColumn($classIblock)
    {
        //Получаю массив этого инфоблок
        $fieldMap = $classIblock::getMap();

        $columns = [];

        foreach ($fieldMap as $key => $field) {
            $columns[] = [
                'id' => $field->getName(),
                'name' => $field->getTitle()
            ];
        }

        return $columns;
    }

    private function getList($classIblock, $page = 1, $limit = 20)
    {
        $offset = $limit * ($page - 1);
        $list = [];

        $data = $classIblock::getList([
            'select' => ['*'],
            'order' => ['ID' => 'ASC'],
            'limit' => $limit,
            'offset' => $offset,
        ]);

        while ($item = $data->fetch()) {
            $list[] = ['data' => $item];
        }

        return $list;
    }

    public function executeComponent()
    {
        try {
            $this->checkModules(); //проверяем подключение модулей

            $iblockIdClass = $this->getModulIblock();

            $this->arResult['COLUMNS'] = $this->getColumn($iblockIdClass); // получаем название полей таблицы
            $this->arResult['LISTS'] = $this->getList($iblockIdClass); //получаем записи таблицы
            $this->arResult["COUNT"] = $iblockIdClass::getCount(); //количесвто записей


            //Подлключаем шаблон
            $this->includeComponentTemplate();
        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }
}