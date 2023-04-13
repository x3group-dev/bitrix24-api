<?php

namespace Bitrix24Api\EntitiesServices;

class AppOption extends BaseEntity
{
    protected string $method = 'app.option.%s';

    public function get($option): array
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['option' => $option]);

        return $response->getResponseData()->getResult()->getResultData();
    }

    public function set($options): array
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['options' => $options]);

        return $response->getResponseData()->getResult()->getResultData();
    }
}
