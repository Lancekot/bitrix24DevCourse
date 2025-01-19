<?php

namespace Models\Lists;

use Models\AbstractIblockPropertyValuesTable;
use Models\Lists\SchoolTable;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Entity\Query\Join;
use Models\Lists\SchoolTable as School;

use Models\Lists\TeacherTable as Teacher;

class ClassroomTable extends AbstractIblockPropertyValuesTable
{
    public const IBLOCK_ID = 21;


    //Долджен описать связь
    public static function getMap(): array
    {
        $map = [

            //Вариант 1
//            'SCHOOL_REL' => new ReferenceField(
//                'SCHOOL_REL',
//                SchoolTable::class,
//                ['=this.SCHOOL' => 'ref.IBLOCK_ELEMENT_ID']
//            )

            (new ReferenceField(
                    'SCHOOL_REL',
                    School::class,
                    ['=this.SCHOOL' => 'ref.IBLOCK_ELEMENT_ID']
                )
            ),
            (new ReferenceField(
                    'CLASSROOM_TEACHER',
                    Teacher::class,
                    ['=this.CLASSROOM_TEACHER_ID' => 'ref.ID']
                )
            ),


        //Вариант2
//
//
//            (new Reference('SCHOOL_REL',
//                SchoolTable::class,
//                Join::on('this.SCHOOL', 'ref.IBLOCK_ELEMENT_ID')))
//                ->configureJoinType('inner'),


        ];

        return parent::getMap() + $map;


    }

}

//ref.ELEMENT_ID
//ref.IBLOCK_ELEMENT_ID