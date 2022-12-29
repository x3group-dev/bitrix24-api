<?php

namespace Bitrix24Api\Models\CRM;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class ProductPropertyEnumerationModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }
}
