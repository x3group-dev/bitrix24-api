<?php

namespace Bitrix24Api\EntitiesServices\CRM\Smart;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\CRM\Smart\ItemModel;

class Item extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'crm.item.%s';
    public const ITEM_CLASS = ItemModel::class;
    protected string $resultKey = 'items';
    protected string $idKey = 'id';
}
