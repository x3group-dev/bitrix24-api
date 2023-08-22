<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\Models\AppModel;
use Illuminate\Support\Facades\Log;

class App extends BaseEntity
{
    protected string $method = 'app.%s';
    public const ITEM_CLASS = AppModel::class;

    public function info(): AppModel
    {
        $response = $this->api->request(sprintf($this->getMethod(), 'info'), []);

        $class = static::ITEM_CLASS;
        $data = $response->getResponseData()->getResult()->getResultData();
        return $class::fromArray($data);
    }

}
