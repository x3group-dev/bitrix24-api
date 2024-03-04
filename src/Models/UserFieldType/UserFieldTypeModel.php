<?php

namespace Bitrix24Api\Models\UserFieldType;

use Bitrix24Api\Models\AbstractModel;

class UserFieldTypeModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }
}
