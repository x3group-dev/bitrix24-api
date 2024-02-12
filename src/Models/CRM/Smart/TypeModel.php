<?php

namespace Bitrix24Api\Models\CRM\Smart;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class TypeModel extends AbstractModel implements HasIdInterface
{

    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
