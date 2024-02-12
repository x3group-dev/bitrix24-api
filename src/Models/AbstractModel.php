<?php

namespace Bitrix24Api\Models;

abstract class AbstractModel
{
    /**
     * @return array
     */
    abstract public function toArray(): array;

    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __isset($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function __get($offset)
    {
        return $this->data[$offset] ?? null;
    }

    public function __set($name, $value)
    {

    }

    protected function isKeyExists(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }
}
