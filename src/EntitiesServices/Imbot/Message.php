<?php

namespace Bitrix24Api\EntitiesServices\Imbot;

use Bitrix24Api\EntitiesServices\BaseEntity;

class Message extends BaseEntity
{
    protected string $method = 'imbot.message.%s';

    public function add($dialogId, $message, $attach = [], $keyboard = '', $menu = '', bool $system = false, bool $urlPreview = true, $botId = null): ?array
    {
        $params = [
            'DIALOG_ID' => $dialogId,
            'MESSAGE' => $message,
            'SYSTEM' => $system ? 'Y' : 'N',
            'URL_PREVIEW' => $urlPreview ? 'Y' : 'N',
        ];

        if (!empty($attach)) {
            $params['ATTACH'] = $attach;
        }

        if (!empty($keyboard)) {
            $params['KEYBOARD'] = $keyboard;
        }

        if (!empty($menu)) {
            $params['MENU'] = $menu;
        }

        if (!empty($botId)) {
            $params['BOT_ID'] = $botId;
        }

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);
            return $response->getResponseData()->getResult()->getResultData() ?? null;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}