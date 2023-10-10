<?php

namespace Bitrix24Api\Models;

class BaseModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }
}
