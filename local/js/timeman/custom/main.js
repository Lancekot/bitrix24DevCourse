BX.addCustomEvent('onTimeManWindowOpen', function(){


    let user_id;


    let element = BX('timeman_main');
    console.log(element);

    let width = 400;
    let windowWidth = window.innerWidth;
    let a = document.createElement('div');
    let popup = BX.PopupWindowManager.create('timeman-notify', a, {
        content: "Если требуется начать рабочий день, то нажмите соответсвующую кнопку",
        autoHide: true,
        width: width,
        offsetLeft: (windowWidth - width)/2,
        offsetTop: 50,
        closeIcon: {
            right: "20px", top: "10px"
        },
        closeByEsc: true,
        overlay: {
            backgroundColor: 'black', opacity: '80'
        },
        lightShadow: true,
        darkMode: false,
        events: {
            onPopupShow: function(){
                //console.log("Helloy World Show")
            },
            onPopupClose: function() {

                element.style.display = 'none';
                element.className = 'popup-window';
            }
        },
        buttons: [
            new BX.PopupWindowButton({
                text: "Начать рабочий день",
                className: "popup-window-button-accept",
                events: {
                    click: function() {

                        BX.ajax({
                            url: 'https://ct70506.tw1.ru/local/php_interface/classes/Otus/Handlers/hendlers_work_day.php',
                            method: 'POST',
                            data: {
                                'STATUS_DAY': 'CLOSE'
                            },
                            // ответ сервера лежит в data
                            onsuccess: function(data) {
                                //document.querySelector("#www").innerHTML = data
                            }

                        });

                        console.log("WorkDay Begin")

                        this.popupWindow.close();
                    }
                }
            }),

            new BX.PopupWindowButton({
                text: "Закрыть раб день",
                className: 'webform-button-link-cancel',
                events: {

                    click: function() {
                        BX.ajax({
                            url: 'https://ct70506.tw1.ru/local/php_interface/classes/Otus/Handlers/hendlers_work_day.php',
                            method: 'POST',
                            data: {
                                'STATUS_DAY': 'OPEN'
                            },
                            // ответ сервера лежит в data
                            onsuccess: function(data) {
                                //document.querySelector("#www").innerHTML = data
                            }
                        });

                        console.log("WorkDay Close");
                        this.popupWindow.close();


                    }
                }
            }),
        ]
    })

    popup.show();

})



// BX.addCustomEvent('onTaskTimerChange', function(e){
//
//
//     console.log(e);
//
//
//
// })