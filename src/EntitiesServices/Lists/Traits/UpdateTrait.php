<?php

namespace Bitrix24Api\EntitiesServices\Lists\Traits;

use Bitrix24Api\Exceptions\ApiException;

trait UpdateTrait
{
    public function update(string $iblockTypeId, string $iblockCode, int $sonetGroupId = 0, string $fieldId = null, array $fields = [])
    {
        $params = [
            'IBLOCK_TYPE_ID' => $iblockTypeId,
            'IBLOCK_CODE' => $iblockCode,
            'SOCNET_GROUP_ID' => $sonetGroupId,
            'FIELD_ID' => $fieldId,
            'FIELDS' => $fields,
        ];

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'update'), $params);
            $result = $response->getResponseData()->getResult()->getResultData();
            $id = current($result);
            if (!empty($id)) {
                return $id;
            } else {
                return false;
            }
        } catch (ApiException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
