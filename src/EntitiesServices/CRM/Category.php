<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\ApiClient;
use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Exceptions\InvalidArgumentException;
use Bitrix24Api\Exceptions\MethodNotFound;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\CRM\CategoryModel;

class Category extends BaseEntity
{
    protected string $method = 'crm.category.%s';
    public const ITEM_CLASS = CategoryModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';
    private string $entityTypeId = '';

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(ApiClient $api, string $entityTypeId)
    {
        parent::__construct($api, []);
        if (empty($entityTypeId)) {
            throw new InvalidArgumentException('entityTypeId is null');
        }
        $this->entityTypeId = $entityTypeId;
    }

    /**
     * @throws \Exception
     */
    public function get($id): ?AbstractModel
    {
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['id' => $id, 'entityTypeId' => $this->entityTypeId]);
            return new $class($response->getResponseData()->getResult()->getResultData());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getList(array $params = []): \Generator
    {
        $params = array_merge($params, $this->baseParams);
        parent::getList($params);
    }

    /**
     * @throws MethodNotFound
     */
    public function getListFast(array $params = []): \Generator
    {
        throw new MethodNotFound();
    }

    /**
     * @throws \Exception
     */

    public function add(array $fields): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'add'), ['entityTypeId' => $this->entityTypeId, 'fields' => $fields]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function fields(): array
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'fields'), ['entityTypeId' => $this->entityTypeId]);
            return $response->getResponseData()->getResult()->getResultData();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update($id, array $fields): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'update'), ['id' => $id, 'fields' => $fields, 'entityTypeId' => $this->entityTypeId]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function delete($id): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'delete'), ['id' => $id, 'entityTypeId' => $this->entityTypeId]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
