<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class DealContactItemsModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        return $this->CONTACT_ID;
    }
}
