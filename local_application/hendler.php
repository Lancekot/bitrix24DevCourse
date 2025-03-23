<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/local_application/CRest/crest.php');


$activity_id = $_POST['data']['FIELDS']['ID'];

if($activity_id){

    $method = 'crm.activity.get';

    $params = [
        'id' => $activity_id,
    ];


    $res = CRest::call($method, $params);

    $deal_id = $res['result']['OWNER_ID'];
    $type_crm_entyty = $res['result']['OWNER_TYPE_ID'];

}

if($type_crm_entyty == 2 && !empty($deal_id)){

    //Получаем ID контакта по ID сделки
    $method = 'crm.deal.get';

    $params = [
        'id' => $deal_id,
    ];

    $res = CRest::call($method, $params);

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

        $res = CRest::call($method, $params);

    }

}