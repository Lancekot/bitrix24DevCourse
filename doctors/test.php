<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @global CMain $APPLICATION */
//use Models\Lists\ClientsTable as Clients;
use CJSCore;
$APPLICATION->SetTitle('Тест');









//
//$APPLICATION->IncludeComponent(
//    "otus:table.views",
//    'list',
//    [
//        "COMPONENT_TEMPLATE" => 'list',
//        'SHOW_CHECKBOXES' => "Y",
//        'NUM_PAGE'  => "1"
//    ],
//    false
//);



//$APPLICATION->IncludeComponent(
//    "otus:otus.grid",
//    '',
//    [
//        'SHOW_CHECKBOXES' => "Y",
//        'NUM_PAGE'  => "1"
//    ],
//    false
//);

//CJSCore::Init();



//CUtil::InitJSCore(array("timeman.check-control-open-work-day"));

?>


<div id="jjjjj">

</div>

<!--<input type="text" value="03.02.2015" name="date" onclick="BX.calendar({node: this, field: this, bTime: false});">-->



<script>

    let a = new BX.Timeman.CheckControlOpenWorkDay;
    console.log(a.getConsole());

    // BX.ready(function() {
    //
    //     BX.Timeman.CheckControlOpenWorkDay.getConsole();
    // })



    // BX.ready(function() {
    //
    //     let content = BX.create("div", {
    //         children: [
    //             BX.create("input", {
    //                 attrs: {
    //                     type: "text",
    //                     name: "name_online_record",
    //                     placeholder: "Ваше ФИО",
    //                     id: "input_name_online_record",
    //                 }
    //             }),
    //             BX.create("br"),
    //             BX.create("br"),
    //             BX.create("input", {
    //                 attrs: {
    //                     //type: "datetime-local",
    //                     type: "text",
    //                     name: "date_online_record",
    //                     id: "input_date_online_record",
    //                     placeholder: "Выберите дату",
    //                     value: "03.02.2015"
    //                 },
    //                 events: {
    //                     click: function(){
    //                         BX.calendar({
    //                             node: this,
    //                             field: this,
    //                             bTime: false
    //                         });
    //                     }
    //                 }
    //             }),
    //             BX.create("br")
    //         ]
    //     });
    //
    //     BX("jjjjj").innerHTML = content.outerHTML;
    //
    //
    //
    //
    //
    //
    //     // Добавляем обработчик события на кнопку
    //     BX.bind(BX('input_name_online_record'), 'bxchange', function() {
    //         // Получаем значения из полей input
    //         let nameValue = BX('input_name_online_record').value;
    //         // Выводим значения в консоль или используем их по назначению
    //         console.log("Имя: " + nameValue);
    //
    //     });
    //
    //     // Добавляем обработчик события на кнопку
    //     BX.bind(BX('input_name_online_record'), 'bxchange', function() {
    //         // Получаем значения из полей input
    //         let dateValue = BX('input_date_online_record').value;
    //         // Выводим значения в консоль или используем их по назначению
    //         console.log("Дата: " + dateValue);
    //
    //     });
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    // });


</script>







<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>

































