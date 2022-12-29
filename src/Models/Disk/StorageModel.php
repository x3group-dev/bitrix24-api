<?php

namespace Bitrix24Api\Models\Disk;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class StorageModel extends AbstractModel implements HasIdInterface
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

    public function getCode(): ?string
    {
        return $this->CODE;
    }

    public function getEntityType(): ?string
    {
        return $this->ENTITY_TYPE;
    }

    public function getEntityId(): ?int
    {
        return $this->ENTITY_ID;
    }

    public function getRootObjectId(): ?int
    {
        return $this->ROOT_OBJECT_ID;
    }
}
