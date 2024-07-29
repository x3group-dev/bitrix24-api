<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Models\CRM\ActivityConfigurableModel;

class ActivityConfigurable extends BaseEntity
{
    protected string $method = 'crm.activity.configurable.%s';
    public const ITEM_CLASS = ActivityConfigurableModel::class;
    protected string $resultKey = '';
    protected string $listMethod = '';

    public function add(array $params): ?int
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();

            if (isset($result['activity']['id']) && $result['activity']['id'] > 0) {
                return $result['activity']['id'];
            } else {
                return null;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
