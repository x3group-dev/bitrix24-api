<?php

namespace Bitrix24Api\EntitiesServices\Disk;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\Exceptions\Disk\FileNotFound;
use Bitrix24Api\Models\Disk\FileModel;

class File extends BaseEntity
{
    use GetTrait, DeleteTrait;

    protected string $method = 'disk.file.%s';
    public const ITEM_CLASS = FileModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    public function get($id)
    {
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['id' => $id]);
            return new $class($response->getResponseData()->getResult()->getResultData());
        } catch (\Exception $e) {
            if ($e->getMessage() === 'ERROR_NOT_FOUND') {
                throw new FileNotFound('file not found');
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }
}
