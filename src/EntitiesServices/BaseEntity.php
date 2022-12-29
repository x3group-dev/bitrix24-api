<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\ApiClient;
use Bitrix24Api\Models\AbstractModel;
use Illuminate\Support\Facades\Log;

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

    public function getList(array $params = []): \Generator
    {
        if (!empty($this->baseParams))
            $params = array_merge($params, $this->baseParams);

        $method = sprintf($this->getMethod(), $this->listMethod);
        do {

            $result = $this->api->request(
                $method,
                $params
            );

            if ($this->resultKey) {
                $resultData = $result->getResponseData()->getResult()->getResultData()[$this->resultKey] ?? [];
            } else {
                $resultData = $result->getResponseData()->getResult()->getResultData() ?? [];
            }

            $start = $params['start'] ?? 0;

            if(!is_null($this->api->getLogger())) {
                $this->api->getLogger()->debug(
                    "По запросу (getList) {$method} (start: {$start}) получено сущностей: " . count($resultData) .
                    ", всего существует: " . $result->getResponseData()->getPagination()->getTotal(),
                );
            }

            $class = static::ITEM_CLASS;
            foreach ($resultData as $resultDatum) {
                yield new $class($resultDatum);
            }

            if (empty($result->getResponseData()->getPagination()->getNextItem())) {
                break;
            }

            $params['start'] = $result->getResponseData()->getPagination()->getNextItem();
        } while (true);
    }

    public function getListFast(array $params = []): \Generator
    {
        if (!empty($this->baseParams))
            $params = array_merge($params, $this->baseParams);

        $method = sprintf($this->getMethod(), $this->listMethod);
        $params['order']['id'] = 'ASC';
        $params['filter']['>' . $this->idKey] = 0;
        $params['start'] = -1;

        if (isset($params['FILTER']) && is_array($params['FILTER']) && count($params['FILTER']) > 0) {
            if (!isset($params['filter'])) {
                $params['filter'] = [];
            }
            $params['filter'] = array_merge($params['filter'], $params['FILTER']);
            unset($params['FILTER']);
        }

        $totalCounter = 0;

        do {
            // костыль чтобы наверняка
            $params['FILTER'] = $params['filter'];
            $result = $this->api->request(
                $method,
                $params
            );

            if ($this->resultKey) {
                $resultData = $result->getResponseData()->getResult()->getResultData()[$this->resultKey] ?? [];
            } else {
                $resultData = $result->getResponseData()->getResult()->getResultData() ?? [];
            }

            $start = $params['start'] ?? 0;
            $resultCounter = count($resultData);
            $totalCounter += $resultCounter;
            if(!is_null($this->api->getLogger())) {
                $this->api->getLogger()->debug(
                    "По запросу (getListFast) {$method} (start: {$start}) получено сущностей: " . $resultCounter .
                    ", всего получено: " . $totalCounter,
                );
            }

            $class = static::ITEM_CLASS;
            foreach ($resultData as $resultDatum) {
                yield new $class($resultDatum);
            }

            if ($resultCounter < 50) {
                break;
            }

            $params['filter']['>' . $this->idKey] = (new $class($resultData[$resultCounter - 1]))->getId();
        } while (true);
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
