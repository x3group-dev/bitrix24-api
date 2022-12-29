<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class ActivityModel extends AbstractModel implements HasIdInterface
{
    public function getAssociatedEntityId(): ?int
    {
        return $this->ASSOCIATED_ENTITY_ID;
    }

    public function getAutocompleteRule(): ?int
    {
        return $this->AUTOCOMPLETE_RULE;
    }

    public function getDescription(): ?string
    {
        return $this->DESCRIPTION;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getLocation(): ?string
    {
        return $this->LOCATION;
    }

    public function getTitle(): ?string
    {
        return $this->TITLE;
    }

    public function getNotifyValue(): ?int
    {
        return $this->NOTIFY_VALUE;
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

    public function getOwnerId(): ?int
    {
        return $this->OWNER_ID;
    }

    public function getProviderData(): ?string
    {
        return $this->PROVIDER_DATA;
    }

    public function getProviderGroupId(): ?string
    {
        return $this->PROVIDER_GROUP_ID;
    }

    public function getProviderId(): ?string
    {
        return $this->PROVIDER_ID;
    }

    public function getProviderTypeId(): ?string
    {
        return $this->PROVIDER_TYPE_ID;
    }

    public function getResultCurrencyId(): ?string
    {
        return $this->RESULT_CURRENCY_ID;
    }

    public function getResultMask(): ?int
    {
        return $this->RESULT_MARK;
    }

    public function getResultSourceId(): ?string
    {
        return $this->RESULT_SOURCE_ID;
    }

    public function getResultStatus(): ?int
    {
        return $this->RESULT_STATUS;
    }

    public function getResultStream(): ?int
    {
        return $this->RESULT_STREAM;
    }

    public function getSubject(): ?string
    {
        return $this->SUBJECT;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
