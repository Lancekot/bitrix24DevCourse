<?php

namespace Otus\Homework\Crm;

use Bitrix\Main\Event;
use Bitrix\Main\EventResult;


class Handlers
{
    public static function updateTabs(Event $event): EventResult
    {

        $tabs = $event->getParameter('tabs');
        $entityTypeId = $event->getParameter('entityTypeID');
        if ($entityTypeId != \CCrmOwnerType::Deal) {
            return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [
                'tabs' => $tabs,
            ]);
        }
        $dealId = $event->getParameter('entityID');

        $tabs[] = [
            'id' => 'homework',
            'name' =>  'First_tab',
            'loader' => [
                'serviceUrl' => '/bitrix/components/otus.homework/otus.grid/lazyload.ajax.php?$site=' . \SITE_ID . '&' . \bitrix_sessid_get(),
                'componentDate' => [
                    'template' => '.default',
                    'params' => [
                        'DEAL_ID' => $dealId,
                    ],
                ],
            ],
        ];

        return new EventResult(EventResult::SUCCESS, [
            'tabs' => $tabs,
            ]);
    }

}