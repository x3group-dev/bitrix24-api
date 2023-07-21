<?php

namespace Bitrix24Api\Models\Sonet;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class GroupUserModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getUserId(): int
    {
        return (int)$this->USER_ID;
    }

    public function getRole(): string
    {
        return $this->ROLE;
    }
}
