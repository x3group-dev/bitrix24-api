<?php

namespace Bitrix24Api\EntitiesServices\Entity;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\Entity\ItemModel;

class Item extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'entity.item.%s';
    public const ITEM_CLASS = ItemModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    public function get(int $id): ?ItemModel
    {
        if ($id === 0)
            throw new \Exception('id 0');

        $params = [
            'FILTER' => [
                'ID' => $id,
            ],
        ];

        if (!empty($this->baseParams))
            $params = array_merge($params, $this->baseParams);

        $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);

        $class = static::ITEM_CLASS;
        $entity = null;
        $item = current($response->getResponseData()->getResult()->getResultData());
        if ($item)
            $entity = new $class($item);

        return $entity;
    }

    public function add($params = [])
    {
        if (!empty($this->baseParams))
            $params = array_merge($params, $this->baseParams);

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();
            $id = current($result);
            if ($id > 0) {
                return $id;
            } else {
                return false;
            }
        } catch (ApiException $e) {

        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public function update($id, array $fields): bool
    {
        if (!empty($this->baseParams))
            $fields = array_merge($fields, $this->baseParams);

        $fields['ID'] = $id;

        try {
            $this->api->request(sprintf($this->getMethod(), 'update'), $fields);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($id): bool
    {
        $fields = ['ID' => $id];

        if (!empty($this->baseParams))
            $fields = array_merge($fields, $this->baseParams);

        try {
            $result = $this->api->request(sprintf($this->getMethod(), 'delete'), $fields);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
