<?php

namespace Apps\Otus\MyTest;

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

//Здесь идет описание новой таблицы в БД
class BookTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'bt_my_books';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,]
            ),
            new Entity\StringField('ISBN', [
                'required' => true,
                'column_name' => 'ISBNCODE', //если хочу вернить название
                'validation' => function(){ //Если требуется проверять на корректность заполненния даннымы перед добванеием в таблицу, return должен вернуть true
                    return [new Entity\Validator\RegExp('/[\d-]{13,}/')];
                }
            ]),
            new Entity\StringField('TITLE'),
            new Entity\DateField('PUBLISH_DATE', [
                'default_value' => new Type\Date //сюда можно добавлять и функции callback function
            ]),
            new Entity\BooleanField('CLOSED', ['values' => ['N', 'Y']]),
            new Entity\EnumField('NAME', ['values' => ['VALUE 1', 'VALUE 2', 'VALUE 3', 'VALUE 4']]),

            //Если треубется делать рассчет в рамках БД, то можно передать запрос, и резултат возвращать в поле
            //SELECT DATEDIFF(NOW(), PUBLISH_DATE) AS AGE_DAYS FROM my_book
            new Entity\ExpressionField('AGE_DAYS', 'DATEDIFF(NOW(), %s)', ['PUBLISH_DATE']), // вместо  %s приходит PUBLISH_DATE
        );
    }
    //Для привязки пользоватлебского поля, через админку, нужно добавть
    public static function getUfId()
    {
        return 'MY_BOOK';
    }



    //можно добавлять свои обработчик событий
    public static function onBeforeAdd(Entity\Event $event)
    {
        $result = new Entity\EventResult;
        $data = $event->getParameter("fields");
        if (isset($data['ISBN']))
        {
            $cleanIsbn = str_replace('-', '', $data['ISBN']);
            $result->modifyFields(array('ISBN' => $cleanIsbn));
        }
        return $result;
    }

    //Если треубется сделать проверку при обновление конкретного поля, и вслучае чего, отменить, либо запретить обновление конкретного поля
    public static function onBeforeUpdate(Entity\Event $event)
    {
        $result = new Entity\EventResult;
        $data = $event->getParameter("fields");
        if (isset($data['ISBN']))
        {
            $result->unsetFields(array('ISBN'));
        }
        return $result;
    }



}


// код для создания таблицы в MySQL
// (получен путем вызова BookTable::getEntity()->compileDbTableStructureDump())

//По итогу что создаться таблица? а как это отразится в рамках админки или публичной части?