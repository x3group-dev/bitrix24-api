<?php

namespace Bitrix24Api\EntitiesServices\Traits\Base;

trait GetTrait
{
    /**
     * @throws \Exception
     */
    public function get($id)
    {
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['id' => $id]);
            return new $class($response->getResponseData()->getResult()->getResultData());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
