<?php

namespace Bitrix24Api\EntitiesServices\Event;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Models\Event\EventModel;

class Event extends BaseEntity
{
    protected string $method = 'event.%s';
    public const ITEM_CLASS = EventModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    public function bind(array $params)
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'bind'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();

            return (bool)current($result);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function unbind(array $params)
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'unbind'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();

            return (bool)current($result);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
