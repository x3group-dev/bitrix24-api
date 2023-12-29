<?php

namespace Bitrix24Api\EntitiesServices\Event;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\Event\EventModel;

class Event extends BaseEntity
{
    use GetListTrait;

    protected string $method = 'event.%s';
    public const ITEM_CLASS = EventModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    public function bind(
        string $event,
        string $handler,
        ?int $authType = null,
        ?string $eventType = null,
        mixed $authConnector = null,
        mixed $options = null,
    )
    {
        try {
            $params = [
                'event' => $event,
                'handler' => $handler,
                'auth_type' => $authType,
                'event_type' => $eventType,
                'auth_connector' => $authConnector,
                'options' => $options,
            ];

            $response = $this->api->request(sprintf($this->getMethod(), 'bind'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();

            return (bool)current($result);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function unbind(
        string $event,
        string $handler,
        ?int $authType = null,
        ?string $eventType = null,
        mixed $authConnector = null,
        mixed $options = null,
    )
    {
        try {
            $params = [
                'event' => $event,
                'handler' => $handler,
                'auth_type' => $authType,
                'event_type' => $eventType,
                'auth_connector' => $authConnector,
                'options' => $options,
            ];

            $response = $this->api->request(sprintf($this->getMethod(), 'unbind'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();

            return (bool)current($result);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
