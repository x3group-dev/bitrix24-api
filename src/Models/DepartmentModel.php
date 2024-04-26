<?php

namespace Bitrix24Api\Models;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;
use JetBrains\PhpStorm\Pure;

class DepartmentModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getName(): ?string
    {
        return $this->NAME;
    }

    public function getParent(): ?string
    {
        return $this->PARENT;
    }

    public function getSort(): ?string
    {
        return $this->SORT;
    }

    public function getHead(): ?string
    {
        return $this->UF_HEAD;
    }
}
