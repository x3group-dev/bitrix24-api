<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class CompanyModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getTitle(): ?string
    {
        return $this->TITLE;
    }

    public function hasPhone(): bool
    {
        return $this->HAS_PHONE === 'Y';
    }

    public function getFirstPhone(): ?string
    {
        if ($this->hasPhone()) {
            return current($this->PHONE)['VALUE'];
        }

        return null;
    }
}
