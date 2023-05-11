<?php

namespace Bitrix24Api\EntitiesServices\Task;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Task\Exceptions\TaskActionNotAllowed;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\Task\TaskModel;

class Task extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'tasks.task.%s';
    public const ITEM_CLASS = TaskModel::class;
    protected string $resultKey = 'tasks';
    protected string $listMethod = 'list';

    public function get($id, array $select = []): ?TaskModel
    {
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['taskId' => $id, 'select' => $select]);

            $result = $response->getResponseData()->getResult()->getResultData();
            if (isset($result['task']))
                return new $class($result['task']);
            else
                return null;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function add(array $fields = [])
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), ['fields' => $fields]);
            $result = $response->getResponseData()->getResult()->getResultData();
            $id = $result['task']['id'];
            if ($id > 0) {
                return $id;
            } else {
                return false;
            }
        } catch (ApiException $e) {

        }
        return false;
    }

    public function attach(int $id, int $fileId, array $params = []): ?bool
    {
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'files.attach'), ['taskId' => $id, 'fileId' => $fileId, 'params' => $params]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAccess(int $id, array $users = [])
    {
        if (empty($users))
            return [];
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'getaccess'), ['taskId' => $id, 'users' => $users]);
            $result = $response->getResponseData()->getResult()->getResultData();
            if (isset($result['allowedActions'])) {
                return $result['allowedActions'];
            }
        } catch (ApiException $e) {

        }
    }

    public function update($id, array $fields = [])
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'update'), ['taskId' => $id, 'fields' => $fields]);
            $result = $response->getResponseData()->getResult()->getResultData();
            if (current($result)) {
                return current($result);
            } else {
                return false;
            }
        } catch (ApiException $e) {
            if ($e->getCode() === 400) {
                throw new TaskActionNotAllowed($e->getMessage(), $e->getCode(), $e);
            }
        }
        return false;
    }

    public function getHistoryList(int $taskId, $order = [], array $filter = []): array
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'history.list'), ['taskId' => $taskId, 'filter' => $filter, 'order' => $order]);
            $result = $response->getResponseData()->getResult()->getResultData();
            if (current($result)) {
                return current($result);
            } else {
                return [];
            }
        } catch (ApiException $e) {

        }
        return [];
    }
}
