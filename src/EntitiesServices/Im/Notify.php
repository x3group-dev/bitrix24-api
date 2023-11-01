<?php

namespace Bitrix24Api\EntitiesServices\Im;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Exceptions\ApiException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class Notify extends BaseEntity
{
    protected string $method = 'im.notify.%s';

    public const NOTIFY_TYPE_PERSONAL = 1;
    public const NOTIFY_TYPE_SYSTEM = 2;

    /**
     * Отправка уведомления
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function add(int $type, int $userId, string $message, string $messageOut = '', string $tag = '', string $subTag = '', array $attach = [])
    {
        $method = $type === self::NOTIFY_TYPE_PERSONAL ? sprintf($this->getMethod(), 'personal.add') : sprintf($this->getMethod(), 'system.add ');
        $fields = [
            'USER_ID' => $userId,
            'MESSAGE' => $message,
            'MESSAGE_OUT' => $messageOut,
            'TAG' => $tag,
            'SUB_TAG' => $subTag,
            'ATTACH' => $attach
        ];

        try {
            $response = $this->api->request($method, $fields);
            $result = $response->getResponseData()->getResult()->getResultData();
            $id = current($result);
            if ($id > 0) {
                return $id;
            } else {
                return false;
            }
        } catch (ApiException $e) {
            //todo: process errors
        }
        return false;
    }
}
