<?php

namespace Bitrix24Api\Models\Bizproc;

use Bitrix24Api\Models\AbstractModel;

class EventModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }
}
