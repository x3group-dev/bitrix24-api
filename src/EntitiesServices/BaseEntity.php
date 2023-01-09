<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\ApiClient;
use Bitrix24Api\Models\AbstractModel;

abstract class BaseEntity
{
    public const ITEM_CLASS = '';
    protected string $method = '';
    protected ApiClient $api;
    protected string $resultKey = '';
    protected array $baseParams = [];
    protected string $listMethod = 'list';
    protected string $idKey = 'ID';

    public function __construct(ApiClient $api, $params = [])
    {
        $this->api = $api;
        $this->baseParams = $params;
    }

    public function call(array $params = []): ?AbstractModel
    {
        if (!empty($this->baseParams))
            $params = array_merge($params, $this->baseParams);

        $response = $this->api->request($this->getMethod(), $params);

        $class = static::ITEM_CLASS;
        $entity = new $class([]);
        return !empty($response) ? $entity->fromArray($response->getResponseData()->getResult()->getResultData()) : null;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }
}
