<?php

namespace Bitrix24Api\EntitiesServices\Messageservice;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Exceptions\Entity\AlredyExists;
use Bitrix24Api\Models\Messageservice\SenderModel;

class Sender extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'messageservice.sender.%s';
    public const ITEM_CLASS = SenderModel::class;

    public function add(string $code, string $type, string $handler, string $name, string $description)
    {
        $params = [
            'CODE' => $code,
            'TYPE' => $type,
            'HANDLER' => $handler,
            'NAME' => $name,
            'DESCRIPTION' => $description,
        ];

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();

            if (current($result) === true) {
                return true;
            }

            return false;
        } catch (ApiException $exception) {
            if ($exception->getTitle() === 'ERROR_SENDER_ALREADY_INSTALLED') {
                throw new AlredyExists($exception->getTitle(), 0, $exception->getDescription());
            } else {
                throw new \Exception($exception->getMessage());
            }
        }
    }

    public function delete(string $code)
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'delete'), ['CODE' => $code]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}