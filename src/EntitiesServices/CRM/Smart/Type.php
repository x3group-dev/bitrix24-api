<?php

namespace Bitrix24Api\EntitiesServices\CRM\Smart;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\CRM\Smart\ItemModel;
use Bitrix24Api\Models\CRM\Smart\TypeModel;

class Type extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'crm.type.%s';
    public const ITEM_CLASS = TypeModel::class;
    protected string $resultKey = '';
    protected string $idKey = 'id';
    protected string $listMethod = 'list';

    public function add(array $params = [])
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);

            $class = static::ITEM_CLASS;
            $entity = new $class(current($response->getResponseData()->getResult()->getResultData()));
            return !empty($response) ? $entity : null;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'delete'), [
                'id' => $id,
            ]);
            $result = $response->getResponseData()->getResult()->getResultData();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
