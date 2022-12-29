<?php

namespace Bitrix24Api\EntitiesServices\Sonet;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\Sonet\GroupModel;

class Group extends BaseEntity
{
    protected string $method = 'sonet_group.%s';
    public const ITEM_CLASS = GroupModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';
}
