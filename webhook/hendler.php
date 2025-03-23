<?php
//require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';

file_put_contents('log.txt', json_encode($_POST).PHP_EOL, FILE_APPEND);

function sendB244($method, $fields = null)
{
    $url = 'https://ct70506.tw1.ru/rest/1/o8xd5lfmt3dwdvqe/' . $method;

    //$url = 'https://omniko.bitrix24.ru/rest/1/5nspkfj7nkzfm946/' . $method;

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
    return json_decode($response, true);

}



$activity_id = $_POST['data']['FIELDS']['ID'];

if($activity_id){

    $method = 'crm.activity.get';

    $params = [
        'id' => $activity_id,
    ];


    $res = sendB244($method, $params);

    $deal_id = $res['result']['OWNER_ID'];
    $type_crm_entyty = $res['result']['OWNER_TYPE_ID'];

}

if($type_crm_entyty == 2 && !empty($deal_id)){

    //Получаем ID контакта по ID сделки
    $method = 'crm.deal.get';

    $params = [
        'id' => $deal_id,
    ];

    $res = sendB244($method, $params);

    $contact_id = $res['result']['CONTACT_ID'];

    if($contact_id > 0){

        $method = 'crm.contact.update';

        $params = [
            'ID' => $contact_id,
            'FIELDS' => [
                'UF_CRM_1742627939564' => date("Y-m-d H:i:s"),
                'NAME' => 'Бобик',
            ]
        ];

        $res = sendB244($method, $params);

    }

}
//23.03.2025 20:33:39