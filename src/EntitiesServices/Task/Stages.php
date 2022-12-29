<?php

namespace Bitrix24Api\EntitiesServices\Task;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\Task\StagesModel;

class Stages extends BaseEntity
{
    protected string $method = 'task.stages.%s';
    public const ITEM_CLASS = StagesModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    public function getData($entityId, bool $isAdmin = false): array
    {
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['entityId' => $entityId, 'isAdmin' => $isAdmin]);
            return $response->getResponseData()->getResult()->getResultData();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
