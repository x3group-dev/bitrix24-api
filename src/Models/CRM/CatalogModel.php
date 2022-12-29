<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class CatalogModel extends AbstractModel implements HasIdInterface
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

    public function getOriginatorId(): ?string
    {
        return $this->ORIGINATOR_ID;
    }

    public function getOriginId(): ?string
    {
        return $this->ORIGIN_ID;
    }

    public function getXmlId(): ?string
    {
        return $this->XML_ID;
    }
}
