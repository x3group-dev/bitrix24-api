<?php

namespace Bitrix24Api\Models\Traits;

trait ExistsTrait
{
    public function exists(): bool
    {
        return !empty($this->data);
    }
}
