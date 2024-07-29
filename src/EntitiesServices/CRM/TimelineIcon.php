<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\CRM\TimelineIconModel;

class TimelineIcon extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'crm.timeline.icon.%s';
    public const ITEM_CLASS = TimelineIconModel::class;
    protected string $resultKey = 'icons';
    protected string $listMethod = 'list';
}
