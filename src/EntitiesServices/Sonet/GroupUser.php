<?php

namespace Bitrix24Api\EntitiesServices\Sonet;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\Sonet\GroupUserModel;

class GroupUser extends BaseEntity
{
    use GetListTrait;

    protected string $method = 'sonet_group.user.%s';
    public const ITEM_CLASS = GroupUserModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    public function get(int $groupId): ?array
    {
        $params = [
            'ID' => $groupId,
        ];
        $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);

        return !empty($response) ? $response->getResponseData()->getResult()->getResultData() : [];
    }

    public function groups(): ?GroupUserModel
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'groups'), []);

        $class = static::ITEM_CLASS;
        $entity = new $class($response->getResponseData()->getResult()->getResultData());
        return !empty($response) ? $entity : null;
    }
}
