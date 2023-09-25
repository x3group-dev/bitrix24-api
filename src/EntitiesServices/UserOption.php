<?php

namespace Bitrix24Api\EntitiesServices;

class UserOption extends BaseEntity
{
    protected string $method = 'user.option.%s';

    public function get($option): array
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['option' => $option]);

        return $response->getResponseData()->getResult()->getResultData();
    }

    public function set($options): array
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'set'), ['options' => $options]);

        return $response->getResponseData()->getResult()->getResultData();
    }
}
