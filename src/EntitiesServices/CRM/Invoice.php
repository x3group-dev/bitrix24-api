<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Models\CRM\InvoiceModel;

class Invoice extends BaseEntity
{
    use GetListTrait;

    protected string $method = 'crm.invoice.%s';
    public const ITEM_CLASS = InvoiceModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';
}
