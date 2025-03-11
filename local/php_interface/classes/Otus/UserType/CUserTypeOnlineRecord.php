<?php

namespace Otus\UserType;

use CJSCore;

class CUserTypeOnlineRecord
{
    /**
     * Метод возвращает массив описания собственного типа свойств
     * @return array
     */
    public static function getUserTypeDescription()
    {
        return [
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'ONLINE_RECORD',
            'DESCRIPTION' => 'Онлайн-запись 1111',

            'GetPropertyFieldHtml' => [self::class, 'GetPropertyFieldHtml'], //метод отображения свойства в Админке

            'GetPublicViewHTML' => [self::class, 'GetPublicViewHTML'], // метод отображения значения свойства в Публичной части
            'GetPublicEditHTML' => [self::class, 'GetPropertyFieldHtml'], //метод отображения значения в форме редактирования
        ];


    }

    public static function GetPropertyFieldHtml($arProperty, $arValue, $strHTMLControlName)
    {

        $strResult = '<button id="onl-btn-9129961501" type="bitton">Записать</button>';

        return $strResult;


    }

    public static function GetPublicViewHTML($arProperty, $arValue, $strHTMLControlName)
    {

        $strResult = '';




        //ELEMENT_ID в $arValue и $arProperty (и вообще одинаковые)
        //IBLOCK_ID в $arValue и $arProperty (и вообще одинаковые)




        //Если ссылка на процедуры, который оказывает врач


        //1. Получаем список процедур (готово)
        //2. Добавляем процедуры в ссылку (готово)
        //3. Пишем JS и вещаем на ссылку событие по клику
        //4. Открывается pop-ap с выбором календаря и ФИО
        //5. Отправляем заполненные данные в обработчик по AJAX
        //6. обработчик проверяет, если все ок, то добавляет новый элемент в список
        //7. возвращает ответ, ID созданного Элемента в форму


        //Какие вижу вопросы/моменты
        //1. Можно ли вывести js-скрипты и css в отдельные файлы?
        //2. Можно ли подключать готовые компоненты?


        //1. Получаем список процедур

        $iblockVirClass =  \Bitrix\Iblock\Iblock::wakeUp($arValue['IBLOCK_ID'])->getEntityDataClass();

        $res = $iblockVirClass::getByPrimary($arValue['ELEMENT_ID'], [
            'select' => [
                'PROC_IDS_MULTI.ELEMENT'
            ],
        ])->fetchObject();

        foreach($res->getProcIdsMulti()->getAll() as $prItem){

            $inpid = 'btn_online_record' . rand(0, 99);
            $name_pr = $prItem->getElement()->getName();

            $strResult .= '<a href="#"  onclick="onAddOnlineRecord('. $inpid . ','. $prItem->getElement()->getId() .')"   id="' . $inpid. '">' . $name_pr .'</a><br>';

            //$strResult .= '<a href="#"  onclick="LazyBanner()"   id="' . $inpid. '">' . $prItem->getElement()->getName() .'</a><br>';

//            if($inpid && $name_pr){
//                $strResult .= '<a href="#"  onclick="kkkkkk('.$inpid.')" id="' . $inpid. '">' . $name_pr .'</a><br>';
//            }else{
//
//                $strResult .= '<a href="#"  onclick="kkkkkk("что то по")" id="' . $inpid. '">' . $name_pr .'</a><br>';
//            }


        }









        CJSCore::Init(['popup']);

        $strResult .= '
        <script type="text/javascript">


//           function kkkkkk(inpid){
//               
//              let ff =  BX(inpid);
//               console.log(ff);
//           }
//        
        function LazyBanner(name, date, procedure) {
            console.log("запуск");
            BX.ajax({
                url: "https://ct70506.tw1.ru/local/php_interface/classes/Otus/Handlers/hendlers_userfields_online_records.php", // файл на который идет запрос
                method: "POST", // метод запроса GET/POST
                // параметры передаваемый запросом
                data: {
                    NAME: name,
                    TIME: date,
                    PROC_ID: procedure,
                },
                // ответ сервера лежит в data
                onsuccess: function(data) {
                    //document.querySelector("#www").innerHTML = data
                }
            });
            
               console.log("Завершено");
        }




            
        function onAddOnlineRecord(inpid, pr_id){
            
            let content = BX.create("div", {
                children: [
                    BX.create("input", {
                        attrs: {
                            type: "text",
                            name: "name_online_record",
                            placeholder: "Ваше ФИО",
                            id: "input_name_online_record",
                        }
                    }),
                    BX.create("br"),
                    BX.create("br"),
                    BX.create("input", {
                        attrs: {
                            type: "datetime-local",
                            name: "date_online_record",
                            id: "input_date_online_record",
                        }
                    }),
                    BX.create("br")
                ]
              });
            
            
            var popup = BX.PopupWindowManager.create("popup-message", inpid, {
                content: content,
                //contentColor: "red",
                //borderRadius: "40px",
//                position: "top",
                width: 400,
                height: 400,
                zIndex: 100,
                closeIcon: {
                    //Объект со стилями для иконки закрытия, при null -иконки не будет
                    //opacity: 1
                },
                titleBar: "Записаться на прием",
                closeByEsc: true, // закрывать при нажатии на Esc
                darkMode: false, //окно будет светлым или темным
                autoHide: false, //закрытие при клике вне окна
                draggable: true, //можно двигать или нет
                resizable: true, //можно изменят размер
                min_height: 100, //минимальная высота окна
                min_width: 100, //минимальная ширина окна
                lightShadow: false, // использовать светлую тень у окна
                angle: false, // появится уголок
                overlay: {
                    // объект со стилями фона
                    backgroundColor: "black",
                    opacity: 400
                },
                buttons: [
                    new BX.PopupWindowButton({
                        text: "Добавить запись", //текст кнопки
                        id: "add_new_online_record", //идентификатор
                        //className: "Добавить запись", //доп. классы
                        events: {
                            click: function(){
                                
                                let nameValue = BX("input_name_online_record").value;
                                 let dateValue = BX("input_date_online_record").value;
                                
                                LazyBanner(nameValue, dateValue, pr_id);
                                popup.close();
                            }
                        }
                   }), //дольше можно еще одну кнопку добавить
                ],
                events: {
                    onPopupShow: function() {
                        //Событие при показа окна
                    },
                     onPopupClose: function() {
                        //Событие при закрытие окна
                    },
                }
            });
            
            popup.show();
        }
        
            
            
            
        
        </script>
        ';









        //Если кнопка
        //$strResult = '<button id="onl-btn-9129961501" type="bitton">Записать</button>';



        //Вешаю обрабочик события и pop-up






        return $strResult;

    }






















}