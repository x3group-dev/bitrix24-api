<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\AddTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListArrayTrait;
use Bitrix24Api\Exceptions\MethodNotFound;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\CRM\ActivityTypeModel;

class ActivityType extends BaseEntity
{
    use AddTrait, GetListArrayTrait;

    protected string $method = 'crm.activity.type.%s';
    public const ITEM_CLASS = ActivityTypeModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';
}
