<?php

namespace Bitrix24Api\Http\Providers;

use ArgumentCountError;

use Bitrix24Api\Http\Interfaces\Providers\HttpProviderInterface;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * @method static self make($client = null, ...$arguments)
 */
class HttpProvider extends AbstractProvider implements HttpProviderInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * Настройки механизма HTTP отправки запросов.
     *
     * @var array
     */
    protected array $options;

    /**
     * Метод запроса.
     *
     * @var string
     */
    protected string $method = "POST";

    /**
     * Заголовки запроса.
     *
     * @var string[]
     */
    protected array $headers;

    protected $dataFormat;

    public function __construct($client = null, array $options = ['http_version' => '2.0'])
    {
        $this->options = $options;
        $this->headers = $this->getDefaultHeaders();
        parent::__construct($client);
    }

    /**
     * Логика отправки запроса.
     *
     * @param ...$arguments
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    protected function logicRequest(...$arguments)
    {
        return $this->client->request($this->method, ...$arguments);
    }

    /**
     * Валидация входных параметров запроса.
     *
     * @param ...$arguments
     * @return bool
     */
    public function requestValidate(...$arguments): bool
    {
        $countArguments = count($arguments);
        if ($countArguments < 2) {
            $error = sprintf('Too few arguments, %s defined, 2 expected', $countArguments);
            throw new ArgumentCountError($error);
        }

        return is_string(reset($arguments)) && is_string(next($arguments)) && is_array(next($arguments));
    }

    /**
     * Удаление заголовка по ключу.
     *
     * @param string $name
     * @return $this
     */
    public function deleteHeader(string $name): self
    {
        if (array_key_exists($name, $this->headers)) {
            unset($this->headers[$name]);
        }

        return $this;
    }

    /**
     * Добавление заголовка.
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Получение заголовков запроса.
     *
     * @return string[]
     */
    protected function getHeaders(): array
    {
        return $this->headers;
        return [
            'Accept' => 'application/json',
            'Accept-Charset' => 'utf-8',
            'User-Agent' => sprintf('%s-v-%s-php-%s', self::CLIENT_USER_AGENT, self::CLIENT_VERSION, PHP_VERSION),
        ];
    }

    protected function getDefaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Accept-Charset' => 'utf-8',
        ];
    }

    /**
     * Создание объекта отправки запросов.
     *
     * @return HttpClientInterface
     */
    protected function makeClient(): HttpClientInterface
    {
        return HttpClient::create($this->options);
    }

    /**
     * Подготовка валидного метода отправки через http client
     *
     * @param string $method
     * @return string
     */
    protected function prepareValidMethod(string $method): string
    {
        $method = mb_strtoupper(trim($method));
        return in_array($method, $this->getValidMethods()) ? $method : 'GET';
    }

    /**
     * Получение списка доступных методов.
     *
     * @final
     * @return string[]
     */
    #[ArrayShape(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'])]
    final protected function getValidMethods(): array
    {
        return ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'];
    }

    /**
     * Получение метода отпраки запросов
     *
     * @final
     * @return string
     */
    #[ArrayShape(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'])]
    final public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Установка метода работы HTTP клиента.
     *
     * @final
     * @param string $method
     * @return $this
     */
    final public function setMethod(
        #[ExpectedValues(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'])]
        string $method
    ): self
    {
        $this->method = $this->prepareValidMethod($method);

        return $this;
    }
}
