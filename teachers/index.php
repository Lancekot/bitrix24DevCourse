<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Учителя");

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;

use Models\Lists\ClassroomTable as Classroom;
use Models\Lists\SchoolTable as School;
use Models\Lists\SchoolSubjectTable as SchoolSubject;
use Models\Lists\TeacherTable as Teacher;
use Models\Lists\DoctorsPropertyValuesTable as Doctors;



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




echo "Отдельно созданная таблица 'Учителя', которая связана со списками Школа (1:N), Классы (1:N), Школьные предметы (N:M) ";
$teacher = Teacher::getList([
    'select' => [
        '*', 'SCHOOL.ELEMENT' , 'CLASSROOM.ELEMENT' , 'SUBJECT'
    ],
])->fetchObject();

//pr($teacher);

echo "<br>Данные об учителе: ";
pr($teacher->getId());
pr($teacher->getName());
pr($teacher->getLastName());
pr($teacher->getSecondName());

echo "Учитель работает в школе: ";
pr($teacher->getSchool()->getElement()->getName());



echo "Данный учитель, является классным руководителем, класса 5А";
pr($teacher->getClassroom()->getElement()->getName());

echo "Предметы, которые ведет учитетль";
foreach($teacher->getSubject()->getAll() as $subject){
    pr($subject->getNameSubject());
}




























?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>