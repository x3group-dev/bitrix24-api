<?php

namespace Bitrix24Api\EntitiesServices\UserFieldType;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\UserFieldType\UserFieldTypeModel;

class UserFieldType extends BaseEntity
{
    use GetListTrait;

    protected string $method = 'userfieldtype.%s';
    public const ITEM_CLASS = UserFieldTypeModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    public function add(
        string $userTypeId,
        string $handler,
        string $title,
        string $description = '',
        array $options = []
    ): bool
    {
        $params = [
            'USER_TYPE_ID' => $userTypeId,
            'HANDLER' => $handler,
            'TITLE' => $title,
            'DESCRIPTION' => $description,
            'OPTIONS' => $options,
        ];

        try {
            $userFieldType = $this->api->request(
                sprintf($this->getMethod(), 'add'),
                $params
            );
            
            return current($userFieldType->getResponseData()->getResult()->getResultData());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $userTypeId): bool
    {
        try {
            $this->api->request(
                sprintf($this->getMethod(), 'delete'),
               [
                   'USER_TYPE_ID' => $userTypeId,
               ]
            );
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
