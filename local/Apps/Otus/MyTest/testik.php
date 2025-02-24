<?php
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



//Функция для обновления товарных позиций
function updateProductsByDeal($deal_id, $arPr, $method_4 = 'crm.deal.productrows.set', $hook = 'https://b24.apokdpo.ru/rest/5533/4bakunlcxgmsupt5/'){

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



//echo '<pre>';
//print_r($res);
//echo '</pre>';

















