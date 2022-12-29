<?php

namespace Bitrix24Api\Models\User;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;
use JetBrains\PhpStorm\Pure;

class UserModel extends AbstractModel implements HasIdInterface
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

    public function getLastName(): ?string
    {
        return $this->LAST_NAME;
    }

    public function getEmail(): ?string
    {
        return $this->EMAIL;
    }

    public function getSecondName(): ?string
    {
        return $this->SECOND_NAME;
    }
}
