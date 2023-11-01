<?php

namespace Bitrix24Api\EntitiesServices\Imbot;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListArrayTrait;
use Bitrix24Api\Exceptions\ApiException;

class Command extends BaseEntity
{
    use GetListArrayTrait;

    protected string $method = 'imbot.command.%s';

    public function register(int $botId, string $command, bool $common, array $lang, string $eventCommandAdd, bool $hidden = false, bool $extranetSupport = false, string $clientId = '')
    {
        $fields = [
            'BOT_ID' => $botId,
            'COMMAND' => $command,
            'COMMON' => $common ? 'Y' : 'N',
            'HIDDEN' => $hidden ? 'Y' : 'N',
            'EXTRANET_SUPPORT' => $extranetSupport ? 'Y' : 'N',
            'CLIENT_ID' => $clientId,
            'LANG' => $lang,
            'EVENT_COMMAND_ADD' => $eventCommandAdd
        ];
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'register'), $fields);
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

    public function unregister(int $commandId, string $clientId = '')
    {
        $fields = [
            'COMMAND_ID' => $commandId,
            'CLIENT_ID' => $clientId
        ];
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'unregister'), $fields);
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

    public function update(int $commandId, array $lang, string $eventCommandAdd, bool $hidden = false, bool $extranetSupport = false, string $clientId = '')
    {
        $fields = [
            'COMMAND_ID' => $commandId,
            'FIELDS' => [
                'HIDDEN' => $hidden ? 'Y' : 'N',
                'EXTRANET_SUPPORT' => $extranetSupport ? 'Y' : 'N',
                'CLIENT_ID' => $clientId,
                'LANG' => $lang,
                'EVENT_COMMAND_ADD' => $eventCommandAdd
            ]
        ];
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'unregister'), $fields);
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

    public function answer(int|string $command, int $messageId, string $message, array $attach, array $keyboard, array $menu, bool $system, bool $urlPreview = true, string $clientId = '')
    {
        $fields = [
            'MESSAGE_ID' => $messageId,
            'MESSAGE' => $message,
            'ATTACH' => $attach,
            'KEYBOARD' => $keyboard,
            'MENU' => $menu,
            'SYSTEM' => $system ? 'Y' : 'N',
            'URL_PREVIEW' => $urlPreview ? 'Y' : 'N',
            'CLIENT_ID' => $clientId
        ];

        if (is_int($command)) {
            $fields['COMMAND_ID'] = $command;
        } else {
            $fields['COMMAND'] = $command;
        }

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'answer'), $fields);
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
