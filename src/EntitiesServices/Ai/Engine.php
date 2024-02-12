<?php

namespace Bitrix24Api\EntitiesServices\Ai;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListArrayTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\BaseModel;

class Engine extends BaseEntity
{
    use GetListArrayTrait;

    protected string $method = 'ai.engine.%s';
    public const ITEM_CLASS = BaseModel::class;

    public function register(string $name, string $code, string $category, string $completionsUrl, array $settings = []): int
    {
        $params = [
            'name' => $name,
            'code' => $code,
            'category' => $category,
            'completions_url' => $completionsUrl,
            'settings' => $settings
        ];

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'register'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();

            return (int)current($result);
        } catch (ApiException $exception) {

            throw new \Exception($exception->getMessage());
        }
    }

    public function unregister(string $code)
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'unregister'), ['code' => $code]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
