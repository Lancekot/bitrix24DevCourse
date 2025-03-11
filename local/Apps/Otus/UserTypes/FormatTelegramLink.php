<?php

namespace UserTypes;

use Bitrix\Main\UserField\Types\StringFormattedType;
use CUserTypeManager;

class FormatTelegramLink extends StringFormattedType
{
    public const
        USER_TYPE_ID = 'telegram_string_formatted_link',
        RENDER_COMPONENT = 'otus:main.field.stringformatted'; //компонент который обрабатывает ссылку на телеграм


//getDescription
    public static function getDescription(): array {
        return [
            'DESCRIPTION' => 'Телеграм ссылка 1',
            'BASE_TYPE' => CUserTypeManager::BASE_TYPE_STRING,
        ];
    }

    public static function getDbColumnType(): string {
        return 'text';
    }


    public static function prepareSettings(array $userField): array
    {
        $size = (int)$userField['SETTINGS']['SIZE'];
        $rows = (int)$userField['SETTINGS']['ROWS'];
        $min = (int)$userField['SETTINGS']['MIN_LENGTH'];
        $max = (int)$userField['SETTINGS']['MAX_LENGTH'];

        return [
            //'SIZE' => ($size <= 1 ? 20 : ($size > 255 ? 225 : $size)),
            //'ROWS' => ($rows <= 1 ? 1 : ($rows > 50 ? 50 : $rows)),
            //'REGEXP' => $userField['SETTINGS']['REGEXP'] ?? null,
            'MIN_LENGTH' => $min,
            'MAX_LENGTH' => $max,
            'DEFAULT_VALUE' => $userField['SETTINGS']['DEFAULT_VALUE'] ?? null,
            'PATTERN' => $userField['SETTINGS']['PATTERN'] ?? null,
        ];
    }









}
