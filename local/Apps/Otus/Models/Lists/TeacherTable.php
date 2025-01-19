<?php
namespace Models\Lists;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Entity\Query\Join;

use Models\Lists\SchoolTable as School;
use Models\Lists\ClassroomTable as Classroom;
use Models\Lists\SchoolSubjectTable as SchoolSubject;




/**
 * Class Table
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> NAME string(50) optional
 * <li> LAST_NAME string(50) optional
 * <li> SECOND_NAME string(50) optional
 * <li> SCHOOL_SUBJECT_ID int optional
 * <li> SCHOOL_ID int optional
 * <li> CLASSROOM_ID int optional
 * </ul>
 *
 * @package Bitrix\
 **/

class TeacherTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'teacher';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            'ID' => (new IntegerField('ID',
                []
            ))->configureTitle(Loc::getMessage('_ENTITY_ID_FIELD'))
                ->configurePrimary(true)
                ->configureAutocomplete(true)
            ,
            'NAME' => (new StringField('NAME',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 50),
                        ];
                    },
                ]
            ))->configureTitle(Loc::getMessage('_ENTITY_NAME_FIELD'))
            ,
            'LAST_NAME' => (new StringField('LAST_NAME',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 50),
                        ];
                    },
                ]
            ))->configureTitle(Loc::getMessage('_ENTITY_LAST_NAME_FIELD'))
            ,
            'SECOND_NAME' => (new StringField('SECOND_NAME',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 50),
                        ];
                    },
                ]
            ))->configureTitle(Loc::getMessage('_ENTITY_SECOND_NAME_FIELD'))
            ,

            'SCHOOL_SUBJECT_ID' => (new IntegerField('SCHOOL_SUBJECT_ID',
                []
            ))->configureTitle(Loc::getMessage('_ENTITY_SCHOOL_SUBJECT_ID_FIELD'))
            ,




            'SCHOOL_ID' => (new IntegerField('SCHOOL_ID',
                []
            ))->configureTitle(Loc::getMessage('_ENTITY_SCHOOL_ID_FIELD'))
            ,

            (new ReferenceField(
                'SCHOOL',
                School::class,
                ['=this.SCHOOL_ID' => 'ref.IBLOCK_ELEMENT_ID']
            )),


            'CLASSROOM_ID' => (new IntegerField('CLASSROOM_ID',
                []
            ))->configureTitle(Loc::getMessage('_ENTITY_CLASSROOM_ID_FIELD'))
            ,

            (new ReferenceField(
                'CLASSROOM',
                Classroom::class,
                ['=this.CLASSROOM_ID' => 'ref.IBLOCK_ELEMENT_ID']
            )),

            (new ManyToMany('SUBJECT', SchoolSubject::class))
                ->configureTableName('school_teacher_subject')
                ->configureLocalPrimary('ID', 'TEACHER_ID')
                ->configureLocalReference('teacher')
                ->configureRemotePrimary('IBLOCK_ELEMENT_ID', 'SCHOOL_SUBJECT_ID')
                ->configureRemoteReference('b_iblock_element_prop_s23'),


        ];






    }
}
