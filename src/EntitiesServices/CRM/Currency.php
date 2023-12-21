<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\AddTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\FieldsTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\UpdateTrait;
use Bitrix24Api\Exceptions\NotImplement;
use Bitrix24Api\Models\CRM\CurrencyModel;

class Currency extends BaseEntity
{
    use GetListTrait, GetListFastTrait, AddTrait, UpdateTrait, DeleteTrait, GetTrait, FieldsTrait;

    protected string $method = 'crm.currency.%s';
    public const ITEM_CLASS = CurrencyModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

}
