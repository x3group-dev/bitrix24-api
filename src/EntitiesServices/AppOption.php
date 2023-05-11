<?php

namespace Bitrix24Api\EntitiesServices;

class AppOption extends BaseEntity
{
    protected string $method = 'app.option.%s';

    public function get($option = null): array
    {
        $params = [];
        if(!is_null($option))
            $params = ['option' => $option];

        $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);

        return $response->getResponseData()->getResult()->getResultData();
    }

    public function set($options): array
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['options' => $options]);

        return $response->getResponseData()->getResult()->getResultData();
    }
}
