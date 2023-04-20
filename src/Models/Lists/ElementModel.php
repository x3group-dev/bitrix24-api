<?php

namespace Bitrix24Api\Models\Lists;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;
use JetBrains\PhpStorm\Pure;

class ElementModel extends AbstractModel implements HasIdInterface
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

    public function getIblockId(): ?string
    {
        return $this->IBLOCK_ID;
    }

    public function getIblockSectionId(): ?string
    {
        return $this->IBLOCK_SECTION_ID;
    }

    public function getCreatedBy(): ?string
    {
        return $this->CREATED_BY;
    }

    public function getCode(): ?string
    {
        return $this->CODE;
    }

    public function getBpPublished(): ?string
    {
        return $this->BP_PUBLISHED;
    }

    public function getDateCreate(): ?string
    {
        return $this->DATE_CREATE;
    }

    public function getActiveFrom(): ?string
    {
        return $this->ACTIVE_FROM;
    }

    public function getActiveTo(): ?string
    {
        return $this->ACTIVE_TO;
    }

    public function getTimestamp(): ?string
    {
        return $this->TIMESTAMP_X;
    }

    public function getModifiedBy(): ?int
    {
        return $this->MODIFIED_BY;
    }

    public function getCreatedUserName(): ?string
    {
        return $this->CREATED_USER_NAME;
    }

    public function getUserName(): ?string
    {
        return $this->USER_NAME;
    }

    public function __get($offset)
    {
        if (strpos('PROPERTY_', $offset) && isset($this->data[$offset]) && count($this->data[$offset]) == 1)
            return $this->getProperty($offset);

        return $this->data[$offset] ?? null;
    }

    #[Pure] public function getProperty($offset): ?\Bitrix24Api\Models\Lists\Element\Property\ValueModel
    {
        return isset($this->data[$offset]) ? new \Bitrix24Api\Models\Lists\Element\Property\ValueModel($this->data[$offset]) : null;
    }
}
