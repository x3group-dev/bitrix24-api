<?php

namespace Bitrix24Api\EntitiesServices\Traits\Base;

trait GetListTrait
{
    /**
     * @throws \Exception
     */
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
}
