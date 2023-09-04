<?php

namespace Bitrix24Api\EntitiesServices\Traits\Base;

trait GetListFastTrait
{
    /**
     * @throws \Exception
     */
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
                if ($result->getResponseData()->getResult())
                    $resultData = $result->getResponseData()->getResult()->getResultData();
                else
                    $resultData = [];
            }

            $start = $params['start'] ?? 0;
            $resultCounter = count($resultData);
            $totalCounter += $resultCounter;
            if (!is_null($this->api->getLogger())) {
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
}
