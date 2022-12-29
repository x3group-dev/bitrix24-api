<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class ProductModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getCatalogId(): ?int
    {
        return $this->CATALOG_ID;
    }

    public function getCreateBy(): ?int
    {
        return $this->CREATED_BY;
    }

    public function getCurrencyId(): ?string
    {
        return $this->CURRENCY_ID;
    }

    public function getDescription(): ?string
    {
        return $this->DESCRIPTION;
    }

    public function getDescriptionType(): ?string
    {
        return $this->DESCRIPTION_TYPE;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getMeasure(): ?int
    {
        return $this->MEASURE;
    }

    public function getModifiedBy(): ?int
    {
        return $this->MODIFIED_BY;
    }

    public function getName(): ?string
    {
        return $this->NAME;
    }

    public function getSectionId(): ?int
    {
        return $this->SECTION_ID;
    }

    public function getSort(): ?int
    {
        return $this->SORT;
    }

    public function getVatId(): ?int
    {
        return $this->VAT_ID;
    }

    public function getXmlId(): ?string
    {
        return $this->XML_ID;
    }

}
