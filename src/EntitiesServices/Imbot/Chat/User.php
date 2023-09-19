<?php

namespace Bitrix24Api\EntitiesServices\Imbot\Chat;

use Bitrix24Api\EntitiesServices\BaseEntity;

class User extends BaseEntity
{
    protected string $method = 'imbot.chat.user.%s';

    public function add(int $chatId, array $users, int $botId): ?bool
    {
        $params = [
            'CHAT_ID' => $chatId,
            'USERS' => $users,
            'BOT_ID' => $botId,
        ];

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);
            return (bool)current($response->getResponseData()->getResult()->getResultData()) ?? null;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
