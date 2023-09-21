<?php

namespace Bitrix24Api\Http\Interfaces\Providers;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;

use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @method ResponseInterface request(string $url, array $options)
 */
interface HttpProviderInterface extends ProviderInterface
{
    /**
     * Удаление заголовка по ключу.
     *
     * @param string $name
     * @return $this
     */
    public function deleteHeader(string $name): self;

    /**
     * Добавление заголовка.
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setHeader(string $name, string $value): self;

    /**
     * Получение метода отпраки запросов
     *
     * @return string
     */
    #[ArrayShape(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'])]
    public function getMethod(): string;

    /**
     * Установка метода работы HTTP клиента.
     *
     * @param string $method
     * @return $this
     */
    public function setMethod(
        #[ExpectedValues(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'])]
        string $method
    ): self;
}
