<?php

namespace Bitrix24Api\Models\Entity;

use Bitrix24Api\Models\AbstractModel;

class ItemPropertyModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getName(): ?string
    {
        return $this->NAME;
    }

    public function getProperty(): ?string
    {
        return $this->PROPERTY;
    }

    public function getType(): ?string
    {
        return $this->TYPE;
    }
}
