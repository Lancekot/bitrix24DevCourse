require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Учителя");

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;

use Models\Lists\ClassroomTable as Classroom;
use Models\Lists\SchoolTable as School;
use Models\Lists\SchoolSubjectTable as SchoolSubject;
use Models\Lists\TeacherTable as Teacher;


use Models\Lists\DoctorsPropertyValuesTable as Doctors;

//Вариант 1
//$classroom_iblock = Iblock::wakeUp(21)->getEntityDataClass(); //Bitrix\Iblock\Elements\ElementClassroomTable
//$classroom_iblock_data = $classroom_iblock::getList([
//    'select' => [
////        'ID', 'NAME'
//    '*', 'SCHOOL.ELEMENT.*' , 'SCHOOL.ELEMENT.NAME_SCHOOL' , 'SCHOOL.ELEMENT.CLASSROOMS'
//    ],
//])->fetchObject();
//
//pr($classroom_iblock_data->getId());
//pr($classroom_iblock_data->getName());
//pr($classroom_iblock_data->getSchool()->getElement()->getName());
//pr($classroom_iblock_data->getSchool()->getElement()->getNameSchool()->getValue());
//
//$arrr = $classroom_iblock_data->getSchool()->getElement()->getClassrooms()->getAll();
//foreach($arrr as $el){
//
//    pr($el->getValue());
//
//}

// Вариант 2
//$classRoom_2 = Bitrix\Iblock\Elements\ElementClassroomTable::getList([
//    'select' => [
//        '*', 'SCHOOL.ELEMENT.*', 'SCHOOL.ELEMENT.NAME_SCHOOL', 'SCHOOL.ELEMENT.CLASSROOMS'
//    ]
//])->fetchObject();
//
//pr($classRoom_2->getId());
//pr($classRoom_2->getName());
//pr($classRoom_2->getSchool()->getElement()->getName());
//pr($classRoom_2->getSchool()->getElement()->getNameSchool()->getValue());
//
//$arrr = $classRoom_2->getSchool()->getElement()->getClassrooms()->getAll();
//foreach($arrr as $el){
//
//    pr($el->getValue());
//
//}


//Вариант 3
//$classroom_data = Classroom::getList([
//    'select' => [
//        '*', 'ELEMENT.ID', 'ELEMENT.NAME', 'SCHOOL_REL.ELEMENT', 'CLASSROOM_TEACHER'
//    ],
//])->fetchObject();
//
////pr($classroom_data);
////pr($classroom_data);
//pr($classroom_data->getElement()->getId());
//pr($classroom_data->getElement()->getName());
//pr($classroom_data->getSchool());
//pr($classroom_data->getSchoolRel()->getElement()->getName());
//pr($classroom_data->getClassroomTeacher()->getName());




////Вариант 2
//$school_data = Bitrix\Iblock\Elements\ElementSchoolsTable::getList([
//    'select' => [
//        '*', 'CLASSROOMS.ELEMENT'
//    ]
//])->fetchObject();
//
//pr($school_data->getId());
//pr($school_data->getName());
//
//$ggfgfg = $school_data->getClassrooms()->getAll();
//
//foreach( $ggfgfg as $fff){
//
//    pr($fff->getElement()->getName());
//
//};


////Вариант 3
//$school_data = School::getList([
//    'select' => [
//        '*', 'CLASSROOMS_D', 'ELEMENT.*', 'TEACHERS'
//    ],
//
//])->fetchObject();
//
////pr($school_data);
//
//pr(gettype($school_data->getTeachers()->getAll()));
//
//foreach($school_data->getTeachers()->getAll() as $el){
//
//    pr($el->getName());
//
//}


//pr($school_data->getElement()->getId());
//pr($school_data->getElement()->getName());
//
//pr(gettype($school_data->getClassroomsD()));
//
//foreach($school_data->getClassroomsD()->getAll() as $df){
//    pr($df->getNameClassroom());
//}

//foreach($school_data->getTeachersId() as $rl){
//
//    pr($rl);
//
//}




//Вариант 3
//$teacher = Teacher::getList([
//    'select' => [
//        '*', 'SCHOOL.ELEMENT' , 'CLASSROOM.ELEMENT' , 'SUBJECT'
//    ],
//])->fetchObject();

//pr($teacher);

//pr($teacher->getId());
//pr($teacher->getName());
//pr($teacher->getLastName());
//pr($teacher->getSecondName());
//
////pr(gettype($teacher->getSchool()));
//pr($teacher->getSchool()->getElement()->getName());
//pr($teacher->getClassroom()->getElement()->getName());
//pr($teacher->getSchoolSubjectId());
//pr($teacher->getClassroomId());
//foreach($teacher->getSubject()->getAll() as $subject){
//    pr($subject->getNameSubject());
//}
//










?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>