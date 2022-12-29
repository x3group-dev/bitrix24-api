<?php

namespace Bitrix24Api\EntitiesServices\Entity;

use Bitrix24Api\ApiClient;
use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\GetTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Exceptions\Entity\AlredyExists;
use Bitrix24Api\Exceptions\Entity\NotFound;
use Bitrix24Api\Exceptions\InvalidArgumentException;
use Bitrix24Api\Models\Entity\EntityModel;
use Illuminate\Support\Facades\Log;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class Entity extends BaseEntity
{
    protected string $method = 'entity.%s';
    public const ITEM_CLASS = EntityModel::class;
    protected string $resultKey = '';
    protected string $listMethod = '';
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

    /**
     * @throws \Exception
     */

    public function add(string $name, array $access = [])
    {
        $params = [
            'ENTITY' => $this->entityId,
            'NAME' => $name,
            'ACCESS' => $access
        ];

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();
            if (current($result) === true) {
                return true;
            } else {
                return false;
            }
        } catch (ApiException $exception) {
            if ($exception->getTitle() === 'ERROR_ENTITY_ALREADY_EXISTS') {
                throw new AlredyExists($exception->getTitle(), 0, $exception->getDescription());
            } else {
                throw new \Exception($exception->getMessage());
            }
        }
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws NotFound
     * @throws \Exception
     */
    public function get(): EntityModel
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['ENTITY' => $this->entityId]);
            return new EntityModel($response->getResponseData()->getResult()->getResultData());
        } catch (ApiException $exception) {
            if ($exception->getMessage() == 'ERROR_ENTITY_NOT_FOUND') {
                throw new NotFound($exception->getTitle(), 404, $exception->getDescription());
            } else {
                throw new \Exception($exception->getMessage());
            }
        }
    }

    public function delete(): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'delete'), ['ENTITY' => $this->entityId]);
            return true;
        } catch (ApiException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
