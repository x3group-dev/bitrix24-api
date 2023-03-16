<?php

namespace Bitrix24Api\EntitiesServices\Entity;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\Entity\SectionModel;

class Section extends BaseEntity
{
    use GetListTrait, GetListFastTrait;
    protected string $method = 'entity.section.%s';
    public const ITEM_CLASS = SectionModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    public function add($params = [])
    {
        if (!empty($this->baseParams))
            $params = array_merge($params, $this->baseParams);

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();
            $id = current($result);
            if ($id > 0) {
                return $id;
            } else {
                return false;
            }
        } catch (ApiException $e) {

        }
        return false;
    }
}
