<?php

namespace Bitrix24Api\Http\Interfaces\Providers;

interface ProviderInterface
{
    /**
     * Выполнение запроса к внешней системе.
     *
     * @param ...$arguments
     * @return mixed
     */
    public function request(...$arguments);
}
