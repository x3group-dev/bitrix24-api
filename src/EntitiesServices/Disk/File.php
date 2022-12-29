<?php

namespace Bitrix24Api\EntitiesServices\Disk;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\Models\Disk\FileModel;

class File extends BaseEntity
{
    use GetTrait, DeleteTrait;
    protected string $method = 'disk.file.%s';
    public const ITEM_CLASS = FileModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';
}
