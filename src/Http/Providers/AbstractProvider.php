<?php

namespace Bitrix24Api\Http\Providers;

use Throwable;
use LogicException;
use InvalidArgumentException;

use Bitrix24Api\Exceptions\MethodNotFound;
use Bitrix24Api\Http\Interfaces\Providers\ProviderInterface;

use Psr\Log\LoggerAwareTrait;

abstract class AbstractProvider implements ProviderInterface
{
    use LoggerAwareTrait;

    protected $client;

    public function __construct($client = null)
    {
        $this->client = $client ?: $this->makeClient();
    }

    abstract protected function logicRequest(...$arguments);

    /**
     * Инициализация клиента взаимодействия с внешней системой.
     *
     * @return mixed
     */
    abstract protected function makeClient();

    /**
     * Инициализация объекта провайдера.
     *
     * @param $client
     * @param ...$arguments
     * @return static
     */
    public static function make($client = null, ...$arguments)
    {
        return new static($client, ...$arguments);
    }

    /**
     * Выполнение запроса к внешней системе
     *
     * @param ...$arguments
     * @return mixed
     */
    public function request(...$arguments)
    {
        $validator = [$this, 'requestValidate'];
        if (is_callable($validator) && !call_user_func_array($validator, $arguments)) {
            throw new InvalidArgumentException('Invalid validate');
        }

        return $this->logicRequest(...$arguments);
    }

    /**
     * Выполнение команды провайдера.
     *
     * @param string $command
     * @param ...$arguments
     * @return mixed
     * @throws MethodNotFound|LogicException
     */
    protected function command(string $command, ...$arguments)
    {
        $callable = [$this->client, $command];

        if (!is_callable($callable)) {
            throw new MethodNotFound(sprintf('Command "%s" not found.', $command));
        }

        try {
            return call_user_func($callable, $arguments);
        } catch (Throwable $throwable) {
            if ($this->logger !== null) {
                $this->logger->error($throwable->getMessage());
            }

            throw new LogicException('Provider of commands with an error');
        }
    }
}
