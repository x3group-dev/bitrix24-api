<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\Exceptions\ApiException;
use Illuminate\Support\Facades\Log;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class Scope extends BaseEntity
{
    protected string $method = 'scope';

    /**
     * Если метод вызван без параметров, то он вернет все разрешения, доступные для данного приложения.
     * @throws ApiException
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function get(): array
    {
        $response = $this->api->request($this->getMethod());
        return $response->getResponseData()->getResult()->getResultData();
    }
}
