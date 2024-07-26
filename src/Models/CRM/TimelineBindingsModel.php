<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;

class TimelineBindingsModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }
}
