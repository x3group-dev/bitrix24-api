<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\UpdateTrait;
use Bitrix24Api\Models\CRM\DealUserFieldModel;

class DealUserField extends BaseEntity
{
    use GetTrait, GetListTrait, UpdateTrait, DeleteTrait;

    protected string $method = 'crm.deal.userfield.%s';
    public const ITEM_CLASS = DealUserFieldModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    public function add(array $fields): int|bool
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), ['fields' => $fields]);

            $id = current($response->getResponseData()->getResult()->getResultData());

            if (isset($id) && $id > 0) {
                return $id;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
