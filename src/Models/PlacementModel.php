<?php

namespace Bitrix24Api\Models;

class PlacementModel extends AbstractModel
{

    public function toArray(): array
    {
        return $this->data;
    }
}
