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


use Bitrix\Main\Application,
    Bitrix\Main\Type\DateTime,
    Bitrix\Main\Loader,
    Bitrix\Main\SystemException;

class OtusCurrenciesComponent extends CBitrixComponent
{


    public function onPrepareComponentParams($arParams)
    {
        // тут пишем логику обработки параметров, дополнение к параметрам по умолчанию
        return $arParams;
    }


    private function checkModules()
    {
        if(!Loader::includeModule('currency')){

            throw new \Exception("Не загружены модули необходимые для работы компонента");
        }
        return true;
    }


    private function getCurrentRate()
    {
        return $this->arParams['SELECT_ES'];

    }


    public function executeComponent()
    {
        try {
            $this->checkModules(); //проверяем подключение модулей


            $this->arResult['ARR_CURRENCY_RATE'] = $this->getCurrentRate();

//            $this->arResult['ARR_CURRENCY_RATE'] = "Хрен с горы";



            //Подлключаем шаблон
            $this->includeComponentTemplate();


        }
        catch (SystemException $e){
            ShowError($e->getMessage());
        }
    }












}