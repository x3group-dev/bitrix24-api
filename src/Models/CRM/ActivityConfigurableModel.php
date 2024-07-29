<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;

class ActivityConfigurableModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }
}
