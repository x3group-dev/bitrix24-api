<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\Exceptions\NotImplement;
use Bitrix24Api\Models\CRM\DealUserFieldModel;

class DealUserField extends BaseEntity
{
    use GetTrait, GetListTrait, DeleteTrait;

    protected string $method = 'crm.deal.userfield.%s';
    public const ITEM_CLASS = DealUserFieldModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    /**
     * @throws NotImplement
     */
    public function add(array $fields, array $LIST): bool
    {
        throw new NotImplement();
    }
}
