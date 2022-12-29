<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\Exceptions\NotImplement;
use Bitrix24Api\Models\PlacementModel;

class Placement extends BaseEntity
{
    protected string $method = 'placement.%s';
    public const ITEM_CLASS = PlacementModel::class;

    /**
     * @throws \Bitrix24Api\Exceptions\ApiException
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function get(): array
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'get'), []);

        $class = static::ITEM_CLASS;
        $responseData = $response->getResponseData()->getResult()->getResultData();
        $result = [];
        foreach ($responseData as $responseDatum) {
            $result[] = new $class($responseDatum);
        }
        return $result;
    }

    public function bind($placement, $handler, $lang)
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'bind'), [
            'PLACEMENT' => $placement,
            'HANDLER' => $handler,
            'LANG_ALL' => $lang
        ]);

        return current($response->getResponseData()->getResult()->getResultData());
    }

    public function unbind($placement, $handler)
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'unbind'), [
            'PLACEMENT' => $placement,
            'HANDLER' => $handler,
        ]);

        return current($response->getResponseData()->getResult()->getResultData());
    }

    /**
     * @throws NotImplement
     */
    public function getListFast(array $params = []): \Generator
    {
        throw new NotImplement();
    }
}
