<?php

namespace Bitrix24Api\EntitiesServices\Entity;

use Bitrix24Api\ApiClient;
use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Exceptions\Entity\AlredyExists;
use Bitrix24Api\Exceptions\Entity\PropertyNotFound;
use Bitrix24Api\Exceptions\InvalidArgumentException;
use Bitrix24Api\Models\Entity\ItemPropertyModel;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class ItemProperty extends BaseEntity
{
    use GetListTrait {
        GetListTrait::getList as getListTrait;
    }

    protected string $method = 'entity.item.property.%s';
    public const ITEM_CLASS = ItemPropertyModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';
    private string $entityId = '';

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(ApiClient $api, string $entityTypeId)
    {
        parent::__construct($api, []);
        if (empty($entityTypeId)) {
            throw new InvalidArgumentException('entityId is null');
        }
        $this->entityId = $entityTypeId;
    }

    public function add(string $property, string $name, string $type = 'S')
    {
        $params = [
            'ENTITY' => $this->entityId,
            'PROPERTY' => $property,
            'NAME' => $name,
            'TYPE' => $type
        ];

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();
            if (current($result) === true) {
                return true;
            } else {
                return false;
            }
        } catch (ApiException $e) {
            if ($e->getTitle() === 'ERROR_ENTITY_ALREADY_EXISTS') {
                throw new AlredyExists($e->getTitle(), 0, $e->getDescription());
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws PropertyNotFound
     * @throws \Exception
     */
    public function get($property): ?ItemPropertyModel
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['ENTITY' => $this->entityId, 'PROPERTY' => $property]);
            return new ItemPropertyModel($response->getResponseData()->getResult()->getResultData());
        } catch (ApiException $exception) {
            if ($exception->getMessage() == 'ERROR_PROPERTY_NOT_FOUND') {
                throw new PropertyNotFound($exception->getTitle(), 404, $exception->getDescription());
            } else {
                throw new \Exception($exception->getMessage());
            }
        }
    }

    public function delete($property): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'delete'), ['ENTITY' => $this->entityId, 'PROPERTY' => $property]);
            return true;
        } catch (ApiException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getList(array $params = []): \Generator
    {
        $params = ['ENTITY' => $this->entityId];
        return $this->getListTrait($params);
    }
}
