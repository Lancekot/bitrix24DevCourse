<?php

define('DEBUG_FILE_NAME', $_SERVER['DOCUMENT_ROOT'].'/logs/' . date("Y-m-d") . '.log');

include_once __DIR__ . '/../Apps/Otus/autoload.php';

//require_once __DIR__ . '/classes/Otus/BXHelper.php';

if(file_exists(__DIR__.'/classes/autoload.php')){
    require_once __DIR__. '/classes/autoload.php';
}

//Константы
require dirname(__FILE__) . '/constants.php';

//Обработка событий
require dirname(__FILE__) . '/event_handler.php';


//Общий набор методов
function pr($var, $type = false){
    echo '<pre style="font-size:10px; border:1px solid #000; text-align: left">';
    if($type){
        var_dump($var);
    }else{
        print_r($var);
    }
    echo '</pre>';
}

function addFileLog($text, $path){

    file_put_contents($path, $text . PHP_EOL, FILE_APPEND);
}


//Методы Rest API для работы с CRM
function sendB24($url, array $fields = null)
{
    if($fields){

        $postData = json_encode($fields, JSON_UNESCAPED_UNICODE);
    }
    $reqHeader = ['Content-Type: application/json'];
    //Запускаю сеанс передачи
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $reqHeader);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if($fields){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    }
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    //Получаю ответ
    $response = curl_exec($curl);
    //Завершаю сеанс
    curl_close($curl);
    //Возвращаю результат функции
    //addToLog('Ответ от б24: '.$response);
    //$response = $postData;
    return json_decode($response);
}

//Проверка номера на дубль
function validateAndFormatPhoneNumber($phoneNumber) {
    // Удаляем все символы, кроме цифр
    $digitsOnly = preg_replace('/\D/', '', $phoneNumber);

    // Проверяем длину номера и корректируем его
    if (strlen($digitsOnly) === 11 && $digitsOnly[0] === '8') {
        // Если номер начинается с 8, заменяем на 7
        $digitsOnly[0] = '7';
    } elseif (strlen($digitsOnly) === 10) {
        // Если номер состоит из 10 цифр, добавляем 7 в начало
        $digitsOnly = '7' . $digitsOnly;
    }

    // Проверяем, что номер теперь состоит из 11 цифр и начинается с 7
    if (strlen($digitsOnly) === 11 && $digitsOnly[0] === '7') {
        return $digitsOnly;
    } else {
        return false;
    }
}

//Функция для создания сделки с товарами
function addNewDeal($phone, $contactName, $deal_name, $deal_id, $manager_name, $arPr, $hook){

    $method_1 = 'crm.duplicate.findbycomm';
    $method_2 = 'crm.contact.add';
    $method_3 = 'crm.deal.add';
    $method_4 = 'crm.deal.productrows.set';
    $method_5 = 'crm.deal.update';

    //Проверяю дубль по телефону
    $phone = validateAndFormatPhoneNumber($phone);
    $url = $hook . $method_1;
    $params = [
        'type' => 'PHONE',
        'values' => [$phone],
        'entity_type' => 'CONTACT'
    ];
    $res = sendB24($url, $params);
    $contact_id =$res->result->CONTACT[0];

    //Если дубль не нашел, добавляю новый контакт
    if(!$contact_id){
        //Нужно создать контакт
        $fieldContact = [
            'FIELDS' => [
                'NAME' => $contactName,
                'HAS_PHONE' => 'Y',
                'ASSIGNED_BY_ID' => 1467,
                'PHONE' => [
                    [
                        'VALUE' => '+' . $phone,
                        'VALUE_TYPE' => 'WORK',
                    ],
                ]
            ]
        ];

        $url = $hook . $method_2;
        $res = sendB24($url, $fieldContact);
        $contact_id = $res->result;
    }

    //Создаю новую сделку
    $fieldDeal = [
        'FIELDS' => [
            'TITLE' => $deal_name,
            'CATEGORY_ID' => 24,
            'ASSIGNED_BY_ID' => 5533,
            'UF_CRM_1737909870330' => $deal_id,
            'IS_MANUAL_OPPORTUNITY' => 'N',
            'CONTACT_ID' => $contact_id,
            'UF_CRM_1738088133829' => $manager_name
        ]
    ];
    $url = $hook . $method_3;
    $res = sendB24($url, $fieldDeal);
    $deal_id = $res->result;

    //Добавляю товарные позиции в сделку
    $arProd = array_reverse($arPr);
    $rows = [];
    foreach($arProd as $pr){
        $pr_el_data = explode("/", $pr);

        $pr_inf  = [
            'PRODUCT_NAME' => $pr_el_data[0],
            'PRICE' => $pr_el_data[2],
            'QUANTITY' => $pr_el_data[1],
            'TAX_RATE' => 0,
            'MEASURE_CODE' => 796,
            'MEASURE_NAME' => "шт",
            'SORT' => 10,
        ];
        $rows[] = $pr_inf;
    }
    $fieldPr = [
        'id' => $deal_id,
        'rows' => $rows
    ];
    $url = $hook . $method_4;
    sendB24($url, $fieldPr);



    //Помеять статус сделки после отправки товара
    $fields_deal = [
        'ID' => $deal_id,
        'FIELDS' => [
            'STAGE_ID' => 'C24:PREPARATION'
        ]
    ];

    $url = $hook . $method_5;
    sendB24($url, $fields_deal);

    return $deal_id;

}


//Функция для обновления товарных позиций
function updateProductsByDeal($deal_id, $arPr, $method_4 = 'crm.deal.productrows.set', $hook){

    $rows = [];
    $arProd = array_reverse($arPr);

    foreach($arProd as $pr){

        $pr_el_data = explode("/", $pr);

        $pr_inf  = [
            'PRODUCT_NAME' => $pr_el_data[0],
            'PRICE' => $pr_el_data[2],
            'QUANTITY' => $pr_el_data[1],
            'TAX_RATE' => 0,
            'MEASURE_CODE' => 796,
            'MEASURE_NAME' => "шт",
            'SORT' => 10,
        ];
        $rows[] = $pr_inf;
    }

    $fieldPr = [
        'id' => $deal_id,
        'rows' => $rows
    ];
    $url = $hook . $method_4;
    sendB24($url, $fieldPr);

    //Обновляем сделку
    $fields_deal = [
        'ID' => $deal_id,
        'FIELDS' => [
            //'STAGE_ID' => 'C24:PREPARATION'
        ]
    ];

    $method_5 = 'crm.deal.update';
    $url = $hook . $method_5;
    sendB24($url, $fields_deal);

}

//Функция для формирования массива файлов для отправки
function getFileArrayToSent($arrFiles, $site = 'https://ct70506.tw1.ru'){

    $file_els = [];

    foreach($arrFiles as $fileLinkEl){

        $new_url_file = $site . str_replace(' ', '%20', $fileLinkEl);
        $erl_el_arr = explode('/', $fileLinkEl);
        $name = end($erl_el_arr);
        $data = file_get_contents($new_url_file);

        $el = [
            "fileData" => [
                $name,
                $new_url_file,
//                base64_encode($data)
            ]
        ];

        $file_els[] = $el;

    }

    return $file_els;

}

//Метод для обновления сделки
function updateDealByEco($deal_id, $fieldsArray, $typeUpdate, $hook = '', $method = 'crm.deal.update'){

    if($typeUpdate == 're_work_complete'){
        //Только параметр стадии
        $fields['STAGE_ID'] = 'C24:UC_MGI94Z';

    }elseif ($typeUpdate == 'win'){

        //Только параметр стадии
        $fields['STAGE_ID'] = 'C24:WON';
    }


    //Формирую Массив еще каких то полей




    //Формирую данные для файлов
    $path = $_SERVER['DOCUMENT_ROOT'] . '/local/Apps/Otus/MyTest/log.txt';
    addFileLog(json_encode($fieldsArray), $path);



//    $file1 = explode(',', $fieldsArray['UF_CRM_1738087906883']);
//    $file2 = explode(',', $fieldsArray['UF_CRM_1738136225']);

    $file1 = $fieldsArray['UF_CRM_1738087906883'];
    $file2 = $fieldsArray['UF_CRM_1738136225'];



    $file_document = getFileArrayToSent($file1);

//    addFileLog(json_encode($file_document), $path);




    $file_by_methodist = getFileArrayToSent($file2);

//    addFileLog(json_encode($file_by_methodist), $path);


    $fields["UF_CRM_1605441630001"] = $file_document; //Докуенты
    $fields["UF_CRM_1623956010"] = $file_by_methodist; //Файлы для методиста


    $resultArray = [
        'ID' => $deal_id,
        'fields' => $fields,
    ];



    $url = $hook . $method;
    $res = sendB24($url, $resultArray);

    addFileLog(json_encode($res), $path);

    return $res;

}


//Агент
function updateProductRemainAgent()
{
    \OTUSPROJECT\Handlers\ManagerRemainProducts::updateProductRemain();
    return "updateProductRemainAgent();";
}

















//Bitrix\Main\UI\Extension::load('tasks.color-my-task');

//Bitrix\Main\UI\Extension::load('timeman.check-control-open-work-day');

Bitrix\Main\UI\Extension::load('timeman.custom');


//UF_CRM_1738088133829 - менеджер с портала ЭКО
//UF_CRM_1605441630001 - документы
//UF_CRM_1623956010 - пакет документов для методиста



// if(file_exists($_SERVER['DOCUMENT_ROOT']."/local/php_interface/include/markin.handler.call.php")){
// 	require_once $_SERVER['DOCUMENT_ROOT']."/local/php_interface/include/markin.handler.call.php";
// 	AddEventHandler('crm', 'OnAfterCrmCompanyAdd', 'checkCompanySegment');
// }




//AddEventHandler('crm', 'OnAfterCrmCompanyAdd', 'checkCompanySegment');


//AddEventHandler('crm', 'OnBeforeCrmCompanyAdd', 'checkCompanySegment');
//
//function checkCompanySegment($company_arr)
//{
//
//    if(!$company_arr['UF_CRM_1741764828824'] && $company_arr['ID'] == 0 && $company_arr['ASSIGNED_BY_ID'] == 1){
//
//        $company_arr['RESULT_MESSAGE']['MESSAGE'] = "Сегмент 1";
//
//        global $APPLICATION;
//        $APPLICATION->ThrowException('Сегмент 1');
//
//        return false;
//    }
//
//    return true;
//
//}




//
//function addNotifc($mes, $user_id = 1)
//{
//
//
//
//
////    if (IsModuleInstalled("im") && CModule::IncludeModule("im"))
////    {
////        $arMessageFields = array(
////            "TO_USER_ID" => $user_id,
////            "FROM_USER_ID" => 0,
////            "NOTIFY_TYPE" => IM_NOTIFY_SYSTEM,
////            "NOTIFY_MODULE" => "im",
////            "NOTIFY_TAG" => "IM_CONFIG_NOTICE",
////            "NOTIFY_MESSAGE" => $mes,
////        );
////        CIMNotify::Add($arMessageFields);
////    }
//
//
//
//}

