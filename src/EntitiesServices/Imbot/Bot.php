<?php

namespace Bitrix24Api\EntitiesServices\Imbot;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListArrayTrait;
use Bitrix24Api\Exceptions\ApiException;

class Bot extends BaseEntity
{
    use GetListArrayTrait;

    protected string $method = 'imbot.bot.%s';

    public function register(array $fields = [])
    {
        try {
            $response = $this->api->request('imbot.register', $fields);
            $result = $response->getResponseData()->getResult()->getResultData();
            $id = current($result);
            if ($id > 0) {
                return $id;
            } else {
                return false;
            }
        } catch (ApiException $e) {

        }
        return false;
    }

    public function unregister(int $botId, string $clientId = '')
    {
        $fields = [
            'BOT_ID' => $botId,
            'CLIENT_ID' => $clientId
        ];
        try {
            $response = $this->api->request('imbot.unregister', $fields);
            $result = $response->getResponseData()->getResult()->getResultData();
            if (current($result)) {
                return current($result);
            } else {
                return false;
            }
        } catch (ApiException $e) {

        }
        return false;
    }
}
