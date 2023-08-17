<?php

namespace Bitrix24Api\EntitiesServices\Bizproc;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Models\Bizproc\EventModel;

class Event extends BaseEntity
{
    protected string $method = 'bizproc.event.%s';
    public const ITEM_CLASS = EventModel::class;
    protected string $resultKey = '';

    public function send(string $eventToken, array $returnValues): bool
    {
        $params = [
            'EVENT_TOKEN' => $eventToken,
            'RETURN_VALUES' => $returnValues,
        ];

        try {
            $this->api->request(sprintf($this->getMethod(), 'send'), $params);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
