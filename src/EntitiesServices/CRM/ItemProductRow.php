<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\FieldsTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\UpdateTrait;
use Bitrix24Api\EntitiesServices\Traits\GetTrait;
use Bitrix24Api\Models\CRM\ItemProductRowModel;

class ItemProductRow extends BaseEntity
{
    use FieldsTrait, GetTrait, UpdateTrait, DeleteTrait;

    protected string $method = 'crm.item.productrow.%s';
    public const ITEM_CLASS = ItemProductRowModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    public function add(array $fields)
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), ['fields' => $fields]);
            $result = $response->getResponseData()->getResult()->getResultData();
            $id = $result['productRow']['id'];
            if ($id > 0) {
                return $id;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
