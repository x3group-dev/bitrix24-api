<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\User\UserModel;

class User extends BaseEntity
{
    protected string $method = 'user.%s';
    public const ITEM_CLASS = UserModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    public function get($id): ?AbstractModel
    {
        $params = [
            'FILTER' => [
                'ID' => $id
            ]
        ];
        $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);

        $class = static::ITEM_CLASS;
        $entity = new $class($response->getResponseData()->getResult()->getResultData());
        return !empty($response) ? $entity : null;
    }
}
