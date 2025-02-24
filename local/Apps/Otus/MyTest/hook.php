<?php



//function sendB24($url, array $fields = null)
//{
//    if($fields){
//
//        $postData = json_encode($fields, JSON_UNESCAPED_UNICODE);
//    }
//    $reqHeader = ['Content-Type: application/json'];
//    //Запускаю сеанс передачи
//    $curl = curl_init();
//    curl_setopt($curl, CURLOPT_URL, $url);
//    curl_setopt($curl, CURLOPT_HTTPHEADER, $reqHeader);
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//    if($fields){
//        curl_setopt($curl, CURLOPT_POST, 1);
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
//    }
//    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
//    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
//
//    //Получаю ответ
//    $response = curl_exec($curl);
//    //Завершаю сеанс
//    curl_close($curl);
//    //Возвращаю результат функции
//    //addToLog('Ответ от б24: '.$response);
//    //$response = $postData;
//    return json_decode($response);
//}
//
//function getFileArrayToSent($arrFiles, $site = 'https://ct70506.tw1.ru'){
//
//    $file_els = [];
//
//    foreach($arrFiles as $fileLinkEl){
//
//        $new_url_file = $site . str_replace(' ', '%20', $fileLinkEl);
//        $erl_el_arr = explode('/', $fileLinkEl);
//        $name = end($erl_el_arr);
//
//        $el = [
//            "fileData" => [
//                $name,
//                //base64_encode(file_get_contents($new_url_file))
//                $new_url_file
//            ]
//        ];
//
//        $file_els[] = $el;
//
//    }
//
//    return $file_els;
//
//}
//
////Добавляю в сделку товары
//
//
//$hook = 'https://b24.apokdpo.ru/rest/5533/4bakunlcxgmsupt5/';
//
//$method = 'crm.deal.update';
//
//$deal_id = 172347;
//
//
//$url_doc_1 = 'https://ct70506.tw1.ru/upload/main/378/84jglssp2l75o68d2w0xgbc2g7bjs109/Скрин простой 22.png';
//$url_doc_2 = 'https://ct70506.tw1.ru/upload/main/a33/i8p48e5bx3phi9ta82koiyyh3buxc3qp/Договор от 26.03.docx';
//$url_doc_3 = 'https://ct70506.tw1.ru/upload/main/d2f/h21z1e4qo5rrty7q3vf2bjj7tfvvcgsy/Договор от 25.03.pdf';
//$url_doc_4 = 'https://ct70506.tw1.ru/upload/main/7af/9to5s9bjrb491o84zx9mdqoo619ln0m3/СКрин22.png';
//
//
//
//$arrFile = [
//    '/upload/main/378/84jglssp2l75o68d2w0xgbc2g7bjs109/Скрин простой 22.png',
//    '/upload/main/a33/i8p48e5bx3phi9ta82koiyyh3buxc3qp/Договор от 26.03.docx',
//    '/upload/main/d2f/h21z1e4qo5rrty7q3vf2bjj7tfvvcgsy/Договор от 25.03.pdf',
//];
//
//
//$res = getFileArrayToSent($arrFile);
//
//echo "<pre>";
//print_r($res);
//echo "</pre>";



//$fields = [
//    "UF_CRM_1605441630001" =>
//];












//$sendData = [
//    "id" => $deal_id,
//    "fields" => [
//        "UF_CRM_1605441630001" => [ //Документы
//            [
//                "fileData" => [
//                    'Скрин простой 22.png',
//                    base64_encode(file_get_contents($sssss))
//                ]
//            ],
//            [
//                "fileData" => [
//                    'Договор 1.docx',
//
//                    base64_encode(file_get_contents($url_doc_2))
//                ]
//            ],
//            [
//                "fileData" => [
//                    'Договор 1.pdf',
//                    base64_encode(file_get_contents($url_doc_3))
//                ]
////            ],
//        ],
//        "UF_CRM_1623956010" => [ //Пакет документов для методиста
//            [
//                "fileData" => [
//                    'Сканн 1.png',
//                    base64_encode(file_get_contents($url_doc_1))
//                ]
//            ],
//            [
//                "fileData" => [
//                    'Договор 1.docx',
//
//                    base64_encode(file_get_contents($url_doc_2))
//                ]
//            ],
//            [
//                "fileData" => [
//                    'Договор 1.pdf',
//                    base64_encode(file_get_contents($url_doc_3))
//                ]
//            ],
//        ],
    ]
];



//$url = $hook . $method;
//
//
//$res = sendB24($url, $sendData);
//
//
//echo "<pre>";
//print_r($res);
//echo "</pre>";
////
////


















//$url = 'https://b24.apokdpo.ru/local/markin/markin.change.deals.portals/hendler.php';
//
//$params = [
//    'idd' => 434343434,
//    'name' => 'Clever'
//];
//
//$res = sendB24($url, $params);
//





//$url = 'https://b24.apokdpo.ru/rest/5533/4bakunlcxgmsupt5/lists.element.add';
//
//$fields = [
//    'IBLOCK_TYPE_ID' => 'lists',
//    'IBLOCK_ID' => 134,
//    'ELEMENT_CODE'  => 'change_eco',
//    'FIELDS' => [
//        'PROPERTY_520' => '89348934893', //телефон
//        'PROPERTY_521' => 'Вася', //имя клиента
//        'PROPERTY_522' => 939438, // ID сделки ЭКО
//        'PROPERTY_523' => 'Тестовая', //Название товара
//        'PROPERTY_524' => 10, //кол-во товара
//        'PROPERTY_525' => 100.00, // цена товара
//        'NAME' => 'new_pay'
//     ]
//];
//
//$res = sendB24($url, $fields);


