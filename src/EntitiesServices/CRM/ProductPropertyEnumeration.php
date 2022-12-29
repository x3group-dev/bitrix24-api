<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\FieldsTrait;
use Bitrix24Api\Models\CRM\ProductPropertyEnumerationModel;

class ProductPropertyEnumeration extends BaseEntity
{
    use FieldsTrait;

    protected string $method = 'crm.product.property.enumeration.%s';
    public const ITEM_CLASS = ProductPropertyEnumerationModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';
}
