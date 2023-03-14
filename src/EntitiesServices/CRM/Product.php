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
use Bitrix24Api\Models\CRM\ProductModel;

class Product extends BaseEntity
{
    use GetListTrait, GetListFastTrait, AddTrait, UpdateTrait, DeleteTrait, GetTrait, FieldsTrait;

    protected string $method = 'crm.product.%s';
    public const ITEM_CLASS = ProductModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

}
