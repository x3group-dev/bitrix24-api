<?php

namespace Bitrix24Api\Models\Entity;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class EntityModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getName(): ?int
    {
        return $this->NAME;
    }

    public function getEntity(): ?int
    {
        return $this->ENTITY;
    }
}
