<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\CRM\TimelineBindingsModel;

class TimelineBindings extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'crm.timeline.bindings.%s';
    public const ITEM_CLASS = TimelineBindingsModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';
}
