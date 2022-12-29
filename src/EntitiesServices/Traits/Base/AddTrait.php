<?php

namespace Bitrix24Api\EntitiesServices\Traits\Base;

trait AddTrait
{
    /**
     * @throws \Exception
     */
    public function add(array $fields): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'add'), ['fields' => $fields]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
