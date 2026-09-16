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
            // Исходное исключение часто с пустым сообщением: без класса и previous
            // в логе оставалась запись «Ошибка при получении лида: ""» без причины.
            throw new \Exception($e->getMessage() !== '' ? $e->getMessage() : $e::class, $e->getCode(), $e);
        }
    }
}
