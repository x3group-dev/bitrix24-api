<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\AddTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\FieldsTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\UpdateTrait;
use Bitrix24Api\Models\CRM\CompanyModel;

class Company extends BaseEntity
{
    use GetListTrait, GetListFastTrait, GetTrait, DeleteTrait, FieldsTrait;

    protected string $method = 'crm.company.%s';
    public const ITEM_CLASS = CompanyModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    /**
     * @throws \Exception
     */
    public function add(array $fields, $params = [])
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), ['fields' => $fields, 'params' => $params]);
            $result = $response->getResponseData()->getResult()->getResultData();
            if (isset($result['ID']) && $result['ID'] > 0) {
                return $result['ID'];
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function update($id, array $fields, $params = []): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'update'), ['id' => $id, 'fields' => $fields, 'params' => $params]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
