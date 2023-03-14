<?php

namespace Bitrix24Api\EntitiesServices\Traits\Base;

trait GetListArrayTrait
{
    public function getList(): array
    {
        $method = sprintf($this->getMethod(), $this->listMethod);
        $result = $this->api->request(
            $method,
            []
        );

        $resultData = $result->getResponseData()->getResult()->getResultData() ?? [];

        if (!is_null($this->api->getLogger())) {
            $this->api->getLogger()->debug(
                "По запросу (getList) {$method} (получено сущностей: " . count($resultData),
            );
        }
        return $resultData;
    }
}
