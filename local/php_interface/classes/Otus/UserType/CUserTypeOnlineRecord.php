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


    public static function getDataValues($id) {

        \Bitrix\Main\Loader::includeModule('iblock');

        $data = \Bitrix\Iblock\Elements\ElementdoctorsTable::getList([
            'filter' => ['ID' => $id],
            'select' => ['PROC_IDS_MULTI.ELEMENT'],
        ])->fetchObject();

        $valuesElement = [];
        foreach ($data->getProcIdsMulti()->getAll() as $el){
            $valuesElement[$el->getElement()->getId()] = $el->getElement()->getName();
        }

        return $valuesElement;
    }


    public static function GetPublicViewHTML($arProperty, $arValue, $strHTMLControlName)
    {

        $strResult = '';
        \CJSCore::Init(['popup']);
        $inpid = 'rec_id_' . rand(0, 99);

        $valuesElement = self::getDataValues($arProperty['ELEMENT_ID']);
        if (empty($valuesElement))
        {
            return 'У врача нет процедур';
        }

        $count = 0;

        foreach($valuesElement as $id => $el){

            $strResult .= '<a data-pr-id="'.$id.'"  style="cursor:pointer;" id="elem_'. $count . '_' . $inpid. '">' . $el .'</a><br>';
            $count++;

        }


        $strResult .= '
        <script type="text/javascript">

            BX.ready(function () {
                for(let i = 0; i < '.$count.'; i++)
                    {
                        BX.bind(BX("elem_"+i+"_'.$inpid.'"), "click", onAddOnlineRecord);  
                    }  
            });

            
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

        function onAddOnlineRecord(e){
            
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
            
            var popup = BX.PopupWindowManager.create("popup-message", e.targent, {
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
                                  let pr_id = e.target.getAttribute("data-pr-id");
                                  
                                  console.log("Что пришло сюда");
                                  console.log(pr_id);
                                
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
        
            //rjytw
            
            
        
        </script>
        ';




        return $strResult;

    }





}