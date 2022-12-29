<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\FieldsTrait;
use Bitrix24Api\Exceptions\MethodNotFound;
use Bitrix24Api\Models\CRM\ActivityCommunicationModel;

class ActivityCommunication extends BaseEntity
{
    use FieldsTrait;
    protected string $method = 'crm.activity.communication.%s';
    public const ITEM_CLASS = ActivityCommunicationModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    /**
     * @throws MethodNotFound
     */
    public function getList(array $params = []): \Generator
    {
        throw new MethodNotFound();
    }

    /**
     * @throws MethodNotFound
     */
    public function getListFast(array $params = []): \Generator
    {
        throw new MethodNotFound();
    }

    /**
     * @throws MethodNotFound
     */
    public function update($id, array $fields): bool
    {
        throw new MethodNotFound();
    }

    /**
     * @throws MethodNotFound
     */
    public function delete($id): bool
    {
        throw new MethodNotFound();
    }
}
