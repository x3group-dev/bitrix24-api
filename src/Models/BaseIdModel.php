<?php

namespace Bitrix24Api\Models;

use Bitrix24Api\Models\Interfaces\HasIdInterface;

class BaseIdModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }
}
