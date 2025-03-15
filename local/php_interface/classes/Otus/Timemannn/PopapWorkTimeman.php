<?php

namespace Otus\Timemannn;


use Bitrix\Main\Loader;
use Bitrix\Main;


class PopapWorkTimeman
{

    public static $path;

    public static function init()
    {
        self::$path = $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/classes/Otus/Timemannn/log.txt';
    }

    //Метод для открытия рабочего дня
    public static function openWorkDay($userId)
    {


        if (\Bitrix\Main\Loader::includeModule('timeman')) {

            self::init();

            $TimemanUser = new \CTimeManUser($userId);

            // Проверяем, открыт ли рабочий день
            if (!$TimemanUser->isDayOpen()) {
                addFileLog("Рабочий день закрыт. Открываем рабочий день", self::$path);
                echo "Рабочий день закрыт. Открываем рабочий день...<br>";

                // Открываем рабочий день
                $result = $TimemanUser->openDay();

                if ($result) {
                    echo "Рабочий день успешно открыт.<br>";
                    addFileLog("Рабочий день успешно открыт", self::$path);
                } else {
                    // Получаем последнюю ошибку
                    global $APPLICATION;
                    if ($exception = $APPLICATION->GetException()) {
                        echo "Ошибка: " . $exception->GetString() . "<br>";
                        addFileLog("Ошибка: " . $exception->GetString(), self::$path);
                    } else {
                        echo "Неизвестная ошибка при открытии рабочего дня.<br>";
                        addFileLog("Неизвестная ошибка при открытии рабочего дня", self::$path);
                    }
                }
            } else {
                echo "Рабочий день уже открыт.<br>";
                addFileLog("Рабочий день уже открыт", self::$path);
            }
        } else {
            echo "Модуль timeman не подключен.<br>";
            addFileLog("Модуль timeman не подключен", self::$path);
        }
    }

    //Метод для открытия закрытия дня
    public static function closeWorkDay($userId)
    {

        if (\Bitrix\Main\Loader::includeModule('timeman')) {

            self::init();

            $TimemanUser = new \CTimeManUser($userId);

            // Проверяем, открыт ли рабочий день
            if ($TimemanUser->isDayOpen()) {
                addFileLog("Рабочий день открыт. Закрываем рабочий день", self::$path);
                echo "Рабочий день открыт. Закроем рабочий день...<br>";

                // Закрываем рабочий день
                $result = $TimemanUser->closeDay();

                if ($result) {
                    echo "Рабочий день успешно закрыт.<br>";
                    addFileLog("Рабочий день успешно закрыт", self::$path);
                } else {
                    // Получаем последнюю ошибку
                    global $APPLICATION;
                    if ($exception = $APPLICATION->GetException()) {
                        echo "Ошибка: " . $exception->GetString() . "<br>";
                        addFileLog("Ошибка: " . $exception->GetString(), self::$path);
                    } else {
                        echo "Неизвестная ошибка при закрытии рабочего дня.<br>";
                        addFileLog("Неизвестная ошибка при закрытии рабочего дня", self::$path);
                    }
                }
            } else {
                echo "Рабочий день уже открыт.<br>";
                addFileLog("Рабочий день уже закрыт", self::$path);
            }
        } else {
            echo "Модуль timeman не подключен.<br>";
            addFileLog("Модуль timeman не подключен", self::$path);
        }
    }

}