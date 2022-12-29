<?php

namespace Bitrix24Api\EntitiesServices\Disk;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\Exceptions\MethodNotFound;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Disk\AttachedObjectModel;

class AttachedObject extends BaseEntity
{
    use GetTrait;

    protected string $method = 'disk.attachedObject.%s';
    public const ITEM_CLASS = AttachedObjectModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';
}
