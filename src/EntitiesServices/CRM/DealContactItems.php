<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\FieldsTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\Models\CRM\DealContactItemsModel;
use Bitrix24Api\Models\CRM\DealModel;

class DealContactItems extends BaseEntity
{
    use GetListTrait, GetListFastTrait, GetTrait, DeleteTrait, FieldsTrait;

    protected string $method = 'crm.deal.contact.items.%s';
    public const ITEM_CLASS = DealContactItemsModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';
}
