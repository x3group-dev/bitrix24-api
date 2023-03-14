<?php

namespace Bitrix24Api\EntitiesServices\Task;

use Bitrix24Api\ApiClient;
use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Exceptions\InvalidArgumentException;
use Bitrix24Api\Models\Task\CommentItemModel;

class CommentItem extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'task.commentitem.%s';
    public const ITEM_CLASS = CommentItemModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'getlist';

    public function __construct(ApiClient $api, $params = [])
    {
        parent::__construct($api, $params);
    }

    public function get($taskId, $id): ?CommentItemModel
    {
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), [$taskId, $id]);

            $result = $response->getResponseData()->getResult()->getResultData();
            if (isset($result['ID']))
                return new $class($result);
            else
                return null;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function add($taskId, array $fields = [])
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), [$taskId, $fields]);
            $id = $response->getResponseData()->getResult()->getResultData();
            $id = array_pop($id);
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
