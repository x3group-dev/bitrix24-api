<?php

namespace Bitrix24Api\EntitiesServices\Traits\Base;

trait DeleteTrait
{
    /**
     * @throws \Exception
     */
    public function delete($id): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'delete'), ['id' => $id]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
