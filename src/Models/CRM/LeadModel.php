<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class LeadModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getAddress(): ?string
    {
        return $this->ADDRESS;
    }

    public function getAddress2(): ?string
    {
        return $this->ADDRESS_2;
    }

    public function getAddressCity(): ?string
    {
        return $this->ADDRESS_CITY;
    }

    public function getAddressCountry(): ?string
    {
        return $this->ADDRESS_COUNTRY;
    }

    public function getAddressCountryCode(): ?string
    {
        return $this->ADDRESS_COUNTRY_CODE;
    }

    public function getAddressPostalCode(): ?string
    {
        return $this->ADDRESS_POSTAL_CODE;
    }

    public function getAddressProvince(): ?string
    {
        return $this->ADDRESS_PROVINCE;
    }

    public function getAddressRegion(): ?string
    {
        return $this->ADDRESS_REGION;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getLastName(): ?string
    {
        return $this->LAST_NAME;
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

    public function getOriginVersion(): ?string
    {
        return $this->ORIGIN_VERSION;
    }

    public function getPost(): ?string
    {
        return $this->POST;
    }

    public function getSecondName(): ?string
    {
        return $this->SECOND_NAME;
    }

    public function getSourceDescription(): ?string
    {
        return $this->SOURCE_DESCRIPTION;
    }

    public function getSourceId(): ?string
    {
        return $this->SOURCE_ID;
    }

    public function getStatusDescription(): ?string
    {
        return $this->STATUS_DESCRIPTION;
    }

    public function getStatusId(): ?string
    {
        return $this->STATUS_ID;
    }

    public function getStatusSemanticId(): ?string
    {
        return $this->STATUS_SEMANTIC_ID;
    }

    public function getTitle(): ?string
    {
        return $this->TITLE;
    }

    public function getUtmCampaign(): ?string
    {
        return $this->UTM_CAMPAIGN;
    }

    public function getUtmContent(): ?string
    {
        return $this->UTM_CONTENT;
    }

    public function getUtmMedium(): ?string
    {
        return $this->UTM_MEDIUM;
    }

    public function getUtmSource(): ?string
    {
        return $this->UTM_SOURCE;
    }

    public function getUtmTerm(): ?string
    {
        return $this->UTM_TERM;
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
