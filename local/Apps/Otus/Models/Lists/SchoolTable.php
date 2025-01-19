<?php

namespace Models\Lists;

use Models\AbstractIblockPropertyValuesTable;
use Models\Lists\ClassroomTable as Classroom;
use Models\Lists\TeacherTable as Teacher;
use Bitrix\Main\ORM\Fields\Relations\Reference; //OneToOne
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Entity\Query\Join;


class SchoolTable extends AbstractIblockPropertyValuesTable
{
    public const IBLOCK_ID = 22;

    public static function getMap(): array
    {
        $map = [

            (new OneToMany('CLASSROOMS_D', Classroom::class, 'SCHOOL_REL'))
                ->configureJoinType('inner'),



            (new OneToMany('TEACHERS', Teacher::class, 'SCHOOL'))
                ->configureJoinType('inner'),




        ];

        return parent::getMap() + $map;


    }

}