<?php

namespace Bitrix24Api\EntitiesServices\Lists;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Exceptions\Entity\AlredyExists;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Lists\ElementModel;

class Element extends BaseEntity
{
    protected string $method = 'lists.element.%s';
    public const ITEM_CLASS = ElementModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    public function get(string $iblockTypeId, int $sonetGroupId = 0, $iblockCodeOrId, $id): ?ElementModel
    {
        $params = [
            'IBLOCK_TYPE_ID' => $iblockTypeId,
            'SOCNET_GROUP_ID' => $sonetGroupId,
            'ELEMENT_ID' => $id,
        ];

        if (is_int($iblockCodeOrId)) {
            $params['IBLOCK_ID'] = $iblockCodeOrId;
        } else {
            $params['IBLOCK_CODE'] = $iblockCodeOrId;
        }

        $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);

        $class = static::ITEM_CLASS;
        $entity = new $class(current($response->getResponseData()->getResult()->getResultData()));
        return !empty($response) ? $entity : null;
    }

    public function add(string $iblockTypeId, $iblockCodeOrId, string $elementCode, string $listElementUrl, array $fields, int $sonetGroupId = 0)
    {
        $params = [
            'IBLOCK_TYPE_ID' => $iblockTypeId,
            'ELEMENT_CODE' => $elementCode,
            'LIST_ELEMENT_URL' => $listElementUrl,
            'FIELDS' => $fields,
            'SOCNET_GROUP_ID' => $sonetGroupId
        ];

        if (is_int($iblockCodeOrId)) {
            $params['IBLOCK_ID'] = $iblockCodeOrId;
        } else {
            $params['IBLOCK_CODE'] = $iblockCodeOrId;
        }

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
            throw new \Exception($e->getMessage());
        }
    }

    public function update(string $iblockTypeId, $iblockCodeOrId, $elementCodeOrId, array $fields, int $sonetGroupId = 0)
    {
        $params = [
            'IBLOCK_TYPE_ID' => $iblockTypeId,
            'FIELDS' => $fields,
            'SOCNET_GROUP_ID' => $sonetGroupId
        ];

        if (is_int($iblockCodeOrId)) {
            $params['IBLOCK_ID'] = $iblockCodeOrId;
        } else {
            $params['IBLOCK_CODE'] = $iblockCodeOrId;
        }

        if (is_int($elementCodeOrId)) {
            $params['ELEMENT_ID'] = $elementCodeOrId;
        } else {
            $params['ELEMENT_CODE'] = $elementCodeOrId;
        }

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'update'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();
            if (current($result)) {
                return current($result);
            } else {
                return false;
            }
        } catch (ApiException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
