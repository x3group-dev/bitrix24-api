<?php

namespace Bitrix24Api\Interfaces;

use Bitrix24Api\Config\Config;

interface ClientInterface
{
    /**
     * @todo: Переделать на абстракцию
     * @return Config
     */
    public function getConfig(): Config;
}
