<?php

namespace Bitrix24Api\EntitiesServices\Traits;

use Bitrix24Api\Models\AbstractModel;

trait GetWithoutParamsTrait
{
    /**
     * @throws \Exception
     */
    public function get(): ?AbstractModel
    {
        $params = $this->baseParams;
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);
            return new $class($response->getResponseData()->getResult()->getResultData());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
