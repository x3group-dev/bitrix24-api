<?php

namespace Bitrix24Api\EntitiesServices\Traits\Base;

trait UpdateTrait
{
    /**
     * @throws \Exception
     */
    public function update($id, array $fields): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'update'), ['id' => $id, 'fields' => $fields]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
