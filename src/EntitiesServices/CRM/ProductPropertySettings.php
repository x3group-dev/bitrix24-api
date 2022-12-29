<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\FieldsTrait;
use Bitrix24Api\Models\CRM\ProductPropertySettingsModel;

class ProductPropertySettings extends BaseEntity
{
    use FieldsTrait;

    protected string $method = 'crm.product.property.settings.%s';
    public const ITEM_CLASS = ProductPropertySettingsModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';
}
