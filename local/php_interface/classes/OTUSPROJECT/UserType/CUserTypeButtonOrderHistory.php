<?php
namespace OTUSPROJECT\UserType;

use CJSCore;

class CUserTypeButtonOrderHistory
{
    /**
     * Метод возвращает массив описания собственного типа свойств
     * @return array
     */
    public static function getUserTypeDescription()
    {
        return [
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'BTN_HISTORY',
            'DESCRIPTION' => 'История обращений',

            'GetPropertyFieldHtml' => [self::class, 'GetPropertyFieldHtml'], //метод отображения свойства в Админке
            'GetPublicViewHTML' => [self::class, 'GetPublicViewHTML'], // метод отображения значения свойства в Публичной части
            'GetPublicEditHTML' => [self::class, 'GetPublicEditHTML'], //метод отображения значения в форме редактирования
        ];

    }

    public static function getDataValues($id) {

        \Bitrix\Main\Loader::includeModule('iblock');


        $data = \Bitrix\Iblock\Elements\ElementgarageTable::getList([
            'filter' => ['ID' => $id],
            'select' => ['CLIENT'],
        ])->fetchObject();

        $contactId = $data->get('CLIENT')->getValue();


        if($contactId){
            return $contactId;
        }

    }

    public static function GetPropertyFieldHtml($arProperty, $arValue, $strHTMLControlName)
    {

        $strResult = '<button id="history-btn-123456" type="button">Просмотр истории</button>';

        return $strResult;

    }


    public static function GetPublicViewHTML($arProperty, $arValue, $strHTMLControlName)
    {


        $inpid =  'btn_id_' . rand(0, 99);
        $contactId = self::getDataValues($arProperty['ELEMENT_ID']);


        $strResult = '';
        $strResult .= '<button data-client-id='.$contactId.'  id="'.$inpid.'" type="button">Посмотреть</button>';


        $strResult .= '
            <script type="text/javascript">
                
            BX.ready(function () {
                        BX.bind(BX("'.$inpid.'"), "click", ViewHistory);  
            });
            
            
            function LazyBanner(contactId) 
            {
                let result;
                console.log("запуск");
                return new Promise((resolve, reject) =>{
                    
                    BX.ajax({
                        url: "https://ct70506.tw1.ru/local/php_interface/classes/OTUSPROJECT/Handlers/UserTypeAsaxHistoryOffer.php", // файл на который идет запрос
                        method: "POST", // метод запроса GET/POST
                        // параметры передаваемый запросом
                        data: {
                            CONTACT_ID: contactId,
                        },
                        dataType: "json",
                        // ответ сервера лежит в data
                        onsuccess: function(data) {
                            if (data.status === "success") {
                                console.log("Ответ сервера: ", data.message);
                                console.log(data.fields);
                                 resolve(data.fields);
                                
                                // Обработка успешного ответа
                            } else{
                                console.log("Ошибка: ", data.message);
                                reject(data.message);
                            }
                            //document.querySelector("#www").innerHTML = data
                        },
                         onfailure: function() {
                            console.log("Ошибка при выполнении запроса");
                            reject("Ошибка при выполнении запроса");
                         }
                    });
                });
            }
            
            
            
            function ViewHistory(e)
            {
                
                  let contactId = e.target.getAttribute("data-client-id");        
                  console.log("Что пришло сюда");
                  console.log(contactId);
                  
                  let result;
                  LazyBanner(contactId)
                        .then(arrDeals => {
                            console.log("Аякс");
                            console.log(arrDeals);
                            
                            popopop(arrDeals, e);
                                       
                            
                            // Здесь вы можете обработать arrDeals
                        })
                        .catch(error => {
                            console.log("Произошла ошибка: ", error);
                        });
                

                  
                  
                  //Здесь делаю верстку для contenta (можно добавить какой-нибудь компонент
                  
                  

                
            }
            
            
           
            function getHtml(arrDeals)
            {
                   // Начинаем создание таблицы
                    let html = "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">";
                        html += "<thead>";
                        html += "<tr>";
                        html += "<th>ID</th>";
                        html += "<th>Название</th>";
                        html += "<th>Ответственный</th>";
                        html += "<th>Стадия</th>";                   
                        html += "</tr>";
                        html += "</thead>";
                        html += "<tbody>";
                        
                arrDeals.forEach((arrDeal) => {
                  
                        html += "<tr>";
                        html += `<td>${arrDeal.ID}</td>`;
                        html += `<td>${arrDeal.TITLE}</td>`;
                        html += `<td>${arrDeal.ASSIGNED_BY_ID}</td>`;
                        html += `<td>${arrDeal.STAGE_ID}</td>`;
                        html += "</tr>";
        
                })
                
 
                
            }
            
                function getHtml2(arrDeals) {
                    // Создаем таблицу
                    const table = BX.create("table", {
                        attrs: { border: "1", cellpadding: "5", cellspacing: "0" },
                        children: [
                            // Создаем заголовок таблицы
                            BX.create("thead", {
                                children: [
                                    BX.create("tr", {
                                        children: [
                                            BX.create("th", { text: "ID" }),
                                            BX.create("th", { text: "Название" }),
                                            BX.create("th", { text: "Ответственный" }),
                                            BX.create("th", { text: "Стадия" })
                                        ]
                                    })
                                ]
                            }),
                            // Создаем тело таблицы
                            BX.create("tbody", {
                                children: arrDeals.map(arrDeal => {
                                    return BX.create("tr", {
                                        children: [
                                            BX.create("td", { text: arrDeal.ID }),
                                            BX.create("td", { text: arrDeal.TITLE }),
                                            BX.create("td", { text: arrDeal.ASSIGNED_BY_ID }),
                                            BX.create("td", { text: arrDeal.STAGE_ID })
                                        ]
                                    });
                                })
                            })
                        ]
                    });
                
                    return table;
            }
            
            function popopop(arrDeals, e)
            {
               
                let table = getHtml2(arrDeals);
                
                

                 var popup = BX.PopupWindowManager.create("popup-message", e.targent, {
                content: table,
                //contentColor: "red",
                //borderRadius: "40px",
//                position: "top",
                width: 500,
                height: 500,
                zIndex: 100,
                closeIcon: {
                    //Объект со стилями для иконки закрытия, при null -иконки не будет
                    //opacity: 1
                },
                titleBar: "История обращений по авто",
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
                        text: "Закрыть", //текст кнопки
                        id: "btn_history_popup_close", //идентификатор
                        //className: "Добавить запись", //доп. классы
                        events: {
                            click: function(){
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




















        return $strResult;

    }

    public static function GetPublicEditHTML($arProperty, $arValue, $strHTMLControlName)
    {
        $strResult = '';
        $strResult .= '<button data-client-id=8 style="cursor:pointer; id="history-btn-123456" type="button">Посмотреть</button>';
        return $strResult;

    }


















}