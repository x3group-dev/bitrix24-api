<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\CRM\TimelineLogoModel;

class TimelineLogo extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'crm.timeline.logo.%s';
    public const ITEM_CLASS = TimelineLogoModel::class;
    protected string $resultKey = 'logos';
    protected string $listMethod = 'list';
}
