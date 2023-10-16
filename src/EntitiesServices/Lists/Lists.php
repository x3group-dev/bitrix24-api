<?php

namespace Bitrix24Api\EntitiesServices\Lists;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\EntitiesServices\Traits\GetWithoutParamsTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Exceptions\Entity\AlredyExists;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Lists\ListModel;

class Lists extends BaseEntity
{
    use GetWithoutParamsTrait, GetListTrait;

    protected string $method = 'lists.%s';
    public const ITEM_CLASS = ListModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    /**
     * Метод возвращает данные одного инфоблока
     * @throws \Exception
     */
    public function get(string $iblockTypeId, $iblockCodeOrId, int $sonetGroupId = 0): ?AbstractModel
    {
        $params = [
            'IBLOCK_TYPE_ID' => $iblockTypeId,
            'SOCNET_GROUP_ID' => $sonetGroupId,
        ];

        if (is_int($iblockCodeOrId)) {
            $params['IBLOCK_ID'] = $iblockCodeOrId;
        } else {
            $params['IBLOCK_CODE'] = $iblockCodeOrId;
        }

        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);
            return new $class(!empty($response->getResponseData()->getResult()->getResultData()) ? current($response->getResponseData()->getResult()->getResultData()) : []);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function add(string $iblockTypeId, string $iblockCode, int $sonetGroupId = 0, array $fields, $messages = [], array $rights = [])
    {
        $params = [
            'IBLOCK_TYPE_ID' => $iblockTypeId,
            'IBLOCK_CODE' => $iblockCode,
            'SOCNET_GROUP_ID' => $sonetGroupId,
            'FIELDS' => $fields,
            'MESSAGES' => $messages,
            'RIGHTS' => $rights
        ];

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
            if ($e->getTitle() === 'ERROR_ENTITY_ALREADY_EXISTS') {
                throw new AlredyExists($e->getTitle(), 0, $e->getDescription());
            } else {
                throw new \Exception($e->getMessage());
            }
        }
    }
}