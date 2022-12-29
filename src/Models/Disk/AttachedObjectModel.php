<?php

namespace Bitrix24Api\Models\Disk;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class AttachedObjectModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getObjectId(): int
    {
        return $this->OBJECT_ID;
    }

    public function getEntityId(): int
    {
        return $this->ENTITY_ID;
    }

    public function getCreateTime(): string
    {
        return $this->CREATE_TIME;
    }

    public function getCreatedBy(): ?int
    {
        return $this->CREATED_BY;
    }

    public function getDownloadUrl(): ?string
    {
        return $this->DOWNLOAD_URL;
    }

    public function getName(): ?string
    {
        return $this->NAME;
    }
    public function getSize(): ?int
    {
        return $this->SIZE;
    }

}
