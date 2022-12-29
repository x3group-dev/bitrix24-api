<?php

namespace Bitrix24Api\Models\Sonet;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class GroupUserModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): int
    {
        return (int)$this->ID;
    }
}
