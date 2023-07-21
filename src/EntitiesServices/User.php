<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\User\UserModel;

class User extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

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
        $entity = new $class(current($response->getResponseData()->getResult()->getResultData()));
        return !empty($response) ? $entity : null;
    }
}
