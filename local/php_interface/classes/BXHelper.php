<?php

use CEventLog;

class BXHelper
{
    public static function addLog($message, $itemId = '', $moduleID = '', $type = '', $serverity = '')
    {

        CEventLog::Add([
            "SEVETITY" => $serverity,
            "AUDIT_TYPE_ID" => $type,
            "MODULE_ID" => $moduleID,
            "ITEM_ID" => $itemId,
            "DESCRIPTION" => $message,
        ]);

    }
}
