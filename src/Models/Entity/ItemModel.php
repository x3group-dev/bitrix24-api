<?php

namespace Bitrix24Api\Models\Entity;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;
use JetBrains\PhpStorm\Pure;

class ItemModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getName(): ?string
    {
        return $this->NAME;
    }

    public function getCreatedBy(): int
    {
        return (int)$this->CREATED_BY;
    }

    public function getDateCreate(): \DateTime
    {
        return new \DateTime($this->DATE_CREATE);
    }


    public function getDetailText(): ?string
    {
        return $this->DETAIL_TEXT;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    #[Pure] public function getProperty($property): mixed
    {
        return isset($this->data['PROPERTY_VALUES']) ? $this->data['PROPERTY_VALUES'][$property] : null;
    }
}
