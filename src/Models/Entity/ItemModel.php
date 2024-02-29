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

    public function getCode(): string
    {
        return (string)$this->CODE;
    }

    public function getSort(): int
    {
        return (int)$this->SORT;
    }

    public function getSectionId(): int
    {
        return (int)$this->SECTION;
    }

    public function getCreatedBy(): int
    {
        return (int)$this->CREATED_BY;
    }

    public function getDateCreate(): \DateTime
    {
        return new \DateTime($this->DATE_CREATE);
    }

    public function getTimeStamp(): \DateTime
    {
        return new \DateTime($this->TIMESTAMP_X);
    }

    public function getDateActiveFrom(): ?\DateTime
    {
        if (!empty($this->DATE_ACTIVE_FROM))
            return new \DateTime($this->DATE_ACTIVE_FROM);
        else
            return null;
    }

    public function getDateActiveTo(): ?\DateTime
    {
        if (!empty($this->DATE_ACTIVE_TO))
            return new \DateTime($this->DATE_ACTIVE_TO);
        else
            return null;
    }

    public function getEntity(): string
    {
        return $this->ENTITY;
    }

    public function getPreviewText(): string
    {
        return (string)$this->PREVIEW_TEXT;
    }

    public function getDetailText(): string
    {
        return (string)$this->DETAIL_TEXT;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    #[Pure] public function getProperty($property): mixed
    {
        return $this->data['PROPERTY_VALUES'][$property] ?? null;
    }
}
