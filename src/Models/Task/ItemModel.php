<?php

namespace Bitrix24Api\Models\Task;

use Bitrix24Api\Models\AbstractModel;

class ItemModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }
}
