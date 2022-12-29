<?php

namespace Bitrix24Api\Batch;

class Command
{
    /**
     * @var string
     */
    private string $method;
    /**
     * @var array
     */
    private array $params;
    /**
     * @var null|string
     */
    private ?string $name;

    public function __construct(string $method, array $params, ?string $name = null)
    {
        $this->method = $method;
        $this->params = $params;
        $this->name = $name ?? uniqid($method,true);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
