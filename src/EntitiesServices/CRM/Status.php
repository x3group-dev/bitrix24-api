<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\CRM\StatusModel;

class Status extends BaseEntity
{
    use GetListTrait;

    protected string $method = 'crm.status.%s';
    public const ITEM_CLASS = StatusModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';
}
