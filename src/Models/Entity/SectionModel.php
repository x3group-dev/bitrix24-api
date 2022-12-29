<?php

namespace Bitrix24Api\Models\Entity;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class SectionModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getName(): ?string
    {
        return $this->NAME;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }
}