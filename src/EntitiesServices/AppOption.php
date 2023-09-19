<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\Exceptions\ApiException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class AppOption extends BaseEntity
{
    protected string $method = 'app.option.%s';

    /**
     * Если передать $option, вернет конкретное значение
     * Иначе все опции
     * @param $option
     * @return mixed
     * @throws ApiException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function get($option = null): mixed
    {
        $params = [];
        if (!is_null($option))
            $params = ['option' => $option];

        $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);

        if (is_null($option))
            return $response->getResponseData()->getResult()->getResultData();
        else
            return current($response->getResponseData()->getResult()->getResultData());
    }

    public function set($options): array
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'set'), ['options' => $options]);

        return $response->getResponseData()->getResult()->getResultData();
    }
}
