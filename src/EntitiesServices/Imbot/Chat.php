<?php

namespace Bitrix24Api\EntitiesServices\Imbot;

use Bitrix24Api\EntitiesServices\BaseEntity;

class Chat extends BaseEntity
{
    protected string $method = 'imbot.chat.%s';

    public function add(string $type, string $title, string $description, string $color, string $message, array $users, string $avatar, string $entityType, int $entityId, int $ownerId, int $botId): ?int
    {
        $params = [
            'TYPE' => $type,
            'TITLE' => $title,
            'DESCRIPTION' => $description,
            'COLOR' => $color,
            'MESSAGE' => $message,
            'USERS' => $users,
            'AVATAR' => $avatar,
            'ENTITY_TYPE' => $entityType,
            'ENTITY_ID' => (string)$entityId,
            'OWNER_ID' => $ownerId,
            'BOT_ID' => $botId,
        ];
        if (empty($avatar)) {
            unset($params['AVATAR']);
        }

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);
            return (int)current($response->getResponseData()->getResult()->getResultData()) ?? null;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
