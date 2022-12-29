<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Exceptions\MethodNotFound;
use Bitrix24Api\Exceptions\NotImplement;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\CRM\LeadProductRowsModel;

class LeadProductRows extends BaseEntity
{
    protected string $method = 'crm.lead.productrows.%s';
    public const ITEM_CLASS = LeadProductRowsModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    /**
     * @throws NotImplement
     */
    public function set(int $id, array $rows): array
    {
        throw new NotImplement();
    }

    /**
     * @throws NotImplement
     */
    public function get($id): ?AbstractModel
    {
        throw new NotImplement();
    }

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
