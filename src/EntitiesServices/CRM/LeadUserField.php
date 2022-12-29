<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\Exceptions\NotImplement;
use Bitrix24Api\Models\CRM\LeadUserfieldModel;

class LeadUserField extends BaseEntity
{
    use GetTrait, DeleteTrait;

    protected string $method = 'crm.lead.userfield.%s';
    public const ITEM_CLASS = LeadUserFieldModel::class;
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
