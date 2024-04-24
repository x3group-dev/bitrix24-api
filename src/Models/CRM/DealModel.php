<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class DealModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getContactId(): ?int
    {
        return (int) $this->CONTACT_ID;
    }

    public function getCompanyId(): ?int
    {
        return (int) $this->COMPANY_ID;
    }
}
