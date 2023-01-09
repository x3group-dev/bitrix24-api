<?php

namespace Bitrix24Api\Models\Bizproc;

use Bitrix24Api\Models\AbstractModel;

class RobotModel extends AbstractModel
{
    public function toArray(): array
    {
        return $this->data;
    }
}
