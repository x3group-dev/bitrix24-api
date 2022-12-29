<?php

namespace Bitrix24Api\Models\Lists\Element\Property;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class ValueModel
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function getValue()
    {
        return current($this->data);
    }

    public function getValueId()
    {
        return array_key_first($this->data);
    }
}
