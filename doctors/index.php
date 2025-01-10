<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

//Модели работающие с инфоблоками
use Bitrix\Iblock\Iblock;
use Bitrix\Main\Page\Asset;

function translit($value)
{
    $converter = array(
        'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
        'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
        'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
        'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
        'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
        'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
        'э' => 'e',    'ю' => 'yu',   'я' => 'ya',

        'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
        'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
        'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
        'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
        'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
        'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
        'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
    );

    $value = strtr($value, $converter);
    return $value;
}

$APPLICATION->SetTitle('Врачи');
$APPLICATION->SetAdditionalCSS('/doctors/style.css');


$path = trim($_GET['path'], '/');
$action = '';
$doctor_name = '';


if(!empty($path)){
    $path_parts = explode('/', $path);

   if(sizeof($path_parts) == 1 && in_array($path_parts[0], ['new', 'new_proc'])){

        $action = $path_parts[0];

        if($action == 'new'){
            //Получаю список процедур
            $res = \Bitrix\Iblock\Elements\ElementproceduresTable::getList([
                'select' => ['ID', 'NAME'],
                'order' => ['ID' => 'ASC'],
            ]);

            $procedures = [];

            while ($ar = $res->fetch()) {
                $procedures[$ar['ID']] = $ar['NAME'];
            }


            if(!empty($_POST['form'])){

                $elementData = [
                    'IBLOCK_ID' => 16,
                    'NAME' => translit($_POST["LAST_NAME"]),
                    'ACTIVE' => 'Y', // Элемент будет активен
                    'PROPERTY_VALUES' => [
                        'LAST_NAME' => $_POST["LAST_NAME"],
                        'FIRST_NAME' => $_POST["FIRST_NAME"],
                        'SECOND_NAME' => $_POST["SECOND_NAME"],
                        'PROC_IDS_MULTI' => $_POST["PROC_IDS_MULTI"],
                        // Добавьте другие свойства, если необходимо
                    ],
                ];

                $el = new CIBlockElement;
                $result = $el->Add($elementData);

                //Добавляю данные в форму и редирект на главную
                header('Location: /doctors/');
                exit();
            }

        }else if($action == 'new_proc'){

            if(!empty($_POST['form']) && \Bitrix\Iblock\Elements\ElementproceduresTable::add($_POST)){
                //Добавляю данные в форму и редирект на главную
                header('Location: /doctors/');
                exit();
            }
        }

    }else{
       //Выбран доктор
        $doctor_name = $path_parts[0];

        //Получаю данные по врачу
       $doctor_obj = \Bitrix\Iblock\Elements\ElementdoctorsTable::getList([
           'select' => [
               'NAME',
               'FIRST_NAME',
               'LAST_NAME',
               'SECOND_NAME',
               'PROC_IDS_MULTI.ELEMENT'
           ],
           'filter' => [
                   'NAME' => $doctor_name,
           ]
       ])->fetchObject();

       $procs = [];
       $doctor_person_info = $doctor_obj->getLastName()->getValue() ." "
                            .$doctor_obj->getFirstName()->getValue(). " "
                            .$doctor_obj->getSecondName()->getValue();

       foreach($doctor_obj->getProcIdsMulti()->getAll() as $prItem){

           $procs[] = $prItem->getElement()->getName();
        }

    }
}else{

    //Получаю список врачей
    $doctors_obj = \Bitrix\Iblock\Elements\ElementdoctorsTable::getList([
        'select' => [
            'PREVIEW_PICTURE',
            'NAME',
            'FIRST_NAME',
            'LAST_NAME',
            'SECOND_NAME',
            'PROC_IDS_MULTI.ELEMENT'
        ]
    ])->fetchCollection();

}



?>

<!--Верстка-->
<!--Шапка-->
<section class="doctors_section_h">

    <a href="/doctors/" class="doctors_btn_main_page">Главная</a>

    <div class="doctors_btn_gr">
        <a href="/doctors/new" class="doctors_btn">Добавить Врача</a>
        <a href="/doctors/new_proc" class="doctors_btn">Добавить Процедуру</a>
    </div>

</section>

<?php if(empty($doctor_name) && empty($action)): ?>
<!--Блок вывода без действий-->
<section class="doctors_section_b">

    <h1 class="doctors_h">Врачи</h1>
    <div class="doctors_list">
        <?php foreach($doctors_obj as $doctor){
            $previewPicturePath = \CFile::GetPath($doctor->get('PREVIEW_PICTURE'));
            ?>

        <a href="/doctors/<?= $doctor->getName() ?>">

            <img width="200px" height="200" src="<?php echo $previewPicturePath ?>">
            <div>
                <p>
                    <?=
                    $doctor->getLastName()->getValue() ." "
                    .$doctor->getFirstName()->getValue(). " "
                    .$doctor->getSecondName()->getValue()
                    ?>
                </p>
            </div>
        </a>

        <?php } ?>
    </div>

</section>
<?php endif; ?>

<!--Блок вывода формы добавления врача-->
<?php if($action == 'new'): ?>
<section class="doctors_section_f">
    <h1 class="doctors_h">Добавление нового врача</h1>
    <form id="form_new_doctor" method="POST" class="form_new_doctor">
        <label class="doctors_label" for="last_name">Фамилия</label>
        <input type="text" class="doctor_input" name="LAST_NAME" id="last_name">
        <label class="doctors_label" for="first_name">Имя</label>
        <input type="text" class="doctor_input" name="FIRST_NAME" id="first_name">
        <label class="doctors_label" for="second_name">Отчество</label>
        <input type="text" class="doctor_input" name="SECOND_NAME" id="second_name">
        <input type="hidden" name="form" value="new">
        <label class="doctors_label" for="procedure">Выбрать процедуру</label>

        <select id="procedure" name="PROC_IDS_MULTI[]" class="doctor_input_select" multiple>
            <?php foreach($procedures as $id => $name){?>
            <option value="<?php echo $id ?>"><?php echo $name ?></option>
            <?php } ?>
        </select>

        <input type="submit" class="doctor_input_btn" value="Создать">
    </form>
</section>
<?php endif; ?>


<!--Блок вывода формы добавления процедуры-->
<?php if($action == 'new_proc'): ?>
<section class="doctors_section_f">
    <h1 class="doctors_h">Добавление новой процедуры</h1>
    <form id="form_new_prc" method="POST" class="form_new_prc">
<!--    <form id="form_new_prc" action="/doctors/" method="POST" class="form_new_prc">-->
        <label class="doctors_label" for="name">Название процедуры</label>
        <input type="text" class="doctor_input" name="NAME" id="name">
        <input type="hidden" name="form" value="new_proc">
        <input type="submit" class="doctor_input_btn" value="Создать">
    </form>
</section>
<?php endif; ?>


<!--Блок страницы Доктора-->
<?php if(!empty($doctor_name)): ?>
<section class="doctors_section_l">
    <h2><?php echo $doctor_person_info ?></h2>
    <div class="doctor_description">
        <h3>Списко оказываемых услуг:</h3>
        <ul class="doctor_prc_list">
            <?php foreach($procs as $proc){ ?>
            <li><?php echo $proc ?></li>
            <?php } ?>
        </ul>
    </div>
</section>
<?php endif; ?>

