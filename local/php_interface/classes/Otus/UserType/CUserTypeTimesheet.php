<?php


namespace Otus\UserType;


use Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Iblock;

/**
 * Реализация свойство «Расписание врача»
 * Class CUserTypeTimesheet
 * @package lib\usertype
 */
class CUserTypeTimesheet
{
    /**
     * Метод возвращает массив описания собственного типа свойств
     * @return array
     */
    public static function GetUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE' => Iblock\PropertyTable::TYPE_STRING,
            'USER_TYPE' => 'TIMESHEET',
            //'USER_TYPE_ID' => 'user_timesheet', //Уникальный идентификатор типа свойств
            'DESCRIPTION' => 'Расписание специалиста',

            'CLASS_NAME' => __CLASS__,
            'ConvertToDB' => [__CLASS__, 'ConvertToDB'],
            'ConvertFromDB' => [__CLASS__, 'ConvertFromDB'],

            'GetPropertyFieldHtml' => [__CLASS__, 'GetPropertyFieldHtml'],
        );
    }

    /**
     * Конвертация данных перед сохранением в БД
     * @param $arProperty
     * @param $value
     * @return mixed
     */
    public static function ConvertToDB($arProperty, $value)
    {
        if(is_array($value) && isset($value['VALUE']['TIME_FROM']) && isset($value['VALUE']['TIME_TO'])){

            if ($value['VALUE']['TIME_FROM'] != '' && $value['VALUE']['TIME_TO'] != '')
            {
                try {
                    $value['VALUE'] = base64_encode(serialize($value['VALUE']));

                } catch(Bitrix\Main\ObjectException $exception) {
                    echo $exception->getMessage();
                }
            } else {
                $value['VALUE'] = '';
            }
        }else{
            $value['VALUE'] = '';
        }

        return $value;
    }

    /**
     * Конвертируем данные при извлечении из БД
     * @param $arProperty
     * @param $value
     * @param string $format
     * @return mixed
     */
    public  static function ConvertFromDB($arProperty, $value, $format = '')
    {
        if ($value['VALUE'] != '')
        {
            try {
                $value['VALUE'] = base64_decode($value['VALUE']);
            } catch(Bitrix\Main\ObjectException $exception) {
                echo $exception->getMessage();
            }
        }

        return $value;
    }

    /**
     * Представление формы редактирования значения в Админке
     * @param $arUserField
     * @param $arHtmlControl
     */
    public static function GetPropertyFieldHtml($arProperty, $value, $arHtmlControl)
    {
        $weekDays = [
            'mon' => 'Понедельник',
            'tue' => 'Вторник',
            'wed' => 'Среда',
            'thu' => 'Четверг',
            'fri' => 'Пятница',
            'sat' => 'Суббота',
            'sun' => 'Воскресенье',
        ];

        $itemId = 'row_' . substr(md5($arHtmlControl['VALUE']), 0, 10); //ID для js
        $fieldName =  htmlspecialcharsbx($arHtmlControl['VALUE']);
        //htmlspecialcharsback нужен для того, чтобы избавиться от многобайтовых символов из-за которых не работает unserialize()
        $arValue = unserialize(htmlspecialcharsback($value['VALUE']), [stdClass::class]);

        $select = '<select class="week_day" name="'. $fieldName .'[WEEK_DAY]">';
        foreach ($weekDays as $key => $day){
            if($arValue['WEEK_DAY'] == $key){
                $select .= '<option value="'. $key .'" selected="selected">'. $day .'</option>';
            } else {
                $select .= '<option value="'. $key .'">'. $day .'</option>';
            }

        }
        $select .= '</select>';

        $html = '<div class="property_row" id="'. $itemId .'">';

        $html .= '<div class="reception_time">';
        $html .= $select;
        $timeFrom = ($arValue['TIME_FROM']) ? $arValue['TIME_FROM'] : '';
        $timeTo = ($arValue['TIME_TO']) ? $arValue['TIME_TO'] : '';

        $html .='&nbsp;время приёма: с&nbsp;<input type="time" name="'. $fieldName .'[TIME_FROM]" value="'. $timeFrom . '">';
        $html .='&nbsp;по&nbsp;<input type="time" name="'. $fieldName .'[TIME_TO]" value="'. $timeTo .'">';
        if($timeFrom!='' && $timeTo!=''){
            $html .= '&nbsp;&nbsp;<input type="button" style="height: auto;" value="x" title="Удалить" onclick="document.getElementById(\''. $itemId .'\').parentNode.parentNode.remove()" />';
        }
        $html .= '</div>';

        $html .= '</div><br/>';

        return $html;
    }
}