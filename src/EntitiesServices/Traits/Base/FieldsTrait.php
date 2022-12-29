<?php

namespace Bitrix24Api\EntitiesServices\Traits\Base;

trait FieldsTrait
{
    public function fields(): array
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'fields'), []);
            return $response->getResponseData()->getResult()->getResultData();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
