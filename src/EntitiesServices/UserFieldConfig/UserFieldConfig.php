<?php

namespace Bitrix24Api\EntitiesServices\UserFieldConfig;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\UserFieldConfig\UserFieldConfigModel;

class UserFieldConfig extends BaseEntity
{
    use GetListTrait;

    protected string $method = 'userfieldconfig.%s';
    public const ITEM_CLASS = UserFieldConfigModel::class;
    protected string $resultKey = 'fields';
    protected string $listMethod = 'list';

    public function add(
        string $moduleId,
        string $entityId,
        string $fieldName,
        string $userTypeId,
        array $field = []
    ): ?AbstractModel
    {
        $field = array_merge($field, [
            'entityId' => $entityId,
            'fieldName' => $fieldName,
            'userTypeId' => $userTypeId,
        ]);

        try {
            $userField = $this->api->request(
                sprintf($this->getMethod(), 'add'),
                [
                    'moduleId' => $moduleId,
                    'field' => $field
                ]
            );

            $class = static::ITEM_CLASS;

            return new $class(
                !(empty($userField
                    ->getResponseData()
                    ->getResult()
                    ->getResultData())
                ) ? current($userField
                    ->getResponseData()
                    ->getResult()
                    ->getResultData()) : []
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $moduleId, int $id): bool
    {
        try {
            $this->api->request(
                sprintf($this->getMethod(), 'delete'),
               [
                   'moduleId' => $moduleId,
                   'id' => $id,
               ]
            );
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function get(string $moduleId, int $id): ?AbstractModel
    {
        try {
            $userField = $this->api->request(
                sprintf($this->getMethod(), 'get'),
                    [
                        'moduleId' => $moduleId,
                        'id' => $id,
                    ]
            );

            $class = static::ITEM_CLASS;

            return new $class(
                !(empty($userField
                    ->getResponseData()
                    ->getResult()
                    ->getResultData())
                ) ? current($userField
                    ->getResponseData()
                    ->getResult()
                    ->getResultData()) : []
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getTypes(string $moduleId): array
    {
        try {
            $types = $this->api->request(
                sprintf($this->getMethod(), 'getTypes'),
                [
                    'moduleId' => $moduleId
                ]
            );

            return $types->getResponseData()->getResult()->getResultData() ?? [];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(string $moduleId, int $id, array $field = []): ?AbstractModel
    {
        try {
            $userField = $this->api->request(
                sprintf($this->getMethod(), 'update'),
                [
                    'moduleId' => $moduleId,
                    'id' => $id,
                    'field' => $field,
                ]
            );

            $class = static::ITEM_CLASS;

            return new $class(
                !(empty($userField
                    ->getResponseData()
                    ->getResult()
                    ->getResultData())
                ) ? current($userField
                    ->getResponseData()
                    ->getResult()
                    ->getResultData()) : []
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
