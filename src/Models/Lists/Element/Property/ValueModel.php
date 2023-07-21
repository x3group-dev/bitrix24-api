<?php

namespace Bitrix24Api\Models\Lists\Element\Property;

class ValueModel
{
    protected array|string $data;

    public function __construct(array|string $data)
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function getValue()
    {
        if (is_array($this->data))
            return current($this->data);
        else
            return $this->data;
    }

    public function getValueId()
    {
        return array_key_first($this->data);
    }
}
